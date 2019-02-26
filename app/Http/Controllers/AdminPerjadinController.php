<?php namespace App\Http\Controllers;

	use Session;
	use Request;
	use DB;
	use CRUDBooster;
	use Carbon\carbon;

	class AdminPerjadinController extends \crocodicstudio\crudbooster\controllers\CBController {

	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "nama_kegiatan";
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
			$this->table = "perjadin";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"Bagian Id","name"=>"bagian_id","join"=>"bagian,nama"];
			$this->col[] = ["label"=>"No Pengajuan","name"=>"no_pengajuan"];
			$this->col[] = ["label"=>"Tgl Pengajuan","name"=>"tgl_pengajuan"];
			$this->col[] = ["label"=>"Nama Kegiatan","name"=>"nama_kegiatan"];
			$this->col[] = ["label"=>"Tgl Awal","name"=>"tgl_awal"];
			$this->col[] = ["label"=>"Tgl Akhir","name"=>"tgl_akhir"];
			$this->col[] = ["label"=>"Provinsi Id","name"=>"provinsi_id","join"=>"provinsi,title"];
			$this->col[] = ["label"=>"Status","name"=>"status_id","join"=>"status,keterangan"];
			$this->col[] = ["label"=>"Total Pengajuan","name"=>"total_pengajuan"];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ['label'=>'Bagian','name'=>'bagian_id','type'=>'text','validation'=>'required','width'=>'col-sm-10','readonly'=>'1'];
			$this->form[] = ['label'=>'No Mak','name'=>'no_mak','type'=>'select','validation'=>'required|min:1|max:255','width'=>'col-sm-10','datatable'=>'m_rpk,uraian_kegiatan','datatable_format'=>'no_mak_7 ,\'-\',uraian_kegiatan'];
			$this->form[] = ['label'=>'Nama Kegiatan','name'=>'nama_kegiatan','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10','readonly'=>'1'];
			$this->form[] = ['label'=>'No Surat Tugas','name'=>'no_surat_tugas','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Tgl Surat Tugas','name'=>'tgl_surat_tugas','type'=>'date','validation'=>'required|date','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'File','name'=>'file_surat_tugas','type'=>'upload','validation'=>'required','width'=>'col-sm-9'];
			$this->form[] = ['label'=>'Tgl Awal','name'=>'tgl_awal','type'=>'date','validation'=>'required|date','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Tgl Akhir','name'=>'tgl_akhir','type'=>'date','validation'=>'required|date','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Prov Asal','name'=>'prov_asal','type'=>'select','validation'=>'required|min:1|max:255','width'=>'col-sm-10' , 'datatable'=>'provinsi,title' , 'value'=>31];
			$this->form[] = ['label'=>'Provinsi Id','name'=>'provinsi_id','type'=>'select','validation'=>'required|integer|min:0','width'=>'col-sm-10' , 'datatable'=>'provinsi,title'];
			$this->form[] = ['label'=>'Kabkota Id','name'=>'kabkota_id','type'=>'select','validation'=>'required|integer|min:0','width'=>'col-sm-10' , 'datatable'=>'kabkota,nama','parent_select'=>'provinsi_id' ];
			
			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ['label'=>'Bagian Id','name'=>'bagian_id' ,'id'=>'bagian_id' ,'type'=>'text','validation'=>'required','width'=>'col-sm-10' , 'readonly'=>true];
			//$this->form[] = ['label'=>'No Mak','name'=>'no_mak','type'=>'select','validation'=>'required|min:1|max:255','width'=>'col-sm-10','datatable'=>'m_rpk,uraian_kegiatan','datatable_format'=>'no_mak_7 ,\'-\',uraian_kegiatan'];
			//$this->form[] = ['label'=>'Nama Kegiatan','name'=>'nama_kegiatan','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10' , 'readonly'=>true];
			//$this->form[] = ['label'=>'No Surat Tugas','name'=>'no_surat_tugas','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10','datatable'=>'bagian,nama'];
			//$this->form[] = ['label'=>'Tgl Surat Tugas','name'=>'tgl_surat_tugas','type'=>'date','validation'=>'required|date','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Tgl Awal','name'=>'tgl_awal','type'=>'date','validation'=>'required|date','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Tgl Akhir','name'=>'tgl_akhir','type'=>'date','validation'=>'required|date','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Prov Asal','name'=>'prov_asal','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Provinsi Id','name'=>'provinsi_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Kabkota Id','name'=>'kabkota_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
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
	        $this->load_js[] = asset("js/pengajuan/perjadin/perjadin.js");
	        
	        
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
			$bagianuser = DB::table('bagian_user')->where('user_id' , CRUDBooster::myId())->first();
			$bagian 	= DB::table('bagian')->where('id' , $bagianuser->bagian_id)->first();
			$parameter 	= DB::table('parameter')->where('nama','Tahun Anggaran')->first();
			$postdata['bagian_id']		= $bagianuser->bagian_id;
			$postdata['status_id'] 		= 1;
			$postdata['metode_bayar']	= 5;

			$dataPengajuan = DB::table('no_pengajuan')->where('bagian_id' , $bagianuser->bagian_id)
													  ->where('jenis' , 'Perjadin')
													  ->get();
			
			if(Count($dataPengajuan) == 0)
			{
				$data = [];
				$data['bagian_id'] 	= $bagianuser->bagian_id;
				$data['nomor'] 		= 1;
				$data['jenis'] 		= "Perjadin";
				
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

			$postdata['no_pengajuan'] = $nomor_pengajuan;
			$postdata['tgl_pengajuan']	= Carbon::now();
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

		public function getBagian()
		{
			$data = DB::table('bagian_user')->where('user_id' , CRUDBooster::myId())->first();
			
			$bagian = DB::table('bagian')->where('id' , $data->bagian_id)->first();

			return $bagian->nama;
		}

		public function getNamaKegiatan($id)
		{
			$rpk = DB::table('m_rpk')->where('id' , $id)->first();
			return $rpk->uraian_kegiatan;
		}

	    //By the way, you can still create your own method in here... :) 


	}