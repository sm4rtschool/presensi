<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transaksi_kehadiran extends CI_Controller {
	
	public function __construct()
    {
        parent::__construct();
		// profiler ini untuk menampilkan debug
        //$this->output->enable_profiler(TRUE);
		//echo tgl_indo("2016-03-26")
			
		$this->load->database();
		$this->load->helper('url');
		$this->load->library('pagination');
		$this->load->library('auth');
		$this->load->library('fungsi');
		$this->load->library('session');
		$this->load->model('Trkehadiranmodel');
		$this->load->model('m_mspegawai');
		$this->load->model('m_database');
	}
	
	public function index()
	{
		if(!is_logged_in())
		{
			redirect('login');
		}
		else
		{	
			$this->list_kehadiran();
		}
	}
	
	function datatables_pegawai()
	{
		
		/* Indexed column (used for fast and accurate table cardinality) */
		$sIndexColumn = "idabsen";
       
		/* DB table to use */
		$sTable = "tabsenb";
     
		/* Database connection information 
		$gaSql['user']       = "";
		$gaSql['password']   = "";
		$gaSql['db']         = "";
		$gaSql['server']     = "";
		*/
     
		/*
		* Columns
		* If you don't want all of the columns displayed you need to hardcode $aColumns array with your elements.
		* If not this will grab all the columns associated with $sTable
		*/
		
		$aColumns = array('Keterangan', 'Departemen', 'CONVERT(VARCHAR, Tanggal , 120)');
		//$aColumns = array('no_baris', 'idabsen', 'nip', 'Nama', 'Tanggal', 'KdAbsen', 'Keterangan', 'Departemen', 'Jabatan', 'is_pimpinan_approve', 'is_operator_approve');
		//$aColumns = array();
 
 
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * If you just want to use the basic configuration for DataTables with PHP server-side, there is
     * no need to edit below this line
     */
     
    /*
     * ODBC connection
     */
    //$connectionInfo = array("UID" => $gaSql['user'], "PWD" => $gaSql['password'], "Database"=>$gaSql['db'],"ReturnDatesAsStrings"=>true);
    //$gaSql['link'] = sqlsrv_connect( $gaSql['server'], $connectionInfo);
    $params = array();
    //$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
           
       
    /* Ordering */
	
    $sOrder = "";
    if ( isset( $_GET['iSortCol_0'] ) ) 
	{
        $sOrder = "ORDER BY  ";
        for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ ) {
            if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" ) {
                $sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
                    ".addslashes( $_GET['sSortDir_'.$i] ) .", ";
            }
        }
        
		$sOrder = substr_replace( $sOrder, "", -2 );
        if ( $sOrder == "ORDER BY" ) 
		{
            $sOrder = "";
        }
		
    }
       
    /* Filtering */
    $sWhere = "";
    if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" ) {
        $sWhere = "WHERE (";
        for ( $i=0 ; $i<count($aColumns) ; $i++ ) {
            $sWhere .= $aColumns[$i]." LIKE '%".addslashes( $_GET['sSearch'] )."%' OR ";
        }
        $sWhere = substr_replace( $sWhere, "", -3 );
        $sWhere .= ')';
    }
    
	/* Individual column filtering */
    for ( $i=0 ; $i<count($aColumns) ; $i++ ) {
        if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )  {
            if ( $sWhere == "" ) {
                $sWhere = "WHERE ";
            } else {
                $sWhere .= " AND ";
            }
            $sWhere .= $aColumns[$i]." LIKE '%".addslashes($_GET['sSearch_'.$i])."%' ";
        }
    }
       
    /* Paging */
    $top = (isset($_GET['iDisplayStart']))?((int)$_GET['iDisplayStart']):0;
    $limit = (isset($_GET['iDisplayLength']))?((int)$_GET['iDisplayLength'] ):10;
	
    $sQuery = "SELECT TOP $limit ".implode(",",$aColumns)."
        FROM $sTable
        $sWhere ".(($sWhere=="")?" WHERE ":" AND ")." $sIndexColumn NOT IN
        (
            SELECT $sIndexColumn FROM
            (
                SELECT TOP $top ".implode(",",$aColumns)."
                FROM $sTable
                $sWhere
                $sOrder
            )
            as [virtTable]
        )
        $sOrder";

		$parameter_login = array(
		'kdkaryawan' => $this->session->userdata('kdkaryawan'),
		'level' => $this->session->userdata('level')
		);
		
		//echo $parameter_login['kdkaryawan'] . ' | ' . $parameter_login['level'];
       
		//function getlist_ketidakhadiran($aColumns, $sWhere, $sOrder, $top, $limit, $parameter_login)
		$rResult = $this->Trkehadiranmodel->getlist_kehadiran($aColumns, $sWhere, $sOrder, $top, $limit, $parameter_login);
       
		$iTotal = 0;
        $rResultTotal = $this->Trkehadiranmodel->getlist_kehadiran_total($sIndexColumn, $parameter_login);
        $iTotal = $rResultTotal->num_rows();
		
		//$sQueryCnt = "SELECT * FROM $sTable $sWhere";
		//function getlist_ketidakhadiran_filteredtotal($sIndexColumn, $parameter_login, $aColumns, $sWhere, $sOrder, $top, $limit)
		$iFilteredTotal = 0;
		$rResultTotalFiltered = $this->Trkehadiranmodel->getlist_kehadiran_filteredtotal($sIndexColumn, $parameter_login, $aColumns, $sWhere, $sOrder, $top, $limit);
		$iFilteredTotal = $rResultTotalFiltered->num_rows();
		
			$sEcho = (isset($_REQUEST['sEcho'])) ? $_REQUEST['sEcho'] : 0;
				
			$output = array(
				//"sEcho" => $sEcho, //$this->input->post('draw'),
				"sEcho" => $sEcho,
				"iTotalRecords" => $iTotal,
				//"recordsTotal" => $iTotal,
				"iTotalDisplayRecords" => $iFilteredTotal,
				//"recordsFiltered" => $iFilteredTotal,
				"aaData" => array()
			);			
		
		$numbering = 0;
		$page = 1;
		
		foreach ($rResult->result() as $aRow) 
		{
			
			$row = array();			
			//$row[] = $numbering + $page; 
			
				//$is_pimpinan_approve = $aRow->is_pimpinan_approve;
				//$is_operator_approve = $aRow->is_operator_approve;
				
				$row[] = $aRow->no_baris; 
				//$row[] = $numbering + $page; 
				$row[] = $aRow->Departemen;
				$row[] = $aRow->nip;
				$row[] = $aRow->Nama;
			
				//row[] = $aRow->Tanggal;
				$row[] = date('d-m-Y', strtotime($aRow->Tanggal));
			
				$ftipe = $aRow->FTipe;
				If ($ftipe == 0)
				{
					$row[] = 'IN';
				}
				else
				{
					$row[] = 'OUT';
				}
				
				$row[] = date('H:i:s', strtotime($aRow->Waktu));
				$row[] = $aRow->Keterangan;
			
				/*
				//	atur kolom status pimpinan
				if ($is_pimpinan_approve == 0)	
				{
				
					$row[] = '<div class="bg-red-active color-palette" align = "center"><span>rejected</span></div>';
				
				}
				else if ($is_pimpinan_approve == 1)	
				{
				
					$row[] = '<div class="bg-blue-active color-palette" align = "center"><span>approved</span></div>';
				
				}
				else	
				{
				
					$row[] = '<div class="bg-yellow-active color-palette" align = "center"><span>unread</span></div>';
					
				}		

				//	atur kolom status petugas
				if ($is_operator_approve == 0)	
				{
				
					$row[] = '<div class="bg-red-active color-palette" align = "center"><span>rejected</span></div>';
				
				}
				else if ($is_operator_approve == 1)	
				{
				
					$row[] = '<div class="bg-blue-active color-palette" align = "center"><span>approved</span></div>';
				
				}
				else	
				{
				
					$row[] = '<div class="bg-yellow-active color-palette" align = "center"><span>unread</span></div>';
				
				}
			
				//	atur kolom aksi
				
				//add html for action
				
				//'<i class="ui-tooltip fa fa-book" style="font-size: 22px;color:#2222aa;cursor:pointer;" data-original-title="Detail" onclick="detailpekerjaan('+row.id_pekerjaan+')" ></i><i class="ui-tooltip fa fa-pencil" style="font-size: 22px; color:#22aa22; cursor:pointer;" data-original-title="Edit" onclick="editpekerjaan('+row.id_pekerjaan+')"></i>&nbsp;<i class="ui-tooltip fa fa-trash-o" style="font-size: 22px;color:#aa2222; cursor:pointer;" data-original-title="Delete" onclick="deletepekerjaan('+row.id_pekerjaan+')" ></i>'
				
				if ($is_pimpinan_approve == 0)	
				{
				
					//$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void()" title="Detail" onclick="detail_absen('."'".$aRow->idabsen."'".')"><i class="glyphicon glyphicon-check"></i> Detail</a>';
					$row[] = '<i class="ui-tooltip fa fa-book" title="Detail" style="font-size: 22px;color:#2222aa;cursor:pointer;" data-original-title="Detail" onclick="detail_absen('."'".$aRow->idabsen."'".')"></i>';
					
				
				}
				else if ($is_pimpinan_approve == 1)	
				{
				
					//$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void()" title="Detail" onclick="detail_absen('."'".$aRow->idabsen."'".')"><i class="glyphicon glyphicon-check"></i> Detail</a>';
					$row[] = '<i class="ui-tooltip fa fa-book" title="Detail" style="font-size: 22px;color:#2222aa;cursor:pointer;" data-original-title="Detail" onclick="detail_absen('."'".$aRow->idabsen."'".')"></i>';
								
				}
				else	
				{
				
					//$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void()" title="Detail" onclick="detail_absen('."'".$aRow->idabsen."'".')"><i class="glyphicon glyphicon-check"></i> Detail</a>
					//<a class="btn btn-sm btn-primary" href="javascript:void()" title="Hapus" onclick="hapus_absen('."'".$aRow->idabsen."'".')"><i class="glyphicon glyphicon-check"></i> Hapus</a>';

					$row[] = '<i class="ui-tooltip fa fa-book" title="Detail" style="font-size: 22px;color:#2222aa;cursor:pointer;" data-original-title="Detail" onclick="detail_absen('."'".$aRow->idabsen."'".')"></i>&nbsp;
					<i class="ui-tooltip fa fa-trash-o" title="Hapus" style="font-size: 22px;color:#aa2222; cursor:pointer;" data-original-title="Hapus" onclick="hapus_absen('."'".$aRow->idabsen."'".')"></i>';
						
				}	
				*/
						
			$page++;
			$output['aaData'][] = $row;
			//$output_data[] = $row;
		
		}	//	foreach ($rResult->result() as $aRow) 		
	
		echo json_encode($output);
				
	}
	
	function list_kehadiran()
	{
		
		$data['username'] = $this->session->userdata('username');
		$data['nama_lengkap'] = $this->session->userdata('nama_lengkap');
		$data['email'] = $this->session->userdata('email');
		$data['address'] = $this->session->userdata('address');
		$data['phone'] = $this->session->userdata('phone');
		$data['level'] = $this->session->userdata('level');
		
		$data['title']="<i class=\"fa fa-user fa-fw\"></i> Transaksi Kehadiran";
		$data['subtitle']=" Transaksi Kehadiran / Pegawai";
		$data['tabletitle']="Table Transaksi Kehadiran";
		$data['navigasi']="<li><a href=\"#\"><i class=\"fa fa-dashboard\"></i> Home</a></li>
            <li><a href=\"#\">Transaksi</a></li>
            <li class=\"active\">Kehadiran</li>";
			
		$this->load->view('header',$data);
		$this->load->view('leftsidebar');
		$this->load->view('transaksi_kehadiran/list_kehadiran',$data);
		$this->load->view('footer');
		$this->load->view('rightsidebar');
		
	}
	
	function add_kehadiran()
	{
		
		$data['username'] = $this->session->userdata('username');
		$data['nama_lengkap'] = $this->session->userdata('nama_lengkap');
		$data['email'] = $this->session->userdata('email');
		$data['address'] = $this->session->userdata('address');
		$data['phone'] = $this->session->userdata('phone');
		$data['level'] = $this->session->userdata('level');
		
		$this->load->library('form_validation');
		
		$data['title']="<i class=\"fa fa-user fa-fw\"></i> Transaksi Kehadiran";
		$data['subtitle']=" Transaksi / Kehadiran";
		$data['tabletitle']="Table Transaksi Kehadiran";
		$data['navigasi']="<li><a href=\"#\"><i class=\"fa fa-dashboard\"></i> Home</a></li>
            <li><a href=\"#\">Transaksi</a></li>
            <li class=\"active\">Kehadiran</li>";
		
		if(!is_logged_in())
		{
			redirect('login');
		}
		else
		{
			
			//$data['msjenisketidakhadiran'] = $this->Trketidakhadiranmodel->getKdJenisKetidakhadiran();
			//$data['mspimpinan'] = $this->Trketidakhadiranmodel->getPimpinan();
		
			$this->load->view('header',$data);
			$this->load->view('leftsidebar');
			$this->load->view('transaksi_kehadiran/add_kehadiran',$data);
			$this->load->view('footer');
			$this->load->view('rightsidebar');
			
		}
		
	}
	
	public function check_alasan()
    {
            if ($this->input->post('cboalasan') === '- Pilih Alasan -')  {
				$this->form_validation->set_message('check_alasan', 'Alasan harus diisi !!');
            return FALSE;
        }
        else {
            return TRUE;
        }
    }
	
	/* save add data */
	function save_add()
	{
	
		if(!is_logged_in())
		{
			redirect('login');
		}
		else
		{
			//initial variabel
			$sTanggalAbsen = "";
			
			$data['username'] = $this->session->userdata('username');
			$data['nama_lengkap'] = $this->session->userdata('nama_lengkap');
			$data['email'] = $this->session->userdata('email');
			$data['address'] = $this->session->userdata('address');
			$data['phone'] = $this->session->userdata('phone');
			$data['kdkaryawan'] = $this->session->userdata('kdkaryawan');
					
			$this->load->library('form_validation');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>', '</div>');
			
			$this->form_validation->set_rules('edtgldari', 'Dari Tanggal', 'trim|required');
			$this->form_validation->set_rules('edtglsampai', 'Sampai Tanggal', 'trim|required');
			
			//echo $cboalasan = $this->input->post('cboalasan');
			
			//If ($this->input->post('cboalasan') == '- Pilih Alasan -')
			//{
			$this->form_validation->set_rules('cboalasan', 'Alasan', 'required|callback_check_alasan');
			//}
			
			$this->form_validation->set_rules('cbopimpinan', 'Pimpinan', 'required|is_natural');	
			
			if (empty($_FILES['userfile']['name']))
			{
				$this->form_validation->set_rules('userfile', 'Lampiran', 'required');
			}
			
			if ($this->form_validation->run() == FALSE) 
			{
						
				$data['title']="<i class=\"fa fa-user fa-fw\"></i> Transaksi Ketidakhadiran";
				$data['subtitle']=" Transaksi / Ketidakhadiran";
				$data['tabletitle']="Table Master Data User";
				$data['navigasi']="<li><a href=\"#\"><i class=\"fa fa-dashboard\"></i> Home</a></li>
				<li><a href=\"#\">Transaksi</a></li>
				<li class=\"active\">Ketidakhadiran</li>";
				
				$data['mspimpinan'] = $this->Trketidakhadiranmodel->getPimpinan();
				$data["message"] = "";
				
				$this->load->view('header',$data);
				$this->load->view('leftsidebar');
				$this->load->view('transaksi_ketidakhadiran/add_ketidakhadiran',$data);
				$this->load->view('footer');
				$this->load->view('rightsidebar');
			
			} 
			else 
			{  
		
				$edtgldari = $this->input->post('edtgldari');
				$edtglsampai = $this->input->post('edtglsampai');
				$cboalasan = $this->input->post('cboalasan');
				$cbopimpinan = $this->input->post('cbopimpinan');
				$memoketerangan = $this->input->post('memoketerangan');
				$file_element_name = $_FILES['userfile']['name'];
				//$_FILES['userfile']['name']
				
				$dttanggaldari = str_replace("/","-",$edtgldari);
				$dttanggalsampai = str_replace("/","-",$edtglsampai);
	
				$begin = new DateTime($dttanggaldari);
				$end = new DateTime($dttanggalsampai);
				date_add($end,date_interval_create_from_date_string("1 days"));

				$interval = DateInterval::createFromDateString('1 day');
				$period = new DatePeriod($begin, $interval, $end);

				foreach ($period as $dt)
				{
					
					$sTanggalAbsen = $dt->format("Y-m-d");
					//echo $sTanggalAbsen;
					//echo '<br>';
					
					//get tmt pegawai berdasarkan tanggal ketika si pegawai absen
					
					$qrygettmtpegawai = $this->m_database->getDataTMTPegawai($data['kdkaryawan'], $sTanggalAbsen, $sTanggalAbsen);
					
					If ($qrygettmtpegawai->num_rows() > 0)
					{
						
						foreach ($qrygettmtpegawai->result() as $row)
						{
							$sKdDepartemen = $row->kddepartemen;
							$sKdJabatan = $row->kdjabatan;
						}
						
					}
					else
					{
						echo "data tmt pegawai kosong";
					}
					
					$is_hari_libur = $this->m_database->GetHariLiburSabtuMinggu($sTanggalAbsen);
					
					If ($is_hari_libur)  //  hari libur nasional
					{
						Goto Goto_HariLibur;
					}            
					else
					{
						
						/*{ Proses karyawan yang schedule nya normal }  { Proses karyawan yang schedule nya normal }
						{ get ikdshift  } { get ikdshift  } { get ikdshift  } { get ikdshift  } { get ikdshift  }*/
						
						$query = $this->db->query(
						"SP_GetScheduleKaryawanSelainShift '".$data['kdkaryawan']."','".$sTanggalAbsen."'");
						
						If ($query->num_rows() > 0)
						{
							
							foreach ($query->result() as $row)
							{
								$iKdShift = $row->recordid;
							}
							
						}
						else
						{
							$iKdShift = -1;
						}
												
					} // Jika Bukan hari libur atau hari kerja
					
					/*{ Get workon, workoff, nama schedule, is_eselon } { Get workon, workoff, nama schedule, is_eselon }*/

					$QryGetShift = $this->m_database->CariShift($iKdShift);
					
					If ($QryGetShift->num_rows() > 0)
					{
						
						$sHari = $this->fungsi->GetNamaHariByDate($sTanggalAbsen);
						
						If ($sHari == 'Jumat')
						{

							foreach ($QryGetShift->result() as $row)
							{
								$sWorkOn = $row->WorkOnJumat;
								$sWorkOff = $row->WorkOffJumat;
								$sShift = $row->Shift;
								$is_eselon = $row->is_eselon;
							}

						}
						else	// Schedule senin sampai kamis
						{ 
						
							foreach ($QryGetShift->result() as $row)
							{
								$sWorkOn = $row->WorkOn;
								$sWorkOff = $row->WorkOff;
								$sShift = $row->Shift;
								$is_eselon = $row->is_eselon;
							}
							
						}
						
					}
					
					
					/*{ Get workon, workoff, nama schedule, is_eselon } { Get workon, workoff, nama schedule, is_eselon }*/
					
					//  jika kdjenisketidakhadiran nya tidak dilimit ya langsung aja insert ke tabsen
                	
					//echo $is_eselon;
					
					
					$is_limit = $this->input->post('is_limit');
					
					If ($is_limit == 0)
					{
												
						$sSerialNumber = "-";
						$sScheduleMasuk = $sTanggalAbsen . ' ' . $sWorkOn;
						$sSchedulePulang = $sTanggalAbsen . ' ' . $sWorkOff;
						
						$this->Trketidakhadiranmodel->GenerateAlasanNoLimit($cbopimpinan, $sTanggalAbsen, $data['kdkaryawan'], $cboalasan, $is_eselon, $sKdDepartemen, $sKdJabatan, $sScheduleMasuk, $sSchedulePulang, $iKdShift, $sShift, $memoketerangan, $sSerialNumber, $data['username']);
					
					}	//  If is_limit = '0' Then  //  jika kdjenisketidakhadiran nya tidak dilimit ya langsung aja insert ke tabsen
					else //if ($this->input->post('is_limit') = 1)	//  If is_limit = '1' Then  //  jika kdjenisketidakhadiran nya dilimit
					{
						
						$sSerialNumber = "-";
						$sScheduleMasuk = $sTanggalAbsen . ' ' . $sWorkOn;
						$sSchedulePulang = $sTanggalAbsen . ' ' . $sWorkOff;
						
						//echo $cboalasan;
						
						$this->Trketidakhadiranmodel->GenerateAlasanLimit($file_element_name, $cbopimpinan, $sTanggalAbsen, $data['kdkaryawan'], $cboalasan, $is_eselon, $sKdDepartemen, $sKdJabatan, $sScheduleMasuk, $sSchedulePulang, $iKdShift, $sShift, $memoketerangan, $sSerialNumber, $data['username']);
						
					}
					
					
					Goto_HariLibur:
					//echo "hari libur bos";
					
				}	//looping tanggal
				
				//@unlink($_FILES[$file_element_name]);
				
				$this->session->set_flashdata('notif', '<div class="box-body"><div class="alert alert-info alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-info"></i> Info!</h4>
                    Input data user berhasil.
                  </div></div>');
				  
				redirect('transaksi_ketidakhadiran');
				
				
			}
													
		}
	}
	/* end save add data */
	
	/*	upload file	*/
	
	function upload_attachment()
	{
		
		/**
		* This is just an example of how a file could be processed from the
		* upload script. It should be tailored to your own requirements.
		*/

		// Only accept files with these extensions
		$whitelist = array('jpg', 'jpeg', 'png', 'gif');
		$name      = null;
		$error     = 'No file uploaded.';

		if (isset($_FILES)) {
			if (isset($_FILES['file'])) {
			$tmp_name = $_FILES['file']['tmp_name'];
			$name     = basename($_FILES['file']['name']);
			$error    = $_FILES['file']['error'];
		
				if ($error === UPLOAD_ERR_OK) 
				{
				
					$extension = pathinfo($name, PATHINFO_EXTENSION);

					if (!in_array($extension, $whitelist)) {
						$error = 'Invalid file type uploaded.';
					} else {
						move_uploaded_file($tmp_name, $name);
					}
				}
			}
		}

		echo json_encode(array(
		'name'  => $name,
		'error' => $error,
		));
		
		die();
	
	}
	
	function detail_absen()
	{
		
		$level_user = $this->session->userdata('level');			
		$data['level'] = $this->session->userdata('level');
			
		$idabsen = $this->uri->segment(3);
		$data['list'] = $this->m_mspegawai->getBiodataMskaryawanByIdAbsen($idabsen, $level_user);
		//$data['idabsen'] = $idabsen;
		$data['tabsen_request'] = $this->Trketidakhadiranmodel->getTabsenRequestByIdAbsen($idabsen);
		
		$this->load->view('transaksi_ketidakhadiran/detail_absen',$data);
		
	}
	
	/* delete data*/
	
	function hapus_absen($id='')
	{
				
		if(!is_logged_in())
		{
			redirect('login');
		}
		else
		{
		
			if($id=='')
			{
				redirect('login');
			}
			else
			{
				
				$this->Trketidakhadiranmodel->hapus_absen($id);
				$this->session->set_flashdata('notif', '<div class="alert-box success"><span>Sukses: </span> Data absen Dengan ID '.$id.' Berhasil Dihapus.</div>');
				redirect('transaksi_ketidakhadiran');	
				
			}
		}
	}
	
	/* end delete data */
	
}

/* End of file msuser.php */
/* Location: ./application/controllers/transaksi_ketidakhadiran.php */