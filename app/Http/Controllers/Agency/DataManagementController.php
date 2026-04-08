<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\Agency;
use App\Models\Sektor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DataManagementController extends Controller
{
    public function assets()
    {
        $user = Auth::user();
        if (!$user->agensi_id) {
            abort(403, 'User tidak dikaitkan dengan agensi');
        }

        $assets = Asset::where('agensi_id', $user->agensi_id)
            ->with('jenisAset')
            ->paginate(15);
        return view('agency.data.assets', ['assets' => $assets]);
    }

    public function createAsset()
    {
        $jenisAssets = \App\Models\JenisAset::all();
        return view('agency.data.create-asset', ['jenisAssets' => $jenisAssets]);
    }

    public function storeAsset(Request $request)
    {
        $user = Auth::user();
        if (!$user->agensi_id) {
            abort(403, 'User tidak dikaitkan dengan agensi');
        }

        Asset::create([
            'agensi_id' => $user->agensi_id,
            'id_jenis_aset' => $request->id_jenis_aset,
            'nama_aset' => $request->nama_aset
        ]);
        return redirect()->route('agency.data.assets')->with('success', 'Aset berjaya ditambahkan');
    }

    public function agencies()
    {
        $user = Auth::user();
        if (!$user->agensi_id) {
            abort(403, 'User tidak dikaitkan dengan agensi');
        }

        $currentAgency = Agency::find($user->agensi_id);
        $agencies = Agency::where('sektor_id', $currentAgency->sektor_id)
            ->with('sektor')
            ->paginate(15);

        return view('agency.data.agencies', ['agencies' => $agencies, 'sektorId' => $currentAgency->sektor_id]);
    }

    public function createAgency()
    {
        $user = Auth::user();
        if (!$user->agensi_id) {
            abort(403, 'User tidak dikaitkan dengan agensi');
        }

        $currentAgency = Agency::find($user->agensi_id);
        $sektor = Sektor::find($currentAgency->sektor_id);

        return view('agency.data.create-agency', ['sektor' => $sektor]);
    }

    public function storeAgency(Request $request)
    {
        $user = Auth::user();
        if (!$user->agensi_id) {
            abort(403, 'User tidak dikaitkan dengan agensi');
        }

        $currentAgency = Agency::find($user->agensi_id);

        $validated = $request->validate([
            'nama_agensi' => ['required', 'string', 'max:255'],
            'no_tel_agensi' => ['required', 'string', 'max:20'],
            'website' => ['nullable', 'string', 'max:255'],
            'nama_pic' => ['required', 'string', 'max:255'],
            'notel_pic' => ['required', 'string', 'max:20'],
            'emel_pic' => ['required', 'email', 'max:255'],
            'jenis_agensi' => ['required', 'string', 'max:255'],
        ]);

        Agency::create([
            'nama_agensi' => $validated['nama_agensi'],
            'no_tel_agensi' => $validated['no_tel_agensi'],
            'website' => $validated['website'] ?? null,
            'nama_pic' => $validated['nama_pic'],
            'notel_pic' => $validated['notel_pic'],
            'emel_pic' => $validated['emel_pic'],
            'sektor_id' => $currentAgency->sektor_id,
            'jenis_agensi' => $validated['jenis_agensi'],
        ]);

        return redirect()->route('agency.data.agencies')->with('success', 'Agensi berjaya ditambahkan');
    }
}
