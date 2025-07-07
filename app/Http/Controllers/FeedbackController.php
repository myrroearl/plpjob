<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    /**
     * Display the feedback form.
     */
    public function index()
    {
        // Get the user's latest feedback
        $latestFeedback = Auth::user()->feedback()
            ->latest()
            ->first();

        return view('feedback.index', [
            'latestFeedback' => $latestFeedback
        ]);
    }

    /**
     * Store a new feedback submission.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employment_status' => 'required|in:yes,no,other',
            'company_name' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'employment_duration' => 'nullable|string',
            'improvements' => 'nullable|string',
            'additional_comments' => 'nullable|string',
        ]);

        // Create or update feedback
        $feedback = Feedback::updateOrCreate(
            ['user_id' => Auth::id()],
            $validated
        );

        return redirect()->route('feedback.index')
            ->with('success', 'Thank you! Your feedback has been successfully ' . 
                ($request->has('feedback_id') ? 'updated' : 'submitted') . '.');
    }

    public function checkFeedbackExists()
    {
        $exists = Auth::user()->feedback()->exists();
        return response()->json(['exists' => $exists]);
    }
}
