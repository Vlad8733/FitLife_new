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
        return view('biography.edit', [
            'user' => $user,
            'biography' => $user->biography
        ]);
    }

    public function store(Request $request)
    {
        return $this->update($request);
    }


    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'full_name' => 'nullable|string|max:255',
            'age'       => 'nullable|integer|min:1',
            'height'    => 'nullable|numeric|min:0',
            'weight'    => 'nullable|numeric|min:0',
            'gender'    => 'nullable|string|in:male,female,other',
        ]);

        $user->biography
            ? $user->biography->update($data)
            : Biography::create(array_merge($data, ['user_id' => $user->id]));

        return redirect()
            ->route('biography.edit')
            ->with('success', 'Biography successfully saved!');
    }
}
