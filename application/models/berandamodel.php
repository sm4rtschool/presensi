<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Berandamodel extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
 
    function getJumlahTugas($id_user)
    {
		
		$query = $this->db->query('SELECT count(id_tugas) AS jum FROM tugas WHERE id_user = ' . $id_user . '');

		/*
		if ($this->session->userdata('level')=='2') {
		$id_pemberi_tanggung_jawab = $this->session->userdata('user_id');
		$query = $this->db->query('SELECT count(id_proses) AS jum FROM flow_proses WHERE id_pemberi_tanggung_jawab = '.$id_pemberi_tanggung_jawab.'');
		}
		
		if ($this->session->userdata('level')=='3') {
		$id_penanggung_jawab = $this->session->userdata('user_id');
		$query = $this->db->query('SELECT count(id_proses) AS jum FROM flow_proses WHERE id_penanggung_jawab = '.$id_penanggung_jawab.'');
		}
		*/
		
		$jumlah = 0;
		if($query->num_rows()>0)
		{
			foreach($query->result() as $row) 
			{
				$jumlah = $row->jum;
			}
		}
		return $jumlah;
    }	
	
	function getJumlahPekerjaan($id_user)
    {
		
		$query = $this->db->query('SELECT count(id_pekerjaan) AS jum FROM pekerjaan WHERE id_user = ' . $id_user . '');

		/*
		if ($this->session->userdata('level')=='2') {
		$id_pemberi_tanggung_jawab = $this->session->userdata('user_id');
		$query = $this->db->query('SELECT count(id_proses) AS jum FROM flow_proses WHERE id_pemberi_tanggung_jawab = '.$id_pemberi_tanggung_jawab.'');
		}
		
		if ($this->session->userdata('level')=='3') {
		$id_penanggung_jawab = $this->session->userdata('user_id');
		$query = $this->db->query('SELECT count(id_proses) AS jum FROM flow_proses WHERE id_penanggung_jawab = '.$id_penanggung_jawab.'');
		}
		*/
		
		$jumlah = 0;
		if($query->num_rows()>0)
		{
			foreach($query->result() as $row) 
			{
				$jumlah = $row->jum;
			}
		}
		return $jumlah;
    }
	
	function getChartAlpa($sKdKaryawan,$sTahun,$Alasan)
	{
		
		$SP_GetAlpaPegawaiSetahun = $this->db->query(
				"SP_GetAlpaPegawaiSetahun '".$sKdKaryawan."','".$sTahun."','".$Alasan."'");
		
		return $SP_GetAlpaPegawaiSetahun;
		
	}
	
	function getSummaryDashboard($sKdKaryawan)
	{
		
		$SP_GetSummaryDashboard = $this->db->query(
				"SP_GetSummaryDashboard '".$sKdKaryawan."'");
		
		return $SP_GetSummaryDashboard;
		
	}
	
}
?>