<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    // Show edit profile form
    public function edit()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    // Show user profile
    public function show(User $user)
    {
        return view('profile.show', compact('user'));
    }

    // Update user profile info
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => [
                'required',
                'string',
                'min:3',
                'max:20',
                'regex:/^[a-zA-Z0-9_]+$/',
                Rule::unique('users', 'username')->ignore($user->id),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        Log::info('Profile update request:', [
            'has_banner' => $request->hasFile('banner'),
            'has_avatar' => $request->hasFile('avatar'),
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
        ]);

        $data = $request->only('name', 'username', 'email');

        // Handle banner upload
        if ($request->hasFile('banner')) {
            $this->deleteFile($user->banner);
            $data['banner'] = $request->file('banner')->store('banner', 'public');
            Log::info('New banner path: ' . $data['banner']);
        }

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $this->deleteFile($user->avatar);
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
            Log::info('New avatar path: ' . $data['avatar']);
        }

        $user->update($data);
        Log::info('User updated:', $data);

        return redirect()->back()->with('status', 'Profile updated successfully!');
    }

    // Update user password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        return redirect()->back()->with('status', 'Password updated successfully!');
    }

    // Delete user account
    public function destroy(Request $request)
    {
        $user = Auth::user();
        $user->delete();
        Auth::logout();

        return redirect('/')->with('status', 'Account deleted successfully!');
    }

    // Helper: delete a file if it exists
    private function deleteFile($path)
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
            Log::info('Deleted file: ' . $path);
        }
    }
}
