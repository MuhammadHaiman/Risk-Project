<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use App\Models\DaftarRisiko;
use App\Models\Asset;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get agency from user's agensi_id
        if (!$user->agensi_id) {
            abort(403, 'User tidak dikaitkan dengan agensi');
        }

        $agency = Agency::findOrFail($user->agensi_id);

        $totalAssets = Asset::where('agensi_id', $agency->id)->count();
        $totalRisks = DaftarRisiko::where('agensi_id', $agency->id)->count();

        $highRisks = DaftarRisiko::where('agensi_id', $agency->id)
            ->where('tahap_risiko', 'Tinggi')->count();
        $mediumRisks = DaftarRisiko::where('agensi_id', $agency->id)
            ->where('tahap_risiko', 'Sederhana')->count();
        $lowRisks = DaftarRisiko::where('agensi_id', $agency->id)
            ->where('tahap_risiko', 'Rendah')->count();

        return view('agency.dashboard', [
            'agency' => $agency,
            'totalAssets' => $totalAssets,
            'totalRisks' => $totalRisks,
            'highRisks' => $highRisks,
            'mediumRisks' => $mediumRisks,
            'lowRisks' => $lowRisks
        ]);
    }
}
