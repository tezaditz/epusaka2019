<?php namespace App\Http\Controllers;

	use Session;
	use Request;
	use DB;
	use CRUDBooster;

	class AdminMRpkController extends \crocodicstudio\crudbooster\controllers\CBController {

	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "id";
			$this->limit = "20";
			$this->orderby = "id,desc";
			$this->global_privilege = false;
			$this->button_table_action = true;
			$this->button_bulk_action = true;
			$this->button_action_style = "button_icon";
			$this->button_add = true;
			$this->button_edit = true;
			$this->button_delete = true;
			$this->button_detail = false;
			$this->button_show = true;
			$this->button_filter = true;
			$this->button_import = false;
			$this->button_export = false;
			$this->table = "m_rpk";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"Satker","name"=>"satker_id","join"=>"satker,nama"];
			$this->col[] = ["label"=>"Bagian","name"=>"bagian_id","join"=>"bagian,nama"];
			$this->col[] = ["label"=>"No Mak","name"=>"no_mak_7"];
			$this->col[] = ["label"=>"Komponen","name"=>"uraian_kegiatan"];
			
			
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			
			$this->form = [];
			$userid 	= CRUDBooster::MyId();
			$satkeruser = DB::table('satker_user')->where('user_id' , $userid)->first();
			$parameter  = DB::table('parameter')->where('nama' , 'Tahun Anggaran')->first();
			$rkakl9 		= DB::table('rkakl')->where('satker_id' , $satkeruser->satker_id)
											->where('level' , 9)
											->where('thnang' , $parameter->nilai)
											->first();
			$rkakl4 		= DB::table('rkakl')->where('satker_id' , $satkeruser->satker_id)
											->where('thnang' , $parameter->nilai)
											->where('level' , 4)->first();
										

			$this->form[] = ['label'=>'Kode 9','name'=>'kode_9','type'=>'hidden','readonly' => true,'width'=>'col-sm-10' , 'value'=> $rkakl9->id];
			$this->form[] = ['label'=>'Kode 4','name'=>'kode_4','type'=>'hidden','validation'=>'required|min:1|max:255','width'=>'col-sm-10' , 'value' => $rkakl4->kode];			

			$this->form[] = ['label'=>'Progam','name'=>'uraian_kode9','type'=>'text','readonly' => true,'width'=>'col-sm-10' , 'value'=> $rkakl9->uraian];
			$this->form[] = ['label'=>'Kegiatan','name'=>'uraian_kode4','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10' , 'value' => $rkakl4->uraian, 'readonly'=>true];
			
			
			if(CRUDBooster::getCurrentMethod() == 'getEdit'  && CRUDBooster::getCurrentId()) {
				$this->form[] = ['label'=>'id' , 'name'=>'id' , 'type'=>'text', 'value'=>CRUDBooster::getCurrentId()];
				$this->form[] = ['label'=>'Output','name'=>'kode_8' , 'id'=>'kode_8','type'=>'select','validation'=>'required|min:1|max:255','width'=>'col-sm-10' ];
				$this->form[] = ['label'=>'Suboutput','name'=>'kode_6' , 'id'=>'kode_6','type'=>'select','validation'=>'required|min:1|max:255',
				'width'=>'col-sm-10' ];
				$this->form[] = ['label'=>'Komponen','name'=>'kode_7' , 'id'=>'kode_7','type'=>'select','validation'=>'required|min:1|max:255',
				'width'=>'col-sm-10'];
				
			}
			else
			{
				$this->form[] = ['label'=>'Output','name'=>'kode_8' , 'id'=>'kode_8','type'=>'select','datatable'=>'rkakl,uraian' , 'datatable_where'=>'level = 8' , 'datatable_format'=>'no_mak ,\'-\',uraian' ,'validation'=>'required|min:1|max:255','width'=>'col-sm-10' ];
				$this->form[] = ['label'=>'Suboutput','name'=>'kode_6' , 'id'=>'kode_6','type'=>'select','validation'=>'required|min:1|max:255','width'=>'col-sm-10'  ];
				$this->form[] = ['label'=>'Komponen','name'=>'kode_7','id'=>'kode_7','type'=>'select','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			}
			
			
			
			$this->form[] = ['label'=>'Uraian Kegiatan','name'=>'uraian_kegiatan' , 'id'=>'uraian_kegiatan','type'=>'text' ,'readonly'=>true,'validation'=>'required|min:1|max:255','width'=>'col-sm-10'];


			$columns = [];
			$columns[] = ['label'=>'Tanggal Awal','name'=>'tgl_awal_pelaksanaan','type'=>'date','value'=>date('Y-m-d'),'required'=>true];
			$columns[] = ['label'=>'Tanggal Akhir','name'=>'tgl_akhir_pelaksanaan','type'=>'date','value'=>date('Y-m-d'),'required'=>true];
			$this->form[] = ['label'=>'Tanggal Pelaksanaan','name'=>'detail_rpk','type'=>'child','columns'=>$columns,'table'=>'detail_rpk','foreign_key'=>'m_rpk_id'];

			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ['label'=>'Kode 9','name'=>'kode_9','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Kode 8','name'=>'kode_8','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Kode 6','name'=>'kode_6','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Kode 7','name'=>'kode_7','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Uraian Kegiatan','name'=>'uraian_kegiatan','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
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
			if(CRUDBooster::getCurrentMethod() == 'getEdit' && CRUDBooster::getCurrentId()) {
				$this->load_js[] = asset("js/monitoring/rpk_edit.js");
			}
			else
			{
				$this->load_js[] = asset("js/monitoring/rpk.js");
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
			$data = DB::table('m_rpk')->where('kode_7' , $postdata['kode_7'])->first();
			if($data)
			{
				$pesan = "Kegiatan " . $data->uraian_kegiatan . " Sudah Tersedia RPK" ;
				CRUDBooster::redirect(CRUDBooster::mainpath(),$pesan,"danger");
			}


			
			$parameter = DB::table('parameter')->where('nama' , 'Tahun Anggaran')->first();
			$bagianuser = DB::table('bagian_user')->where('user_id' , CRUDBooster::MyId())->first();
			$satkeruser = DB::table('satker_user')->where('user_id' , CRUDBooster::MyId())->first();
			$postdata['bagian_id'] = $bagianuser->bagian_id;
			$postdata['satker_id'] = $satkeruser->satker_id;
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
			$data_rpk = DB::table('m_rpk')->where('id' , $id)->first();

			$data = [];
			$data['bagian_id'] = $data_rpk->bagian_id;
			$data['satker_id'] = $data_rpk->satker_id;
			$data['thnang'] = $data_rpk->thnang;
			$data['uraian'] = $data_rpk->uraian_kegiatan;
			$data['m_rpk_id'] = $id;
			if($data)
			{
				DB::table('m_rpd')->insert($data);
			}

			$data_nomak = DB::table('rkakl')->where('id' , $data_rpk->kode_7)->first();
			$data_rkakl = DB::table('rkakl')->where('no_mak_sys' , 'LIKE' , '%' . $data_nomak->no_mak_sys . '%')->get();
			$m_rpd      = DB::table('m_rpd')->where('m_rpk_id' , $id)->first();
			foreach ($data_rkakl as $key => $value) {
				$detail_rpd = [];
				$detail_rpd['m_rpd_id'] = $m_rpd->id;
				$detail_rpd['kode'] = $value->kode;
				$detail_rpd['level'] = $value->level;
				$detail_rpd['rkakl_id'] = $value->id;
				$detail_rpd['no_mak_sys'] = $value->no_mak_sys;
				$detail_rpd['uraian'] = $value->uraian;
				$detail_rpd['vol'] = $value->vol;
				$detail_rpd['sat'] = $value->sat;
				$detail_rpd['hargasat'] = $value->hargasat;
				$detail_rpd['jumlah'] = $value->jumlah;

				if($detail_rpd)
				{
					DB::table('detail_rpd')->insert($detail_rpd);
				}

			}

			$data_rkakl = DB::table('rkakl')->where('id' , $data_rpk->kode_6)->first();
			
			DB::table('m_rpk')->where('id' , $id)
			->update(['uraian_6' => $data_rkakl->uraian,
						'no_mak_6'=>$data_rkakl->no_mak]);

			$data_rkakl = DB::table('rkakl')->where('id' , $data_rpk->kode_7)->first();
			$parameter = DB::table('parameter')->where('nama' , 'Tahun Anggaran')->first();

			DB::table('m_rpk')->where('id' , $id)
						->update(['no_mak_7'=>$data_rkakl->no_mak,
									'thnang'=>$parameter->nilai]);

			$data_rkakl = DB::table('rkakl')->where('id' , $data_rpk->kode_8)->first();
			$parameter = DB::table('parameter')->where('nama' , 'Tahun Anggaran')->first();

			DB::table('m_rpk')->where('id' , $id)
						->update(['no_mak_8'=>$data_rkakl->no_mak,
									'uraian_8'=>$data_rkakl->uraian,
									'rkakl_created_at'=>$data_rkakl->created_at,
									'thnang'=>$parameter->nilai]);

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
			$getRPD = DB::table('m_rpd')->where('m_rpk_id' , $id)->first();
			DB::table('detail_rpd')->where('m_rpd_id' , $getRPD->id)->delete();
			DB::table('m_rpd')->where('id' , $getRPD->id)->delete();
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


		// public function getDetail($id)
		// {
		// 	$data['page_title'] = 'Detail Rencana Pelaksanaan Kegiatan';
		// 	$data['master'] = DB::table('m_rpk')->where('id' , $id)->get();

			
		// 	$this->cbView('backend.monitoring.rpk.detail',$data);
		// }

	    //By the way, you can still create your own method in here... :) 


	}