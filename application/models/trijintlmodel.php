<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Trijintlmodel extends CI_Model{
	
	function __construct(){
        parent::__construct();
        $this->load->model('m_database','m_database');
    }
	
	function getPimpinan()
	{
		
		$ssql = "SELECT a.kdkaryawan, b.Nama FROM msuser a JOIN mskaryawan b ON a.kdkaryawan = b.KdKaryawan WHERE group_name = 'Pimpinan' ORDER BY fname ASC";
		$query = $this->db->query($ssql);
		return $query->result();	
		
	}
	
	function getAlasanTL()
	{
		
		$ssql = "SELECT * FROM msalasan_tl ORDER BY id ASC";
		$query = $this->db->query($ssql);
		return $query->result_array();	
		
	}
	
	function getTabsenByIdAbsen($idabsen)
	{
		
		$ssql = "SELECT a.*, b.alasan FROM tabsen a LEFT JOIN
				(
					SELECT * FROM msalasan_tl
				) b
				ON a.id_alasan_tl = b.id WHERE idabsen = '$idabsen' ";
				
		//echo $ssql;
		$query = $this->db->query($ssql);
		return $query;	
		
	}
	
	function getTabsenRequestByIdAbsen($idabsen)
	{
		
		$ssql = "SELECT * FROM tabsen WHERE idabsen = '$idabsen'";
		
		/*
		$ssql = "SELECT a.*, b.Jenis FROM 
(
SELECT * FROM tabsen_request WHERE idabsen = '$idabsen'
) a
JOIN ex_jenisketidakhadiran b ON a.KdAbsen = b.KdJenisKetidakhadiran";
*/
		
		$query = $this->db->query($ssql);
		return $query;	
		
	}
	
	function getlist_ijintl($aColumns, $sWhere, $sOrder, $top, $limit, $parameter_login)
    {
		
		$kdkaryawan = $parameter_login['kdkaryawan'];
		
		$top = $top + 1;
		$limit = $limit - 1;
		$begin = $top;
		$end = $top + $limit;
		
		$ssql = "SELECT * FROM
			(
			SELECT ROW_NUMBER() OVER (ORDER by idabsen DESC) as no_baris, idabsen, 
			Tanggal, Keterangan, WorkOn, WorkOff, DutyOn, DutyOff, nip, Nama, is_pimpinan_approve_tl, is_petugas_approve_tl, alasan, CONVERT(CHAR(5), Late) + ' (' +
			(select KdTerlambatDatang from ex_terlambatdatang WHERE MenitAwal <= x.Late AND x.Late <= MenitAkhir) + ')' AS Late FROM
			(
				SELECT a.idabsen, a.Tanggal, a.Keterangan, a.WorkOn, a.WorkOff, a.DutyOn, a.DutyOff, a.Late, b.nip, b.Nama, is_pimpinan_approve_tl, is_petugas_approve_tl, c.alasan
				FROM tabsen a 
				JOIN mskaryawan b ON a.KdKaryawan = b.KdKaryawan	
				LEFT JOIN msalasan_tl c ON a.id_alasan_tl = c.id 	
				WHERE a.KdKaryawan = '$kdkaryawan' AND Late > 0 
			) x
			$sWhere
			) y
			WHERE no_baris BETWEEN '$begin' AND '$end' ORDER BY no_baris ASC";
		
        $query = $this->db->query($ssql);
        
        return $query;
    }
	
	//$sWhere
	//$sOrder
	
	function getlist_ijintl_filteredtotal($sIndexColumn, $parameter_login, $aColumns, $sWhere, $sOrder, $top, $limit)
	{
		
		$kdkaryawan = $parameter_login['kdkaryawan'];
		
        $query = $this->db->query("
			
			SELECT $sIndexColumn FROM
			(
			SELECT ROW_NUMBER() OVER (ORDER by idabsen DESC) as no_baris, idabsen, Tanggal, Keterangan, DutyOn, DutyOff, Late, nip, Nama FROM
			(
				SELECT a.idabsen, a.Tanggal, a.Keterangan, a.DutyOn, a.DutyOff, a.Late, b.nip, b.Nama
				FROM tabsen a 
				JOIN mskaryawan b ON a.KdKaryawan = b.KdKaryawan			
				WHERE a.KdKaryawan = '$kdkaryawan' AND Late > 0
			) x
			$sWhere
			) y
			
        ");
        
        return $query;
		
    }
			
    function getlist_ijintl_total($sIndexColumn, $parameter_login)
	{
		
		/*
		// make sure we have a result
		if ( $query->num_rows() == 1 ) 
		{  
			// assign the result 
			$user = $query->row();  
			// pull out the field you want 
			$value = $user->first_field_of_resultset;
			// return it
			return $value ; 
		}
		else { return FALSE; }		
		*/
		
		$kdkaryawan = $parameter_login['kdkaryawan'];
		
        $query = $this->db->query("SELECT COUNT(*) AS total_jml_data FROM tabsen WHERE KdKaryawan = '$kdkaryawan' AND Late > 0");
		$total_jml_data = $query->row()->total_jml_data;  
		return $total_jml_data;
		
    }
	
	function save($path_attachment_tl, $file_element_name, $kdpimpinan_tl, $is_pimpinan_approve_tl, $is_petugas_approve_tl, $is_tl_finish, $id_alasan_tl, $idabsen)
	{
				
		/* prepare upload file */
		
		$status = "";
		$msg = "";
		$file_element_name = 'userfile';
				
		if (empty($_POST['cboalasan']))
		{
			$status = "error";
			$msg = "Please enter a title";
		}
	 
				if ($status != "error")
				{
					
					$config['upload_path'] = $path_attachment_tl;
					$config['allowed_types'] = 'gif|jpg|png|doc|pdf|jpeg';
					
					$config['overwrite'] = FALSE;
					$config['max_size'] = 0;
					//'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
					$config['max_width'] = 0;
					$config['max_height'] = 0;
					$config['max_filename'] = 0;
					$config['encrypt_name'] = FALSE;
					
					//echo $sTanggalAbsen . ' | ' . $idabsen;
					//echo '<br>';
					$config['file_name'] = 'tl' . $idabsen;
 
					$this->load->library('upload');
					$this->upload->initialize($config);
 
					if (!$this->upload->do_upload($file_element_name))
					{
						$status = 'error';
						$msg = $this->upload->display_errors('', '');
					}
					else
					{					
						
						//$data = $this->upload->initialize($config);
						$data = $this->upload->data();
						
						//$file_id = $this->files_model->insert_file($data['file_name'], $_POST['title']);
											
						$nama_file = 'tl' . $idabsen . $data['file_ext']; 
						$type_file = $data['file_type'];
						
						$ssql = "UPDATE tabsen SET kdpimpinan_tl = '$kdpimpinan_tl', is_pimpinan_approve_tl = '$is_pimpinan_approve_tl', 
						is_petugas_approve_tl = '$is_petugas_approve_tl', is_tl_finish = '$is_tl_finish', id_alasan_tl = '$id_alasan_tl', 
						nama_file_tl = '$nama_file', type_file_tl = '$type_file'
						WHERE idabsen = '$idabsen'";
						
						//echo $ssql;
						
						$file_id = $this->db->query($ssql);
						
						if($file_id)
						{
							$status = "success";
							$msg = "File successfully uploaded";
						}
						else
						{
							unlink($data['full_path']);
							$status = "error";
							$msg = "Something went wrong when saving the file, please try again.";
						}
						
					}
					
					@unlink($_FILES[$file_element_name]);
					return json_encode(array('status' => $status, 'msg' => $msg));
					
				}
				
		/* prepare upload file */
		
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
SELECT xx.KdKaryawan_mskaryawan, xx.nama AS nama_pegawai, xx.departemen, xx.jabatan, xx.kdpimpinan_tl, xx.kdpetugas_tl, yy.Nama as nama_pimpinan 
FROM (
				
				SELECT * FROM (
					SELECT a.KdKaryawan as KdKaryawan_mskaryawan, a.Nama, b.Departemen, c.Jabatan FROM mskaryawan a 
					JOIN msdepartemen b ON a.KdDepartemen = b.RecordID
					JOIN msjabatan c ON a.KdJabatan = c.RecordID
				)
				a
				JOIN
				(
					SELECT KdKaryawan as KdKaryawan_tabsen, kdpimpinan_tl, kdpetugas_tl FROM tabsen WHERE idabsen = $idabsen
				)
				b
				ON a.KdKaryawan_mskaryawan = b.KdKaryawan_tabsen
) xx
JOIN mskaryawan yy ON xx.kdpimpinan_tl = yy.KdKaryawan
) bb
ON aa.KdKaryawan = bb.kdpetugas_tl
";
			
			$query = $this->db->query($ssql);
			
			// kalo operator udah approve
			If ($query->num_rows() > 0)
			{
				
				
				
			}
			else
			{
				
				$ssql = "SELECT xx.KdKaryawan_mskaryawan, xx.nama AS nama_pegawai, xx.departemen, xx.jabatan, xx.kdpimpinan_tl, xx.kdpetugas_tl, yy.Nama as nama_pimpinan 
FROM (
				
				SELECT * FROM (
					SELECT a.KdKaryawan as KdKaryawan_mskaryawan, a.Nama, b.Departemen, c.Jabatan FROM mskaryawan a 
					JOIN msdepartemen b ON a.KdDepartemen = b.RecordID
					JOIN msjabatan c ON a.KdJabatan = c.RecordID
				)
				a
				JOIN
				(
					SELECT KdKaryawan as KdKaryawan_tabsen, kdpimpinan_tl, kdpetugas_tl FROM tabsen WHERE idabsen = $idabsen
				)
				b
				ON a.KdKaryawan_mskaryawan = b.KdKaryawan_tabsen
) xx
JOIN mskaryawan yy ON xx.kdpimpinan_tl = yy.KdKaryawan
";

			$query = $this->db->query($ssql);
				
			}
			
		}
		
		return $query;	
	
	}
	
}