<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * Mendapatkan semua fakultas
     */
    public function getAllFakultas()
    {
        $fakultas = Fakultas::all();
        return response()->json($fakultas);
    }
}
