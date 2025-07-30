<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class SupabaseStorageService
{
    private $supabaseUrl;
    private $supabaseKey;
    private $bucket;

    public function __construct()
    {
        $this->supabaseUrl = 'https://cawdbumigiwafukejndb.supabase.co';
        $this->supabaseKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImNhd2RidW1pZ2l3YWZ1a2VqbmRiIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NTM4MzY5NDYsImV4cCI6MjA2OTQxMjk0Nn0.R0twY6a16flkMAMdh6kndykvNRIG5d2FGlOpqoxQL20';
        $this->bucket = 'adminfiles';
    }

    /**
     * Upload a file to Supabase Storage
     *
     * @param string $filePath Local path to the file
     * @param string $fileName Name to save the file as in Supabase
     * @return array|false Returns array with success status and public URL, or false on failure
     */
    public function uploadFile($filePath, $fileName)
    {
        try {
            if (!file_exists($filePath)) {
                throw new \Exception("File not found: {$filePath}");
            }

            $fileContent = file_get_contents($filePath);
            $mimeType = mime_content_type($filePath);

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->supabaseKey,
                'Content-Type' => $mimeType,
            ])->post(
                "{$this->supabaseUrl}/storage/v1/object/{$this->bucket}/{$fileName}",
                $fileContent
            );

            if ($response->successful()) {
                $publicUrl = "{$this->supabaseUrl}/storage/v1/object/public/{$this->bucket}/{$fileName}";
                
                return [
                    'success' => true,
                    'url' => $publicUrl,
                    'filename' => $fileName
                ];
            } else {
                \Log::error('Supabase upload failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'file' => $fileName,
                    'url' => "{$this->supabaseUrl}/storage/v1/object/{$this->bucket}/{$fileName}",
                    'bucket' => $this->bucket
                ]);
                return false;
            }
        } catch (\Exception $e) {
            \Log::error('Supabase upload exception', [
                'message' => $e->getMessage(),
                'file' => $fileName
            ]);
            return false;
        }
    }

    /**
     * Upload a file from a temporary path (like /tmp)
     *
     * @param string $tempPath Temporary file path
     * @param string $fileName Name to save the file as
     * @return array|false
     */
    public function uploadFromTemp($tempPath, $fileName)
    {
        return $this->uploadFile($tempPath, $fileName);
    }

    /**
     * Delete a file from Supabase Storage
     *
     * @param string $fileName Name of the file to delete
     * @return bool
     */
    public function deleteFile($fileName)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->supabaseKey,
            ])->delete("{$this->supabaseUrl}/storage/v1/object/{$this->bucket}/{$fileName}");

            return $response->successful();
        } catch (\Exception $e) {
            \Log::error('Supabase delete failed', [
                'message' => $e->getMessage(),
                'file' => $fileName
            ]);
            return false;
        }
    }

    /**
     * Get public URL for a file
     *
     * @param string $fileName
     * @return string
     */
    public function getPublicUrl($fileName)
    {
        return "{$this->supabaseUrl}/storage/v1/object/public/{$this->bucket}/{$fileName}";
    }

    /**
     * Check if a file exists in Supabase Storage
     *
     * @param string $fileName
     * @return bool
     */
    public function fileExists($fileName)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->supabaseKey,
            ])->head("{$this->supabaseUrl}/storage/v1/object/{$this->bucket}/{$fileName}");

            return $response->successful();
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get file metadata from Supabase Storage
     *
     * @param string $fileName
     * @return array|false
     */
    public function getFileMetadata($fileName)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->supabaseKey,
            ])->get("{$this->supabaseUrl}/storage/v1/object/info/{$this->bucket}/{$fileName}");

            if ($response->successful()) {
                return $response->json();
            }
            return false;
        } catch (\Exception $e) {
            return false;
        }
    }
} 
