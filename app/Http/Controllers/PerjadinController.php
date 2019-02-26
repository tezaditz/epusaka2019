<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use CRUDBooster;
class PerjadinController extends Controller
{
	public function memuat_nomak()
    {
            $bagianuser = DB::table('bagian_user')->where('user_id' , CRUDBooster::myId())->first();
			$param_perjadin = DB::table('parameter')->where('nama' , 'Akun Perjadin')->first();
			$akun = explode("," , $param_perjadin->nilai);
			
			$rpk = DB::table('m_rpk')->where('bagian_id' , $bagianuser->bagian_id)->get();
			$nomak = [];
			foreach ($rpk as $key => $value) {
				$rpd = DB::table('m_rpd')->where('m_rpk_id' , $value->id)->first();
				for ($i=0; $i < Count($akun) ; $i++) { 
					$detail_rpd  = DB::table('detail_rpd')->where('m_rpd_id' , $rpd->id)
															->where('kode' , 'LIKE' , '%' . $akun[$i] . '%')->count();
					
					if($detail_rpd != 0)
					{
						$nomak[$key]['id'] = $value->kode_7;
						$nomak[$key]['no_mak'] = $value->no_mak_7;
						$nomak[$key]['uraian'] = $value->uraian_kegiatan;
					}
				}
			}

			return $nomak;
    }

    public function memuat_jenis_belanja($id)
    {
        $data_rpk   = DB::table('m_rpk')->where('id' , $id)->first();
        $data_rkakl = DB::table('rkakl')->where('id' , $data_rpk->kode_7)->first();
        $akun_honor = DB::table('parameter')->where('nama' , 'Akun Honor')->first();
        $akun_perjadin = DB::table('parameter')->where('nama' , 'Akun perjadin')->first();
        $akun = explode("," , $akun_honor->nilai);
        $perjadin = explode("," , $akun_perjadin->nilai);
        $data_akun  = DB::table('rkakl')->where('no_mak_sys' , 'LIKE' , '%' . $data_rkakl->no_mak_sys . '%')
        ->whereNotIn('kode' , $akun)
        ->whereNotIn('kode' , $perjadin)
        ->where('level' , 11)                       
        ->get(['kode' , 'no_urut','uraian']);

        return $data_akun;

    }

    public function memuat_nomak_perkantoran()
    {
        $parameter = DB::table('parameter')->where('nama' , 'Mak Layanan Perkantoran')->first();
        $satkeruser = DB::table('satker_user')->where('user_id' , CRUDBooster::MyId())->first();
        $bagianuser = DB::table('bagian_user')->where('user_id' , CRUDBooster::MyId())->first();
        $tahunang  = DB::table('parameter')->where('nama' , 'Tahun Anggaran')->first();
        
        $rpk = DB::table('m_rpk')->where('no_mak_7' , 'LIKE' , '%'. $parameter->nilai .'%' )
        ->where('thnang' , $tahunang->nilai)
        ->where('satker_id' , $satkeruser->satker_id)
        ->where('bagian_id' , $bagianuser->bagian_id)
        ->first();

        $rpd = DB::table('m_rpd')->where('m_rpk_id' , $rpk->id)->first();

        $data = DB::table('detail_rpd')->where('m_rpd_id' , $rpd->id)
        ->where('level' , 11)
        ->get();
        
        return $data;
    }


}