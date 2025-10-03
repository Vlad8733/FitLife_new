<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Progress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProgressPhotoController extends Controller
{
    // Show all progress photos for authenticated user
    public function index()
    {
        $progressPhotos = Auth::user()->progress()->latest()->get();
        return view('progress.index', compact('progressPhotos'));
    }

    // Store a new progress photo
    public function store(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|max:2048',
            'description' => 'nullable|string|max:255',
        ]);

        Auth::user()->progress()->create([
            'photo' => $request->file('photo')->store('progress', 'public'),
            'description' => $request->description,
        ]);

        return back()->with('success', '');
    }

    // Update photo description
    public function update(Request $request, Progress $progress)
    {
        $this->authorizeUser($progress);

        $request->validate([
            'description' => 'nullable|string|max:255',
        ]);

        $progress->update(['description' => $request->description]);

        return back()->with('success', '');
    }

    // Delete a photo
    public function destroy(Progress $progress)
    {
        $this->authorizeUser($progress);

        Storage::disk('public')->delete($progress->photo);
        $progress->delete();

        return back()->with('success', '');
    }

    // Helper: check if the authenticated user owns the progress photo
    private function authorizeUser(Progress $progress)
    {
        if ($progress->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
