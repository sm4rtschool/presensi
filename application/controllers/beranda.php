<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Beranda extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		// profiler ini untuk menampilkan debug
        //$this->output->enable_profiler(TRUE);
			
		$this->load->database();
		$this->load->helper(array('form', 'url', 'html'));
		$this->load->library('pagination');
		$this->load->library('auth');
		$this->load->library('fungsi');
		$this->load->library('session');
		$this->load->model('berandamodel');
		$this->load->model('msusermodel','login_model');
		$this->load->model('eventmodel','events');
    }
		
	public function index()
	{
		if(!is_logged_in())
		{
			redirect('login');
		}
		else
		{	
			$this->home();
		}
	}
	
	function ambil_waktu_server()
	{
		
		//Ambil Jam & Tgl Server
		
		$sp_GetServerDate = $this->db->query("SELECT GETDATE() AS ambil_waktu_server");
		$Thn = date('Y', strtotime($sp_GetServerDate->row()->ambil_waktu_server));
		return $Thn;
		
	}
	
	private function home()
	{
		
		//echo $this->session->userdata('level');
		
		// ambil menu dari database sesuai dengan level
		//$data['menu'] = $this->Login_model->get_menu_for_level($id_level);	
		
		//$data['user']=$this->session->userdata('username');		
		
		$id_user = $this->session->userdata('user_id');
		$data['username'] = $this->session->userdata('username');
		$data['nama_lengkap'] = $this->session->userdata('nama_lengkap');
		$data['email'] = $this->session->userdata('email');
		$data['address'] = $this->session->userdata('address');
		$data['phone'] = $this->session->userdata('phone');
		$data['level'] = $this->session->userdata('level');
		
		//$data['jumlah_tugas'] = $this->berandamodel->getJumlahTugas($id_user);
		//$data['jumlah_pekerjaan'] = $this->berandamodel->getJumlahPekerjaan($id_user);
		
		$this->load->view('header',$data);
		$this->load->view('leftsidebar',$data);
			
		
		If ($this->session->userdata('level') == 'Super Admin')
		{
			$this->load->view('beranda/beranda_superadmin',$data);
		}
		else If ($this->session->userdata('level') == 'Operator')
		{
			$this->load->view('beranda/beranda_operator',$data);
		}
		else If ($this->session->userdata('level') == 'Pegawai')
		{
			
			$kdkaryawan = $this->session->userdata('kdkaryawan');
			$tahun = $this->ambil_waktu_server();
			
			foreach($this->berandamodel->getChartAlpa($kdkaryawan,$tahun,'A')->result_array() as $row)
			{
				$data['grafik'][]=(float)$row['Januari'];
				$data['grafik'][]=(float)$row['Februari'];
				$data['grafik'][]=(float)$row['Maret'];
				$data['grafik'][]=(float)$row['April'];
				$data['grafik'][]=(float)$row['Mei'];
				$data['grafik'][]=(float)$row['Juni'];
				$data['grafik'][]=(float)$row['Juli'];
				$data['grafik'][]=(float)$row['Agustus'];
				$data['grafik'][]=(float)$row['September'];
				$data['grafik'][]=(float)$row['Oktober'];
				$data['grafik'][]=(float)$row['November'];
				$data['grafik'][]=(float)$row['Desember'];
			}
			
			$summary_dashboard = $this->berandamodel->getSummaryDashboard($kdkaryawan);
			$data['late'] = $summary_dashboard->row()->Late;
			$data['homeearly'] = $summary_dashboard->row()->HomeEarly;
			$data['kuota_ct'] = $summary_dashboard->row()->kuota_ct;
			$data['kuota_i'] = $summary_dashboard->row()->kuota_i;
						
			$this->load->view('beranda/beranda_pegawai',$data);
			
		}
		else If ($this->session->userdata('level') == 'Pimpinan')
		{
			$this->load->view('beranda/beranda_pimpinan',$data);
		}
		
		
		$this->load->view('footer');
		$this->load->view('rightsidebar');
		
		
				
	}
	
	function getEvents()
	{
		
		$this->events->getKalenderAbsen();
		
	}
	
	function getChartAlpa()
	{
		
		$query = $this->berandamodel->getChartAlpa('2016','1173','A');
		
		If ($query->num_rows() > 0)
		{
		
			foreach($query->result_array() as $row)
			{
			
			$data['grafik'][]=(float)$row['Januari'];
			$data['grafik'][]=(float)$row['Februari'];
			$data['grafik'][]=(float)$row['Maret'];
			$data['grafik'][]=(float)$row['April'];
			$data['grafik'][]=(float)$row['Mei'];
			$data['grafik'][]=(float)$row['Juni'];
			$data['grafik'][]=(float)$row['Juli'];
			$data['grafik'][]=(float)$row['Agustus'];
			$data['grafik'][]=(float)$row['September'];
			$data['grafik'][]=(float)$row['Oktober'];
			$data['grafik'][]=(float)$row['November'];
			$data['grafik'][]=(float)$row['Desember'];
			
			}
		
		}
		
		echo json_encode($data);
		
	}
	
}

/* End of file beranda.php */
/* Location: ./application/controllers/beranda.php */