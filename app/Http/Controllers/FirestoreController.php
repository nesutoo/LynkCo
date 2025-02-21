<?php

namespace App\Http\Controllers;

use Google\Cloud\Firestore\FirestoreClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Exception;

class FirestoreController extends Controller
{
    protected $firestore;
    protected $presenceCollection = 'presence';

    public function __construct()
    {
        try {
            // Get the path to the Firebase credentials file
            $credentialsPath = base_path(config('services.firebase.credentials'));

            // Check if credentials file exists
            if (!file_exists($credentialsPath)) {
                throw new Exception('Firebase credentials file not found');
            }

            $this->firestore = new FirestoreClient([
                'keyFilePath' => $credentialsPath,
                'projectId' => config('services.firebase.project_id')
            ]);
        } catch (Exception $e) {
            Log::error('Firebase initialization error: ' . $e->getMessage());
            throw new Exception('Failed to initialize Firebase: ' . $e->getMessage());
        }
    }

    public function updatePresence(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'status' => 'required|string|in:online,offline,away'
            ]);

            // Get authenticated user
            $user = Auth::user();
            if (!$user) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $userId = (string) $user->id;
            $status = $request->input('status');
            
            // Prepare presence data
            $presenceData = [
                'user_id' => $userId,
                'status' => $status,
                'last_seen' => time(),
                'name' => $user->name,
                'updated_at' => [
                    'seconds' => time(),
                    'nanos' => 0
                ]
            ];

            // Update presence in Firestore
            $userRef = $this->firestore->collection($this->presenceCollection)->document($userId);
            $userRef->set($presenceData, ['merge' => true]);

            return response()->json([
                'success' => true,
                'message' => 'Presence updated successfully',
                'data' => $presenceData
            ]);

        } catch (Exception $e) {
            Log::error('Presence update error: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'exception' => $e
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Failed to update presence',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getOnlineUsers()
    {
        try {
            // Get authenticated user
            if (!Auth::check()) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            // Get current timestamp minus 5 minutes (for active status)
            $activeThreshold = time() - (5 * 60);

            // Query online users
            $presenceRef = $this->firestore->collection($this->presenceCollection);
            $query = $presenceRef
                ->where('status', '=', 'online')
                ->where('last_seen', '>', $activeThreshold);
            
            $snapshot = $query->documents();

            $onlineUsers = [];
            foreach ($snapshot as $document) {
                $userData = $document->data();
                $onlineUsers[] = [
                    'user_id' => $userData['user_id'] ?? null,
                    'name' => $userData['name'] ?? 'Unknown',
                    'status' => $userData['status'] ?? 'offline',
                    'last_seen' => $userData['last_seen'] ?? null,
                ];
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'online_count' => count($onlineUsers),
                    'users' => $onlineUsers
                ]
            ]);

        } catch (Exception $e) {
            Log::error('Get online users error: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'exception' => $e
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Failed to fetch online users',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function clearPresence()
    {
        try {
            // Get authenticated user
            $user = Auth::user();
            if (!$user) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $userId = (string) $user->id;
            
            // Update status to offline
            $userRef = $this->firestore->collection($this->presenceCollection)->document($userId);
            $userRef->set([
                'status' => 'offline',
                'last_seen' => time(),
                'updated_at' => [
                    'seconds' => time(),
                    'nanos' => 0
                ]
            ], ['merge' => true]);

            return response()->json([
                'success' => true,
                'message' => 'Presence cleared successfully'
            ]);

        } catch (Exception $e) {
            Log::error('Clear presence error: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'exception' => $e
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Failed to clear presence',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}