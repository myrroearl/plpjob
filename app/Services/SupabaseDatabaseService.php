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
     * Get the latest model (alias for getLatestAlumniPredictionModel)
     *
     * @return array|false
     */
    public function getLatestModel()
    {
        return $this->getLatestAlumniPredictionModel();
    }

    /**
     * Update a specific alumni_prediction_models record by ID
     *
     * @param int $id
     * @param array $data
     * @return array|false
     */
    public function updateAlumniPredictionModel($id, $data)
    {
        try {
            $response = Http::withHeaders([
                'apikey' => $this->supabaseKey,
                'Authorization' => 'Bearer ' . $this->supabaseKey,
                'Content-Type' => 'application/json',
                'Prefer' => 'return=representation'
            ])->patch(
                "{$this->supabaseUrl}/rest/v1/alumni_prediction_models?id=eq.{$id}",
                $data
            );

            if ($response->successful()) {
                $result = $response->json();
                Log::info('Supabase update by ID successful', [
                    'id' => $id,
                    'data' => $data,
                    'result' => $result
                ]);
                return $result;
            } else {
                Log::error('Supabase update by ID failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'id' => $id,
                    'data' => $data
                ]);
                return false;
            }
        } catch (\Exception $e) {
            Log::error('Supabase update by ID exception', [
                'message' => $e->getMessage(),
                'id' => $id,
                'data' => $data
            ]);
            return false;
        }
    }
} 
