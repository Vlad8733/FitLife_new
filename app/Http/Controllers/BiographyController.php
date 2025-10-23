<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Biography;

class BiographyController extends Controller
{
     // Show the biography edit form for the authenticated user
    public function edit()
    {
        $user = Auth::user();
        return view('biography.edit', [
            'user' => $user,
            'biography' => $user->biography
        ]);
    }

     // Update or create the biography of the authenticated user
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validate biography fields
        $data = $request->validate([
            'full_name' => 'nullable|string|max:255',
            'age'       => 'nullable|integer|min:1',
            'height'    => 'nullable|numeric|min:0',
            'weight'    => 'nullable|numeric|min:0',
            'gender'    => 'nullable|string|in:male,female,other',
        ]);

        // Update existing biography or create new one
        $user->biography 
            ? $user->biography->update($data) 
            : Biography::create(array_merge($data, ['user_id' => $user->id]));

        return redirect()
            ->route('biography.edit')
            ->with('success', 'Biography successfully saved!');
    }
}
