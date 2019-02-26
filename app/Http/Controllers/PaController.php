<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DB;

class PaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request , $id)
    {
        $data = $request->all();
        
        foreach ($request->nilai as $key => $value) {
            
            if($request->nilai[$key] != 0)
            {
                DB::table('pilih_akun')->where('id' ,$request->id[$key])
                                    ->update([
                                        'pengajuan' => str_replace('.', '' , $request->nilai[$key])
                                    ]);                
            }
            # code...
        }

        $data_pa = DB::table('pilih_akun')
                        ->where('kegiatan_id' , $id)
                        ->select(DB::raw('SUM(pengajuan) as jumlah') , 'kode' , 'kegiatan_id' )
                        ->groupby('kode' , 'kegiatan_id')
                        ->get();
                        
                        $insert_data = [];
                        foreach ($data_pa as $key => $value) {
                            $insert_data['kegiatan_id'] = $value->kegiatan_id;
                            $insert_data['akun'] = $value->kode;
                            $insert_data['jumlah'] = $value->jumlah;
                        }

                        if($insert_data)
                        {
                            DB::table('detail_akun')->where('kegiatan_id' , $id)->delete();
                            DB::table('detail_akun')->insert($insert_data);
                        }
        $data_keg = DB::table('m_kegiatan')->where('id' , $id)->first();
        $dataRkakl = DB::table('rkakl')->where('no_urut' , $data_keg->jenis_belanja)->first();
        DB::table('detail_akun')->where('kegiatan_id' , $id)
                                ->update(['uraian' => $dataRkakl->uraian]);

        // insert detail_kegiatan
        $data_pa = DB::table('pilih_akun')->where('kegiatan_id' , $id)->get();
        $data = [];
        $total_pengajuan = 0;
        foreach ($data_pa as $key => $value) {
            if($value->jumlah !=0 )
            {
                $data[$key]['kegiatan_id']            = $value->kegiatan_id;
                $rkakl = DB::table('rkakl')->where('no_mak_sys' , $value->no_mak_sys)->first();
                $data[$key]['no_urut_rkakl']          = $rkakl->no_urut;
                $data[$key]['level']                  = $value->level;
                $data[$key]['kode']                   = $value->kode;
                $data[$key]['akun']                   = $value->kode;
                $data[$key]['no_mak_sys']             = $value->no_mak_sys;
                $data[$key]['uraian']                 = $value->uraian;
                $data[$key]['vol']                    = $value->vol;
                $data[$key]['sat']                    = $value->sat;
                $data[$key]['hargasat']                   = $value->hargasat;
                $data[$key]['jumlah']                     = $value->jumlah;
                $data[$key]['jumlah_pengajuan']           = $value->pengajuan;
                $data[$key]['sisa_pagu_sblm_pengajuan']   = $value->sisa_pagu;
                $data[$key]['jumlah_pertanggungjawaban']  = 0;
                $total_pengajuan = $total_pengajuan + $value->pengajuan;
            }
        }

        if($data)
        {
            DB::table('detail_kegiatan')->where('kegiatan_id' , $id)->delete();
            DB::table('detail_kegiatan')->insert($data);
            
            DB::table('m_kegiatan')->where('id' , $id)->update(['total_pengajuan' => $total_pengajuan]);
        }



        return redirect('/admin/keg/' . $id . '/dakun');

    }

    public function store_perjadin(Request $request , $id)
    {
        $data = $request->all();
        foreach ($request->nilai as $key => $value) {
            if($request->nilai[$key] != 0)
            {
                DB::table('pilih_akun')->where('id' ,$request->id[$key])
                                    ->update([
                                        'pengajuan' => str_replace('.', '' , $request->nilai[$key])
                                    ]);                
            }
        }

        $data_pa = DB::table('pilih_akun')
                        ->where('kegiatan_id' , $id)
                        ->select(DB::raw('SUM(pengajuan) as jumlah') , 'kode' , 'kegiatan_id' )
                        ->groupby('kode' , 'kegiatan_id')
                        ->get();

                        $insert_data = [];
                        foreach ($data_pa as $key => $value) {
                            if($value->jumlah != 0)
                            {
                                $insert_data['kegiatan_id'] = $value->kegiatan_id;
                                $insert_data['akun'] = $value->kode;
                                $insert_data['jenis_transaksi'] = 'Perjadin';
                                $insert_data['jumlah'] = $value->jumlah;

                                $rkakl = DB::table('rkakl')->where('kode' , $value->kode)->first();
                                $insert_data['uraian'] = $rkakl->uraian;
                            }
                        }

                        if($insert_data)
                        {
                            DB::table('detail_akun')->where('kegiatan_id' , $id)->delete();
                            DB::table('detail_akun')->insert($insert_data);
                        }
                        
        

        // insert detail_kegiatan
        $data_pa = DB::table('pilih_akun')->where('kegiatan_id' , $id)->get();
        $data = [];
        $total_pengajuan = 0;
        foreach ($data_pa as $key => $value) {
            if( $value->pengajuan != 0)
            {
                $data[$key]['perjadin_id']            = $value->kegiatan_id;
                $rkakl = DB::table('rkakl')->where('no_mak_sys' , $value->no_mak_sys)->first();
                $data[$key]['rkakl_id']                 = $rkakl->id;
                $data[$key]['level']                  = $value->level;
                $data[$key]['kode']                   = $value->kode;
                $data[$key]['akun']                   = $value->kode;
                $data[$key]['no_mak_sys']             = $value->no_mak_sys;
                $data[$key]['uraian']                 = $value->uraian;
                $data[$key]['vol']                    = $value->vol;
                $data[$key]['sat']                    = $value->sat;
                $data[$key]['hargasat']                   = $value->hargasat;
                $data[$key]['jumlah']                     = $value->jumlah;
                $data[$key]['jumlah_pengajuan']           = $value->pengajuan;
                $data[$key]['sisa_pagu_sblm_pengajuan']   = $value->sisa_pagu;
                $data[$key]['jumlah_pertanggungjawaban']  = 0;
                $total_pengajuan = $total_pengajuan + $value->pengajuan;
            }
        }

        DB::table('perjadin')->where('id' , $id)->update(['total_pengajuan' => $total_pengajuan]);

        if($data)
        {
            DB::table('detail_perjadin')->where('perjadin_id' , $id)->delete();
            DB::table('detail_perjadin')->insert($data);
            
            DB::table('m_kegiatan')->where('id' , $id)->update(['total_pengajuan' => $total_pengajuan]);
        }



        return redirect('/admin/perjadin/' . $id . '/dakun');

    }

    public function store_honor(Request $request , $id)
    {
        $data = $request->all();
        
        foreach ($request->nilai as $key => $value) {
            
            if($request->nilai[$key] != 0)
            {
                DB::table('pilih_akun')->where('id' ,$request->id[$key])
                                        ->where('jenis_transaksi' , 'honor')
                                        ->update([
                                            'pengajuan' => str_replace('.', '' , $request->nilai[$key])
                                        ]);                
            }
            # code...
        }

        $data_pa = DB::table('pilih_akun')
                        ->where('kegiatan_id' , $id)
                        ->where('jenis_transaksi' , 'honor')
                        ->select(DB::raw('SUM(pengajuan) as jumlah') , 'kode' , 'kegiatan_id' )
                        ->groupby('kode' , 'kegiatan_id')
                        ->get();
        
        
                        $insert_data = [];
                        foreach ($data_pa as $key => $value) {
                            if($value->jumlah != 0)
                            {
                                $insert_data['kegiatan_id'] = $value->kegiatan_id;
                                $insert_data['akun'] = $value->kode;
                                $insert_data['jenis_transaksi'] = 'honor';
                                $akun = DB::table('akun')->where('akun' ,  $value->kode)->first();
                                $insert_data['uraian']  = $akun->keterangan;
                                $insert_data['jumlah'] = $value->jumlah;
                            }

                        }

                        if($insert_data)
                        {
                            DB::table('detail_akun')->where('kegiatan_id' , $id)->where('jenis_transaksi' , 'honor')->delete();
                            DB::table('detail_akun')->insert($insert_data);
                        }


        // insert detail_kegiatan
        $data_pa = DB::table('pilih_akun')->where('kegiatan_id' , $id)->get();
        $data = [];
        $total_pengajuan = 0;
        foreach ($data_pa as $key => $value) {
            if($value->jumlah != 0){
                $data[$key]['honor_id']            = $value->kegiatan_id;
                $rkakl = DB::table('rkakl')->where('no_mak_sys' , $value->no_mak_sys)->first();
                $data[$key]['rkakl_id']                     = $rkakl->id;
                $data[$key]['level']                        = $value->level;
                $data[$key]['kode']                         = $value->kode;
                $data[$key]['akun']                         = $value->kode;
                $data[$key]['no_mak_sys']                   = $value->no_mak_sys;
                $data[$key]['uraian']                       = $value->uraian;
                $data[$key]['vol']                          = $value->vol;
                $data[$key]['sat']                          = $value->sat;
                $data[$key]['hargasat']                     = $value->hargasat;
                $data[$key]['jumlah']                       = $value->jumlah;
                $data[$key]['jumlah_pengajuan']             = $value->pengajuan;
                $data[$key]['sisa_pagu_sblm_pengajuan']     = $value->sisa_pagu;
                $data[$key]['jumlah_pertanggungjawaban']    = 0;
                $total_pengajuan = $total_pengajuan + $value->pengajuan;
            };
        }

        if($data)
        {
            DB::table('detail_honor')->where('honor_id' , $id)->delete();
            DB::table('detail_honor')->insert($data);
            
            DB::table('honor')->where('id' , $id)->update(['jml_pengajuan' => $total_pengajuan]);
        }



        return redirect('/admin/hn/' . $id . '/dakun');

    }

    public function store_perkantoran(Request $request , $id)
    {
        $data = $request->all();
        
        foreach ($request->nilai as $key => $value) {
            
            if($request->nilai[$key] != 0)
            {
                DB::table('pilih_akun')->where('id' ,$request->id[$key])
                                    ->update([
                                        'pengajuan' => str_replace('.', '' , $request->nilai[$key])
                                    ]);                
            }
            # code...
        }

        $data_pa = DB::table('pilih_akun')
                        ->where('kegiatan_id' , $id)
                        ->select(DB::raw('SUM(pengajuan) as jumlah') , 'kode' , 'kegiatan_id' )
                        ->groupby('kode' , 'kegiatan_id')
                        ->get();
                        
                       
                        $insert_data = [];
                        foreach ($data_pa as $key => $value) {
                            $insert_data['kegiatan_id'] = $value->kegiatan_id;
                            $insert_data['akun'] = $value->kode;
                            
                            $insert_data['jumlah'] = $value->jumlah;
                        }

                        
                        if($insert_data)
                        {
                            DB::table('detail_akun')->where('kegiatan_id' , $id)->delete();
                            DB::table('detail_akun')->insert($insert_data);
                        }
        $data_keg = DB::table('m_kegiatan')->where('id' , $id)->first();
        $dataRkakl = DB::table('rkakl')->where('no_urut' , $data_keg->jenis_belanja)->first();
        DB::table('detail_akun')->where('kegiatan_id' , $id)
                                ->update(['uraian' => $dataRkakl->uraian]);

        // insert detail_perkantoran
        $data_pa = DB::table('pilih_akun')->where('kegiatan_id' , $id)->get();
        $data = [];
        $total_pengajuan = 0;
        foreach ($data_pa as $key => $value) {
            $data[$key]['kegiatan_id']            = $value->kegiatan_id;

            $rkakl = DB::table('rkakl')->where('no_mak_sys' , $value->no_mak_sys)->first();


            $data[$key]['no_urut_rkakl']          = $rkakl->no_urut;
            $data[$key]['level']                  = $value->level;
            $data[$key]['kode']                   = $value->kode;
            $data[$key]['akun']                   = $value->kode;
            $data[$key]['no_mak_sys']             = $value->no_mak_sys;
            $data[$key]['uraian']                 = $value->uraian;
            $data[$key]['vol']                    = $value->vol;
            $data[$key]['sat']                    = $value->sat;
            $data[$key]['hargasat']                   = $value->hargasat;
            $data[$key]['jumlah']                     = $value->jumlah;
            $data[$key]['jumlah_pengajuan']           = $value->pengajuan;
            $data[$key]['sisa_pagu_sblm_pengajuan']   = $value->sisa_pagu;
            $data[$key]['jumlah_pertanggungjawaban']  = 0;
            $total_pengajuan = $total_pengajuan + $value->pengajuan;
        }

        if($data)
        {
            DB::table('detail_kegiatan')->where('kegiatan_id' , $id)->delete();
            DB::table('detail_kegiatan')->insert($data);
            
            DB::table('m_kegiatan')->where('id' , $id)->update(['total_pengajuan' => $total_pengajuan]);
        }



        return redirect('/admin/perkantoran/' . $id . '/dakun');

    }

    
}
