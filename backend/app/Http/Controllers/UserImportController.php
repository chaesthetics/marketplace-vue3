<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\ImportUsersJob;

class UserImportController extends Controller
{
    public function import(Request $request)
    {
        // Validate file
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt|max:2048'
        ]);

        // Store the file
        $path = $request->file('csv_file')->store('csv_uploads');
        \Log::info(["Filepath" => $path]);
        // Dispatch the job to process the file
        ImportUsersJob::dispatch($path);

        return response()->json(['message' => 'CSV uploaded. Processing in the background.']);
    }

}
