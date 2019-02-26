<?php namespace App\Http\Controllers;

	use Session;

	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Input;
	use DB;
	use CRUDBooster;
	use Carbon\carbon;
	use Illuminate\Support\Facades\App;

	class AdminKegController extends \crocodicstudio\crudbooster\controllers\CBController {

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
				$this->button_edit = false;
				$this->button_delete = false;
				
				$this->button_detail = false;
				$this->button_show = true;
				$this->button_filter = false;
				$this->button_import = false;
				$this->button_export = false;
				$this->table = "m_kegiatan";
				# END CONFIGURATION DO NOT REMOVE THIS LINE

				# START COLUMNS DO NOT REMOVE THIS LINE
				$this->col = [];
				$this->col[] = ["label"=>"No Pengajuan","name"=>"no_pengajuan"];
				$this->col[] = ["label"=>"Tgl Pengajuan","name"=>"tgl_pengajuan",'callback_php'=>'date("d M y",strtotime($row->tgl_pengajuan))'];
				$this->col[] = ["label"=>"No Mak","name"=>"no_mak"];
				$this->col[] = ["label"=>"Uraian Kegiatan","name"=>"uraian"];
				$this->col[] = ["label"=>"Tgl Awal","name"=>"tgl_awal" ,'callback_php'=>'date("d M y",strtotime($row->tgl_awal))'];
				$this->col[] = ["label"=>"Tgl Akhir","name"=>"tgl_akhir" ,'callback_php'=>'date("d M y",strtotime($row->tgl_akhir))'];
				$this->col[] = ["label"=>"Total Pengajuan","name"=>"total_pengajuan" , 'callback_php' => 'number_format($row->total_pengajuan , 0 , "," , ".")'];
				$this->col[] = ["label"=>"Status","name"=>"status_id","join"=>"status,keterangan"];
				# END COLUMNS DO NOT REMOVE THIS LINE

				# START FORM DO NOT REMOVE THIS LINE
				$this->form = [];
				$this->form[] = ['label'=>'Bagian','name'=>'bagian_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10' , 'readonly'=>true];
				$this->form[] = ['label'=>'Nama Kegiatan','name'=>'rkakl_id','type'=>'select','validation'=>'required|min:1|max:255','width'=>'col-sm-10','datatable'=>'m_rpk,uraian_kegiatan'];
				$this->form[] = ['label'=>'Jenis Belanja','name'=>'jenis_belanja','type'=>'select','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
				$this->form[] = ['label'=>'Tgl Awal','name'=>'tgl_awal','type'=>'date','validation'=>'required|date','width'=>'col-sm-10'];
				$this->form[] = ['label'=>'Tgl Akhir','name'=>'tgl_akhir','type'=>'date','validation'=>'required|date','width'=>'col-sm-10'];
				$this->form[] = ['label'=>'Hotel','name'=>'hotel_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'hotel,nama_hotel'];
				$this->form[] = ['label'=>'Provinsi','name'=>'provinsi_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'provinsi,title'];
				// $this->form[] = ['label'=>'Status','name'=>'status_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'status,keterangan'];
				# END FORM DO NOT REMOVE THIS LINE

				# OLD START FORM
				//$this->form = [];
				//$this->form[] = ['label'=>'Bagian','name'=>'bagian_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'bagian,nama'];
				//$this->form[] = ['label'=>'No Pengajuan','name'=>'no_pengajuan','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
				//$this->form[] = ['label'=>'No Mak','name'=>'no_mak','type'=>'select','validation'=>'required|min:1|max:255','width'=>'col-sm-10','datatable'=>'rpk,no_mak','datatable_where'=>'level = 8' , 'datatable_format'=>"no_mak ,'-',uraian"];
				//$this->form[] = ['label'=>'Nama Kegiatan','name'=>'nama_kegiatan','type'=>'text','validation'=>'required|min:1|max:255|readonly:true','width'=>'col-sm-10' , 'readonly'=>true];
				//$this->form[] = ['label'=>'Tgl Awal','name'=>'tgl_awal','type'=>'date','validation'=>'required|date','width'=>'col-sm-10'];
				//$this->form[] = ['label'=>'Tgl Akhir','name'=>'tgl_akhir','type'=>'date','validation'=>'required|date','width'=>'col-sm-10'];
				//$this->form[] = ['label'=>'Hotel','name'=>'hotel_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'hotel,nama_hotel'];
				//$this->form[] = ['label'=>'Provinsi','name'=>'provinsi_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'provinsi,title'];
				//$this->form[] = ['label'=>'Status','name'=>'status_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'status,keterangan'];
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
					$bagianuser = DB::table('bagian_user')->where('user_id' , CRUDBooster::MyId())->first();
					// if($bagianuser->bagian_id != 6)
					// {
						$this->addaction[] = ['label'=>'Nota Dinas' , 'target'=>'_blank','url'=>CRUDBooster::mainpath('[id]/notadinas'),'icon'=>'fa fa-print','color'=>'success','showIf'=>"[status_id] == 2"];
					// }
					// else
					// {
						$this->addaction[] = ['label'=>'' ,'url'=>CRUDBooster::mainpath('[id]/draft'),'icon'=>'fa fa-eye','color'=>'info','showIf'=>"[status_id] == 1 Or [status_id] == 2 Or [status_id] == 3 Or [status_id] == 4  "];
					$this->addaction[] = ['label'=>'' ,'url'=>CRUDBooster::mainpath('[id]/edit'),'icon'=>'fa fa-pencil','color'=>'success','showIf'=>"[status_id] == 1"];
					// $this->addaction[] = ['label'=>'' ,'url'=>CRUDBooster::mainpath('[id]/draft'),'icon'=>'fa fa-eye','color'=>'info','showIf'=>"[status_id] == 1 "];
				

				


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
				if(CRUDBooster::getCurrentMethod() == 'getAdd') {
					
						$this->load_js[] = asset("js/pengajuan/kegiatan.js");
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
			
				if(CRUDBooster::myPrivilegeName() == 'user')
				{
					$bagianuser = DB::table('bagian_user')->where('user_id' , CRUDBooster::MyId())->first();
					if($bagianuser->bagian_id != 6)
					{
						$query->where('bagian_id' , $bagianuser->bagian_id)
									->whereIn('status_id' , ['1' , '2' , '3' , '4']);
					}
				}

				if(CRUDBooster::myPrivilegeName() == 'Bendahara')
				{
					$query->whereIn('status_id' , ['1' , '2' , '3' , '4']);
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
				if($column_index == 7)
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
				$bagianuser = DB::table('bagian_user')->where('user_id' , CRUDBooster::MyId())->first();
				$bagian 	= DB::table('bagian')->where('id' , $bagianuser->bagian_id)->first();
				$parameter 	= DB::table('parameter')->where('nama','Tahun Anggaran')->first();

				// generate nomor pengajuan
				$dataPengajuan = DB::table('no_pengajuan')->where('bagian_id' , $bagianuser->bagian_id)
															->where('jenis' , 'Kegiatan')
															->get();
				
				if(Count($dataPengajuan) == 0)
				{
					$data = [];
					$data['bagian_id'] 	= $bagianuser->bagian_id;
					$data['nomor'] 		= 1;
					$data['jenis'] 		= "Kegiatan";
					
					DB::table('no_pengajuan')->insert($data);
					$nomor = 1;
				}
				else
				{
					$data = DB::table('no_pengajuan')->where('bagian_id' , $bagianuser->bagian_id)
															->where('jenis' , 'Kegiatan')
															->first();
					
					$nomor = $data->nomor + 1;
					DB::table('no_pengajuan')->where('bagian_id' , $bagianuser->bagian_id)
											->where('jenis' , 'Kegiatan')
											->update(['nomor' => $nomor
											]);
				}

				$nomor_pengajuan = "AJU-" . $nomor . '/' . $bagian->kode . '/' . $parameter->nilai;
				// end generate nomor pengajuan

				// fill no_mak dan uraian
				// $rpk = DB::table('m_rpk')->where('id' , $postdata['rpk_id'])->first();
				$rkakl = DB::table('rkakl')->where('id' , $postdata['rkakl_id'])->first();
				// end fill no_mak dan uraian

				$postdata['bagian_id']			= $bagianuser->bagian_id;
				$postdata['thnang']				= $parameter->nilai;
				$postdata['rkakl_id']			= $rkakl->id;
				$postdata['no_mak'] 			= $rkakl->no_mak;
				$postdata['uraian'] 			= $rkakl->uraian;
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
				$DataKeg = DB::table('m_kegiatan')->where('id' , $id)->first();
				$getRkakl = DB::table('rkakl')->where('id' , $DataKeg->jenis_belanja)->first();
				$DataRkakl = DB::table('rkakl')->where('no_mak_sys' , 'LIKE' , '%' . $getRkakl->no_mak . '%')->get();
				$data = [];
				$akun = '';
				foreach ($DataRkakl as $key => $value) {
					$data[$key]['kegiatan_id'] 				=  $id;
					$data[$key]['jenis_transaksi'] 		=  'Kegiatan';
					$data[$key]['level'] 							=  $value->level;
					$data[$key]['header'] 						=  $value->header;
					if($akun == '')
					{
					$data[$key]['kode'] 							=  $value->kode;
					$akun 														= $value->kode;
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

					$to = '/admin/keg/' . $id . '/dakun';
					$message = 'master kegiatan berhasil ditambahkan';
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
				 $bagianuser = DB::table('bagian_user')->where('user_id' , CRUDBooster::myId())->first();
				 $postdata['bagian_id'] = $bagianuser->bagian_id;
	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after edit public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_after_edit($id) {
				$to = '/admin/keg/' . $id . '/dakun';
				$message = 'master kegiatan berhasil diubah';
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

		public function detail_akun($id)
		{
					$data = [];
				  $data['page_title'] = 'Pilih Akun';
				  $data['row'] = DB::table('detail_akun')->where('kegiatan_id',$id)->get();
				  $data['id'] = $id;
				  
				  //Please use cbView method instead view method from laravel
				  $this->cbView('backend.pengajuan.kegiatan.detailakun',$data);
		}

		public function getDraft($id)
		{
			//Create an Auth
			if(!CRUDBooster::isRead() && $this->global_privilege==FALSE || $this->button_edit==FALSE) {    
				CRUDBooster::redirect(CRUDBooster::adminPath(),trans("crudbooster.denied_access"));
			}
			
			$data = [];
			$data['page_title'] = 'Draft Kegiatan';
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
			
			//Please use cbView method instead view method from laravel
			$this->cbView('backend.pengajuan.kegiatan.draft',$data);
		}

		public function getAdd()
		{
			if(!CRUDBooster::isCreate() && $this->global_privilege==FALSE || $this->button_add==FALSE) {    
				CRUDBooster::redirect(CRUDBooster::adminPath(),trans("crudbooster.denied_access"));
			  }
			  
			  $data = [];
			  $data['page_title'] = 'Add Data';
			  $data['hotel'] = DB::table('hotel')->get(['id' , 'nama_hotel']);
				$data['provinsi'] = DB::table('provinsi')->get(['id' , 'title']);
				$bagianuser = DB::table('bagian_user')->where('user_id' , CRUDBooster::myId())->first();
				
				$data['current_bagian']  = DB::table('bagian')->where('id' , $bagianuser->bagian_id)->first();

				$data['nama_kegiatan'] = $this->memuat_nomak();
				// $data['jenis_belanja'] = $this->jenis_belanja();
				
				
			  //Please use cbView method instead view method from laravel
			  $this->cbView('backend.pengajuan.kegiatan.add',$data);
		}

		public function getEdit($id)
		{
			if(!CRUDBooster::isCreate() && $this->global_privilege==FALSE || $this->button_edit==FALSE) {    
				CRUDBooster::redirect(CRUDBooster::adminPath(),trans("crudbooster.denied_access"));
			  }
			  
			  $data = [];
			  $data['page_title'] = 'Edit Data';
			  $data['kegiatan'] = DB::table('m_kegiatan')->where('id' ,$id)->first(); 
			  
			  $data['hotel'] = DB::table('hotel')->get();
			  $data['prov'] = DB::table('provinsi')->where('id' , $data['kegiatan']->provinsi_id )->first(['id' , 'title']);
			  $data['akun']		= DB::table('rkakl')->where('no_urut' , $data['kegiatan']->jenis_belanja)->first();
			  $data['id']		= $id;
			  $data['bagian'] = DB::table('bagian')->where('nama' , '!=' , 'All')->get();
			  $data['provinsi'] = DB::table('provinsi')->get();
			  
			  $data['jenis_belanja'] = $this->jenis_belanja($data['kegiatan']->rkakl_id);
			  
			  
			  //Please use cbView method instead view method from laravel
			  $this->cbView('backend.pengajuan.kegiatan.edit',$data);
		}

		public function senddraft($id)
		{
			//ubah status
			DB::table('m_kegiatan')->where('id' , $id)->update(['status_id'=>2]);

			$data = DB::table('m_kegiatan')->where('id' , $id)->first();

			$config['content'] = "Pengajuan Kegiatan Baru : " . $data->no_pengajuan;
			$config['to'] = CRUDBooster::adminPath('keg/' . $id . '/draft');
			$config['id_cms_users'] = [8]; //This is an array of id users
			CRUDBooster::sendNotification($config);



				$to = '/admin/keg/';
				$message = 'kegiatan berhasil ditambahkan';
				$type = 'info';
				CRUDBooster::redirect($to,$message,$type);
		}

		public function sendBend(Request $request , $id)
		{
			
			if(CRUDBooster::myPrivilegeName() == 'Bendahara')
			{
				DB::table('m_kegiatan')->where('id' , $id)
				->update([
					'metode_bayar_id' => $request->input('metode_bayar_id'),
					'status_id'		=> $request->input('status_id'),
					'alasan'		=> $request->input('alasan')
				]);

				$cek = DB::table('transaksi')->where('id_t' , $id)->where('keterangan' , 'kegiatan')->Count();
				if($cek == 0)
				{
					$this->insert_to_transaksi($id , 'Kegiatan' , $request->input('status_id'));
				}
				else
				{
					$this->update_transaksi_status($id , 'Kegiatan' , $request->input('status_id'));
				}
			
				
			}

			return redirect(CRUDBooster::mainpath());
			
		}

		public function print_notadinas($id)
		{
			$kegiatan = DB::table('m_kegiatan')->where('id' , $id)->first();
			$bagianuser 				= DB::table('bagian_user')->where('user_id' , CRUDBooster::MyId())->first();
			$ppk						= DB::table('pejabat')->where('jabatan' , 'Pejabat Pembuat Komitmen')->first();
			$pimpinan					= DB::table('pimpinan')->where('bagian_id' , $bagianuser->bagian_id)->first();
			$data['no_pengajuan'] 		= $kegiatan->no_pengajuan;
			$data['total_pengajuan']	= $kegiatan->total_pengajuan;
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
			
			$data['detail']				= DB::table('detail_kegiatan')->where('kegiatan_id', $id)->where('level' , 0)->get();
			
			$view = view('backend.pengajuan.kegiatan.laporan.notadinas', $data)->render();
			$pdf = App::make('dompdf.wrapper');
			$pdf->loadHTML($view);
			$pdf->setPaper($papersize, $paperorientation);

			return $pdf->stream($filename.'.pdf');
			
		}


		public function getbagian(){
			$data = DB::table('bagian_user')->where('user_id', CRUDBooster::myId())->first();
			$bagian = DB::table('bagian')->where('id', $data->bagian_id)->first();
			return $bagian->nama;

		}
		
		public function jenis_belanja($id)
		{
			
			$data_rkakl = DB::table('rkakl')->where('id' , $id)->first();
			$akun_honor = DB::table('parameter')->where('nama' , 'Akun Honor')->first();
			$akun_perjadin = DB::table('parameter')->where('nama' , 'Akun perjadin')->first();
			$akun_pengadaan = DB::table('parameter')->where('nama' , 'Akun pengadaan')->first();
			$akun = explode("," , $akun_honor->nilai);
			$perjadin = explode("," , $akun_perjadin->nilai);
			$pengadaan = explode("," , $akun_pengadaan->nilai);
			$data_akun  = DB::table('rkakl')->where('no_mak_sys' , 'LIKE' , '%' . $data_rkakl->no_mak_sys . '%')
			->whereNotIn('kode' , $akun)
			->whereNotIn('kode' , $perjadin)
			->whereNotIn('kode' , $pengadaan)
			->where('level' , 11)                       
			->get(['kode' , 'id','uraian']);
	
			return $data_akun;
		}

		public function memuat_nomak()
    {
        $parameter = DB::table('parameter')->where('nama' , 'Tahun Anggaran')->first();
        $linsek = DB::table('parameter')->where('nama' , 'MAK LINSEK')->first();
        $perkantoran = DB::table('parameter')->where('nama' , 'Mak Perkantoran')->first();
        $satkeruser = DB::table('satker_user')->where('user_id' , CRUDBooster::MyId())->first();
        $bagianuser = DB::table('bagian_user')->where('user_id' , CRUDBooster::MyId())->first();

       $data_rpk = DB::table('m_rpk')->where('thnang' , $parameter->nilai)
                                     ->where('satker_id' , $satkeruser->satker_id)
                                     ->where('bagian_id' , $bagianuser->bagian_id)
                                     ->where('no_mak_7' , '!=' , $linsek->nilai)
                                     ->where('no_mak_7' , 'NOT LIKE' , '%' . $perkantoran->nilai . '%')
                                     ->get();

       
        
        return $data_rpk;
    }

		public function pertanggungjawaban_index()
		{
			
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





	}