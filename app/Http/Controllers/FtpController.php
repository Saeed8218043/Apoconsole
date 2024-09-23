<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class FtpController extends Controller
{
    // Method to check FTP connection
    public function checkConnection()
    {
        try {
            // Attempt to list files in the root directory
            $files = Storage::disk('old_ftp')->files('/');

            // If no exception is thrown, the connection is successful
            return response()->json([
                'status' => 'success',
                'message' => 'FTP connection successful.',
                'files' => $files
            ]);
        } catch (\Exception $e) {
            // If an exception is caught, the connection failed
            Log::error('FTP connection failed: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'FTP connection failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function transferLatestFile()
    {
        try {
            // Get the latest file from the old FTP server
            $files = Storage::disk('old_ftp')->files('/');

            if (empty($files)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No files found on the old FTP server'
                ]);
            }

            $latestFile = null;
            $latestTimestamp = null;

            foreach ($files as $file) {
                $timestamp = Storage::disk('old_ftp')->lastModified($file);
                if (is_null($latestTimestamp) || $timestamp > $latestTimestamp) {
                    $latestTimestamp = $timestamp;
                    $latestFile = $file;
                }
            }

            if ($latestFile) {
                // Get the content of the latest file
                $latestFileContent = Storage::disk('old_ftp')->get($latestFile);

                // Upload the latest file to the new FTP server
                Storage::disk('new_ftp')->put($latestFile, $latestFileContent);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Latest file transferred successfully',
                    'latest_file' => $latestFile
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No latest file found'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error during file transfer: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error during file transfer: ' . $e->getMessage()
            ], 500);
        }
    }
}
