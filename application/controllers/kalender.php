<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kalender extends CI_Controller {
	
	public function __construct()
    {
            parent::__construct();
			// profiler ini untuk menampilkan debug
          	//$this->output->enable_profiler(TRUE);
			
			$this->load->database();
			$this->load->helper('url');
			//$this->load->library('pagination');
			$this->load->library('auth');
			$this->load->library('fungsi');
			$this->load->library('session');
			$this->load->model('eventmodel','events');
    }
	
	
	public function index()
	{
		if(!is_logged_in()){
		redirect('login');}else{	
			$this->list_calendar();
		}
	}
	
	function add_user()
	{
		
		$data['username'] = $this->session->userdata('username');
		$data['nama_lengkap'] = $this->session->userdata('nama_lengkap');
		$data['email'] = $this->session->userdata('email');
		$data['address'] = $this->session->userdata('address');
		$data['phone'] = $this->session->userdata('phone');
		
		$this->load->library('form_validation');
		
		$data['title']="<i class=\"fa fa-user fa-fw\"></i> Master Data User";
		$data['subtitle']=" User / Karyawan";
		$data['tabletitle']="Table Master Data User";
		$data['navigasi']="<li><a href=\"#\"><i class=\"fa fa-dashboard\"></i> Home</a></li>
            <li><a href=\"#\">Data Master</a></li>
            <li class=\"active\">Tambah User</li>";
		
		if(!is_logged_in())
		{
			redirect('login');
		}
		else
		{
		
			$this->load->view('header',$data);
			$this->load->view('leftsidebar');
			$this->load->view('msuser/add_user');
			$this->load->view('footer');
			$this->load->view('rightsidebar');
		}
		
	}
	
	/* edit data */
	function edit_user()
	{
		
		$data['username'] = $this->session->userdata('username');
		$data['nama_lengkap'] = $this->session->userdata('nama_lengkap');
		$data['email'] = $this->session->userdata('email');
		$data['address'] = $this->session->userdata('address');
		$data['phone'] = $this->session->userdata('phone');
		
		$this->load->library('form_validation');
		$data['title']="<i class=\"fa fa-user fa-fw\"></i> Master Data User";
		$data['subtitle']=" User / Karyawan";
		$data['tabletitle']="Table Master Data User";
		$data['navigasi']="<li><a href=\"#\"><i class=\"fa fa-dashboard\"></i> Home</a></li>
            <li><a href=\"#\">Data Master</a></li>
            <li class=\"active\">Edit User</li>";
		
		$id = $this->uri->segment(3);
	
		if(!is_logged_in())
		{
			redirect('login');
		}
		else
		{
		
			
			if($this->msuser->getUserById($id)->num_rows()>0)
			{
				
				$data['data'] =  $this->msuser->getUserById($id);
				
				$this->load->view('header',$data);
				$this->load->view('leftsidebar');
				$this->load->view('msuser/edit_user',$data);
				$this->load->view('footer');
				$this->load->view('rightsidebar');
			
			}
			else
			{
				$this->session->set_flashdata('notif', '<div class="alert-box warning"><span>Perhatian: </span> Data Yang Anda Cari Tidak Ada.</div>');
				redirect('msuser');
			}
			
			
		}
	}
	/* end edit data */
	
	private function list_calendar()
	{
		
		$data['username'] = $this->session->userdata('username');
		$data['nama_lengkap'] = $this->session->userdata('nama_lengkap');
		$data['email'] = $this->session->userdata('email');
		$data['address'] = $this->session->userdata('address');
		$data['phone'] = $this->session->userdata('phone');
		
		$data['title']="<i class=\"fa fa-user fa-fw\"></i> Kalender Kegiatan";
		$data['subtitle']=" Kalender Kegiatan / Karyawan";
		$data['tabletitle']="Kalender Kegiatan";
		$data['navigasi']="<li><a href=\"#\"><i class=\"fa fa-dashboard\"></i> Home</a></li>
            <li class=\"active\">Kalender Kegiatan</li>";
			
			//<li><a href=\"#\">Kalender</a></li>
			
		$this->load->view('header',$data);
		$this->load->view('leftsidebar');
		$this->load->view('calendar',$data);
		$this->load->view('footer');
		$this->load->view('rightsidebar');
		
	}
	
	function getEvents(){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
 		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 1000;
		$data = isset($_POST['data']) ? mysql_real_escape_string($_POST['data']) : '';  
 		$offset = ($page-1)*$rows;
		$this->events->limit = $rows;
 		$this->events->offset = $offset;
		$this->events->getEvents($data);
	}
	
	/* save add data */
	function save_add()
	{
	
		if(!is_logged_in())
		{
			redirect('login');
		}
		else
		{
			
			$data['username'] = $this->session->userdata('username');
			$data['nama_lengkap'] = $this->session->userdata('nama_lengkap');
			$data['email'] = $this->session->userdata('email');
			$data['address'] = $this->session->userdata('address');
			$data['phone'] = $this->session->userdata('phone');
					
					
			$this->load->library('form_validation');
			//$this->form_validation->set_error_delimiters('<div class="alert-box warning"><span>Peringatan: </span>', '</span></div>');
			//$this->form_validation->set_error_delimiters('<div class="alert-box warning">', '</span></div>');
			$this->form_validation->set_error_delimiters('<h4><i class="fa fa-info"></i>  Perhatian :</h4><div class="callout callout-info" style="margin-bottom: 0!important;"><div class="alert-box warning">', '</span></div></div>');
						
			$this->form_validation->set_rules('edusername', 'Username', 'required');
			$this->form_validation->set_rules('edpassword', 'Password', 'required');
			$this->form_validation->set_rules('edemail', 'Email', 'required');
			$this->form_validation->set_rules('ednohp', 'No.HP', 'required');
			
						
			if ($this->form_validation->run() == FALSE) 
			{
						
				$data['title']="<i class=\"fa fa-user fa-fw\"></i> Master Data User";
				$data['subtitle']=" User / Karyawan";
				$data['tabletitle']="Table Master Data User";
				$data['navigasi']="<li><a href=\"#\"><i class=\"fa fa-dashboard\"></i> Home</a></li>
				<li><a href=\"#\">Data Master</a></li>
				<li class=\"active\">User</li>";
			
				$this->load->view('header.php',$data);
				$this->load->view('leftsidebar');
				$this->load->view('msuser/add_user',$data);
				$this->load->view('footer.php');
				$this->load->view('rightsidebar');
			
			} 
			else 
			{  
		
				$username = $this->input->post('edusername');
				$password = $this->input->post('edpassword');
				$email = $this->input->post('edemail');
				$no_hp = $this->input->post('ednohp');
				$nama_lengkap = $this->input->post('ednamalengkap');
				$alamat = $this->input->post('memoalamat');			
				
				//$user_level = $this->input->post('user_level');
				//$id_user = $this->get_indeks_user();
				
				$this->msuser->save($username,$password,$email,$no_hp,$nama_lengkap,$alamat);
				$this->session->set_flashdata('notif', '<div class="alert-box success"><span>Sukses: </span> Data User Berhasil Disimpan.</div>');
				redirect('msuser');
				
			}
					
								
		}
	}
	/* end save add data */
	
	/* save edit data */
	
	function save_edit()
	{
	
		if(!is_logged_in())
		{
			redirect('login');
		}
		else
		{
			
			$data['username'] = $this->session->userdata('username');
			$data['nama_lengkap'] = $this->session->userdata('nama_lengkap');
			$data['email'] = $this->session->userdata('email');
			$data['address'] = $this->session->userdata('address');
			$data['phone'] = $this->session->userdata('phone');
							
			$this->load->library('form_validation');
			//$this->form_validation->set_error_delimiters('<div class="alert-box warning"><span>Peringatan: </span>', '</span></div>');
			$this->form_validation->set_error_delimiters('<h4><i class="fa fa-info"></i>  Perhatian :</h4><div class="callout callout-info" style="margin-bottom: 0!important;"><div class="alert-box warning">', '</span></div></div>');
						
			$this->form_validation->set_rules('edusername', 'Username', 'required');
			$this->form_validation->set_rules('edpassword', 'Password', 'required');
			$this->form_validation->set_rules('edemail', 'Email', 'required');
			$this->form_validation->set_rules('ednohp', 'No.HP', 'required');		
									
			if ($this->form_validation->run() == FALSE) 
			{
						
				$data['title']="<i class=\"fa fa-user fa-fw\"></i> Master Data User";
				$data['subtitle']=" User / Karyawan";
				$data['tabletitle']="Table Master Data User";
				$data['navigasi']="<li><a href=\"#\"><i class=\"fa fa-dashboard\"></i> Home</a></li>
				<li><a href=\"#\">Data Master</a></li>
				<li class=\"active\">User</li>";
			
				$this->load->view('header.php',$data);
				$this->load->view('leftsidebar');
				$this->load->view('msuser/edit_user',$data);
				$this->load->view('footer.php');
				$this->load->view('rightsidebar');
			
			} 
			else 
			{  
		
				$username = $this->input->post('edusername');
				$password = $this->input->post('edpassword');
				$email = $this->input->post('edemail');
				$no_hp = $this->input->post('ednohp');
				$nama_lengkap = $this->input->post('ednamalengkap');
				$alamat = $this->input->post('memoalamat');	
				
				$this->msuser->update($id_user,$username,$password,$email,$no_hp,$nama_lengkap,$alamat);
				$this->session->set_flashdata('notif', '<div class="alert-box success"><span>Sukses: </span> Data User Berhasil Disimpan.</div>');
				redirect('msuser');
				
			}
					
								
		}
	}
	
	/* end save edit data */
	
	/* delete data*/
	
	function delete($id='')
	{
				
		if(!is_logged_in())
		{
			redirect('login');
		}
		else
		{
		
			if($id=='')
			{
				redirect('login');
			}
			else
			{
				
				$this->msuser->delete($id);
				$this->session->set_flashdata('notif', '<div class="alert-box success"><span>Sukses: </span> Data user Dengan ID '.$id.' Berhasil Dihapus.</div>');
				redirect('msuser');	
				
			}
		}
	}
	
	/* end delete data */
	
	function load_user_detail()
	{
		$id = $this->uri->segment(3);
		$data['list'] = $this->msuser->getUserById($id);
		$this->load->view('msuser/list_user_detail',$data);
	}
	
}

/* End of file msuser.php */
/* Location: ./application/controllers/msuser.php */