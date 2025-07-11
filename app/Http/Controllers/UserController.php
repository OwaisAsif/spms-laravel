<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Property;
use App\Models\ShareList;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('role', 'agent')->get();
        return view('users', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function updatePermission(Request $request)
    {
        $user = User::find($request->id);

        if ($user && in_array($request->type, ['contact', 'photo', 'image_merge'])) {
            $column = $request->type . '_permission';
            $user->$column = $request->value;
            $user->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Invalid ID.']);
    }

    public function getShareCount()
    {
        $user = Auth::user();

        $properties = is_string($user->properties_share_list)
            ? json_decode($user->properties_share_list, true)
            : [];

        $images = is_string($user->images_share_list)
            ? json_decode($user->images_share_list, true)
            : [];

        $sharepropertyCount = Property::whereIn('building_id', $properties)->whereNull('deleted_at')->count();
        $shareimgCount = Photo::whereIn('id', $images)->whereNull('deleted_at')->count();

        $totalCount = $sharepropertyCount + $shareimgCount;

        // For Image Share List Previous shared count
        $imgPreShareCount = ShareList::where('type', 'Image')->where('created_by', auth()->user()->id)->count();

        return response()->json([
            'count' => $totalCount,
            'preShareCount' => $imgPreShareCount
        ]);
    }

    public function sharePage()
    {
        return view('publish');
    }

    public function clearShareList()
    {
        $user = Auth::user()->id;
        $shareList = User::where('id', $user)->first();
        $shareList->properties_share_list = null;
        $shareList->images_share_list = null;
        $shareList->save();

        return redirect('/admin-search')->with('success', 'Share list cleared successfully.');
    }

    public function shareDetails()
    {
        $user = Auth::user();

        $properties = is_string($user->properties_share_list)
            ? json_decode($user->properties_share_list, true)
            : [];

        $images = is_string($user->images_share_list)
            ? json_decode($user->images_share_list, true)
            : [];

        // Filter out soft-deleted properties and images
        $properties = Property::whereIn('building_id', $properties)->whereNull('deleted_at')->pluck('building_id')->toArray();
        $images = Photo::whereIn('id', $images)->whereNull('deleted_at')->pluck('id')->toArray();

        $sharepropertyCount = count($properties);
        $shareimgCount = count($images);

        $propertiesData = collect();
        if (!empty($properties)) {
            $propertiesData = Property::with('photos')
                ->whereIn('building_id', $properties)
                ->orderByRaw("FIELD(building_id, " . implode(',', $properties) . ")")
                ->get();

            $propertiesData->each(function ($property) {
                $property->photos = $property->photos->map(function ($photo) {
                    $photo->image = asset($photo->image);
                    return $photo;
                });
            });
        }

        $imagesData = collect();
        $commentsCode = collect();
        if (!empty($images)) {
            $imagesData = Photo::whereIn('id', $images)
                ->orderByRaw("FIELD(id, " . implode(',', $images) . ")")
                ->get()
                ->map(function ($image) {
                    $image->image = asset($image->image);
                    return $image;
                });

            $commentsCode = Photo::whereIn('id', $images)->groupBy('code')->pluck('code');
        }

        return response()->json([
            'properties_count' => $sharepropertyCount,
            'images_count' => $shareimgCount,
            'properties_data' => $propertiesData,
            'images_data' => $imagesData,
            'comments_codes' => $commentsCode
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    public function removeSharedImage(Request $request)
    {
        $user = Auth::user();  
        $imageId = $request->id;

        $updateImgList = User::where('id', $user->id)->first();
        $imagesShareList = json_decode($updateImgList->images_share_list, true);

        if (is_array($imagesShareList) && in_array($imageId, $imagesShareList)) {
            $updatedList = array_filter($imagesShareList, function ($image) use ($imageId) {
                return $image != $imageId;
            });

            $updateImgList->images_share_list = json_encode(array_values($updatedList));
            $updateImgList->save();

            return response()->json(['message' => 'Image removed successfully']);
        }
        return response()->json(['message' => 'Image ID not found or invalid share list'], 404);
    }

    public function sharedImageOrder(Request $request)
    {
        $user = Auth::user();  
        $reorderedIds = $request->input('reordered_ids');

        $updateImgList = User::find($user->id);

        if (is_array($reorderedIds)) {
            $updateImgList->images_share_list = json_encode($reorderedIds);
            $updateImgList->save();

            return response()->json(['message' => 'Image order updated successfully']);
        }

        return response()->json(['message' => 'Invalid image list'], 400);
    }

    public function removeSharedProperty(string $id)
    {
        $user = Auth::user();  
        $propertyId = $id;

        $updatePropertyList = User::where('id', $user->id)->first();
        $propertiesShareList = json_decode($updatePropertyList->properties_share_list, true);

        if (is_array($propertiesShareList) && in_array($propertyId, $propertiesShareList)) {
            $updatedList = array_filter($propertiesShareList, function ($property) use ($propertyId) {
                return $property != $propertyId;
            });

            $updatePropertyList->properties_share_list = json_encode(array_values($updatedList));
            $updatePropertyList->save();

            return response()->json([
                'message' => 'Property removed successfully',
                'property_id' => $propertyId
            ]);
        }
        
        return response()->json(['message' => 'Property ID not found or invalid share list'], 404);
    }

    public function savePropertyShareList(Request $request)
    {
        $propertyShareList = $request->input('property_share_list');

        $propertyShareList = array_map(function($item) {
            return str_replace('swipe-', '', $item);
        }, $propertyShareList);

        $user = Auth::user();
        $update = User::find($user->id);

        $update->properties_share_list = json_encode($propertyShareList);
        $update->save();

        return response()->json(['message' => 'Property share list saved successfully']);
    }

    public function passwordUpdate(Request $request)
    {
        $id = Auth()->user()->id;
        $user = User::where('id', $id)->first();
        $user->password = Hash::make($request->passwordLogIn);
        $user->save();

        return redirect()->back()->with('success', 'Password is updated');
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
        $user = User::find($id);

        if ($user) {
            $user->delete();
            return response()->json(['success' => true, 'message' => 'User deleted successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Invalid ID.']);
    }
}
