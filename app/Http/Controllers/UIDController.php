<?php

namespace App\Http\Controllers;

use App\Models\Uid;
use Illuminate\Http\Request;

class UIDController extends Controller
{
    public function index()
    {
        $uids = Uid::with(['siswa:id,name'])->get();

        return view('datauid', compact('uids'));
    }

    public function updateName(Request $request)
    {
        $validated = $request->validate([
            'uid_id' => 'required|integer|exists:uid,id',
            'name' => 'required|string|min:2|max:255',
        ]);

        // Ensure we get a single Uid model instance (not a collection) and not null
        $uid = Uid::query()->findOrFail($validated['uid_id']);
        $uid->name = $validated['name'];
        $uid->save();

        return response()->json([
            'success' => true,
            'uid' => [
                'id' => $uid->id,
                'uid' => $uid->uid,
                'name' => $uid->name,
            ],
        ]);
    }
}
