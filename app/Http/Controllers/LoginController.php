<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class LoginController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Menampilkan halaman login
     */
    public function index(): View
    {
        return view('auth.login');
    }

    /**
     * Memproses login
     */
    public function login(Request $request): RedirectResponse
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Memanggil AuthService
        $result = $this->authService->login(
            $request->email,
            $request->password
        );

        // Jika login gagal
        if (!$result['success']) {
            return back()
                ->withErrors([
                    'email' => $result['message']
                ])
                ->withInput();
        }

        // Ambil data user
        $user = $result['user'];

        // Redirect berdasarkan role
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($user->role === 'manager') {
            return redirect()->route('manager.dashboard');
        }

        return redirect()->route('staff.dashboard');
    }
}
