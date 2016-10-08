<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	
	public function __construct()
    {
            parent::__construct();
          	//$this->output->enable_profiler(TRUE);
			
			$this->load->database();
			$this->load->helper('url');
			$this->load->library('pagination');
			$this->load->library('auth');
			$this->load->library('fungsi');
			$this->load->library('session');
			
    }

	public function index()
	{
		$this->load->view('login/login');
	}
	
	function do_login()
	{
		$this->auth->restrict(true);
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->index();
		}
		else
		{
			
     		$this->load->library('auth');
			
			$login = array(	'username'=>$this->input->post('username'),
							'password'=>$this->input->post('password')
			);
			
			$return = $this->auth->do_login($login);
			
			if($return)
			{
				redirect('beranda');
			}
			else
			{
				echo warning('Maaf, username atau password yang Anda masukkan salah...','login');
			}
			
		}
	}
	
	function logout()
	{
		$this->auth->logout();
		//redirect('login');
		/*Redirect the user to some site*/ 
         redirect('http://localhost/presensi_dashboard/'); 
	}
	
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */