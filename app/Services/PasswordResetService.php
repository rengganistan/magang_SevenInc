<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class PasswordResetService
{
    /**
     * Kirim link reset password ke email user
     */
    public function sendResetLink(string $email): array
    {
        $status = Password::sendResetLink(['email' => $email]);

        if ($status === Password::RESET_LINK_SENT) {
            return [
                'success' => true,
                'message' => 'Link reset password telah dikirim ke email Anda.',
            ];
        }

        // EMAIL_NOT_FOUND atau error lain
        return [
            'success' => false,
            'message' => 'Email tidak ditemukan dalam sistem kami.',
        ];
    }

    /**
     * Reset password user dengan token yang valid
     */
    public function resetPassword(string $email, string $password, string $token): array
    {
        $status = Password::reset(
            [
                'email'                 => $email,
                'password'              => $password,
                'password_confirmation' => $password,
                'token'                 => $token,
            ],
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return [
                'success' => true,
                'message' => 'Password berhasil direset.',
            ];
        }

        $message = match ($status) {
            Password::INVALID_TOKEN => 'Token reset password tidak valid atau sudah kedaluwarsa.',
            Password::INVALID_USER  => 'Email tidak ditemukan dalam sistem kami.',
            default                 => 'Terjadi kesalahan. Silakan coba lagi.',
        };

        return [
            'success' => false,
            'message' => $message,
        ];
    }
}
