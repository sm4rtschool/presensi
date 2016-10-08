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
				$row[] = $aRow->nip;
				$row[] = $aRow->Nama;
			
				$row[] = date('d-m-Y', strtotime($aRow->Tanggal));
				$row[] = date('h:i:s', strtotime($aRow->WorkOn));
				$row[] = date('h:i:s', strtotime($aRow->WorkOff));
				$row[] = date('h:i:s', strtotime($aRow->DutyOn));
				$row[] = date('h:i:s', strtotime($aRow->DutyOff));
				$row[] = $aRow->HomeEarly;
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
	
	function add_ijinpsw()
	{
		
		$data['username'] = $this->session->userdata('username');
		$data['nama_lengkap'] = $this->session->userdata('nama_lengkap');
		$data['email'] = $this->session->userdata('email');
		$data['address'] = $this->session->userdata('address');
		$data['phone'] = $this->session->userdata('phone');
		
		$this->load->library('form_validation');
		
		$data['title']="<i class=\"fa fa-user fa-fw\"></i> Transaksi Ijin Pulang Sebelum Waktu";
		$data['subtitle']=" Transaksi / Ijin Pulang Sebelum Waktu";
		$data['tabletitle']="Table Transaksi Ijin Pulang Sebelum Waktu";
		$data['navigasi']="<li><a href=\"#\"><i class=\"fa fa-dashboard\"></i> Home</a></li>
            <li><a href=\"#\">Transaksi</a></li>
            <li class=\"active\">Ijin Pulang Sebelum Waktu</li>";
		
		if(!is_logged_in())
		{
			redirect('login');
		}
		else
		{
		
			$this->load->view('header',$data);
			$this->load->view('leftsidebar');
			$this->load->view('transaksi_ijinpsw/add_ijinpsw',$data);
			$this->load->view('footer');
			$this->load->view('rightsidebar');
		}
		
	}
	
	/* edit data */
	function edit_user()
	{
		
		$data['username'] = $this->session->userdata('username');
		$data['nama_lengkap'] = $this->session->userdata('nama_lengkap');
		$data['email'] = $this->session->userdata('email');
		$data['address'] = $this->session->userdata('address');
		$data['phone'] = $this->session->userdata('phone');
		
		$this->load->library('form_validation');
		$data['title']="<i class=\"fa fa-user fa-fw\"></i> Master Data User";
		$data['subtitle']=" User / Karyawan";
		$data['tabletitle']="Table Master Data User";
		$data['navigasi']="<li><a href=\"#\"><i class=\"fa fa-dashboard\"></i> Home</a></li>
            <li><a href=\"#\">Data Master</a></li>
            <li class=\"active\">Edit User</li>";
		
		$id = $this->uri->segment(3);
	
		if(!is_logged_in())
		{
			redirect('login');
		}
		else
		{
		
			
			if($this->msuser->getUserById($id)->num_rows()>0)
			{
				
				$data['data'] =  $this->msuser->getUserById($id);
				
				$this->load->view('header',$data);
				$this->load->view('leftsidebar');
				$this->load->view('msuser/edit_user',$data);
				$this->load->view('footer');
				$this->load->view('rightsidebar');
			
			}
			else
			{
				$this->session->set_flashdata('notif', '<div class="alert-box warning"><span>Perhatian: </span> Data Yang Anda Cari Tidak Ada.</div>');
				redirect('msuser');
			}
			
			
		}
	}
	/* end edit data */
	
	private function list_user()
	{
		
		$data['username'] = $this->session->userdata('username');
		$data['nama_lengkap'] = $this->session->userdata('nama_lengkap');
		$data['email'] = $this->session->userdata('email');
		$data['address'] = $this->session->userdata('address');
		$data['phone'] = $this->session->userdata('phone');
		
		$data['title']="<i class=\"fa fa-user fa-fw\"></i> Master Data User";
		$data['subtitle']=" User / Karyawan";
		$data['tabletitle']="Table Master Data User";
		$data['navigasi']="<li><a href=\"#\"><i class=\"fa fa-dashboard\"></i> Home</a></li>
            <li><a href=\"#\">Data Master</a></li>
            <li class=\"active\">User</li>";
		$this->load->view('header',$data);
		$this->load->view('leftsidebar');
		$this->load->view('msuser/list_user',$data);
		$this->load->view('footer');
		$this->load->view('rightsidebar');
		
	}
	
	function load_grid(){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
 		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 1000;
		$data = isset($_POST['data']) ? mysql_real_escape_string($_POST['data']) : '';  
 		$offset = ($page-1)*$rows;
		$this->msuser->limit = $rows;
 		$this->msuser->offset = $offset;
		$this->msuser->load_grid($data);
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
	
	/* save edit data */
	
	function save_edit()
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
			$this->form_validation->set_error_delimiters('<h4><i class="fa fa-info"></i>  Perhatian :</h4><div class="callout callout-info" style="margin-bottom: 0!important;"><div class="alert-box warning">', '</span></div></div>');
						
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
				$this->load->view('msuser/edit_user',$data);
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
				
				$this->msuser->update($id_user,$username,$password,$email,$no_hp,$nama_lengkap,$alamat);
				$this->session->set_flashdata('notif', '<div class="alert-box success"><span>Sukses: </span> Data User Berhasil Disimpan.</div>');
				redirect('msuser');
				
			}
					
								
		}
	}
	
	/* end save edit data */
	
	/* delete data*/
	
	function delete($id='')
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
				
				$this->msuser->delete($id);
				$this->session->set_flashdata('notif', '<div class="alert-box success"><span>Sukses: </span> Data user Dengan ID '.$id.' Berhasil Dihapus.</div>');
				redirect('msuser');	
				
			}
		}
	}
	
	/* end delete data */
	
	function load_user_detail()
	{
		$id = $this->uri->segment(3);
		$data['list'] = $this->msuser->getUserById($id);
		$this->load->view('msuser/list_user_detail',$data);
	}
	
	function edit_password()
	{
		
		$data['username'] = $this->session->userdata('username');
		$data['nama_lengkap'] = $this->session->userdata('nama_lengkap');
		$data['email'] = $this->session->userdata('email');
		$data['address'] = $this->session->userdata('address');
		$data['phone'] = $this->session->userdata('phone');
		
		$this->load->library('form_validation');
		
		$data['title']="<i class=\"fa fa-user fa-fw\"></i> Rubah Password";
		$data['subtitle']=" Rubah Password / User";
		$data['tabletitle']="Rubah Password";
		$data['navigasi']="<li><a href=\"#\"><i class=\"fa fa-dashboard\"></i> Home</a></li>
            <li><a href=\"#\">Data Master</a></li>
            <li class=\"active\">Rubah Password</li>";
		
		if(!is_logged_in())
		{
			redirect('login');
		}
		else
		{
		
			$this->load->view('header',$data);
			$this->load->view('leftsidebar');
			$this->load->view('msuser/edit_password');
			$this->load->view('footer');
			$this->load->view('rightsidebar');
			
		}
	
	}
	
	function save_edit_password()
	{
		
		$data['username'] = $this->session->userdata('username');
		$data['nama_lengkap'] = $this->session->userdata('nama_lengkap');
		$data['email'] = $this->session->userdata('email');
		$data['address'] = $this->session->userdata('address');
		$data['phone'] = $this->session->userdata('phone');
	
		$this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>', '</div>');
        
		$this->form_validation->set_rules('old_password', 'Password Lama', 'required');
        $this->form_validation->set_rules('new_password', 'Password Baru', 'required');
        $this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'required');
		
		$data['title']="<i class=\"fa fa-user fa-fw\"></i> Rubah Password";
		$data['subtitle']=" Rubah Password / User";
		$data['tabletitle']="Rubah Password";
		$data['navigasi']="<li><a href=\"#\"><i class=\"fa fa-dashboard\"></i> Home</a></li>
        <li><a href=\"#\">Data Master</a></li>
        <li class=\"active\">Rubah Password</li>";
		
		if ($this->form_validation->run() == FALSE) 
		{
			
			$this->load->view('header',$data);
			$this->load->view('leftsidebar');
			$this->load->view('msuser/edit_password');
			$this->load->view('footer');
			$this->load->view('rightsidebar');
			
        } 
		else 
		{  
		
			$id_user =  $this->session->userdata('user_id');
			
			//var post
			//$spassword = hash('sha512',$password);
			$spasswordlama = hash('sha512',$this->input->post('old_password'));
			$spasswordbaru = hash('sha512',$this->input->post('new_password'));
			$spasswordkonfirmasi = hash('sha512',$this->input->post('confirm_password'));
			
			//$this->db->query('UPDATE user SET password = "'.$password.'" WHERE userid = "'.$id_user.'"');
			//$cek_password_lama	= $this->db->query("SELECT password FROM user WHERE userid = $id_user");
			
			if ($spasswordbaru != $spasswordkonfirmasi) 
			{
				//$this->session->set_flashdata('notif', '<div id="alert" class="alert alert-error">Password Baru 1 dan 2 tidak cocok</div>');
				$this->session->set_flashdata('notif', '<div class="box-body"><div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-info"></i> Info!</h4>
                    Password baru dan konfirmasi tidak sama
                  </div></div>');
				redirect('msuser/edit_password');
			}
			
			$query = $this->db->query("SELECT * FROM user WHERE userid = '$id_user' AND password='$spasswordlama'");
			
			
			if ($query->num_rows() > 0)
			{
				
				
				$this->msuser->updatePassword($id_user, $spasswordkonfirmasi);
				//$this->session->set_flashdata('notif', '<div class="alert-box success"><span>Sukses: </span> Password berhasil diperbaharui</div>');
				$this->session->set_flashdata('notif', '<div class="box-body"><div class="alert alert-info alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-info"></i> Info!</h4>
                    Password berhasil diperbaharui
                  </div></div>');
				redirect('msuser/edit_password');
				
				
				/*
				echo $id_user;
				echo '</br>';
				echo $spasswordlama; 
				*/
				
				
			}
			else
			{
				$this->session->set_flashdata('notif', '<div id="alert" class="alert alert-error">Password lama yang Anda masukkan salah</div>');
				redirect('msuser/edit_password');
			} 		
			
		}
		
	}
	
	
	//untuk return value validasi apakah password lama sesuai dengan yg diinputkan
	public function password_check($str)
	{
			
		$id_user =  $this->session->userdata('user_id');
		$password = md5($str);
		
		$query = $this->db->query("SELECT * FROM user WHERE userid = '$id_user' AND password='$password'");
			
			if ($query->num_rows() > 0)
			{
				return TRUE;
		
			}
			else
			{
				//echo 'id usernya = ' . $id_user . 'passwordnya = ' . $password;
				$this->form_validation->set_message('password_check', 'Password yang Anda Masukan Salah.');
				return FALSE;
			}
		
	}
	
		//untuk reset password user
	public function reset_password($id)
	{
	$tingkat = $this->checkRole($id);

	if($tingkat==1){
	
		echo warning('Satu guru satu ilmu jangan saling ganggu :) ','user');
	
	}else{
		
		$username = $this->uri->segment(4);
		$this->user->updatePassword($id,$username);
		$this->session->set_flashdata('notif', '<p class = "error">Password Username '.$username.' Berhasil Direset</p>');
		redirect('user/');

	}
	
	}
	
}

/* End of file msuser.php */
/* Location: ./application/controllers/msuser.php */