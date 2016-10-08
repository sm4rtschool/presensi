<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transaksi_approval_ketidakhadiran extends CI_Controller{
	
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
		$this->load->model('m_trappketidakhadiran');
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
			$this->list_approval_ketidakhadiran();
		}
	}
	
	function datatables_pimpinan()
	{
		
		/* Indexed column (used for fast and accurate table cardinality) */
		$sIndexColumn = "idabsen";
       
		/* DB table to use */
		$sTable = "tabsen_request";
     
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
		
		$aColumns = array('nip', 'Nama', 'CONVERT(VARCHAR, Tanggal , 120)', 'KdAbsen', 'Keterangan', 'Departemen');
		//$aColumns = array('no_baris', 'idabsen', 'is_pimpinan_approve', 'nip', 'Nama', 'Tanggal', 'KdAbsen', 'Keterangan', 'Departemen');
 
 
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
		
		$rResult = $this->m_trappketidakhadiran->getlist_ketidakhadiran($aColumns, $sWhere, $sOrder, $top, $limit, $parameter_login);
       
		$iTotal = 0;
        $rResultTotal = $this->m_trappketidakhadiran->getlist_ketidakhadiran_total($sIndexColumn, $parameter_login);
        $iTotal = $rResultTotal->num_rows();
	   
		$iFilteredTotal = 0;
		$rResultTotalFiltered = $this->m_trappketidakhadiran->getlist_ketidakhadiran_filteredtotal($sIndexColumn, $parameter_login, $aColumns, $sWhere, $sOrder, $top, $limit);
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
			//$row[] = $numbering + $page; 
			
				$is_pimpinan_approve = $aRow->is_pimpinan_approve;
				
				$row[] = $aRow->no_baris; 
				$row[] = $aRow->Departemen;
				$row[] = $aRow->nip;
				$row[] = $aRow->Nama;
			
				//row[] = $aRow->Tanggal;
				$row[] = date('d-m-Y', strtotime($aRow->Tanggal));
				$sTahun = date('Y', strtotime($aRow->Tanggal)); 
			
				$row[] = $aRow->KdAbsen;
				$row[] = $aRow->Keterangan;
			
				//	atur kolom status
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
			
				//	atur kolom aksi
			
				if ($is_pimpinan_approve == 0)
				{
				
					//add html for action
					//$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void()" title="Proses" onclick="proses_approval_ketidakhadiran('."'".$aRow->idabsen."'".','."'".$parameter_login['level']."'".')"><i class="glyphicon glyphicon-check"></i> Proses</a>
					//<a class="btn btn-sm btn-primary" href="javascript:void()" title="Detail" onclick="#"><i class="glyphicon glyphicon-check"></i> Detail</a>';
					
					$row[] = '<i class="ui-tooltip fa fa-check-square-o" title="Proses" style="font-size: 22px;color:#aa2222; cursor:pointer;" data-original-title="Proses" onclick="proses_approval_ketidakhadiran('."'".$aRow->idabsen."'".','."'".$parameter_login['level']."'".')"></i>&nbsp;
					<i class="ui-tooltip fa fa-book" title="Detail" style="font-size: 22px;color:#2222aa;cursor:pointer;" data-original-title="Detail" onclick="history_absen('."'".$sTahun."'".','."'".$aRow->KdKaryawan."'".','."'".$aRow->nip."'".','."'".$aRow->Nama."'".','."'".$aRow->Departemen."'".','."'".'-'."'".')"></i>';
				}
				else if ($is_pimpinan_approve == 1)
				{
				
					//add html for action
					//$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void()" title="Detail" onclick="#"><i class="glyphicon glyphicon-check"></i> Detail</a>';
					$row[] = '<i class="ui-tooltip fa fa-book" title="Detail" style="font-size: 22px;color:#2222aa;cursor:pointer;" data-original-title="Detail" onclick="history_absen('."'".$sTahun."'".','."'".$aRow->KdKaryawan."'".','."'".$aRow->nip."'".','."'".$aRow->Nama."'".','."'".$aRow->Departemen."'".','."'".'-'."'".')"></i>';
				
				}
				else
				{
				
					//add html for action																														function history_absen(Tahun, sKdKaryawan, sNip, sNama, sDepartemen, sNamaJabatan)
					//$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void()" title="Proses" onclick="proses_approval_ketidakhadiran('."'".$aRow->idabsen."'".','."'".$parameter_login['level']."'".')"><i class="glyphicon glyphicon-check"></i> Proses</a>
					//<a class="btn btn-sm btn-primary" href="javascript:void()" title="Detail" onclick="#"><i class="glyphicon glyphicon-check"></i> Detail</a>';
					$row[] = '<i class="ui-tooltip fa fa-check-square-o" title="Proses" style="font-size: 22px;color:#aa2222; cursor:pointer;" data-original-title="Proses" onclick="proses_approval_ketidakhadiran('."'".$aRow->idabsen."'".','."'".$parameter_login['level']."'".')"></i>&nbsp;
					<i class="ui-tooltip fa fa-book" title="Detail" style="font-size: 22px;color:#2222aa;cursor:pointer;" data-original-title="Detail" onclick="history_absen('."'".$sTahun."'".','."'".$aRow->KdKaryawan."'".','."'".$aRow->nip."'".','."'".$aRow->Nama."'".','."'".$aRow->Departemen."'".','."'".'-'."'".')"></i>';
				
				}
						
			$page++;
			$output['aaData'][] = $row;
		
		}	//	foreach ($rResult->result() as $aRow) 
    
		echo json_encode($output);
				
	}
	
	function datatables_operator()
	{
		
		/* Indexed column (used for fast and accurate table cardinality) */
		$sIndexColumn = "idabsen";
       
		/* DB table to use */
		$sTable = "";
     
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
		$aColumns = array('idabsen', 'Nama', 'Tanggal', 'KdAbsen', 'Keterangan');
 
 
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
		
		//echo $parameter_login['kdkaryawan'] . ' | ' . $parameter_login['level'];
       
		
		$rResult = $this->m_trappketidakhadiran->getlist_ketidakhadiran($aColumns, $sWhere, $sOrder, $top, $limit, $parameter_login);
       
		$iFilteredTotal = 0;
        
        $rResultTotal = $this->m_trappketidakhadiran->getlist_ketidakhadiran_total($sIndexColumn, $parameter_login);
        $iTotal = $rResultTotal->num_rows();
        $iFilteredTotal = $iTotal;
		
        if(isset($_GET['sEcho']))
		{
			$output = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iFilteredTotal,
            "aaData" => array()
			);	
		}
       
		
		/*
        foreach ($rResult->result_array() as $aRow)
		{
            $row = array();
            for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
                /* General output */
				
				/*
                if($i < 1)
                    $row[] = $numbering + $page; //. '|' . $aRow[ $aColumns[$i] ];
                else
                    $row[] = $aRow[ $aColumns[$i] ];
            }
            $page++;
            $output['aaData'][] = $row;
        }
		*/

		//date_default_timezone_set('Asia/Jakarta');
		
		$numbering = 0;
		$page = 1;
		foreach ($rResult->result() as $aRow) 
		{
			
			$row = array();			
			//$row[] = $numbering + $page; 
			
				$is_operator_approve = $aRow->is_operator_approve;
				$is_pimpinan_approve = $aRow->is_pimpinan_approve;
				
				$row[] = $aRow->no_baris; 
				$row[] = $aRow->Departemen;
				$row[] = $aRow->nip;
				$row[] = $aRow->Nama;
			
				//row[] = $aRow->Tanggal;
				$row[] = date('d-M-Y', strtotime($aRow->Tanggal));
				$sTahun = date('Y', strtotime($aRow->Tanggal));
			
				$row[] = $aRow->KdAbsen;
				$row[] = $aRow->Keterangan;
				//$row[] = $aRow->nama_pimpinan;
				
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
			
				if ($is_operator_approve == 0)
				{
				
					//add html for action
					//$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void()" title="Proses" onclick="petugas_approval_ketidakhadiran('."'".$aRow->idabsen."'".','."'".$parameter_login['level']."'".')"><i class="glyphicon glyphicon-check"></i> Proses</a>
					//<a class="btn btn-sm btn-primary" href="javascript:void()" title="Detail" onclick="#"><i class="glyphicon glyphicon-check"></i> Detail</a>';
					$row[] = '<i class="ui-tooltip fa fa-check-square-o" title="Proses" style="font-size: 22px;color:#aa2222; cursor:pointer;" data-original-title="Proses" onclick="petugas_approval_ketidakhadiran('."'".$aRow->idabsen."'".','."'".$parameter_login['level']."'".', '."'".$aRow->is_pimpinan_approve."'".')"></i>&nbsp;
					<i class="ui-tooltip fa fa-book" title="Detail" style="font-size: 22px;color:#2222aa;cursor:pointer;" data-original-title="Detail" onclick="history_absen('."'".$sTahun."'".','."'".$aRow->KdKaryawan."'".','."'".$aRow->nip."'".','."'".$aRow->Nama."'".','."'".$aRow->Departemen."'".','."'".'-'."'".')"></i>';
				
				
				}
				else if ($is_operator_approve == 1)
				{
				
					//add html for action
					//$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void()" title="Detail" onclick="#"><i class="glyphicon glyphicon-check"></i> Detail</a>';
					$row[] = '<i class="ui-tooltip fa fa-book" title="Detail" style="font-size: 22px;color:#2222aa;cursor:pointer;" data-original-title="Detail" onclick="history_absen('."'".$sTahun."'".','."'".$aRow->KdKaryawan."'".','."'".$aRow->nip."'".','."'".$aRow->Nama."'".','."'".$aRow->Departemen."'".','."'".'-'."'".')"></i>';
				
				}
				else
				{
				
					//add html for action
					//$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void()" title="Proses" onclick="petugas_approval_ketidakhadiran('."'".$aRow->idabsen."'".','."'".$parameter_login['level']."'".', '."'".$aRow->is_pimpinan_approve."'".')"><i class="glyphicon glyphicon-check"></i> Proses</a>
					//<a class="btn btn-sm btn-primary" href="javascript:void()" title="Detail" onclick="#"><i class="glyphicon glyphicon-check"></i> Detail</a>';
					$row[] = '<i class="ui-tooltip fa fa-check-square-o" title="Proses" style="font-size: 22px;color:#aa2222; cursor:pointer;" data-original-title="Proses" onclick="petugas_approval_ketidakhadiran('."'".$aRow->idabsen."'".','."'".$parameter_login['level']."'".', '."'".$aRow->is_pimpinan_approve."'".')"></i>&nbsp;
					<i class="ui-tooltip fa fa-book" title="Detail" style="font-size: 22px;color:#2222aa;cursor:pointer;" data-original-title="Detail" onclick="history_absen('."'".$sTahun."'".','."'".$aRow->KdKaryawan."'".','."'".$aRow->nip."'".','."'".$aRow->Nama."'".','."'".$aRow->Departemen."'".','."'".'-'."'".')"></i>';
								
				}
					
						
			$page++;
			$output['aaData'][] = $row;
		
		}	//	foreach ($rResult->result() as $aRow) 
    
		echo json_encode($output);
				
	}
	
	/*======================================= list_approval_ketidakhadiran ===================================*/
    function data_list_approval_ketidakhadiran(){
		
        $aColumns = array('idabsen', 'Nama', 'Tanggal', 'KdAbsen', 'Keterangan');
        
        $sIndexColumn = "idabsen";
        
        // paging
        $sLimit = "";
        if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' ){
            $sLimit = "LIMIT ".mysql_real_escape_string( $_GET['iDisplayStart'] ).", ".
                mysql_real_escape_string( $_GET['iDisplayLength'] );
        }
		if ( isset( $_GET['iDisplayStart'] )){
        $numbering = mysql_real_escape_string( $_GET['iDisplayStart'] );
		}
        $page = 1;
		
        $sOrder = "";
        // ordering
        if ( isset( $_GET['iSortCol_0'] ) ){
            $sOrder = "ORDER BY  ";
            for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ ){
                if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" ){
                    $sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
                        ".mysql_real_escape_string( $_GET['sSortDir_'.$i] ) .", ";
                }
            }
            
            $sOrder = substr_replace( $sOrder, "", -2 );
            if ( $sOrder == "ORDER BY" ){
                $sOrder = "";
            }
        }

        // filtering
        $sWhere = "";
		if(isset($_GET['sSearch'])){
			if ( $_GET['sSearch'] != ""){
            $sWhere = "WHERE (";
            for ( $i=0 ; $i<count($aColumns) ; $i++ ){
                $sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
            }
            $sWhere = substr_replace( $sWhere, "", -3 );
            $sWhere .= ')';
			}
		}
        
        // individual column filtering
        for ( $i=0 ; $i<count($aColumns) ; $i++ ){
			
			if(isset($_GET['bSearchable_'.$i])){
				
				if ( $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' ){
					
					if ( $sWhere == "" ){
						$sWhere = "WHERE ";
					}
					else
					{
						$sWhere .= " AND ";
					}
					$sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
				}
			}
        }
        
        $rResult = $this->m_trappketidakhadiran->getlist_ketidakhadiran($aColumns, $sWhere, $sOrder, $sLimit);
        
        $iFilteredTotal = 10;
        
        $rResultTotal = $this->m_trappketidakhadiran->getlist_ketidakhadiran_total($sIndexColumn);
        $iTotal = $rResultTotal->num_rows();
        $iFilteredTotal = $iTotal;
		
        if(isset($_GET['sEcho'])){
        $output = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iFilteredTotal,
            "aaData" => array()
        );
		}
		
        $numbering = 0;
        foreach ($rResult->result_array() as $aRow)
		{
			
            $row = array();
			
            for ($i=0; $i < count($aColumns); $i++ ){
                
				/* General output */
                if($i < 1)
                    $row[] = $numbering+$page.'|'.$aRow[ $aColumns[$i] ];
                else
                    $row[] = $aRow[ $aColumns[$i] ];
            }
            $page++;
            $output['aaData'][] = $row;
        }
        
        echo json_encode($output);
		
    }
    /*======================================= end of list_approval_ketidakhadiran ===================================*/

	function list_approval_ketidakhadiran()
	{
		
		$data['username'] = $this->session->userdata('username');
		$data['nama_lengkap'] = $this->session->userdata('nama_lengkap');
		$data['email'] = $this->session->userdata('email');
		$data['address'] = $this->session->userdata('address');
		$data['phone'] = $this->session->userdata('phone');
		$data['level'] = $this->session->userdata('level');
		
		$data['title']="<i class=\"fa fa-user fa-fw\"></i> Transaksi Approval Ketidakhadiran";
		$data['subtitle']=" Transaksi Approval Ketidakhadiran / Pegawai";
		$data['tabletitle']="Table Transaksi Approval Ketidakhadiran";
		$data['navigasi']="<li><a href=\"#\"><i class=\"fa fa-dashboard\"></i> Home</a></li>
            <li><a href=\"#\">Transaksi</a></li>
            <li class=\"active\">Approval Ketidakhadiran</li>";
			
		$this->load->view('header',$data);
		$this->load->view('leftsidebar');
		$this->load->view('transaksi_approval_ketidakhadiran/list_approval_ketidakhadiran',$data);
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
	
	function proses_approval_ketidakhadiran()
	{
		
		$level_user = $this->session->userdata('level');			
		$data['level'] = $this->session->userdata('level');
			
		$idabsen = $this->uri->segment(3);
		$data['list'] = $this->m_mspegawai->getBiodataMskaryawanByIdAbsen($idabsen, $level_user);
		//$data['idabsen'] = $idabsen;
		$data['tabsen_request'] = $this->m_trappketidakhadiran->getTabsenRequestByIdAbsen($idabsen);
		
		$this->load->view('transaksi_approval_ketidakhadiran/proses_approval_ketidakhadiran',$data);
		
	}
	
	function petugas_approval_ketidakhadiran()
	{
		
		$level_user = $this->session->userdata('level');			
		$data['level'] = $this->session->userdata('level');
			
		$idabsen = $this->uri->segment(3);
		$data['list'] = $this->m_mspegawai->getBiodataMskaryawanByIdAbsen($idabsen, $level_user);
		//$data['idabsen'] = $idabsen;
		$data['tabsen_request'] = $this->m_trappketidakhadiran->getTabsenRequestByIdAbsen($idabsen);

		$this->load->view('transaksi_approval_ketidakhadiran/petugas_approval_ketidakhadiran',$data);
					
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
			
		$this->m_trappketidakhadiran->proses_approval_ketidakhadiran($data);
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
			
		$this->m_trappketidakhadiran->proses_approval_ketidakhadiran_bypetugas($data);
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