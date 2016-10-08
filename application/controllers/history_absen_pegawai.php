<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class History_absen_pegawai extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_trappketidakhadiran');
		$this->load->helper('url');
		//$this->load->library('pagination');
		$this->load->library('auth');
		$this->load->library('fungsi');

    }
	
	public function index()
	{
		$this->load_history_absen();
	}
	
	public function load_history_absen()
	{
		
		$tahun =$this->uri->segment(3);
		$kdkaryawan =$this->uri->segment(4);
		$data['tahun'] = $tahun;
		$data['kdkaryawan'] = $kdkaryawan;
		$data['history_absen'] = $this->m_trappketidakhadiran->getHistoryAbsen($tahun, $kdkaryawan);
		
		$this->load->view('history_absen_pegawai/history_absen_pegawai.php',$data);
	}
		
}
