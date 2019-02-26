<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class RpkController extends Controller
{
    public function memuat_program()
    {
        $parameter = DB::table('parameter')->where('nama' , 'Tahun Anggaran')->first();
        $satkeruser = DB::table('satker_user')->where('user_id' , CRUDBooster::MyId())->first();
        $data_rkakl = DB::table('rkakl')->where('level' , 9)
                                        ->where('thnang' , $parameter->nilai)
                                        ->where('satker_id' , $satkeruser->satker_id)
                                        ->first();

        return $data_rkakl;
    }
    public function memuat_output($id)
    {
        if($id == 0)
        {
            $data = DB::table('rkakl')->where('level' , 8)->get();
        }
        else
        {
            $rpk = DB::table('m_rpk')->where('id' , $id)->first();
            $data = DB::table('rkakl')->where('id' , $rpk->kode_8)->get();
        }
        

        return $data;
    }
    public function memuat_suboutput($idkode8)
    {
        $output = DB::table('rkakl')
                        ->where('id' , $idkode8)
                        ->first();
        
        $data = DB::table('rkakl')
                        ->where('no_mak_sys' , 'LIKE' , '%' . $output->no_mak_sys . '%')
                        ->where('level' , 6)
                        ->get(['id' , 'no_urut' , 'kode' , 'no_mak_sys' , 'uraian']);

        
        return $data;
    }

    public function memuat_komponen($id)
    {
        $output = DB::table('rkakl')
                        ->where('id' , $id)
                        ->first();
        
        $data = DB::table('rkakl')
                        ->where('no_mak_sys' , 'LIKE' , '%' . $output->no_mak_sys . '%')
                        ->where('level' , 7)
                        ->get(['id' , 'no_urut' , 'kode' , 'no_mak_sys' , 'uraian']);
        
        if(Count($data) == 0)
        {
            $data = DB::table('rkakl')
                        ->where('no_mak_sys' , 'LIKE' , '%' . $output->no_mak_sys . '%')
                        ->where('level' , 6)
                        ->get(['id' , 'no_urut' , 'kode' , 'no_mak_sys' , 'uraian']);
        }
        
        return $data;
    }

    public function memuat_uraian($id)
    {
        $data = DB::table('rkakl')
                        ->where('id' , $id)
                        ->get();
        
        return $data;
    }

    public function memuat_data($id)
    {
        $data_rpk = DB::table('m_rpk')->where('id' , $id)->get();

        return response($data_rpk);
    }
}
