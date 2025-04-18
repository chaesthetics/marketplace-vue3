<?php

namespace App\Services;

use App\Services\BaseServiceInterface;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Item;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

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
            $payload['status'] = 'pending';
            $payload['price'] = 0.00;
            unset($payload['file']);

            $item = new Item($payload);
            $item->createdBy()->associate(auth()->user()->id);
            $item->save();

            $this->storeImage($item, $file);
        } catch (\Exception $e) {
            $code = (int) $e->getCode();
            $this->error = ['message' => $e->getMessage(), 'code' => $code > 0 ? $code : Response::HTTP_INTERNAL_SERVER_ERROR];
        }

        return $item;
    }
    public function update($id, array $payload): mixed
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    private function storeImage(Item $item, UploadedFile $file): string
    {
        $fileNameOnly = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $fileName = sprintf('%s.%s', $fileNameOnly, $file->getClientOriginalExtension());

        $fileDirectory = sprintf('public/images/%s',
            $item->id);

        Storage::disk('local')->putFileAs($fileDirectory, $file, $fileName);
        
        $fileDirectory = str_replace('public/', '', $fileDirectory);
        $item->update([
            'file_path' => $fileDirectory,
            'file_name' => $fileName,
        ]);

        return sprintf('%s/%s', $fileDirectory, $fileName);
    }
}