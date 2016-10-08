<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class M_mspegawai extends CI_Model
{
	
	function get_datatables()
	{
	
		if($_POST['length'] != -1)
		{
			$start = $_POST['start'];
			$end = $start + $_POST['length'];
			$query = $this->db->query('SELECT no_baris,id, nama, fname, group_name FROM 
			(
				SELECT ROW_NUMBER() OVER (ORDER by id) as no_baris,id, nama, fname, group_name FROM msuser
			) 
			as something
			WHERE no_baris BETWEEN '.$start.' AND '.$end.' ORDER BY id');
		}
		else
		{
			$query = $this->db->query('SELECT no_baris,id, nama, fname, group_name FROM 
			(
				SELECT ROW_NUMBER() OVER (ORDER by id) as no_baris,id, nama, fname, group_name FROM msuser
			) 
			as something');
		}
	
	return $query;
	
	}

	function count_all(){
		$this->db->from('msuser');
		return $this->db->count_all_results();
	}

	function count_filtered(){
		$query = $this->get_datatables();
		return $query->num_rows();
	}

	function getMsKaryawanById($kdkaryawan)
	{
		
		$ssql = "SELECT * FROM mskaryawan WHERE KdKaryawan = '$kdkaryawan' AND is_pensiun = '0'";
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
						SELECT KdKaryawan FROM tabsen_request WHERE idabsen = $idabsen
					)";
					
			$query = $this->db->query($ssql);
			
		}
		else if ($level == 'Operator')
		{
			
			$ssql = "SELECT xx.KdKaryawan_mskaryawan, xx.nama AS nama_pegawai, xx.departemen, xx.jabatan, xx.kdpimpinan_tl, yy.Nama as nama_pimpinan FROM(
				SELECT * FROM (
				SELECT a.KdKaryawan as KdKaryawan_mskaryawan, a.Nama, b.Departemen, c.Jabatan FROM mskaryawan a 
				JOIN msdepartemen b ON a.KdDepartemen = b.RecordID
				JOIN msjabatan c ON a.KdJabatan = c.RecordID
				)
				a
				JOIN
				(
					SELECT KdKaryawan as KdKaryawan_tabsen, kdpimpinan_tl FROM tabsen WHERE idabsen = $idabsen
				)
				b
				ON a.KdKaryawan_mskaryawan = b.KdKaryawan_tabsen
				) xx
				JOIN mskaryawan yy ON xx.kdpimpinan_tl = yy.KdKaryawan";
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
	
}