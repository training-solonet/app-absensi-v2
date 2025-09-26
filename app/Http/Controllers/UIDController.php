<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Uid;
use Illuminate\Http\Request;

class UIDController extends Controller
{
    public function index()
    {
        $uids = Uid::with(['siswa:id,name'])->get();
        $siswas = Siswa::query()->select('id', 'name')->orderBy('name')->get();

        return view('datauid', compact('uids', 'siswas'));
    }

    public function updateName(Request $request)
    {
        $validated = $request->validate([
            // validate against the correct connection/table names
            'uid_id' => 'required|integer|exists:absensi_v2.uid,id',
            'siswa_id' => 'required|integer|exists:siswa_connectis.view_siswa,id',
        ]);

        // Ensure we get a single Uid model instance (not a collection) and not null
        /** @var Uid $uid */
        $uid = Uid::query()->findOrFail($validated['uid_id']);
        $uid->id_siswa = $validated['siswa_id'];
        // Optional: also mirror the siswa name into uid.name for backward compatibility
        /** @var Siswa|null $siswa */
        $siswa = Siswa::find((int) $validated['siswa_id']);
        if ($siswa) {
            $uid->name = $siswa->name;
        }
        $uid->save();

        return response()->json([
            'success' => true,
            'uid' => [
                'id' => $uid->id,
                'uid' => $uid->uid,
                'name' => $uid->name,
                'siswa' => $siswa ? ['id' => $siswa->id, 'name' => $siswa->name] : null,
            ],
        ]);
    }
}
