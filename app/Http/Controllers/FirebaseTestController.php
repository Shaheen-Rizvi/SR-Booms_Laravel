<?php

namespace App\Http\Controllers;

use App\Services\FirebaseService;
use Illuminate\Http\JsonResponse;

class FirebaseTestController extends Controller
{
    public function test(): JsonResponse
    {
        $firebase = app()->make(FirebaseService::class);
        $database = $firebase->getDatabase();
        
        try {
            // Test write
            $database->getReference('test')->set(['message' => 'Firebase is working!']);
            
            // Test read
            $value = $database->getReference('test/message')->getValue();
            
            return response()->json([
                'status' => 'success',
                'message' => $value
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}