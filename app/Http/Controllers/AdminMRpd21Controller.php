<?php namespace App\Http\Controllers;

	use Session;
	use Request;
	use DB;
	use CRUDBooster;

	class AdminMRpd21Controller extends \crocodicstudio\crudbooster\controllers\CBController {

	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "id";
			$this->limit = "20";
			$this->orderby = "id,desc";
			$this->global_privilege = false;
			$this->button_table_action = true;
			$this->button_bulk_action = true;
			$this->button_action_style = "button_icon";
			$this->button_add = false;
			$this->button_edit = false;
			$this->button_delete = false;
			$this->button_detail = false;
			$this->button_show = true;
			$this->button_filter = true;
			$this->button_import = false;
			$this->button_export = false;
			$this->table = "m_rpd";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"Bagian","name"=>"bagian_id","join"=>"bagian,nama"];
			// $this->col[] = ["label"=>"Satker","name"=>"satker_id"];
			// $this->col[] = ["label"=>"Thnang","name"=>"thnang"];
			// $this->col[] = ["label"=>"Kegiatan","name"=>"m_rpk_id"];
			$this->col[] = ["label"=>"Uraian","name"=>"uraian"];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ['label'=>'Bagian','name'=>'bagian_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'bagian,nama'];
			$this->form[] = ['label'=>'Satker','name'=>'satker_id','type'=>'hidden','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Thnang','name'=>'thnang','type'=>'hidden','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Kegiatan','name'=>'m_rpk_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'m_rpk,uraian_kegiatan'];
			
			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$bagianuser = DB::table('bagian_user')->where('user_id' , CRUDBooster::MyId())->first();
			//$satkeruser = DB::table('satker_user')->where('user_id' , CRUDBooster::MyId())->first();
			//$parameter  = DB::table('parameter')->where('nama' , 'Tahun Anggaran')->first();
			//$this->form[] = ['label'=>'Bagian','name'=>'bagian_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'bagian,nama' , 'value'=>$bagianuser->bagian_id , 'disabled'=>true];
			//$this->form[] = ['label'=>'Satker','name'=>'satker_id','type'=>'hidden','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'satker,nama' , 'value'=>$satkeruser->satker_id];
			//$this->form[] = ['label'=>'Thnang','name'=>'thnang','type'=>'hidden','validation'=>'required|integer|min:0','width'=>'col-sm-10' , 'value'=>$parameter->nilai];
			//$this->form[] = ['label'=>'Kegiatan','name'=>'m_rpk_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'m_rpk,uraian_kegiatan' ];
			


			// $columns = [];
			// $columns[] = ['label'=>'rkakl_id','name'=>'rkakl_id','type'=>'text','required'=>true ];
			// $columns[] = ['label'=>'no_mak_sys','name'=>'no_mak_sys','type'=>'text','required'=>true ];
			// $columns[] = ['label'=>'uraian','name'=>'uraian','type'=>'text','required'=>true ];
			// $columns[] = ['label'=>'sat','name'=>'sat','type'=>'text','required'=>true ];
			// $columns[] = ['label'=>'hargasat','name'=>'hargasat','type'=>'text','required'=>true ];
			// $columns[] = ['label'=>'jumlah','name'=>'jumlah','type'=>'text','required'=>true ];
			
			// $columns[] = ['label'=>'Januari','name'=>'jan','type'=>'text','required'=>true ];
			// $columns[] = ['label'=>'Februari','name'=>'feb','type'=>'text','required'=>true ];
			// $columns[] = ['label'=>'Maret','name'=>'mar','type'=>'text','required'=>true ];
			// $columns[] = ['label'=>'April','name'=>'apr','type'=>'text','required'=>true ];
			// $columns[] = ['label'=>'Mei','name'=>'mei','type'=>'text','required'=>true ];
			// $columns[] = ['label'=>'Juni','name'=>'jun','type'=>'text','required'=>true ];
			// $columns[] = ['label'=>'Juli','name'=>'jul','type'=>'text','required'=>true ];
			// $columns[] = ['label'=>'Agustus','name'=>'aug','type'=>'text','required'=>true ];
			// $columns[] = ['label'=>'September','name'=>'sep','type'=>'text','required'=>true ];
			// $columns[] = ['label'=>'Oktober','name'=>'oct','type'=>'text','required'=>true ];
			// $columns[] = ['label'=>'November','name'=>'nov','type'=>'text','required'=>true ];
			// $columns[] = ['label'=>'Desember','name'=>'dec','type'=>'text','required'=>true ];
			// $this->form[] = ['label'=>'Detail RPD','name'=>'detail_rpd','type'=>'child','columns'=>$columns,'table'=>'detail_rpd','foreign_key'=>'m_rpd_id'];
			// # OLD END FORM

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
	        // $this->sub_module = array();
			$this->sub_module[] = ['label'=>'Detail','path'=>'detail_rpd','parent_columns'=>'id,uraian_kegiatan','foreign_key'=>'m_rpd_id','button_color'=>'success','button_icon'=>'fa fa-bars'];

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
			 $this->load_js[] = asset("js/monitoring/rpd.js");
			
	        
	        
	        
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
			if(CRUDBooster::myPrivilegeName()== 'user')
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



	    //By the way, you can still create your own method in here... :) 


	}