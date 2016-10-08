<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Msjabatan extends CI_Controller {
	
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
			$this->load->model('msjabatanmodel','msjabatan');
    }	
	
	public function index()
	{
		
		if(!is_logged_in())
		{
			redirect('login');
		}
		else
		{	
			$this->list_jabatan();
		}
		
	}

	public function ajax_list()
	{
		$list = $this->msjabatan->get_datatables();
		$data = array();
		$no = $_POST['start'];
		
		foreach ($list->result() as $msuser){
			$no++;
			$row = array();
			
			$row[] = $msjabatan->RecordID;
			$row[] = $msjabatan->Jabatan;

			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void()" title="Edit" onclick="edit_person('."'".$msjabatan->RecordID."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void()" title="Hapus" onclick="delete_person('."'".$msjabatan->RecordID."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->msjabatan->count_all(),
						"recordsFiltered" => $this->msjabatan->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);//
	}
	
	private function list_jabatan()
	{
		
		$data['username'] = $this->session->userdata('username');
		$data['nama_lengkap'] = $this->session->userdata('nama_lengkap');
		$data['email'] = $this->session->userdata('email');
		$data['address'] = $this->session->userdata('address');
		$data['phone'] = $this->session->userdata('phone');
		
		$data['title']="<i class=\"fa fa-user fa-fw\"></i> Master Data Jabatan";
		$data['subtitle']=" Master Data / Jabatan";
		$data['tabletitle']="Table Master Data Jabatan";
		$data['navigasi']="<li><a href=\"#\"><i class=\"fa fa-dashboard\"></i> Home</a></li>
            <li><a href=\"#\">Data Master</a></li>
            <li class=\"active\">Jabatan</li>";
		$this->load->view('header',$data);
		$this->load->view('leftsidebar',$data);
		$this->load->view('msjabatan/list_jabatan',$data);
		$this->load->view('footer');
		$this->load->view('rightsidebar');
		
	}
	
	function load_grid()
	{
		
		$id_user = $this->session->userdata('user_id');
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
 		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 1000;
		$data = isset($_POST['data']) ? mysql_real_escape_string($_POST['data']) : '';  
 		$offset = ($page-1)*$rows;
		$this->mscalendar->limit = $rows;
 		$this->mscalendar->offset = $offset;
		$this->mscalendar->load_grid($data,$id_user);
	}
	
	function add_calendar_modal()
	{
		
		$data['username'] = $this->session->userdata('username');
		$data['nama_lengkap'] = $this->session->userdata('nama_lengkap');
		$data['email'] = $this->session->userdata('email');
		$data['address'] = $this->session->userdata('address');
		$data['phone'] = $this->session->userdata('phone');
		
		$this->load->view('mscalendar/add_calendar_modal',$data);
		
	}
	
	function add_calendar()
	{
		
		$data['username'] = $this->session->userdata('username');
		$data['nama_lengkap'] = $this->session->userdata('nama_lengkap');
		$data['email'] = $this->session->userdata('email');
		$data['address'] = $this->session->userdata('address');
		$data['phone'] = $this->session->userdata('phone');
		
		$this->load->library('form_validation');
		$data['title']="<i class=\"fa fa-user fa-fw\"></i> Master Data Tugas";
		$data['subtitle']=" Tugas / Karyawan";
		$data['tabletitle']="Table Master Data Tugas";
		$data['navigasi']="<li><a href=\"#\"><i class=\"fa fa-dashboard\"></i> Home</a></li>
            <li><a href=\"#\">Data Master</a></li>
            <li class=\"active\">Tambah Tugas</li>";
		
		if(!is_logged_in())
		{
			redirect('login');
		}
		else
		{
		
			$this->load->view('header',$data);
			$this->load->view('leftsidebar');
			$this->load->view('mscalendar/add_calendar');
			$this->load->view('footer');
			$this->load->view('rightsidebar');
			
		}
		
	}
	
	/* edit data */
	function edit_tugas()
	{
		
		$data['username'] = $this->session->userdata('username');
		$data['nama_lengkap'] = $this->session->userdata('nama_lengkap');
		$data['email'] = $this->session->userdata('email');
		$data['address'] = $this->session->userdata('address');
		$data['phone'] = $this->session->userdata('phone');
		
		$this->load->library('form_validation');
		$data['title']="<i class=\"fa fa-user fa-fw\"></i> Master Data Tugas";
		$data['subtitle']=" Tugas / Karyawan";
		$data['tabletitle']="Table Master Data Tugas";
		$data['navigasi']="<li><a href=\"#\"><i class=\"fa fa-dashboard\"></i> Home</a></li>
            <li><a href=\"#\">Data Master</a></li>
            <li class=\"active\">Edit Tugas</li>";
		
		$id = $this->uri->segment(3);
	
		if(!is_logged_in())
		{
			redirect('login');
		}
		else
		{
		
			if($this->mstugas->getTugasById($id)->num_rows()>0)
			{
				
				$data['data'] =  $this->mstugas->gettugasById($id);
				
				$this->load->view('header',$data);
				$this->load->view('leftsidebar');
				$this->load->view('mstugas/edit_tugas',$data);
				$this->load->view('footer');
				$this->load->view('rightsidebar');
			
			}
			else
			{
				$this->session->set_flashdata('notif', '<div class="alert-box warning"><span>Perhatian: </span> Data Yang Anda Cari Tidak Ada.</div>');
				redirect('mstugas');
			}
		}
	}
	/* end edit data */
	
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
			$this->form_validation->set_error_delimiters('<h4><i class="fa fa-info"></i>  Perhatian :</h4><div class="callout callout-info" style="margin-bottom: 0!important;"><div class="alert-box warning">', '</span></div></div>');
						
			$this->form_validation->set_rules('ednamatugas', 'Nama Tugas', 'required');
			$this->form_validation->set_rules('cbojenistugas', 'Jenis Tugas', 'required');			
									
			if ($this->form_validation->run() == FALSE) 
			{
						
				$data['title']="<i class=\"fa fa-user fa-fw\"></i> Master Data Tugas";
				$data['subtitle']=" Tugas / Karyawan";
				$data['tabletitle']="Table Master Data Tugas";
				$data['navigasi']="<li><a href=\"#\"><i class=\"fa fa-dashboard\"></i> Home</a></li>
				<li><a href=\"#\">Data Master</a></li>
				<li class=\"active\">Tugas</li>";
			
				$this->load->view('header.php',$data);
				$this->load->view('leftsidebar');
				$this->load->view('mstugas/add_tugas',$data);
				$this->load->view('footer.php');
				$this->load->view('rightsidebar');
			
			} 
			else 
			{  
		
				$id_user = $this->session->userdata('user_id');
				$namatugas = $this->input->post('ednamatugas');
				$jenistugas = $this->input->post('cbojenistugas');
				$deskripsi = $this->input->post('memodeskripsi');
				$detail = $this->input->post('memodetail');
				$persetujuan = $this->input->post('cbopersetujuan');
				$tanggal = $this->input->post('dttanggaltugas');
				$status = $this->input->post('edstatus');
								
				date_default_timezone_set('Asia/Jakarta');
				$tanggal = date("Y-m-d H:i:s");
				
				$this->mstugas->save($id_user,$namatugas,$jenistugas,$deskripsi,$detail,$persetujuan,$tanggal,$status);
				
				$this->session->set_flashdata('notif', '<div class="alert-box success"><span>Sukses: </span> Data User Berhasil Disimpan.</div>');
				redirect('mstugas');
				
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
						
			$this->form_validation->set_rules('ednamatugas', 'Nama Tugas', 'required');
			$this->form_validation->set_rules('cbojenistugas', 'Jenis Tugas', 'required');	
			
			if ($this->form_validation->run() == FALSE) 
			{
						
				$id = $this->input->post('id_tugas');
				$data['data'] =  $this->mstugas->gettugasById($id);
				
				$this->load->view('header',$data);
				$this->load->view('leftsidebar');
				$this->load->view('mstugas/edit_tugas',$data);
				$this->load->view('footer');
				$this->load->view('rightsidebar');
						
			} 
			else 
			{  
						
				$id_tugas = $this->input->post('id_tugas');
				
				$namatugas = $this->input->post('ednamatugas');
				$jenistugas = $this->input->post('cbojenistugas');
				$deskripsi = $this->input->post('memodeskripsi');
				$detail = $this->input->post('memodetail');
				$persetujuan = $this->input->post('cbopersetujuan');
				$tanggal = $this->input->post('dttanggaltugas');
				$status = $this->input->post('edstatus');
								
				date_default_timezone_set('Asia/Jakarta');
				$tanggal = date("Y-m-d H:i:s");
				
				$this->mstugas->update($namatugas,$jenistugas,$deskripsi,$detail,$persetujuan,$tanggal,$status,$id_tugas);
				$this->session->set_flashdata('notif', '<div class="alert-box success"><span>Sukses: </span> Data tugas Berhasil Diubah.</div>');
				redirect('mstugas');
				
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
				
				$this->mstugas->delete($id);
				$this->session->set_flashdata('notif', '<div class="alert-box success"><span>Sukses: </span> Data tugas Dengan ID '.$id.' Berhasil Dihapus.</div>');
				redirect('mstugas');	
				
			}
		}
	}
	
	/* end delete data */
		
	function load_tugas_detail(){
		$id = $this->uri->segment(3);
		$data['list'] = $this->mstugas->getTugasById($id);
		$this->load->view('mstugas/list_tugas_detail',$data);
	}
	
	public function ajax_add()
	{
		
		$this->_validate();
		$data = array(
				'title' => $this->input->post('edtitle'),
				'start' => $this->input->post('edstart'),
				'end' => $this->input->post('edend'),
			);
			
		$insert = $this->mscalendar->save($data);
		echo json_encode(array("status" => TRUE));
		
	}
	
	public function ajax_edit($id)
	{
		$data = $this->mscalendar->get_by_id($id);
		echo json_encode($data);
	}
	
	public function ajax_update()
	{
	
		$this->_validate();	
		$data = array(
				'id' => $this->input->post('id'),
				'title' => $this->input->post('edtitle'),
				'start' => $this->input->post('edstart'),
				'end' => $this->input->post('edend'),
			);
		
		$this->mscalendar->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	
	}
	
	public function ajax_delete($id)
	{
		$this->mscalendar->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}
	
	function load_calendar_detail()
	{
		$id = $this->uri->segment(3);
		$data['list'] = $this->mscalendar->getCalendarById($id);
		$this->load->view('mscalendar/list_calendar_detail',$data);
	}
	
	private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('edtitle') == '')
        {
            $data['inputerror'][] = 'edtitle';
            $data['error_string'][] = 'Title harus diisi!!';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('edstart') == '')
        {
            $data['inputerror'][] = 'edstart';
            $data['error_string'][] = 'Tanggal awal harus diisi!!';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('edend') == '')
        {
            $data['inputerror'][] = 'edend';
            $data['error_string'][] = 'Tanggal akhir harus diisi!!';
            $data['status'] = FALSE;
        }
 
        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
		
    }
		
}

/* End of file mstugas.php */
/* Location: ./application/controllers/mstugas.php */