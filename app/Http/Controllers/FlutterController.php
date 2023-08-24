<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FlutterController extends Controller
{
    public function getMigration()
    {
        $migrations = DB::table('migrations')->get();
        return response()->json($migrations);
    }
}
