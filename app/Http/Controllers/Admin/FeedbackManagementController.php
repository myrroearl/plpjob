<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FeedbackManagementController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Feedback::with('user');

            // Handle sorting
            switch ($request->input('sort')) {
                case 'latest':
                    $query->latest();
                    break;
                case 'oldest':
                    $query->oldest();
                    break;
                case 'status':
                    $query->orderBy('employment_status');
                    break;
                default:
                    $query->latest();
                    break;
            }

            // Handle employment status filter
            if ($status = $request->input('employment_status')) {
                $query->where('employment_status', $status);
            }

            $feedbacks = $query->paginate(10)->withQueryString();
            return view('admin.feedbacks.index', compact('feedbacks'));

        } catch (\Exception $e) {
            Log::error('Feedback listing error: ' . $e->getMessage());
            return back()->with('error', 'Error loading feedbacks: ' . $e->getMessage());
        }
    }

    public function destroy(Feedback $feedback)
    {
        try {
            $feedback->delete();
            Log::info("Feedback deleted successfully: {$feedback->id}");
            return response()->json(['message' => 'Feedback deleted successfully']);
        } catch (\Exception $e) {
            Log::error('Feedback deletion error: ' . $e->getMessage());
            return response()->json(['error' => 'Error deleting feedback'], 422);
        }
    }
}