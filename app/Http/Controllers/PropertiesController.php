<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Property;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class PropertiesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tempId = Str::random(6);
        $districts = explode(',', Utility::where('key', 'district')->value('value'));
        $facilities = explode(',', Utility::where('key', 'facilities')->value('value'));
        $types = explode(',', Utility::where('key', 'types')->value('value'));
        $decorations = explode(',', Utility::where('key', 'decorations')->value('value'));
        $usage = explode(',', Utility::where('key', 'usage')->value('value'));
        return view('properties.add-property', compact('tempId', 'districts', 'facilities', 'types', 'decorations', 'usage'));
    }

    public function propertyListPage()
    {
        return view('property-list');
    }

    public function propertyListTable(Request $request)
    {
        if ($request->ajax()) {
            $properties = Property::orderBy('created_at', 'desc')->get();
            
            return response()->json([
                'data' => $properties
            ]);
        }
    }

    public function photoPage(string $code)
    {
        return view('photos', compact('code'));
    }

    public function photosTable(string $code)
    {
        $photos = Photo::where('code', $code)->orderBy('created_at', 'desc')->get();

        return response()->json([
            'data' => $photos
        ]);
    }

    public function photoDelete(string $id)
    {
        $photo = Photo::where('id', $id)->first();
    
        if (!$photo) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid ID.'
            ]);
        }
        $photo->delete();

        return response()->json([
            'success' => true,
            'message' => 'Record deleted.'
        ]);
    }

    public function copyProperty(Request $request)
    {
        $originalProperty = Property::where('code', $request->code)->first();
        
        if (!$originalProperty) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid ID.'
            ]);
        }
        $newProperty = $originalProperty->replicate();
        
        $newProperty->code = 'temp - ' . $originalProperty->code;

        $newProperty->save();

        return response()->json([
            'success' => true,
            'message' => 'Record Copied.'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function uploadImage(Request $request)
    {
        try {
            $request->validate([
                'filepond' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'temp_id' => 'required|string',
            ]);
        
            $tempId = $request->temp_id;
            $uploadDir = public_path("temp/{$tempId}"); 
            
            if (!File::exists($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }
        
            if ($request->file('filepond')) {
                $file = $request->file('filepond');
                $filename = $file->getClientOriginalName();
                $file->move($uploadDir, $filename);
        
                return response()->json([
                    'filename' => $filename,
                    'path' => "temp/{$tempId}/{$filename}",
                ], 200);
            }
        
            return response()->json(['error' => 'No file uploaded'], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Server error: ' . $e->getMessage()], 500);
        }
    }

    public function deleteImage(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['path'])) {
            return response()->json(['error' => 'Invalid request data'], 400);
        }
        $filePath = public_path($data['path']);

        if (File::exists($filePath)) {
            if (File::delete($filePath)) {
                return response()->json(['message' => 'File deleted successfully'], 200);
            } else {
                return response()->json(['error' => 'Failed to delete file'], 500);
            }
        }

        return response()->json(['error' => 'File not found'], 404);
    }

    public function checkCode(Request $request)
    {
        $code = $request->input('code');

        $exists = Property::where('code', $code)->exists();

        if ($exists) {
            return response('<p class="text-danger">Not Available</p>', 200)
                ->header('Content-Type', 'text/html');
        } else {
            return response('<p class="text-success">Available</p>', 200)
                ->header('Content-Type', 'text/html');
        }
    }

    public function searchBuilding(Request $request)
    {
        $building = $request->input('building');
        $output = '<ul class="list-group">';
        
        if ($building) {
            $buildings = DB::table('new_add')
                ->where('building_name', 'LIKE', "%{$building}%")
                ->pluck('building_name');
            
            if ($buildings->isEmpty()) {
                $output .= "<p class='text-danger text-center font-weight-bold'>No Building found</p>";
            } else {
                foreach ($buildings as $bldg) {
                    $output .= "<li class='list-group-item list-group-item-action list-group-item-dark'>{$bldg}</li>";
                }
            }
        } else {
            $output .= "<p class='text-danger text-center font-weight-bold'>No Building found</p>";
        }
        
        $output .= '</ul>';
        return response($output);
    }

    public function getBuildingInfo(Request $request)
    {
        $building_name = $request->input('text1');

        $building = DB::table('new_add')
            ->where('building_name', '=', $building_name)
            ->first(['building_name', 'address_chinese', 'year']);

        $building_name = trim($building_name);
        $building_name = str_replace(["\n", "\r"], '', $building_name);

        $ytLink = Property::where('building', $building_name)
            ->whereNotNull('yt_link_1')
            ->orderBy('created_at', 'desc')
            ->first();

        $propertyLatest = Property::where('building', $building_name)
            ->orderBy('created_at', 'desc')
            ->first();
        
        if ($ytLink) {
            $allYtChange = Property::where('building', $building_name)->get();
            
            foreach ($allYtChange as $link) {
                $link->yt_link_1 = $ytLink->yt_link_1;
                $link->save();
            }
        }
        
        if ($building) {
            return response()->json([
                'address_chinese' => $building->address_chinese ?? '',
                'year' => $building->year ?? '',
                'yt_link' => $ytLink->yt_link_1 ?? '',
                'propertyLatest' => $propertyLatest
            ]);
        }

        return response()->json([], 404);
    }

    public function duplicateImages(Request $request)
    {
        $buildingName = $request->input('building');
        $imageIds = $request->input('images');
        $code = $request->input('code');
        $properties = Property::where('building', '=', $buildingName)->get();
        foreach ($properties as $property) {
            foreach ($imageIds as $imageId) {
                $image = Photo::find($imageId);
                if($property->code != $code){
                    $newImage = $image->replicate();
                    $newImage->code = $property->code;
                    $uuid = strtolower(str_pad(rand(1, 99999999999999), 14, '0', STR_PAD_LEFT));
                    $newImage->uuid = $uuid;
                    $newImage->save();

                    $sourcePath = public_path($image->image);
                    $newFolderPath = public_path("properties/{$property->code}");
                    $newFilename = "{$uuid}.{$this->getFileExtension($sourcePath)}";

                    if (!File::exists($newFolderPath)) {
                        File::makeDirectory($newFolderPath, 0755, true);
                    }

                    $destinationPath = "{$newFolderPath}/{$newFilename}";
                    if (File::exists($sourcePath)) {
                        File::copy($sourcePath, $destinationPath);
                    }
                    $newImage->image = "properties/{$property->code}/{$newFilename}";
                    $newImage->save();
                }
            }
        }

        return response()->json(['message' => 'Images successfully duplicated to properties in the same building.']);
    }

    private function getFileExtension($filePath)
    {
        return pathinfo($filePath, PATHINFO_EXTENSION);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:properties,code',
            'building' => 'required'
        ], [
            'code.unique' => 'Code is Taken!',
        ]);

        $property = new Property;

        $property->code = $request->code;
        $property->district = $request->district;
        $property->street = $request->street;
        $property->building = $request->building;
        $property->floor = $request->floor;
        $property->flat = $request->flat;
        $property->no_room = $request->no_rooms;
        $property->enter_password = $request->entry_password;
        $property->block = $request->block;
        $property->cargo_lift = $request->cargo_lift;
        $property->customer_lift = $request->customer_lift;
        $property->tf_hr = $request->tf_hr;
        $property->car_park = $request->car_park;
        $property->num_floors = $request->num_floors;
        $property->ceiling_height = $request->ceiling_height;
        $property->air_con_system = $request->air_con_system;
        $property->building_loading = $request->building_loading;
        // $property->display_by = null;
        $property->individual = 'No';
        $property->separate = 'No';
        $property->year = $request->year;
        $property->agent_name = auth()->user()->name;

        // LANDLORD DETAILS
        $property->landlord_name = $request->landlord_name;
        $property->bank = $request->bank;
        $property->bank_acc = $request->bank_account;
        $property->management_company = $request->management_company;
        $property->remarks = $request->remark;
        $property->contact1 = $request->contact1;
        $property->number1 = $request->number1;
        $property->contact2 = $request->contact2;
        $property->number2 = $request->number2;
        $property->contact3 = $request->contact3;
        $property->number3 = $request->number3;

        // F.T.O.D
        $property->facilities = implode(',', $request->facilities ?? []);
        $property->types = implode(',', $request->types ?? []);
        $property->decorations = implode(',', $request->decorations ?? []);
        $property->usage = implode(',', $request->usage ?? []);
        $property->yt_link_1 = $request->yt_link_1;
        $property->yt_link_2 = $request->yt_link_2;

        // dd($request->options, $request->option_date, $request->option_free_formate);
        $options = $request->input('options', []);
        $dates = $request->input('option_date', []);
        $formats = $request->input('option_free_formate', []);
        
        $othersArray = [];
        $datesArray = [];
        $currentDateArray = [];
        $formatsArray = [];

        foreach ($options as $index => $option) {
            if (!empty($option)) {
                $date = isset($dates[$index]) ? $dates[$index] : null;
                $format = isset($formats[$index]) ? $formats[$index] : null;
                $currentDate = now()->toDateString();

                $othersArray[] = $option;
                $datesArray[] = $date;
                $formatsArray[] = $format;
                $currentDateArray[] = $currentDate;
            }
        }

        $property->others = json_encode($othersArray);
        $property->other_date = json_encode($datesArray);
        $property->other_current_date = json_encode($currentDateArray);
        $property->other_free_formate = json_encode($formatsArray);

        // Pricing
        $property->gross_sf = $request->gross_sf;
        $property->net_sf = $request->net_sf;
        $property->selling_price = $request->selling;
        $property->selling_g = $request->selling_g;
        $property->selling_n = $request->selling_n;
        $property->rental_price = $request->rental;
        $property->rental_g = $request->rental_g;
        $property->rental_n = $request->rental_n;
        $property->mgmf = $request->mgmf;
        $property->rate = $request->rate;
        $property->land = $request->land;
        $property->oths = $request->oths;

        $property->save();

        $tempId = $request->tempId;
        $code = $request->code;
        $response = $this->renameAndMoveFolder($tempId, $code);

        // if ($response) {
        //     return $response;
        // }
        if (!$response['status']) {
            return redirect()->back()->with('error', $response['message']);
        }

        return redirect()->back()->with('success', 'Property updated successfully!');
    } 

    public function bulkImport()
    {
        return view('properties.properties-import');
    }

    public function importBulkProperties(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx'
        ]);

        $file = $request->file('file');
        $headings = Excel::toArray([], $file)[0][0] ?? [];

        $headingsNormalized = array_map(fn($h) => strtolower(str_replace('_', '', trim($h))), $headings);

        $dbColumns = (new Property())->getConnection()->getSchemaBuilder()->getColumnListing((new Property())->getTable());

        $excludedColumns = ['building_id', 'building_created_at', 'landlord_created_at', 'created_at', 'updated_at'];
        $columns = array_diff($dbColumns, $excludedColumns);

        $columnsNormalized = [];
        foreach ($columns as $col) {
            $columnsNormalized[strtolower(str_replace('_', ' ', $col))] = $col;
        }

        $rows = Excel::toArray([], $file)[0] ?? [];

        $utilityColumns = ['district', 'usage', 'decorations', 'types', 'facilities'];
        $validUtilities = [];

        foreach ($utilityColumns as $col) {
            $utilityData = Utility::where('key', $col)->value('value');
            $validUtilities[$col] = $utilityData ? explode(',', $utilityData) : [];
        }

        foreach ($rows as $key => $row) {
            if ($key === 0) continue;

            $data = [];

            foreach ($columnsNormalized as $normalizedCol => $originalCol) {
                $index = array_search($normalizedCol, $headingsNormalized, true);
                $value = ($index !== false && isset($row[$index])) ? trim($row[$index]) : null;

                // Skip this iteration if 'code' is null or empty
                if ($originalCol === 'code'|| $originalCol === 'building') {
                    if (is_null($value) || $value === '') {
                        continue 2;
                    }
                    if ($originalCol === 'code' && Property::where('code', $value)->exists()) {
                        continue 2;
                    }
                }

                // Validate utility columns
                if (in_array($originalCol, $utilityColumns) && !in_array($value, $validUtilities[$originalCol])) {
                    $value = null;
                }

                $data[$originalCol] = $value;
            }

            // Fixed fields
            $data['agent_name'] = auth()->user()->name;
            $data['individual'] = 'No';
            $data['separate'] = 'No';
            $data['others'] = json_encode([]);
            $data['other_date'] = json_encode([]);
            $data['other_current_date'] = json_encode([]);
            $data['other_free_formate'] = json_encode([]);

            if (isset($data['code'])) {
                Property::create($data);
            }
        }

        return back()->with('success', 'Properties imported successfully.');
    }

    // public function renameAndMoveFolder($tempId, $code)
    // {
    //     $tempFolderPath = public_path("temp/{$tempId}");
    //     $newFolderPath = public_path("properties/{$code}");

    //     if (!File::exists($tempFolderPath)) {
    //         return ['status' => false, 'message' => 'Temp folder does not exist.'];
    //     }

    //     if (!File::exists($newFolderPath)) {
    //         File::makeDirectory($newFolderPath, 0755, true);
    //         Log::info("New folder created: {$newFolderPath}");
    //     }

    //     $tempFiles = File::files($tempFolderPath);

    //     foreach ($tempFiles as $file) {
    //         $filename = $file->getFilename();
    //         $uuid = strtolower(str_pad(rand(1, 99999999999999), 14, '0', STR_PAD_LEFT));
    //         $newFilename = "{$uuid}.{$filename}";
    //         $destinationPath = "{$newFolderPath}/{$newFilename}";

    //         if (!File::exists($destinationPath)) {
    //             try {
    //                 File::copy($file->getPathname(), $destinationPath);
    //                 Log::info("File copied: {$file->getPathname()} to {$destinationPath}");

    //                 $imgPath = "properties/{$code}/{$newFilename}";
    //                 Photo::create([
    //                     'image' => $imgPath,
    //                     'code' => $code,
    //                     'uuid' => $uuid,
    //                 ]);
    //             } catch (\Exception $e) {
    //                 Log::error("File save failed: {$e->getMessage()}");
    //                 return ['status' => false, 'message' => 'Failed to save file to the database.'];
    //             }
    //         }
    //     }

    //     File::deleteDirectory($tempFolderPath);
    //     Log::info("Temp folder deleted: {$tempFolderPath}");

    //     return ['status' => true, 'message' => 'Folders merged and processed successfully.'];
    // }

    public function renameAndMoveFolder($tempId, $code)
    {
        ini_set('memory_limit', '1G'); 
        $tempFolderPath = public_path("temp/{$tempId}");
        $newFolderPath = public_path("properties/{$code}");
        $watermarkPath = public_path("assets/watermark/watermark.png");

        if (!File::exists($tempFolderPath)) {
            return ['status' => false, 'message' => 'Temp folder does not exist.'];
        }

        if (!File::exists($newFolderPath)) {
            File::makeDirectory($newFolderPath, 0755, true);
            Log::info("New folder created: {$newFolderPath}");
        }

        $tempFiles = File::files($tempFolderPath);

        foreach ($tempFiles as $file) {
            $extension = pathinfo($file->getFilename(), PATHINFO_EXTENSION);
            $uuid = strtolower(str_pad(rand(1, 99999999999999), 14, '0', STR_PAD_LEFT));
            $newFilename = "{$uuid}.{$extension}";
            $destinationPath = "{$newFolderPath}/{$newFilename}";

            if (!File::exists($destinationPath)) {
                try {
                    $image = imagecreatefromstring(file_get_contents($file->getPathname()));
                    if (!$image) {
                        Log::error("Failed to create image from file: {$file->getPathname()}");
                        continue;
                    }
                    $watermark = imagecreatefrompng($watermarkPath);
                    if (!$watermark) {
                        Log::error("Failed to create watermark from: {$watermarkPath}");
                        continue;
                    }
                    $watermarkWidth = 500;
                    $watermarkHeight = 400;
                    $resizedWatermark = imagescale($watermark, $watermarkWidth, $watermarkHeight);

                    $x = (imagesx($image) - $watermarkWidth) / 2;
                    $y = (imagesy($image) - $watermarkHeight) / 2;

                    imagecopy($image, $resizedWatermark, $x, $y, 0, 0, $watermarkWidth, $watermarkHeight);

                    if (!imagepng($image, $destinationPath)) {
                        Log::error("Failed to save watermarked image: {$destinationPath}");
                        continue;
                    }

                    imagedestroy($image);
                    imagedestroy($watermark);
                    imagedestroy($resizedWatermark);

                    Log::info("File processed and watermarked: {$destinationPath}");
                    $imgPath = "properties/{$code}/{$newFilename}";
                    Photo::create([
                        'image' => $imgPath,
                        'code' => $code,
                        'uuid' => $uuid,
                    ]);
                } catch (\Exception $e) {
                    Log::error("File save failed: {$e->getMessage()}");
                    return ['status' => false, 'message' => 'Failed to save file to the database.'];
                }
            }
        }

        File::deleteDirectory($tempFolderPath);
        Log::info("Temp folder deleted: {$tempFolderPath}");

        return ['status' => true, 'message' => 'Folders merged and processed successfully with watermark added.'];
    }

    public function updateOrder(Request $request)
    {
        // dd($request->all());
        $property = Property::where('code', $request->input('code'))->first();

        if (!$property) {
            return response()->json(['error' => 'Property not found'], 404);
        }

        $contacts = [
            ['contact' => $request->input('contact1'), 'number' => $request->input('number1')],
            ['contact' => $request->input('contact2'), 'number' => $request->input('number2')],
            ['contact' => $request->input('contact3'), 'number' => $request->input('number3')],
        ];

        foreach ($contacts as $index => $contactData) {
            $property->{"contact" . ($index + 1)} = $contactData['contact'];
            $property->{"number" . ($index + 1)} = $contactData['number'];
        }
        $property->save();

        return response()->json(['success' => true]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $code)
    {
        $property = Property::with('photos', 'comments.user')->where('code', $code)->first();
        $latestComment = $property->comments->sortByDesc('created_at')->first();
        return view('property-detail', compact('property', 'latestComment'));
    }

    public function editCode(string $code)
    {
        return view('properties.edit.edit-code', compact('code'));
    }

    public function editProperty(string $code)
    {
        $property = Property::where('code', $code)->first();
        $tempId = Str::random(6);
        $districts = explode(',', Utility::where('key', 'district')->value('value'));
        return view('properties.edit.edit-property', compact('property', 'tempId', 'districts'));
    }

    public function getPropertyImages($code)
    {
        $photos = Photo::where('code', $code)->pluck('image');

        if ($photos->isEmpty()) {
            return response()->json([], 200);
        }
        $images = $photos->map(function ($path) {
            return [
                'source' => url($path),
                'options' => ['type' => 'local'],
            ];
        });

        return response()->json($images, 200);
    }

    public function editBuildinginfo($code)
    {
        $property = Property::where('code', $code)->first();
        $districts = explode(',', Utility::where('key', 'district')->value('value'));
        return view('properties.edit.edit-building-info', compact('property', 'districts'));
    }

    public function editLandlord($code)
    {
        $property = Property::where('code', $code)->first();
        return view('properties.edit.edit-landlord', compact('property'));
    }

    public function editFtod($code)
    {
        $property = Property::where('code', $code)->first();

        $savedFacilities = explode(',', $property->facilities);
        $savedTypes = explode(',', $property->types);
        $savedDecorations = explode(',', $property->decorations);
        $savedUsages = explode(',', $property->usage);

        $facilities = explode(',', Utility::where('key', 'facilities')->value('value'));
        // dd($facilities);
        $types = explode(',', Utility::where('key', 'types')->value('value'));
        $decorations = explode(',', Utility::where('key', 'decorations')->value('value'));
        $usage = explode(',', Utility::where('key', 'usage')->value('value'));

        return view('properties.edit.edit-ftod', compact('property', 'facilities', 'types', 'decorations', 'usage', 'savedFacilities', 'savedTypes', 'savedDecorations', 'savedUsages'));
    }

    public function editSizePrice($code)
    {
        $property = Property::where('code', $code)->first();
        return view('properties.edit.edit-size-price', compact('property'));
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
    public function update(Request $request, string $code)
    {
        // dd($request->all());
        $property = Property::where('code', $code)->first();

        $property->district = $request->district;
        $property->street = $request->street;
        $property->building = $request->building;
        $property->floor = $request->floor;
        $property->flat = $request->flat;
        $property->no_room = $request->no_rooms;
        $property->enter_password = $request->entry_password;
        $property->block = $request->block;
        $property->cargo_lift = $request->cargo_lift;
        $property->customer_lift = $request->customer_lift;
        $property->tf_hr = $request->tf_hr;
        $property->car_park = $request->car_park;
        $property->num_floors = $request->num_floors;
        $property->ceiling_height = $request->ceiling_height;
        $property->air_con_system = $request->air_con_system;
        $property->building_loading = $request->building_loading;
        $property->display_by = $request->display;
        $property->individual = $request->individual ?? 'No';
        $property->separate = $request->separate ?? 'No';
        $property->year = $request->year;

        // Landlord Edit
        $property->landlord_name = $request->landlord_name;
        $property->bank = $request->bank;
        $property->bank_acc = $request->bank_account;
        $property->management_company = $request->management_company;
        $property->remarks = $request->remark;
        $property->contact1 = $request->contact1;
        $property->number1 = $request->number1;
        $property->contact2 = $request->contact2;
        $property->number2 = $request->number2;
        $property->contact3 = $request->contact3;
        $property->number3 = $request->number3;

        $property->save();

        if ($request->filled('removed_images')) {
            $removedImagePaths = json_decode($request->removed_images, true);
    
            $cleanedPaths = array_map(function ($path) {
                // Remove the base URL (http://new_spms.test/) from the full URL
                $baseUrl = url('/'); // This generates the base URL (http://new_spms.test)
                return Str::replaceFirst($baseUrl . '/', '', $path); // Remove base URL part
            }, $removedImagePaths);

            // Soft delete images
            Photo::whereIn('image', $cleanedPaths)->delete();
        }

        $tempId = $request->tempId;
        $code = $request->code;
        $response = $this->renameAndMoveFolder($tempId, $code);

        // if ($response) {
        //     return $response;
        // }
        if($tempId = null){
            if (!$response['status']) {
                return redirect()->back()->with('error', $response['message']);
            }
        }

        // return redirect()->back()->with('success', 'Landlord updated successfully!');
        return redirect()->route('property.show', ['code' => $code])->with('success', 'Landlord updated successfully!');
    }

    public function updateCode(Request $request, string $code)
    {
        try {
            $request->validate([
                'code_new' => 'required|unique:properties,code',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('property.show', ['code' => $code])
                             ->withErrors($e->errors());
        }

        $newCode = Property::where('code', $code)->first();
        if (!$newCode) {
            return back()->withErrors(['code' => 'The specified property code does not exist.']);
        }

        $newCode->code = $request->code_new;
        $newCode->save();

        $photoCodes = Photo::where('code', $code)->get();

        foreach($photoCodes as $photoCode)
        {   
            $oldPhotoPath = $photoCode->image;
            $newPhotoPath = str_replace("properties/{$code}/", "properties/{$request->code_new}/", $oldPhotoPath);

            $photoCode->code = $request->code_new;
            $photoCode->image = $newPhotoPath;
            $photoCode->save();
        }

        // Rename the folder if it exists
        $oldFolderPath = public_path("properties/{$code}");
        $newFolderPath = public_path("properties/{$request->code_new}");
        if (file_exists($oldFolderPath)) {
            rename($oldFolderPath, $newFolderPath);
        }

        return redirect()->route('property.show', ['code' => $request->code_new])
                     ->with('success', 'Code and related data updated successfully.');
    }

    public function updateBuildinginfo(Request $request, string $code)
    {
        $property = Property::where('code', $code)->first();

        $property->district = $request->district;
        $property->street = $request->street;
        $property->building = $request->building;
        $property->floor = $request->floor;
        $property->flat = $request->flat;
        $property->no_room = $request->no_rooms;
        $property->enter_password = $request->entry_password;
        $property->block = $request->block;
        $property->cargo_lift = $request->cargo_lift;
        $property->customer_lift = $request->customer_lift;
        $property->tf_hr = $request->tf_hr;
        $property->car_park = $request->car_park;
        $property->num_floors = $request->num_floors;
        $property->ceiling_height = $request->ceiling_height;
        $property->air_con_system = $request->air_con_system;
        $property->building_loading = $request->building_loading;
        $property->display_by = $request->display;
        $property->individual = $request->individual ?? 'No';
        $property->separate = $request->separate ?? 'No';
        $property->year = $request->year;
        // $property->agent_name = auth()->user()->name;
        $property->save();

        // return redirect()->back()->with('success', 'Building Info updated successfully!');
        return redirect()->route('property.show', ['code' => $code])->with('success', 'Landlord updated successfully!');
    }

    public function updateLandlord(Request $request, string $code)
    {
        $property = Property::where('code', $code)->first();
        
        $property->landlord_name = $request->landlord_name;
        $property->bank = $request->bank;
        $property->bank_acc = $request->bank_account;
        $property->management_company = $request->management_company;
        $property->remarks = $request->remark;
        $property->contact1 = $request->contact1;
        $property->number1 = $request->number1;
        $property->contact2 = $request->contact2;
        $property->number2 = $request->number2;
        $property->contact3 = $request->contact3;
        $property->number3 = $request->number3;

        $property->save();
        // return redirect()->back()->with('success', 'Landlord updated successfully!');
        return redirect()->route('property.show', ['code' => $code])->with('success', 'Landlord updated successfully!');
    }

    public function updateFtod(Request $request, string $code)
    {
        $property = Property::where('code', $code)->first();
        // F.T.O.D
        $property->facilities = implode(',', $request->facilities ?? []);
        $property->types = implode(',', $request->types ?? []);
        $property->decorations = implode(',', $request->decorations ?? []);
        $property->usage = implode(',', $request->usage ?? []);
        $property->yt_link_1 = $request->yt_link_1;
        $property->yt_link_2 = $request->yt_link_2;

        // dd($request->options, $request->option_date, $request->option_free_formate);

        $options = $request->input('options', []);
        $dates = $request->input('option_date', []);
        $formats = $request->input('option_free_formate', []);
        
        $othersArray = [];
        $datesArray = [];
        $formatsArray = [];
        $currentDateArray = [];

        // Retrieve existing data
        // $existingOthers = json_decode($property->others, true) ?? [];
        // $existingDates = json_decode($property->other_date, true) ?? [];
        // $existingFormats = json_decode($property->other_free_formate, true) ?? [];
        $existingCurrentDates = json_decode($property->other_current_date, true) ?? [];

        foreach ($options as $index => $option) {
            if (!empty($option)) {
                $date = isset($dates[$index]) ? $dates[$index] : null;
                $format = isset($formats[$index]) ? $formats[$index] : null;
                $currentDate = now()->toDateString();
                
                $othersArray[] = $option;
                $datesArray[] = $date;
                $formatsArray[] = $format;
                $currentDateArray[] = isset($existingCurrentDates[$index]) ? $existingCurrentDates[$index] : $currentDate;
            }
        }

        $property->others = json_encode($othersArray);
        $property->other_date = json_encode($datesArray);
        $property->other_current_date = json_encode($currentDateArray);
        $property->other_free_formate = json_encode($formatsArray);

        $property->save();
        // return redirect()->back()->with('success', 'Ftod updated successfully!');
        return redirect()->route('property.show', ['code' => $code])->with('success', 'Landlord updated successfully!');
    }

    public function updatesizePrice(Request $request, string $code)
    {
        $property = Property::where('code', $code)->first();

        // Pricing
        $property->gross_sf = $request->gross_sf;
        $property->net_sf = $request->net_sf;
        $property->selling_price = $request->selling;
        $property->selling_g = $request->selling_g;
        $property->selling_n = $request->selling_n;
        $property->rental_price = $request->rental;
        $property->rental_g = $request->rental_g;
        $property->rental_n = $request->rental_n;
        $property->mgmf = $request->mgmf;
        $property->rate = $request->rate;
        $property->land = $request->land;
        $property->oths = $request->oths;

        $property->save();
        // return redirect()->back()->with('success', 'Size Price updated successfully!');
        return redirect()->route('property.show', ['code' => $code])->with('success', 'Landlord updated successfully!');
    }

    public function updateRoom(Request $request)
    {
        // Get data from the request
        $photoId = $request->input('photo_id');
        $field = $request->input('field');
        $value = $request->input('value');

        $photo = Photo::where('id', $photoId)->first();
        $photo->{$field} = $value;
        $photo->save();

        // Respond with a success message
        return response()->json(['success' => true, 'message' => 'Field updated successfully.']);
    }

    public function ytLink(Request $request)
    {
        $imgId = $request->image_id;
        $image = Photo::where('id', $imgId)->first();

        $image->yt_link = $request->link;
        $image->save();

        return back()->with('success', 'YouTube link added successfully!');
    }

    public function searchProperties(Request $request)
    {
        $query = $request->input('query');
        $output = '<ul class="list-group">';

        if ($query) {
            $buildings = Property::where('building', 'LIKE', "%{$query}%")
                ->orWhere('code', 'LIKE', "%{$query}%")
                ->get();

            if ($buildings->isEmpty()) {
                $output .= "<p>No property found</p>";
            } else {
                foreach ($buildings as $building) {
                    $output .= "<a href='" . route('property.show', ['code' => $building->code]) . "' class='text-decoration-none'>";
                    $output .= "<li class='list-group-item list-group-item-action list-group-item-dark'>";
                    $output .= "<strong>" 
                            . e($building->building ?? 'N/A') 
                            . ' (' . e($building->code ?? 'N/A') . ')'
                            . "</strong>"
                            . ' (' . e($building->flat ?? 'N/A') 
                            . ' - ' . e($building->floor ?? 'N/A') 
                            . ' - ' . e($building->block ?? 'N/A') . ')';
                    $output .= "</li>";
                    $output .= "</a>";
                }
            }
        } else {
            $output .= "<p class='text-danger text-center font-weight-bold'>Enter a search term</p>";
        }

        $output .= '</ul>';
        return response($output);
    }

    public function ftodOthers($id, Request $request)
    {
        $property = Property::where('building_id', $id)->first();
        
        if ($property) {
            $property->others = json_encode([]); 
            $property->other_date = json_encode([]);
            $property->other_current_date = json_encode([]);
            $property->other_free_formate = json_encode([]);
            $property->save();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Ftod updated successfully!',
                ]);
            }
            return redirect()->back()->with('success', 'Ftod updated successfully!');
        }
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Property not found!',
            ], 404);
        }
        return redirect()->back()->with('error', 'Property not found!');
    }

    public function ftodOtherRO(Request $request)
    {
        $id = $request->building_id;
        $rentOutDate = $request->date;
        $property = Property::where('building_id', $id)->first();

        if ($property) {
            $property->others = [];
            $property->other_date = [];
            $property->other_current_date = [];
            $property->other_free_formate = [];
            $property->save();

            $formattedRentOutDate = Carbon::parse($rentOutDate)->format('Y-m-d');

            $othersArray = ['Rent Out 巳租'];
            $datesArray = [$formattedRentOutDate];
            $formatsArray = [null];
            $currentDateArray = [now()->toDateString()];

            $property->others = $othersArray;
            $property->other_date = $datesArray;
            $property->other_current_date = $currentDateArray;
            $property->other_free_formate = $formatsArray;
            $property->save();

            return response()->json([
                'success' => true,
                'message' => 'Ftod updated successfully!',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Property not found!',
        ], 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $code)
    {
        $property = Property::where('code', $code)->first();
        $property->code = $property->code . ' del_' . date('Y-m-d H:i:s');
        $property->save();

        $property->delete(); 

        return response()->json([
            'success' => true,
            'message' => 'Property deleted successfully.'
        ]);
    }
}
