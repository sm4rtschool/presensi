<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_monitoring_absensi_harian extends CI_Model{
	
	function __construct(){
        parent::__construct();
        $this->load->model('m_database','m_database');
    }
	
	function getlist_kehadiran($parameter_login, $tanggal_sekarang, $user_id)
    {
		
		$kdkaryawan = $parameter_login['kdkaryawan'];
		
		$ssql = "SELECT z.nip, z.Nama, y.DutyOn, y.DutyOff FROM 
(
SELECT a.KdKaryawan, a.DutyOn, a.DutyOff FROM tabsen a
JOIN msdepartemen b
ON a.KdDepartemen = b.RecordID
WHERE Tanggal = '$tanggal_sekarang' AND UserID LIKE '$user_id%' AND KdAbsen = 'H'
) y
JOIN mskaryawan z
ON y.KdKaryawan = z.KdKaryawan
";
		
        $query = $this->db->query($ssql);
        
        return $query;
    }
	
	function getlist_ketidakhadiran($parameter_login, $tanggal_sekarang, $user_id)
    {
		
		$kdkaryawan = $parameter_login['kdkaryawan'];
		
		$ssql = "SELECT z.nip, z.Nama, x.Jenis FROM 
(
SELECT KdJenisKetidakhadiran, Jenis FROM ex_jenisketidakhadiran
)
x
JOIN
(
SELECT a.KdKaryawan, a.KdAbsen FROM tabsen a
JOIN msdepartemen b
ON a.KdDepartemen = b.RecordID
WHERE Tanggal = '$tanggal_sekarang' AND UserID LIKE '$user_id%' AND KdAbsen NOT IN ('A','H')
) y
ON x.KdJenisKetidakhadiran = y.KdAbsen
JOIN mskaryawan z
ON y.KdKaryawan = z.KdKaryawan
";
		
        $query = $this->db->query($ssql);
        
        return $query;
    }
	
	function getlist_alpa($parameter_login, $tanggal_sekarang, $user_id)
    {
		
		$kdkaryawan = $parameter_login['kdkaryawan'];
		
		$ssql = "SELECT z.nip, z.Nama, x.Jenis FROM 
(
SELECT KdJenisKetidakhadiran, Jenis FROM ex_jenisketidakhadiran WHERE KdJenisKetidakhadiran = 'A'
)
x
JOIN
(
SELECT a.KdKaryawan, a.KdAbsen FROM tabsen a
JOIN msdepartemen b
ON a.KdDepartemen = b.RecordID
WHERE Tanggal = '$tanggal_sekarang' AND UserID LIKE '$user_id%' AND KdAbsen = 'A'
) y
ON x.KdJenisKetidakhadiran = y.KdAbsen
JOIN mskaryawan z
ON y.KdKaryawan = z.KdKaryawan
";
		
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
	
	function getPimpinan()
	{
		
		//$ssql = "SELECT * FROM msuser WHERE group_name = 'Pimpinan' ORDER BY fname ASC";
		$ssql = "SELECT a.kdkaryawan, b.Nama FROM msuser a JOIN mskaryawan b ON a.kdkaryawan = b.KdKaryawan WHERE group_name = 'Pimpinan' ORDER BY fname ASC";
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
	
	function GenerateAlasanNoLimit($KdPimpinan, $sTanggalAbsen, $sKdKaryawan, $Alasan, $is_eselon, $sKdDepartemen, $sKdJabatan, $sWorkOn, $sWorkOff, $iKdShift, $sShift, $sKeterangan, $sSerialNumber, $sNIP)
	{
		
		// cek dulu transaksi di tabsen nya. takutnya si user sudah melakukan transaksi yang kode ketidakhadiran nya di limit

		$SP_GetTabsenRequestLimit = $this->db->query(
		"SP_GetTabsenRequestLimit '".$sTanggalAbsen."','".$sKdKaryawan."','".$Alasan."'");
		
		/*
		echo $sTanggalAbsen;
		echo '</br>';
		echo $sKdKaryawan;
		echo '</br>';
		echo $Alasan;
		echo '</br>';
		*/
		
		
		If ($SP_GetTabsenRequestLimit->num_rows() > 0)
		{
							
			$WsNotifikasi = $WsNotifikasi . '{ Anda sudah melakukan transaksi ketidakhadiran ' . $Alasan .
                    'pada ' . $sTanggalAbsen . ' }' . '<br>';

            Goto Goto_SudahMelakukanTrKetidakhadiran;
		
		}
		
		$ssql = "DELETE FROM tabsen WHERE Tanggal = '$sTanggalAbsen' AND KdKaryawan = '$sKdKaryawan' ";
		$this->db->query($ssql);
		
		$ssql = "DELETE FROM ex_ketidakhadiran WHERE TanggalMulai = '$sTanggalAbsen' AND KdKaryawan = '$sKdKaryawan' ";
		$this->db->query($ssql);
		
		$iKdKetidakhadiran = $this->m_database->GenerateMaxNumber('ex_ketidakhadiran','KdKetidakhadiran');
		$ssql = "INSERT INTO ex_ketidakhadiran (KdKetidakhadiran,KdKaryawan,KdJenisKetidakhadiran,TanggalMulai,TanggalSelesai,Keterangan) VALUES 
				('$iKdKetidakhadiran','$sKdKaryawan','$Alasan','$sTanggalAbsen','$sTanggalAbsen','')";
		$this->db->query($ssql);

        // Jika pegawai yang schedule nya tetap
        
		If ($is_eselon != 1) 
		{
			
			// DutyOn,DutyOff,
			/*Duty On & Duty Off Ga usah di isi !! Lawong nama'a aja udah ga masuk Ya udah pasti ga ada Duty on & Off nya*/
			
			//echo "nilai selain 1";
			
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
					$config['upload_path'] = './attachment/';
					$config['allowed_types'] = 'gif|jpg|png|doc|pdf|jpeg';
					
					$config['overwrite'] = FALSE;
					$config['max_size'] = 0;
					//'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
					$config['max_width'] = 0;
					$config['max_height'] = 0;
					$config['max_filename'] = 0;
					$config['encrypt_name'] = FALSE;
					
					$idabsen = $this->m_database->GenerateMaxNumber('tabsen_request', 'idabsen');
					//echo $sTanggalAbsen . ' | ' . $idabsen;
					//echo '<br>';
					$config['file_name'] = $idabsen;
 
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
											
						$nama_file = $idabsen . $data['file_ext']; 
						$type_file = $data['file_type'];
						
						
						$ssql = "INSERT INTO tabsen_request (nama_file, type_file, is_pimpinan_approve, is_operator_approve, KdPimpinan,KdKaryawan,KdAbsen,KdDepartemen,KdJabatan,Tanggal,idabsen,WorkOn,WorkOff,KdIndex,DefaultShift,Shift,Keterangan,SerialNumber,nip) VALUES
								('$nama_file', '$type_file', 2, 2, '$KdPimpinan','$sKdKaryawan','$Alasan','$sKdDepartemen','$sKdJabatan','$sTanggalAbsen',$idabsen,'$sWorkOn','$sWorkOff',1,$iKdShift,'$sShift','$sKeterangan','$sSerialNumber','$sNIP')";
						
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
					
				}
				
				echo json_encode(array('status' => $status, 'msg' => $msg));
				
			/* prepare upload file */
			                  			
		}	// End Jika Yang Tidak Hadir adalah Staff
		else if ($is_eselon == 1)	// Jika yang tidak hadir adalah eselon
		{
			
			// DutyOn,DutyOff,
						
			echo "nilai 1";
			$sScheduleMasuk = $sTanggalAbsen + ' ' + $sWorkOn;
            $sSchedulePulang = sTanggalAbsen + ' ' + $sWorkOff;
			
			$ssql = "INSERT INTO tabsen (KdKaryawan,KdAbsen,KdDepartemen,KdJabatan,Tanggal,idabsen,DefaultShift,Shift,Keterangan,SerialNumber,nip) VALUES
					($sKdKaryawan,$Alasan,$sKdDepartemen,$sKdJabatan,$sTanggalAbsen,$idabsen,$iKdShift,$sShift,$sKeterangan,$sSerialNumber,$sNIP)";
			$this->db->query($ssql);       
			
		}
		
		Goto_SudahMelakukanTrKetidakhadiran:
		
		return true;
		
	}
	
	function GenerateAlasanLimit($attachment, $KdPimpinan, $sTanggalAbsen, $sKdKaryawan, $Alasan, $is_eselon, $sKdDepartemen, $sKdJabatan, $sWorkOn, $sWorkOff, $iKdShift, $sShift, $sKeterangan, $sSerialNumber, $sNIP)
	{
		
		/*
			To call procedures defined by you, you have to go with
			$this->db->query("call test_proc()");
		*/
		
		// cek dulu transaksi di tabsen nya. takutnya si user sudah melakukan transaksi yang kode ketidakhadiran nya di limit

		$SP_GetTabsenRequestLimit = $this->db->query(
		"SP_GetTabsenRequestLimit '".$sTanggalAbsen."','".$sKdKaryawan."','".$Alasan."'");
		
		/*
		echo $sTanggalAbsen;
		echo '</br>';
		echo $sKdKaryawan;
		echo '</br>';
		echo $Alasan;
		echo '</br>';
		*/
		
		If ($SP_GetTabsenRequestLimit->num_rows() > 0)
		{
							
			$WsNotifikasi = $WsNotifikasi . '{ Anda sudah melakukan transaksi ketidakhadiran ' . $Alasan .
                    'pada ' . $sTanggalAbsen . ' }' . '<br>';

            Goto Goto_SudahMelakukanTrKetidakhadiran;
		
		}
		
		/* prepare upload file */
				
				$status = "";
				$msg = "";
				$file_element_name = 'userfile';
				//$file_element_name = $attachment;
     
				if (empty($_POST['cboalasan']))
				{
					$status = "error";
					$msg = "Please enter a title";
				}
		
		//  get value ijin ini intinya

        //Ambil Jam & Tgl Server
		/*
		$sp_GetServerDate = $this->db->query("sp_GetServerDate()");
		
		If ($sp_GetServerDate->num_rows() > 0)
		{
			
			foreach ($sp_GetServerDate->result() as $row)
			{
				$dtServerDate = $sp_GetServerDate->$row->ServerDate;
			}
						
		}
		*/
                
        //DecodeDate(DtServerDate, $thn, $bln, $tgl); 
		/*
			$date = DateTime::createFromFormat("Y-m-d", "2068-06-15");
			echo $date->format("Y");
		*/
		
		//$Thn = $dtServerDate->format("Y");	
		$Thn = '2016';	
		
		$WsNotifikasi = '';

		/*SELECT * FROM mslimit_ketidakhadiran WHERE tahun = @tahun AND kdkaryawan = @kdkaryawan AND kdketidakhadiran = @kdabsen*/
		$SP_GetLimitKetidakhadiran = $this->db->query(
		"SP_GetLimitKetidakhadiran '".$Thn."','".$sKdKaryawan."','".$Alasan."'");
		
		If ($SP_GetLimitKetidakhadiran->num_rows() > 0)
		{
			
			foreach ($SP_GetLimitKetidakhadiran->result() as $row)
			{
				
				$iPrioritas = $row->prioritas;
				$sKdHeader = $row->kdheader;
				$sIDLimitKetidakhadiran = $row->id;
				$iKuota = $row->kuota;
				
			}
			
			If ($iPrioritas = 2) // KdAbsen IJIN
			{
				
				If ($iKuota > 0) // kalo kuota ijinnya masih ada
				{
					
					$iKuota = $iKuota - 1;
					
					//	insert into tabsen dan UPDATE mslimit_ketidakhadiran SET kuota = @kuota WHERE id = @idmslimitketidakhadiran
					
					$BreakOn  = NULL;
					$BreakOff  = NULL;
					$MinuteBreak = 0;
					$MinuteBalance = 0;
					$MinuteActual = 0; 
					$MinuteCredit = 0; 
					$MinuteDebet = 0; 
					$Late = 0;
					$HomeEarly = 0; 
					$OTTotal = 0;
					$JamEfektif = 0;
					$is_ijintelat  = NULL;
					$is_ijinpulangawal  = NULL;			
					
					if ($status != "error")
					{
						$config['upload_path'] = './attachment/';
						$config['allowed_types'] = 'gif|jpg|png|doc|pdf|jpeg';
						
						$config['overwrite'] = FALSE;
						$config['max_size'] = 0;
						//'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
						$config['max_width'] = 0;
						$config['max_height'] = 0;
						$config['max_filename'] = 0;
						$config['encrypt_name'] = FALSE;
 
						$idabsen = $this->m_database->GenerateMaxNumber('tabsen_request', 'idabsen');
						$config['file_name'] = $idabsen;
 
						$this->load->library('upload');
						$this->upload->initialize($config);
 
						if (!$this->upload->do_upload($file_element_name))
						{
							$status = 'error';
							$msg = $this->upload->display_errors('', '');
						}
						else
						{
						
							$data = $this->upload->data();
						
							//$file_id = $this->files_model->insert_file($data['file_name'], $_POST['title']);
											
							$nama_file = $idabsen . $data['file_ext']; 
							$type_file = $data['file_type'];
							
							$ssql = "INSERT INTO tabsen_request (nama_file, type_file, is_pimpinan_approve, is_operator_approve, KdPimpinan, KdKaryawan, KdAbsen, KdDepartemen, KdJabatan, Tanggal, idabsen, DutyOn, DutyOff, WorkOn, WorkOff, BreakOn, BreakOff, MinuteBreak, MinuteBalance, MinuteActual, MinuteCredit, MinuteDebet, Late, HomeEarly, OTTotal, JamEfektif, KdIndex, DefaultShift, Shift, Keterangan, SerialNumber, nip, is_ijintelat, is_ijinpulangawal) VALUES
							('$nama_file', '$type_file', 2, 2, '$KdPimpinan','$sKdKaryawan','$Alasan','$sKdDepartemen','$sKdJabatan','$sTanggalAbsen',$idabsen, NULL, NULL,'$sWorkOn','$sWorkOff', NULL, NULL,'$MinuteBreak', '$MinuteBalance', '$MinuteActual', '$MinuteCredit', '$MinuteDebet', '$Late', '$HomeEarly', '$OTTotal', '$JamEfektif', 1, $iKdShift, '$sShift','$sKeterangan','$sSerialNumber','$sNIP', NULL, NULL)";
						
							$file_id = $this->db->query($ssql);
							
							$ssql = "UPDATE mslimit_ketidakhadiran SET kuota = $iKuota WHERE id = '$sIDLimitKetidakhadiran'";
							$this->db->query($ssql);
							
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
						
					}
							
					echo json_encode(array('status' => $status, 'msg' => $msg));													
					
				}	// If ($iKuota > 0) // kalo kuota ijinnya masih ada
				else	//	If ($iKuota <= 0) jika kuota ijin nya sudah habis
				{
					
					/*SELECT * FROM mslimit_ketidakhadiran WHERE tahun = @tahun AND kdkaryawan = @kdkaryawan AND kdketidakhadiran = @kdabsen*/
					$SP_GetLimitKetidakhadiran = $this->db->query(
					"SP_GetLimitKetidakhadiran '".$Thn."','".$sKdKaryawan."','".$sKdHeader."'");
					
					If ($SP_GetLimitKetidakhadiran->num_rows() > 0)
					{
			
						foreach ($SP_GetLimitKetidakhadiran->result() as $row)
						{
				
							$iPrioritas = $row->prioritas;
							$sKdHeader = $row->kdheader;
							$sIDLimitKetidakhadiran = $row->id;
							$iKuota_CT = $row->kuota;
				
						}
						
						//echo $iPrioritas;
						//echo $sKdHeader;
						//echo $sIDLimitKetidakhadiran;
						//echo $iKuota_CT;
						
						If ($iKuota_CT > 0) // jika kuota CT nya masih ada
						{
							
							$iKuota_CT = $iKuota_CT - 1;
					
							//	insert into tabsen dan UPDATE mslimit_ketidakhadiran SET kuota = @kuota WHERE id = @idmslimitketidakhadiran
					
							$BreakOn = Null;
							$BreakOff = Null;
							$MinuteBreak = 0;
							$MinuteBalance = 0;
							$MinuteActual = 0; 
							$MinuteCredit = 0; 
							$MinuteDebet = 0; 
							$Late = 0;
							$HomeEarly = 0; 
							$OTTotal = 0;
							$JamEfektif = 0;
							$is_ijintelat = Null;
							$is_ijinpulangawal = Null;	
					
							if ($status != "error")
							{
						
								$config['upload_path'] = './attachment/';
								$config['allowed_types'] = 'gif|jpg|png|doc|pdf|jpeg';
						
								$config['overwrite'] = FALSE;
								$config['max_size'] = 0;
								//'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
								$config['max_width'] = 0;
								$config['max_height'] = 0;
								$config['max_filename'] = 0;
								$config['encrypt_name'] = FALSE;
 
								$idabsen = $this->m_database->GenerateMaxNumber('tabsen_request', 'idabsen');
								$config['file_name'] = $idabsen;
 
								$this->load->library('upload');
								$this->upload->initialize($config);
 
								if (!$this->upload->do_upload($file_element_name))
								{
									$status = 'error';
									$msg = $this->upload->display_errors('', '');
								}
								else
								{
						
									$data = $this->upload->data();
						
									//$file_id = $this->files_model->insert_file($data['file_name'], $_POST['title']);
											
									$nama_file = $idabsen . $data['file_ext']; 
									$type_file = $data['file_type'];
							
									$ssql = "INSERT INTO tabsen_request (nama_file, type_file, is_pimpinan_approve, is_operator_approve, KdPimpinan, KdKaryawan, KdAbsen, KdDepartemen, KdJabatan, Tanggal, idabsen, DutyOn, DutyOff, WorkOn, WorkOff, BreakOn, BreakOff, MinuteBreak, MinuteBalance, MinuteActual, MinuteCredit, MinuteDebet, Late, HomeEarly, OTTotal, JamEfektif, KdIndex, DefaultShift, Shift, Keterangan, SerialNumber, nip, is_ijintelat, is_ijinpulangawal) VALUES
									('$nama_file', '$type_file', 2, 2, '$KdPimpinan','$sKdKaryawan','$Alasan','$sKdDepartemen','$sKdJabatan','$sTanggalAbsen',$idabsen, NULL, NULL,'$sWorkOn','$sWorkOff', NULL, NULL,'$MinuteBreak', '$MinuteBalance', '$MinuteActual', '$MinuteCredit', '$MinuteDebet', '$Late', '$HomeEarly', '$OTTotal', '$JamEfektif', 1, $iKdShift, '$sShift','$sKeterangan','$sSerialNumber','$sNIP', NULL, NULL)";
									
									$file_id = $this->db->query($ssql);
									
									$ssql = "UPDATE mslimit_ketidakhadiran SET kuota = $iKuota_CT WHERE id = '$sIDLimitKetidakhadiran'";
									$this->db->query($ssql);
							
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
						
							}
							
							echo json_encode(array('status' => $status, 'msg' => $msg));	
							
						} // If ($iKuota_CT > 0) // jika kuota CT nya masih ada
						else //If ($iKuota_CT = 0) // jika kuota CT nya sudah habis
						{
							
							//get tmt pegawai berdasarkan tanggal ketika si pegawai absen
							
							$qrygettmtpegawai = $this->m_database->getDataTMTPegawai($sKdKaryawan, $sTanggalAbsen, $sTanggalAbsen);
					
							If ($qrygettmtpegawai->num_rows() > 0)
							{
						
								foreach ($qrygettmtpegawai->result() as $row)
								{
									$sKdDepartemen = $row->kddepartemen;
									$sKdJabatan = $row->kdjabatan;
								}
						
							}
							else
							{
								$sKdDepartemen = '-1';
								$sKdJabatan = '-1';
							}
							
							$idabsen = $this->m_database->GenerateMaxNumber('tabsen_request', 'idabsen');
							
							$ssql = "INSERT INTO tabsen_request (nama_file, type_file, is_pimpinan_approve, is_operator_approve, KdPimpinan, KdKaryawan, KdAbsen,KdDepartemen,KdJabatan,Tanggal,idabsen,DutyOn, DutyOff, WorkOn, WorkOff,BreakOn,BreakOff,MinuteBreak, MinuteBalance, MinuteActual, MinuteCredit, MinuteDebet, Late, HomeEarly, OTTotal, JamEfektif, KdIndex,DefaultShift,Shift,Keterangan,SerialNumber,nip,is_ijintelat, is_ijinpulangawal) VALUES
							('noimage.jpg', 'image/jpeg', 2, 2, '$KdPimpinan', '$sKdKaryawan', 'A', '$sKdDepartemen', '$sKdJabatan', '$sTanggalAbsen', $idabsen, NULL, NULL, '$sWorkOn', '$sWorkOn', NULL, NULL, '0', '0', '0', '0', '0', '0', '0', '0', '0', 1, $iKdShift, '$sShift','$sKeterangan','$sSerialNumber','$sNIP', NULL, NULL)";
						      
							$this->db->query($ssql);
                              
                            $WsNotifikasi = $WsNotifikasi . '{ Kode absensi ' . $sKdKaryawan . ', pada ' . $sTanggalAbsen . 
                            ', transaksi ketidakhadirannya dianggap sebagai ' . 'Alpa }' . '<br>';

                            Goto Goto_SudahMelakukanTrKetidakhadiran;
							
						}
						
					} // If ($SP_GetLimitKetidakhadiran->num_rows() > 0)
					else //  If SP_GetLimitKetidakhadiran.RecordCount = 0 Then
					{ //  jika rows cuti tahunan tidak ada ya insert jadi alpa aja lah
						
							//get tmt pegawai berdasarkan tanggal ketika si pegawai absen
							
							$qrygettmtpegawai = $this->m_database->getDataTMTPegawai($sKdKaryawan, $sTanggalAbsen, $sTanggalAbsen);
					
							If ($qrygettmtpegawai->num_rows() > 0)
							{
						
								foreach ($qrygettmtpegawai->result() as $row)
								{
									$sKdDepartemen = $row->kddepartemen;
									$sKdJabatan = $row->kdjabatan;
								}
						
							}
							else
							{
								$sKdDepartemen = '-1';
								$sKdJabatan = '-1';
							}
							
							$idabsen = $this->m_database->GenerateMaxNumber('tabsen_request', 'idabsen');
							
							$ssql = "INSERT INTO tabsen_request (nama_file, type_file, is_pimpinan_approve, is_operator_approve, KdPimpinan, KdKaryawan, KdAbsen,KdDepartemen,KdJabatan,Tanggal,idabsen,DutyOn, DutyOff, WorkOn, WorkOff,BreakOn,BreakOff,MinuteBreak, MinuteBalance, MinuteActual, MinuteCredit, MinuteDebet, Late, HomeEarly, OTTotal, JamEfektif, KdIndex,DefaultShift,Shift,Keterangan,SerialNumber,nip,is_ijintelat, is_ijinpulangawal) VALUES
							('noimage.jpg', 'image/jpeg', 2, 2, '$KdPimpinan', '$sKdKaryawan', 'A', '$sKdDepartemen', '$sKdJabatan', '$sTanggalAbsen', $idabsen, NULL, NULL, '$sWorkOn', '$sWorkOn', NULL, NULL, '0', '0', '0', '0', '0', '0', '0', '0', '0', 1, $iKdShift, '$sShift','$sKeterangan','$sSerialNumber','$sNIP', NULL, NULL)";
						    						      
							$this->db->query($ssql);
                              
                            $WsNotifikasi = $WsNotifikasi . '{ Kode absensi ' . $sKdKaryawan . ', pada ' . $sTanggalAbsen . 
                            ', transaksi ketidakhadirannya dianggap sebagai ' . 'Alpa }' . '<br>';

                            Goto Goto_SudahMelakukanTrKetidakhadiran;
						
					}
						
				}	//	If ($iKuota <= 0)
				
				
			}	//	If ($iPrioritas = 2) // KdAbsen IJIN
			else //If ($iPrioritas = 1) // KdAbsen CT
			{
				
				If ($iKuota > 0) // jika kuota CT > 0
				{
					
					$iKuota = $iKuota - 1;
					
					//	insert into tabsen dan UPDATE mslimit_ketidakhadiran SET kuota = @kuota WHERE id = @idmslimitketidakhadiran
					
					$BreakOn = NULL;
					$BreakOff = NULL;
					$MinuteBreak = 0;
					$MinuteBalance = 0;
					$MinuteActual = 0; 
					$MinuteCredit = 0; 
					$MinuteDebet = 0; 
					$Late = 0;
					$HomeEarly = 0; 
					$OTTotal = 0;
					$JamEfektif = 0;
					$is_ijintelat = NULL;
					$is_ijinpulangawal = NULL;	
					
					if ($status != "error")
					{
					
						$config['upload_path'] = './attachment/';
						$config['allowed_types'] = 'gif|jpg|png|doc|pdf|jpeg';
						
						$config['overwrite'] = FALSE;
						$config['max_size'] = 0;
						//'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
						$config['max_width'] = 0;
						$config['max_height'] = 0;
						$config['max_filename'] = 0;
						$config['encrypt_name'] = FALSE;
 
						$idabsen = $this->m_database->GenerateMaxNumber('tabsen_request', 'idabsen');
						$config['file_name'] = $idabsen;
 
						$this->load->library('upload');
						$this->upload->initialize($config);
 
						if (!$this->upload->do_upload($file_element_name))
						{
							
							$status = 'error';
							$msg = $this->upload->display_errors('', '');
							
						}
						else
						{
							$data = $this->upload->data();
							//$file_id = $this->files_model->insert_file($data['file_name'], $_POST['title']);
											
							$nama_file = $idabsen . $data['file_ext']; 
							$type_file = $data['file_type'];
						
							$ssql = "INSERT INTO tabsen_request (nama_file, type_file, is_pimpinan_approve, is_operator_approve, KdPimpinan, KdKaryawan, KdAbsen, KdDepartemen, KdJabatan, Tanggal, idabsen, DutyOn, DutyOff, WorkOn, WorkOff, BreakOn, BreakOff, MinuteBreak, MinuteBalance, MinuteActual, MinuteCredit, MinuteDebet, Late, HomeEarly, OTTotal, JamEfektif, KdIndex, DefaultShift, Shift, Keterangan, SerialNumber, nip, is_ijintelat, is_ijinpulangawal) VALUES
							('$nama_file', '$type_file', 2, 2, '$KdPimpinan','$sKdKaryawan','$Alasan','$sKdDepartemen','$sKdJabatan','$sTanggalAbsen',$idabsen,NULL,NULL,'$sScheduleMasuk','$sSchedulePulang','$BreakOn','$BreakOff','$MinuteBreak', '$MinuteBalance', '$MinuteActual', '$MinuteCredit', '$MinuteDebet', '$Late', '$HomeEarly', '$OTTotal', '$JamEfektif', 1, $iKdShift, '$sShift','$sKeterangan','$sSerialNumber','$sNIP', '$is_ijintelat', '$is_ijinpulangawal')";
						
							$file_id = $this->db->query($ssql);
							
							$ssql = "UPDATE mslimit_ketidakhadiran SET kuota = $iKuota WHERE id = '$sIDLimitKetidakhadiran'";
							$this->db->query($ssql);
							
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
						
					}
							
					echo json_encode(array('status' => $status, 'msg' => $msg));
					
				} //If ($iKuota > 0) // jika kuota CT > 0
				else	//	if kuota CT habis
				{
					
					//get tmt pegawai berdasarkan tanggal ketika si pegawai absen
							
					$qrygettmtpegawai = $this->m_database->getDataTMTPegawai($sKdKaryawan, $sTanggalAbsen, $sTanggalAbsen);
					
					If ($qrygettmtpegawai->num_rows() > 0)
					{
						
						foreach ($qrygettmtpegawai->result() as $row)
						{
							$sKdDepartemen = $row->kddepartemen;
							$sKdJabatan = $row->kdjabatan;
						}
					
					}
					else
					{
						$sKdDepartemen = '-1';
						$sKdJabatan = '-1';
					}
					
					$idabsen = $this->m_database->GenerateMaxNumber('tabsen_request', 'idabsen');
					
					$ssql = "INSERT INTO tabsen_request (nama_file, type_file, is_pimpinan_approve, is_operator_approve, KdPimpinan, KdKaryawan, KdAbsen,KdDepartemen,KdJabatan,Tanggal,idabsen,DutyOn, DutyOff, WorkOn, WorkOff,BreakOn,BreakOff,MinuteBreak, MinuteBalance, MinuteActual, MinuteCredit, MinuteDebet, Late, HomeEarly, OTTotal, JamEfektif, KdIndex,DefaultShift,Shift,Keterangan,SerialNumber,nip,is_ijintelat, is_ijinpulangawal) VALUES
							('noimage.jpg', 'image/jpeg', 2, 2, '$KdPimpinan', '$sKdKaryawan', 'A', '$sKdDepartemen', '$sKdJabatan', '$sTanggalAbsen', $idabsen, NULL, NULL, '$sWorkOn', '$sWorkOn', NULL, NULL, '0', '0', '0', '0', '0', '0', '0', '0', '0', 1, $iKdShift, '$sShift','$sKeterangan','$sSerialNumber','$sNIP', NULL, NULL)";
						    						      
					$this->db->query($ssql);
                              
                    $WsNotifikasi = $WsNotifikasi . '{ Kode absensi ' . $sKdKaryawan . ', pada ' . $sTanggalAbsen . 
                    ', transaksi ketidakhadirannya dianggap sebagai ' . 'Alpa }' . '<br>';

                    Goto Goto_SudahMelakukanTrKetidakhadiran;
					
				}
				
			}
			
		}	//	If ($SP_GetLimitKetidakhadiran->num_rows() > 0)

		Goto_SudahMelakukanTrKetidakhadiran:
        
				
	}	//	GenerateAlasanLimit
	
	public function insert_file($filename, $title)
    {
        $data = array(
            'filename'      => $filename,
            'title'         => $title
        );
        $this->db->insert('files', $data);
        return $this->db->insert_id();
    }
	
	function hapus_absen($id)
	{
		
		// delete data attachment
		
		$ssql = "SELECT * FROM tabsen_request WHERE idabsen = '$id'";
		$query = $this->db->query($ssql);
		
		If ($query->num_rows() > 0)
		{
						
			foreach ($query->result() as $row)
			{
				$nama_file = $row->nama_file;
				$is_finish = $row->is_finish;
				$sTanggalAbsen = $row->Tanggal;
				$sKdAbsen = $row->KdAbsen;
			}
			
			If ($nama_file != 'noimage.jpg')
			{
			
				$path_attachment = './attachment/' . $nama_file;  
				//echo $path_attachment;
				unlink($path_attachment);
				//$status = "error";
				//$msg = "Something went wrong when saving the file, please try again.";
			
			}
			else
			{
				
				echo "noimage.jpg";
				
			}
			
			/*
			If ($is_finish == 1)
			{
				
				$qryexecute = "DELETE FROM tabsen WHERE Tanggal = '$sTanggalAbsen' AND KdKaryawan = '$sKdAbsen' ";
				$this->db->query($qryexecute);
				
			}
			*/
			
		}
		
		//echo $nama_file;
		//echo '<br>';
		
		// delete data absen di tabsen_request
		$qryexecute = "DELETE FROM tabsen_request WHERE idabsen = '$id'";
		$this->db->query($qryexecute);
		
		return true;
			
	}
	
}