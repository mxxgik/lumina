<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    /**
     * Register push token for authenticated user
     */
    public function registerToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required|string',
            'device_id' => 'required|string',
            'platform' => 'required|in:ios,android',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 400);
        }

        $user = $request->user();
        $user->update([
            'push_token' => $request->token,
            'device_id' => $request->device_id,
            'platform' => $request->platform,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Push token registrado correctamente'
        ]);
    }

    /**
     * Get all notifications for authenticated user
     */
    public function index(Request $request)
    {
        $user = $request->user();
        
        $notifications = Notification::where('usuario_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $notifications
        ]);
    }

    /**
     * Mark a notification as read
     */
    public function markAsRead(Request $request, $id)
    {
        $user = $request->user();
        
        $notification = Notification::where('id', $id)
            ->where('usuario_id', $user->id)
            ->first();

        if (!$notification) {
            return response()->json([
                'success' => false,
                'message' => 'Notificación no encontrada'
            ], 404);
        }

        $notification->update([
            'is_read' => true,
            'read_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Notificación marcada como leída',
            'data' => $notification
        ]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead(Request $request)
    {
        $user = $request->user();
        
        Notification::where('usuario_id', $user->id)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Todas las notificaciones marcadas como leídas'
        ]);
    }

    /**
     * Delete a notification
     */
    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        
        $notification = Notification::where('id', $id)
            ->where('usuario_id', $user->id)
            ->first();

        if (!$notification) {
            return response()->json([
                'success' => false,
                'message' => 'Notificación no encontrada'
            ], 404);
        }

        $notification->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notificación eliminada correctamente'
        ]);
    }

    /**
     * Send push notification to a user
     * 
     * @param int $userId
     * @param string $title
     * @param string $body
     * @param array $data
     * @return bool
     */
    public function sendPushNotification($userId, $title, $body, $data = [])
    {
        $user = User::find($userId);
        
        if (!$user || !$user->push_token) {
            \Log::warning("No se pudo enviar notificación al usuario {$userId}: Token no encontrado");
            return false;
        }

        // Guardar notificación en base de datos
        Notification::create([
            'usuario_id' => $userId,
            'title' => $title,
            'body' => $body,
            'data' => $data,
        ]);

        // Preparar mensaje para Expo Push
        $message = [
            'to' => $user->push_token,
            'sound' => 'default',
            'title' => $title,
            'body' => $body,
            'data' => $data,
            'priority' => 'high',
            'channelId' => 'default',
        ];

        try {
            $response = Http::post('https://exp.host/--/api/v2/push/send', $message);
            
            if ($response->successful()) {
                \Log::info("Notificación enviada exitosamente al usuario {$userId}");
                return true;
            } else {
                \Log::error("Error en respuesta de Expo: " . $response->body());
                return false;
            }
        } catch (\Exception $e) {
            \Log::error("Error enviando notificación push: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Send push notification to multiple users
     * 
     * @param array $userIds
     * @param string $title
     * @param string $body
     * @param array $data
     * @return array
     */
    public function sendBulkPushNotification($userIds, $title, $body, $data = [])
    {
        $results = [
            'success' => [],
            'failed' => []
        ];

        foreach ($userIds as $userId) {
            $sent = $this->sendPushNotification($userId, $title, $body, $data);
            
            if ($sent) {
                $results['success'][] = $userId;
            } else {
                $results['failed'][] = $userId;
            }
        }

        return $results;
    }
}
