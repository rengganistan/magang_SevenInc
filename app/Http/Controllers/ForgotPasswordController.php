<?php

namespace App\Http\Controllers;

use App\Services\PasswordResetService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ForgotPasswordController extends Controller
{
    protected PasswordResetService $passwordResetService;

    public function __construct(PasswordResetService $passwordResetService)
    {
        $this->passwordResetService = $passwordResetService;
    }

    /**
     * Tampilkan form request forgot password
     */
    public function showForgotForm(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Kirim link reset password ke email
     */
    public function sendResetLink(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $result = $this->passwordResetService->sendResetLink($request->email);

        if (!$result['success']) {
            return back()
                ->withErrors(['email' => $result['message']])
                ->withInput();
        }

        return back()->with('status', $result['message']);
    }

    /**
     * Tampilkan form reset password
     */
    public function showResetForm(Request $request, string $token): View
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    /**
     * Proses reset password
     */
    public function resetPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'token'                 => ['required'],
            'email'                 => ['required', 'email'],
            'password'              => ['required', 'min:8', 'confirmed'],
        ]);

        $result = $this->passwordResetService->resetPassword(
            $request->email,
            $request->password,
            $request->token
        );

        if (!$result['success']) {
            return back()
                ->withErrors(['email' => $result['message']])
                ->withInput();
        }

        return redirect()->route('login')
            ->with('status', 'Password berhasil direset. Silakan login dengan password baru.');
    }
}
