<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Biography;

class BiographyController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $biography = $user->biography;
        return view('biography.edit', compact('user', 'biography'));
    }

public function update(Request $request)
{
    $user = Auth::user();

    $data = $request->validate([
        'full_name' => 'nullable|string|max:255',
        'age' => 'nullable|integer|min:1',
        'height' => 'nullable|numeric|min:0',
        'weight' => 'nullable|numeric|min:0',
        'gender' => 'nullable|string|in:male,female,other',
    ]);

    $biography = $user->biography;

    if ($biography) {
        $biography->update($data);
    } else {
        $data['user_id'] = $user->id;
        Biography::create($data);
    }

    return redirect()->route('biography.edit')->with('success', 'Biography updated successfully!');
}

}
