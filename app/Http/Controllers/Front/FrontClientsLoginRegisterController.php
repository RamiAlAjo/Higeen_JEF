<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class FrontClientsLoginRegisterController extends Controller
{
    /**
     * Show the registration form.
     */
    public function create()
    {
        return view('front.register');
    }

    /**
     * Handle client registration.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email',
            'password' => 'required|confirmed|min:6',
            'phone_number' => 'nullable|string|max:20',
            'shipping_address' => 'nullable|string|max:255',
            'billing_address' => 'nullable|string|max:255',
            'preferred_payment_method' => 'nullable|string|max:50',
            'area' => 'nullable|string|max:100',
            'gender' => 'nullable|in:male,female',
            'date_of_birth' => 'nullable|date|before:today',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $avatarPath = null;

        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            // Save file under storage/app/public/uploads/avatars
            $avatarPath = $request->file('avatar')->store('uploads/avatars', 'public');
        }

        $client = Client::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'shipping_address' => $request->shipping_address,
            'billing_address' => $request->billing_address,
            'preferred_payment_method' => $request->preferred_payment_method,
            'area' => $request->area,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'avatar' => $avatarPath,
        ]);

        Auth::guard('client')->login($client);

        return redirect()->route('client.dashboard')->with('success', 'Registered successfully.');
    }

    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('front.login');
    }

    /**
     * Handle client login.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('client')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('client.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ])->withInput();
    }

    /**
     * Logout client.
     */
    public function logout()
    {
        Auth::guard('client')->logout();

        return redirect()->route('client.login')->with('success', 'Logged out successfully.');
    }

    /**
     * Show profile edit form.
     */
    public function edit()
    {
        $client = Auth::guard('client')->user();
        return view('front.profile.edit', compact('client'));
    }

    /**
     * Update client profile.
     */
    public function update(Request $request)
    {
        $client = Auth::guard('client')->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email,' . $client->id,
            'phone_number' => 'nullable|string|max:20',
            'shipping_address' => 'nullable|string|max:255',
            'billing_address' => 'nullable|string|max:255',
            'preferred_payment_method' => 'nullable|string|max:50',
            'area' => 'nullable|string|max:100',
            'gender' => 'nullable|in:male,female',
            'date_of_birth' => 'nullable|date|before:today',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->only([
            'name', 'email', 'phone_number', 'shipping_address',
            'billing_address', 'preferred_payment_method', 'area',
            'gender', 'date_of_birth'
        ]);

        // Handle avatar upload
        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {

            // Delete old avatar if it exists
            if ($client->avatar && Storage::disk('public')->exists($client->avatar)) {
                Storage::disk('public')->delete($client->avatar);
            }

            // Store the new one
            $data['avatar'] = $request->file('avatar')->store('uploads/avatars', 'public');
        }

        $client->update($data);

        return redirect()->route('client.dashboard')->with('success', 'Profile updated successfully.');
    }
}
