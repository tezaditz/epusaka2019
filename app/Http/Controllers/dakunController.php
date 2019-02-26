<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class dakunController extends Controller
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
        //
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
        //
        DB::table('detail_akun')->where('kegiatan_id' , $id)->delete();

        return redirect('/admin/keg/' . $id . '/dakun' );
    }

    public function destroy_perjadin($id)
    {
        //
        DB::table('detail_akun')->where('kegiatan_id' , $id)->delete();

        return redirect('/admin/perjadin/' . $id . '/dakun' );
    }

    public function destroy_hn($id)
    {
        //
        DB::table('detail_akun')->where('kegiatan_id' , $id)
        ->where('jenis_transaksi' , 'honor')
        ->delete();

        return redirect('/admin/hn/' . $id . '/dakun' );
    }
}
