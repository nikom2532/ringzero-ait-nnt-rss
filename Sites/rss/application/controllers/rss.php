<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rss extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	/*public function index()
	{
		$this->load->view('welcome_message');
		echo "Test new file";
	}*/
	public function index()
	{
		$this->load->view('index');
	}
	public function sharing()
	{
		$this->load->database();
		$this->load->model('rss_m');
		$this->load->library('pagination');
		$config['base_url'] = base_url()."rss/pagination";
		$config['per_page'] = 20;
		$config['num_links'] = 1;

		$config['first_link'] = "<img src='".image_asset_url('table/pev.png')."' style='margin: -5px 10px 0;'>";
		$config['last_link'] = "<img src='".image_asset_url('table/end.png')."' style='margin: -5px 10px 0;'>";
		$config['next_link'] = "<img src='".image_asset_url('table/next.png')."' style='margin: -5px 10px 0;'>";
		$config['prev_link'] = "";

		$data['subtype'] = $this->rss_m->get_newstype();
		$data['query3'] = $this->rss_m->get_subtype();
		$data['query4'] = $this->rss_m->get_department();
		$data['query10'] = $this->rss_m->get_reporter();

		$config['total_rows'] = $this->rss_m->count_css_news();
		$config['display_pages'] = FALSE;
		$this->pagination->initialize($config);
		$data['query9'] = $this->rss_m->count_css_news();
		$data['query'] = $this->rss_m->get_news($this->uri->segment(3),$config['per_page']);
		//var_dump($data['query']->result());
		$data['query5'] = $this->rss_m->count_vdo($data['query']->result());
		$data['query6'] = $this->rss_m->count_picture($data['query']->result());
		$data['query7'] = $this->rss_m->count_voice($data['query']->result());
		$data['query8'] = $this->rss_m->count_other($data['query']->result());

		$data['pagination'] = $this->pagination->create_links();
		$this->load->view('sharing_pagination',$data);
		//}

	}
	public function find()
	{
		$this->load->database();
		$this->load->model('rss_m');
		$this->load->library('pagination');
		$config['base_url'] = base_url()."rss/pagination";
		$config['per_page'] = 20;
		$config['num_links'] = 1;
		$config['first_link'] = "<img src='".image_asset_url('table/pev.png')."' style='margin: -5px 10px 0;'>";
		$config['last_link'] = "<img src='".image_asset_url('table/end.png')."' style='margin: -5px 10px 0;'>";
		$config['next_link'] = "<img src='".image_asset_url('table/next.png')."' style='margin: -5px 10px 0;'>";
		$config['prev_link'] = "";
		$data['subtype'] = $this->rss_m->get_newstype();
		$data['query3'] = $this->rss_m->get_subtype();
		$data['query4'] = $this->rss_m->get_department();
		$data['query10'] = $this->rss_m->get_reporter();
		if($post = $this->input->post())
		{
			extract($post);
			$data['query'] = $this->rss_m->search_news($this->uri->segment(3),$config['per_page'],$search,$start_date,$end_date,$TypeID,$SubTypeID,$DepartmentID,$UserId);
			$rs = $this->rss_m->count_search_news($search,$start_date,$end_date,$TypeID,$SubTypeID,$DepartmentID,$UserId);
			$data['count'] = $rs->row_array();
			$config['total_rows'] = $rs->num_rows();
			$config['display_pages'] = FALSE;
			$this->pagination->initialize($config);
			$data['query9'] = $rs->num_rows();
			$data['query5'] = $this->rss_m->count_vdo($data['query']->result());
			$data['query6'] = $this->rss_m->count_picture($data['query']->result());
			$data['query7'] = $this->rss_m->count_voice($data['query']->result());
			$data['query8'] = $this->rss_m->count_other($data['query']->result());
			$data['pagination'] = $this->pagination->create_links();
			$data['pagination'] = "";
			$this->load->view('find',$data);
		}
		else
		{
			$url = base_url()."rss/sharing";
			header('Location: ../rss/sharing');
		}
	}
	public function rss_feed()
	{
		$this->load->database();
		$this->load->model('rss_m');
		$value = $this->input->post();
		extract($value);
		$user_id = $this->session->userdata('user_id');
		$data['rss'] = $this->rss_m->generate_rss($search,$start_date,$end_date,$type,$subtype,$department,$reporter,$video,$sound,$image,$other,$user_id);
		echo $data['rss'];
	}
	function get_subtype($newstype)
	{
		$this->load->model('rss_m','', TRUE);
		$_data = $this->rss_m->get_newstype_by_subtype($newstype);
		echo json_encode($_data);
	}
	function get_user($userid)
	{
		$this->load->model('rss_m','', TRUE);   
		$_data = $this->rss_m->get_reporter_by_id($userid);
		echo json_encode($_data);
	}
	public function detail()
	{
		$this->load->model('rss_m');
		$data['query'] = $this->rss_m->get_detail();
		$data['query2'] = $this->rss_m->get_pic();
		$data['query3'] = $this->rss_m->get_video();
		$data['query4'] = $this->rss_m->get_voice();
		$data['query5'] = $this->rss_m->get_other();
		//$id['id'] = $this->input->get('id');
		$data['status'] = $this->rss_m->get_status();
		$this->load->view('detail',$data);
	}
	public function view_rss()
	{
		$this->load->model('rss_m');
		$data['query'] = $this->rss_m->get_rss_newsid($this->uri->segment(3));
		$i = 0;
		foreach($data['query'] as $item)
		{
			$newsid = $item->Detail_NewsID;
			$data['title'][$i] = $this->rss_m->get_rss($newsid);
			$i++;
		}
		$this->load->view('test_rss',$data);
	}
	public function login()
	{
		$this->load->model('rss_m');
		$authen = $this->input->post('Authenticated');
		$user = $this->input->post('UserId');
		$username = $this->input->post('Username');
		if($authen == "true")
		{
			echo "Success";
			$this->session->set_userdata('user_id',$user);
			$user_id = $this->session->userdata('user_id');
			$this->session->set_userdata('user_name',$username);
			$this->rss_m->insertlog($user_id);
		}
		else if($authen == "false")
		{
			echo "ไม่พบข้อมูลผู้ใช้งาน";
		}
	}
	public function logout()
	{
		$this->session->sess_destroy();
		$this->load->model('rss_m');
		$lastid['id'] = $this->rss_m->last_log();
		$mainid = "";
		foreach($lastid['id'] as $last)
		{
			$mainid = $last->Log_ID;
		}
		$this->rss_m->updatelog($mainid);
		header('location:index');
	}
	public function test_login()
	{
		$this->load->view('test_login');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */