<?php

namespace App\Http\Controllers;

use Intervention\Image\Facades\Image;
use App\Models\Photo;
use App\Models\Property;
use App\Models\ShareList;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Exception;

class ShareListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function preShareList()
    {
        $shareListImgs = ShareList::Where('type', 'Image')
            ->where('created_by', auth()->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();
        foreach ($shareListImgs as $share) {
            $share->photos = $share->getPhotos();
        }
        return view('share-list', compact('shareListImgs'));
    }

    public function ImagesShared(Request $request)
    {
        $userId = Auth()->user()->id;
        $user = User::find($userId);

        $sLink = Str::random(14);

        $imagesArr = json_decode($user->images_share_list, true);

        $imageOptions = [];

        foreach ($imagesArr as $key => $imgId) {
            if (is_numeric($imgId)) {
                $imagesArr[$key] = [
                    'square_' => $imgId,
                    'original_' => $imgId
                ];
            }
            if (isset($imagesArr[$key]) && !is_array($imagesArr[$key])) {
                $imagesArr[$key] = [
                    'square_' => $imgId,
                    'original_' => $imgId
                ];
            }
        }

        $newImagesArr = [];  

        foreach ($imagesArr as $key => $imgData) {
            // Extract square_ and original_
            $squareImageId = $imgData['square_'];
            $originalSizeImageId = $imgData['original_'];

            $image = Photo::where('id', $originalSizeImageId)->whereNull('deleted_at')->first();
            if ($image) {
                $file = $image->image;
                $filename = basename($file);
                $filename = str_replace('.', '_', $filename);  // Replace dots with underscores

                if ($file) {
                    $imageOptions[$originalSizeImageId] = [
                        'room'        => (int) $request->input("room_$filename", 0),
                        'size'        => (int) $request->input("size_$filename", 0),
                        'price'       => (int) $request->input("price_$filename", 0),
                        'label_room'  => (int) $request->input("label_room_$filename", 0),
                        'label_size'  => (int) $request->input("label_size_$filename", 0),
                        'label_price' => (int) $request->input("label_price_$filename", 0),
                        'border'      => (int) $request->input("border_$filename", 0),
                        'label'       => $request->input("label_$filename", ''),
                        'note'        => $request->input("note_$filename", ''),
                    ];
                }

                // Gather image options (room, size, price, etc.)
                $room = (int) $request->input("room_$filename", 0);
                $size = (int) $request->input("size_$filename", 0);
                $price = (int) $request->input("price_$filename", 0);
                $labelRoom = (int) $request->input("label_room_$filename", 0);
                $labelSize = (int) $request->input("label_size_$filename", 0);
                $labelPrice = (int) $request->input("label_price_$filename", 0);
                $border = (int) $request->input("border_$filename", 0);
                $label = $request->input("label_$filename", '');
                $note = $request->input("note_$filename", '');

                if ($room || $size || $price || $labelRoom || $labelSize || $labelPrice || $border || $label || $note) {
                    
                    $originalPath = public_path($image->image);
                    if (!file_exists($originalPath)) {
                        continue;
                    }

                    $originalImage = Image::make($originalPath);
                    $originalImageName = pathinfo($originalPath, PATHINFO_FILENAME);
                    $originalImageExtension = pathinfo($originalPath, PATHINFO_EXTENSION);

                    $folderPath = "shareImgs/$sLink/$originalSizeImageId";
                    $squarePath = "$folderPath/square_{$originalImageName}.{$originalImageExtension}";
                    $originalSizePath = "$folderPath/original_{$originalImageName}.{$originalImageExtension}";

                    $absoluteFolderPath = public_path($folderPath);
                    if (!is_dir($absoluteFolderPath)) {
                        mkdir($absoluteFolderPath, 0755, true);
                    }

                    $squareImage = $originalImage->resize(350, 350);
                    $originalSizeImage = $originalImage;

                    if ($border === 1) {
                        $borderThickness = 10;
                        $borderColor = '#ff9900';

                        $squareImage = Image::canvas($squareImage->width() + 2 * $borderThickness, $squareImage->height() + 2 * $borderThickness, $borderColor);
                        $squareImage->insert($originalImage->resize(350, 350), 'center');

                        $originalSizeImage = Image::canvas($originalSizeImage->width() + 2 * $borderThickness, $originalSizeImage->height() + 2 * $borderThickness, $borderColor);
                        $originalSizeImage->insert($originalImage, 'center');
                    }


                    if (!empty($label)) {
                        $labelText = $label;
                        $backgroundColor = '#ff9900';
                        $textColor = '#ffffff';
                        $fontSize = 22;
                        $fontPath = public_path('fonts/arial-bold.ttf');
                        $polygonHeight = 35;
                        $padding = 20;
                    
                        // Ensure the font file exists
                        if (!file_exists($fontPath)) {
                            throw new Exception("Font file not found: {$fontPath}");
                        }
                    
                        // Calculate the width of the text
                        $textBox = imagettfbbox($fontSize, 0, $fontPath, $labelText);
                        $textWidth = abs($textBox[4] - $textBox[0]) + $padding; // Add padding to the text width
                    
                        // Calculate the top position of the polygon at 20% from the bottom
                        $polygonTopY = $originalSizeImage->height() * 0.8 - $polygonHeight;
                    
                        // Calculate the starting X position from the right
                        $polygonStartX = $originalSizeImage->width() - $textWidth;
                    
                        // Define polygon points for the original image
                        $originalPolygonPoints = [
                            $polygonStartX, $polygonTopY, // Top-left
                            $originalSizeImage->width(), $polygonTopY, // Top-right
                            $originalSizeImage->width(), $polygonTopY + $polygonHeight, // Bottom-right
                            $polygonStartX - ($textWidth * 0.2), $polygonTopY + $polygonHeight // Bottom-left
                        ];
                    
                        // Draw the polygon on the original image
                        $originalSizeImage->polygon($originalPolygonPoints, function ($draw) use ($backgroundColor) {
                            $draw->background($backgroundColor);
                        });
                    
                        // Add text to the original image (centered inside the polygon)
                        $originalSizeImage->text(
                            $labelText,
                            $polygonStartX + ($textWidth / 2), // Centered horizontally within the polygon
                            $polygonTopY + ($polygonHeight / 2), // Centered vertically within the polygon
                            function ($font) use ($textColor, $fontSize, $fontPath) {
                                $font->file($fontPath);
                                $font->size($fontSize);
                                $font->color($textColor);
                                $font->align('center');
                                $font->valign('middle');
                            }
                        );
                    
                        // Repeat similar steps for the square image
                        $polygonStartX = $squareImage->width() - $textWidth;
                    
                        $squarePolygonPoints = [
                            $polygonStartX, $polygonTopY, // Top-left
                            $squareImage->width(), $polygonTopY, // Top-right
                            $squareImage->width(), $polygonTopY + $polygonHeight, // Bottom-right
                            $polygonStartX - ($textWidth * 0.2), $polygonTopY + $polygonHeight // Bottom-left
                        ];
                    
                        // Draw the polygon on the square image
                        $squareImage->polygon($squarePolygonPoints, function ($draw) use ($backgroundColor) {
                            $draw->background($backgroundColor);
                        });
                    
                        // Add text to the square image
                        $squareImage->text(
                            $labelText,
                            $polygonStartX + ($textWidth / 2), // Centered horizontally within the polygon
                            $polygonTopY + ($polygonHeight / 2), // Centered vertically within the polygon
                            function ($font) use ($textColor, $fontSize, $fontPath) {
                                $font->file($fontPath);
                                $font->size($fontSize);
                                $font->color($textColor);
                                $font->align('center');
                                $font->valign('middle');
                            }
                        );
                    }
                    
                    
                    // if ($labelRoom == 1 || $labelSize == 1 || $labelPrice == 1) {
                    //     $topCenterText = [];
                    
                    //     if ($labelRoom == 1) {
                    //         $topCenterText[] = "單位 " . $image->room_number;
                    //     }
                    //     if ($labelSize == 1) {
                    //         $topCenterText[] = "呎吋 " . $image->size;
                    //     }
                    //     if ($labelPrice == 1) {
                    //         $topCenterText[] = "價錢 " . $image->price;
                    //     }
                    
                    //     if (!empty($topCenterText)) {
                    //         $text = implode(" ", $topCenterText);
                    //         $backgroundColor = '#ff9900';
                    //         $textColor = '#ffffff';
                    //         $fontSize = 14;
                    //         $fontPath = public_path('fonts/NotoSansTC-Light.otf');
                    //         $polygonHeight = 30;
                    //         $padding = 20;
                    //         $polygonTopY = ($border === 1) ? 10 : 0; 
                    
                    //         // Ensure the font file exists
                    //         if (!file_exists($fontPath)) {
                    //             throw new Exception("Font file not found: {$fontPath}");
                    //         }
                    
                    //         $addTopPolygon = function ($image) use ($text, $backgroundColor, $textColor, $fontSize, $fontPath, $polygonHeight, $padding, $polygonTopY) {
                    //             $textBox = imagettfbbox($fontSize, 0, $fontPath, $text);
                    //             $textWidth = abs($textBox[4] - $textBox[0]) + $padding;
                    
                    //             $polygonLeftX = ($image->width() - $textWidth) / 2;
                    
                    //             $topPolygonPoints = [
                    //                 $polygonLeftX, $polygonTopY, // Top-left
                    //                 $polygonLeftX + ($textWidth * 0.1), $polygonTopY + $polygonHeight, // 10% Bottom-left
                    //                 $polygonLeftX + ($textWidth * 0.9), $polygonTopY + $polygonHeight, // 90% Bottom-right
                    //                 $polygonLeftX + $textWidth, $polygonTopY // Top-right
                    //             ];
                    
                    //             // Draw the polygon
                    //             $image->polygon($topPolygonPoints, function ($draw) use ($backgroundColor) {
                    //                 $draw->background($backgroundColor);
                    //             });
                    
                    //             // Add text to the polygon
                    //             $image->text(
                    //                 $text,
                    //                 $polygonLeftX + ($textWidth / 2), // Center text horizontally
                    //                 $polygonTopY + ($polygonHeight / 2), // Center text vertically
                    //                 function ($font) use ($textColor, $fontSize, $fontPath) {
                    //                     $font->file($fontPath);
                    //                     $font->size($fontSize);
                    //                     $font->color($textColor);
                    //                     $font->align('center');
                    //                     $font->valign('middle');
                    //                 }
                    //             );
                    //         };
                    
                    //         $addTopPolygon($originalSizeImage);
                    //         $addTopPolygon($squareImage);
                    //     }
                    // }
                    if ($labelRoom == 1 || $labelSize == 1 || $labelPrice == 1) {
                        $topCenterText = [];
                    
                        // Prepare the label text in light style and value text in bold style
                        if ($labelRoom == 1) {
                            $topCenterText[] = "單位 " . $image->room_number;  // Room number (Value will be bold)
                        }
                        if ($labelSize == 1) {
                            $topCenterText[] = "呎吋 " . $image->size;  // Size (Value will be bold)
                        }
                        if ($labelPrice == 1) {
                            $topCenterText[] = "價錢 " . $image->price;  // Price (Value will be bold)
                        }
                    
                        if (!empty($topCenterText)) {
                            $text = implode(" ", $topCenterText);
                            $backgroundColor = '#ff9900';
                            $textColor = '#ffffff';
                            $fontSize = 14;
                            $fontPathLight = public_path('fonts/NotoSansTC-Light.otf'); // Light font for Chinese text
                            $fontPathBold = public_path('fonts/NotoSansTC-Bold.otf');   // Bold font for values
                            $polygonHeight = 30;
                            $padding = 20;
                            $polygonTopY = ($border === 1) ? 10 : 0;
                    
                            // Ensure the font files exist
                            if (!file_exists($fontPathLight)) {
                                throw new Exception("Font file not found: {$fontPathLight}");
                            }
                            if (!file_exists($fontPathBold)) {
                                throw new Exception("Font file not found: {$fontPathBold}");
                            }
                    
                            $addTopPolygon = function ($image) use ($text, $backgroundColor, $textColor, $fontSize, $fontPathLight, $fontPathBold, $polygonHeight, $padding, $polygonTopY) {
                                // Calculate the bounding box for the full text (light font, labels)
                                $textBox = imagettfbbox($fontSize, 0, $fontPathLight, strip_tags($text));
                                $textWidth = abs($textBox[4] - $textBox[0]) + $padding;
                    
                                $polygonLeftX = ($image->width() - $textWidth) / 2;
                    
                                $topPolygonPoints = [
                                    $polygonLeftX, $polygonTopY, // Top-left
                                    $polygonLeftX + ($textWidth * 0.1), $polygonTopY + $polygonHeight, // 10% Bottom-left
                                    $polygonLeftX + ($textWidth * 0.9), $polygonTopY + $polygonHeight, // 90% Bottom-right
                                    $polygonLeftX + $textWidth, $polygonTopY // Top-right
                                ];
                    
                                // Draw the polygon
                                $image->polygon($topPolygonPoints, function ($draw) use ($backgroundColor) {
                                    $draw->background($backgroundColor);
                                });
                    
                                // Add light Chinese labels (NotoSansTC-Light.otf) to the polygon
                                $image->text(
                                    strip_tags($text), // Text without HTML tags
                                    $polygonLeftX + ($textWidth / 2), // Center text horizontally
                                    $polygonTopY + ($polygonHeight / 2), // Center text vertically
                                    function ($font) use ($textColor, $fontSize, $fontPathLight) {
                                        $font->file($fontPathLight);
                                        $font->size($fontSize);
                                        $font->color($textColor);
                                        $font->align('center');
                                        $font->valign('middle');
                                    }
                                );
                    
                                // Add bold values (e.g., room number, size, price) using NotoSansTC-Bold.otf
                                $boldText = preg_replace_callback('/(\d+|\S+|\d{1,3}(?:,\d{3})*)/', function ($matches) use ($fontPathBold, $textColor, $fontSize) {
                                    return $matches[0];  // Just match the numeric values for bold
                                }, $text);
                    
                                // Add bold text to the polygon
                                $image->text(
                                    strip_tags($boldText), // Only the bold part of the text
                                    $polygonLeftX + ($textWidth / 2), // Center text horizontally
                                    $polygonTopY + ($polygonHeight / 2), // Center text vertically
                                    function ($font) use ($textColor, $fontSize, $fontPathBold) {
                                        $font->file($fontPathBold);
                                        $font->size($fontSize);
                                        $font->color($textColor);
                                        $font->align('center');
                                        $font->valign('middle');
                                    }
                                );
                            };
                    
                            // Add the top polygon to both the original and square images
                            $addTopPolygon($originalSizeImage);
                            $addTopPolygon($squareImage);
                        }
                    }

                    $squareImage->save(public_path($squarePath));
                    $originalSizeImage->save(public_path($originalSizePath));

                    $squarePhoto = Photo::create(['image' => $squarePath]);
                    $originalSizePhoto = Photo::create(['image' => $originalSizePath]);

                    $newImagesArr[$squareImageId] = [
                        'square_' => $squarePhoto->id,
                        'original_' => $originalSizePhoto->id,
                    ];
                } else {
                    $newImagesArr[$squareImageId] = [
                        'square_' => $squareImageId,
                        'original_' => $originalSizeImageId,
                    ];
                }
            }
        }

        // Handle property options (building info, map, etc.)
        $property_options = [];
        if ($request->input('show_building_info') == "on") {
            $property_options = $request->building_info;
        }
        if ($request->input('show_building_name') == "1") {
            $property_options[] = 'show_building_name';
        }
        if ($request->input('show_map') == "1") {
            $property_options[] = 'show_map';
        }
        if ($request->input('show_as_list') == "1") {
            $property_options[] = 'show_as_list';
        }

        // Handle individual comments for properties
        $codesArr = explode(',', $request->input('codesArr'));
        $individual_comments = [];
        foreach ($codesArr as $code) {
            $commentKey = 'individual_comment_' . str_replace(' ', '_', $code);
            $individual_comments[$code] = $request->input($commentKey) ?? null;
        }

        // Create the ShareList record
        $shareList = new ShareList;
        $shareList->share_data = json_encode($newImagesArr);
        $shareList->link = $sLink;
        $shareList->type = 'Image';
        $shareList->comment = $request->comment;
        $shareList->property_options = json_encode($property_options);
        $shareList->image_options = json_encode($imageOptions);
        $shareList->images_property_comments = json_encode($individual_comments);
        $shareList->created_by = $userId;
        $shareList->save();

        // Generate WhatsApp link with the shared list URL

        // if ($request->get('action_type') === 'submit1')
        // {
        //     return redirect()->route('pdf.page', ['link' => $sLink]);
        // }
    
        // // If "Share" button is clicked
        // if ($request->has('submit'))
        // {
        //     $whatsappLink = "whatsapp://send?text=" . urlencode(url('/spms/sharedImgs/' . $sLink));
        //     return redirect()->away($whatsappLink);
        // }

        if ($request->ajax()) {
            if ($request->get('action_type') === 'submit1') {
                // Return the route for generating the PDF
                return response()->json(['route' => route('pdf.page', ['link' => $sLink])]);
            }
    
            if ($request->get('action_type') === 'submit') {
                // Return the WhatsApp link
                $whatsappLink = "whatsapp://send?text=" . urlencode(url('/spms/sharedImgs/' . $sLink));
                return response()->json(['route' => $whatsappLink]);
            }
        }
    
        return back();
    }

    public function pdfPage($link)
    {
        $shareList = ShareList::where('link', $link)->first();
        if($shareList->type == 'Property'){
            return redirect()->back()->with('error', 'The shared link is not valid for this operation.');
        }
        $typeUrl = $shareList->type;
        $imgsId = json_decode($shareList->share_data, true);
        // dd($imgsId);
        $imgKeys = array_keys($imgsId);
        $comment = $shareList->comment;
        $individualComments = $shareList->images_property_comments;
        $propertyOptions = $shareList->property_options;
        $imgsOptions = $shareList->image_options;
        $propertyCode = Photo::whereIn('id', $imgKeys)->distinct()->pluck('code');
        
        $properties = Property::whereIn('code', $propertyCode)
        ->with(['photos' => function ($query) use ($imgKeys) {
            // Fetch only the required photo IDs
            $query->whereIn('id', $imgKeys);
        }])
        ->get()
        ->map(function ($property) use ($imgsId, $link) {
            $property->photos = $property->photos->map(function ($photo) use ($imgsId, $link) {
                $photoId = $photo->id;
                
                // Check if the photo ID exists in the imgsId array
                if (isset($imgsId[$photoId])) {
                    // Get the square and original image IDs from the imgsId array
                    $squareImageId = $imgsId[$photoId]['square_'];
                    $originalImageId = $imgsId[$photoId]['original_'];
                    
                    // Compare the photo's ID with the corresponding image IDs
                    if ($photo->id == $squareImageId || $photo->id == $originalImageId) {
                        $photo->square_image = asset($photo->image);
                        $photo->original_image = asset($photo->image);
                    } else {
                        $squareImg = Photo::where('id', $squareImageId)->first();
                        $originalImage = Photo::where('id', $originalImageId)->first();
                        $photo->square_image = asset($squareImg->image);
                        $photo->original_image = asset($originalImage->image);
                    }
                }

                return $photo;
            });

            return $property;
        });

        return view('shared_pages.s-print', compact('properties','comment', 'individualComments', 'propertyOptions', 'imgsOptions', 'typeUrl'));
    }

    public function ImageSharePage($link)
    {
        $shareList = ShareList::where('link', $link)->first();
        if($shareList->type == 'Property'){
            return redirect()->back()->with('error', 'The shared link is not valid for this operation.');
        }
        $typeUrl = $shareList->type;
        $imgsId = json_decode($shareList->share_data, true);
        // dd($imgsId);
        $imgKeys = array_keys($imgsId);
        $comment = $shareList->comment;
        $individualComments = $shareList->images_property_comments;
        $propertyOptions = $shareList->property_options;
        $imgsOptions = $shareList->image_options;
        $propertyCode = Photo::whereIn('id', $imgKeys)->distinct()->pluck('code');

        // only sahred images array ids  imgs show
        // $properties = Property::whereIn('code', $propertyCode)
        //     ->with(['photos' => function ($query) use ($imgsId) {
        //         $query->whereIn('id', $imgsId);
        //     }])
        //     ->get();
        $properties = Property::whereIn('code', $propertyCode)
        ->with(['photos' => function ($query) use ($imgKeys) {
            // Fetch only the required photo IDs
            $query->whereIn('id', $imgKeys);
        }])
        ->get()
        ->map(function ($property) use ($imgsId, $link) {
            $property->photos = $property->photos->map(function ($photo) use ($imgsId, $link) {
                $photoId = $photo->id;
                
                // Check if the photo ID exists in the imgsId array
                if (isset($imgsId[$photoId])) {
                    // Get the square and original image IDs from the imgsId array
                    $squareImageId = $imgsId[$photoId]['square_'];
                    $originalImageId = $imgsId[$photoId]['original_'];
                    
                    // Compare the photo's ID with the corresponding image IDs
                    if ($photo->id == $squareImageId || $photo->id == $originalImageId) {
                        $photo->square_image = asset($photo->image);
                        $photo->original_image = asset($photo->image);
                    } else {
                        $squareImg = Photo::where('id', $squareImageId)->first();
                        $originalImage = Photo::where('id', $originalImageId)->first();
                        $photo->square_image = asset($squareImg->image);
                        $photo->original_image = asset($originalImage->image);
                    }
                }

                return $photo;
            });

            return $property;
        });


        // dd($properties);
        return view('shared_pages.shared-images', compact('properties','comment', 'individualComments', 'propertyOptions', 'imgsOptions', 'typeUrl'));
    }

    public function PreImagesShared(Request $request)
    {   
        $sLink = Str::random(14);
        $old_share = ShareList::where('id', $request->hash)->first();
        if (!$old_share) {
            return back()->with('error', 'Original share not found.');
        }
        $share_data = $old_share->share_data;
        $image_options = $old_share->image_options;

        if ($request->action === 'url') {
            $type = 'URL Open';
        } elseif ($request->action === 'share') {
            $type = 'Copy Images';
        }

        $newShare = new ShareList;
        $newShare->type = $type;
        $newShare->comment = $request->comment;
        $newShare->link = $sLink;
        $newShare->image_options = $image_options;
        $newShare->share_data = $share_data;
        $newShare->created_by = auth()->user()->id;
        $newShare->save();

        // Determine action
        if ($request->action === 'url') {
            return redirect()->route('Images.share.page', $sLink);
        } elseif ($request->action === 'share') {
            $whatsappLink = "whatsapp://send?text=" . urlencode(url('/spms/sharedImgs/' . $sLink));
            return redirect()->away($whatsappLink);
        }

        return back()->with('error', 'Invalid action.');
    }

    public function mergeShareData(Request $request)
    {
        $ids = $request->input('list', []);
        $comment = $request->input('comment', '');

        // Validate the input
        if (empty($ids) || !is_array($ids)) {
            return response()->json(['error' => 'Invalid input'], 422);
        }

        // Get the shares, ordered by ID in ascending order (oldest first)
        $shares = ShareList::whereIn('id', $ids)->orderBy('id', 'asc')->get(['share_data', 'image_options']);

        $mergedData = [];
        $mergedImageOptions = [];

        foreach ($shares as $index => $share) {
            $shareData = json_decode($share->share_data, true) ?? [];
            $imageOptions = json_decode($share->image_options, true) ?? [];

            if (json_last_error() !== JSON_ERROR_NONE) {
                return response()->json(['error' => 'Invalid JSON data in share_data or image_options'], 422);
            }

            // Always use image_options from the latest (oldest in query) record
            if ($index === count($shares) - 1) {
                $mergedImageOptions = $imageOptions;  // Take the image options from the last record
            }

            // Merge the share_data, ensuring we only take the latest record's value for each key
            foreach ($shareData as $key => $value) {
                // If the key exists in mergedData, we overwrite it with the latest value
                // If it doesn't exist, we add it to mergedData
                $mergedData[$key] = $value;
            }
        }

        // Save the merged data
        $sLink = Str::random(14);
        $newShare = new ShareList;
        $newShare->link = $sLink;
        $newShare->type = 'Merged Images Data';
        $newShare->share_data = json_encode($mergedData);  // Encode array to JSON
        $newShare->image_options = json_encode($mergedImageOptions);  // Encode array to JSON
        $newShare->comment = $comment;
        $newShare->created_by = auth()->user()->id;
        $newShare->save();

        // Generate WhatsApp link and return response
        $whatsappLink = "whatsapp://send?text=" . urlencode(url('/spms/sharedImgs/' . $sLink));

        return response()->json([
            'message' => 'Data merged successfully!',
            'whatsappLink' => $whatsappLink
        ]);
    }

    public function PropertiesShared(Request $request)
    {
        // dd($request->all());
        $userId = Auth()->user()->id;
        $user = User::where('id', $userId)->first();

        $sLink = Str::random(29);
        $propertiesArr = json_decode($user->properties_share_list, true);

        // Filter properties not deleted
        $filteredProperties = [];
        foreach ($propertiesArr as $propertyId) {
            $property = Property::where('building_id', $propertyId)->whereNull('deleted_at')->first();
            if ($property) {
                $filteredProperties[] = $propertyId;
            }
        }

        // Handle property_options, storing it as JSON
        $propertyOptions = [
            'show_items' => $request->input('show_items') === 'yes' ? 'yes' : 'no'
        ];

        $shareList = new ShareList;
        $shareList->share_data = json_encode($filteredProperties);
        $shareList->link = $sLink;
        $shareList->type = 'Property';
        $shareList->comment = $request->comment;
        $shareList->property_options = json_encode($propertyOptions);
        $shareList->created_by = $userId;
        $shareList->save();

        $whatsappLink = "whatsapp://send?text=" . urlencode(url('/spms/sharedProperties/' . $sLink));
        return redirect()->away($whatsappLink);
    }

    public function propertySharePage(string $link)
    {
        $properties = ShareList::where('link', $link)->where('type','Property')->first();
        $comment = $properties->comment;
        $propertyOptions = json_decode($properties->property_options, true); 
        $showCode = $propertyOptions['show_items'] ?? 'no';
        
        $propertiesArr = json_decode($properties->share_data, true);
        $propertyDetails = Property::whereIn('building_id', $propertiesArr)->with('photos')->get();

        return view('shared_pages.shared-properties', compact('propertyDetails','comment', 'showCode', 'link'));
    }

    public function fetchPropertyDetails(Request $request)
    {
        $codes = $request->input('codes');

        if (!$codes || !is_array($codes)) {
            return response()->json(['error' => 'Invalid request data'], 400);
        }

        $properties = Property::whereIn('code', $codes)->get();

        $response = $properties->map(function ($property) {
            return [
                'code' => $property->code,
                'gross_sf' => $property->gross_sf,
                'selling_price' => $property->selling_price,
                'selling_g' => $property->selling_g,
                'rental_price' => $property->rental_price,
                'rental_g' => $property->rental_g,
                'oths' => $property->oths,
                'other_free_formate' => $property->other_free_formate,
            ];
        });

        return response()->json($response);
    }

    public function propertyDetailsSharePage($code, $link)
    {

        $checkLink = ShareList::where('link', $link)->where('type','Property')->first();

        if (!$checkLink) {
            return redirect()->back()->with('error', 'The provided URL is incorrect.');
        }

        $property = Property::where('code', $code)->with('photos')->first();

        if (!$property) {
            return redirect()->back()->with('error', 'Property not found.');
        }

        return view('shared_pages.share-property-details', compact('property'));
    }

    public function delete(Request $request)
    {
         $ids = $request->query('ids', []);

        if (!empty($ids)) {
            $idsArray = explode(',', $ids);

            $shareLists = ShareList::whereIn('id', $idsArray)->get();

            foreach ($shareLists as $share) {
                $folderPath = public_path('shareImgs/' . $share->link);

                if (File::exists($folderPath) && is_dir($folderPath)) {
                    File::deleteDirectory($folderPath);
                }

                $share->delete();
            }

            return redirect()->back()->with('success', 'Selected items and associated folders deleted successfully.');
        }

        return redirect()->back()->with('error', 'No items selected.');
    }

    public function deleteOldShareRecords(Request $request)
    {
        if ($request->_token !== csrf_token()) {
            return response()->json(['error' => 'Invalid CSRF token'], 403);
        }

        $shareLists = ShareList::where('type', 'Image')
                                ->orderBy('created_at', 'asc')
                                ->limit(20)
                                ->get();

        $deletedCount = 0;

        foreach ($shareLists as $share) {
            try {
                $folderPath = public_path('shareImgs/' . $share->link);
                if (File::exists($folderPath) && is_dir($folderPath)) {
                    File::deleteDirectory($folderPath);
                }

                $share->delete();

                $deletedCount++;

            } catch (\Exception $e) {
                Log::error('Error deleting ShareList record ID ' . $share->id . ': ' . $e->getMessage());
            }
        }

        return response()->json([
            'message' => "{$deletedCount} old records and their folders deleted successfully."
        ]);
    }

    public function gridPage(string $code)
    {
        $imgs = json_decode(auth()->user()->images_share_list, true) ?? [];

        if (empty($imgs)) {
            return back()->with('error', 'No shared images found.');
        }

        // $imageIds = array_slice($imgs, 0, 6);
        $images = Photo::whereIn('id', $imgs)
                    ->where('code', $code)
                    ->orderByRaw('FIELD(id, ' . implode(',', $imgs) . ')')
                    ->get();
        $imagesWithUrls = $images->map(function ($image) {
            return asset($image->image);
        });
        return view('grid', compact('imagesWithUrls'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
