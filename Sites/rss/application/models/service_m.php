<?php
class Service_m extends CI_model
{
	public function __construct() 
    {
           parent::__construct(); 
           $this->load->database();
    }

	public function get_category($cate)
	{
		$query = $this->db->select('TOP 20 NT01_NewsID,NT01_NewsTitle,NT01_NewsDesc,NT01_NewsDate,NT01_ReporterID,NT01_ReWriteID')
				 ->where('NT02_TypeID',$cate)
				 ->order_by('NT01_NewsDate')
				 ->get('[NNT_DataCenter_2].dbo.NT01_News');
		return $query->result();
	}

	public function find_picture($newsid)
	{
		$query = $this->db->select('NT01_NewsID,NT11_PicPath,NT11_PicID,NT11_PicName')
				->where('NT01_NewsID',$newsid)
				->get('[NNT_DataCenter_2].dbo.NT11_Picture');
		return $query->result();
	}

	public function find_user($userid)
	{
		$query	= $this->db->select('SC03_UserId,SC03_FName')
				->where('SC03_UserId',$userid)
				->get('SC03_User');
		return $query->result();
	}
}  
?>