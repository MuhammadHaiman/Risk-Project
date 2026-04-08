<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DaftarRisiko;
use App\Models\Agency;
use App\Models\Asset;
use Illuminate\Http\Request;

class RiskManagementController extends Controller
{
    public function index()
    {
        $risks = DaftarRisiko::with(['agency', 'asset', 'kategoriRisiko', 'risiko'])->paginate(15);
        return view('admin.risk.index', ['risks' => $risks]);
    }

    public function show($id)
    {
        $risk = DaftarRisiko::with([
            'agency',
            'asset',
            'kategoriRisiko',
            'subKategoriRisiko',
            'risiko',
            'puncaRisiko',
            'kategoriPuncaRisiko'
        ])->findOrFail($id);
        return view('admin.risk.show', ['risk' => $risk]);
    }

    public function edit($id)
    {
        $risk = DaftarRisiko::findOrFail($id);
        return view('admin.risk.edit', ['risk' => $risk]);
    }

    public function update(Request $request, $id)
    {
        $risk = DaftarRisiko::findOrFail($id);
        $risk->update($request->all());
        return redirect()->route('admin.risks.index')->with('success', 'Risiko berjaya dikemaskini');
    }
}
