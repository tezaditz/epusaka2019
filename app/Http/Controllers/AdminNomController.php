<?php namespace App\Http\Controllers;

	use Session;
	use Request;
	use DB;
	use CRUDBooster;
	use Maatwebsite\Excel\Facades\Excel;
	use Carbon\carbon;

	class AdminNomController extends \crocodicstudio\crudbooster\controllers\CBController {

	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "nama_peserta";
			$this->limit = "20";
			$this->orderby = "id,asc";
			$this->global_privilege = false;
			$this->button_table_action = true;
			$this->button_bulk_action = true;
			$this->button_action_style = "button_icon";
			$this->button_add = false;
			$this->button_edit = true;
			$this->button_delete = true;
			$this->button_detail = true;
			$this->button_show = true;
			$this->button_filter = true;
			$this->button_import = false;
			$this->button_export = false;
			$this->table = "nominatif";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"Nama Peserta","name"=>"nama_peserta"];
			$this->col[] = ["label"=>"Nip","name"=>"nip"];
			$this->col[] = ["label"=>"Gol","name"=>"gol"];
			$this->col[] = ["label"=>"Instansi","name"=>"instansi"];
			$this->col[] = ["label"=>"Tgl Berangkat","name"=>"tgl_berangkat"];
			$this->col[] = ["label"=>"Tgl Kembali","name"=>"tgl_kembali"];
			$this->col[] = ["label"=>"Lama","name"=>"lama"];
			$this->col[] = ["label"=>"Tiket Pesawat","name"=>"tiket_pesawat"];
			$this->col[] = ["label"=>"Taksi Provinsi","name"=>"taksi_provinsi"];
			$this->col[] = ["label"=>"Taksi Kabupaten","name"=>"taksi_kabupaten"];
			$this->col[] = ["label"=>"Uang Harian","name"=>"uang_harian"];
			$this->col[] = ["label"=>"Penginapan","name"=>"penginapan"];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ['label'=>'Kegiatan Id','name'=>'kegiatan_id','type'=>'text','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Jenis Peserta','name'=>'jenis_peserta','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Peserta Id','name'=>'peserta_id','type'=>'text','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'peserta,id'];
			$this->form[] = ['label'=>'Nama Peserta','name'=>'nama_peserta','type'=>'select2','validation'=>'required|min:1|max:255','width'=>'col-sm-10','datatable'=>'pegawai,nama'];
			$this->form[] = ['label'=>'Nip','name'=>'nip','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Gol','name'=>'gol','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Instansi','name'=>'instansi','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Daerah Asal','name'=>'daerah_asal','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Prov Daerah Tujuan','name'=>'prov_daerah_tujuan','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Kab Daerah Tujuan','name'=>'kab_daerah_tujuan','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Tgl Berangkat','name'=>'tgl_berangkat','type'=>'date','validation'=>'required|date','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Tgl Kembali','name'=>'tgl_kembali','type'=>'date','validation'=>'required|date','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Lama','name'=>'lama','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Tiket Pesawat','name'=>'tiket_pesawat','type'=>'money','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Uang Harian','name'=>'uang_harian','type'=>'money','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Penginapan','name'=>'penginapan','type'=>'money','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Taksi Provinsi','name'=>'taksi_provinsi','type'=>'money','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Taksi Kabupaten','name'=>'taksi_kabupaten','type'=>'money','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ['label'=>'Kegiatan Id','name'=>'kegiatan_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'kegiatan,id'];
			//$this->form[] = ['label'=>'Jenis Peserta','name'=>'jenis_peserta','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Peserta Id','name'=>'peserta_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'peserta,id'];
			//$this->form[] = ['label'=>'Nama Peserta','name'=>'nama_peserta','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Nip','name'=>'nip','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Gol','name'=>'gol','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Instansi','name'=>'instansi','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Daerah Asal','name'=>'daerah_asal','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Prov Daerah Tujuan','name'=>'prov_daerah_tujuan','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Kab Daerah Tujuan','name'=>'kab_daerah_tujuan','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Tgl Berangkat','name'=>'tgl_berangkat','type'=>'date','validation'=>'required|date','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Tgl Kembali','name'=>'tgl_kembali','type'=>'date','validation'=>'required|date','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Lama','name'=>'lama','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Tiket Pesawat','name'=>'tiket_pesawat','type'=>'money','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Uang Harian','name'=>'uang_harian','type'=>'money','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Penginapan','name'=>'penginapan','type'=>'money','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Taksi Provinsi','name'=>'taksi_provinsi','type'=>'money','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Taksi Kabupaten','name'=>'taksi_kabupaten','type'=>'money','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
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
			$this->load_js = array();
			$this->load_js[] = asset("js/pengajuan/nominatif.js");
	        
	        
	        
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
		
		public function getIndex($id)
		{
			//First, Add an auth
				if(!CRUDBooster::isView())
				{
					CRUDBooster::redirect(CRUDBooster::adminPath(),trans('crudbooster.denied_access'));
   				};
			//Create your own query 
			$data = [];
			$data['page_title'] = 'List Nominatif';
			$data['result'] = DB::table('nominatif')
			->where('kegiatan_id' , $id)
			->orderby('id','asc')->paginate(50);
			$data['id'] = $id;
			$data['pegawai'] = DB::table('pegawai')->get();
			 
			//Create a view. Please use `cbView` method instead of view method from laravel.
			$this->cbView('backend.pengajuan.kegiatan.nominatif.index',$data);
		}

		public function getAdd($id)
		{
			if(!CRUDBooster::isCreate() && $this->global_privilege==FALSE || $this->button_add==FALSE) {    
				CRUDBooster::redirect(CRUDBooster::adminPath(),trans("crudbooster.denied_access"));
			  }
			  
			  $data = [];
			  $data['page_title'] = 'Tambah Pelaksana';
			  $data['pegawai'] = DB::table('pegawai')->get();
			  $data['id'] = $id;
			  
			  //Please use cbView method instead view method from laravel
			  $this->cbView('backend.pengajuan.kegiatan.nominatif.add',$data);
		}

		public function AddGuest($id)
		{
			
			if(!CRUDBooster::isCreate() && $this->global_privilege==FALSE || $this->button_add==FALSE) {    
				CRUDBooster::redirect(CRUDBooster::adminPath(),trans("crudbooster.denied_access"));
			  }
			  
			  $data = [];
			  $data['page_title'] = 'Tambah Pelaksana';
			  $data['tamu'] = DB::table('tamu')->get();
			  $data['id'] = $id;
			  
			  //Please use cbView method instead view method from laravel
			  $this->cbView('backend.pengajuan.kegiatan.nominatif.tamu',$data);
		}

		public function getDataPegawai($id)
		{
			$data = [];
			$pegawai= DB::table('pegawai')->where('id' , $id)->first();
			$pangkat = DB::table('pangkat')->where('id' , $pegawai->pangkat_id)->first();
			$jabatan = DB::table('jabatan')->where('id' , $pegawai->jabatan_id)->first();

			$data['nama_pegawai'] 	= $pegawai->nama;
			$data['nip'] 			= $pegawai->nip;
			$data['gol'] 			= $pangkat->nama .'|' .  $pangkat->golongan;
			$data['jabatan'] 		= $jabatan->name;

			return $data;		
			
		}

		public function getDataTamu($id)
		{
			$data = [];
			$tamu= DB::table('tamu')->where('id' , $id)->first();
			
			

			$data['nama_pegawai'] 	= $tamu->nama;
			$data['nip'] 			= $tamu->nip;
			$data['instansi'] 			= $tamu->instansi;
			$data['jabatan'] 		= $tamu->jabatan;

			return $data;		
			
		}

		// PERJADIN

		public function getIndexPerjadin($id)
		{
			//First, Add an auth
				// if(!CRUDBooster::isView())
				// {
				// 	CRUDBooster::redirect(CRUDBooster::adminPath(),trans('crudbooster.denied_access'));
   			// 			};
			//Create your own query 
			$data = [];
			$data['page_title'] = 'List Nominatif';
			$data['result'] = DB::table('data_perjadin')
			->where('perjadin_id' , $id)
			->orderby('id','asc')->paginate(10);
			$data['id'] = $id;
			$data['pegawai'] = DB::table('pegawai')->get();
			 
			//Create a view. Please use `cbView` method instead of view method from laravel.
			$this->cbView('backend.pengajuan.perjadin.nominatif.index',$data);
		}

		public function getAddPerjadin($id)
		{
			// if(!CRUDBooster::isCreate() && $this->global_privilege==FALSE || $this->button_add==FALSE) {    
			// 	CRUDBooster::redirect(CRUDBooster::adminPath(),trans("crudbooster.denied_access"));
			//   }
			  
			  $data = [];
			  $data['page_title'] = 'Tambah Pelaksana';
			  $data['pegawai'] = DB::table('pegawai')->get();
			  $data['id'] = $id;
			  
			  //Please use cbView method instead view method from laravel
			  $this->cbView('backend.pengajuan.perjadin.nominatif.add',$data);
		}

		public function AddGuestPerjadin($id)
		{
			
			if(!CRUDBooster::isCreate() && $this->global_privilege==FALSE || $this->button_add==FALSE) {    
				CRUDBooster::redirect(CRUDBooster::adminPath(),trans("crudbooster.denied_access"));
			  }
			  
			  $data = [];
			  $data['page_title'] = 'Tambah Pelaksana';
			  $data['tamu'] = DB::table('tamu')->get();
			  $data['id'] = $id;
			  
			  //Please use cbView method instead view method from laravel
			  $this->cbView('backend.pengajuan.perjadin.nominatif.tamu',$data);
		}

		public function getDataPegawaiPerjadin($id)
		{
			$data = [];
			$pegawai= DB::table('pegawai')->where('id' , $id)->first();
			$pangkat = DB::table('pangkat')->where('id' , $pegawai->pangkat_id)->first();
			$jabatan = DB::table('jabatan')->where('id' , $pegawai->jabatan_id)->first();

			$data['nama_pegawai'] 	= $pegawai->nama;
			$data['nip'] 			= $pegawai->nip;
			$data['gol'] 			= $pangkat->nama .'|' .  $pangkat->golongan;
			$data['jabatan'] 		= $jabatan->name;

			return $data;		
			
		}

		public function getDataTamuPerjadin($id)
		{
			$data = [];
			$tamu= DB::table('tamu')->where('id' , $id)->first();
			
			

			$data['nama_pegawai'] 	= $tamu->nama;
			$data['nip'] 			= $tamu->nip;
			$data['instansi'] 			= $tamu->instansi;
			$data['jabatan'] 		= $tamu->jabatan;

			return $data;		
			
		}

		public function download_perjadin($id)
		{
			ini_set('memory_limit', '1024M');
			set_time_limit(180);
			
			$data = DB::table('perjadin')->where('id' , $id)->first();
			$prov = DB::table('provinsi')->where('id' , $data->provinsi_id)->first();
			

			Excel::create($data->nama_kegiatan, function ($excel) use ($data , $prov) {
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
					$sheet->setCellValue('A3', $data->nama_kegiatan);
					$sheet->setCellValue('A4', ($prov->title . ', ' . date('d M', strtotime($data->tgl_awal)) . ' s.d ' . date('d M Y', strtotime($data->tgl_akhir))));

					$sheet->mergeCells('A6:A7');
					$sheet->mergeCells('B6:B7');
					$sheet->mergeCells('C6:C7');
					$sheet->mergeCells('D6:D7');
					$sheet->mergeCells('E6:E7');
					$sheet->mergeCells('F6:F7');
					$sheet->mergeCells('G6:G7');
					$sheet->mergeCells('H6:H7');
					$sheet->mergeCells('I6:I7');
					$sheet->mergeCells('J6:K6');
					$sheet->mergeCells('L6:M6');
					$sheet->mergeCells('N6:N7');
					$sheet->cells('A6:N7', function($cells) {
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
					$sheet->setCellValue('F6', 'HARI');
					$sheet->setCellValue('G6', 'TIKET PESAWAT');
					$sheet->setCellValue('H6', 'TAKSI PROVINSI');
					$sheet->setCellValue('I6', 'TAKSI KAB');
					$sheet->setCellValue('J6', 'UANG HARIAN');
					$sheet->setCellValue('J7', 'SATUAN');
					$sheet->setCellValue('K7', 'TOTAL');
					$sheet->setCellValue('L6', 'PENGINAPAN');
					$sheet->setCellValue('L7', 'SATUAN');
					$sheet->setCellValue('M7', 'TOTAL');
					$sheet->setCellValue('N6', 'JUMLAH');
					

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
						'G6' => array(
							'width' => 15
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

		public function reset_nominatid_perjadin($id)
		{
			DB::table('data_perjadin')->where('perjadin_id' , $id)->delete();
			$to = '/admin/perjadin/'. $id .'/nominatif';
            $message = 'Data berhasil di Hapus';
            $type = 'success';
            CRUDBooster::redirect($to,$message,$type);
		}

		public function download_nominatif($id)
		{
			ini_set('memory_limit', '1024M');
			set_time_limit(180);
			
			$data = DB::table('perjadin')->where('id' , $id)->first();
			$prov = DB::table('provinsi')->where('id' , $data->provinsi_id)->first();
			

			Excel::create($data->nama_kegiatan, function ($excel) use ($data , $prov , $id) {
				$excel->getProperties()->setCreator("Maarten Balliauw")
					->setLastModifiedBy("Data Solusion Comindo")
					->setTitle("Office 2007 XLSX Test Document")
					->setSubject("Office 2007 XLSX Test Document")
					->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
					->setKeywords("office 2007 openxml php")
					->setCategory("Test result file");
				$excel->sheet('sheet_1', function ($sheet) use ($data , $prov, $id) {
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
					$sheet->setCellValue('A3', $data->nama_kegiatan);
					$sheet->setCellValue('A4', ($prov->title . ', ' . date('d M', strtotime($data->tgl_awal)) . ' s.d ' . date('d M Y', strtotime($data->tgl_akhir))));

					$sheet->mergeCells('A6:A7');
					$sheet->mergeCells('B6:B7');
					$sheet->mergeCells('C6:C7');
					$sheet->mergeCells('D6:D7');
					$sheet->mergeCells('E6:E7');
					$sheet->mergeCells('F6:F7');
					$sheet->mergeCells('G6:G7');
					$sheet->mergeCells('H6:H7');
					$sheet->mergeCells('I6:I7');
					$sheet->mergeCells('J6:K6');
					$sheet->mergeCells('L6:M6');
					$sheet->mergeCells('N6:N7');
					$sheet->cells('A6:N7', function($cells) {
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
					$sheet->setCellValue('F6', 'HARI');
					$sheet->setCellValue('G6', 'TIKET PESAWAT');
					$sheet->setCellValue('H6', 'TAKSI PROVINSI');
					$sheet->setCellValue('I6', 'TAKSI KAB');
					$sheet->setCellValue('J6', 'UANG HARIAN');
					$sheet->setCellValue('J7', 'SATUAN');
					$sheet->setCellValue('K7', 'TOTAL');
					$sheet->setCellValue('L6', 'PENGINAPAN');
					$sheet->setCellValue('L7', 'SATUAN');
					$sheet->setCellValue('M7', 'TOTAL');
					$sheet->setCellValue('N6', 'JUMLAH');
					

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
						'G6' => array(
							'width' => 15
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

					$nom = DB::table('data_perjadin')->where('perjadin_id' , $id)->get();
					
					// ISI DATA
					$row = 8;
					$total_pesawat = 0;$total_taksi_prov = 0;$total_taksi_kab = 0;$total_uh = 0;$total_inap = 0;$total_semua = 0;
					foreach ($nom as $key => $value) {
						$rows = $row + $key;
						$sheet->setCellValue('A' . $rows , $key + 1);
						$sheet->setCellValue('B' . $rows, $value->nama_pelaksana);
						$sheet->setCellValue('C' . $rows, $value->nip);
						$sheet->setCellValue('D' . $rows, $value->instansi);
						$sheet->setCellValue('E' . $rows, $value->gol);
						$sheet->setCellValue('F' . $rows, $value->lama);
						$sheet->setCellValue('G' . $rows, $value->tiket_pesawat);
						$sheet->setCellValue('H' . $rows, $value->taksi_provinsi);
						$sheet->setCellValue('I' . $rows, $value->taksi_kabkota);
						$sheet->setCellValue('J' . $rows, $value->uang_harian / $value->lama);
						$sheet->setCellValue('K' . $rows, $value->uang_harian);
						$sheet->setCellValue('L' . $rows, $value->penginapan / $value->lama);
						$sheet->setCellValue('M' . $rows, $value->penginapan);
						$sheet->setCellValue('N' . $rows, $value->tiket_pesawat + $value->taksi_provinsi + $value->taksi_kabkota + $value->uang_harian + $value->penginapan  );

						$total_pesawat 		= $total_pesawat + $value->tiket_pesawat;
						$total_taksi_prov 	= $total_taksi_prov + $value->taksi_provinsi;
						$total_taksi_kab 	= $total_taksi_kab + $value->taksi_kabkota;
						$total_uh 			= $total_uh + $value->uang_harian;
						$total_inap 		= $total_inap + $value->penginapan;
						
					}
					// END ISI DATA

					$total_semua 		= $total_pesawat + $total_taksi_prov + $total_taksi_kab + $total_uh + $total_inap ;
					// row total
					$row = $row + $key + 1;
					$sheet->mergeCells('A' . $row . ':F' . $row );
					$sheet->cells('A' . $row . ':N' . $row , function($cells) {
						$cells->setAlignment('right');
						$cells->setValignment('right');
						$cells->setFontWeight('bold');
						$cells->setBackground('#cccfd4');
					});
					$sheet->mergeCells('J' . $row . ':K' . $row );
					$sheet->mergeCells('L' . $row . ':M' . $row );
					$sheet->setCellValue('A' . $row, 'TOTAL');
					$sheet->setCellValue('G' . $row, $total_pesawat);
					$sheet->setCellValue('H' . $row, $total_taksi_prov);
					$sheet->setCellValue('i' . $row, $total_taksi_kab);
					$sheet->setCellValue('J' . $row, $total_uh);
					$sheet->setCellValue('L' . $row, $total_inap);
					$sheet->setCellValue('N' . $row, $total_semua);

					$sheet->setColumnFormat(array(
						'G' => '0',
						'H' => '0',
						'I' => '0',
						'J' => '0',
						'K' => '0',
						'L' => '0',
						'M' => '0',
						'N' => '0',
					));

				});
			})->download('xlsx');
		}

		public function download_tandaterima($id)
		{
			ini_set('memory_limit', '1024M');
			set_time_limit(180);
			
			$data = DB::table('perjadin')->where('id' , $id)->first();
			$prov = DB::table('provinsi')->where('id' , $data->provinsi_id)->first();
			

			Excel::create('Tanda Terima Uang Muka ' . $data->nama_kegiatan, function ($excel) use ($data , $prov , $id) {
				$excel->getProperties()->setCreator("Maarten Balliauw")
					->setLastModifiedBy("Data Solusion Comindo")
					->setTitle("Office 2007 XLSX Test Document")
					->setSubject("Office 2007 XLSX Test Document")
					->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
					->setKeywords("office 2007 openxml php")
					->setCategory("Test result file");
				$excel->sheet('sheet_1', function ($sheet) use ($data , $prov , $id) {
					// header
					$sheet->mergeCells('A1:G1');
					$sheet->setCellValue('A1', 'TANDA TERIMA UANG MUKA');
					

					$sheet->cells('A1', function($cells) {
						$cells->setAlignment('center');
						$cells->setValignment('center');
						$cells->setFontWeight('bold');
						
					});

					$ta = DB::table('parameter')->where('nama' , 'Tahun Anggaran')->first();
					$sheet->setCellValue('F3', 'TA :' . $ta->nilai );
					$sheet->setCellValue('F4', 'MAK :' . $data->no_mak );
					$sheet->setCellValue('B7', 'Sudah Terima Dari');
					$sheet->setCellValue('C7', ':');
					$sheet->setCellValue('D7', 'Bendahara Pengeluaran');
					$sheet->setCellValue('B8', 'Kegiatan');
					$sheet->setCellValue('C8', ':');
					$sheet->setCellValue('D8', $data->nama_kegiatan);
					$sheet->setCellValue('B9', 'Kegiatan');
					$sheet->setCellValue('C9', ':');
					$sheet->setCellValue('D9', date('d M', strtotime($data->tgl_awal)) . ' s.d ' . date('d M Y', strtotime($data->tgl_akhir)));
					$sheet->setCellValue('B10', 'Lokasi Kegiatan');
					$sheet->setCellValue('C10', ':');
					$sheet->setCellValue('D10', $prov->title);
					$sheet->setCellValue('B11', 'Rincian');

					$sheet->setSize(array(
						'A6' => array(
							'width' => 5,
						),
						'B6' => array(
							'width' => 25,
						),
						'C6' => array(
							'width' => 2,
						),
						'D6' => array(
							'width' => 20
						),
						'E6' => array(
							'width' => 25
						),
						'F6' => array(
							'width' => 25
						)
					));

					$pelaksana = DB::table('data_perjadin')->where('perjadin_id' , $id)->get();
					$no_romawi = ['I' , 'II' , 'III' , 'IV'];
					$row_start = 13;
					foreach ($pelaksana as $key => $value) {
						$rows = $row_start + $key;
						$sheet->setCellValue('A' . $rows , $no_romawi[$key]);
						$sheet->setCellValue('B' . $rows , 'Uang Muka a.n');
						$sheet->setCellValue('C' . $rows , ':');
						$sheet->setCellValue('D' . $rows , $value->nama_pelaksana);

						$rows = $rows + 1;
						$sheet->setCellValue('A' . $rows , 'NO');
						$sheet->setCellValue('B' . $rows , 'RINCIAN');
						$sheet->setCellValue('D' . $rows , 'UANG MUKA');
						$sheet->setCellValue('E' . $rows , 'DIPERTANGGUNGJAWABKAN');
						$sheet->setCellValue('F' . $rows , 'DIKEMBALIKAN');

						$rows = $rows + 1;
						$sheet->setCellValue('A' . $rows , '1');
						$sheet->setCellValue('B' . $rows , 'Uang Harian ('. $value->lama.' Hari)');
						$sheet->setCellValue('D' . $rows , $value->uang_harian);
						$sheet->setCellValue('E' . $rows , '0');
						$sheet->setCellValue('F' . $rows , '0');

						$rows = $rows + 1;
						$sheet->setCellValue('A' . $rows , '2');
						$lama = $value->lama - 1;
						$sheet->setCellValue('B' . $rows , 'Penginapan ('. $lama .' Hari)');
						$sheet->setCellValue('D' . $rows , $value->penginapan);
						$sheet->setCellValue('E' . $rows , '0');
						$sheet->setCellValue('F' . $rows , '0');

						$rows = $rows + 1;
						$sheet->setCellValue('A' . $rows , '3');
						$sheet->setCellValue('B' . $rows , 'Taksi');
						$total_taksi = $value->taksi_provinsi + $value->taksi_kabupaten;
						$sheet->setCellValue('D' . $rows , $total_taksi);
						$sheet->setCellValue('E' . $rows , '0');
						$sheet->setCellValue('F' . $rows , '0');

						$rows = $rows + 1;
						$sheet->setCellValue('A' . $rows , '4');
						$sheet->setCellValue('B' . $rows , 'Pesawat');
						$sheet->setCellValue('D' . $rows , $value->tiket_pesawat);
						$sheet->setCellValue('E' . $rows , '0');
						$sheet->setCellValue('F' . $rows , '0');

						$col = ['A' , 'C' , 'E'];
						$sheet->setCellValue( '' . $col[$key] .'26' , 'Pelaksana '.$no_romawi[$key].' ');
						$sheet->setCellValue( '' . $col[$key] .'31' , $value->nama_pelaksana);
						$sheet->setCellValue( '' . $col[$key] .'32' , 'NIP. ' . $value->nip);

						$sheet->setCellValue('F8' , 'Mengetahui,');

					}

					$rows = $rows + 2;
					$sheet->setCellValue('B' . $rows , 'TOTAL DITERIMA');
					$sheet->setCellValue('D' . $rows , $value->tiket_pesawat + $value->uang_harian + $value->taksi_kabupaten + $value->taksi_provinsi + $value->penginapan);
					$sheet->setCellValue('E' . $rows , '0');
					$sheet->setCellValue('F' . $rows , '0');

					$rows = $rows + 3;
					$sheet->setCellValue('B' . $rows , 'Barang/Pekerjaan tersebut telah diterima dengan lengkap dan baik');

					$rows = $rows + 1;
					
					$sheet->setCellValue('B' . $rows , 'Jakarta,'. date('d M', strtotime(Carbon::now())) .'');

					
				});
					
			})->download('xlsx');
		}



		



	    //By the way, you can still create your own method in here... :) 


	}