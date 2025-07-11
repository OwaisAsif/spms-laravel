<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShareList extends Model
{
    use HasFactory;

    protected $casts = [
        'share_data' => 'array',
    ];

    // Custom method to retrieve photos based on share_data
    public function getPhotos()
    {
        // Check if share_data is stored as a JSON string and decode it manually if necessary
        $shareData = is_string($this->share_data) ? json_decode($this->share_data, true) : $this->share_data;

        // If the share_data is an array, extract the keys (photo IDs)
        if (is_array($shareData)) {
            $photoIds = array_keys($shareData);

            // Fetch the photos from the Photo model where the id matches the photo IDs in share_data
            return Photo::whereIn('id', $photoIds)->get();
        }

        return collect(); // Return an empty collection if share_data is not an array
    }
}
