<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Msuser extends CI_Controller {
	
	public function __construct()
       {
            parent::__construct();
			// profiler ini untuk menampilkan debug
          	//$this->output->enable_profiler(TRUE);
			
			$this->load->database();
			$this->load->helper('url');
			$this->load->library('pagination');
			$this->load->library('auth');
			$this->load->library('fungsi');
			$this->load->library('session');
			$this->load->model('msusermodel','msuser');
       }
	
	
	public function index()
	{
		if(!is_logged_in())
		{
			redirect('login');
		}
		else
		{	
			$this->list_user();
		}
	}
	
	public function ajax_list()
	{
		$list = $this->msuser->get_datatables();
		$data = array();
		$no = $_POST['start'];
		
		foreach ($list->result() as $msuser) {
			$no++;
			$row = array();
			
			$row[] = $msuser->nama;
			$row[] = $msuser->fname;
			$row[] = $msuser->group_name;

			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void()" title="Edit" onclick="edit_person('."'".$msuser->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void()" title="Hapus" onclick="delete_person('."'".$msuser->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->msuser->count_all(),
						"recordsFiltered" => $this->msuser->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);//
	}
	
	function load_dropdown_pegawai()
	{
		
		$list = $this->msuser->getMsKaryawan();
		$ddata = array();

		foreach ($list as $qrymskaryawan) 
		{

			$row = array();

			$row['KdKaryawan'] = $qrymskaryawan['KdKaryawan'];
			$row['Nama'] = $qrymskaryawan['Nama'];
			$ddata[] = $row;
		
		}

		$output = array(
			"qrymskaryawan" => $ddata,
        );
		//output to json format
		echo json_encode($output);
		
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
			$this->load->view('msuser/add_user',$data);
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
	
	private function list_user()
	{
		
		$data['username'] = $this->session->userdata('username');
		$data['nama_lengkap'] = $this->session->userdata('nama_lengkap');
		$data['email'] = $this->session->userdata('email');
		$data['address'] = $this->session->userdata('address');
		$data['phone'] = $this->session->userdata('phone');
		
		$data['title']="<i class=\"fa fa-user fa-fw\"></i> Master Data User";
		$data['subtitle']=" User / Karyawan";
		$data['tabletitle']="Table Master Data User";
		$data['navigasi']="<li><a href=\"#\"><i class=\"fa fa-dashboard\"></i> Home</a></li>
            <li><a href=\"#\">Data Master</a></li>
            <li class=\"active\">User</li>";
		$this->load->view('header',$data);
		$this->load->view('leftsidebar');
		$this->load->view('msuser/list_user',$data);
		$this->load->view('footer');
		$this->load->view('rightsidebar');
		
	}
	
	function load_grid(){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
 		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 1000;
		$data = isset($_POST['data']) ? mysql_real_escape_string($_POST['data']) : '';  
 		$offset = ($page-1)*$rows;
		$this->msuser->limit = $rows;
 		$this->msuser->offset = $offset;
		$this->msuser->load_grid($data);
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
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>', '</div>');
			
			//$this->form_validation->set_error_delimiters('<div class="notif-bot-cnt"></div>');

			$this->form_validation->set_rules('edusername', 'Username', 'required');
			$this->form_validation->set_rules('edpassword', 'Password', 'required');
			$this->form_validation->set_rules('cbopegawai', 'Pegawai', 'required');
			$this->form_validation->set_rules('cboleveluser', 'Level User', 'required');
						
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
				$cbokdkaryawan = $this->input->post('cbopegawai');
				$cboleveluser = $this->input->post('cboleveluser');
				
				$this->msuser->save($username,$password,$cbokdkaryawan,$cboleveluser);
				//$this->session->set_flashdata('notif', '<div class="alert-box success"><span>Sukses: </span> Data User Berhasil Disimpan.</div>');
				$this->session->set_flashdata('notif', '<div class="box-body"><div class="alert alert-info alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-info"></i> Info!</h4>
                    Input data user berhasil.
                  </div></div>');
				//$alert = "Simpan data berhasil !!";
				//$this->session->set_flashdata('alert', $alert);
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
	
	function edit_password()
	{
		
		$data['username'] = $this->session->userdata('username');
		$data['nama_lengkap'] = $this->session->userdata('nama_lengkap');
		$data['email'] = $this->session->userdata('email');
		$data['address'] = $this->session->userdata('address');
		$data['phone'] = $this->session->userdata('phone');
		
		$this->load->library('form_validation');
		
		$data['title']="<i class=\"fa fa-user fa-fw\"></i> Rubah Password";
		$data['subtitle']=" Rubah Password / User";
		$data['tabletitle']="Rubah Password";
		$data['navigasi']="<li><a href=\"#\"><i class=\"fa fa-dashboard\"></i> Home</a></li>
            <li><a href=\"#\">Data Master</a></li>
            <li class=\"active\">Rubah Password</li>";
		
		if(!is_logged_in())
		{
			redirect('login');
		}
		else
		{
		
			$this->load->view('header',$data);
			$this->load->view('leftsidebar');
			$this->load->view('msuser/edit_password');
			$this->load->view('footer');
			$this->load->view('rightsidebar');
			
		}
	
	}
	
	function save_edit_password()
	{
		
		$data['username'] = $this->session->userdata('username');
		$data['nama_lengkap'] = $this->session->userdata('nama_lengkap');
		$data['email'] = $this->session->userdata('email');
		$data['address'] = $this->session->userdata('address');
		$data['phone'] = $this->session->userdata('phone');
	
		$this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>', '</div>');
        
		$this->form_validation->set_rules('old_password', 'Password Lama', 'required');
        $this->form_validation->set_rules('new_password', 'Password Baru', 'required');
        $this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'required');
		
		$data['title']="<i class=\"fa fa-user fa-fw\"></i> Rubah Password";
		$data['subtitle']=" Rubah Password / User";
		$data['tabletitle']="Rubah Password";
		$data['navigasi']="<li><a href=\"#\"><i class=\"fa fa-dashboard\"></i> Home</a></li>
        <li><a href=\"#\">Data Master</a></li>
        <li class=\"active\">Rubah Password</li>";
		
		if ($this->form_validation->run() == FALSE) 
		{
			
			$this->load->view('header',$data);
			$this->load->view('leftsidebar');
			$this->load->view('msuser/edit_password');
			$this->load->view('footer');
			$this->load->view('rightsidebar');
			
        } 
		else 
		{  
		
			$id_user =  $this->session->userdata('user_id');
			
			//var post
			//$spassword = hash('sha512',$password);
			$spasswordlama = hash('sha512',$this->input->post('old_password'));
			$spasswordbaru = hash('sha512',$this->input->post('new_password'));
			$spasswordkonfirmasi = hash('sha512',$this->input->post('confirm_password'));
			
			//$this->db->query('UPDATE user SET password = "'.$password.'" WHERE userid = "'.$id_user.'"');
			//$cek_password_lama	= $this->db->query("SELECT password FROM user WHERE userid = $id_user");
			
			if ($spasswordbaru != $spasswordkonfirmasi) 
			{
				//$this->session->set_flashdata('notif', '<div id="alert" class="alert alert-error">Password Baru 1 dan 2 tidak cocok</div>');
				$this->session->set_flashdata('notif', '<div class="box-body"><div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-info"></i> Info!</h4>
                    Password baru dan konfirmasi tidak sama
                  </div></div>');
				redirect('msuser/edit_password');
			}
			
			$query = $this->db->query("SELECT * FROM user WHERE userid = '$id_user' AND password='$spasswordlama'");
			
			
			if ($query->num_rows() > 0)
			{
				
				
				$this->msuser->updatePassword($id_user, $spasswordkonfirmasi);
				//$this->session->set_flashdata('notif', '<div class="alert-box success"><span>Sukses: </span> Password berhasil diperbaharui</div>');
				$this->session->set_flashdata('notif', '<div class="box-body"><div class="alert alert-info alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-info"></i> Info!</h4>
                    Password berhasil diperbaharui
                  </div></div>');
				redirect('msuser/edit_password');
				
				
				/*
				echo $id_user;
				echo '</br>';
				echo $spasswordlama; 
				*/
				
				
			}
			else
			{
				$this->session->set_flashdata('notif', '<div id="alert" class="alert alert-error">Password lama yang Anda masukkan salah</div>');
				redirect('msuser/edit_password');
			} 		
			
		}
		
	}
	
	
	//untuk return value validasi apakah password lama sesuai dengan yg diinputkan
	public function password_check($str)
	{
			
		$id_user =  $this->session->userdata('user_id');
		$password = md5($str);
		
		$query = $this->db->query("SELECT * FROM user WHERE userid = '$id_user' AND password='$password'");
			
			if ($query->num_rows() > 0)
			{
				return TRUE;
		
			}
			else
			{
				//echo 'id usernya = ' . $id_user . 'passwordnya = ' . $password;
				$this->form_validation->set_message('password_check', 'Password yang Anda Masukan Salah.');
				return FALSE;
			}
		
	}
	
		//untuk reset password user
	public function reset_password($id)
	{
	$tingkat = $this->checkRole($id);

	if($tingkat==1){
	
		echo warning('Satu guru satu ilmu jangan saling ganggu :) ','user');
	
	}else{
		
		$username = $this->uri->segment(4);
		$this->user->updatePassword($id,$username);
		$this->session->set_flashdata('notif', '<p class = "error">Password Username '.$username.' Berhasil Direset</p>');
		redirect('user/');

	}
	
	}
	
}

/* End of file msuser.php */
/* Location: ./application/controllers/msuser.php */