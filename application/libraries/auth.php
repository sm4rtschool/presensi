<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

class Auth{

	var $CI = null;

	function Auth()
	{
		$this->CI =& get_instance();
		$this->CI->load->database();
		$this->CI->load->helper('url');
	}
	
	function do_login($login = NULL)
	{
	     	
		// A few safety checks
	    // Our array has to be set

	    if(!isset($login))
			return FALSE;
		
	    //Our array has to have 2 values
	     //No more, no less!
	    	
		if(count($login) != 2)
			return FALSE;
		
	    $username = $login['username'];
	    //$password = hash('sha512',$login['password']);
	    $password = md5($login['password']);
		
		$this->CI->db->from('msuser');
		$this->CI->db->where('nama', $username);
		$this->CI->db->where('pass',$password);
		$query = $this->CI->db->get();
			
	     	if ($query->num_rows() > 0)
	     	{
				
				foreach ($query->result() as $row)
				{
					$user_id 	= $row->UserID;
					$username 	= $row->nama;
					$kdkaryawan = $row->kdkaryawan;
					//$nama_lengkap=$row->fname;
					//$email=$row->email;
					//$address=$row->address;
					//$phone=$row->phone;
					//$id_perusahaan = $row->username; 
					//$namafull 	= $row->fname;
						//$count 		= $row->user_logincount;
					$level 		= $row->group_name;
					//$last	    = $row->LAST_LOGIN;
					//$count++;
				}
			
				$this->CI->load->model('m_mspegawai');  //<-------Load the Model first
				$qrymskaryawan = $this->CI->m_mspegawai->getMsKaryawanById($kdkaryawan);
				
				If ($qrymskaryawan->num_rows() > 0)
				{
				
					foreach ($qrymskaryawan->result() as $row)
					{
						$nama = $row->Nama;
						$email = $row->Email;
						$address = $row->Alamat;
						$phone = $row->NoHP;
						$nip = $row->nip;
					}
					
					$newdata = array(
							'user_id' => $user_id,
                            'username' => $username,
                            'nama_lengkap' => $nama,
							'email' => $email,
							'address' => $address,
							'phone' => $phone,
                            'logged_in' => TRUE,
							'level'		=> $level,
							'kdkaryawan' => $kdkaryawan,
							'nip' => $nip
							// 'login_ke' 	=> $count,
							//'last_login'=> $last,							
               		);
					
					// Our user exists, set session.
					$this->CI->session->set_userdata($newdata);	  
					// update counter login
					//	$this->CI->db->where('user_id',$user_id);
					//	$this->CI->db->update('user',array('user_logincount'=>$count));	
									
					return TRUE;	
					
				}
				else
				{
					return false;
				}
			
			}
			else 
			{
				// No existing user.
				return FALSE;
			}
	
	}
 
	 /**
         *
         * This function restricts users from certain pages.
         * use restrict(TRUE) if a user can't access a page when logged in
         *
         * @access	public
         * @param	boolean	wether the page is viewable when logged in
         * @return	void
         */	
    	function restrict($logged_out = FALSE)
    	{
		// If the user is logged in and he's trying to access a page
		// he's not allowed to see when logged in,
		// redirect him to the index!
		if ($logged_out && is_logged_in())
		{
		      echo $this->CI->fungsi->warning('Maaf, sepertinya Anda sudah login...',site_url().'/beranda');
		      die();
		}
		
		// If the user isn' logged in and he's trying to access a page
		// he's not allowed to see when logged out,
		// redirect him to the login page!
		if ( !$logged_out & !is_logged_in()) 
		{
		      echo $this->CI->fungsi->warning('Anda diharuskan untuk Login bila ingin mengakses halaman ini.',site_url());
		      die();
		}
	}
	function logout() 
	{
		$now = date('Y-m-d');
		//$this->CI->db->where('user_id',from_session('user_id'));
		//$this->CI->db->update('user',array('LAST_LOGIN'=>$now));
		$this->CI->session->sess_destroy();	
		return TRUE;
	}
	
	function cek($id,$ret=false)
	{

					//user control for menu
			$this->CI->db->from('menu');
			$q = $this->CI->db->get();
			$menu = array();
			foreach ($q->result() as $r){
				$menu[$r->controller] = $r->id_role;
			}
		
		
		/*
		$menu = array(
		
			//utilitas di controller anggota
			'anggota/getProvinsi'=>'+1+2+',
			'anggota/getKabupaten'=>'+1+2+',
			'anggota/getKecamatan'=>'+1+2+',
			'anggota/getKelurahan'=>'+1+2+'
	
			
		);
				
			*/
		$allowed = explode('+',$menu[$id]);
		
		if(!in_array(from_session('level'),$allowed))
		{
			//if($ret) return false;
			echo $this->CI->fungsi->warning('Anda tidak diijinkan mengakses halaman ini.',site_url());
			die();
		}
		else
		{
			//if($ret) return true;
			return true;
		}
	}
	
	function getUri(){
		$temp = $this->CI->uri->segment(1)."/".$this->CI->uri->segment(2);
		return $temp;
	}
	
	function setChaptcha()
	{
		$this->CI->config->load('config');
		$this->CI->load->helper('string');
		$this->CI->load->plugin('captcha');
		$captcha_url = $this->CI->config->item('captcha_url');
		$captcha_path = $this->CI->config->item('captcha_path');
		$vals = array(
			'img_path'      	=> $captcha_path,
			'img_url'       	=> $captcha_url,
			'expiration'    	=> 3600,// one hour
			'font_path'	 		=> './system/fonts/georgia.ttf',
			'img_width'	 		=> '140',
			'img_height' 		=> 30,
			'word'				=> random_string('numeric', 6),
        	);
		$cap = create_captcha($vals);
		$capdb = array(
			'captcha_id'      	=> '',
			'captcha_time'    	=> $cap['time'],
			'ip_address'      	=> $this->CI->input->ip_address(),
			'word'            	=> $cap['word']
		);
		$query = $this->CI->db->insert_string('captcha', $capdb);
		$this->CI->db->query($query);
		$data['cap'] = $cap;
		return $data;
	}
		
	
}
// End of library class
// Location: system/application/libraries/Auth.php
