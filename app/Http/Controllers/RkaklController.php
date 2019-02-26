<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;
use CRUDBooster;

class RkaklController extends Controller
{
    public function load_rkakl()
    {

        // delete rkakl

        DB::table('rkakl')->delete();

        $userid = CRUDBooster::MyId();
        $satkeruser = DB::table('satker_user')->where('user_id' , $userid)->first();
        $data_upload = DB::table('rkakl_upload')
                            ->where('satker_id' , $satkeruser->satker_id)
                           ->get();
        $parameter = DB::table('parameter')->where('nama' , 'Tahun Anggaran')->first();
        $data = [];
        $kode9 = '';$kode4 = '';$kode8 = '';$kode6 = '';$kode7 = '';$kode11 = '';$kode0 = '';
        $x = 0;$y=0;$z=0;
        $no = 1;
        foreach ($data_upload as $key => $value) {
            $nomak = '';$nomaksys = '';
            switch (strlen($value->kode)) {
                case 9:
                    $kode9 = trim($value->kode);
                    $nomak = $kode9;
                    $nomaksys = $kode9;
                    break;
                case 4:
                    $kode4 = trim($value->kode);
                    $nomak = $kode9 . '.' . $kode4;
                    $nomaksys = $kode9 . '.' . $kode4;
                    break;
                case 8:
                    $kode8 = trim($value->kode);
                    $nomak = $kode9 . '.' . $kode8;
                    $nomaksys = $kode9 . '.' . $kode8;
                    break;
                case 6:
                    $kode6 = trim($value->kode);
                    $nomak = $kode9 . '.' . $kode8 . '.' . $kode6;
                    $nomaksys = $kode9 . '.' . $kode8 . '.' . $kode6;
                    break;
                case 7:
                    $kode7 = trim($value->kode);
                    $nomak = $kode9 . '.' . $kode8 . '.' . $kode6 . '.' . $kode7;
                    $nomaksys = $kode9 . '.' . $kode8 . '.' . $kode6 . '.' . $kode7;
                    break;
                case 11:
                    $kode11 = trim($value->kode);
                    $x = 0;
                    $z = 0 ;
                    $nomak = $kode9 . '.' . $kode8 . '.' . $kode6 . '.' . $kode7 . '.' . $kode11;
                    $nomaksys = $kode9 . '.' . $kode8 . '.' . $kode6 . '.' . $kode7 . '.' . $kode11;
                    break;
                default:
                    
                    $tanda1 = trim(substr($value->uraian , 0 , 3));    
                    $tanda2 = trim(substr($tanda1 , 0 , 2));
                    if($tanda2 == ">")
                    {
                        $x = $x + 1;
                        $y = 0;
                        $z = 0;
                        $nomak = $kode9 . '.' . $kode8 . '.' . $kode6 . '.' . $kode7 . '.' . $kode11;
                        $nomaksys = $kode9 . '.' . $kode8 . '.' . $kode6 . '.' . $kode7 . '.' . $kode11 . '.' . $x;
                    }
                    elseif ($tanda2 == ">>") {
                        $y = $y + 1;
                        $z = 0;
                        $nomak = $kode9 . '.' . $kode8 . '.' . $kode6 . '.' . $kode7 . '.' . $kode11;
                        $nomaksys = $kode9 . '.' . $kode8 . '.' . $kode6 . '.' . $kode7 . '.' . $kode11 . '.' . $x . '.' . $y;
                    }
                    else
                    {
                        $z = $z + 1;
                        $nomak = $kode9 . '.' . $kode8 . '.' . $kode6 . '.' . $kode7 . '.' . $kode11;
                        $nomaksys = $kode9 . '.' . $kode8 . '.' . $kode6 . '.' . $kode7 . '.' . $kode11 . '.' . $x . '.' . $y . '.' . $z;
                    }



                    break;
            }

            $nomaksys = $nomaksys;

            $data[$key]['id']               = $no;
            $data[$key]['no_urut']               = $no;
            $data[$key]['satker_id']        = $satkeruser->satker_id;
            $data[$key]['thnang']           = $parameter->nilai;
            $data[$key]['no_mak']           = $nomak;
            $data[$key]['no_mak_sys']       = $nomaksys;
            $data[$key]['level']            = strlen($value->kode);
            $data[$key]['kode']             = TRIM($value->kode);
            $data[$key]['uraian']           = $value->uraian;
            $data[$key]['vol']              = $value->vol;
            $data[$key]['sat']              = $value->sat;
            $data[$key]['hargasat']         = $value->hargasat;
            $data[$key]['jumlah']           = $value->jumlah;
            $data[$key]['kdblokir']         = $value->kdblokir;
            $data[$key]['sdana']            = $value->sdana;

            $no = $no + 1;
        }

        if($data)
        {
            DB::table('rkakl')->insert($data);
        }

        $baseline_update = DB::table('rkakl')
                                ->where('uraian' , 'LIKE' , '%_x000D_[Base Line]%')
                                ->get();
        foreach ($baseline_update as $key => $value) {
            $geturaian = $value->uraian;
            $a = substr($geturaian , 0 , strlen($geturaian) - 18  );
            DB::table('rkakl')
                        ->where('id' , $value->id)
                        ->update(['uraian' => $a]);
        }
        
        DB::table('parameter')->where('nama','id_rkakl')->update(['nilai'=>$no]);


        return back();
        
    }
}
