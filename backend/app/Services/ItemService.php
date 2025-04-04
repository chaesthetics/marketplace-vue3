<?php

namespace App\Services;

use App\Models\Item;
use App\Models\User;
use App\Models\Category;

class ItemService implements BaseServiceInterface 
{
    public $error = [];

    public function create(array $payload): mixed
    {
        $item = null;
        try{
            $file = $payload['file'];
            $payload['file_path'] = $file->getPath();
            $payload['file_name'] = $file->getClientOriginalName();
            $payload['file_type'] = $file->getClientMimeType();
            $payload['name'] = $payload['name'] ?? $file->getClientOriginalName();
            unset($payload['file']);
    
            $item = new Item($payload);
            $item->user()->associate(auth()->id());
            $item->status = 'pending';
            $item->title = $payload['title'];
            
            $item->save();
        } catch (\Exception $e) {
            $this->error = ['message' => $e->getMessage(), 'code' => HttpStatusCode::Internal_Server_Error->value];
        }
        
        return $item;
    }

    public function update($id, array $payload): Item
    {
        return Item::findOrFail($id)->update($payload);
    }

    public function destroy($id)
    {
        return Item::destroy($id);
    }
}
