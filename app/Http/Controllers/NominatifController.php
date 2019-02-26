<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DB;
use Carbon\carbon;
use CRUDBooster;
use Maatwebsite\Excel\Facades\Excel;

class NominatifController extends Controller
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

        $pegawai    = DB::table('pegawai')->where('id' , $request->input('nama_peserta'))->first();
        $kegiatan   = DB::table('m_kegiatan')->where('id' , $id)->first();
        $provinsi   = DB::table('provinsi')->where('id' , $kegiatan->provinsi_id)->first();

        $tgl1        = Carbon::parse($kegiatan->tgl_awal);
        $tgl2        = Carbon::parse($kegiatan->tgl_akhir);
        $inv         =  $tgl2->diffInDays($tgl1);


        $insert = [];
        $insert['kegiatan_id']          = $id;
        $insert['peserta_id']           = $request->input('nama_peserta');
        $insert['nama_peserta']         = $pegawai->nama;
        $insert['nip']                  = $request->input('nip');
        $insert['gol']                  = $request->input('golongan');
        $insert['instansi']             = $request->input('instansi');
        $insert['daerah_asal']          = 'DKI Jakarta';
        $insert['prov_daerah_tujuan']   = $provinsi->title;
        $insert['tgl_berangkat']        = $kegiatan->tgl_awal;
        $insert['tgl_kembali']          = $kegiatan->tgl_akhir;
        $insert['lama']                 = $inv;
        $insert['tiket_pesawat']        = str_replace('.' , '' , $request->input('total_tiket_pesawat'));
        $insert['uang_harian']          = str_replace('.' , '' , $request->input('totaluh'));
        $insert['penginapan']           = str_replace('.' , '' , $request->input('total_penginapan'));
        $insert['taksi_provinsi']       = str_replace('.' , '' , $request->input('total_taksi_prov'));
        $insert['taksi_kabupaten']      = str_replace('.' , '' , $request->input('total_taksi_kab'));

        
        if($insert)
        {
            DB::table('nominatif')->insert($insert);
            $to = '/admin/keg/'. $id .'/nominatif';
            $message = 'Pelaksana berhasil ditambahkan';
            $type = 'info';
            CRUDBooster::redirect($to,$message,$type);
        }
        

        
    }

    public function store_guest(Request $request , $id)
    {
        $data = $request->all();       

        $pegawai    = DB::table('tamu')->where('id' , $request->input('nama_peserta'))->first();
        $kegiatan   = DB::table('m_kegiatan')->where('id' , $id)->first();
        $provinsi   = DB::table('provinsi')->where('id' , $kegiatan->provinsi_id)->first();

        $tgl1        = Carbon::parse($kegiatan->tgl_awal);
        $tgl2        = Carbon::parse($kegiatan->tgl_akhir);
        $inv         =  $tgl2->diffInDays($tgl1);


        $insert = [];
        $insert['kegiatan_id']          = $id;
        $insert['peserta_id']           = $request->input('nama_peserta');
        $insert['nama_peserta']         = $pegawai->nama;
        $insert['nip']                  = $request->input('nip');
        $insert['gol']                  = $request->input('golongan');
        $insert['instansi']             = $request->input('instansi');
        $insert['daerah_asal']          = 'DKI Jakarta';
        $insert['prov_daerah_tujuan']   = $provinsi->title;
        $insert['tgl_berangkat']        = $kegiatan->tgl_awal;
        $insert['tgl_kembali']          = $kegiatan->tgl_akhir;
        $insert['lama']                 = $inv;
        $insert['tiket_pesawat']        = str_replace('.' , '' , $request->input('total_tiket_pesawat'));
        $insert['uang_harian']          = str_replace('.' , '' , $request->input('totaluh'));
        $insert['penginapan']           = str_replace('.' , '' , $request->input('total_penginapan'));
        $insert['taksi_provinsi']       = str_replace('.' , '' , $request->input('total_taksi_prov'));
        $insert['taksi_kabupaten']      = str_replace('.' , '' , $request->input('total_taksi_kab'));

        
        if($insert)
        {
            DB::table('nominatif')->insert($insert);
            $to = '/admin/keg/'. $id .'/nominatif';
            $message = 'Pelaksana berhasil ditambahkan';
            $type = 'info';
            CRUDBooster::redirect($to,$message,$type);
        }
        

        
    }


    // PERJADIN

    public function store_perjadin(Request $request , $id)
    {
        $data = $request->all();       

        $pegawai    = DB::table('pegawai')->where('id' , $request->input('nama_peserta'))->first();
        $kegiatan   = DB::table('perjadin')->where('id' , $id)->first();
        $provinsi   = DB::table('provinsi')->where('id' , $kegiatan->provinsi_id)->first();

        $tgl1        = Carbon::parse($kegiatan->tgl_awal);
        $tgl2        = Carbon::parse($kegiatan->tgl_akhir);
        $inv         =  $tgl2->diffInDays($tgl1);


        $insert = [];
        $insert['perjadin_id']          = $id;
        $insert['nama_pelaksana']         = $pegawai->nama;
        $insert['nip']                  = $request->input('nip');
        $insert['gol']                  = $request->input('golongan');
        $insert['instansi']             = $request->input('instansi');
        $insert['daerah_asal_id']      = 31;
        $insert['daerah_asal']          = 'DKI Jakarta';
        $insert['daerah_tujuan_id']     = $provinsi->id;
        $insert['daerah_tujuan']         = $provinsi->title;
        $insert['tgl_berangkat']        = $kegiatan->tgl_awal;
        $insert['tgl_kembali']          = $kegiatan->tgl_akhir;
        $insert['lama']                 = $inv;
        $insert['tiket_pesawat']        = str_replace('.' , '' , $request->input('total_tiket_pesawat'));
        $insert['uang_harian']          = str_replace('.' , '' , $request->input('totaluh'));
        $insert['penginapan']           = str_replace('.' , '' , $request->input('total_penginapan'));
        $insert['taksi_provinsi']       = str_replace('.' , '' , $request->input('total_taksi_prov'));
        $insert['taksi_kabupaten']      = str_replace('.' , '' , $request->input('total_taksi_kab'));

        
        if($insert)
        {
            DB::table('data_perjadin')->insert($insert);
            $to = '/admin/perjadin/'. $id .'/nominatif';
            $message = 'Pelaksana berhasil ditambahkan';
            $type = 'info';
            CRUDBooster::redirect($to,$message,$type);
        }
        

        
    }

    public function store_guest_perjadin(Request $request , $id)
    {
        $data = $request->all();       

        $pegawai    = DB::table('tamu')->where('id' , $request->input('nama_peserta'))->first();
        $kegiatan   = DB::table('m_kegiatan')->where('id' , $id)->first();
        $provinsi   = DB::table('provinsi')->where('id' , $kegiatan->provinsi_id)->first();

        $tgl1        = Carbon::parse($kegiatan->tgl_awal);
        $tgl2        = Carbon::parse($kegiatan->tgl_akhir);
        $inv         =  $tgl2->diffInDays($tgl1);


        $insert = [];
        $insert['kegiatan_id']          = $id;
        $insert['peserta_id']           = $request->input('nama_peserta');
        $insert['nama_peserta']         = $pegawai->nama;
        $insert['nip']                  = $request->input('nip');
        $insert['gol']                  = $request->input('golongan');
        $insert['instansi']             = $request->input('instansi');
        $insert['daerah_asal']          = 'DKI Jakarta';
        $insert['prov_daerah_tujuan']   = $provinsi->title;
        $insert['tgl_berangkat']        = $kegiatan->tgl_awal;
        $insert['tgl_kembali']          = $kegiatan->tgl_akhir;
        $insert['lama']                 = $inv;
        $insert['tiket_pesawat']        = str_replace('.' , '' , $request->input('total_tiket_pesawat'));
        $insert['uang_harian']          = str_replace('.' , '' , $request->input('totaluh'));
        $insert['penginapan']           = str_replace('.' , '' , $request->input('total_penginapan'));
        $insert['taksi_provinsi']       = str_replace('.' , '' , $request->input('total_taksi_prov'));
        $insert['taksi_kabupaten']      = str_replace('.' , '' , $request->input('total_taksi_kab'));

        
        if($insert)
        {
            DB::table('nominatif')->insert($insert);
            $to = '/admin/keg/'. $id .'/nominatif';
            $message = 'Pelaksana berhasil ditambahkan';
            $type = 'info';
            CRUDBooster::redirect($to,$message,$type);
        }
        

        
    }

    // END PERJADIN

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
        $data = DB::table('nominatif')->where('id' , $id)->first();
        $idkeg = $data->kegiatan_id;
        DB::table('nominatif')->where('id' , $id)->delete();

        $to = '/admin/keg/'. $idkeg .'/nominatif';
        $message = 'Pelaksana berhasil dihapus';
        $type = 'info';
        CRUDBooster::redirect($to,$message,$type);
        
        
    }

    public function destroy_perjadin($id)
    {
        $data = DB::table('data_perjadin')->where('id', $id)->first();
        $idPerjadin = $data->perjadin_id;

        DB::table('data_perjadin')->where('id' , $id)->delete();

        $to = '/admin/perjadin/'. $idPerjadin .'/nominatif';
        $message = 'Pelaksana berhasil dihapus';
        $type = 'info';
        CRUDBooster::redirect($to,$message,$type);
    }

    public function import_perjadin(Request $request , $id)
    {

        if($request->hasFile('import_file'))
        {
            $path = $request->file('import_file')->getRealPath();
            $data = Excel::load($path, function($reader) {
                $reader->noHeading();
                $reader->skipRows(7);
            })->get();
            $insert = [];
            $perjadin = DB::table('perjadin')->where('id' , $id)->first();
            $provinsi = DB::table('provinsi')->where('id' , $perjadin->provinsi_id)->first();
            $tgl1        = Carbon::parse($perjadin->tgl_awal);
            $tgl2        = Carbon::parse($perjadin->tgl_akhir);
            $inv         =  $tgl2->diffInDays($tgl1);
            foreach ($data as $row) {
                $insert['perjadin_id']          = $id;
                $insert['nama_pelaksana']       = $row[1];;
                $insert['nip']                  = $row[2];
                $insert['gol']                  = $row[4];
                $insert['instansi']             = $row[3];
                $insert['daerah_asal_id']       = 31;
                $insert['daerah_asal']          = 'DKI Jakarta';
                $insert['daerah_tujuan_id']     = $provinsi->id;
                $insert['daerah_tujuan']        = $provinsi->title;
                $insert['tgl_berangkat']        = $perjadin->tgl_awal;
                $insert['tgl_kembali']          = $perjadin->tgl_akhir;
                $insert['lama']                 = $inv;
                $insert['tiket_pesawat']        = $row[6];
                $insert['uang_harian']          = $row[10];
                $insert['penginapan']           = $row[12];
                $insert['taksi_provinsi']       = $row[7];
                $insert['taksi_kabupaten']      = $row[8];
            
                DB::table('data_perjadin')->insert($insert);
            }

            $to = '/admin/perjadin/'. $id .'/nominatif';
            $message = 'File berhasil diupload';
            $type = 'success';
            CRUDBooster::redirect($to,$message,$type);
            
        }
    }

    public function download_excel_kegiatan($id)
    {
        ini_set('memory_limit', '1024M');
        set_time_limit(180);
        
        $data = DB::table('m_kegiatan')->where('id' , $id)->first();
        $prov = DB::table('provinsi')->where('id' , $data->provinsi_id)->first();
        

        Excel::create($data->uraian, function ($excel) use ($data , $prov) {
            $excel->getProperties()->setCreator("Maarten Balliauw")
                ->setLastModifiedBy("Data Solusion Comindo")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Test result file");
            $excel->sheet('sheet_1', function ($sheet) use ($data , $prov) {
                $sheet->mergeCells('A1:L1');
                $sheet->mergeCells('A2:L2');
                $sheet->mergeCells('A3:L3');
                $sheet->mergeCells('A4:L4');

                $sheet->cells('A1:A4', function($cells) {
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setFontWeight('bold');
                });
                $sheet->setCellValue('A1', 'DAFTAR NOMINATIF');
                $sheet->setCellValue('A2', 'PEGAWAI YANG MELAKUKAN PERJALANAN DINAS');
                $sheet->setCellValue('A3', $data->uraian);
                $sheet->setCellValue('A4', ($prov->title . ', ' . date('d M', strtotime($data->tgl_awal)) . ' s.d ' . date('d M Y', strtotime($data->tgl_akhir))));

                $sheet->mergeCells('A6:A7');
                $sheet->mergeCells('B6:B7');
                $sheet->mergeCells('C6:C7');
                $sheet->mergeCells('D6:D7');
                $sheet->mergeCells('E6:E7');
                $sheet->mergeCells('F6:G6');
                $sheet->mergeCells('H6:I6');
                $sheet->mergeCells('J6:J7');
                $sheet->mergeCells('K6:K7');
                $sheet->mergeCells('L6:L7');
                $sheet->mergeCells('M6:M7');
                $sheet->mergeCells('N6:O6'); // UANG HARIAN
                $sheet->mergeCells('P6:Q6'); // PENGINAPAN
                $sheet->mergeCells('R6:R7'); // 
                
                $sheet->cells('A6:R7', function($cells) {
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setFontWeight('bold');
                    $cells->setBackground('#cccfd4');
                });
                $sheet->setCellValue('A6', 'No');
                $sheet->setCellValue('B6', 'NAMA');
                $sheet->setCellValue('C6', 'NIP');
                $sheet->setCellValue('D6', 'INSTANSI \ JABATAN');
                $sheet->setCellValue('E6', 'GOL');
                $sheet->setCellValue('F6', 'DAERAH');
                $sheet->setCellValue('F7', 'ASAL');
                $sheet->setCellValue('G7', 'TUJUAN');
                $sheet->setCellValue('H6', 'TANGGAL');
                $sheet->setCellValue('H7', 'BERANGKAT');
                $sheet->setCellValue('I7', 'KEMBALI');
                $sheet->setCellValue('J6', 'HARI');
                $sheet->setCellValue('K6', 'TIKET PESAWAT');
                $sheet->setCellValue('L6', 'TAKSI PROVINSI');
                $sheet->setCellValue('M6', 'TAKSI KAB');
                $sheet->setCellValue('N6', 'UANG HARIAN');
                $sheet->setCellValue('N7', 'SATUAN');
                $sheet->setCellValue('O7', 'TOTAL');
                $sheet->setCellValue('P6', 'PENGINAPAN');
                $sheet->setCellValue('P7', 'SATUAN');
                $sheet->setCellValue('Q7', 'TOTAL');
                $sheet->setCellValue('R6', 'JUMLAH');
                $sheet->setSize(array(
                    'A6' => array(
                        'width' => 5,
                    ),
                    'B6' => array(
                        'width' => 25,
                    ),
                    'C6' => array(
                        'width' => 25,
                    ),
                    'D6' => array(
                        'width' => 20
                    ),
                    'F6' => array(
                        'width' => 25
                    ),
                    'G6' => array(
                        'width' => 25
                    ),
                    'H6' => array(
                        'width' => 15
                    ),
                    'I6' => array(
                        'width' => 15
                    ),
                    'J6' => array(
                        'width' => 15
                    ),
                    'K6' => array(
                        'width' => 15
                    ),
                    'L6' => array(
                        'width' => 15
                    )
                ));
            });
        })->download('xlsx');
    }

    public function import_excel_kegiatan(Request $request , $id)
    {
        
        if($request->hasFile('import_file'))
        {
            $path = $request->file('import_file')->getRealPath();
            $data = Excel::load($path, function($reader) {
                $reader->noHeading();
                $reader->skipRows(7);
            })->get();
            $insert = [];
            $perjadin = DB::table('perjadin')->where('id' , $id)->first();
            $provinsi = DB::table('provinsi')->where('id' , $perjadin->provinsi_id)->first();
            $tgl1        = Carbon::parse($perjadin->tgl_awal);
            $tgl2        = Carbon::parse($perjadin->tgl_akhir);
            $inv         =  $tgl2->diffInDays($tgl1);
            foreach ($data as $row) {
                $insert['kegiatan_id']          = $id;
                $insert['nama_peserta']         = $row[1];
                $insert['nip']                  = $row[2];
                $insert['instansi']             = $row[3];
                $insert['gol']                  = $row[4];
                $insert['daerah_asal']          = $row[5];
                $insert['daerah_tujuan']        = $row[6];
                $insert['tgl_berangkat']        = $row[7];
                $insert['tgl_kembali']          = $row[8];
                $insert['lama']                 = $row[9];
                $insert['tiket_pesawat']        = $row[10];
                $insert['taksi_provinsi']       = $row[11];
                $insert['taksi_kabupaten']      = $row[12];
                $insert['uang_harian']          = $row[14];
                $insert['penginapan']           = $row[16];
                DB::table('nominatif')->insert($insert);
            }

            $to = '/admin/keg/'. $id .'/nominatif';
            $message = 'File berhasil diupload';
            $type = 'success';
            CRUDBooster::redirect($to,$message,$type);
    }

    }

    public function reset_kegiatan($id)
    {
        DB::table('nominatif')->where('kegiatan_id' , $id)->delete();

        $to = '/admin/keg/'. $id .'/nominatif';
            $message = 'File berhasil diupload';
            $type = 'success';
            CRUDBooster::redirect($to,$message,$type);
    }
    
}
