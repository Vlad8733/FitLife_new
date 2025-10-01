<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    public function show(User $user)
    {
        return view('profile.show', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // Валидация
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Логирование для отладки
        Log::info('Profile update request:', [
            'has_banner' => $request->hasFile('banner'),
            'has_avatar' => $request->hasFile('avatar'),
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $data = $request->only('name', 'email');

        // Обработка баннера
        if ($request->hasFile('banner')) {
            Log::info('Processing banner upload');
            if ($user->banner && Storage::disk('public')->exists($user->banner)) {
                Storage::disk('public')->delete($user->banner);
                Log::info('Deleted old banner: ' . $user->banner);
            }
            $bannerPath = $request->file('banner')->store('banner', 'public');
            $data['banner'] = $bannerPath;
            Log::info('New banner path: ' . $bannerPath);
        }

        // Обработка аватарки
        if ($request->hasFile('avatar')) {
            Log::info('Processing avatar upload');
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
                Log::info('Deleted old avatar: ' . $user->avatar);
            }
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $avatarPath;
            Log::info('New avatar path: ' . $avatarPath);
        }

        // Обновление данных пользователя
        $user->update($data);
        Log::info('User updated:', $data);

        return redirect()->back()->with('status', 'Profile updated successfully!');
    }

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

    public function destroy(Request $request)
    {
        $user = Auth::user();
        $user->delete();
        Auth::logout();
        return redirect('/')->with('status', 'Account deleted successfully!');
    }
}