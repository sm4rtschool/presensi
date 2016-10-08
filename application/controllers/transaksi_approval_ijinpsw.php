<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transaksi_approval_ijinpsw extends CI_Controller{
	
	public function __construct()
    {
    
		parent::__construct();
		// profiler ini untuk menampilkan debug
		//$this->output->enable_profiler(TRUE);
			
		$this->load->database();
		$this->load->helper('url');
		$this->load->library('pagination');
		$this->load->library('auth');
		$this->load->library('fungsi');
		$this->load->library('session');
		$this->load->model('m_trappijinpsw');
		$this->load->model('m_mspegawai');
		$this->load->helper('html');
		
	}
		
	public function index()
	{
		if(!is_logged_in())
		{
			redirect('login');
		}
		else
		{	
			$this->list_approval_ijinpsw();
		}
	}
	
	function datatables_pimpinan()
	{
		
		$sIndexColumn = "idabsen";
		$sTable = "tabsen";		
		$aColumns = array('nip', 'Nama', 'CONVERT(VARCHAR, Tanggal , 120)', 'Departemen');  
        $params = array();
    
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
    $top = (isset($_GET['iDisplayStart']))?((int)$_GET['iDisplayStart']):0 ;
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
		
		$rResult = $this->m_trappijinpsw->getlist_ijinpsw($aColumns, $sWhere, $sOrder, $top, $limit, $parameter_login);
       
		$iTotal = 0;
        $rResultTotal = $this->m_trappijinpsw->getlist_ijinpsw_total($sIndexColumn, $parameter_login);
        $iTotal = $rResultTotal->num_rows();
		
		$iFilteredTotal = 0;
		$rResultTotalFiltered = $this->m_trappijinpsw->getlist_ijinpsw_filteredtotal($sIndexColumn, $parameter_login, $aColumns, $sWhere, $sOrder, $top, $limit);
		$iFilteredTotal = $rResultTotalFiltered->num_rows();
		
		$sEcho = (isset($_REQUEST['sEcho'])) ? $_REQUEST['sEcho'] : 0;
				
		$output = array(
			"sEcho" => $sEcho,
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);	

		//date_default_timezone_set('Asia/Jakarta');
		
		$numbering = 0;
		$page = 1;
		
		foreach ($rResult->result() as $aRow) 
		{
			
			$row = array();			
				
				$row[] = $aRow->no_baris; 
				$row[] = $aRow->Departemen;
				//$row[] = $aRow->nip;
				$row[] = $aRow->Nama;
			
				$row[] = date('d-m-Y', strtotime($aRow->Tanggal));
				$row[] = date('h:i:s', strtotime($aRow->WorkOn));
				$row[] = date('h:i:s', strtotime($aRow->WorkOff));
				//$row[] = date('h:i:s', strtotime($aRow->DutyOn));
				$row[] = date('h:i:s', strtotime($aRow->DutyOff));
				$row[] = $aRow->HomeEarly;
				$row[] = $aRow->alasan;
			
				$is_pimpinan_approve_psw = $aRow->is_pimpinan_approve_psw;
				//	atur kolom status pimpinan
				if ($is_pimpinan_approve_psw == 0)	
				{
				
					//$row[] = '<div class="bg-red-active color-palette" align = "center"><span>rejected</span></div>';
					$row[] = '<div align = "center"><img src="' . base_url() . 'asset/img/led_yellowanimated_16x16.gif" align = "center"></div>';
				
				}
				else if ($is_pimpinan_approve_psw == 1)	
				{
				
					$row[] = '<div align = "center"><img src="' . base_url() . 'asset/img/led_greenanimated_16x16.gif" align = "center"></div>';
					//$row[] = '<div class="bg-blue-active color-palette" align = "center"><span>approved</span></div>';
				
				}
				else	
				{
				
					//$row[] = '<div class="bg-yellow-active color-palette" align = "center"><span>unread</span></div>';
					$row[] = '<div align = "center"><img src="' . base_url() . 'asset/img/SR_Blink.gif" align = "center"></div>';
					
				}		

				//	atur kolom status petugas
				/*
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
				*/
				//	atur kolom aksi
				
				//add html for action
				
				//'<i class="ui-tooltip fa fa-book" style="font-size: 22px;color:#2222aa;cursor:pointer;" data-original-title="Detail" onclick="detailpekerjaan('+row.id_pekerjaan+')" ></i><i class="ui-tooltip fa fa-pencil" style="font-size: 22px; color:#22aa22; cursor:pointer;" data-original-title="Edit" onclick="editpekerjaan('+row.id_pekerjaan+')"></i>&nbsp;<i class="ui-tooltip fa fa-trash-o" style="font-size: 22px;color:#aa2222; cursor:pointer;" data-original-title="Delete" onclick="deletepekerjaan('+row.id_pekerjaan+')" ></i>'
				
				if ($is_pimpinan_approve_psw == 0)	
				{
				
					$row[] = '<i class="ui-tooltip fa fa-check-square-o" title="Proses" style="font-size: 22px;color:#aa2222; cursor:pointer;" data-original-title="Proses" onclick="proses_approval_ijinpsw('."'".$aRow->idabsen."'".','."'".$parameter_login['level']."'".')"></i>&nbsp;
					<i class="ui-tooltip fa fa-book" title="Detail" style="font-size: 22px;color:#2222aa;cursor:pointer;" data-original-title="Detail" onclick="#"></i>';
													
				}
				else if ($is_pimpinan_approve_psw == 1)	
				{
				
					$row[] = '<i class="ui-tooltip fa fa-book" title="Detail" style="font-size: 22px;color:#2222aa;cursor:pointer;" data-original-title="Detail" onclick="detail_absen('."'".$aRow->idabsen."'".')"></i>';
								
				}
				else	
				{
				
					$row[] = '<i class="ui-tooltip fa fa-check-square-o" title="Proses" style="font-size: 22px;color:#aa2222; cursor:pointer;" data-original-title="Proses" onclick="proses_approval_ijinpsw('."'".$aRow->idabsen."'".','."'".$parameter_login['level']."'".')"></i>&nbsp;
					<i class="ui-tooltip fa fa-book" title="Detail" style="font-size: 22px;color:#2222aa;cursor:pointer;" data-original-title="Detail" onclick="#"></i>';
											
				}	
				
				
															
			$page++;
			$output['aaData'][] = $row;
			//$output_data[] = $row;
		
		}	//	foreach ($rResult->result() as $aRow) 		
	
		echo json_encode($output);
				
	}
	
	function datatables_operator()
	{
		
		$sIndexColumn = "idabsen";
		$sTable = "tabsen";
		$aColumns = array('nip', 'Nama', 'CONVERT(VARCHAR, Tanggal , 120)', 'Departemen');  
		$params = array();
           
       
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
    $top = (isset($_GET['iDisplayStart']))?((int)$_GET['iDisplayStart']):0 ;
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
		
		$rResult = $this->m_trappijinpsw->getlist_ijinpsw($aColumns, $sWhere, $sOrder, $top, $limit, $parameter_login);
       
		$iTotal = 0;
        $rResultTotal = $this->m_trappijinpsw->getlist_ijinpsw_total($sIndexColumn, $parameter_login);
        $iTotal = $rResultTotal->num_rows();
		
		$iFilteredTotal = 0;
		$rResultTotalFiltered = $this->m_trappijinpsw->getlist_ijinpsw_filteredtotal($sIndexColumn, $parameter_login, $aColumns, $sWhere, $sOrder, $top, $limit);
		$iFilteredTotal = $rResultTotalFiltered->num_rows();
		
		$sEcho = (isset($_REQUEST['sEcho'])) ? $_REQUEST['sEcho'] : 0;
				
		$output = array(
			"sEcho" => $sEcho,
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);	

		//date_default_timezone_set('Asia/Jakarta');
		
		$numbering = 0;
		$page = 1;
		
		foreach ($rResult->result() as $aRow) 
		{
			
			$row = array();			
				
				$row[] = $aRow->no_baris; 
				$row[] = $aRow->Departemen;
				//$row[] = $aRow->nip;
				$row[] = $aRow->Nama;
			
				$row[] = date('d-m-Y', strtotime($aRow->Tanggal));
				$row[] = date('h:i:s', strtotime($aRow->WorkOn));
				$row[] = date('h:i:s', strtotime($aRow->WorkOff));
				//$row[] = date('h:i:s', strtotime($aRow->DutyOn));
				$row[] = date('h:i:s', strtotime($aRow->DutyOff));
				$row[] = $aRow->HomeEarly;
				$row[] = $aRow->alasan;
			
				$is_pimpinan_approve_psw = $aRow->is_pimpinan_approve_psw;
				//	atur kolom status pimpinan
				if ($is_pimpinan_approve_psw == 0)	
				{
				
					//$row[] = '<div class="bg-red-active color-palette" align = "center"><span>rejected</span></div>';
					$row[] = '<div align = "center"><img src="' . base_url() . 'asset/img/led_yellowanimated_16x16.gif" align = "center"></div>';
				
				}
				else if ($is_pimpinan_approve_psw == 1)	
				{
				
					$row[] = '<div align = "center"><img src="' . base_url() . 'asset/img/led_greenanimated_16x16.gif" align = "center"></div>';
					//$row[] = '<div class="bg-blue-active color-palette" align = "center"><span>approved</span></div>';
				
				}
				else	
				{
				
					//$row[] = '<div class="bg-yellow-active color-palette" align = "center"><span>unread</span></div>';
					$row[] = '<div align = "center"><img src="' . base_url() . 'asset/img/SR_Blink.gif" align = "center"></div>';
					
				}		

				//	atur kolom status petugas
				$is_petugas_approve_psw = $aRow->is_petugas_approve_psw;
				if ($is_petugas_approve_psw == 0)	
				{
				
					//$row[] = '<div class="bg-red-active color-palette" align = "center"><span>rejected</span></div>';
					$row[] = '<div align = "center"><img src="' . base_url() . 'asset/img/led_yellowanimated_16x16.gif" align = "center"></div>';
				
				}
				else if ($is_petugas_approve_psw == 1)	
				{
				
					//$row[] = '<div class="bg-blue-active color-palette" align = "center"><span>approved</span></div>';
					$row[] = '<div align = "center"><img src="' . base_url() . 'asset/img/led_greenanimated_16x16.gif" align = "center"></div>';
				
				}
				else	
				{
				
					//$row[] = '<div class="bg-yellow-active color-palette" align = "center"><span>unread</span></div>';
					$row[] = '<div align = "center"><img src="' . base_url() . 'asset/img/SR_Blink.gif" align = "center"></div>';
				
				}
				
				//	atur kolom aksi
				
				//add html for action
				
				//'<i class="ui-tooltip fa fa-book" style="font-size: 22px;color:#2222aa;cursor:pointer;" data-original-title="Detail" onclick="detailpekerjaan('+row.id_pekerjaan+')" ></i><i class="ui-tooltip fa fa-pencil" style="font-size: 22px; color:#22aa22; cursor:pointer;" data-original-title="Edit" onclick="editpekerjaan('+row.id_pekerjaan+')"></i>&nbsp;<i class="ui-tooltip fa fa-trash-o" style="font-size: 22px;color:#aa2222; cursor:pointer;" data-original-title="Delete" onclick="deletepekerjaan('+row.id_pekerjaan+')" ></i>'
				
				if ($is_petugas_approve_psw == 0)	
				{
				
					$row[] = '<i class="ui-tooltip fa fa-check-square-o" title="Proses" style="font-size: 22px;color:#aa2222; cursor:pointer;" data-original-title="Proses" onclick="petugas_approval_ijinpsw('."'".$aRow->idabsen."'".','."'".$parameter_login['level']."'".', '."'".$aRow->is_pimpinan_approve_psw."'".')"></i>&nbsp;
					<i class="ui-tooltip fa fa-book" title="Detail" style="font-size: 22px;color:#2222aa;cursor:pointer;" data-original-title="Detail" onclick="#"></i>';
													
				}
				else if ($is_petugas_approve_psw == 1)	
				{
				
					$row[] = '<i class="ui-tooltip fa fa-book" title="Detail" style="font-size: 22px;color:#2222aa;cursor:pointer;" data-original-title="Detail" onclick="#"></i>';
								
				}
				else	
				{
				
					$row[] = '<i class="ui-tooltip fa fa-check-square-o" title="Proses" style="font-size: 22px;color:#aa2222; cursor:pointer;" data-original-title="Proses" onclick="petugas_approval_ijinpsw('."'".$aRow->idabsen."'".','."'".$parameter_login['level']."'".', '."'".$aRow->is_pimpinan_approve_psw."'".')"></i>&nbsp;
					<i class="ui-tooltip fa fa-book" title="Detail" style="font-size: 22px;color:#2222aa;cursor:pointer;" data-original-title="Detail" onclick="#"></i>';
											
				}	
				
				
															
			$page++;
			$output['aaData'][] = $row;
			//$output_data[] = $row;
		
		}	//	foreach ($rResult->result() as $aRow) 		
	
		echo json_encode($output);
				
	}
	
	function list_approval_ijinpsw()
	{
		
		$data['username'] = $this->session->userdata('username');
		$data['nama_lengkap'] = $this->session->userdata('nama_lengkap');
		$data['email'] = $this->session->userdata('email');
		$data['address'] = $this->session->userdata('address');
		$data['phone'] = $this->session->userdata('phone');
		$data['level'] = $this->session->userdata('level');
		
		$data['title']="<i class=\"fa fa-user fa-fw\"></i> Transaksi Approval Ijin Pulang Sebelum Waktu";
		$data['subtitle']=" Transaksi Approval Ijin Pulang Cepat / Pegawai";
		$data['tabletitle']="Table Transaksi Approval Ijin Pulang Sebelum Waktu";
		$data['navigasi']="<li><a href=\"#\"><i class=\"fa fa-dashboard\"></i> Home</a></li>
            <li><a href=\"#\">Transaksi</a></li>
            <li class=\"active\">Approval Ijin Pulang Sebelum Waktu</li>";
			
		$this->load->view('header',$data);
		$this->load->view('leftsidebar');
		$this->load->view('transaksi_approval_ijinpsw/list_approval_ijinpsw',$data);
		$this->load->view('footer');
		$this->load->view('rightsidebar');
		
	}
	
	function modal_proses_approval()
	{
		
		$data['username'] = $this->session->userdata('username');
		$data['nama_lengkap'] = $this->session->userdata('nama_lengkap');
		$data['email'] = $this->session->userdata('email');
		$data['address'] = $this->session->userdata('address');
		$data['phone'] = $this->session->userdata('phone');
		$data['level'] = $this->session->userdata('level');
		
		$this->load->view('transaksi_approval_ketidakhadiran/proses_approval',$data);
		
	}
	
	function proses_approval_ijinpsw()
	{
		
		$level_user = $this->session->userdata('level');			
		$data['level'] = $this->session->userdata('level');
			
		$idabsen = $this->uri->segment(3);
		$data['list'] = $this->m_trappijinpsw->getBiodataMskaryawanByIdAbsen($idabsen, $level_user);
		$data['tabsen'] = $this->m_trappijinpsw->getTabsenByIdAbsen($idabsen);
		$data['path_attachment_psw'] = $this->config->item('path_attachment_psw');
		
		$this->load->view('transaksi_approval_ijinpsw/pimpinan_approval_ijinpsw.php',$data);
		
	}
	
	function petugas_approval_ijinpsw()
	{
		
		$level_user = $this->session->userdata('level');			
		$data['level'] = $this->session->userdata('level');
			
		$idabsen = $this->uri->segment(3);
		$data['list'] = $this->m_trappijinpsw->getBiodataMskaryawanByIdAbsen($idabsen, $level_user);
		$data['tabsen'] = $this->m_trappijinpsw->getTabsenByIdAbsen($idabsen);
		$this->load->view('transaksi_approval_ijinpsw/petugas_approval_ijinpsw',$data);
					
	}
	
	function approval_ketidakhadiran_by_operator()
	{
		
			$idabsen = $this->uri->segment(3);
			$data['list'] = $this->m_mspegawai->getBiodataMskaryawanByIdAbsen($idabsen, $data['level']);
			$data['idabsen'] = $idabsen;
			
			$this->load->view('transaksi_approval_ketidakhadiran/proses_approval_ketidakhadiran',$data);
		
	}
	
	public function ajax_proses_approval()
	{
		
		// validasi formnya, takutnya user lupa checked radio button
		$this->validasi_proses_approval();
		
		$data = array(
			'idabsen' => $this->input->post('idabsen'),
			'is_approve' => $this->input->post('cbois_approve')
		);
			
		$this->m_trappijinpsw->proses_approval_ijinpsw($data);
		echo json_encode(array("status" => TRUE));
		
	}	
	
	public function ajax_proses_approval_bypetugas()
	{
		
		// validasi formnya, takutnya user lupa checked radio button
		$this->validasi_proses_approval();
		
		$data = array(
			'idabsen' => $this->input->post('idabsen'),
			'is_approve' => $this->input->post('cbois_approve'),
			'kdoperator' => $this->session->userdata('kdkaryawan')
		);
			
		$this->m_trappijinpsw->proses_approval_ijinpsw_bypetugas($data);
		echo json_encode(array("status" => TRUE));
		
	}	
	
	private function validasi_proses_approval()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('cbois_approve') == '')
        {
            $data['inputerror'][] = 'cbois_approve';
            $data['error_string'][] = 'Setuju/Tidak Setuju harus dipilih!!';
            $data['status'] = FALSE;
        }
 
        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
		
    }
	
	function history_absen()
	{
		
		$Tahun = $this->uri->segment(3);
		$sKdKaryawan = $this->uri->segment(4);
		$sNip = $this->uri->segment(5);		
		$sNama = $this->uri->segment(6);
		$sDepartemen = $this->uri->segment(7);
		$sNamaJabatan = $this->uri->segment(8);
		
		/*
		$data = array(
		'tahun' => $Tahun,
		'kdkaryawan' => $sKdKaryawan,
		'nip' => $sNip,
		'sNama' => $sNama,
		'departemen' => $sDepartemen
		);
		*/
		
		$data['tahun'] = $Tahun;
		$data['kdkaryawan'] = $sKdKaryawan;
		
		//$query = $this->db->query(
		//"EXEC SP_GenerateLaporanKedisiplinanAlpa '".$Tahun."','".$sKdKaryawan."','".$sNip."','".$sNama."','".$sDepartemen."','".$sNamaJabatan."'");
		
		$this->load->view('transaksi_approval_ketidakhadiran/history_absen_pegawai', $data);
		
	}
	
}

/* End of file msuser.php */
/* Location: ./application/controllers/msuser.php */