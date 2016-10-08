<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_laprinci_kehadiran extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->load->library('fungsi');
    }
	
	function getTabsen()
	{
		
		
		
	}
	
	function getUnitKerja()
	{
		
		//$this->db->distinct('unit_kerja');
		//$this->db->order_by("unit_kerja", "ASC");
		//$query = $this->db->get('tukin_duk');
		
		$ssql = "SELECT DISTINCT Departemen FROM msdepartemen ORDER BY Departemen ASC";
		$query = $this->db->query($ssql);
		return $query->result();	
		
		// Produces: ORDER BY title DESC 
		// Produces: SELECT DISTINCT * FROM table
		
	}
    
	function insert_duk($dataarray)
    {
		
		//echo count($dataarray);
		//echo '</br>';
		
		for ($i=0;$i<count($dataarray);$i++)
		{
			
			
			$data_duk = array(
                'tahun_bulan'=>$dataarray[$i]['tahun_bulan'],
                'nip'=>$dataarray[$i]['nip'],
                'gol'=>$dataarray[$i]['gol'],
                'jabatan'=>$dataarray[$i]['jabatan'],
                'eselon'=>$dataarray[$i]['eselon'],
                'unit_kerja'=>$dataarray[$i]['unit_kerja']
                //'grade'=>$dataarray[$i]['grade'],
                //'tunjangan_kinerja'=>$dataarray[$i]['tunjangan_kinerja']
            );
			
			
			/*
					echo $tahun_bulan;
					echo ' | ';
					echo $nip;
					echo ' | ';
					echo $gol;
					echo ' | ';
					echo $jabatan;
					echo ' | ';
					echo $eselon;
					echo ' | ';
					echo $unit_kerja;
					echo '</br>';
			
			
			/*
					echo $data['tahun_bulan'];
					echo ' | ';
					echo $data['nip'];
					echo ' | ';
					echo $data['gol'];
					echo ' | ';
					echo $data['jabatan'];
					echo ' | ';
					echo $data['eselon'];
					echo ' | ';
					echo $data['unit_kerja'];
					echo '</br>';
            */
			
			//$simpan = $this->db->insert('tukin_duk', $data_duk);
			//return $simpan;
			
			/*
			$query = "INSERT INTO tukin_duk (tahun_bulan, nip, gol, jabatan, eselon, unit_kerja, grade, tunjangan_kinerja) 
					  VALUES ('2014-12','".$nip."','".$gol."','".$jabatan."','".$eselon."','".$unit_kerja."','".$grade."','".$tunjangan_kinerja."')";
					  
					  echo $query;
					  echo '</br>';
					  
			/*
			return $this->db->query($query);
			*/
			//$i = $i + 1;
        }
		
		$simpan = $this->db->insert('tukin_duk', $data_duk);
		return $simpan;
		
    }

	
    function setUser($user_id,$username,$user_level)
    {
	
		$fname = '';
		$fname = $this->getNamaByNip($username);
	
		$password = md5($username);
		$query = "INSERT INTO msuser(id_user, password, username, fname, level) 
		values ('$user_id','$password','$username','$fname','$user_level')";
		return $this->db->query($query);
    }
	
	function generate_kebutuhan_anggaran($iPengaliBulan)
	{
		
		$sSQL = "SELECT a.*, d.KdPeringkat, d.TunjanganKinerja FROM tukin_duk a JOIN mskaryawan b ON a.nip=b.nip
						JOIN mstmt c ON c.kdkaryawan=b.KdKaryawan
						JOIN ex_peringkat d ON c.kdperingkat=d.kdperingkat
						WHERE tanggal_dari BETWEEN '2014-01-01' AND '2014-12-31'";
						
		$QryGet = $this->db->query($sSQL);
		
		if ($QryGet->num_rows() == 0)
		{
			echo warning('Data kosong !!','laporan_kebutuhan_anggaran');
		}
		else
		{

			foreach ($QryGet->result() as $row)
			{
						
				
						
			}
					
		}
		
	}
	
}
?>