<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Msusermodel extends CI_Model
{
	
	function __construct(){
        parent::__construct();
        $this->load->model('m_database','m_database');
    }
	
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

	function getMsKaryawan()
	{
		
		$ssql = "SELECT KdKaryawan, Nama FROM mskaryawan WHERE is_pensiun = '0' ORDER BY Nama ASC";
		$query = $this->db->query($ssql);
		return $query->result_array();	
		
	}
	
	function save($username,$password,$kdkaryawan,$leveluser)
	{
		
			$spassword = md5($password);
			$id = $this->m_database->GenerateMaxNumber('msuser', 'id');
			$ssql = "INSERT INTO msuser (id, nama, pass, kdkaryawan, group_name) VALUES ($id,'$username','$spassword','$kdkaryawan','$leveluser')";
		
			return $this->db->query($ssql);
		
	}
	
}