<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rss extends CI_Controller {

	public function __construct() 
    {
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('curl');
        
    }

	public function index()
	{
		$data['status'] = "";
		$this->load->view('index',$data);
	}

	public function sharing()
	{
		$this->load->database();
		$this->load->model('rss_m');
		$this->load->library('pagination');

		$data['newstype'] = $this->rss_m->get_newstype();
		$data['subtype'] = $this->rss_m->get_subtype();
		$data['moretype'] = $this->rss_m->get_moretype();
		$data['department'] = $this->rss_m->get_department();
		$data['reporter'] = $this->rss_m->get_reporter();

		$perpage = 20;	
		$data['rows'] = $this->rss_m->count_css_news();
		$data['query'] = $this->rss_m->get_news($this->uri->segment(3),$perpage);
		$data['video_status'] = $this->rss_m->count_vdo($data['query']->result());
		$data['picture_status'] = $this->rss_m->count_picture($data['query']->result());
		$data['voice_status'] = $this->rss_m->count_voice($data['query']->result());
		$data['other_status'] = $this->rss_m->count_other($data['query']->result());

		$this->load->view('sharing',$data);

	}
	public function find()
	{
		$this->load->database();
		$this->load->model('rss_m');
		$data['newstype'] = $this->rss_m->get_newstype();
		$data['subtype'] = $this->rss_m->get_subtype();
		$data['moretype'] = $this->rss_m->get_moretype();
		$data['department'] = $this->rss_m->get_department();
		$data['reporter'] = $this->rss_m->get_reporter();
		if($post = $this->input->post())
		{

			extract($post);
			$perpage = 20;
			$data['query'] = $this->rss_m->search_news_update($this->uri->segment(3),$perpage,$search,$start_date,$end_date,$TypeID,$SubTypeID,$DepartmentID,$UserId,$MoreTypeID);
			$rs = $this->rss_m->count_search_news_update($search,$start_date,$end_date,$TypeID,$SubTypeID,$DepartmentID,$UserId,$MoreTypeID);
			$data['count'] = $rs->row_array();
			$data['rows'] = $rs->num_rows();
			$data['video_status'] = $this->rss_m->count_vdo($data['query']->result());
			$data['picture_status'] = $this->rss_m->count_picture($data['query']->result());
			$data['voice_status'] = $this->rss_m->count_voice($data['query']->result());
			$data['other_status'] = $this->rss_m->count_other($data['query']->result());
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
		$data['rss'] = $this->rss_m->generate_rss_update($search,$start_date,$end_date,$type,$subtype,$department,$reporter,$video,$sound,$image,$other,$user_id,$moretype);
		echo $data['rss'];
	}
	function get_subtype($newstype)
	{
		$this->load->model('rss_m','', TRUE);
		$_data = $this->rss_m->get_newstype_by_subtype($newstype);
		echo json_encode($_data);
	}
	function get_moretype($subtype)
	{
		$this->load->model('rss_m','', TRUE);
		$_data = $this->rss_m->get_subtype_by_moretype($subtype);
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
		$id = $this->input->get('id');
		$data['detail'] = $this->rss_m->get_detail($id);
		$data['get_picture'] = $this->rss_m->get_pic($id);
		$data['get_video'] = $this->rss_m->get_video($id);
		$data['get_voice'] = $this->rss_m->get_voice($id);
		$data['get_other'] = $this->rss_m->get_other($id);
		$data['status'] = $this->rss_m->get_status($id);
		$this->rss_m->insert_count($id);
		$data['count_newsid'] = $this->rss_m->news_count($id);
		$this->load->view('detail',$data);
	}
	public function view_rss()
	{
		$this->load->model('rss_m');
		$data['mainid'] = $this->rss_m->get_rss_mainid($this->uri->segment(3));
		$mainid = $data['mainid']['0']->Main_RssID;
		$statusid = $data['mainid']['0']->Main_Status;
		$data['count_news'] = $this->rss_m->get_rss_newscount($mainid); 
		$count_news = $data['count_news']['0']->count_news;
		$data['newsid'] = $this->rss_m->get_news_rss_default();
		$first_mainid = $this->rss_m->get_first_detail_mainid($mainid);
		$first_mainid = $first_mainid->Detail_RssID;
		for ($i=0; $i < $count_news; $i++) { 
			$this->rss_m->update_rss($mainid,$data['newsid'][$i]->NewsID,$first_mainid);
			$first_mainid++;
		}
		$data['query'] = $this->rss_m->get_rss_newsid($this->uri->segment(3));
		$i = 0;
		foreach($data['query'] as $item)
		{
			$newsid = $item->Detail_NewsID;
			$data['title'][$i] = $this->rss_m->get_rss($newsid);
			$data['picture'][$i] = $this->rss_m->get_pic($newsid);
			$i++;
		}
		$this->load->view('xml',$data);
	}
	public function view_rss_default()
	{
		$this->load->model('rss_m');
		$data['query'] = $this->rss_m->get_news_rss_default();
		$i = 0;
		foreach ($data['query'] as $item) 
		{
			$newsid = $item->NewsID;
			$data['title'][$i] = $this->rss_m->get_rss($newsid);
			$data['picture'][$i] = $this->rss_m->get_pic($newsid);
			$i++;
		}
		$this->load->view('xml_default',$data);
	}
	/*public function login()
	{
		$this->load->model('rss_m');
		$post = array(
					'username' => $this->input->post('username'), 
					'password' => $this->input->post('password'), 
				);
		$authen_source = $this->curl->simple_post('http://111.223.32.9/prdservice/api/authenticate', $post, array(CURLOPT_BUFFERSIZE => 10));
		$authen_source = json_decode($authen_source);
		$authen = $authen_source->Authenticated;
		$user = $authen_source->UserID;
		$username = $authen_source->UserName;
		$data['status'] = "";
		if($authen == "true")
		{
			$data['status'] = "สำเร็จ";
			$this->session->set_userdata('user_id',$user);
			$user_id = $this->session->userdata('user_id');
			$this->session->set_userdata('user_name',$username);
			$this->rss_m->insertlog($user_id);
			redirect(base_url().index_page().'rss/sharing', 'refresh');
			//header('location:sharing');
		}
		else
		{
			$data['status'] = "ไม่พบข้อมูลผู้ใช้งาน";
			$this->load->view('index',$data);
		}
	}*/
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
	public function test_page()
	{
		echo base_url()."<br/>";
		echo site_url();
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */