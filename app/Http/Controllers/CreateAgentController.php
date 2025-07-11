<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class CreateAgentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('create-staff');
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
        $agent = new User;
        $agent->name = $request->name;
        $agent->password = $request->password;
        $agent->role = 'agent';
        $agent->save();

        return redirect()->back()->with('success', 'Successfully Added!');
    }

    // public function shareProperty(Request $request)
    // {
    //     $buildingId = $request->input('building_id');
    //     $user = User::find(auth()->id());

    //     if (!$user) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'User not found!',
    //         ], 404);
    //     }

    //     $sharedProperties = json_decode($user->properties_share_list, true) ?? [];

    //     if (in_array($buildingId, $sharedProperties)) {
    //         $sharedProperties = array_filter($sharedProperties, fn($id) => $id != $buildingId);
    //         $message = "Property removed from shared list.";
    //     } else {
    //         $sharedProperties[] = $buildingId;
    //         $message = "Property added share list successfully!";
    //     }

    //     $user->properties_share_list = array_values($sharedProperties);
    //     $user->save(); 

    //     return response()->json([
    //         'success' => true,
    //         'message' => $message,
    //         'shared_properties' => $sharedProperties,
    //     ]);
    // }
    public function shareProperty(Request $request)
    {
        $buildingIds = $request->input('building_id');
        $user = User::find(auth()->id());

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found!',
            ], 404);
        }

        $sharedProperties = json_decode($user->properties_share_list, true) ?? [];

        if (!is_array($buildingIds)) {
            $buildingIds = [$buildingIds];
        }

        $added = [];
        $removed = [];

        foreach ($buildingIds as $buildingId) {
            if (in_array($buildingId, $sharedProperties)) {
                $sharedProperties = array_filter($sharedProperties, fn($id) => $id != $buildingId);
                $removed[] = $buildingId;
            } else {
                $sharedProperties[] = $buildingId;
                $added[] = $buildingId;
            }
        }
        
        $user->properties_share_list = array_values($sharedProperties);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Shared properties updated successfully!',
            'added' => $added,
            'removed' => $removed,
            'shared_properties' => $sharedProperties,
        ]);
    }

    public function shareImage(Request $request)
    {
        $imageId = $request->input('image_id');
        $user = User::find(auth()->id());

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found!',
            ], 404);
        }

        $sharedImages = json_decode($user->images_share_list, true) ?? [];

        if (in_array($imageId, $sharedImages)) {
            $sharedImages = array_filter($sharedImages, fn($id) => $id != $imageId);
            $message = "Image removed from shared list.";
        } else {
            $sharedImages[] = $imageId;
            $message = "Image added to shared list successfully!";
        }

        $user->images_share_list = array_values($sharedImages);
        $user->save(); 

        return response()->json([
            'success' => true,
            'message' => $message,
            'shared_images' => $sharedImages,
        ]);
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
