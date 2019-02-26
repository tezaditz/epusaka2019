<?php namespace App\Http\Controllers;

	use Session;
	use Request;
	use DB;
	use CRUDBooster;
	use Carbon\carbon;

	class AdminHonorController extends \crocodicstudio\crudbooster\controllers\CBController {

	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "no_mak";
			$this->limit = "20";
			$this->orderby = "id,desc";
			$this->global_privilege = false;
			$this->button_table_action = true;
			$this->button_bulk_action = true;
			$this->button_action_style = "button_icon";
			$this->button_add = true;
			$this->button_edit = false;
			$this->button_delete = false;
			$this->button_detail = false;
			$this->button_show = true;
			$this->button_filter = false;
			$this->button_import = false;
			$this->button_export = false;
			$this->table = "honor";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"No Mak","name"=>"no_mak"];
			$this->col[] = ["label"=>"Nama Kegiatan","name"=>"nama_kegiatan"];
			$this->col[] = ["label"=>"No Pengajuan","name"=>"no_pengajuan"];
			$this->col[] = ["label"=>"Tgl Pengajuan","name"=>"tgl_pengajuan",'callback_php'=>'date("d M Y",strtotime($row->tgl_pengajuan))'];
			$this->col[] = ["label"=>"Jml Pengajuan","name"=>"jml_pengajuan", 'callback_php' => 'number_format($row->jml_pengajuan , 0 , "," , ".")'];
			$this->col[] = ["label"=>"Status","name"=>"status_id","join"=>"status,keterangan"];
			// $this->col[] = ["label"=>"Tahun Anggaran","name"=>"tahun_anggaran"];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ['label'=>'Bagian','name'=>'bagian_id','type'=>'text','validation'=>'required|integer|min:0','width'=>'col-sm-10' , 'readonly'=>true];
			$this->form[] = ['label'=>'No Mak','name'=>'rkakl_id','type'=>'select','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Nama Kegiatan','name'=>'nama_kegiatan','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10' , 'readonly'=>true];
			$this->form[] = ['label'=>'Tgl Awal','name'=>'tgl_awal','type'=>'date','validation'=>'required|date','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Tgl Akhir','name'=>'tgl_akhir','type'=>'date','validation'=>'required|date','width'=>'col-sm-10'];
			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ["label"=>"No Mak","name"=>"no_mak","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Judul","name"=>"judul","type"=>"text","required"=>TRUE,"validation"=>"required|string|min:3|max:70","placeholder"=>"You can only enter the letter only"];
			//$this->form[] = ["label"=>"Nama Kegiatan","name"=>"nama_kegiatan","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"No Pengajuan","name"=>"no_pengajuan","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Tgl Pengajuan","name"=>"tgl_pengajuan","type"=>"date","required"=>TRUE,"validation"=>"required|date"];
			//$this->form[] = ["label"=>"Jml Pengajuan","name"=>"jml_pengajuan","type"=>"money","required"=>TRUE,"validation"=>"required|integer|min:0"];
			//$this->form[] = ["label"=>"Tahun Anggaran","name"=>"tahun_anggaran","type"=>"date","required"=>TRUE,"validation"=>"required|date"];
			//$this->form[] = ["label"=>"Alasan","name"=>"alasan","type"=>"textarea","required"=>TRUE,"validation"=>"required|string|min:5|max:5000"];
			//$this->form[] = ["label"=>"Metode Id","name"=>"metode_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"metode,id"];
			//$this->form[] = ["label"=>"Tgl Awal","name"=>"tgl_awal","type"=>"date","required"=>TRUE,"validation"=>"required|date"];
			//$this->form[] = ["label"=>"Tgl Akhir","name"=>"tgl_akhir","type"=>"date","required"=>TRUE,"validation"=>"required|date"];
			//$this->form[] = ["label"=>"Bagian Id","name"=>"bagian_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"bagian,nama"];
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
			$this->addaction[] = ['label'=>'' ,'url'=>"/admin/hn/[id]/draft",'icon'=>'fa fa-eye','color'=>'info','showIf'=>"[status_id] == 1 Or [status_id] == 2 Or [status_id] == 3 Or [status_id] == 4  "];

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
			$this->load_js = array();
			$this->load_js[] = asset("js/pengajuan/honor.js");
	        
	        
	        
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
	            
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate row of index table html 
	    | ---------------------------------------------------------------------- 
	    |
	    */    
	    public function hook_row_index($column_index,&$column_value) {	        
			//Your code here
			if($column_index == 5)
			{
				$column_value	= "<div class ='text-right'>" .$column_value. "</div>";
			}
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
			$parameter 	= DB::table('parameter')->where('nama','Tahun Anggaran')->first();
			$postdata['bagian_id'] = $bagianuser->bagian_id;
			$postdata['status_id'] = 1;
			$postdata['metode_bayar_id'] = 5;

			$rkakl = DB::table('rkakl')->where('id' , $postdata['rkakl_id'])->first();

			$postdata['no_mak'] = $rkakl->no_mak;
			$postdata['nama_kegiatan'] = $rkakl->uraian;
			$postdata['no_pengajuan'] = $this->gen_no_pengajuan('honor');
			$postdata['tgl_pengajuan'] = Carbon::now();
			$postdata['jml_pengajuan'] = 0;
			$postdata['thnang'] = $parameter->nilai;
						


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
			$honor = DB::table('honor')->where('id' , $id)->first();
			$parameter = DB::table('parameter')->where('nama' , 'Akun Honor')->first();
			$akun = explode("," , $parameter->nilai);
			for ($i=0; $i < Count($akun) ; $i++) { 
				$rkakl = DB::table('rkakl')->where('no_mak_sys' , 'LIKE' , '%' . $honor->no_mak . '.' . $akun[$i] . '%')->get();
				// if(Count($rkakl)>0)
				// {
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


						$data['kegiatan_id'] 			=  $id;
						$data['jenis_transaksi'] 		=  'honor';
						$data['level'] 					=  $value->level;
						$data['header'] 			=  $value->header;
						$data['kode'] 				=  $uraian_akun;
						$data['no_mak'] 			=  $value->no_mak;
						$data['no_mak_sys'] 		=  $value->no_mak_sys;
						$data['uraian'] 			=  $value->uraian;
						$data['vol'] 				=  $value->vol;
						$data['sat'] 				=  $value->sat;
						$data['hargasat'] 		=  $value->hargasat;
						$data['jumlah'] 			=  $value->jumlah;
						$data['pengajuan'] 		=  0;
						$data['sisa_pagu'] 		=  $value->jumlah - ($value->realisasi_1 + $value->realisasi_2 + $value->realisasi_3);
					
						if($data)
						{
							DB::table('pilih_akun')->insert($data);
						}
					
					
					}
				// }
			}

				$to = '/admin/hn/' . $id . '/dakun';
				$message = 'master honor berhasil ditambahkan';
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
			$honor = DB::table('honor')->where('id' , $id)->first();

			$postdata['bagian_id'] = $honor->bagian_id;
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
				$to = '/admin/hn/' . $id . '/dakun';
				$message = 'master honor berhasil diubah';
				$type = 'info';
				CRUDBooster::redirect($to,$message,$type);
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
		
		public function getbagian()
		{
			$data = DB::table('bagian_user')->where('user_id' , CRUDBooster::myId())->first();
			$bagian = DB::table('bagian')->where('id' , $data->bagian_id)->first();

			return $bagian->nama;
		}

		public function getnomak()
		{
			$bagianuser = DB::table('bagian_user')->where('user_id' , CRUDBooster::myId())->first();
			$param_honor = DB::table('parameter')->where('nama' , 'Akun Honor')->first();
			$akun = explode("," , $param_honor->nilai);
			$linsek = DB::table('parameter')->where('nama' , 'MAK LINSEK')->first();
        	$perkantoran = DB::table('parameter')->where('nama' , 'Mak Perkantoran')->first();
			// $rpk = DB::table('m_rpk')->where('bagian_id' , $bagianuser->bagian_id)
			// 						->where('no_mak_7' , '!=' , $linsek->nilai)
			// 						->where('no_mak_7' , 'NOT LIKE' , '%' . $perkantoran->nilai . '%')
			// 						->get();
			$rpk = DB::table('m_rpk')->where('bagian_id' , $bagianuser->bagian_id)
									->where('no_mak_7' , 'NOT LIKE' , '%' . $perkantoran->nilai . '%')
									->where('no_mak_7' , 'NOT LIKE' , '%' . $linsek->nilai . '%')
									->get();

			
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

		public function fillnamakegiatan($id)
		{
			$data = DB::table('rkakl')->where('id' , $id)->first();
			return $data->uraian;
		}

		public function getAdd()
		{
			if(!CRUDBooster::isCreate() && $this->global_privilege==FALSE || $this->button_add==FALSE) {    
				CRUDBooster::redirect(CRUDBooster::adminPath(),trans("crudbooster.denied_access"));
			  }
			  
			  $data = [];
			  $data['page_title'] = 'Add Data';
			  $data['nomak'] = $this->getnomak();
			  
			  
			  //Please use cbView method instead view method from laravel
			  $this->cbView('backend.pengajuan.honor.add',$data);
		}

		public function gen_no_pengajuan($jenis_transaksi)
		{
			// generate nomor pengajuan
			$bagianuser = DB::table('bagian_user')->where('user_id' , CRUDBooster::myId())->first();
			$bagian 	= DB::table('bagian')->where('id' , $bagianuser->bagian_id)->first();
			$parameter 	= DB::table('parameter')->where('nama','Tahun Anggaran')->first();
			$dataPengajuan = DB::table('no_pengajuan')->where('bagian_id' , $bagianuser->bagian_id)
			->where('jenis' , $jenis_transaksi)
			->get();

			if(Count($dataPengajuan) == 0)
			{
				$data = [];
				$data['bagian_id'] 	= $bagianuser->bagian_id;
				$data['nomor'] 		= 1;
				$data['jenis'] 		= $jenis_transaksi;

				DB::table('no_pengajuan')->insert($data);
				$nomor = 1;
			}
			else
			{
				$data = DB::table('no_pengajuan')->where('bagian_id' , $bagianuser->bagian_id)
										->where('jenis' , $jenis_transaksi)
										->first();

				$nomor = $data->nomor + 1;
				DB::table('no_pengajuan')->where('bagian_id' , $bagianuser->bagian_id)
						->where('jenis' , $jenis_transaksi)
						->update(['nomor' => $nomor
						]);
			}

			$nomor_pengajuan = "AJU-" . $nomor . '/' . $bagian->kode . '/' . $parameter->nilai;
			// end generate nomor pengajuan
			return $nomor_pengajuan;
		}

		public function detail_akun($id)
		{
			$data = [];
			$data['page_title'] = 'Pilih Akun';
			$data['row'] = DB::table('detail_akun')->where('kegiatan_id',$id)
			->where('jenis_transaksi' , 'honor')
			->get();
			$data['id'] = $id;

			//Please use cbView method instead view method from laravel
			$this->cbView('backend.pengajuan.honor.detailakun',$data);
		}

		public function getDraft($id)
		{
			//Create an Auth

			
			$data = [];
			$data['page_title'] = 'Draft Honor';
			$data['row'] = DB::table('honor')->where('id',$id)->first();
			$data['status'] = DB::table('status')->where('id' , $data['row']->status_id)->first();
			$data['bagian'] = DB::table('bagian')->where('id' , $data['row']->bagian_id)->first();
			
			$data['detail'] = DB::table('detail_honor')
			->where('level' , 0)
			->where('honor_id' , $id)
			->where('jumlah_pengajuan' , '!=' , 0)->get();

			$data['id'] = $id;
			$data['metode_bayar'] 	= DB::table('metode_bayar')->get();
			$data['status_bend']	= DB::table('status')
			->where('kode_status' , 'LIKE' , '%BEND%')
			->get(['id' , 'keterangan']);
			$data['result'] = DB::table('penerima_honor')->where('honor_id' , $id)->get();
			
			//Please use cbView method instead view method from laravel
			$this->cbView('backend.pengajuan.honor.draft',$data);
		}

		public function senddraft($id)
		{
			//ubah status
			DB::table('honor')->where('id' , $id)->update(['status_id'=>2]);

				$to = '/admin/honor';
				$message = 'Pengajuan Honor Berhasil dikirim';
				$type = 'info';
				CRUDBooster::redirect($to,$message,$type);
		}

		public function getEdit($id)
		{
			if(!CRUDBooster::isCreate() && $this->global_privilege==FALSE || $this->button_add==FALSE) {    
				CRUDBooster::redirect(CRUDBooster::adminPath(),trans("crudbooster.denied_access"));
			  }
			  
			  $data = [];
			  $data['page_title'] = 'Add Data';
			  $data['master'] = DB::table('honor')->where('id' , $id)->first();
			  $data['bagian'] = DB::table('bagian')->where('nama' , '!=' , 'All')->get();
			  $data['no_mak'] = $this->getnomak();
			  $data['id'] = $id;

			//   return $data;
			  
		  
			  //Please use cbView method instead view method from laravel
			  $this->cbView('backend.pengajuan.honor.edit',$data);
		}

		

	    //By the way, you can still create your own method in here... :) 


	}