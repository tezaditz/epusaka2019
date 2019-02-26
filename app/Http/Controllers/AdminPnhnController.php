<?php namespace App\Http\Controllers;

	use Session;
	use Request;
	use DB;
	use CRUDBooster;
	use Maatwebsite\Excel\Facades\Excel;
	use Carbon\carbon;
	
	use Illuminate\Support\Facades\Input;

	class AdminPnhnController extends \crocodicstudio\crudbooster\controllers\CBController {

	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "nama_penerima";
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
			$this->table = "penerima_honor";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"Nama Penerima","name"=>"nama_penerima"];
			$this->col[] = ["label"=>"Nip","name"=>"nip"];
			$this->col[] = ["label"=>"Instansi","name"=>"instansi"];
			$this->col[] = ["label"=>"Npwp","name"=>"npwp"];
			$this->col[] = ["label"=>"Gol","name"=>"gol"];
			$this->col[] = ["label"=>"Jumlah Honor","name"=>"jumlah_honor"];
			$this->col[] = ["label"=>"Jumlah Terima","name"=>"jumlah_terima"];
			$this->col[] = ["label"=>"Jumlah Terima","name"=>"jumlah_terima"];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ['label'=>'Honor','name'=>'id_honor','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'honor,nama_kegiatan'];
			$this->form[] = ['label'=>'Nama Penerima','name'=>'nama_penerima','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Nip','name'=>'nip','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Instansi','name'=>'instansi','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Npwp','name'=>'npwp','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Gol','name'=>'gol','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Jumlah Honor','name'=>'jumlah_honor','type'=>'money','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Jumlah Potongan','name'=>'jumlah_potongan','type'=>'money','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Jumlah Terima','name'=>'jumlah_terima','type'=>'money','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ["label"=>"Honor","name"=>"id_honor","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"honor,nama_kegiatan"];
			//$this->form[] = ["label"=>"Nama Penerima","name"=>"nama_penerima","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Nip","name"=>"nip","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Instansi","name"=>"instansi","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Npwp","name"=>"npwp","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Gol","name"=>"gol","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Jumlah Honor","name"=>"jumlah_honor","type"=>"money","required"=>TRUE,"validation"=>"required|integer|min:0"];
			//$this->form[] = ["label"=>"Jumlah Potongan","name"=>"jumlah_potongan","type"=>"money","required"=>TRUE,"validation"=>"required|integer|min:0"];
			//$this->form[] = ["label"=>"Jumlah Terima","name"=>"jumlah_terima","type"=>"money","required"=>TRUE,"validation"=>"required|integer|min:0"];
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
			$this->load_js[] = asset("js/pengajuan/hn_nominatif.js");
	        
	        
	        
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

		public function getIndex()
		{
			//First, Add an auth
			// if(!CRUDBooster::isView()) CRUDBooster::redirect(CRUDBooster::adminPath(),trans('crudbooster.denied_access'));
			//Create your own query 
			
		}
		public function getAdd()
		{
			// if(!CRUDBooster::isCreate() && $this->global_privilege==FALSE || $this->button_add==FALSE) {    
			// 	CRUDBooster::redirect(CRUDBooster::adminPath(),trans("crudbooster.denied_access"));
			//   }
			  
			  $data = [];
			  $data['page_title'] = 'Tambah Pelaksana';
			  $data['pegawai'] = DB::table('pegawai')->get();
			  $data['id'] = $id;
			  
			  //Please use cbView method instead view method from laravel
			  $this->cbView('backend.pengajuan.honor.nominatif.add',$data);
		}

		public function AddGuest($id)
		{
			
			// if(!CRUDBooster::isCreate() && $this->global_privilege==FALSE || $this->button_add==FALSE) {    
			// 	CRUDBooster::redirect(CRUDBooster::adminPath(),trans("crudbooster.denied_access"));
			//   }
			  
			  $data = [];
			  $data['page_title'] = 'Tambah Pelaksana';
			  $data['tamu'] = DB::table('tamu')->get();
			  $data['id'] = $id;
			  
			  //Please use cbView method instead view method from laravel
			  $this->cbView('backend.pengajuan.honor.nominatif.tamu',$data);
		}

		public function list_nominatif_honor($id)
		{
			if(!CRUDBooster::myId())
			{
				return redirect('/');
			}
			$data = [];
			$data['page_title'] = 'List Nominatif';
			$data['result'] = DB::table('penerima_honor')->where('honor_id' , $id)->orderby('id','asc')->paginate(10);
			$data['id'] = $id;
			$data['pegawai'] = DB::table('pegawai')->get();
			
			// return $data;
			//Create a view. Please use `cbView` method instead of view method from laravel.
			$this->cbView('backend.pengajuan.honor.nominatif.index',$data);
		}

		public function download_honor($id)
		{
			ini_set('memory_limit', '1024M');
			set_time_limit(180);
			
			$data = DB::table('honor')->where('id' , $id)->first();
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
					$sheet->mergeCells('A1:N1');
					$sheet->mergeCells('A2:N2');
					$sheet->mergeCells('A3:N3');

					$sheet->cells('A1:A4', function($cells) {
						$cells->setAlignment('center');
						$cells->setValignment('center');
						$cells->setFontWeight('bold');
					});
					$sheet->setCellValue('A1', 'DAFTAR TANDA TERIMA HONOR');
					$sheet->setCellValue('A2', $data->nama_kegiatan);
					$sheet->setCellValue('A3', (date('d M', strtotime($data->tgl_awal)) . ' s.d ' . date('d M Y', strtotime($data->tgl_akhir))));

					// $sheet->mergeCells('A6:A7');
					// $sheet->mergeCells('B6:B7');
					// $sheet->mergeCells('C6:C7');
					// $sheet->mergeCells('D6:D7');
					// $sheet->mergeCells('E6:E7');
					$sheet->mergeCells('F6:G6');
					$sheet->mergeCells('H6:I6');
					$sheet->mergeCells('J6:K6');
					$sheet->mergeCells('L6:M6');
					$sheet->mergeCells('N6:O6');
					$sheet->cells('A6:N6', function($cells) {
						$cells->setAlignment('center');
						$cells->setValignment('center');
						$cells->setFontWeight('bold');
						$cells->setBackground('#cccfd4');
					});
					$sheet->setCellValue('A6', 'NO');
					$sheet->setCellValue('B6', 'NAMA');
					$sheet->setCellValue('C6', 'INSTANSI \ JABATAN');
					$sheet->setCellValue('D6', 'NO.NPWP');
					$sheet->setCellValue('E6', 'NO.KTP');
					$sheet->setCellValue('F6', 'HONOR');
					$sheet->setCellValue('F7', 'Rp');
					$sheet->setCellValue('H6', 'SELAMA');
					$sheet->setCellValue('H7', '1');
					$sheet->setCellValue('I7', 'JAM/KALI');
					$sheet->setCellValue('J6', 'JUMLAH');
					$sheet->setCellValue('J7', 'Rp');
					$sheet->setCellValue('L6', 'POTONGAN');
					$sheet->setCellValue('L7', 'Rp');
					$sheet->setCellValue('N6', 'TOTAL');
					$sheet->setCellValue('N7', 'Rp');
										

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
						'E6' => array(
							'width' => 20
						),
						'F6' => array(
							'width' => 5
						),
						'G6' => array(
							'width' => 15
						),
						'H6' => array(
							'width' => 5
						),
						'I6' => array(
							'width' => 15
						),
						'J6' => array(
							'width' => 5
						),
						'K6' => array(
							'width' => 15
						),
						'L6' => array(
							'width' => 5
						),
						'M6' => array(
							'width' => 15
						),
						'N6' => array(
							'width' => 5
						),
						'O6' => array(
							'width' => 15
						)
					));
				});
			})->download('xlsx');
		}

		

	    //By the way, you can still create your own method in here... :) 


	}