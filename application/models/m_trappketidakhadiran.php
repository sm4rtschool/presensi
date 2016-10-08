<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_trappketidakhadiran extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('m_database','m_database');
	}
	
	function getTabsenRequestByIdAbsen($idabsen)
	{
		
		//$ssql = "SELECT * FROM tabsen_request WHERE idabsen = '$idabsen'";
		
		$ssql = "SELECT a.*, b.Jenis FROM 
				(
					SELECT * FROM tabsen_request WHERE idabsen = '$idabsen'
				) a
				JOIN ex_jenisketidakhadiran b ON a.KdAbsen = b.KdJenisKetidakhadiran";
		
		$query = $this->db->query($ssql);
		return $query;	
		
	}
	
	/*==================================== ssp_tm_alkes ============================================*/
	
	/*
	SELECT KdKaryawan FROM 
	(
	SELECT row_number() OVER (ORDER BY idabsen) AS no_urut, KdKaryawan 
	FROM tabsen WHERE YEAR(Tanggal) = '2016' --ORDER BY idabsen ASC
	) A 
	WHERE no_urut BETWEEN 1 AND 10
	*/
	
	/*
	SELECT no_baris, idabsen, Nama, Tanggal, KdAbsen, Keterangan
	FROM (SELECT row_number() OVER (ORDER BY ".$sIndexColumn.") AS rownum, ".implode(",",$aColumns)." 
	FROM $sTable $sWhere $sOrder ) AS A WHERE A.rownum BETWEEN ".$top." AND ".($top+$limit);
	*/
	
    function getlist_ketidakhadiran($aColumns, $sWhere, $sOrder, $top, $limit, $parameter_login)
    {
		
		$kdkaryawan = $parameter_login['kdkaryawan'];
		$level = $parameter_login['level'];
		
		$top = $top + 1;
		$limit = $limit - 1;
		$begin = $top;
		$end = $top + $limit;
		
		If ($level == 'Pimpinan')
		{
		
			$ssql = "SELECT * FROM
				(
					SELECT ROW_NUMBER() OVER (ORDER by idabsen DESC) as no_baris, idabsen, is_pimpinan_approve, KdKaryawan, nip, Nama, Tanggal, KdAbsen, Keterangan, Departemen FROM
					(
						SELECT ROW_NUMBER() OVER (ORDER by idabsen) as no_baris, a.idabsen, a.is_pimpinan_approve, b.KdKaryawan, b.nip, b.Nama, a.Tanggal, a.KdAbsen, a.Keterangan, c.Departemen
						FROM tabsen_request a JOIN mskaryawan b ON a.KdKaryawan = b.KdKaryawan
						JOIN msdepartemen c ON b.KdDepartemen = c.RecordID						
						WHERE a.KdPimpinan = '$kdkaryawan'
					) x
					$sWhere
				) y			
				WHERE no_baris BETWEEN '$begin' AND '$end' ORDER BY no_baris ASC";
				
		}
		else if ($level == 'Operator')
		{
			
			$ssql = "SELECT * FROM
				(
					SELECT ROW_NUMBER() OVER (ORDER by idabsen DESC) as no_baris, idabsen, is_pimpinan_approve, is_operator_approve, KdKaryawan, nip, Nama, Tanggal, KdAbsen, Keterangan, Departemen FROM
					(
						SELECT ROW_NUMBER() OVER (ORDER by idabsen) as no_baris, a.idabsen, a.is_pimpinan_approve, a.is_operator_approve, b.KdKaryawan, b.nip, b.Nama, a.Tanggal, a.KdAbsen, a.Keterangan, c.Departemen
						FROM tabsen_request a JOIN mskaryawan b ON a.KdKaryawan = b.KdKaryawan
						JOIN msdepartemen c ON a.KdDepartemen = c.RecordID
						--WHERE a.is_pimpinan_approve = 1
					) x
					$sWhere
				) y			
				WHERE no_baris BETWEEN '$begin' AND '$end' ORDER BY no_baris ASC";
			
		}
		
		//echo $ssql;
        $query = $this->db->query($ssql);        
        return $query;
		
    }
	
	//$sWhere
	//$sOrder

	function getlist_ketidakhadiran_filteredtotal($sIndexColumn, $parameter_login, $aColumns, $sWhere, $sOrder, $top, $limit)
	{
		
		$kdkaryawan = $parameter_login['kdkaryawan'];
		$level = $parameter_login['level'];
		
		If ($level == 'Pimpinan')
		{
			
			$ssql = "SELECT $sIndexColumn FROM
					(
						SELECT no_baris, idabsen, is_pimpinan_approve, nip, Nama, Tanggal, KdAbsen, Keterangan, Departemen FROM
							(
								SELECT ROW_NUMBER() OVER (ORDER by idabsen) as no_baris, a.idabsen, a.is_pimpinan_approve, b.nip, b.Nama, a.Tanggal, a.KdAbsen, a.Keterangan, c.Departemen
								FROM tabsen_request a JOIN mskaryawan b ON a.KdKaryawan = b.KdKaryawan
								JOIN msdepartemen c ON a.KdDepartemen = c.RecordID								
								WHERE a.KdPimpinan = '$kdkaryawan'
							) x
							$sWhere
					) y";
			
		}
		else if ($level == 'Operator')
		{
			
			$ssql = "SELECT $sIndexColumn FROM
					(
						SELECT no_baris, idabsen, is_operator_approve, nip, Nama, Tanggal, KdAbsen, Keterangan, Departemen FROM
							(
								SELECT ROW_NUMBER() OVER (ORDER by idabsen) as no_baris, a.idabsen, a.is_operator_approve, b.nip, b.Nama, a.Tanggal, a.KdAbsen, a.Keterangan, c.Departemen
								FROM tabsen_request a JOIN mskaryawan b ON a.KdKaryawan = b.KdKaryawan
								JOIN msdepartemen c ON a.KdDepartemen = c.RecordID								
								--WHERE a.is_pimpinan_approve = 1
							) x
							$sWhere
					) y";
			
		}
		
		$query = $this->db->query($ssql);        
        return $query;
		
    }
    
    function getlist_ketidakhadiran_total($sIndexColumn, $parameter_login)
	{
		
		$kdkaryawan = $parameter_login['kdkaryawan'];
		$level = $parameter_login['level'];
		
		If ($level == 'Pimpinan')
		{
			
			$ssql = "SELECT $sIndexColumn FROM
					(
						SELECT no_baris, idabsen, is_pimpinan_approve, nip, Nama, Tanggal, KdAbsen, Keterangan, Departemen FROM
							(
								SELECT ROW_NUMBER() OVER (ORDER by idabsen) as no_baris, a.idabsen, a.is_pimpinan_approve, b.nip, b.Nama, a.Tanggal, a.KdAbsen, a.Keterangan, c.Departemen
								FROM tabsen_request a JOIN mskaryawan b ON a.KdKaryawan = b.KdKaryawan
								JOIN msdepartemen c ON a.KdDepartemen = c.RecordID
								WHERE a.KdPimpinan = '$kdkaryawan'
							) x
					) y";
			
		}
		else if ($level == 'Operator')
		{
			
			$ssql = "SELECT $sIndexColumn FROM
					(
						SELECT no_baris, idabsen, is_operator_approve, nip, Nama, Tanggal, KdAbsen, Keterangan, Departemen FROM
							(
								SELECT ROW_NUMBER() OVER (ORDER by idabsen) as no_baris, a.idabsen, a.is_operator_approve, b.nip, b.Nama, a.Tanggal, a.KdAbsen, a.Keterangan, c.Departemen
								FROM tabsen_request a JOIN mskaryawan b ON a.KdKaryawan = b.KdKaryawan
								JOIN msdepartemen c ON a.KdDepartemen = c.RecordID								
								--WHERE a.is_pimpinan_approve = 1
							) x
					) y";
			
		}
		
		$query = $this->db->query($ssql);
		
		//echo $ssql;
        
        return $query;
		
    }
	
    /*==================================== end of m_trappketidakhadiran =====================================*/
	
	function proses_approval_ketidakhadiran($data)
	{
		$is_approve = $data['is_approve'];
		$idabsen = $data['idabsen'];
		$ssql = "UPDATE tabsen_request SET is_pimpinan_approve = '$is_approve' WHERE idabsen = '$idabsen'"; 
		return $this->db->query($ssql);
		
	}
	
	function proses_approval_ketidakhadiran_bypetugas($data)
	{
		$is_approve = $data['is_approve'];
		$idabsen = $data['idabsen'];
		$kdoperator = $data['kdoperator'];
		
		If ($is_approve == 1)
		{
			
			$ssql1 = "UPDATE tabsen_request SET is_operator_approve = '$is_approve', is_finish = 1, KdOperator = '$kdoperator' WHERE idabsen = '$idabsen'"; 
			$this->db->query($ssql1);
			
			$idabsen_tabsen = $this->m_database->GenerateMaxNumber('tabsen', 'idabsen');
		
			$ssql2 = "INSERT INTO tabsen (idabsen, KdKaryawan, Tanggal, KdAbsen, KdDepartemen, KdJabatan, DefaultShift, Shift, WorkOn, WorkOff, Keterangan, nip)
			SELECT '$idabsen_tabsen', KdKaryawan, Tanggal, KdAbsen, KdDepartemen, KdJabatan, DefaultShift, Shift, WorkOn, WorkOff, Keterangan, nip FROM tabsen_request
			WHERE idabsen = '$idabsen'";

			$this->db->query($ssql2);
			
		}
		else
		{
			$ssql1 = "UPDATE tabsen_request SET is_operator_approve = '$is_approve', is_finish = 0, KdOperator = '$kdoperator' WHERE idabsen = '$idabsen'"; 
			$this->db->query($ssql1);
		}	

		return true;
		
	}
	
	function getHistoryAbsen_OLD($tahun, $kdkaryawan)
	{
		
		//SELECT @Akumulasi_Desember = COUNT(KdAbsen) from tabsen where YEAR(Tanggal) = @tahun and MONTH(Tanggal) 
		//in (01,02,03,04,05,06,07,08,09,10,11,12) and KdKaryawan = @kdkaryawan and KdAbsen='A'

		//SET @keterangan = (SELECT dbo.GetHukumanAlpa(@Akumulasi_Desember) AS MyResult)
		
		// DELETE DATA TEMPORARY NYA DULU
		$this->db->query("DELETE FROM laporan_history_absen");
		
		$ssql = "SELECT * FROM ex_jenisketidakhadiran WHERE KdJenisKetidakhadiran NOT IN ('A','C','H')";
		$qryopen = $this->db->query($ssql);
		
		If ($qryopen->num_rows() > 0)
		{
			
			foreach ($qryopen->result() as $val)
			{
				
				$kdabsen = $val->KdJenisKetidakhadiran;
			
		

		//	insert yang alpa
		
		$ssql = "
INSERT INTO laporan_history_absen (Tahun, kdabsen, kdkaryawan,nip,nama,departemen,jabatan,
januari,februari,maret,april,mei,juni,juli,agustus,september,oktober,november,desember,
akumulasi_januari,akumulasi_februari,akumulasi_maret,akumulasi_april, akumulasi_mei,
akumulasi_juni,akumulasi_juli,akumulasi_agustus,akumulasi_september,akumulasi_oktober,
akumulasi_november,akumulasi_desember,keterangan)

SELECT $tahun, '$kdabsen', $kdkaryawan, '-', '-', '-', '-', 
(select COUNT(KdAbsen) from tabsen where YEAR(Tanggal) = $tahun and MONTH(Tanggal)=01 and KdKaryawan = $kdkaryawan and KdAbsen='$kdabsen') as Januari, 
(select COUNT(KdAbsen) from tabsen where YEAR(Tanggal) = $tahun and MONTH(Tanggal)=02 and KdKaryawan = $kdkaryawan and KdAbsen='$kdabsen') as Februari, 
(select COUNT(KdAbsen) from tabsen where YEAR(Tanggal) = $tahun and MONTH(Tanggal)=03 and KdKaryawan = $kdkaryawan and KdAbsen='$kdabsen') as Maret, 
(select COUNT(KdAbsen) from tabsen where YEAR(Tanggal) = $tahun and MONTH(Tanggal)=04 and KdKaryawan = $kdkaryawan and KdAbsen='$kdabsen') as April, 
(select COUNT(KdAbsen) from tabsen where YEAR(Tanggal) = $tahun and MONTH(Tanggal)=05 and KdKaryawan = $kdkaryawan and KdAbsen='$kdabsen') as Mei, 
(select COUNT(KdAbsen) from tabsen where YEAR(Tanggal) = $tahun and MONTH(Tanggal)=06 and KdKaryawan = $kdkaryawan and KdAbsen='$kdabsen') as Juni, 
(select COUNT(KdAbsen) from tabsen where YEAR(Tanggal) = $tahun and MONTH(Tanggal)=07 and KdKaryawan = $kdkaryawan and KdAbsen='$kdabsen') as Juli, 
(select COUNT(KdAbsen) from tabsen where YEAR(Tanggal) = $tahun and MONTH(Tanggal)=08 and KdKaryawan = $kdkaryawan and KdAbsen='$kdabsen') as Agustus, 
(select COUNT(KdAbsen) from tabsen where YEAR(Tanggal) = $tahun and MONTH(Tanggal)=09 and KdKaryawan = $kdkaryawan and KdAbsen='$kdabsen') as September, 
(select COUNT(KdAbsen) from tabsen where YEAR(Tanggal) = $tahun and MONTH(Tanggal)=10 and KdKaryawan = $kdkaryawan and KdAbsen='$kdabsen') as Oktober, 
(select COUNT(KdAbsen) from tabsen where YEAR(Tanggal) = $tahun and MONTH(Tanggal)=11 and KdKaryawan = $kdkaryawan and KdAbsen='$kdabsen') as November, 
(select COUNT(KdAbsen) from tabsen where YEAR(Tanggal) = $tahun and MONTH(Tanggal)=12 and KdKaryawan = $kdkaryawan and KdAbsen='$kdabsen') as Desember, 

(select COUNT(KdAbsen) from tabsen where YEAR(Tanggal) = $tahun and MONTH(Tanggal)=01 and KdKaryawan = $kdkaryawan and KdAbsen='$kdabsen') as Akumulasi_Januari, 
(select COUNT(KdAbsen) from tabsen where YEAR(Tanggal) = $tahun and MONTH(Tanggal) in (01,02) and KdKaryawan = $kdkaryawan and KdAbsen='$kdabsen') as Akumulasi_Februari, 
(select COUNT(KdAbsen) from tabsen where YEAR(Tanggal) = $tahun and MONTH(Tanggal) in (01,02,03) and KdKaryawan = $kdkaryawan and KdAbsen='$kdabsen') as Akumulasi_Maret, 
(select COUNT(KdAbsen) from tabsen where YEAR(Tanggal) = $tahun and MONTH(Tanggal) in (01,02,03,04) and KdKaryawan = $kdkaryawan and KdAbsen='$kdabsen') as Akumulasi_April, 
(select COUNT(KdAbsen) from tabsen where YEAR(Tanggal) = $tahun and MONTH(Tanggal) in (01,02,03,04,05) and KdKaryawan = $kdkaryawan and KdAbsen='$kdabsen') as Akumulasi_Mei, 
(select COUNT(KdAbsen) from tabsen where YEAR(Tanggal) = $tahun and MONTH(Tanggal) in (01,02,03,04,05,06) and KdKaryawan = $kdkaryawan and KdAbsen='$kdabsen') as Akumulasi_Juni, 
(select COUNT(KdAbsen) from tabsen where YEAR(Tanggal) = $tahun and MONTH(Tanggal) in (01,02,03,04,05,06,07) and KdKaryawan = $kdkaryawan and KdAbsen='$kdabsen') as Akumulasi_Juli, 
(select COUNT(KdAbsen) from tabsen where YEAR(Tanggal) = $tahun and MONTH(Tanggal) in (01,02,03,04,05,06,07,08) and KdKaryawan = $kdkaryawan and KdAbsen='$kdabsen') as Akumulasi_Agustus, 
(select COUNT(KdAbsen) from tabsen where YEAR(Tanggal) = $tahun and MONTH(Tanggal) in (01,02,03,04,05,06,07,08,09) and KdKaryawan = $kdkaryawan and KdAbsen='$kdabsen') as Akumulasi_September, 
(select COUNT(KdAbsen) from tabsen where YEAR(Tanggal) = $tahun and MONTH(Tanggal) in (01,02,03,04,05,06,07,08,09,10) and KdKaryawan = $kdkaryawan and KdAbsen='$kdabsen') as Akumulasi_Oktober, 
(select COUNT(KdAbsen) from tabsen where YEAR(Tanggal) = $tahun and MONTH(Tanggal) in (01,02,03,04,05,06,07,08,09,10,11) and KdKaryawan = $kdkaryawan and KdAbsen='$kdabsen') as Akumulasi_November, 
(select COUNT(KdAbsen) from tabsen where YEAR(Tanggal) = $tahun and MONTH(Tanggal) in (01,02,03,04,05,06,07,08,09,10,11,12) and KdKaryawan = $kdkaryawan and KdAbsen='$kdabsen') as Akumulasi_Desember,
'-'";

			$this->db->query($ssql);
	
		}
	
	}
	
	// get datanya
	$ssql = "SELECT a.*, b.Jenis FROM laporan_history_absen a JOIN ex_jenisketidakhadiran b ON a.kdabsen = b.KdJenisKetidakhadiran";
	$query = $this->db->query($ssql);
	return $query;
		
	}
	
	function getHistoryAbsen($tahun, $kdkaryawan)
	{
		
		//SELECT @Akumulasi_Desember = COUNT(KdAbsen) from tabsen where YEAR(Tanggal) = @tahun and MONTH(Tanggal) 
		//in (01,02,03,04,05,06,07,08,09,10,11,12) and KdKaryawan = @kdkaryawan and KdAbsen='A'

		//SET @keterangan = (SELECT dbo.GetHukumanAlpa(@Akumulasi_Desember) AS MyResult)
		
		// DELETE DATA TEMPORARY NYA DULU
		//$this->db->query("DELETE FROM laporan_history_absen");
		
		$query = $this->db->query(
		"SP_GetHistoryAbsen '".$tahun."','".$kdkaryawan."'");
	
		// get datanya
		$ssql = "SELECT a.*, b.Jenis FROM laporan_history_absen a JOIN ex_jenisketidakhadiran b ON a.kdabsen = b.KdJenisKetidakhadiran";
		$query = $this->db->query($ssql);
		return $query;
		
	}
		
}