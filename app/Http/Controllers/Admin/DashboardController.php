<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use App\Models\DaftarRisiko;
use App\Models\Asset;
use App\Models\User;
use App\Models\Sektor;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $sektorId = $request->query('sektor_id');

        $query = Agency::query();
        if ($sektorId) {
            $query->where('sektor_id', $sektorId);
        }
        $agencies = $query->get();
        $agencyIds = $agencies->pluck('id')->toArray();

        // If sector selected, only count data from that sector's agencies
        if ($sektorId) {
            $totalAgencies = count($agencies);
            $totalAssets = Asset::whereIn('agensi_id', $agencyIds)->count();
            $totalRisks = DaftarRisiko::whereIn('agensi_id', $agencyIds)->count();
            $highRisks = DaftarRisiko::whereIn('agensi_id', $agencyIds)->where('tahap_risiko', 'Tinggi')->count();
            $mediumRisks = DaftarRisiko::whereIn('agensi_id', $agencyIds)->where('tahap_risiko', 'Sederhana')->count();
            $lowRisks = DaftarRisiko::whereIn('agensi_id', $agencyIds)->where('tahap_risiko', 'Rendah')->count();
        } else {
            // Show all data
            $totalAgencies = Agency::count();
            $totalAssets = Asset::count();
            $totalRisks = DaftarRisiko::count();
            $highRisks = DaftarRisiko::where('tahap_risiko', 'Tinggi')->count();
            $mediumRisks = DaftarRisiko::where('tahap_risiko', 'Sederhana')->count();
            $lowRisks = DaftarRisiko::where('tahap_risiko', 'Rendah')->count();
        }

        $totalUsers = User::count();
        $sektors = Sektor::all();

        return view('admin.dashboard', [
            'totalAgencies' => $totalAgencies,
            'totalAssets' => $totalAssets,
            'totalRisks' => $totalRisks,
            'totalUsers' => $totalUsers,
            'highRisks' => $highRisks,
            'mediumRisks' => $mediumRisks,
            'lowRisks' => $lowRisks,
            'sektors' => $sektors,
            'selectedSektor' => $sektorId
        ]);
    }
}
