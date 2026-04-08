<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Agency;
use App\Models\Sektor;
use App\Mail\NewUserRegisteredMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        $sektors = Sektor::with('agencies')->get();
        $agencies = Agency::all();
        return view('auth.register', ['sektors' => $sektors, 'agencies' => $agencies]);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'role' => ['required', 'in:admin,agency'],
            'sektor_id' => ['nullable', 'exists:sektor,id'],
            'agensi_id' => ['nullable', 'exists:agencies,id']
        ]);

        // If role is agency, agensi_id is required
        if ($validated['role'] === 'agency' && empty($validated['agensi_id'])) {
            return back()->withErrors(['agensi_id' => 'Agensi adalah wajib untuk pengguna agensi'])->withInput();
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'agensi_id' => $validated['agensi_id'] ?? null,
        ]);

        // Send welcome email to newly registered user
        try {
            Mail::to($user->email)->send(new NewUserRegisteredMail($user));
        } catch (\Exception $e) {
            // Log error but don't fail user registration
            \Log::error('Failed to send welcome email: ' . $e->getMessage());
        }

        Auth::login($user);
        return redirect()->intended($this->redirectPath());
    }

    private function redirectPath()
    {
        if (Auth::user()->role === 'admin') {
            return route('admin.dashboard');
        }
        return route('agency.dashboard');
    }
}
