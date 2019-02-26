<?php namespace App\Http\Controllers;

	use Session;
	use Request;
	use DB;
	use CRUDBooster;
	use CB;
	use Illuminate\Support\Facades\App;
	use Illuminate\Support\Facades\Cache;	
	use Illuminate\Support\Facades\Hash;
	use Illuminate\Support\Facades\PDF;
	use Illuminate\Support\Facades\Route;
	use Illuminate\Support\Facades\Storage;
	use Illuminate\Support\Facades\Validator;
	use Maatwebsite\Excel\Facades\Excel;
	use Schema;


	class AdminRkaklUploadController extends \crocodicstudio\crudbooster\controllers\CBController {

	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "id";
			$this->limit = "500";
			$this->orderby = "id,asc";
			$this->global_privilege = false;
			$this->button_table_action = false;
			$this->button_bulk_action = false;
			$this->button_action_style = "button_icon";
			$this->button_add = false;
			$this->button_edit = false;
			$this->button_delete = false;
			$this->button_detail = false;
			$this->button_show = false;
			$this->button_filter = false;
			$this->button_import = true;
			$this->button_export = true;
			$this->table = "rkakl_upload";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"Kode","name"=>"kode"];
			$this->col[] = ["label"=>"Uraian","name"=>"uraian"];
			$this->col[] = ["label"=>"Vol","name"=>"vol"];
			$this->col[] = ["label"=>"Sat","name"=>"sat"];
			$this->col[] = ["label"=>"Hargasat","name"=>"hargasat"];
			$this->col[] = ["label"=>"Jumlah","name"=>"jumlah"];
			$this->col[] = ["label"=>"Kdblokir","name"=>"kdblokir"];
			$this->col[] = ["label"=>"Sdana","name"=>"sdana"];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ['label'=>'Satker Id','name'=>'satker_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'satker,id'];
			$this->form[] = ['label'=>'Kode','name'=>'kode','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Uraian','name'=>'uraian','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Vol','name'=>'vol','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Sat','name'=>'sat','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Hargasat','name'=>'hargasat','type'=>'money','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Jumlah','name'=>'jumlah','type'=>'money','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Kdblokir','name'=>'kdblokir','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Sdana','name'=>'sdana','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ['label'=>'Satker Id','name'=>'satker_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'satker,id'];
			//$this->form[] = ['label'=>'Kode','name'=>'kode','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Uraian','name'=>'uraian','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Vol','name'=>'vol','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Sat','name'=>'sat','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Hargasat','name'=>'hargasat','type'=>'money','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Jumlah','name'=>'jumlah','type'=>'money','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Kdblokir','name'=>'kdblokir','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Sdana','name'=>'sdana','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
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
			$satkerid = DB::table('satker_user')->where('user_id', CRUDBooster::myId())->first();
	            $query->where('satker_id' , $satkerid->satker_id);
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
		
		public function getImportData()
		{	
			$this->cbLoader();
			$data['page_menu'] = Route::getCurrentRoute()->getActionName();
			$data['page_title'] = 'Import Data '.$module->name;

			if (Request::get('file') && ! Request::get('import')) {
				$file = base64_decode(Request::get('file'));
				$file = storage_path('app/'.$file);
				$rows = Excel::load($file, function ($reader) {
				})->get();
				
				$countRows = ($rows)?count($rows):0;
				
				Session::put('total_data_import', $countRows);

				$data_import_column = [];
				foreach ($rows as $value) {
					$a = [];
					foreach ($value as $k => $v) {
						$a[] = $k;
					}
					if ($a && count($a)) {
						$data_import_column = $a;
					}
					break;
				}

				$table_columns = DB::getSchemaBuilder()->getColumnListing($this->table);

				$data['table_columns'] = $table_columns;
				$data['data_import_column'] = $data_import_column;
			}

			return view('crudbooster::import', $data);
		}

		public function postDoneImport()
		{
			$this->cbLoader();
			$data['page_menu'] = Route::getCurrentRoute()->getActionName();
			$data['page_title'] = trans('crudbooster.import_page_title', ['module' => $module->name]);
			Session::put('select_column', Request::get('select_column'));

			return view('crudbooster::import', $data);
		}

		public function postDoImportChunk()
		{
			ini_set('memory_limit', '1024M');
			set_time_limit(180);
			
			$this->cbLoader();
			$file_md5 = md5(Request::get('file'));

			if (Request::get('file') && Request::get('resume') == 1) {
				$total = Session::get('total_data_import');
				$prog = intval(Cache::get('success_'.$file_md5)) / $total * 100;
				$prog = round($prog, 2);
				if ($prog >= 100) {
					Cache::forget('success_'.$file_md5);
				}

				return response()->json(['progress' => $prog, 'last_error' => Cache::get('error_'.$file_md5)]);
			}

			$select_column = Session::get('select_column');
			$select_column = array_filter($select_column);
			$table_columns = DB::getSchemaBuilder()->getColumnListing($this->table);

			$file = base64_decode(Request::get('file'));
			$file = storage_path('app/'.$file);

			$rows = Excel::load($file, function ($reader) {
			})->get();

			$has_created_at = false;
			if (CRUDBooster::isColumnExists($this->table, 'created_at')) {
				$has_created_at = true;
			}

			$data_import_column = [];
			foreach ($rows as $value) {
				$a = [];
				foreach ($select_column as $sk => $s) {
					$colname = $table_columns[$sk];

					if (CRUDBooster::isForeignKey($colname)) {

						//Skip if value is empty
						if ($value->$s == '') {
							continue;
						}

						if (intval($value->$s)) {
							$a[$colname] = $value->$s;
						} else {
							$relation_table = CRUDBooster::getTableForeignKey($colname);
							$relation_moduls = DB::table('cms_moduls')->where('table_name', $relation_table)->first();

							$relation_class = __NAMESPACE__.'\\'.$relation_moduls->controller;
							if (! class_exists($relation_class)) {
								$relation_class = '\App\Http\Controllers\\'.$relation_moduls->controller;
							}
							$relation_class = new $relation_class;
							$relation_class->cbLoader();

							$title_field = $relation_class->title_field;

							$relation_insert_data = [];
							$relation_insert_data[$title_field] = $value->$s;






							if (CRUDBooster::isColumnExists($relation_table, 'created_at')) {
								$relation_insert_data['created_at'] = date('Y-m-d H:i:s');
							}

							try {
								$relation_exists = DB::table($relation_table)->where($title_field, $value->$s)->first();
								if ($relation_exists) {
									$relation_primary_key = $relation_class->primary_key;
									$relation_id = $relation_exists->$relation_primary_key;
								} else {
									$relation_id = DB::table($relation_table)->insertGetId($relation_insert_data);
								}

								$a[$colname] = $relation_id;
							} catch (\Exception $e) {
								exit($e);
							}
						} //END IS INT

					} else {
						$a[$colname] = $value->$s;
					}
				}

				$has_title_field = true;
				foreach ($a as $k => $v) {
					if ($k == $this->title_field && $v == '') {
						$has_title_field = false;
						break;
					}
				}

				if ($has_title_field == false) {
					continue;
				}

				try {
					//===================================================
					$getparameter = DB::table('parameter')->where('nama' , 'Tahun Anggaran')->first();
					$satkerid = DB::table('satker_user')->where('user_id', CRUDBooster::myId())->first();
					if ($has_created_at) {
						$a['created_at'] 	= date('Y-m-d H:i:s');
						$a['thnang']		= $getparameter->nilai;
						$a['satker_id']		= $satkerid->satker_id;
					}

					DB::table($this->table)->insert($a);
					Cache::increment('success_'.$file_md5);
				} catch (\Exception $e) {
					$e = (string) $e;
					Cache::put('error_'.$file_md5, $e, 500);
				}
			}

			return response()->json(['status' => true]);
		}

		public function postDoUploadImportData()
		{
			$this->cbLoader();
			if (Request::hasFile('userfile')) {
				$file = Request::file('userfile');
				$ext = $file->getClientOriginalExtension();

				$validator = Validator::make([
					'extension' => $ext,
				], [
					'extension' => 'in:xls,xlsx,csv',
				]);

				if ($validator->fails()) {
					$message = $validator->errors()->all();

					return redirect()->back()->with(['message' => implode('<br/>', $message), 'message_type' => 'warning']);
				}

				//Create Directory Monthly
				$filePath = 'uploads/'.CB::myId().'/'.date('Y-m');
				Storage::makeDirectory($filePath);

				//Move file to storage
				$filename = md5(str_random(5)).'.'.$ext;
				$url_filename = '';
				if (Storage::putFileAs($filePath, $file, $filename)) {
					$url_filename = $filePath.'/'.$filename;
				}
				$url = CRUDBooster::mainpath('import-data').'?file='.base64_encode($url_filename);

				return redirect($url);
			} else {
				return redirect()->back();
			}
		}
				//By the way, you can still create your own method in here... :) 


		}