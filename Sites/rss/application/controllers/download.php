<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Download extends CI_Controller {

	public function __construct() 
    {
		parent::__construct();
		$this->load->model('download_m');
		$this->load->helper('url');
        
    }

	public function download_video()
	{
		$file = $this->input->get('file');
		$news_id = $this->input->get('newsid');
		$mem_id = $this->session->userdata('user_id');
		$file_type = "video";
		$date = date("Y-m-d H:i:s");
		$this->download_m->insert_download_log($file_type,$date,$mem_id,$news_id);
		redirect($file);
	}

	public function download_audio()
	{
		$file = $this->input->get('file');
		$news_id = $this->input->get('newsid');
		$mem_id = $this->session->userdata('user_id');
		$file_type = "audio";
		$date = date("Y-m-d H:i:s");
		$this->download_m->insert_download_log($file_type,$date,$mem_id,$news_id);
		redirect($file);
	}

	public function download_picture()
	{
		$file = $this->input->get('file');
		$news_id = $this->input->get('newsid');
		$mem_id = $this->session->userdata('user_id');
		$file_type = "picture";
		$date = date("Y-m-d H:i:s");
		$this->download_m->insert_download_log($file_type,$date,$mem_id,$news_id);
		redirect($file);
	}

	public function download_otherfile()
	{
		$file = $this->input->get('file');
		$news_id = $this->input->get('newsid');
		$mem_id = $this->session->userdata('user_id');
		$file_type = "other";
		$date = date("Y-m-d H:i:s");
		$this->download_m->insert_download_log($file_type,$date,$mem_id,$news_id);
		redirect($file);
	}
}
