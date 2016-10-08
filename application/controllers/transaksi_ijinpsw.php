<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transaksi_ijinpsw extends CI_Controller {
	
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
		$this->load->model('trijinpswmodel');
		//$this->load->model('m_mspegawai');
    }
	
	public function index()
	{
		if(!is_logged_in())
		{
			redirect('login');
		}
		else
		{	
			$this->list_ijinpsw();
		}
	}
	
	function list_ijinpsw()
	{
		
		$data['username'] = $this->session->userdata('username');
		$data['nama_lengkap'] = $this->session->userdata('nama_lengkap');
		$data['email'] = $this->session->userdata('email');
		$data['address'] = $this->session->userdata('address');
		$data['phone'] = $this->session->userdata('phone');
		$data['level'] = $this->session->userdata('level');
		
		$data['title']="<i class=\"fa fa-user fa-fw\"></i> Transaksi Ijin Pulang Sebelum Waktu";
		$data['subtitle']=" Transaksi Ijin Pulang Sebelum Waktu / Pegawai";
		$data['tabletitle']="Table Transaksi Ijin Pulang Sebelum Waktu";
		$data['navigasi']="<li><a href=\"#\"><i class=\"fa fa-dashboard\"></i> Home</a></li>
            <li><a href=\"#\">Transaksi</a></li>
            <li class=\"active\">Ijin Pulang Sebelum Waktu</li>";
			
		$this->load->view('header',$data);
		$this->load->view('leftsidebar');
		$this->load->view('transaksi_ijinpsw/list_ijinpsw',$data);
		$this->load->view('footer');
		$this->load->view('rightsidebar');
		
	}
	
	function datatables_pegawai()
	{
		
		/* Indexed column (used for fast and accurate table cardinality) */
		$sIndexColumn = "idabsen";
       
		/* DB table to use */
		$sTable = "tabsen";
     
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
		
		$aColumns = array('CONVERT(VARCHAR, Tanggal , 120)');
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
       
		$rResult = $this->trijinpswmodel->getlist_ijinpsw($aColumns, $sWhere, $sOrder, $top, $limit, $parameter_login);
       
		$iTotal = 0;
        $rResultTotal = $this->trijinpswmodel->getlist_ijinpsw_total($sIndexColumn, $parameter_login);
        $iTotal = $rResultTotal;
		
		$iFilteredTotal = 0;
		$rResultTotalFiltered = $this->trijinpswmodel->getlist_ijinpsw_filteredtotal($sIndexColumn, $parameter_login, $aColumns, $sWhere, $sOrder, $top, $limit);
		$iFilteredTotal = $rResultTotalFiltered->num_rows();
		
			$sEcho = (isset($_REQUEST['sEcho'])) ? $_REQUEST['sEcho'] : 0;
				
			$output = array(
				"sEcho" => $sEcho,
				"iTotalRecords" => $iTotal,
				"iTotalDisplayRecords" => $iFilteredTotal,
				"aaData" => array()
			);			
		
		$numbering = 0;
		$page = 1;
		
		foreach ($rResult->result() as $aRow) 
		{
			
			$row = array();			
			//$row[] = $numbering + $page; 
				
				$row[] = $aRow->no_baris; 
				//$row[] = $numbering + $page; 
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
				$is_petugas_approve_psw = $aRow->is_petugas_approve_psw;
				
				//	atur kolom status pimpinan
				if ($is_pimpinan_approve_psw == 0)	
				{
				
					//$row[] = '<div class="bg-red-active color-palette" align = "center"><span>rejected</span></div>';
					$row[] = '<div align = "center"><img src="' . base_url() . 'asset/img/led_yellowanimated_16x16.gif" align = "center"></div>';
				
				}
				else if ($is_pimpinan_approve_psw == 1)	
				{
				
					$row[] = '<div align = "center"><img src="' . base_url() . 'asset/img/led_greenanimated_16x16.gif" align = "center"></div>';
				
				}
				else	
				{
				
					$row[] = '<div align = "center"><img src="' . base_url() . 'asset/img/SR_Blink.gif" align = "center"></div>';
					
				}		

				//	atur kolom status petugas
				if ($is_petugas_approve_psw == 0)	
				{
				
					$row[] = '<div align = "center"><img src="' . base_url() . 'asset/img/led_yellowanimated_16x16.gif" align = "center"></div>';
				
				}
				else if ($is_petugas_approve_psw == 1)	
				{
				
					$row[] = '<div align = "center"><img src="' . base_url() . 'asset/img/led_greenanimated_16x16.gif" align = "center"></div>';
				
				}
				else	
				{
				
					$row[] = '<div align = "center"><img src="' . base_url() . 'asset/img/SR_Blink.gif" align = "center"></div>';
				
				}
			
				//	atur kolom aksi
				
				//add html for action
				
				//'<i class="ui-tooltip fa fa-book" style="font-size: 22px;color:#2222aa;cursor:pointer;" data-original-title="Detail" onclick="detailpekerjaan('+row.id_pekerjaan+')" ></i><i class="ui-tooltip fa fa-pencil" style="font-size: 22px; color:#22aa22; cursor:pointer;" data-original-title="Edit" onclick="editpekerjaan('+row.id_pekerjaan+')"></i>&nbsp;<i class="ui-tooltip fa fa-trash-o" style="font-size: 22px;color:#aa2222; cursor:pointer;" data-original-title="Delete" onclick="deletepekerjaan('+row.id_pekerjaan+')" ></i>'
				
				if ($is_pimpinan_approve_psw == 0)	
				{
				
					$row[] = '<i class="ui-tooltip fa fa-check-square-o" title="Proses" style="font-size: 22px;color:#aa2222; cursor:pointer;" data-original-title="Proses" onclick="konfirmasi_psw('."'".$aRow->idabsen."'".')"></i>';
					//<i class="ui-tooltip fa fa-book" title="Detail" style="font-size: 22px;color:#2222aa;cursor:pointer;" data-original-title="Detail" onclick="detail_absen('."'".$aRow->idabsen."'".')"></i>';
					
				
				}
				else if ($is_pimpinan_approve_psw == 1)	
				{
				
					//$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void()" title="Detail" onclick="detail_absen('."'".$aRow->idabsen."'".')"><i class="glyphicon glyphicon-check"></i> Detail</a>';
					$row[] = '<i class="ui-tooltip fa fa-book" title="Detail" style="font-size: 22px;color:#2222aa;cursor:pointer;" data-original-title="Detail" onclick="detail_absen('."'".$aRow->idabsen."'".')"></i>';
								
				}
				else	
				{
				
					//$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void()" title="Detail" onclick="detail_absen('."'".$aRow->idabsen."'".')"><i class="glyphicon glyphicon-check"></i> Detail</a>
					//<a class="btn btn-sm btn-primary" href="javascript:void()" title="Hapus" onclick="hapus_absen('."'".$aRow->idabsen."'".')"><i class="glyphicon glyphicon-check"></i> Hapus</a>';

					$row[] = '<i class="ui-tooltip fa fa-book" title="Detail" style="font-size: 22px;color:#2222aa;cursor:pointer;" data-original-title="Detail" onclick="detail_absen('."'".$aRow->idabsen."'".')"></i>';
						
				}	
				
				
				
															
			$page++;
			$output['aaData'][] = $row;
			//$output_data[] = $row;
		
		}	//	foreach ($rResult->result() as $aRow) 		
	
		echo json_encode($output);
				
	}
	
	function add_ijinpsw()
	{
		
		$data['username'] = $this->session->userdata('username');
		$data['nama_lengkap'] = $this->session->userdata('nama_lengkap');
		$data['email'] = $this->session->userdata('email');
		$data['address'] = $this->session->userdata('address');
		$data['phone'] = $this->session->userdata('phone');
		
		$this->load->library('form_validation');
			
		$data['title']="<i class=\"fa fa-user fa-fw\"></i> Transaksi Ijin Pulang Sebelum Waktu";
		$data['subtitle']=" Transaksi Ijin Pulang Sebelum Waktu / Pegawai";
		$data['tabletitle']="Table Transaksi Ijin Pulang Sebelum Waktu";
		$data['navigasi']="<li><a href=\"#\"><i class=\"fa fa-dashboard\"></i> Home</a></li>
            <li><a href=\"#\">Transaksi</a></li>
            <li class=\"active\">Ijin Pulang Sebelum Waktu</li>";
			
		$idabsen = $this->uri->segment(3);
		
		if(!is_logged_in())
		{
			redirect('login');
		}
		else
		{
								
			if($this->trijinpswmodel->getTabsenRequestByIdAbsen($idabsen)->num_rows()>0)
			{
				
				$data['tabsen'] =  $this->trijinpswmodel->getTabsenRequestByIdAbsen($idabsen);
				$data['is_posting_data'] = 0;
				$data['mspimpinan'] = $this->trijinpswmodel->getPimpinan();
				
				$this->load->view('header',$data);
				$this->load->view('leftsidebar');
				$this->load->view('transaksi_ijinpsw/add_ijinpsw',$data);
				$this->load->view('footer');
				$this->load->view('rightsidebar');
			
			}
			else
			{
				$this->session->set_flashdata('notif', '<div class="alert-box warning"><span>Perhatian: </span> Data Yang Anda Cari Tidak Ada.</div>');
				redirect('transaksi_ijintl');
			}
			
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
			
			$data['username'] = $this->session->userdata('username');
			$data['nama_lengkap'] = $this->session->userdata('nama_lengkap');
			$data['email'] = $this->session->userdata('email');
			$data['address'] = $this->session->userdata('address');
			$data['phone'] = $this->session->userdata('phone');					
					
			$this->load->library('form_validation');
			
			//$this->form_validation->set_error_delimiters('<div class="alert-box warning"><span>Peringatan: </span>', '</span></div>');
			//$this->form_validation->set_error_delimiters('<div class="alert-box warning">', '</span></div>');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>', '</div>');
			
			//$this->form_validation->set_error_delimiters('<div class="notif-bot-cnt"></div>');

			$this->form_validation->set_rules('cboalasan', 'Alasan', 'required|callback_check_alasan');
			$this->form_validation->set_rules('cbopimpinan', 'Pimpinan', 'required|is_natural');
			
			$idabsen = $this->input->post('idabsen');
						
			if (empty($_FILES['userfile']['name']))
			{
				$this->form_validation->set_rules('userfile', 'Lampiran', 'required');
			}
						
			if ($this->form_validation->run() == FALSE) 
			{
								
				$data['title']="<i class=\"fa fa-user fa-fw\"></i> Transaksi Ijin Pulang Sebelum Waktu";
				$data['subtitle']=" Transaksi Ijin Pulang Sebelum Waktu / Pegawai";
				$data['tabletitle']="Table Transaksi Ijin Pulang Sebelum Waktu";
				$data['navigasi']="<li><a href=\"#\"><i class=\"fa fa-dashboard\"></i> Home</a></li>
				<li><a href=\"#\">Transaksi</a></li>
				<li class=\"active\">Ijin Pulang Sebelum Waktu</li>";
			
				$data['is_posting_data'] = 0;
				$data['tabsen'] =  $this->trijinpswmodel->getTabsenRequestByIdAbsen($idabsen);
			
				$this->load->view('header.php',$data);
				$this->load->view('leftsidebar');
				$this->load->view('transaksi_ijinpsw/add_ijinpsw',$data);
				$this->load->view('footer.php');
				$this->load->view('rightsidebar');
			
			} 
			else 
			{  
		
				$cboalasan = $this->input->post('cboalasan');
				$cbopimpinan = $this->input->post('cbopimpinan');
				$file_element_name = $_FILES['userfile']['name'];	
				$path_attachment_psw = $this->config->item('path_attachment_psw');
				
				$notif = $this->trijinpswmodel->save($path_attachment_psw, $file_element_name, $cbopimpinan, 0, 0, 0, $cboalasan, $idabsen);				
				
				$this->session->set_flashdata('notif', '<div class="box-body"><div class="alert alert-info alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-info"></i> Info!</h4>
                    Konfirmasi pulang sebelum waktu berhasil.
                  </div></div>');

				redirect('transaksi_ijinpsw');
				
			}
											
		}
	}
	/* end save add data */
	
	function load_dropdown_alasan()
	{
		
		$list = $this->trijinpswmodel->getAlasanPSW();
		$ddata = array();

		foreach ($list as $msalasan_psw) 
		{

			$row = array();

			$row['id_alasan'] = $msalasan_psw['id'];
			$row['alasan'] = $msalasan_psw['alasan'];
			$ddata[] = $row;
		
		}

		$output = array(
			"msalasan_psw" => $ddata,
        );
		//output to json format
		echo json_encode($output);
		
	}
	
	function load_dropdown_pimpinan()
	{
		
		$list_pimpinan = $this->trijintlmodel->getPimpinan();
		$data_pimpinan = array();

		foreach ($list_pimpinan as $mspimpinan) 
		{

			$row_pimpinan = array();

			$row_pimpinan['idkaryawan'] = $mspimpinan->kdkaryawan;
			$row_pimpinan['nama_karyawan'] = $mspimpinan->Nama;
			$data_pimpinan[] = $row_pimpinan;
		
		}

		$output_pimpinan = array(
			"pimpinan" => $data_pimpinan,
        );
		echo json_encode($output_pimpinan);
		
	}
	
	function detail_absen()
	{
		
		$level_user = $this->session->userdata('level');			
		$data['level'] = $this->session->userdata('level');
			
		$idabsen = $this->uri->segment(3);
		$data['list'] = $this->trijinpswmodel->getBiodataMskaryawanByIdAbsen($idabsen, $level_user);
		$data['tabsen'] = $this->trijinpswmodel->getTabsenByIdAbsen($idabsen);
		
		$this->load->view('transaksi_ijinpsw/detail_ijinpsw',$data);
		
	}
	
}

/* End of file transaksi_ijintl.php */
/* Location: ./application/controllers/transaksi_ijintl.php */