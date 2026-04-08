<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DaftarRisiko;
use App\Models\Agency;
use App\Models\Sektor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\HighestRiskReportExport;
use App\Exports\AssetHighestRisksExport;

class ReportController extends Controller
{
    public function index()
    {
        $risks = DaftarRisiko::with(['agency', 'asset', 'kategoriRisiko'])->paginate(15);
        return view('admin.report.index', ['risks' => $risks]);
    }

    public function byAgency($agencyId)
    {
        $agency = Agency::findOrFail($agencyId);
        $risks = DaftarRisiko::where('agensi_id', $agencyId)
            ->with(['asset', 'kategoriRisiko', 'risiko'])
            ->paginate(15);
        return view('admin.report.by-agency', ['agency' => $agency, 'risks' => $risks]);
    }

    public function byRiskLevel($level)
    {
        $risks = DaftarRisiko::where('tahap_risiko', $level)
            ->with(['agency', 'asset', 'kategoriRisiko'])
            ->paginate(15);
        return view('admin.report.by-level', ['level' => $level, 'risks' => $risks]);
    }

    public function highestRiskReport()
    {
        $sectors = Sektor::all();
        $selectedSector = request('sector');
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

        return view('admin.report.highest-risk', [
            'highestRisksByAgency' => $highestRisksByAgency,
            'sectors' => $sectors,
            'agencies' => $allAgencies,
            'selectedSector' => $selectedSector,
            'selectedAgency' => $selectedAgency,
            'isAdmin' => true
        ]);
    }

    public function assetWithHighestRisksReport()
    {
        $sectors = Sektor::all();
        $selectedSector = request('sector');
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

        return view('admin.report.asset-highest-risks', [
            'assetRisksByAgency' => $assetRisksByAgency,
            'sectors' => $sectors,
            'agencies' => $allAgencies,
            'selectedSector' => $selectedSector,
            'selectedAgency' => $selectedAgency,
            'isAdmin' => true
        ]);
    }

    public function exportHighestRiskPdf()
    {
        $selectedSector = request('sector');
        $selectedAgency = request('agency');

        $agenciesQuery = Agency::query();
        if ($selectedSector) {
            $agenciesQuery->where('sektor_id', $selectedSector);
        }

        $agencies = $agenciesQuery->get();
        $highestRisksByAgency = [];

        foreach ($agencies as $agency) {
            $risks = DaftarRisiko::where('agensi_id', $agency->id)
                ->select('risiko_id', DB::raw('COUNT(*) as frequency'), 'sub_kategori_risiko_id')
                ->with('risiko.subKategoriRisiko')
                ->groupBy('risiko_id', 'sub_kategori_risiko_id')
                ->orderByDesc('frequency')
                ->limit(5)
                ->get();

            if ($selectedAgency && $agency->id != $selectedAgency) {
                continue;
            }

            $highestRisksByAgency[$agency->id] = [
                'agency' => $agency,
                'risks' => $risks
            ];
        }

        $pdf = Pdf::loadView('admin.report.pdfs.highest-risk', [
            'highestRisksByAgency' => $highestRisksByAgency,
            'title' => 'Laporan Risiko Tertinggi'
        ]);

        return $pdf->download('laporan-risiko-tertinggi.pdf');
    }

    public function exportHighestRiskExcel()
    {
        $selectedSector = request('sector');
        $selectedAgency = request('agency');

        $agenciesQuery = Agency::query();
        if ($selectedSector) {
            $agenciesQuery->where('sektor_id', $selectedSector);
        }

        $agencies = $agenciesQuery->get();
        $highestRisksByAgency = [];

        foreach ($agencies as $agency) {
            $risks = DaftarRisiko::where('agensi_id', $agency->id)
                ->select('risiko_id', DB::raw('COUNT(*) as frequency'), 'sub_kategori_risiko_id')
                ->with('risiko.subKategoriRisiko')
                ->groupBy('risiko_id', 'sub_kategori_risiko_id')
                ->orderByDesc('frequency')
                ->limit(5)
                ->get();

            if ($selectedAgency && $agency->id != $selectedAgency) {
                continue;
            }

            $highestRisksByAgency[$agency->id] = [
                'agency' => $agency,
                'risks' => $risks
            ];
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
            'laporan-risiko-tertinggi.xlsx'
        );
    }

    public function exportAssetHighestRisksPdf()
    {
        $selectedSector = request('sector');
        $selectedAgency = request('agency');

        $agenciesQuery = Agency::query();
        if ($selectedSector) {
            $agenciesQuery->where('sektor_id', $selectedSector);
        }

        $agencies = $agenciesQuery->get();
        $assetRisksByAgency = [];

        foreach ($agencies as $agency) {
            $assets = DaftarRisiko::where('agensi_id', $agency->id)
                ->select('aset_id', DB::raw('COUNT(*) as risk_count'))
                ->with('asset')
                ->groupBy('aset_id')
                ->orderByDesc('risk_count')
                ->limit(5)
                ->get();

            if ($selectedAgency && $agency->id != $selectedAgency) {
                continue;
            }

            $assetRisksByAgency[$agency->id] = [
                'agency' => $agency,
                'assets' => $assets
            ];
        }

        $pdf = Pdf::loadView('admin.report.pdfs.asset-highest-risks', [
            'assetRisksByAgency' => $assetRisksByAgency,
            'title' => 'Laporan Aset dengan Risiko Tertinggi'
        ]);

        return $pdf->download('laporan-aset-risiko-tertinggi' . date('Y-m-d') . '.pdf');
    }

    public function exportAssetHighestRisksExcel()
    {
        $selectedSector = request('sector');
        $selectedAgency = request('agency');

        $agenciesQuery = Agency::query();
        if ($selectedSector) {
            $agenciesQuery->where('sektor_id', $selectedSector);
        }

        $agencies = $agenciesQuery->get();
        $assetRisksByAgency = [];

        foreach ($agencies as $agency) {
            $assets = DaftarRisiko::where('agensi_id', $agency->id)
                ->select('aset_id', DB::raw('COUNT(*) as risk_count'))
                ->with('asset')
                ->groupBy('aset_id')
                ->orderByDesc('risk_count')
                ->limit(5)
                ->get();

            if ($selectedAgency && $agency->id != $selectedAgency) {
                continue;
            }

            $assetRisksByAgency[$agency->id] = [
                'agency' => $agency,
                'assets' => $assets
            ];
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
            'laporan-aset-risiko-tertinggi.xlsx'
        );
    }
}
