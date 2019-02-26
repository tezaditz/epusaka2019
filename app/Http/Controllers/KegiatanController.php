<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use CRUDBooster;
class KegiatanController extends Controller
{
    public function memuat_nomak()
    {
        $parameter = DB::table('parameter')->where('nama' , 'Tahun Anggaran')->first();
        $linsek = DB::table('parameter')->where('nama' , 'MAK LINSEK')->first();
        $perkantoran = DB::table('parameter')->where('nama' , 'Mak Perkantoran')->first();
        $satkeruser = DB::table('satker_user')->where('user_id' , CRUDBooster::MyId())->first();
        $bagianuser = DB::table('bagian_user')->where('user_id' , CRUDBooster::MyId())->first();

       $data_rpk = DB::table('m_rpk')->where('thnang' , $parameter->nilai)
                                     ->where('satker_id' , $satkeruser->satker_id)
                                     ->where('bagian_id' , $bagianuser->bagian_id)
                                     ->where('no_mak_7' , 'NOT LIKE' , '%' . $linsek->nilai . '%')
                                     ->where('no_mak_7' , 'NOT LIKE' , '%' . $perkantoran->nilai . '%')
                                     ->get();

       
        
        return $data_rpk;
    }

    public function memuat_jenis_belanja($id)
    {
        
        
        $data_rkakl = DB::table('rkakl')->where('id' , $id)->first();
        $akun_honor = DB::table('parameter')->where('nama' , 'Akun Honor')->first();
        $akun_perjadin = DB::table('parameter')->where('nama' , 'Akun perjadin')->first();
        $akun_pengadaan = DB::table('parameter')->where('nama' , 'Akun pengadaan')->first();
        $akun = explode("," , $akun_honor->nilai);
        $perjadin = explode("," , $akun_perjadin->nilai);
        $pengadaan = explode("," , $akun_pengadaan->nilai);
        $data_akun  = DB::table('rkakl')->where('no_mak_sys' , 'LIKE' , '%' . $data_rkakl->no_mak_sys . '%')
        ->whereNotIn('kode' , $akun)
        ->whereNotIn('kode' , $perjadin)
        ->whereNotIn('kode' , $pengadaan)
        ->where('level' , 11)                       
        ->get(['kode' , 'no_urut','uraian']);

        return $data_akun;

    }

    
  


   
}
