<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_database extends CI_Model{
	
	function getKdJenisKetidakhadiran()
	{
		
		$ssql = "SELECT KdJenisKetidakhadiran, Jenis FROM ex_jenisketidakhadiran ORDER BY KdJenisKetidakhadiran ASC";
		$query = $this->db->query($ssql);
		return $query->result();	
		
	}
	
	function getPimpinan()
	{
		
		$ssql = "SELECT * FROM msuser WHERE group_name = 'Pimpinan' ORDER BY fname ASC";
		$query = $this->db->query($ssql);
		return $query->result();	
		
	}
	
	function getMsKaryawan()
	{
		
		$ssql = "SELECT * FROM mskaryawan WHERE is_pensiun = '0' ORDER BY Nama ASC";
		$query = $this->db->query($ssql);
		return $query->result();	
		
	}
			
	function save($edtgldari,$edtglsampai,$cboalasan,$cbopimpinan,$memoketerangan)
	{
		
		$this->db->trans_begin();
	
			$data = array(
			'username' => $username,
			'name' => $nama_lengkap,
			'email' => $email,
			'password' => $spassword,
			'address' => $alamat,
			'phone' => $no_hp			
			);

			$this->db->insert('tabsen_request', $data); 
					
			if ($this->db->trans_status() === FALSE)
			{
				$this->db->trans_rollback();
				return false;
			}
			else
			{				
				$this->db->trans_commit();
				return true;
			}
		
	}
	
	function getDataTMTPegawai($KdKaryawan, $TanggalDari, $TanggalSampai)
	{
		
		$ssql = "SELECT a.KdKaryawan, b.kddepartemen, b.kdjabatan FROM mskaryawan a 
				JOIN mstmt b ON a.KdKaryawan = b.kdkaryawan 
               	WHERE b.id = (SELECT MAX(id) FROM mstmt WHERE tanggal_dari <= '" . $TanggalDari . "' AND kdkaryawan = '" . $KdKaryawan . "') 
               	AND b.kdkaryawan = '" . $KdKaryawan . "'";
	
		$qrygettmtpegawai = $this->db->query($ssql);
		return $qrygettmtpegawai;
	
	}
	
	function GenerateMaxNumber($tabel, $kolom)
	{
		
		$ssql = "SELECT MAX(" . $kolom . ") as maxx FROM " . $tabel;
		$qryget = $this->db->query($ssql);
		
		If ($qryget->num_rows() > 0)
		{
			$qryopen = $this->db->query($ssql)->row();
			$maxx = $qryopen->maxx;
			$maxx = $maxx + 1;
			return $maxx;
		}
		else
		{
			return 1;
		}
		
	}
	
	function GetHariLiburSabtuMinggu($sTanggal)
	{
		
		$ssql = "SELECT * FROM mslibur WHERE Tanggal = '$sTanggal'";
		$qryget = $this->db->query($ssql);

		if ($qryget->num_rows() > 0)
		{
			return true;
		}
		else
		{
			
			$day = date('D', strtotime($sTanggal));
    	
			$dayList = array(
			'Sun' => 'Minggu',
			'Mon' => 'Senin',
			'Tue' => 'Selasa',
			'Wed' => 'Rabu',
			'Thu' => 'Kamis',
			'Fri' => 'Jumat',
			'Sat' => 'Sabtu'
			);
    
			$sHari = $dayList[$day];	
			
			//if( !is_home() or !is_archive()) {
			if ($sHari == 'Sabtu' or $sHari == 'Minggu') 
			{
				return true;
			}
			else
			{
				return false;
			}
			
		}
		
	}
	
	function CariShift($iKdShift)
	{
		
		$ssql = "SELECT * FROM msshift WHERE RecordID = '$iKdShift'";
		$qryget = $this->db->query($ssql);
		return $qryget;
	
	}
		
}