<?php namespace App\Http\Controllers;

	use Session;
	// use Request;
	use DB;
	use CRUDBooster;
	use Carbon\carbon;

	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Input;
	use Illuminate\Support\Facades\App;

	class AdminPerjadin29Controller extends \crocodicstudio\crudbooster\controllers\CBController {

	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "nama_kegiatan";
			$this->limit = "20";
			$this->orderby = "id,desc";
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
			$this->table = "perjadin";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"No Pengajuan","name"=>"no_pengajuan"];
			$this->col[] = ["label"=>"No Surat Tugas","name"=>"no_surat_tugas"];
			$this->col[] = ["label"=>"Tgl Pengajuan","name"=>"tgl_pengajuan",'callback_php'=>'date("d M y",strtotime($row->tgl_pengajuan))'];
			$this->col[] = ["label"=>"No Mak","name"=>"no_mak"];
			$this->col[] = ["label"=>"Nama Kegiatan","name"=>"nama_kegiatan"];
			$this->col[] = ["label"=>"No Surat Tugas","name"=>"no_surat_tugas"];
			$this->col[] = ["label"=>"Tgl Surat Tugas","name"=>"tgl_surat_tugas" ,'callback_php'=>'date("d M y",strtotime($row->tgl_surat_tugas))'];
			$this->col[] = ["label"=>"Tgl Awal","name"=>"tgl_awal" ,'callback_php'=>'date("d M y",strtotime($row->tgl_awal))'];
			$this->col[] = ["label"=>"Tgl Akhir","name"=>"tgl_akhir" ,'callback_php'=>'date("d M y",strtotime($row->tgl_akhir))'];
			$this->col[] = ["label"=>"Status","name"=>"status_id","join"=>"status,keterangan"];
			$this->col[] = ["label"=>"Provinsi","name"=>"provinsi_id" , 'join'=>'provinsi,title'];
			$this->col[] = ["label"=>"Kabkota","name"=>"kabkota_id",'join'=>'kabkota,nama'];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$bagianuser = DB::table('bagian_user')->where('user_id' , CRUDBooster::MyId())->first();
			$this->form[] = ['label'=>'Bagian','name'=>'bagian_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'bagian,nama','value'=>$bagianuser->bagian_id , 'readonly'=>true];

			$this->form[] = ['label'=>'No Pengajuan','name'=>'no_pengajuan','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];

			$this->form[] = ['label'=>'No Surat Tugas','name'=>'no_surat_tugas','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];

			$this->form[] = ['label'=>'Tgl Surat Tugas','name'=>'tgl_surat_tugas','type'=>'date','validation'=>'required|date','width'=>'col-sm-10'];

			$this->form[] = ['label'=>'Tgl Pengajuan','name'=>'tgl_pengajuan','type'=>'date','validation'=>'required|date','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'No Mak','name'=>'no_mak','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			
			$this->form[] = ['label'=>'Nama Kegiatan','name'=>'id_rkakl','type'=>'select','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Tgl Awal','name'=>'tgl_awal','type'=>'date','validation'=>'required|date','width'=>'col-sm-10'];
			
			$this->form[] = ['label'=>'Tgl Akhir','name'=>'tgl_akhir','type'=>'date','validation'=>'required|date','width'=>'col-sm-10'];
			
			$this->form[] = ['label'=>'Provinsi','name'=>'provinsi_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'provinsi,title'];

			$this->form[] = ['label'=>'Kabkota','name'=>'kabkota_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'kabkota,title'];
			
			$this->form[] = ['label'=>'File','name'=>'file','type'=>'filemanager','filemanager_type'=>'file','validation'=>'required','width'=>'col-sm-10'];

			$this->form[] = ['label'=>'Lama','name'=>'lama','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ['label'=>'No Pengajuan','name'=>'no_pengajuan','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Tgl Pengajuan','name'=>'tgl_pengajuan','type'=>'date','validation'=>'required|date','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'No Mak','name'=>'no_mak','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Nama Kegiatan','name'=>'nama_kegiatan','type'=>'select2','validation'=>'required|min:1|max:255','width'=>'col-sm-10','datatable'=>'kegiatan,nama_kegiatan'];
			//$this->form[] = ['label'=>'Tgl Awal','name'=>'tgl_awal','type'=>'date','validation'=>'required|date','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Tgl Akhir','name'=>'tgl_akhir','type'=>'date','validation'=>'required|date','width'=>'col-sm-10'];
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
	        // $this->load_js[] = asset("js/pengajuan/perjadin.js");

	        if(CRUDBooster::getCurrentMethod() == 'getEdit' && CRUDBooster::getCurrentId()) {
				$this->load_js[] = asset("js/pengajuan/perjadin_edit.js");;
			}
			else
			{
				$this->load_js[] = asset("js/pengajuan/perjadin.js");
			}
	        
	        
	        
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
	        $bagianuser = DB::table('bagian_user')->where('user_id' , CRUDBooster::MyId())->first();
			if($bagianuser->bagian_id != 5)
			{
				$query->where('bagian_id' , $bagianuser->bagian_id);
			}
	            
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
			$parameter 	= DB::table('parameter')->where('nama','Tahun Anggaran')->first();
			$gettglawal 	= DB::table('perjadin')->where('id','Tgl Awal')->first();
			$gettglakhir 	= DB::table('perjadin')->where('id','Tgl Akhir')->first();

			
			$postdata['bagian_id'] = $bagianuser->bagian_id;
			
			// generate nomor pengajuan
			$dataPengajuan = DB::table('no_pengajuan')->where('bagian_id' , $bagianuser->bagian_id)
													  ->where('jenis' , 'Perjadin')
													  ->get();
			
			if(Count($dataPengajuan) == 0)
			{
				$data = [];
				$data['bagian_id'] 		= $bagianuser->bagian_id;
				$data['nomor'] 			= 1;
				$data['jenis'] 			= "Perjadin";
				
				DB::table('no_pengajuan')->insert($data);
				$nomor = 1;
			}
			else
			{
				$data = DB::table('no_pengajuan')->where('bagian_id' , $bagianuser->bagian_id)
													  ->where('jenis' , 'Perjadin')
													  ->first();
				
				$nomor = $data->nomor + 1;
				DB::table('no_pengajuan')->where('bagian_id' , $bagianuser->bagian_id)
										->where('jenis' , 'Perjadin')
										->update(['nomor' => $nomor
										]);
			}

			$nomor_pengajuan = "AJU-" . $nomor . '/' . $bagian->kode . '/' . $parameter->nilai;

			

			// // end generate nomor pengajuan			

			
			
			$postdata['thn_anggaran']		= $parameter->nilai;
			$postdata['no_pengajuan'] 		= $nomor_pengajuan;
			$postdata['status_id'] 			= 1;
			$postdata['metode_bayar_id'] 	= 5;
			$postdata['tgl_pengajuan'] 		= Carbon::now();
			// $postdata['no_surat_tugas'] 	= 1;
			// $postdata['lama'] 				= $gettglawal - $gettglakhir;
			$postdata['prov_asal'] 			= 31;
			
			
			

			

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
			
			// update no mak & uraian kegiatan
			$Data = DB::table('perjadin')->where('id' , $id)->first();
			$getRkakl = DB::table('rkakl')->where('id' , $Data->id_rkakl)->first();
			DB::table('perjadin')->where('id' , $id)
			->update([
				
				'no_mak' => $getRkakl->no_mak,
				'nama_kegiatan' => $getRkakl->uraian
			]);

			
			$akun_perjadin = DB::table('parameter')->where('nama' , 'Akun Perjadin')->first();
			$akun = explode("," , $akun_perjadin->nilai);
			for ($i=0; $i < Count($akun) ; $i++) { 
				// $rkakl = DB::table('rkakl')->where('no_mak_sys' , 'LIKE' , '%' . $Data->no_mak . '%')->get();
				$rkakl = DB::table('rkakl')->where('no_mak_sys' , 'LIKE' , '%'.$getRkakl->no_mak_sys .'.'. $akun[$i] .'%')->get();
				
				$uraian_akun = '';
				foreach ($rkakl as $key => $value) {

					if($value->kode != '')
						{
							$uraian_akun = $value->kode;
						}
						else
						{
							$uraian_akun = $uraian_akun;
						}

					$data['kegiatan_id'] 		=  $id;
					$data['level'] 				=  $value->level;
					$data['jenis_transaksi'] 	=  'Perjadin';
					$data['header'] 			=  $value->header;
					$data['kode'] 				=  $uraian_akun;
					$data['no_mak'] 			=  $value->no_mak;
					$data['no_mak_sys'] 		=  $value->no_mak_sys;
					$data['uraian'] 			=  $value->uraian;
					$data['vol'] 				=  $value->vol;
					$data['sat'] 				=  $value->sat;
					$data['hargasat'] 			=  $value->hargasat;
					$data['jumlah'] 			=  $value->jumlah;
					$data['pengajuan'] 			=  0;
					$data['sisa_pagu'] 			=  $value->jumlah - ($value->realisasi_1 + $value->realisasi_2 + $value->realisasi_3);

					if($data)
					{
						DB::table('pilih_akun')->insert($data);	
					}
				}
			}

				$to = '/admin/perjadin/' . $id . '/dakun';
				$message = 'master perjadin berhasil ditambahkan';
				$type = 'info';

				CRUDBooster::redirect($to,$message,$type);
				
			

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
	        $bagianuser = DB::table('bagian_user')->where('user_id' , CRUDBooster::myId())->first();
			$bagian 	= DB::table('bagian')->where('id' , $bagianuser->bagian_id)->first();
			$DataRkakl = DB::table('rkakl')->where('no_mak_sys' , 'LIKE' , '%' . $getRkakl->no_mak . '%')->get();

			// return $DataRkakl;
			// die();


			$postdata['bagian_id'] = $bagianuser->bagian_id;

			// get data perjadin
			$getdataperjadin = DB::table('perjadin')->where('id', $id)->first();
			// $getRkakl = DB::table('rkakl')->where('id' , $getdataperjadin->id_rkakl)->first();


			// if(Count($getdataperjadin) == 0){

				// $postdata = [];
				

				// $postdata['id_rkakl'] 		= $getdataperjadin->id_rkakl;
				// $postdata['no_mak']			= $getdataperjadin->no_mak;
				// $postdata['thn_anggaran']	= $getdataperjadin->thn_anggaran;
				// $postdata['nama_kegiatan']	= $getdataperjadin->nama_kegiatan;
				// $postdata['no_surat_tugas']	= $getdataperjadin->no_surat_tugas;
				// $postdata['tgl_surat_tugas']= $getdataperjadin->tgl_surat_tugas;
				// $postdata['tgl_awal']		= $getdataperjadin->tgl_awal;
				// $postdata['tgl_akhir']		= $getdataperjadin->tgl_akhir;
				$postdata['lama']			= $getdataperjadin->lama;
				$postdata['provinsi_id']		= $getdataperjadin->provinsi_id;
				$postdata['kabkota_id']		= $getdataperjadin->kabkota_id;
				// $postdata['status_id']			= $getdataperjadin->status_id;
				// $postdata['metode_bayar_id']= $getdataperjadin->metode_bayar_id;
				// $postdata['file']			= $getdataperjadin->file;
				
				// DB::table('xperjadin')->where('id', $id)->update($postdata);

			// }


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
	        
	        // $Data = DB::table('perjadin')->where('id' , $id)->first();
	        // $getRkakl = DB::table('rkakl')->where('id' , $Data->id_rkakl)->first();
	        // $DataRkakl = DB::table('rkakl')->where('no_mak_sys' , 'LIKE' , '%' . $getRkakl->no_mak . '%')->get();



	        // $data = [];

	        // $data['lama'] = $Data->lama;

	        // return $data;
	        // die();

	       
	        // foreach ($DataRkakl as $key => $value) {
	        // // if(Count($ambil) == 0 ){
	        // 	# code...
	        // 	// $data['id']				= $id;
	        // 	$data[$key]['bagian_id'] 		=$value->bagian_id;
	        // 	$data[$key]['id_rkakl'] 		=$value->id_rkakl;
	        // 	$data[$key]['no_mak'] 			=$value->no_mak;
	        // 	// $data['thn_anggaran'] 	=$value->thn_anggaran;
	        // 	// $data['nama_kegiatan'] 	=$value->nama_kegiatan;
	        // 	// $data['no_surat_tugas'] 	=$value->no_surat_tugas;
	        // 	// $data['tgl_surat_tugas'] 	=$value->tgl_surat_tugas;
	        // 	// $data['tgl_awal'] 		=$value->tgl_awal;
	        // 	// $data['tgl_akhir'] 		=$value->tgl_akhir;	        	
	        // 	// $data['lama'] 			=$value->lama;
	        // 	// $data['provinsi_id'] 		=$value->provinsi_id;
	        // 	// $data['kabkota_id'] 		=$value->kabkota_id;
	        // 	// $data['status_id'] 		=$value->status_id;
	        // 	// $data['metode_bayar_id'] 	=$value->metode_bayar_id;
	        // 	// $data['file'] 			=$value->file;
	        // }
	        

	        // DB::table('xperjadin')->where('id', $id)->update(['lama' => $Data->lama]);



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
				  $this->cbView('backend.pengajuan.perjadin.detailakun',$data);
		}

		public function getDetail($id)
		{
			$data = [];
			$data['page_title'] = 'Draft Perjadin';
			$data['row'] = DB::table('perjadin')->where('id',$id)->first();
			$data['status'] = DB::table('status')->where('id' , $data['row']->status_id)->first();
			$data['bagian'] = DB::table('bagian')->where('id' , $data['row']->bagian_id)->first();
			$data['daerah'] = DB::table('provinsi')->where('id' , $data['row']->provinsi_id)->first();
			$data['detail'] = DB::table('detail_perjadin')
			->where('level' , 0)
			->where('perjadin_id' , $id)->get();
			$data['nominatif'] = DB::table('data_perjadin')->where('perjadin_id' , $id)->get();
			$data['id'] = $id;
			$data['metode_bayar'] 	= DB::table('metode_bayar')->get();
			$data['status_bend']			= DB::table('status')->get(['id' , 'keterangan']);

			// $data['nopengajuan'] = DB::table('m_kegiatan')->where('id',$id)->first();
			//Please use cbView method instead view method from laravel
			$this->cbView('backend.pengajuan.perjadin.draft',$data);
		}

	    public function getDraft($id)
		{
			//Create an Auth
			// if(!CRUDBooster::isRead() && $this->global_privilege==FALSE || $this->button_edit==FALSE) {    
			// 	CRUDBooster::redirect(CRUDBooster::adminPath(),trans("crudbooster.denied_access"));
			// }
			
			$data = [];
			$data['page_title'] = 'Draft Perjadin';
			$data['row'] = DB::table('perjadin')->where('id',$id)->first();
			$data['status'] = DB::table('status')->where('id' , $data['row']->status_id)->first();
			$data['bagian'] = DB::table('bagian')->where('id' , $data['row']->bagian_id)->first();
			$data['daerah'] = DB::table('provinsi')->where('id' , $data['row']->provinsi_id)->first();
			$data['detail'] = DB::table('detail_perjadin')
			->where('level' , 0)
			->where('perjadin_id' , $id)->get();
			$data['nominatif'] = DB::table('data_perjadin')->where('perjadin_id' , $id)->get();
			$data['id'] = $id;
			$data['metode_bayar'] 	= DB::table('metode_bayar')->get();
			$data['status_bend']			= DB::table('status')->get(['id' , 'keterangan']);

			// $data['nopengajuan'] = DB::table('m_kegiatan')->where('id',$id)->first();
			//Please use cbView method instead view method from laravel
			$this->cbView('backend.pengajuan.perjadin.draft',$data);
		}

	    public function getAdd()
		{
			if(!CRUDBooster::isCreate() && $this->global_privilege==FALSE || $this->button_add==FALSE) {    
				CRUDBooster::redirect(CRUDBooster::adminPath(),trans("crudbooster.denied_access"));
			  }
			  
			  $data = [];
			  $data['page_title'] = 'Add Data';
			  $bagianuser = DB::table('bagian_user')->where('user_id' , CRUDBooster::MyId())->first();
			  $data['provinsi'] = DB::table('provinsi')->get(['id' , 'title']);
			  $data['kabkota'] = DB::table('kabkota')->get(['id' , 'nama']);
			  $rpk = DB::table('m_rpk')->where('bagian_id' , $bagianuser->bagian_id)->get();
			  
			  $nomak=[];
			  $parameter = DB::table('parameter')->where('nama', 'akun perjadin')->first();
			  $akun = explode(',', $parameter->nilai);

			  // return count($akun);
			  foreach ($rpk as $key => $value) {
			  	// return $value->no_mak_7;

			  	for ($i=0; $i <= count($akun); $i++) { 
			  		
			  		$rpd = DB::table('detail_rpd')->where('no_mak_sys', 'LIKE', '%'. $value->no_mak_7 . $akun[$i] .'%')
			  										->where('level', 7)->count();
			  										// return $rpd;
			  		if ($rpd > 0) {
			  			
			  					// return count($rpd);
			  			$nomak[$key]['id'] = $value->kode_7;
			  			$nomak[$key]['no_mak'] = $value->no_mak_7;
			  			$nomak[$key]['uraian'] = $value->uraian_kegiatan; 


 			  		}
			  	}

			  }

			  // return $nomak;
			  $data['perjadins'] = $nomak;
 			 // return $data['update_data'];
 			 // die();			
			  
			  //Please use cbView method instead view method from laravel
			  $this->cbView('backend.pengajuan.perjadin.add',$data);
		}

		public function getEdit($id)
		{
			if(!CRUDBooster::isCreate() && $this->global_privilege==FALSE || $this->button_edit==FALSE) {    
				CRUDBooster::redirect(CRUDBooster::adminPath(),trans("crudbooster.denied_access"));
			  }
			  
			  $data = [];
			  $data['page_title'] = 'Edit Data';
			  $data['perjadin'] = DB::table('perjadin')->where('id' ,$id)->first(); 
			  $data['provinsi'] = DB::table('provinsi')->where('id' , $data['perjadin']->provinsi_id )->first(['id' , 'title']);
			  $data['kabkota'] 	= DB::table('kabkota')->where('id' , $data['perjadin']->kabkota_id )->first(['id' , 'nama']);
			  
			  // $data['akun']		= DB::table('rkakl')->where('no_urut' , $data['perjadin']->jenis_belanja)->first();
			  $data['id']		= $id;

			  // return $data;
			  // die();
		  
			  //Please use cbView method instead view method from laravel
			  $this->cbView('backend.pengajuan.perjadin.edit',$data);
		}

		public function senddraft($id)
		{
			//ubah status
			DB::table('perjadin')->where('id' , $id)->update(['status_id'=>2]);

				$to = '/admin/perjadin29';
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

		public function getkabkota($id)
		{
			$data = DB::table('kabkota')->where('provinsi_id' , $id)->get();
			return $data;
		}
		// public function getkegiatan(){
		// 	$data = DB::table('bagian_user')->where('user_id', CRUDBooster::MyId())->first();
		// 	$kegiatan = DB::table('kegiatan')->where('id', $data->kegiatan_id)->first();
		// 	return $kegiatan->nama;

		// }
	    //By the way, you can still create your own method in here... :) 


	}