<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SupabaseDatabaseService
{
    private $supabaseUrl;
    private $supabaseKey;

    public function __construct()
    {
        $this->supabaseUrl = 'https://cawdbumigiwafukejndb.supabase.co';
        $this->supabaseKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImNhd2RidW1pZ2l3YWZ1a2VqbmRiIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NTM4MzY5NDYsImV4cCI6MjA2OTQxMjk0Nn0.R0twY6a16flkMAMdh6kndykvNRIG5d2FGlOpqoxQL20';
    }

    /**
     * Insert a new record into alumni_prediction_models table
     *
     * @param array $data
     * @return array|false
     */
    public function insertAlumniPredictionModel($data)
    {
        try {
            $response = Http::withHeaders([
                'apikey' => $this->supabaseKey,
                'Authorization' => 'Bearer ' . $this->supabaseKey,
                'Content-Type' => 'application/json',
                'Prefer' => 'return=representation'
            ])->post(
                "{$this->supabaseUrl}/rest/v1/alumni_prediction_models",
                $data
            );

            if ($response->successful()) {
                $result = $response->json();
                Log::info('Supabase insert successful', [
                    'data' => $data,
                    'result' => $result
                ]);
                return $result;
            } else {
                Log::error('Supabase insert failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'data' => $data
                ]);
                return false;
            }
        } catch (\Exception $e) {
            Log::error('Supabase insert exception', [
                'message' => $e->getMessage(),
                'data' => $data
            ]);
            return false;
        }
    }

    /**
     * Update the most recent alumni_prediction_models record
     *
     * @param array $data
     * @return array|false
     */
    public function updateLatestAlumniPredictionModel($data)
    {
        try {
            // First, get the latest record ID
            $latestResponse = Http::withHeaders([
                'apikey' => $this->supabaseKey,
                'Authorization' => 'Bearer ' . $this->supabaseKey,
                'Content-Type' => 'application/json'
            ])->get(
                "{$this->supabaseUrl}/rest/v1/alumni_prediction_models",
                [
                    'select' => 'id',
                    'order' => 'id.desc',
                    'limit' => 1
                ]
            );

            if (!$latestResponse->successful()) {
                Log::error('Failed to get latest record ID', [
                    'status' => $latestResponse->status(),
                    'body' => $latestResponse->body()
                ]);
                return false;
            }

            $latestRecords = $latestResponse->json();
            if (empty($latestRecords)) {
                Log::error('No records found to update');
                return false;
            }

            $latestId = $latestRecords[0]['id'];

            // Update the record
            $response = Http::withHeaders([
                'apikey' => $this->supabaseKey,
                'Authorization' => 'Bearer ' . $this->supabaseKey,
                'Content-Type' => 'application/json',
                'Prefer' => 'return=representation'
            ])->patch(
                "{$this->supabaseUrl}/rest/v1/alumni_prediction_models?id=eq.{$latestId}",
                $data
            );

            if ($response->successful()) {
                $result = $response->json();
                Log::info('Supabase update successful', [
                    'id' => $latestId,
                    'data' => $data,
                    'result' => $result
                ]);
                return $result;
            } else {
                Log::error('Supabase update failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'id' => $latestId,
                    'data' => $data
                ]);
                return false;
            }
        } catch (\Exception $e) {
            Log::error('Supabase update exception', [
                'message' => $e->getMessage(),
                'data' => $data
            ]);
            return false;
        }
    }

    /**
     * Get the most recent alumni_prediction_models record
     *
     * @return array|false
     */
    public function getLatestAlumniPredictionModel()
    {
        try {
            $response = Http::withHeaders([
                'apikey' => $this->supabaseKey,
                'Authorization' => 'Bearer ' . $this->supabaseKey,
                'Content-Type' => 'application/json'
            ])->get(
                "{$this->supabaseUrl}/rest/v1/alumni_prediction_models",
                [
                    'select' => '*',
                    'order' => 'id.desc',
                    'limit' => 1
                ]
            );

            if ($response->successful()) {
                $result = $response->json();
                return !empty($result) ? $result[0] : false;
            } else {
                Log::error('Supabase get latest failed', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return false;
            }
        } catch (\Exception $e) {
            Log::error('Supabase get latest exception', [
                'message' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Get recent uploads for display
     *
     * @param int $limit
     * @return array|false
     */
    public function getRecentUploads($limit = 5)
    {
        try {
            $response = Http::withHeaders([
                'apikey' => $this->supabaseKey,
                'Authorization' => 'Bearer ' . $this->supabaseKey,
                'Content-Type' => 'application/json'
            ])->get(
                "{$this->supabaseUrl}/rest/v1/alumni_prediction_models",
                [
                    'select' => 'model_name,last_updated,prediction_accuracy,total_alumni',
                    'order' => 'last_updated.desc',
                    'limit' => $limit
                ]
            );

            if ($response->successful()) {
                return $response->json();
            } else {
                Log::error('Supabase get recent uploads failed', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return false;
            }
        } catch (\Exception $e) {
            Log::error('Supabase get recent uploads exception', [
                'message' => $e->getMessage()
            ]);
            return false;
        }
    }
} 
