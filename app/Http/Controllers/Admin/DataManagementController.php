<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use App\Models\KategoriRisiko;
use App\Models\SubKategoriRisiko;
use App\Models\Risiko;
use App\Models\PuncaRisiko;
use App\Models\JenisAset;
use App\Models\Sektor;
use Illuminate\Http\Request;

class DataManagementController extends Controller
{
    public function agencies()
    {
        $agencies = Agency::with('sektor')->paginate(15);
        return view('admin.data.agencies', ['agencies' => $agencies]);
    }

    public function riskCategories()
    {
        $categories = KategoriRisiko::withCount('subKategoriRisiko')->paginate(15);
        return view('admin.data.risk-categories', ['categories' => $categories]);
    }

    public function createRiskCategory()
    {
        return view('admin.data.create-risk-category');
    }

    public function storeRiskCategory(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255', 'unique:kategori_risiko,nama'],
        ]);

        KategoriRisiko::create($validated);
        return redirect()->route('admin.data.risk-categories')->with('success', 'Kategori risiko berjaya ditambahkan');
    }

    public function destroyRiskCategory($id)
    {
        $category = KategoriRisiko::findOrFail($id);

        if ($category->subKategoriRisiko()->exists()) {
            return redirect()->route('admin.data.risk-categories')
                ->with('error', 'Tidak boleh padam kategori risiko kerana ada sub-kategori yang berkaitan');
        }

        $category->delete();
        return redirect()->route('admin.data.risk-categories')->with('success', 'Kategori risiko berjaya dipadam');
    }

    public function subCategories()
    {
        $subCategories = SubKategoriRisiko::with('kategoriRisiko')->withCount('risikos')->paginate(15);
        return view('admin.data.sub-categories', ['subCategories' => $subCategories]);
    }

    public function createSubCategory()
    {
        $categories = KategoriRisiko::all();
        return view('admin.data.create-sub-category', ['categories' => $categories]);
    }

    public function storeSubCategory(Request $request)
    {
        $validated = $request->validate([
            'kategori_risiko_id' => ['required', 'exists:kategori_risiko,id'],
            'nama' => ['required', 'string', 'max:255'],
        ]);

        SubKategoriRisiko::create($validated);
        return redirect()->route('admin.data.sub-categories')->with('success', 'Sub-kategori risiko berjaya ditambahkan');
    }

    public function destroySubCategory($id)
    {
        $subCategory = SubKategoriRisiko::findOrFail($id);

        if ($subCategory->risiko()->exists()) {
            return redirect()->route('admin.data.sub-categories')
                ->with('error', 'Tidak boleh padam sub-kategori risiko kerana ada risiko yang berkaitan');
        }

        $subCategory->delete();
        return redirect()->route('admin.data.sub-categories')->with('success', 'Sub-kategori risiko berjaya dipadam');
    }

    public function risks()
    {
        $risks = Risiko::with('subKategoriRisiko.kategoriRisiko')->paginate(15);
        return view('admin.data.risks', ['risks' => $risks]);
    }

    public function createRisk()
    {
        $subCategories = SubKategoriRisiko::with('kategoriRisiko')->get();
        return view('admin.data.create-risk', ['subCategories' => $subCategories]);
    }

    public function storeRisk(Request $request)
    {
        $validated = $request->validate([
            'sub_kategori_risiko_id' => ['required', 'exists:sub_kategori_risiko,id'],
            'nama' => ['required', 'string', 'max:255'],
        ]);

        Risiko::create($validated);
        return redirect()->route('admin.data.risks')->with('success', 'Risiko berjaya ditambahkan');
    }

    public function destroyRisk($id)
    {
        $risk = Risiko::findOrFail($id);
        $risk->delete();
        return redirect()->route('admin.data.risks')->with('success', 'Risiko berjaya dipadam');
    }

    public function causes()
    {
        $causes = PuncaRisiko::with('kategoriRisiko')->paginate(15);
        return view('admin.data.causes', ['causes' => $causes]);
    }

    public function createCause()
    {
        $categories = KategoriRisiko::all();
        return view('admin.data.create-cause', ['categories' => $categories]);
    }

    public function storeCause(Request $request)
    {
        $validated = $request->validate([
            'kategori_risiko_id' => ['required', 'exists:kategori_risiko,id'],
            'nama' => ['required', 'string', 'max:255'],
        ]);

        PuncaRisiko::create($validated);
        return redirect()->route('admin.data.causes')->with('success', 'Punca risiko berjaya ditambahkan');
    }

    public function destroyCause($id)
    {
        $cause = PuncaRisiko::findOrFail($id);
        $cause->delete();
        return redirect()->route('admin.data.causes')->with('success', 'Punca risiko berjaya dipadam');
    }

    public function assetTypes()
    {
        $assets = JenisAset::withCount('assets')->paginate(15);
        return view('admin.data.asset-types', ['assets' => $assets]);
    }

    public function createAssetType()
    {
        return view('admin.data.create-asset-type');
    }

    public function storeAssetType(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255', 'unique:jenis_aset'],
        ]);

        JenisAset::create($validated);
        return redirect()->route('admin.data.asset-types')->with('success', 'Jenis aset berjaya ditambahkan');
    }

    public function destroyAssetType($id)
    {
        $assetType = JenisAset::findOrFail($id);

        if ($assetType->assets()->exists()) {
            return redirect()->route('admin.data.asset-types')
                ->with('error', 'Tidak boleh padam jenis aset kerana ada aset yang berkaitan');
        }

        $assetType->delete();
        return redirect()->route('admin.data.asset-types')->with('success', 'Jenis aset berjaya dipadam');
    }

    public function sectors()
    {
        $sectors = Sektor::withCount('agencies')->paginate(15);
        return view('admin.data.sectors', ['sectors' => $sectors]);
    }

    public function createSector()
    {
        return view('admin.data.create-sector');
    }

    public function storeSector(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255', 'unique:sektor,nama'],
            'create_agency' => ['boolean'],
            'nama_agensi' => ['required_if:create_agency,true', 'string', 'max:255'],
            'no_tel_agensi' => ['required_if:create_agency,true', 'string', 'max:20'],
            'website' => ['nullable', 'string', 'max:255'],
            'nama_pic' => ['required_if:create_agency,true', 'string', 'max:255'],
            'notel_pic' => ['required_if:create_agency,true', 'string', 'max:20'],
            'emel_pic' => ['required_if:create_agency,true', 'email', 'max:255'],
            'jenis_agensi' => ['required_if:create_agency,true', 'string', 'max:255'],
        ]);

        $sector = Sektor::create(['nama' => $validated['nama']]);

        if ($validated['create_agency'] ?? false) {
            Agency::create([
                'nama_agensi' => $validated['nama_agensi'],
                'no_tel_agensi' => $validated['no_tel_agensi'],
                'website' => $validated['website'] ?? null,
                'nama_pic' => $validated['nama_pic'],
                'notel_pic' => $validated['notel_pic'],
                'emel_pic' => $validated['emel_pic'],
                'sektor_id' => $sector->id,
                'jenis_agensi' => $validated['jenis_agensi'],
            ]);
        }

        return redirect()->route('admin.data.sectors')->with('success', 'Sektor dan agensi berjaya ditambahkan');
    }

    public function destroySector($id)
    {
        $sector = Sektor::findOrFail($id);

        if ($sector->agencies()->exists()) {
            return redirect()->route('admin.data.sectors')
                ->with('error', 'Tidak boleh padam sektor kerana ada agensi yang berkaitan');
        }

        $sector->delete();
        return redirect()->route('admin.data.sectors')->with('success', 'Sektor berjaya dipadam');
    }

    public function createAgency()
    {
        $sectors = Sektor::all();
        return view('admin.data.create-agency', ['sectors' => $sectors]);
    }

    public function storeAgency(Request $request)
    {
        $validated = $request->validate([
            'nama_agensi' => ['required', 'string', 'max:255'],
            'no_tel_agensi' => ['required', 'string', 'max:20'],
            'website' => ['nullable', 'string', 'max:255'],
            'nama_pic' => ['required', 'string', 'max:255'],
            'notel_pic' => ['required', 'string', 'max:20'],
            'emel_pic' => ['required', 'email', 'max:255'],
            'sektor_id' => ['required', 'exists:sektor,id'],
            'jenis_agensi' => ['required', 'string', 'max:255'],
        ]);

        Agency::create($validated);
        return redirect()->route('admin.data.agencies')->with('success', 'Agensi berjaya ditambahkan');
    }

    public function editAgency($id)
    {
        $agency = Agency::findOrFail($id);
        $sectors = Sektor::all();
        return view('admin.data.edit-agency', ['agency' => $agency, 'sectors' => $sectors]);
    }

    public function updateAgency(Request $request, $id)
    {
        $agency = Agency::findOrFail($id);

        $validated = $request->validate([
            'nama_agensi' => ['required', 'string', 'max:255'],
            'no_tel_agensi' => ['required', 'string', 'max:20'],
            'website' => ['nullable', 'string', 'max:255'],
            'nama_pic' => ['required', 'string', 'max:255'],
            'notel_pic' => ['required', 'string', 'max:20'],
            'emel_pic' => ['required', 'email', 'max:255'],
            'sektor_id' => ['required', 'exists:sektor,id'],
            'jenis_agensi' => ['required', 'string', 'max:255'],
        ]);

        $agency->update($validated);
        return redirect()->route('admin.data.agencies')->with('success', 'Agensi berjaya dikemas kini');
    }

    public function destroyAgency($id)
    {
        $agency = Agency::findOrFail($id);

        if ($agency->assets()->exists() || $agency->daftarRisikos()->exists()) {
            return redirect()->route('admin.data.agencies')
                ->with('error', 'Tidak boleh padam agensi kerana ada data yang berkaitan');
        }

        $agency->delete();
        return redirect()->route('admin.data.agencies')->with('success', 'Agensi berjaya dipadam');
    }
}
