<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Models\DaftarRisiko;
use App\Models\Asset;
use App\Models\Agency;
use App\Models\KategoriRisiko;
use App\Models\User;
use App\Notifications\HighRiskRegisteredNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiskManagementController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user->agensi_id) {
            abort(403, 'User tidak dikaitkan dengan agensi');
        }

        $risks = DaftarRisiko::where('agensi_id', $user->agensi_id)
            ->with(['asset', 'kategoriRisiko', 'risiko'])
            ->paginate(15);
        return view('agency.risk.index', ['risks' => $risks]);
    }

    public function create()
    {
        $user = Auth::user();
        if (!$user->agensi_id) {
            abort(403, 'User tidak dikaitkan dengan agensi');
        }

        $assets = Asset::where('agensi_id', $user->agensi_id)->get();
        $kategoris = KategoriRisiko::all();

        return view('agency.risk.create', [
            'assets' => $assets,
            'kategoris' => $kategoris,
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->agensi_id) {
            abort(403, 'User tidak dikaitkan dengan agensi');
        }

        $riskScore = $request->impak * $request->kebarangkalian;
        $riskLevel = $this->calculateRiskLevel($riskScore);

        $risk = DaftarRisiko::create([
            'agensi_id' => $user->agensi_id,
            'aset_id' => $request->aset_id,
            'kategori_id' => $request->kategori_id,
            'sub_kategori_risiko_id' => $request->sub_kategori_risiko_id,
            'risiko_id' => $request->risiko_id,
            'punca_risiko_id' => $request->punca_risiko_id,
            'impak' => $request->impak,
            'kebarangkalian' => $request->kebarangkalian,
            'skor_risiko' => $riskScore,
            'tahap_risiko' => $riskLevel,
            'kawalan_sediada' => $request->kawalan_sediada,
            'plan_mitigasi' => $request->plan_mitigasi,
            'pemilik_risiko' => $request->pemilik_risiko
        ]);

        // Send notification to all admins if risk is high
        if ($riskLevel === 'Tinggi') {
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                try {
                    $admin->notify(new HighRiskRegisteredNotification($risk));
                } catch (\Exception $e) {
                    \Log::error('Failed to send high-risk notification: ' . $e->getMessage());
                }
            }
        }

        return redirect()->route('agency.risks.index')->with('success', 'Risiko berjaya didaftarkan');
    }

    public function show($id)
    {
        $user = Auth::user();
        if (!$user->agensi_id) {
            abort(403, 'User tidak dikaitkan dengan agensi');
        }

        $risk = DaftarRisiko::with([
            'agency',
            'asset',
            'kategoriRisiko',
            'subKategoriRisiko',
            'risiko',
            'puncaRisiko',
            'kategoriPuncaRisiko'
        ])->where('agensi_id', $user->agensi_id)->findOrFail($id);
        return view('agency.risk.show', ['risk' => $risk]);
    }

    public function edit($id)
    {
        $user = Auth::user();
        if (!$user->agensi_id) {
            abort(403, 'User tidak dikaitkan dengan agensi');
        }

        $risk = DaftarRisiko::where('agensi_id', $user->agensi_id)->findOrFail($id);
        $assets = Asset::where('agensi_id', $user->agensi_id)->get();
        $kategoris = KategoriRisiko::all();

        return view('agency.risk.edit', [
            'risk' => $risk,
            'assets' => $assets,
            'kategoris' => $kategoris,
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->agensi_id) {
            abort(403, 'User tidak dikaitkan dengan agensi');
        }

        $risk = DaftarRisiko::where('agensi_id', $user->agensi_id)->findOrFail($id);
        $risk->update([
            'aset_id' => $request->aset_id,
            'kategori_id' => $request->kategori_id,
            'sub_kategori_risiko_id' => $request->sub_kategori_risiko_id,
            'risiko_id' => $request->risiko_id,
            'punca_risiko_id' => $request->punca_risiko_id,
            'impak' => $request->impak,
            'kebarangkalian' => $request->kebarangkalian,
            'skor_risiko' => $request->impak * $request->kebarangkalian,
            'tahap_risiko' => $this->calculateRiskLevel($request->impak * $request->kebarangkalian),
            'kawalan_sediada' => $request->kawalan_sediada,
            'plan_mitigasi' => $request->plan_mitigasi,
            'pemilik_risiko' => $request->pemilik_risiko
        ]);
        return redirect()->route('agency.risks.index')->with('success', 'Risiko berjaya dikemaskini');
    }

    private function calculateRiskLevel($score)
    {
        if ($score >= 20) return 'Tinggi';
        if ($score >= 10) return 'Sederhana';
        return 'Rendah';
    }
}
