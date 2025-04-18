<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ItemsResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'description' => $item->description,
                    'price' => $item->price,
                    'status' => $item->status,
                    'location' => $item->location,
                    'created_by' => $item->created_by,
                    'category_id' => $item->category_id,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                    'file_path' => $item->file_path,
                    'file_name' => $item->file_name,
                    'file_type' => $item->file_type,
                    'image_url' => $item->image_url,
                ];
            })->toArray(),
        ];
    }
}
