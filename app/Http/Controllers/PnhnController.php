<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DB;
use CRUDBooster;
use Carbon\carbon;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\UploadedFile;

class PnhnController extends Controller
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
    public function store(Request $request)
    {
        // return $request;
        $id                             = $request->input('id');  

        $insert = [];
        $insert['honor_id']             = $request->input('id');
        $insert['nama_penerima']        = $request->input('nama_peserta');
        $insert['nip']                  = $request->input('nip');
        $insert['npwp']                  = $request->input('npwp');
        $insert['instansi']             = $request->input('instansi');
        $insert['gol']                  = $request->input('golongan');
        $insert['jumlah_honor']         = str_replace('.' , '' ,$request->input('jumlah_honor'));
        $insert['jumlah_potongan']      = str_replace('.' , '' ,$request->input('jumlah_potongan'));
        $insert['jumlah_terima']        = str_replace('.' , '' ,$request->input('terima'));

        if($insert)
        {
            DB::table('penerima_honor')->insert($insert);
            $to = '/admin/hn/' . $id . '/nominatif';
            $message = 'Pelaksana berhasil ditambahkan';
            $type = 'info';
            CRUDBooster::redirect($to,$message,$type);   
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('penerima_honor')->where('id' , $id)->delete();

        $to = '/admin/hn/'. $id .'/nominatif';
        $message = 'Pelaksana berhasil dihapus';
        $type = 'info';
        CRUDBooster::redirect($to,$message,$type);  

    }
/**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function import_excel(Request $request , $id)
    {
        ini_set('memory_limit', '1024M');
        set_time_limit(180);

        if($request->hasFile('import_file'))
        {
            $path = $request->file('import_file')->getRealPath();
            
            $data = Excel::load($path, function($reader){
                $reader->noHeading();
                $reader->skipRows(6);
            })->get();

            $insert= [];
            $honor = DB::table('honor')->where('id' , $id)->first();
            $x = 0;
            foreach ($data as $row) {
                
                $insert[$x]['honor_id']         = $id;
                $insert[$x]['nama_penerima']    = $row[1];
                $insert[$x]['instansi']         = $row[2];
                $insert[$x]['npwp']             = $row[3];
                $insert[$x]['jumlah_honor']     = $row[10];
                $insert[$x]['jumlah_potongan']  = $row[12];
                $insert[$x]['jumlah_terima']    = $row[14];
                # code...

                $x++;
            }

            if($insert)
            {
                DB::table('penerima_honor')->insert($insert);

                $to = '/admin/hn/'. $id .'/nominatif';
                $message = 'File berhasil diupload';
                $type = 'success';
                CRUDBooster::redirect($to,$message,$type);
            }
        }

        
        

    }

    public function Hapus_Semua($id)
    {
        DB::table('penerima_honor')->where('honor_id' , $id)->delete();
        $to = '/admin/hn/'. $id .'/nominatif';
        $message = 'Data Berhasil diHapus';
        $type = 'warning';
        CRUDBooster::redirect($to,$message,$type);
    }
}
