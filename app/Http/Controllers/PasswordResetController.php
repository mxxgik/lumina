<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class PasswordResetController extends Controller
{
    /**
     * Enviar código de recuperación de 6 dígitos
     */
    public function sendResetCode(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = User::where('email', $request->email)->first();

            // Siempre responder igual, exista o no el usuario
            $genericResponse = [
                'success' => true,
                'message' => 'Si el correo existe, se ha enviado un código de recuperación.'
            ];

            if ($user) {
                // Generar código de 6 dígitos
                $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
                // Eliminar tokens anteriores del usuario
                PasswordReset::where('email', $request->email)->delete();
                // Crear nuevo token (válido por 15 minutos)
                PasswordReset::create([
                    'email' => $request->email,
                    'token' => Hash::make($code),
                    'created_at' => Carbon::now()
                ]);
                // Enviar email con el código
                try {
                    $htmlBody = "<!DOCTYPE html>
                        <html lang=\"es\">
                        <head>
                            <meta charset=\"UTF-8\">
                            <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
                            <title>Código de Recuperación</title>
                        </head>
                        <body style=\"font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px;\">
                            <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                                <tr>
                                    <td align=\"center\">
                                        <table width=\"600\" border=\"0\" cellspacing=\"0\" cellpadding=\"20\" style=\"max-width: 600px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);\">
                                            <tr>
                                                <td align=\"center\" style=\"padding: 40px 20px;\">
                                                    <h1 style=\"color: #333333; margin-top: 0;\">Recuperación de Contraseña</h1>
                                                    <p style=\"color: #555555; font-size: 16px; line-height: 1.5;\">Hola {$user->nombre},</p>
                                                    <p style=\"color: #555555; font-size: 16px; line-height: 1.5;\">Tu código para restablecer la contraseña es:</p>
                                                    <p style=\"font-size: 24px; font-weight: bold; color: #333333; background-color: #f0f0f0; padding: 10px 20px; border-radius: 5px; display: inline-block; margin: 20px 0;\">{$code}</p>
                                                    <p style=\"color: #555555; font-size: 16px; line-height: 1.5;\">Este código expirará en 15 minutos.</p>
                                                    <p style=\"color: #777777; font-size: 14px; line-height: 1.5;\">Si no solicitaste este cambio, puedes ignorar este correo.</p>
                                                    <hr style=\"border: 0; border-top: 1px solid #eeeeee; margin: 30px 0;\">
                                                    <p style=\"color: #777777; font-size: 14px;\">Saludos,<br>El Equipo de Lumina</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </body>
                        </html>";

                    Mail::html($htmlBody, function ($message) use ($request) {
                        $message->to($request->email)
                                ->subject('Código de Recuperación - Lumina');
                    });
                    // En desarrollo, devolver el código para facilitar pruebas
                    if (config('app.env') === 'local') {
                        $genericResponse['data'] = ['code' => $code];
                    }
                } catch (\Exception $e) {
                    // No revelar error de email, solo loguear si es necesario
                }
            }
            return response()->json($genericResponse, 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send reset code',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Verificar código de recuperación
     */
    public function verifyResetCode(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'code' => 'required|string|size:6'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors()
                ], 422);
            }

            $resetRecord = PasswordReset::where('email', $request->email)->first();

            if (!$resetRecord) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontró solicitud de recuperación para este email'
                ], 404);
            }

            // Verificar si el código expiró (15 minutos)
            if (Carbon::parse($resetRecord->created_at)->addMinutes(15)->isPast()) {
                $resetRecord->delete();
                return response()->json([
                    'success' => false,
                    'message' => 'El código ha expirado. Solicita uno nuevo.'
                ], 400);
            }

            // Verificar el código
            if (!Hash::check($request->code, $resetRecord->token)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Código inválido'
                ], 400);
            }

            // Generar token temporal para cambiar contraseña
            $resetToken = Str::random(60);
            
            $resetRecord->update([
                'token' => Hash::make($resetToken),
                'created_at' => Carbon::now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Código verificado correctamente',
                'data' => [
                    'reset_token' => $resetToken
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to verify reset code',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Restablecer contraseña
     */
    public function resetPassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'reset_token' => 'required|string',
                'password' => 'required|string|min:8|confirmed'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors()
                ], 422);
            }

            $resetRecord = PasswordReset::where('email', $request->email)->first();

            if (!$resetRecord) {
                return response()->json([
                    'success' => false,
                    'message' => 'Token de recuperación no válido'
                ], 404);
            }

            // Verificar si el token expiró (15 minutos)
            if (Carbon::parse($resetRecord->created_at)->addMinutes(15)->isPast()) {
                $resetRecord->delete();
                return response()->json([
                    'success' => false,
                    'message' => 'El token ha expirado'
                ], 400);
            }

            // Verificar el token
            if (!Hash::check($request->reset_token, $resetRecord->token)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Token inválido'
                ], 400);
            }

            // Actualizar contraseña
            $user = User::where('email', $request->email)->first();
            $user->update([
                'password' => Hash::make($request->password)
            ]);

            // Eliminar el token usado
            $resetRecord->delete();

            // Revocar todos los tokens existentes del usuario por seguridad
            $user->tokens()->delete();

            return response()->json([
                'success' => true,
                'message' => 'Contraseña actualizada correctamente. Por favor, inicia sesión con tu nueva contraseña.'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to reset password',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
