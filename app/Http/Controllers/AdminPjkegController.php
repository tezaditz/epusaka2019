<?php namespace App\Http\Controllers;

	use Session;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Input;
	use DB;
	use CRUDBooster;
	use App\Controllers\AdminKegController;

	class AdminPjkegController extends \crocodicstudio\crudbooster\controllers\CBController {

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
			$this->table = "m_kegiatan";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"No Pengajuan","name"=>"no_pengajuan"];
			$this->col[] = ["label"=>"Tgl Pengajuan","name"=>"tgl_pengajuan"];
			$this->col[] = ["label"=>"No Mak","name"=>"no_mak"];
			$this->col[] = ["label"=>"Uraian","name"=>"uraian"];
			$this->col[] = ["label"=>"Total Pengajuan","name"=>"total_pengajuan" , 'callback_php'=>'number_format($row->total_pengajuan , 0 , "," , ".")'];
			$this->col[] = ["label"=>"Status","name"=>"status_id","join"=>"status,keterangan"];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ['label'=>'Bagian Id','name'=>'bagian_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'bagian,nama'];
			$this->form[] = ['label'=>'Thnang','name'=>'thnang','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'No Pengajuan','name'=>'no_pengajuan','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Tgl Pengajuan','name'=>'tgl_pengajuan','type'=>'date','validation'=>'required|date','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Rkakl Id','name'=>'rkakl_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'rkakl,id'];
			$this->form[] = ['label'=>'Rpk Id','name'=>'rpk_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'rpk,id'];
			$this->form[] = ['label'=>'Kode 7','name'=>'kode_7','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'No Mak','name'=>'no_mak','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Uraian','name'=>'uraian','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Jenis Belanja','name'=>'jenis_belanja','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Tgl Awal','name'=>'tgl_awal','type'=>'date','validation'=>'required|date','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Tgl Akhir','name'=>'tgl_akhir','type'=>'date','validation'=>'required|date','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Hotel Id','name'=>'hotel_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Provinsi Id','name'=>'provinsi_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'provinsi,title'];
			$this->form[] = ['label'=>'Total Pengajuan','name'=>'total_pengajuan','type'=>'money','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Status Id','name'=>'status_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'status,id'];
			$this->form[] = ['label'=>'Alasan','name'=>'alasan','type'=>'textarea','validation'=>'required|string|min:5|max:5000','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Metode Bayar Id','name'=>'metode_bayar_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'metode_bayar,id'];
			$this->form[] = ['label'=>'Jenis Transaksi Id','name'=>'jenis_transaksi_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'jenis_transaksi,id'];
			$this->form[] = ['label'=>'Sp2d','name'=>'sp2d','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Path','name'=>'path','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ['label'=>'Bagian Id','name'=>'bagian_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'bagian,nama'];
			//$this->form[] = ['label'=>'Thnang','name'=>'thnang','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'No Pengajuan','name'=>'no_pengajuan','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Tgl Pengajuan','name'=>'tgl_pengajuan','type'=>'date','validation'=>'required|date','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Rkakl Id','name'=>'rkakl_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'rkakl,id'];
			//$this->form[] = ['label'=>'Rpk Id','name'=>'rpk_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'rpk,id'];
			//$this->form[] = ['label'=>'Kode 7','name'=>'kode_7','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'No Mak','name'=>'no_mak','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Uraian','name'=>'uraian','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Jenis Belanja','name'=>'jenis_belanja','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Tgl Awal','name'=>'tgl_awal','type'=>'date','validation'=>'required|date','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Tgl Akhir','name'=>'tgl_akhir','type'=>'date','validation'=>'required|date','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Hotel Id','name'=>'hotel_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Provinsi Id','name'=>'provinsi_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'provinsi,title'];
			//$this->form[] = ['label'=>'Total Pengajuan','name'=>'total_pengajuan','type'=>'money','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Status Id','name'=>'status_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'status,id'];
			//$this->form[] = ['label'=>'Alasan','name'=>'alasan','type'=>'textarea','validation'=>'required|string|min:5|max:5000','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Metode Bayar Id','name'=>'metode_bayar_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'metode_bayar,id'];
			//$this->form[] = ['label'=>'Jenis Transaksi Id','name'=>'jenis_transaksi_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'jenis_transaksi,id'];
			//$this->form[] = ['label'=>'Sp2d','name'=>'sp2d','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Path','name'=>'path','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
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
			$this->addaction[] = ['label'=>'' ,'url'=>'/admin/pjkeg/[id]/draft','icon'=>'fa fa-eye','color'=>'info','showIf'=>"[status_id] == 5 or [status_id] == 7 "];


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
	        $this->load_js[] = asset("js/pertanggungjawaban/kegiatan/draft.js");
	        
	        
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
			if(CRUDBooster::myPrivilegeName()== 'user')
			{
				$query->whereIn('status_id' , [5 , 7]);
			}

			if(CRUDBooster::myPrivilegeName()== 'Bendahara')
			{
				$query->whereIn('status_id' , [7]);
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
			if($column_index == 5)
			{
				$column_value = "<div class='text-right'>".$column_value."</div>";
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

		public function getDraft($id)
		{
			//Create an Auth
			if(!CRUDBooster::isRead() && $this->global_privilege==FALSE || $this->button_edit==FALSE) {    
				CRUDBooster::redirect(CRUDBooster::adminPath(),trans("crudbooster.denied_access"));
			}

			if(!CRUDBooster::myID())
			{
				return redirect('/');
			}
			
			$data = [];
			$data['page_title'] = 'Draft Pertanggungjawaban Kegiatan';
			$data['row'] = DB::table('m_kegiatan')->where('id',$id)->first();
			$data['status'] = DB::table('status')->where('id' , $data['row']->status_id)->first();
			$data['bagian'] = DB::table('bagian')->where('id' , $data['row']->bagian_id)->first();
			$data['daerah'] = DB::table('provinsi')->where('id' , $data['row']->provinsi_id)->first();
			$data['detail'] = DB::table('detail_kegiatan')
										->where('level' , 0)
										->where('kegiatan_id' , $id)->get();
			$data['id'] = $id;
			$data['metode_bayar'] 	= DB::table('metode_bayar')->get();
			$data['status_bend']	= DB::table('status')
										->where('kode_status' , 'LIKE' , '%BEND%')
										->get(['id' , 'keterangan']);
			$data['result'] = DB::table('nominatif')->where('kegiatan_id' , $id)->get();
			$data['privilage'] = CRUDBooster::myPrivilegeName();
			
			//Please use cbView method instead view method from laravel
			$this->cbView('backend.pertanggungjawaban.kegiatan.draft',$data);
		}

		public function send(Request $request , $id)
		{

			
			if($request->all())
			{
				$detailid = $request->input('detail_id');
				$nilai_pj = $request->input('pjnilai');
				foreach ($detailid as $key => $value) {
					DB::table('detail_kegiatan')->where('id' , $value)
												->update([
													'jumlah_pertanggungjawaban' => str_replace( '.' , '' ,$nilai_pj[$key]),
												]);
				}

				// update status to -> 'pertanggungjawaban baru'
				
				DB::table('m_kegiatan')->where('id' , $id)
				->update(['status_id' => '7']);

				$this->update_transaksi_status($id , 'Kegiatan' , 7);

				$to = '/admin/pjkeg/';
				$message = 'Pertanggungjawaban berhasil ditambahkan';
				$type = 'info';
				CRUDBooster::redirect($to,$message,$type);
			}

			
		}

		public function sendbend(Request $request , $id)
		{

			if($request->all())
			{
				$detailid = $request->input('detail_id');
				return $detailid;
				$nilai_pj = $request->input('pjnilai');
				foreach ($detailid as $key => $value) {
					DB::table('detail_kegiatan')->where('id' , $value)
												->update([
													'jumlah_pertanggungjawaban' => str_replace( '.' , '' ,$nilai_pj[$key]),
												]);
				}

				// update status to -> 'pertanggungjawaban baru'
				
				DB::table('m_kegiatan')->where('id' , $id)
				->update(['status_id' => '7']);

				$this->update_transaksi_status($id , 'Kegiatan' , 7);

				$to = '/admin/pjkeg/';
				$message = 'Pertanggungjawaban berhasil ditambahkan';
				$type = 'info';
				CRUDBooster::redirect($to,$message,$type);
			}
			

			
		}

		public function insert_to_transaksi($id_t , $keterangan , $status)
		{
				$transaksi = [];
				$data = DB::table('detail_kegiatan')->where('kegiatan_id' , $id_t)->where('jumlah_pengajuan' , '!=' , 0)->get();
				foreach ($data as $key => $value) {
					$nomak = explode('.' , $value->no_mak_sys);

					$transaksi[$key]['id_t'] 					= $id_t;
					$transaksi[$key]['keterangan'] 		= $keterangan;
					$transaksi[$key]['status_id']			= $status;
					$transaksi[$key]['no_mak_sys']		= $value->no_mak_sys;
					$transaksi[$key]['jumlah']				= $value->jumlah_pengajuan;
					$transaksi[$key]['kode_9']				= $nomak[$key][0];
					// $transaksi[$key]['kode_9']			= '';
					// $transaksi[$key]['kode_9']			= '';
					// $transaksi[$key]['kode_9']			= '';
					// $transaksi[$key]['kode_9']			= '';
					// $transaksi[$key]['kode_9']			= '';
					// $transaksi[$key]['kode_9']			= '';

					$this->hitung_rkakl($value->no_mak_sys , $value->jumlah_pengajuan , $status);
				}

				if($transaksi)
				{
					DB::table('transaksi')->insert($transaksi);
				}

		}

		public function update_transaksi_status($id_t , $keterangan , $status)
		{
			 $data_transaksi = DB::table('transaksi')->where('id_t' , $id_t)
													->where('keterangan' , $keterangan)
													->get();
				foreach ($data_transaksi as $key => $value) {
					DB::table('transaksi')->where('id_t' , $id_t)
													->where('keterangan' , $keterangan)
													->update(['status_id' => $status ]);					

					$this->hitung_rkakl($value->no_mak_sys , $value->jumlah , $status);
				}
		}

		public function hitung_rkakl($nomaksys , $nilai , $status)
		{
					$nomak = explode('.',$nomaksys);

					$rkakl = DB::table('rkakl')->where('no_mak_sys' , $nomaksys)->first();
					if( $status == 3 || $status == 4)
					{
							$curr_nilai = $rkakl->realisasi_1 + $nilai;
							DB::table('rkakl')->where('no_mak_sys' , $nomaksys)->update([ 'realisasi_1' => $curr_nilai ]);
					}
					elseif ($status == 5) {
						$realisasi_1 = $rkakl->realisasi_1 - $nilai; 
						$curr_nilai = $rkakl->realisasi_2 + $nilai;
						DB::table('rkakl')->where('no_mak_sys' , $nomaksys)->update([ 
							'realisasi_1' => $realisasi_1, 
							'realisasi_2' => $curr_nilai ]);
					}
					else {
						$realisasi_2 = $rkakl->realisasi_2 - $nilai;
						$curr_nilai = $rkakl->realisasi_3 + $nilai;
						DB::table('rkakl')->where('no_mak_sys' , $nomaksys)->update([ 
							'realisasi_2' => $realisasi_2,
							'realisasi_3' => $curr_nilai ]);
					}
					

					


		}


	    //By the way, you can still create your own method in here... :) 


	}