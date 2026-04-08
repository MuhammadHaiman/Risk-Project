<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Models\DaftarRisiko;
use App\Models\Agency;
use App\Models\Sektor;
use App\Exports\HighestRiskReportExport;
use App\Exports\AssetHighestRisksExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return $this->getAllRisks();
        }

        if (!$user->agensi_id) {
            abort(403, 'User tidak dikaitkan dengan agensi');
        }

        $risks = DaftarRisiko::where('agensi_id', $user->agensi_id)
            ->with(['asset', 'kategoriRisiko', 'risiko'])
            ->paginate(15);
        return view('agency.report.index', ['risks' => $risks]);
    }

    public function getAllRisks()
    {
        $sectors = Sektor::all();
        $selectedSector = request('sector');

        $risksQuery = DaftarRisiko::with(['asset', 'kategoriRisiko', 'risiko', 'agency.sektor']);

        if ($selectedSector) {
            $risksQuery->whereHas('agency.sektor', function ($q) use ($selectedSector) {
                $q->where('id', $selectedSector);
            });
        }

        $risks = $risksQuery->paginate(15);

        return view('agency.report.all-risks', [
            'risks' => $risks,
            'sectors' => $sectors,
            'selectedSector' => $selectedSector
        ]);
    }

    public function highestRiskReport()
    {
        $user = Auth::user();
        $sectors = Sektor::all();
        $selectedSector = request('sector');

        if ($user->role === 'admin') {
            return $this->highestRiskReportAdmin($selectedSector);
        }

        if (!$user->agensi_id) {
            abort(403, 'User tidak dikaitkan dengan agensi');
        }

        // Get the most frequently registered risks for this agency
        $highestRisks = DaftarRisiko::where('agensi_id', $user->agensi_id)
            ->select('risiko_id', DB::raw('COUNT(*) as frequency'), 'sub_kategori_risiko_id')
            ->with('risiko.subKategoriRisiko')
            ->groupBy('risiko_id', 'sub_kategori_risiko_id')
            ->orderByDesc('frequency')
            ->paginate(10);

        return view('agency.report.highest-risk', [
            'highestRisks' => $highestRisks,
            'agency' => Auth::user(),
            'isAdmin' => false
        ]);
    }

    private function highestRiskReportAdmin($selectedSector = null)
    {
        $sectors = Sektor::all();
        $selectedAgency = request('agency');

        $agenciesQuery = Agency::query();

        if ($selectedSector) {
            $agenciesQuery->where('sektor_id', $selectedSector);
        }

        $agencies = $agenciesQuery->get();
        $allAgencies = Agency::all();

        // Get highest risks per agency
        $highestRisksByAgency = [];
        foreach ($agencies as $agency) {
            $risks = DaftarRisiko::where('agensi_id', $agency->id)
                ->select('risiko_id', DB::raw('COUNT(*) as frequency'), 'sub_kategori_risiko_id')
                ->with('risiko.subKategoriRisiko')
                ->groupBy('risiko_id', 'sub_kategori_risiko_id')
                ->orderByDesc('frequency')
                ->limit(5)
                ->get();

            // If specific agency filter is applied, show only that agency
            if ($selectedAgency && $agency->id != $selectedAgency) {
                continue;
            }

            $highestRisksByAgency[$agency->id] = [
                'agency' => $agency,
                'risks' => $risks
            ];
        }

        return view('agency.report.highest-risk-admin', [
            'highestRisksByAgency' => $highestRisksByAgency,
            'sectors' => $sectors,
            'agencies' => $allAgencies,
            'displayAgencies' => $agencies,
            'selectedSector' => $selectedSector,
            'selectedAgency' => $selectedAgency,
            'isAdmin' => true
        ]);
    }

    public function assetWithHighestRisksReport()
    {
        $user = Auth::user();
        $sectors = Sektor::all();
        $selectedSector = request('sector');

        if ($user->role === 'admin') {
            return $this->assetWithHighestRisksReportAdmin($selectedSector);
        }

        if (!$user->agensi_id) {
            abort(403, 'User tidak dikaitkan dengan agensi');
        }

        // Get assets with highest risk count for this agency
        $assetRiskCounts = DaftarRisiko::where('agensi_id', $user->agensi_id)
            ->select('aset_id', DB::raw('COUNT(*) as risk_count'))
            ->with('asset')
            ->groupBy('aset_id')
            ->orderByDesc('risk_count')
            ->paginate(10);

        return view('agency.report.asset-highest-risks', [
            'assetRiskCounts' => $assetRiskCounts,
            'agency' => Auth::user(),
            'isAdmin' => false
        ]);
    }

    private function assetWithHighestRisksReportAdmin($selectedSector = null)
    {
        $sectors = Sektor::all();
        $selectedAgency = request('agency');

        $agenciesQuery = Agency::query();

        if ($selectedSector) {
            $agenciesQuery->where('sektor_id', $selectedSector);
        }

        $agencies = $agenciesQuery->get();
        $allAgencies = Agency::all();

        // Get asset risk counts per agency
        $assetRisksByAgency = [];
        foreach ($agencies as $agency) {
            $assets = DaftarRisiko::where('agensi_id', $agency->id)
                ->select('aset_id', DB::raw('COUNT(*) as risk_count'))
                ->with('asset')
                ->groupBy('aset_id')
                ->orderByDesc('risk_count')
                ->limit(5)
                ->get();

            // If specific agency filter is applied, show only that agency
            if ($selectedAgency && $agency->id != $selectedAgency) {
                continue;
            }

            $assetRisksByAgency[$agency->id] = [
                'agency' => $agency,
                'assets' => $assets
            ];
        }

        return view('agency.report.asset-highest-risks-admin', [
            'assetRisksByAgency' => $assetRisksByAgency,
            'sectors' => $sectors,
            'agencies' => $allAgencies,
            'displayAgencies' => $agencies,
            'selectedSector' => $selectedSector,
            'selectedAgency' => $selectedAgency,
            'isAdmin' => true
        ]);
    }

    public function byAsset($assetId)
    {
        $user = Auth::user();
        if (!$user->agensi_id) {
            abort(403, 'User tidak dikaitkan dengan agensi');
        }

        $risks = DaftarRisiko::where('agensi_id', $user->agensi_id)
            ->where('aset_id', $assetId)
            ->with(['asset', 'kategoriRisiko'])
            ->paginate(15);
        return view('agency.report.by-asset', ['risks' => $risks]);
    }

    // Export Methods
    public function exportHighestRiskPdf()
    {
        $user = Auth::user();
        $agency = $user->agensi_id ? Agency::find($user->agensi_id) : null;
        $title = 'Laporan Risiko Tertinggi';

        if ($user->role === 'admin') {
            $selectedSector = request('sector');
            $selectedAgency = request('agency');
            $agencies = $this->getAgenciesForSector($selectedSector);
            $highestRisksByAgency = $this->getHighestRisksByAgency($agencies);

            // Filter by specific agency if provided
            if ($selectedAgency) {
                $highestRisksByAgency = array_filter($highestRisksByAgency, function ($item) use ($selectedAgency) {
                    return $item['agency']->id == $selectedAgency;
                });
            }

            $pdf = Pdf::loadView('reports.pdfs.highest-risk-admin', [
                'highestRisksByAgency' => $highestRisksByAgency,
                'title' => $title
            ]);
        } else {
            if (!$user->agensi_id) {
                abort(403, 'User tidak dikaitkan dengan agensi');
            }

            $highestRisks = DaftarRisiko::where('agensi_id', $user->agensi_id)
                ->select('risiko_id', DB::raw('COUNT(*) as frequency'), 'sub_kategori_risiko_id')
                ->with('risiko.subKategoriRisiko')
                ->groupBy('risiko_id', 'sub_kategori_risiko_id')
                ->orderByDesc('frequency')
                ->get();
            // untuk tgk mcm mna pdf tu
            $pdf = Pdf::loadView('reports.pdfs.highest-risk', [
                'highestRisks' => $highestRisks,
                'title' => $title
            ]);
        }

        return $pdf->download('laporan-risiko-tertinggi' . $agency->nama_agensi . date('Y-m-d') . '.pdf');
    }

    public function exportHighestRiskExcel()
    {
        $user = Auth::user();
        $agency = $user->agensi_id ? Agency::find($user->agensi_id) : null;

        if ($user->role === 'admin') {
            $selectedSector = request('sector');
            $selectedAgency = request('agency');
            $agencies = $this->getAgenciesForSector($selectedSector);
            $highestRisksByAgency = $this->getHighestRisksByAgency($agencies);

            // Filter by specific agency if provided
            if ($selectedAgency) {
                $highestRisksByAgency = array_filter($highestRisksByAgency, function ($item) use ($selectedAgency) {
                    return $item['agency']->id == $selectedAgency;
                });
            }

            $data = [];
            foreach ($highestRisksByAgency as $agencyId => $info) {
                foreach ($info['risks'] as $risk) {
                    $data[] = [
                        'risiko_nama' => $risk->risiko->nama ?? '',
                        'sub_kategori' => $risk->risiko->subKategoriRisiko->nama ?? '',
                        'frequency' => $risk->frequency,
                        'agensi' => $info['agency']->nama_agensi
                    ];
                }
            }

            return Excel::download(
                new HighestRiskReportExport($data),
                'laporan-risiko-tertinggi' . $agency->nama_agensi . date('Y-m-d') . '.xlsx'
            );
        } else {
            if (!$user->agensi_id) {
                abort(403, 'User tidak dikaitkan dengan agensi');
            }

            $highestRisks = DaftarRisiko::where('agensi_id', $user->agensi_id)
                ->select('risiko_id', DB::raw('COUNT(*) as frequency'), 'sub_kategori_risiko_id')
                ->with('risiko.subKategoriRisiko')
                ->groupBy('risiko_id', 'sub_kategori_risiko_id')
                ->orderByDesc('frequency')
                ->get()
                ->map(function ($item) {
                    return [
                        'risiko_nama' => $item->risiko->nama ?? '',
                        'sub_kategori' => $item->risiko->subKategoriRisiko->nama ?? '',
                        'frequency' => $item->frequency
                    ];
                });

            return Excel::download(
                new HighestRiskReportExport($highestRisks),
                'laporan-risiko-tertinggi' . $agency->nama_agensi . date('Y-m-d') . '.xlsx'
            );
        }
    }

    public function exportAssetHighestRisksPdf()
    {
        $user = Auth::user();
        $agency = $user->agensi_id ? Agency::find($user->agensi_id) : null;
        $title = 'Laporan Aset dengan Risiko Tertinggi';

        if ($user->role === 'admin') {
            $selectedSector = request('sector');
            $selectedAgency = request('agency');
            $agencies = $this->getAgenciesForSector($selectedSector);
            $assetRisksByAgency = $this->getAssetRisksByAgency($agencies);

            // Filter by specific agency if provided
            if ($selectedAgency) {
                $assetRisksByAgency = array_filter($assetRisksByAgency, function ($item) use ($selectedAgency) {
                    return $item['agency']->id == $selectedAgency;
                });
            }

            $pdf = Pdf::loadView('reports.pdfs.asset-highest-risks-admin', [
                'assetRisksByAgency' => $assetRisksByAgency,
                'title' => $title
            ]);
        } else {
            if (!$user->agensi_id) {
                abort(403, 'User tidak dikaitkan dengan agensi');
            }

            $assetRiskCounts = DaftarRisiko::where('agensi_id', $user->agensi_id)
                ->select('aset_id', DB::raw('COUNT(*) as risk_count'))
                ->with('asset')
                ->groupBy('aset_id')
                ->orderByDesc('risk_count')
                ->get();

            $pdf = Pdf::loadView('reports.pdfs.asset-highest-risks', [
                'assetRiskCounts' => $assetRiskCounts,
                'title' => $title
            ]);
        }

        return $pdf->download('laporan-aset-risiko-tertinggi' . $agency->nama_agensi . date('Y-m-d') . '.pdf');
    }

    public function exportAssetHighestRisksExcel()
    {
        $user = Auth::user();
        $agency = $user->agensi_id ? Agency::find($user->agensi_id) : null;

        if ($user->role === 'admin') {
            $selectedSector = request('sector');
            $selectedAgency = request('agency');
            $agencies = $this->getAgenciesForSector($selectedSector);
            $assetRisksByAgency = $this->getAssetRisksByAgency($agencies);

            // Filter by specific agency if provided
            if ($selectedAgency) {
                $assetRisksByAgency = array_filter($assetRisksByAgency, function ($item) use ($selectedAgency) {
                    return $item['agency']->id == $selectedAgency;
                });
            }

            $data = [];
            foreach ($assetRisksByAgency as $agencyId => $info) {
                foreach ($info['assets'] as $asset) {
                    $data[] = [
                        'asset_nama' => $asset->asset->nama_aset ?? '',
                        'jenis_aset' => $asset->asset->jenisAset->nama ?? '',
                        'risk_count' => $asset->risk_count,
                        'agensi' => $info['agency']->nama_agensi
                    ];
                }
            }

            return Excel::download(
                new AssetHighestRisksExport($data),
                'laporan-aset-risiko-tertinggi' . $agency->nama_agensi . date('Y-m-d') . '.xlsx'
            );
        } else {
            if (!$user->agensi_id) {
                abort(403, 'User tidak dikaitkan dengan agensi');
            }

            $assetRiskCounts = DaftarRisiko::where('agensi_id', $user->agensi_id)
                ->select('aset_id', DB::raw('COUNT(*) as risk_count'))
                ->with('asset')
                ->groupBy('aset_id')
                ->orderByDesc('risk_count')
                ->get()
                ->map(function ($item) {
                    return [
                        'asset_nama' => $item->asset->nama_aset ?? '',
                        'jenis_aset' => $item->asset->jenisAset->nama ?? '',
                        'risk_count' => $item->risk_count
                    ];
                });

            return Excel::download(
                // new tu utk hantr dkt export
                new AssetHighestRisksExport($assetRiskCounts),
                'laporan-aset-risiko-tertinggi' . $agency->nama_agensi . date('Y-m-d') . '.xlsx'
            );
        }
    }

    // Helper methods
    private function getAgenciesForSector($selectedSector = null)
    {
        $agenciesQuery = Agency::query();

        if ($selectedSector) {
            $agenciesQuery->where('sektor_id', $selectedSector);
        }

        return $agenciesQuery->get();
    }

    private function getHighestRisksByAgency($agencies)
    {
        $highestRisksByAgency = [];
        foreach ($agencies as $agency) {
            $risks = DaftarRisiko::where('agensi_id', $agency->id)
                ->select('risiko_id', DB::raw('COUNT(*) as frequency'), 'sub_kategori_risiko_id')
                ->with('risiko.subKategoriRisiko')
                ->groupBy('risiko_id', 'sub_kategori_risiko_id')
                ->orderByDesc('frequency')
                ->limit(5)
                ->get();

            $highestRisksByAgency[$agency->id] = [
                'agency' => $agency,
                'risks' => $risks
            ];
        }

        return $highestRisksByAgency;
    }

    private function getAssetRisksByAgency($agencies)
    {
        $assetRisksByAgency = [];
        foreach ($agencies as $agency) {
            $assets = DaftarRisiko::where('agensi_id', $agency->id)
                ->select('aset_id', DB::raw('COUNT(*) as risk_count'))
                ->with('asset')
                ->groupBy('aset_id')
                ->orderByDesc('risk_count')
                ->limit(5)
                ->get();

            $assetRisksByAgency[$agency->id] = [
                'agency' => $agency,
                'assets' => $assets
            ];
        }

        return $assetRisksByAgency;
    }
}
