<?php

use App\Services\FirebaseService;

class FeedbackController extends Controller
{
    protected $firebase;

    public function __construct(FirebaseService $firebase)
    {
        $this->firebase = $firebase->getDatabase();
    }
    public function storeFeedback(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'feedback' => 'required|string|max:500',
        ]);

        $feedbackData = [
            'user_id' => $request->input('user_id'),
            'feedback' => $request->input('feedback'),
            'created_at' => now()->toDateTimeString(),
        ];

        $this->firebase->getReference('feedbacks')->push($feedbackData);

        return response()->json(['message' => 'Feedback submitted successfully'], 201);
    }
    public function getFeedbacks()
    {
        $feedbacks = $this->firebase->getReference('feedbacks')->getValue();

        if (!$feedbacks) {
            return response()->json(['message' => 'No feedbacks found'], 404);
        }

        return response()->json($feedbacks, 200);
    }
    public function deleteFeedback($id)
    {
        $feedbackRef = $this->firebase->getReference('feedbacks/' . $id);

        if (!$feedbackRef->getSnapshot()->exists()) {
            return response()->json(['message' => 'Feedback not found'], 404);
        }

        $feedbackRef->remove();

        return response()->json(['message' => 'Feedback deleted successfully'], 200);
    }
    public function updateFeedback(Request $request, $id)
    {
        $request->validate([
            'feedback' => 'required|string|max:500',
        ]);

        $feedbackRef = $this->firebase->getReference('feedbacks/' . $id);

        if (!$feedbackRef->getSnapshot()->exists()) {
            return response()->json(['message' => 'Feedback not found'], 404);
        }

        $feedbackData = [
            'feedback' => $request->input('feedback'),
            'updated_at' => now()->toDateTimeString(),
        ];

        $feedbackRef->update($feedbackData);

        return response()->json(['message' => 'Feedback updated successfully'], 200);
    }
    public function getFeedbackById($id)
    {
        $feedbackRef = $this->firebase->getReference('feedbacks/' . $id);

        if (!$feedbackRef->getSnapshot()->exists()) {
            return response()->json(['message' => 'Feedback not found'], 404);
        }

        $feedback = $feedbackRef->getValue();

        return response()->json($feedback, 200);
    }   
}