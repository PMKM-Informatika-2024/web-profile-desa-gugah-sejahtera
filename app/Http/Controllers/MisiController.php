<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;

class MisiController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|unique:profiles,title',
            'description' => 'required'
        ]);

        Profile::create([
            ...$data,
            'type' => 'misi'
        ]);

        return back();
    }

    public function update(Request $request)
    {
        $misi = Profile::query()->findOrFail($request->id);

        $misi->update($request->except("id"));

        return back();
    }

    public function destroy(Profile $id)
    {
        $id->delete();

        return back();
    }
}