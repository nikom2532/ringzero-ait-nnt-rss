<?php
class Download_m extends CI_model
{
	public function __construct() 
    {
           parent::__construct(); 
           $this->load->database();
		   $this->db_rss = $this->load->database('NNT_RSSFEED',true);
    }

	public function insert_download_log($filetype,$date,$mem_id,$news_id)
	{
		$ip = 	getenv('HTTP_CLIENT_IP')?:
				getenv('HTTP_X_FORWARDED_FOR')?:
				getenv('HTTP_X_FORWARDED')?:
				getenv('HTTP_FORWARDED_FOR')?:
				getenv('HTTP_FORWARDED')?:
				getenv('REMOTE_ADDR');

		$download_insert = array(
			'DownloadLog_Type'	=> $filetype,
			'DownloadLog_Date'	=> $date,
			'DownloadLog_IP'	=> $ip,
			'News_ID'			=> $news_id,
			'Mem_ID'			=> $mem_id
		);
		$this->db_rss->insert('DownloadLog',$download_insert);
	}
}  
?>