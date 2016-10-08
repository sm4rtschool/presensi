<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Monitoring_absensi_harian extends CI_Controller {
	
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
		$this->load->model('m_monitoring_absensi_harian');
		$this->load->model('m_mspegawai');
    }
	
	public function index()
	{
		if(!is_logged_in())
		{
			redirect('login');
		}
		else
		{	
			$this->monitoring_absensi_harian();
		}
	}
	
	function monitoring_absensi_harian()
	{
		
		$data['username'] = $this->session->userdata('username');
		$data['nama_lengkap'] = $this->session->userdata('nama_lengkap');
		$data['email'] = $this->session->userdata('email');
		$data['address'] = $this->session->userdata('address');
		$data['phone'] = $this->session->userdata('phone');
		$data['level'] = $this->session->userdata('level');
		$data['user_id'] = $this->session->userdata('user_id');
		
		//sp_GetServerDate = $this->db->query("SELECT GETDATE() AS ambil_waktu_server");
		//$Thn = date('Y', strtotime($sp_GetServerDate->row()->ambil_waktu_server));
		//echo $Thn;
		
		$sp_GetServerDate = $this->db->query("SELECT GETDATE() AS ambil_waktu_server");
		$tanggal_sekarang = date('Y-m-d', strtotime($sp_GetServerDate->row()->ambil_waktu_server));
		
		$data['getlist_kehadiran'] = $this->m_monitoring_absensi_harian->getlist_kehadiran($data['username'], $tanggal_sekarang, $data['user_id']);
		$data['getlist_ketidakhadiran'] = $this->m_monitoring_absensi_harian->getlist_ketidakhadiran($data['username'], $tanggal_sekarang, $data['user_id']);
		$data['getlist_alpa'] = $this->m_monitoring_absensi_harian->getlist_alpa($data['username'], $tanggal_sekarang, $data['user_id']);
		
		$data['title']="<i class=\"fa fa-user fa-fw\"></i> Monitoring Absensi Harian";
		$data['subtitle']=" Monitoring Absensi Harian / Pegawai";
		$data['tabletitle']="Table Monitoring Absensi Harian";
		$data['navigasi']="<li><a href=\"#\"><i class=\"fa fa-dashboard\"></i> Home</a></li>
            <li><a href=\"#\">Transaksi</a></li>
            <li class=\"active\">Monitoring Absensi Harian</li>";
			
		$this->load->view('header',$data);
		$this->load->view('leftsidebar');
		$this->load->view('monitoring_absensi_harian/monitoring_absensi_harian',$data);
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
       
		$rResult = $this->trijintlmodel->getlist_ijintl($aColumns, $sWhere, $sOrder, $top, $limit, $parameter_login);
       
		$iTotal = 0;
        $rResultTotal = $this->trijintlmodel->getlist_ijintl_total($sIndexColumn, $parameter_login);
        $iTotal = $rResultTotal;
		
		$iFilteredTotal = 0;
		$rResultTotalFiltered = $this->trijintlmodel->getlist_ijintl_filteredtotal($sIndexColumn, $parameter_login, $aColumns, $sWhere, $sOrder, $top, $limit);
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
				$row[] = $aRow->nip;
				$row[] = $aRow->Nama;
			
				$row[] = date('d-m-Y', strtotime($aRow->Tanggal));
				$row[] = date('h:i:s', strtotime($aRow->WorkOn));
				$row[] = date('h:i:s', strtotime($aRow->WorkOff));
				$row[] = date('h:i:s', strtotime($aRow->DutyOn));
				$row[] = date('h:i:s', strtotime($aRow->DutyOff));
				$row[] = $aRow->Late;
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
				
				$row[] = '<i class="ui-tooltip fa fa-check-square-o" title="Proses" style="font-size: 22px;color:#aa2222; cursor:pointer;" data-original-title="Proses" onclick="#"></i>&nbsp;
					<i class="ui-tooltip fa fa-book" title="Detail" style="font-size: 22px;color:#2222aa;cursor:pointer;" data-original-title="Detail" onclick="#"></i>';
															
			$page++;
			$output['aaData'][] = $row;
			//$output_data[] = $row;
		
		}	//	foreach ($rResult->result() as $aRow) 		
	
		echo json_encode($output);
				
	}
	
	function add_ijintl()
	{
		
		$data['username'] = $this->session->userdata('username');
		$data['nama_lengkap'] = $this->session->userdata('nama_lengkap');
		$data['email'] = $this->session->userdata('email');
		$data['address'] = $this->session->userdata('address');
		$data['phone'] = $this->session->userdata('phone');
		
		$this->load->library('form_validation');
		
		$data['title']="<i class=\"fa fa-user fa-fw\"></i> Transaksi Ijin Terlambat Datang";
		$data['subtitle']=" Transaksi / Ijin Terlambat Datang";
		$data['tabletitle']="Table Transaksi Ijin Terlambat Datang";
		$data['navigasi']="<li><a href=\"#\"><i class=\"fa fa-dashboard\"></i> Home</a></li>
            <li><a href=\"#\">Transaksi</a></li>
            <li class=\"active\">Ijin Terlambat Datang</li>";
		
		if(!is_logged_in())
		{
			redirect('login');
		}
		else
		{
		
			$this->load->view('header',$data);
			$this->load->view('leftsidebar');
			$this->load->view('transaksi_ijintl/add_ijintl',$data);
			$this->load->view('footer');
			$this->load->view('rightsidebar');
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

			$this->form_validation->set_rules('edusername', 'Username', 'required');
			$this->form_validation->set_rules('edpassword', 'Password', 'required');
			$this->form_validation->set_rules('edemail', 'Email', 'required');
			$this->form_validation->set_rules('ednohp', 'No.HP', 'required');
						
			if ($this->form_validation->run() == FALSE) 
			{
						
				$data['title']="<i class=\"fa fa-user fa-fw\"></i> Master Data User";
				$data['subtitle']=" User / Karyawan";
				$data['tabletitle']="Table Master Data User";
				$data['navigasi']="<li><a href=\"#\"><i class=\"fa fa-dashboard\"></i> Home</a></li>
				<li><a href=\"#\">Data Master</a></li>
				<li class=\"active\">User</li>";
			
				$this->load->view('header.php',$data);
				$this->load->view('leftsidebar');
				$this->load->view('msuser/add_user',$data);
				$this->load->view('footer.php');
				$this->load->view('rightsidebar');
			
			} 
			else 
			{  
		
				$username = $this->input->post('edusername');
				$password = $this->input->post('edpassword');
				$email = $this->input->post('edemail');
				$no_hp = $this->input->post('ednohp');
				$nama_lengkap = $this->input->post('ednamalengkap');
				$alamat = $this->input->post('memoalamat');			
				
				//$user_level = $this->input->post('user_level');
				//$id_user = $this->get_indeks_user();
				
				$this->msuser->save($username,$password,$email,$no_hp,$nama_lengkap,$alamat);
				//$this->session->set_flashdata('notif', '<div class="alert-box success"><span>Sukses: </span> Data User Berhasil Disimpan.</div>');
				$this->session->set_flashdata('notif', '<div class="box-body"><div class="alert alert-info alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-info"></i> Info!</h4>
                    Input data user berhasil.
                  </div></div>');
				//$alert = "Simpan data berhasil !!";
				//$this->session->set_flashdata('alert', $alert);
				redirect('msuser');
				
			}
					
								
		}
	}
	/* end save add data */
	
}

/* End of file msuser.php */
/* Location: ./application/controllers/msuser.php */