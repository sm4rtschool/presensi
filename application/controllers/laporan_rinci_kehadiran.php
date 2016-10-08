<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Laporan_rinci_kehadiran extends CI_Controller {

	public function __construct()
    {
            parent::__construct();
			// profiler ini untuk menampilkan debug
            // $this->output->enable_profiler(TRUE);
			
			$this->load->database();
			$this->load->helper('url');
			$this->load->helper('form');
			$this->load->library('pagination');
			$this->load->library('auth');
			$this->load->library('fungsi');
			$this->load->library('session');
			$this->load->model('m_date', '', TRUE);
			//$this->load->model('Kebutuhan_anggaran_model','kebutuhan_anggaran');
			  
			if(!is_logged_in())
			{
				redirect('login');
			}
    }
	
	
	public function index()
	{
		//jika belum login maka
		if(!is_logged_in())
		{
			redirect('login');
		}
		else
		{	
			$this->f_laprinci_kehadiran();
		}
	}
	
	public function f_laprinci_kehadiran()
	{	
	
		$data['username'] = $this->session->userdata('username');
		$data['nama_lengkap'] = $this->session->userdata('nama_lengkap');
		$data['email'] = $this->session->userdata('email');
		$data['address'] = $this->session->userdata('address');
		$data['phone'] = $this->session->userdata('phone');
		
		$this->load->library('form_validation');
		
		$data['title']="<i class=\"fa fa-user fa-fw\"></i> Transaksi Ijin Pulang Sebelum Waktu";
		$data['subtitle']=" Transaksi / Ijin Pulang Sebelum Waktu";
		$data['tabletitle']="Table Transaksi Ijin Pulang Sebelum Waktu";
		$data['navigasi']="<li><a href=\"#\"><i class=\"fa fa-dashboard\"></i> Home</a></li>
            <li><a href=\"#\">Transaksi</a></li>
            <li class=\"active\">Ijin Pulang Sebelum Waktu</li>";
		
		if(!is_logged_in())
		{
			redirect('login');
		}
		else
		{
		
			$this->load->view('header',$data);
			$this->load->view('leftsidebar');
			$this->load->view('laporan_rinci_kehadiran/laporan_rinci_kehadiran',$data);
			$this->load->view('footer');
			$this->load->view('rightsidebar');
		}
		
    }
	
	function layar()
	{
		
		if(!is_logged_in())
		{
			redirect('login');
		}
		else
		{
			
			$this->load->view('laporan_rinci_kehadiran/layar');
			
		}
		
	}
		
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */