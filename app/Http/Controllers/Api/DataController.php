<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KategoriRisiko;
use App\Models\SubKategoriRisiko;
use App\Models\Risiko;
use App\Models\PuncaRisiko;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function getSubCategories($kategoriId)
    {
        $subCategories = SubKategoriRisiko::where('kategori_risiko_id', $kategoriId)
            ->select('id', 'nama')
            ->get();

        return response()->json($subCategories);
    }

    public function getRisks($subCategoryId)
    {
        $risks = Risiko::where('sub_kategori_risiko_id', $subCategoryId)
            ->select('id', 'nama')
            ->get();

        return response()->json($risks);
    }

    public function getCauses($kategoriId)
    {
        $causes = PuncaRisiko::where('kategori_risiko_id', $kategoriId)
            ->select('id', 'nama')
            ->get();

        return response()->json($causes);
    }
}
