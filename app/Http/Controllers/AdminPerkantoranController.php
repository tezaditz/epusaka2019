<?php namespace App\Http\Controllers;

	use Session;
	// use Request;
	use DB;
	use CRUDBooster;
	use Carbon\carbon;

	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Input;
	use Illuminate\Support\Facades\App;

	class AdminPerkantoranController extends \crocodicstudio\crudbooster\controllers\CBController {

	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "no_pengajuan";
			$this->limit = "20";
			$this->orderby = "id,asc";
			$this->global_privilege = false;
			$this->button_table_action = true;
			$this->button_bulk_action = true;
			$this->button_action_style = "button_icon";
			$this->button_add = true;
			$this->button_edit = true;
			$this->button_delete = true;
			$this->button_detail = true;
			$this->button_show = true;
			$this->button_filter = true;
			$this->button_import = false;
			$this->button_export = false;
			$this->table = "perkantoran";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"No Pengajuan","name"=>"no_pengajuan"];
			$this->col[] = ["label"=>"Tgl Pengajuan","name"=>"tgl_pengajuan"];
			$this->col[] = ["label"=>"No Mak","name"=>"no_mak"];
			$this->col[] = ["label"=>"Uraian","name"=>"uraian"];
			$this->col[] = ["label"=>"Keterangan","name"=>"keterangan"];
			$this->col[] = ["label"=>"Total Nilai","name"=>"total_nilai"];
			// $this->col[] = ["label"=>"Alasan","name"=>"alasan"];
			// $this->col[] = ["label"=>"Metode","name"=>"metode"];
			// $this->col[] = ["label"=>"Status","name"=>"status_id"];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];

			// $bagianuser = DB::table('bagian_user')->where('user_id' , CRUDBooster::MyId())->first();
			// $bagianuser = DB::table('bagian_user')->where('user_id' , CRUDBooster::MyId())->first();
			
			$this->form[] = ['label'=>'Tgl Pengajuan','name'=>'tgl_pengajuan','type'=>'date','validation'=>'required|date','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'No Mak','name'=>'rkakl_id','id'=>'rkakl_id','type'=>'select2','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			
			$this->form[] = ['label'=>'Keterangan','name'=>'keterangan','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			
			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ["label"=>"No Pengajuan","name"=>"no_pengajuan","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Tgl Pengajuan","name"=>"tgl_pengajuan","type"=>"date","required"=>TRUE,"validation"=>"required|date"];
			//$this->form[] = ["label"=>"No Mak","name"=>"no_mak","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Uraian","name"=>"uraian","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Keterangan","name"=>"keterangan","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Total Nilai","name"=>"total_nilai","type"=>"money","required"=>TRUE,"validation"=>"required|integer|min:0"];
			//$this->form[] = ["label"=>"Alasan","name"=>"alasan","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Metode","name"=>"metode","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Status Id","name"=>"status_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"status,id"];
			# OLD END FORM

			/* 
	        | ---------------------------------------------------------------------- 
	        | Sub Module
	        | ----------------------------------------------------------------------     
			| @label          = Label of action 
			| @path           = Path of sub module
			| @foreign_key 	  = foreign key of sub table/module
			| @button_color   = Bootstrap Class (primary,success,warning,danger)
			| @button_icon    = Font Awesome Class  
			| @parent_columns = Sparate with comma, e.g : name,created_at
	        | 
	        */
	        $this->sub_module = array();


	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add More Action Button / Menu
	        | ----------------------------------------------------------------------     
	        | @label       = Label of action 
	        | @url         = Target URL, you can use field alias. e.g : [id], [name], [title], etc
	        | @icon        = Font awesome class icon. e.g : fa fa-bars
	        | @color 	   = Default is primary. (primary, warning, succecss, info)     
	        | @showIf 	   = If condition when action show. Use field alias. e.g : [id] == 1
	        | 
	        */
	        $this->addaction = array();


	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add More Button Selected
	        | ----------------------------------------------------------------------     
	        | @label       = Label of action 
	        | @icon 	   = Icon from fontawesome
	        | @name 	   = Name of button 
	        | Then about the action, you should code at actionButtonSelected method 
	        | 
	        */
	        $this->button_selected = array();

	                
	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add alert message to this module at overheader
	        | ----------------------------------------------------------------------     
	        | @message = Text of message 
	        | @type    = warning,success,danger,info        
	        | 
	        */
	        $this->alert        = array();
	                

	        
	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add more button to header button 
	        | ----------------------------------------------------------------------     
	        | @label = Name of button 
	        | @url   = URL Target
	        | @icon  = Icon from Awesome.
	        | 
	        */
	        $this->index_button = array();



	        /* 
	        | ---------------------------------------------------------------------- 
	        | Customize Table Row Color
	        | ----------------------------------------------------------------------     
	        | @condition = If condition. You may use field alias. E.g : [id] == 1
	        | @color = Default is none. You can use bootstrap success,info,warning,danger,primary.        
	        | 
	        */
	        $this->table_row_color = array();     	          

	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | You may use this bellow array to add statistic at dashboard 
	        | ---------------------------------------------------------------------- 
	        | @label, @count, @icon, @color 
	        |
	        */
	        $this->index_statistic = array();



	        /*
	        | ---------------------------------------------------------------------- 
	        | Add javascript at body 
	        | ---------------------------------------------------------------------- 
	        | javascript code in the variable 
	        | $this->script_js = "function() { ... }";
	        |
	        */
	        $this->script_js = NULL;


            /*
	        | ---------------------------------------------------------------------- 
	        | Include HTML Code before index table 
	        | ---------------------------------------------------------------------- 
	        | html code to display it before index table
	        | $this->pre_index_html = "<p>test</p>";
	        |
	        */
	        $this->pre_index_html = null;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include HTML Code after index table 
	        | ---------------------------------------------------------------------- 
	        | html code to display it after index table
	        | $this->post_index_html = "<p>test</p>";
	        |
	        */
	        $this->post_index_html = null;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include Javascript File 
	        | ---------------------------------------------------------------------- 
	        | URL of your javascript each array 
	        | $this->load_js[] = asset("myfile.js");
	        |
	        */
	        // $this->load_js = array();
	        $this->load_js[] = asset("js/pengajuan/perkantoran.js");
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Add css style at body 
	        | ---------------------------------------------------------------------- 
	        | css code in the variable 
	        | $this->style_css = ".style{....}";
	        |
	        */
	        $this->style_css = NULL;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include css File 
	        | ---------------------------------------------------------------------- 
	        | URL of your css each array 
	        | $this->load_css[] = asset("myfile.css");
	        |
	        */
	        $this->load_css = array();
	        
	        
	    }


	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for button selected
	    | ---------------------------------------------------------------------- 
	    | @id_selected = the id selected
	    | @button_name = the name of button
	    |
	    */
	    public function actionButtonSelected($id_selected,$button_name) {
	        //Your code here
	            
	    }


	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate query of index result 
	    | ---------------------------------------------------------------------- 
	    | @query = current sql query 
	    |
	    */
	    public function hook_query_index(&$query) {
	        //Your code here
	  //       $bagianuser = DB::table('bagian_user')->where('user_id' , CRUDBooster::MyId())->first();
			// if($bagianuser->bagian_id != 5)
			// {
			// 	$query->where('bagian_id' , $bagianuser->bagian_id);
			// }
	            
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate row of index table html 
	    | ---------------------------------------------------------------------- 
	    |
	    */    
	    public function hook_row_index($column_index,&$column_value) {	        
	    	//Your code here
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate data input before add data is execute
	    | ---------------------------------------------------------------------- 
	    | @arr
	    |
	    */
	    public function hook_before_add(&$postdata) {        
	        //Your code here
	        $bagianuser = DB::table('bagian_user')->where('user_id' , CRUDBooster::myId())->first();
			$bagian 	= DB::table('bagian')->where('id' , $bagianuser->bagian_id)->first();
			$parameter 	= DB::table('parameter')->where('nama','Mak Layanan Perkantoran')->first();
			$tahunang	= DB::table('parameter')->where('nama' , 'Tahun Anggaran')->first();
			$postdata['bagian_id'] = $bagianuser->bagian_id;
			
			// generate nomor pengajuan
			$dataPengajuan = DB::table('no_pengajuan')->where('bagian_id' , $bagianuser->bagian_id)
													  ->where('jenis' , 'Layanan Perkantoran')
													  ->get();
			
			if(Count($dataPengajuan) == 0)
			{
				$data = [];
				$data['bagian_id'] 		= $bagianuser->bagian_id;
				$data['nomor'] 			= 1;
				$data['jenis'] 			= "Layanan Perkantoran";
				
				DB::table('no_pengajuan')->insert($data);
				$nomor = 1;
			}
			else
			{
				$data = DB::table('no_pengajuan')->where('bagian_id' , $bagianuser->bagian_id)
													  ->where('jenis' , 'Layanan Perkantoran')
													  ->first();
				
				$nomor = $data->nomor + 1;
				DB::table('no_pengajuan')->where('bagian_id' , $bagianuser->bagian_id)
										->where('jenis' , 'Layanan Perkantoran')
										->update(['nomor' => $nomor
										]);
			}

			$nomor_pengajuan = "AJU-" . $nomor . '/' . $bagian->kode . '/' . $tahunang->nilai;

			$postdata['no_pengajuan'] 		= $nomor_pengajuan;
			$postdata['status_id'] 			= 1;
			$postdata['metode_bayar_id'] 	= 5;
			$postdata['tgl_pengajuan'] 		= Carbon::now();

			
			

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after add public static function called 
	    | ---------------------------------------------------------------------- 
	    | @id = last insert id
	    | 
	    */
	    public function hook_after_add($id) {        
	        //Your code here
	        $Data = DB::table('perkantoran')->where('id' , $id)->first();
			$getRkakl = DB::table('rkakl')->where('id' , $Data->rkakl_id)->first();
			$DataRkakl = DB::table('rkakl')->where('no_mak_sys' , 'LIKE' , '%' . $getRkakl->no_mak . '%')->get();

			//update uraian dan no_mak perkantoran
			DB::table('perkantoran')->where('id' , $id)
						->update([
							'no_mak' => $getRkakl->no_mak,
							'uraian' => $getRkakl->uraian

						]);


			$data = [];
			
			$akun = '';
			foreach ($DataRkakl as $key => $value) {
				$data[$key]['kegiatan_id'] 		=  $id;
				$data[$key]['level'] 			=  $value->level;
				$data[$key]['header'] 			=  $value->header;
				if($akun == '')
				{
				$data[$key]['kode'] 			=  $value->kode;
				$akun 							= $value->kode;
				}
				else
				{
				$data[$key]['kode'] 			=  $akun;
				}
				
				$data[$key]['no_mak'] 			=  $value->no_mak;
				$data[$key]['no_mak_sys'] 		=  $value->no_mak_sys;
				$data[$key]['uraian'] 			=  $value->uraian;
				$data[$key]['vol'] 				=  $value->vol;
				$data[$key]['sat'] 				=  $value->sat;
				$data[$key]['hargasat'] 		=  $value->hargasat;
				$data[$key]['jumlah'] 			=  $value->jumlah;
				$data[$key]['pengajuan'] 		=  0;
				$data[$key]['sisa_pagu'] 		=  $value->jumlah - ($value->realisasi_1 + $value->realisasi_2 + $value->realisasi_3);
				
			}
	

			if($data)
			{
			

				DB::table('pilih_akun')->insert($data);

				$to = '/admin/perkantoran/' . $id . '/dakun';
				$message = 'master Layanan berhasil ditambahkan';
				$type = 'info';

				CRUDBooster::redirect($to,$message,$type);
				
			}


	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate data input before update data is execute
	    | ---------------------------------------------------------------------- 
	    | @postdata = input post data 
	    | @id       = current id 
	    | 
	    */
	    public function hook_before_edit(&$postdata,$id) {        
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after edit public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_after_edit($id) {
	        //Your code here 

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command before delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_before_delete($id) {
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_after_delete($id) {
	        //Your code here

	    }

	     public function detail_akun($id)
		{
			$data = [];
				  $data['page_title'] = 'Pilih Akun';
				  $data['row'] = DB::table('detail_akun')->where('kegiatan_id',$id)->get();
				  $data['id'] = $id;
				  
				  //Please use cbView method instead view method from laravel
				  $this->cbView('backend.pengajuan.perkantoran.detailakun',$data);
		}

	    public function getDraft($id)
		{
			//Create an Auth
			// if(!CRUDBooster::isRead() && $this->global_privilege==FALSE || $this->button_edit==FALSE) {    
			// 	CRUDBooster::redirect(CRUDBooster::adminPath(),trans("crudbooster.denied_access"));
			// }
			
			$data = [];
			$data['page_title'] = 'Draft Perkantoran';
			$data['row'] = DB::table('perkantoran')->where('id',$id)->first();
			$data['status'] = DB::table('status')->where('id' , $data['row']->status_id)->first();
			$data['bagian'] = DB::table('bagian')->where('id' , $data['row']->bagian_id)->first();
			$data['daerah'] = DB::table('provinsi')->where('id' , $data['row']->provinsi_id)->first();
			$data['detail'] = DB::table('detail_kegiatan')
			->where('level' , 0)
			->where('kegiatan_id' , $id)->get();
			$data['id'] = $id;
			$data['metode_bayar'] 	= DB::table('metode_bayar')->get();
			$data['status_bend']			= DB::table('status')->get(['id' , 'keterangan']);

			// $data['nopengajuan'] = DB::table('m_kegiatan')->where('id',$id)->first();
			//Please use cbView method instead view method from laravel
			$this->cbView('backend.pengajuan.perkantoran.draft',$data);
		}

	    public function getAdd()
		{
			if(!CRUDBooster::isCreate() && $this->global_privilege==FALSE || $this->button_add==FALSE) {    
				CRUDBooster::redirect(CRUDBooster::adminPath(),trans("crudbooster.denied_access"));
			  }
			  
			  $data = [];
			  $data['page_title'] = 'Tambah Data';


			  $this->cbView('backend.pengajuan.perkantoran.add',$data);
		}

		public function getEdit($id)
		{
			if(!CRUDBooster::isCreate() && $this->global_privilege==FALSE || $this->button_edit==FALSE) {    
				CRUDBooster::redirect(CRUDBooster::adminPath(),trans("crudbooster.denied_access"));
			  }
			  
			  $data = [];
			  $data['page_title'] = 'Edit Data';
			  $data['perkantoran'] = DB::table('perkantoran')->where('id' ,$id)->first(); 
			  // $data['provinsi'] = DB::table('provinsi')->where('id' , $data['perjadin']->provinsi_id )->first(['id' , 'title']);
			  // $data['kabkota'] 	= DB::table('kabkota')->where('id' , $data['perjadin']->kabkota_id )->first(['id' , 'nama']);
			  
			  // $data['akun']		= DB::table('rkakl')->where('no_urut' , $data['perjadin']->jenis_belanja)->first();
			  $data['id']		= $id;

			  // return $data;
			  // die();
		  
			  //Please use cbView method instead view method from laravel
			  $this->cbView('backend.pengajuan.perkantoran.edit',$data);
		}

		public function senddraft($id)
		{
			//ubah status
			DB::table('perkantoran')->where('id' , $id)->update(['status_id'=>2]);

				$to = '/admin/perkantoran/';
				$message = 'Perjadin berhasil ditambahkan';
				$type = 'info';
				CRUDBooster::redirect($to,$message,$type);
		}

		public function print_notadinas($id)
		{
			$kegiatan = DB::table('perjadin')->where('id' , $id)->first();
			$bagianuser 				= DB::table('bagian_user')->where('user_id' , CRUDBooster::MyId())->first();
			$ppk						= DB::table('pejabat')->where('jabatan' , 'Pejabat Pembuat Komitmen')->first();
			$pimpinan					= DB::table('pimpinan')->where('bagian_id' , $bagianuser->bagian_id)->first();
			$data['no_pengajuan'] 		= $kegiatan->no_pengajuan;
			$data['no_mak']				= $kegiatan->no_mak;
			$data['nama_kegiatan']		= $kegiatan->uraian;
			$data['tgl_awal']			= $kegiatan->tgl_awal;
			$data['tgl_akhir']			= $kegiatan->tgl_akhir;
			$provinsi = DB::table('provinsi')->where('id' , $kegiatan->provinsi_id)->first();
			$data['provinsi']			= $provinsi->title;
			$data['tanggalprint'] 		= Carbon::now();

			
			$data['pimpinan']			= $pimpinan->nama;
			$data['nip_pimpinan']		= $pimpinan->nip;
			$data['jabatan_pimpinan']	= $pimpinan->jabatan;
			$data['ppk_nama']			= $ppk->nama;
			$data['ppk_nip']			= $ppk->nip;
			
			$data['detail']				= DB::table('detail_perjadin')->where('kegiatan_id', $id)->where('level' , 0)->get();
			// return $data;
			$view = view('backend.pengajuan.perjadin.laporan.notadinas', $data)->render();
			$pdf = App::make('dompdf.wrapper');
			$pdf->loadHTML($view);
			$pdf->setPaper($papersize, $paperorientation);

			return $pdf->stream($filename.'.pdf');
			
		}


		public function getbagian(){
			$data = DB::table('bagian_user')->where('user_id', CRUDBooster::MyId())->first();
			$bagian = DB::table('bagian')->where('id', $data->bagian_id)->first();
			return $bagian->nama;

		}

		// public function memuat_uraian_perkantoran($id)
  //   {
  //       $data = DB::table('rkakl')
  //                       ->where('id' , $id)
  //                       ->get();
        
  //       return $data;
  //   }

	    //By the way, you can still create your own method in here... :) 


	}