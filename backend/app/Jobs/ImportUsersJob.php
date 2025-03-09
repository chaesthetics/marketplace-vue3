<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ImportUsersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;
    /**
     * Create a new job instance.
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $file = Storage::get($this->filePath);
        $rows = array_map('str_getcsv', explode("\n", $file));
    
        foreach ($rows as $index => $row) {
            if ($index === 0) continue; 
            
            if (!User::where('email', $row[1])->exists()) {
                $user = User::create([
                    'name' => $row[0] ?? 'Unknown',
                    'email' => $row[1] ?? 'noemail@example.com',
                    'password' => bcrypt($row[2] ?? 'password'),
                ]);

                $user->assignRole($row[3]);
            }
        }
    }
}
