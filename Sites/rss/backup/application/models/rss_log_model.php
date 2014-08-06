<?php
class Rss_m extends CI_model
{
	public function __construct() 
    {
           parent::__construct(); 
           $this->load->database();
		   $this->load->database('NNT_RSSFEED',true);
    }
	public function insertlog()
	{
		$data = array(
		   'test_name' =>  $this->input->post('name'),
		   'test_value' => $this->input->post('value')
		);
		$this->db->insert('test', $data); 
	}
}  
?>