<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Msjabatanmodel extends CI_Model{
	
function get_datatables(){
	
	if($_POST['length'] != -1){
	$start = $_POST['start'];
	$end = $start + $_POST['length'];
	$query = $this->db->query('SELECT no_baris, RecordID, Jabatan FROM
				(
					SELECT ROW_NUMBER() OVER (ORDER by RecordID) as no_baris, RecordID, Jabatan FROM msjabatan
				) 
				as something
				WHERE no_baris BETWEEN '.$start.' AND '.$end.' ORDER BY RecordID');
	}else{
			$query = $this->db->query('SELECT no_baris, RecordID, Jabatan FROM 
				(
					SELECT ROW_NUMBER() OVER (ORDER by RecordID) as no_baris, RecordID, Jabatan FROM msjabatan
				) 
				as something');
	}
	return $query;
}

function count_all(){
		$this->db->from('msjabatan');
		return $this->db->count_all_results();
}

function count_filtered(){
	
	$query = $this->get_datatables();
	return $query->num_rows();
}
	
}