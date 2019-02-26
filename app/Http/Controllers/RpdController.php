<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class RpdController extends Controller
{
    public function insertDetail($rkaklid)
    {
        $rpd = DB::table('rkakl')
                        ->where('id' , $rkaklid)
                        ->first();

        $data_rkakl = DB::table('rkakl')->where('no_mak_sys' , 'LIKE' , '%' . $rpd->no_mak_sys  . '%')->get();
        foreach ($data_rkakl as $key => $value) {
            
        }
    }
}
