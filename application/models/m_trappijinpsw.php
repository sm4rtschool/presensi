<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_trappijinpsw extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('m_database','m_database');
	}
	
	function getTabsenByIdAbsen($idabsen)
	{
		
		$ssql = "SELECT a.*, b.alasan FROM 
				(
					SELECT * FROM tabsen WHERE idabsen = '$idabsen'
				) a
				JOIN msalasan_psw b ON a.id_alasan_psw = b.id";
		
		$query = $this->db->query($ssql);
		return $query;	
		
	}
	
    function getlist_ijinpsw($aColumns, $sWhere, $sOrder, $top, $limit, $parameter_login)
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
					SELECT ROW_NUMBER() OVER (ORDER by idabsen DESC) as no_baris, idabsen, is_pimpinan_approve_psw, 
					KdKaryawan, nip, Nama, Tanggal, KdAbsen, Keterangan, Departemen,
					WorkOn, WorkOff, DutyOn, DutyOff, CONVERT(CHAR(5), HomeEarly) + ' (' +
					(select KdPsw from ex_psw WHERE MenitAwal <= x.HomeEarly AND x.HomeEarly <= MenitAkhir) + ')' AS HomeEarly, alasan FROM
					(
										
						SELECT ROW_NUMBER() OVER (ORDER by idabsen) as no_baris, a.idabsen, a.is_pimpinan_approve_psw, a.KdKaryawan, b.nip, b.Nama, 
						a.Tanggal, a.KdAbsen, a.Keterangan, c.Departemen, a.WorkOn, a.WorkOff, a.DutyOn, a.DutyOff, HomeEarly, d.alasan
						FROM tabsen a JOIN mskaryawan b ON a.KdKaryawan = b.KdKaryawan
						JOIN msdepartemen c ON a.KdDepartemen = c.RecordID
						JOIN msalasan_psw d ON a.id_alasan_psw = d.id
						WHERE a.kdpimpinan_psw = '$kdkaryawan'
						
					) x
					$sWhere
				) y			
				WHERE no_baris BETWEEN '$begin' AND '$end' ORDER BY no_baris ASC";
				
		}
		else if ($level == 'Operator')
		{
			
			$ssql = "SELECT * FROM
				(
					SELECT ROW_NUMBER() OVER (ORDER by idabsen DESC) as no_baris, idabsen, is_pimpinan_approve_psw, is_petugas_approve_psw, 
					KdKaryawan, nip, Nama, Tanggal, KdAbsen, Keterangan, Departemen,
					WorkOn, WorkOff, DutyOn, DutyOff, CONVERT(CHAR(5), HomeEarly) + ' (' +
					(select KdPsw from ex_psw WHERE MenitAwal <= x.HomeEarly AND x.HomeEarly <= MenitAkhir) + ')' AS HomeEarly, alasan FROM
					(
					
						SELECT ROW_NUMBER() OVER (ORDER by idabsen) as no_baris, a.idabsen, a.is_pimpinan_approve_psw, a.is_petugas_approve_psw, 
						a.KdKaryawan, b.nip, b.Nama, a.Tanggal, a.KdAbsen, a.Keterangan, c.Departemen, a.WorkOn, a.WorkOff, a.DutyOn, a.DutyOff, a.HomeEarly, d.alasan
						FROM tabsen a JOIN mskaryawan b ON a.KdKaryawan = b.KdKaryawan
						JOIN msdepartemen c ON a.KdDepartemen = c.RecordID	
						JOIN msalasan_psw d ON a.id_alasan_psw = d.id						
						WHERE a.id_alasan_psw <> 0
						
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

	function getlist_ijinpsw_filteredtotal($sIndexColumn, $parameter_login, $aColumns, $sWhere, $sOrder, $top, $limit)
	{
		
		$kdkaryawan = $parameter_login['kdkaryawan'];
		$level = $parameter_login['level'];
		
		If ($level == 'Pimpinan')
		{
			
			$ssql = "SELECT $sIndexColumn FROM
					(
						SELECT no_baris, idabsen, is_pimpinan_approve_psw, 
						KdKaryawan, nip, Nama, Tanggal, KdAbsen, Keterangan, Departemen,
						WorkOn, WorkOff, DutyOn, DutyOff, HomeEarly FROM
							(
							
								SELECT ROW_NUMBER() OVER (ORDER by idabsen) as no_baris, a.idabsen, a.is_pimpinan_approve_psw, a.KdKaryawan, b.nip, b.Nama, 
								a.Tanggal, a.KdAbsen, a.Keterangan, c.Departemen, a.WorkOn, a.WorkOff, a.DutyOn, a.DutyOff, HomeEarly
								FROM tabsen a JOIN mskaryawan b ON a.KdKaryawan = b.KdKaryawan
								JOIN msdepartemen c ON a.KdDepartemen = c.RecordID						
								WHERE a.kdpimpinan_psw = '$kdkaryawan'
								
							) x
							$sWhere
					) y";
			
		}
		else if ($level == 'Operator')
		{
			
			$ssql = "SELECT $sIndexColumn FROM
					(
						SELECT no_baris, idabsen, is_petugas_approve_psw, nip, Nama, Tanggal, KdAbsen, Keterangan, Departemen FROM
							(
								SELECT ROW_NUMBER() OVER (ORDER by idabsen) as no_baris, a.idabsen, a.is_petugas_approve_psw, 
								b.nip, b.Nama, a.Tanggal, a.KdAbsen, a.Keterangan, c.Departemen
								FROM tabsen a JOIN mskaryawan b ON a.KdKaryawan = b.KdKaryawan
								JOIN msdepartemen c ON a.KdDepartemen = c.RecordID								
								JOIN msalasan_psw d ON a.id_alasan_psw = d.id						
								WHERE a.id_alasan_psw <> 0
							) x
							$sWhere
					) y";
			
		}
		
		//echo $ssql;
		$query = $this->db->query($ssql);        
        return $query;
		
    }
    
    function getlist_ijinpsw_total($sIndexColumn, $parameter_login)
	{
		
		$kdkaryawan = $parameter_login['kdkaryawan'];
		$level = $parameter_login['level'];
		
		If ($level == 'Pimpinan')
		{
			
			$ssql = "SELECT $sIndexColumn FROM
					(
						SELECT no_baris, idabsen, is_pimpinan_approve_psw, 
						KdKaryawan, nip, Nama, Tanggal, KdAbsen, Keterangan, Departemen,
						WorkOn, WorkOff, DutyOn, DutyOff, HomeEarly FROM
							(
								SELECT ROW_NUMBER() OVER (ORDER by idabsen) as no_baris, a.idabsen, a.is_pimpinan_approve_psw, a.KdKaryawan, b.nip, b.Nama, 
								a.Tanggal, a.KdAbsen, a.Keterangan, c.Departemen, a.WorkOn, a.WorkOff, a.DutyOn, a.DutyOff, HomeEarly
								FROM tabsen a JOIN mskaryawan b ON a.KdKaryawan = b.KdKaryawan
								JOIN msdepartemen c ON a.KdDepartemen = c.RecordID						
								WHERE a.kdpimpinan_psw = '$kdkaryawan'
							) x
					) y";
			
		}
		else if ($level == 'Operator')
		{
			
			$ssql = "SELECT $sIndexColumn FROM
					(
						SELECT no_baris, idabsen, is_petugas_approve_psw, nip, Nama, Tanggal, KdAbsen, Keterangan, Departemen FROM
							(
								SELECT ROW_NUMBER() OVER (ORDER by idabsen) as no_baris, a.idabsen, a.is_petugas_approve_psw, 
								b.nip, b.Nama, a.Tanggal, a.KdAbsen, a.Keterangan, c.Departemen
								FROM tabsen a JOIN mskaryawan b ON a.KdKaryawan = b.KdKaryawan
								JOIN msdepartemen c ON a.KdDepartemen = c.RecordID								
								JOIN msalasan_psw d ON a.id_alasan_psw = d.id						
								WHERE a.id_alasan_psw <> 0
							) x
					) y";
			
		}
		
		//echo $ssql;
		$query = $this->db->query($ssql);        
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
	
	function getBiodataMskaryawanByIdAbsen($idabsen, $level)
	{
	
		If ($level == 'Pimpinan')
		{
			
			$ssql = "SELECT a.Nama, b.Departemen, c.Jabatan FROM mskaryawan a JOIN msdepartemen b ON a.KdDepartemen = b.RecordID
					JOIN msjabatan c ON a.KdJabatan = c.RecordID
					WHERE kdkaryawan =
					(
						SELECT KdKaryawan FROM tabsen WHERE idabsen = $idabsen
					)";
					
			$query = $this->db->query($ssql);
			
		}
		else if ($level == 'Operator')
		{
			
			$ssql = "SELECT xx.KdKaryawan_mskaryawan, xx.nama AS nama_pegawai, xx.departemen, xx.jabatan, xx.kdpimpinan_psw, yy.Nama as nama_pimpinan FROM(
				SELECT * FROM (
				SELECT a.KdKaryawan as KdKaryawan_mskaryawan, a.Nama, b.Departemen, c.Jabatan FROM mskaryawan a 
				JOIN msdepartemen b ON a.KdDepartemen = b.RecordID
				JOIN msjabatan c ON a.KdJabatan = c.RecordID
				)
				a
				JOIN
				(
					SELECT KdKaryawan as KdKaryawan_tabsen, kdpimpinan_psw FROM tabsen WHERE idabsen = $idabsen
				)
				b
				ON a.KdKaryawan_mskaryawan = b.KdKaryawan_tabsen
				) xx
				JOIN mskaryawan yy ON xx.kdpimpinan_psw = yy.KdKaryawan";
			
			//echo $ssql;
			$query = $this->db->query($ssql);
			
		}
		else if ($level == 'Pegawai')
		{
				
			$ssql = "SELECT bb.*, aa.Nama as nama_petugas FROM mskaryawan aa
JOIN
(
SELECT xx.KdKaryawan_mskaryawan, xx.nama AS nama_pegawai, xx.departemen, xx.jabatan, xx.kdpimpinan, xx.kdoperator, yy.Nama as nama_pimpinan 
FROM (
				
				SELECT * FROM (
					SELECT a.KdKaryawan as KdKaryawan_mskaryawan, a.Nama, b.Departemen, c.Jabatan FROM mskaryawan a 
					JOIN msdepartemen b ON a.KdDepartemen = b.RecordID
					JOIN msjabatan c ON a.KdJabatan = c.RecordID
				)
				a
				JOIN
				(
					SELECT KdKaryawan as KdKaryawan_tabsen_request, KdPimpinan, KdOperator FROM tabsen_request WHERE idabsen = $idabsen
				)
				b
				ON a.KdKaryawan_mskaryawan = b.KdKaryawan_tabsen_request
) xx
JOIN mskaryawan yy ON xx.KdPimpinan = yy.KdKaryawan
) bb
ON aa.KdKaryawan = bb.KdOperator
";
			
			$query = $this->db->query($ssql);
			
			// kalo operator udah approve
			If ($query->num_rows() > 0)
			{
				
				
				
			}
			else
			{
				
				$ssql = "SELECT xx.KdKaryawan_mskaryawan, xx.nama AS nama_pegawai, xx.departemen, xx.jabatan, xx.kdpimpinan, xx.kdoperator, yy.Nama as nama_pimpinan 
FROM (
				
				SELECT * FROM (
					SELECT a.KdKaryawan as KdKaryawan_mskaryawan, a.Nama, b.Departemen, c.Jabatan FROM mskaryawan a 
					JOIN msdepartemen b ON a.KdDepartemen = b.RecordID
					JOIN msjabatan c ON a.KdJabatan = c.RecordID
				)
				a
				JOIN
				(
					SELECT KdKaryawan as KdKaryawan_tabsen_request, KdPimpinan, KdOperator FROM tabsen_request WHERE idabsen = $idabsen
				)
				b
				ON a.KdKaryawan_mskaryawan = b.KdKaryawan_tabsen_request
) xx
JOIN mskaryawan yy ON xx.KdPimpinan = yy.KdKaryawan
";

			$query = $this->db->query($ssql);
				
			}
			
		}
		
		return $query;	
	
	}
	
	function proses_approval_ijinpsw($data)
	{
		$is_approve = $data['is_approve'];
		$idabsen = $data['idabsen'];
		$ssql = "UPDATE tabsen SET is_pimpinan_approve_psw = '$is_approve' WHERE idabsen = '$idabsen'"; 
		return $this->db->query($ssql);
		
	}
	
	function proses_approval_ijinpsw_bypetugas($data)
	{
		$is_approve = $data['is_approve'];
		$idabsen = $data['idabsen'];
		$kdoperator = $data['kdoperator'];
		$ssql = "UPDATE tabsen SET is_petugas_approve_psw = '$is_approve', is_psw_finish = 1, kdpetugas_psw = '$kdoperator' WHERE idabsen = '$idabsen'"; 
		return $this->db->query($ssql);
		
	}
		
}