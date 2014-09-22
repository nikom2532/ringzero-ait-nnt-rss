<?php
class Rss_m extends CI_model
{
	public function __construct() 
    {
           parent::__construct(); 
           $this->load->database();
		   $this->db_rss = $this->load->database('NNT_RSSFEED',true);
    }
	public function get_newstype()
	{
		$query = $this->db->select('NT02_TypeID,NT02_TypeName')->get('[NNT_DataCenter_2].dbo.NT02_NewsType');
		return $query->result();
	}
	public function get_subtype()
	{
		$query = $this->db->select('NT03_SubTypeID,NT03_SubTypeName')->get('[NNT_DataCenter_2].dbo.NT03_NewsSubType');
		return $query->result();
	}
	public function get_moretype()
	{
		$query = $this->db->select('NT06_MoreTypeID,NT06_MoreTypeName')->get('[NNT_DataCenter_2].dbo.NT06_MoreType');
		return $query->result();
	}
	public function get_newstype_by_subtype($newstype)
	{
        $this->db->select('NT03_SubTypeID, NT03_SubTypeName');
        $this->db->where('NT02_TypeID', $newstype);
        return $query = $this->db->get('[NNT_DataCenter_2].dbo.NT03_NewsSubType')->result();
    }
    public function get_subtype_by_moretype($subtype)
    {
    	$this->db->select('NT06_MoreTypeID,NT06_MoreTypeName');
    	$this->db->where('NT03_SubTypeID', $subtype);
    	return $query = $this->db->get('[NNT_DataCenter_2].dbo.NT06_MoreType')->result();
    } 
	public function get_department()
	{
		$query = $this->db->select('SC07_DepartmentId,SC07_DepartmentName')->order_by('SC07_DepartmentSeq')->get('[NNT_DataCenter_2].dbo.View_RSS_department');
		return $query->result();
	}
	public function get_reporter()
	{
		$query = $this->db->select('SC03_UserId,Name')->get('[NNT_DataCenter_2].dbo.View_RSS_Reporter');
		return $query->result();
	}
	public function get_reporter_by_id($userid)
	{
		$this->db->select('SC03_UserId,Name');
        $this->db->where('SC07_DepartmentId', $userid);
        return $query = $this->db->get('[NNT_DataCenter_2].dbo.View_RSS_Reporter')->result();
	}
	public function count_vdo($news)
	{
		if($news == NULL || $news == "0")
		{
			return 0;
		}
		else
		{
			$i = 0;
			foreach ($news as $item5){;
				$id = $item5->NewsID;
				$this->db->select('[NT01_NewsID]');
				$this->db->from('[NNT_DataCenter_2].[dbo].[View_RSS_VDO]');
				$this->db->where("NT01_NewsID='".$id."'");
				$query = $this->db->get();
				$rowcount[$i] = $query->num_rows();
				$i++;
			}
			return $rowcount;
		}
	}
	public function count_picture($news)
	{
		if($news == NULL || $news == "0")
		{
			return 0;
		}
		else
		{
			$i = 0;
			foreach ($news as $item6){;
				$id = $item6->NewsID;
				$this->db->select('NT01_NewsID');
				$this->db->from('View_RSS_Picture');
				$this->db->where("NT01_NewsID='".$id."'");
				$query = $this->db->get();
				$rowcount[$i] = $query->num_rows();
				$i++;
			}
			return $rowcount;
		}
	}
	public function count_voice($news)
	{
		if($news == NULL || $news == "0")
		{
			return 0;
		}
		else
		{
			$i = 0;
			foreach ($news as $item6){;
				$id = $item6->NewsID;
				$this->db->select('NT01_NewsID');
				$this->db->from('View_RSS_Voice');
				$this->db->where("NT01_NewsID='".$id."'");
				$query = $this->db->get();
				$rowcount[$i] = $query->num_rows();
				$i++;
			}
			return $rowcount;
		}
	}
	public function count_other($news)
	{
		if($news == NULL || $news == "0")
		{
			return 0;
		}
		else
		{
			$i = 0;
			foreach ($news as $item6){;
				$id = $item6->NewsID;
				$this->db->select('NT01_NewsID');
				$this->db->from('View_RSS_OtherFile');
				$this->db->where("NT01_NewsID='".$id."'");
				$query = $this->db->get();
				$rowcount[$i] = $query->num_rows();
				$i++;
			}
			return $rowcount;
		}
	}
	public function get_news($page,$seg)
	{
		if($page == "" || $page == NULL)
		{
			$page = 20;
			$bet = 1;
		}
		else if($page == "20")
		{
			$page = 40;
			$bet = 21;
		}
		else
		{	
			$page = $page + 20;
			$bet = $page - 19;
		}
		$query = "WITH row AS 
		(
			SELECT TOP $page View_RSS_news.NewsID, ROW_NUMBER() OVER (ORDER BY Date DESC) AS 'RowNumber',
			View_RSS_news.Date, View_RSS_news.Title, View_RSS_news.Reporter 
			from [NNT_DataCenter_2].dbo.View_RSS_news
		)
		SELECT DISTINCT * FROM row WHERE RowNumber BETWEEN $bet AND $page ;";
		return $this->db->query($query); 
	}
	public function search_news_update($page,$seg,$sea,$ssd,$esd = NULL,$ty,$sty,$di,$ui,$mty)
	{
		/*echo "MoreID : ".$mty."<br/>";
		echo "UserID : ".$ui."<br>";
		echo "DepartmentID : ".$di."<br>";
		echo "SubTypeID : ".$sty."<br>";
		echo "TypeID : ".$ty."<br>";
		echo "StartDate : ".$ssd."<br>";
		echo "EndDate : ".$esd."<br>";
		echo "Keyword : ".$sea."<br>";*/
		$sd = date("Y-m-d",strtotime($ssd))." 00:00:00.000";
		$ed = date("Y-m-d",strtotime($esd))." 23:59:59.999";
		if($page == "" || $page == NULL)
		{
			$page = 20;
			$bet = 1;
		}
		else if($page == "20")
		{
			$page = 40;
			$bet = 21;
		}
		else
		{	
			$page = $page + 20;
			$bet = $page - 20;
		}
		$query = "";
		if($ui != "")
		{
			$query = "WITH row AS 
			(
				SELECT TOP $page View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title, View_RSS_news.Reporter
				FROM View_RSS_news 
				WHERE Reporter = 
				(
					SELECT View_RSS_Reporter.Name
					FROM View_RSS_Reporter
					WHERE View_RSS_Reporter.SC03_UserId = '$ui'";
					if($di != "")
					{
						$query .= " AND Department = 
						(	
							SELECT View_RSS_department.SC07_DepartmentName 
							FROM View_RSS_department
							WHERE View_RSS_department.SC07_DepartmentId = '$di'
						)";
					}
					if($mty != "")
					{
						$query .= " AND NT06_MoreTypeID = '$mty'";
					}
					if($sty != "")
					{
						$query .= " AND NT03_SubTypeID = '$sty'";
					}
					if($ty != "")
					{
						$query .= " AND NT02_TypeID = '$ty'";
					}
					if($ssd != "")
					{
						$query .= " AND CONVERT(VARCHAR(23),View_RSS_news.Date,121) >= '$sd'";
					}
					if($esd != "")
					{
						$query .= " AND CONVERT(VARCHAR(23),View_RSS_news.Date,121) <= '$ed'";
					}
					if($sea != "")
					{
						$query .= " AND View_RSS_news.Title LIKE '%$sea%'";
					}
				$query .= ")";
			$query .= ")";
			$query .= "SELECT DISTINCT * 
			FROM row 
			WHERE RowNumber 
			BETWEEN $bet AND $page;";
			//echo $query;
			return $this->db->query($query);
		}
		else if($di != "")
		{
			$query = "WITH row AS 
			(
				SELECT TOP $page View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title, View_RSS_news.Reporter 
				FROM View_RSS_news
				WHERE Department = 
				(	
					SELECT View_RSS_department.SC07_DepartmentName 
					FROM View_RSS_department
					WHERE View_RSS_department.SC07_DepartmentId = '$di'";
					if($mty != "")
					{
						$query .= " AND NT06_MoreTypeID = '$mty'";
					}
					if($sty != "")
					{
						$query .= " AND NT03_SubTypeID = '$sty'";
					}
					if($ty != "")
					{
						$query .= " AND NT02_TypeID = '$ty'";
					}
					if($ssd != "")
					{
						$query .= " AND CONVERT(VARCHAR(23),View_RSS_news.Date,121) >= '$sd'";
					}
					if($esd != "")
					{
						$query .= " AND CONVERT(VARCHAR(23),View_RSS_news.Date,121) <= '$ed'";
					}
					if($sea != "")
					{
						$query .= " AND View_RSS_news.Title LIKE '%$sea%'";
					}
				$query .= ")";
			$query .= ")";
			$query .= "SELECT DISTINCT * 
			FROM row 
			WHERE RowNumber 
			BETWEEN $bet AND $page;";
			//echo $query;
			return $this->db->query($query); 
		}
		else if($mty != "") 
		{
			
			$query = "WITH row AS 
			(
				SELECT TOP $page View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title, View_RSS_news.Reporter 
				FROM View_RSS_news
				WHERE NT06_MoreTypeID = '$mty'";
				if($sty != "")
				{
					$query .= " AND NT03_SubTypeID = '$sty'";
				}
				if($ty != "")
				{
					$query .= " AND NT02_TypeID = '$ty'";
				}
				if($ssd != "")
				{
					$query .= " AND CONVERT(VARCHAR(23),View_RSS_news.Date,121) >= '$sd'";
				}
				if($esd != "")
				{
					$query .= " AND CONVERT(VARCHAR(23),View_RSS_news.Date,121) <= '$ed'";
				}
				if($sea != "")
				{
						$query .= " AND View_RSS_news.Title LIKE '%$sea%'";
				}
			$query .= ")";
			$query .= "SELECT DISTINCT * 
			FROM row 
			WHERE RowNumber 
			BETWEEN $bet AND $page;";
			//echo $query;
			return $this->db->query($query);	
		}
		else if($sty != "")
		{
			$query = "WITH row AS 
			(
				SELECT TOP $page View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title, View_RSS_news.Reporter 
				FROM View_RSS_news
				WHERE NT03_SubTypeID = '$sty'";
				if($ty != "")
				{
					$query .= " AND NT02_TypeID = '$ty'";
				}
				if($ssd != "")
				{
					$query .= " AND CONVERT(VARCHAR(23),View_RSS_news.Date,121) >= '$sd'";
				}
				if($esd != "")
				{
					$query .= " AND CONVERT(VARCHAR(23),View_RSS_news.Date,121) <= '$ed'";
				}
				if($sea != "")
				{
						$query .= " AND View_RSS_news.Title LIKE '%$sea%'";
				}
			$query .= ")";
			$query .= "SELECT DISTINCT * 
			FROM row 
			WHERE RowNumber 
			BETWEEN $bet AND $page;";
			//echo $query;
			return $this->db->query($query); 
		}
		else if($ty != "")
		{
			$query = "WITH row AS 
			(
				SELECT TOP $page View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title, View_RSS_news.Reporter 
				FROM View_RSS_news
				WHERE NT02_TypeID = '$ty'";
				if($ssd != "")
				{
					$query .= " AND CONVERT(VARCHAR(23),View_RSS_news.Date,121) >= '$sd'";
				}
				if($esd != "")
				{
					$query .= " AND CONVERT(VARCHAR(23),View_RSS_news.Date,121) <= '$ed'";
				}
				if($sea != "")
				{
					$query .= " AND View_RSS_news.Title LIKE '%$sea%'";
				}
				$query .= ")";
			$query .= "SELECT DISTINCT * 
			FROM row 
			WHERE RowNumber 
			BETWEEN $bet AND $page;";
			//echo $query;
			return $this->db->query($query); 	
		}
		else if($ssd != "")
		{
			$query = "WITH row AS 
			(
				SELECT TOP $page View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title, View_RSS_news.Reporter 
				FROM View_RSS_news
				WHERE CONVERT(VARCHAR(23),View_RSS_news.Date,121) >= '$sd'";
				if($esd != "")
				{
					$query .= " AND CONVERT(VARCHAR(23),View_RSS_news.Date,121) <= '$ed'";
				}
				if($sea != "")
				{
					$query .= " AND View_RSS_news.Title LIKE '%$sea%'";
				}
				$query .= ")";
			$query .= "SELECT DISTINCT * 
			FROM row 
			WHERE RowNumber 
			BETWEEN $bet AND $page;";
			//echo $query;
			return $this->db->query($query);
		}
		else if($esd != "")
		{
			$query = "WITH row AS 
			(
				SELECT TOP $page View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title, View_RSS_news.Reporter 
				FROM View_RSS_news
				WHERE CONVERT(VARCHAR(23),View_RSS_news.Date,121) <= '$ed'";
				if($sea != "")
				{
					$query .= " AND View_RSS_news.Title LIKE '%$sea%'";
				}
				$query .= ")";
			$query .= "SELECT DISTINCT * 
			FROM row 
			WHERE RowNumber 
			BETWEEN $bet AND $page;";
			//echo $query;
			return $this->db->query($query);	
		}
		else
		{
			$query = "WITH row AS 
			(
				SELECT TOP $page View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title, View_RSS_news.Reporter 
				FROM View_RSS_news
				WHERE Title LIKE '%$sea%' 
			)
			SELECT DISTINCT * 
			FROM row 
			WHERE RowNumber
			BETWEEN $bet AND $page;";
			//echo $query;
			return $this->db->query($query);
		}
	}
	public function count_search_news_update($sea,$ssd,$esd = NULL,$ty,$sty,$di,$ui,$mty)
	{
		$sd = date("Y-m-d",strtotime($ssd))." 00:00:00.000";
		$ed = date("Y-m-d",strtotime($esd))." 23:59:59.999";
		$query = "";
		if($ui != "")
		{
			$query = "WITH row AS 
			(
				SELECT View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title 
				FROM View_RSS_news 
				WHERE Reporter = 
				(
					SELECT View_RSS_Reporter.Name
					FROM View_RSS_Reporter
					WHERE View_RSS_Reporter.SC03_UserId = '$ui'";
					if($di != "")
					{
						$query .= " AND Department = 
						(	
							SELECT View_RSS_department.SC07_DepartmentName 
							FROM View_RSS_department
							WHERE View_RSS_department.SC07_DepartmentId = '$di'
						)";
					}
					if($mty != "")
					{
						$query .= " AND NT06_MoreTypeID = '$mty'";
					}
					if($sty != "")
					{
						$query .= " AND NT03_SubTypeID = '$sty'";
					}
					if($ty != "")
					{
						$query .= " AND NT02_TypeID = '$ty'";
					}
					if($ssd != "")
					{
						$query .= " AND CONVERT(VARCHAR(23),View_RSS_news.Date,121) >= '$sd'";
					}
					if($esd != "")
					{
						$query .= " AND CONVERT(VARCHAR(23),View_RSS_news.Date,121) <= '$ed'";
					}
					if($sea != "")
					{
						$query .= " AND View_RSS_news.Title LIKE '%$sea%'";
					}
				$query .= ")";
			$query .= ")";
			$query .= "SELECT DISTINCT * 
			FROM row ";
			//echo $query;
			return $this->db->query($query);
		}
		else if($di != "")
		{
			$query = "WITH row AS 
			(
				SELECT View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title 
				FROM View_RSS_news
				WHERE Department = 
				(	
					SELECT View_RSS_department.SC07_DepartmentName 
					FROM View_RSS_department
					WHERE View_RSS_department.SC07_DepartmentId = '$di'";
					if($mty != "")
					{
						$query .= " AND NT06_MoreTypeID = '$mty'";
					}
					if($sty != "")
					{
						$query .= " AND NT03_SubTypeID = '$sty'";
					}
					if($ty != "")
					{
						$query .= " AND NT02_TypeID = '$ty'";
					}
					if($ssd != "")
					{
						$query .= " AND CONVERT(VARCHAR(23),View_RSS_news.Date,121) >= '$sd'";
					}
					if($esd != "")
					{
						$query .= " AND CONVERT(VARCHAR(23),View_RSS_news.Date,121) <= '$ed'";
					}
					if($sea != "")
					{
						$query .= " AND View_RSS_news.Title LIKE '%$sea%'";
					}
				$query .= ")";
			$query .= ")";
			$query .= "SELECT DISTINCT * 
			FROM row ";
			//echo $query;
			return $this->db->query($query); 
		}
		else if($mty != "") 
		{
			
			$query = "WITH row AS 
			(
				SELECT View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title, View_RSS_news.Reporter 
				FROM View_RSS_news
				WHERE NT06_MoreTypeID = '$mty'";
				if($sty != "")
				{
					$query .= " AND NT03_SubTypeID = '$sty'";
				}
				if($ty != "")
				{
					$query .= " AND NT02_TypeID = '$ty'";
				}
				if($ssd != "")
				{
					$query .= " AND CONVERT(VARCHAR(23),View_RSS_news.Date,121) >= '$sd'";
				}
				if($esd != "")
				{
					$query .= " AND CONVERT(VARCHAR(23),View_RSS_news.Date,121) <= '$ed'";
				}
				if($sea != "")
				{
						$query .= " AND View_RSS_news.Title LIKE '%$sea%'";
				}
			$query .= ")";
			$query .= "SELECT DISTINCT * 
			FROM row ";
			//echo $query;
			return $this->db->query($query);	
		}
		else if($sty != "")
		{
			$query = "WITH row AS 
			(
				SELECT View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title 
				FROM View_RSS_news
				WHERE NT03_SubTypeID = '$sty'";
				if($ty != "")
				{
					$query .= " AND NT02_TypeID = '$ty'";
				}
				if($ssd != "")
				{
					$query .= " AND CONVERT(VARCHAR(23),View_RSS_news.Date,121) >= '$sd'";
				}
				if($esd != "")
				{
					$query .= " AND CONVERT(VARCHAR(23),View_RSS_news.Date,121) <= '$ed'";
				}
				if($sea != "")
				{
						$query .= " AND View_RSS_news.Title LIKE '%$sea%'";
				}
			$query .= ")";
			$query .= "SELECT DISTINCT * 
			FROM row ";
			//echo $query;
			return $this->db->query($query); 
		}
		else if($ty != "")
		{
			$query = "WITH row AS 
			(
				SELECT View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title 
				FROM View_RSS_news
				WHERE NT02_TypeID = '$ty'";
				if($ssd != "")
				{
					$query .= " AND CONVERT(VARCHAR(23),View_RSS_news.Date,121) >= '$sd'";
				}
				if($esd != "")
				{
					$query .= " AND CONVERT(VARCHAR(23),View_RSS_news.Date,121) <= '$ed'";
				}
				if($sea != "")
				{
					$query .= " AND View_RSS_news.Title LIKE '%$sea%'";
				}
				$query .= ")";
			$query .= "SELECT DISTINCT * 
			FROM row ";
			//echo $query;
			return $this->db->query($query); 	
		}
		else if($ssd != "")
		{
			$query = "WITH row AS 
			(
				SELECT View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title 
				FROM View_RSS_news
				WHERE CONVERT(VARCHAR(23),View_RSS_news.Date,121) >= '$sd'";
				if($esd != "")
				{
					$query .= " AND CONVERT(VARCHAR(23),View_RSS_news.Date,121) <= '$ed'";
				}
				if($sea != "")
				{
					$query .= " AND View_RSS_news.Title LIKE '%$sea%'";
				}
				$query .= ")";
			$query .= "SELECT DISTINCT * 
			FROM row ";
			//echo $query;
			return $this->db->query($query);
		}
		else if($esd != "")
		{
			$query = "WITH row AS 
			(
				SELECT View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title 
				FROM View_RSS_news
				WHERE CONVERT(VARCHAR(23),View_RSS_news.Date,121) <= '$ed'";
				if($sea != "")
				{
					$query .= " AND View_RSS_news.Title LIKE '%$sea%'";
				}
				$query .= ")";
			$query .= "SELECT DISTINCT * 
			FROM row ";
			//echo $query;
			return $this->db->query($query);	
		}
		else
		{
			$query = "WITH row AS 
			(
				SELECT View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title 
				FROM View_RSS_news
				WHERE Title LIKE '%$sea%' 
			)
			SELECT DISTINCT * 
			FROM row"; 
			//echo $query;
			return $this->db->query($query);
		}
	}
	public function generate_rss_update($sea,$ssd,$esd = NULL,$ty,$sty,$di,$ui,$vdo,$voice,$pic,$other,$userid,$mty)
	{
		$sd = date("Y-m-d",strtotime($ssd))." 00:00:00.000";
		$ed = date("Y-m-d",strtotime($esd))." 23:59:59.999";
		$today = date("Y-m-d H:i:s");
		$mainid = "";
		$news_count = 0;
		if($ssd == NULL || $esd == NULL)
		{
			$query = 
				"INSERT INTO [NNT_RSSFEED].dbo.Main_RSS(Main_UserID,Main_Date,Main_CountNews,Main_StatusVDO,Main_StatusVoice,Main_StatusPicture,Main_StatusOther)
				 VALUES ('$userid','$today',20,'$vdo','$voice','$pic','$other');";
			$news_count = 20;
		}
		else
		{
			$query = 
				"INSERT INTO [NNT_RSSFEED].dbo.Main_RSS(Main_UserID,Main_Date,Main_CountNews,Main_StatusVDO,Main_StatusVoice,Main_StatusPicture,Main_StatusOther)
				 VALUES ('$userid','$today',100,'$vdo','$voice','$pic','$other');";
			$news_count = 100;
		}
		$this->db_rss->query($query);
		if($ui != "")
		{
			$status = 8;
			$query = "
				SELECT TOP $news_count NewsID,NT02_TypeID,NT03_SubTypeID 
				FROM View_RSS_news 
				WHERE Reporter = 
				(
					SELECT View_RSS_Reporter.Name
					FROM View_RSS_Reporter
					WHERE View_RSS_Reporter.SC03_UserId = '$ui'
				)";
					if($di != "")
					{
						$query .= " AND Department = 
						(	
							SELECT View_RSS_department.SC07_DepartmentName 
							FROM View_RSS_department
							WHERE View_RSS_department.SC07_DepartmentId = '$di'
						)";
					}
					if($mty != "")
					{
						$query .= " AND NT06_MoreTypeID = '$mty'";
					}
					if($sty != "")
					{
						$query .= " AND NT03_SubTypeID = '$sty'";
					}
					if($ty != "")
					{
						$query .= " AND NT02_TypeID = '$ty'";
					}
					if($ssd != "")
					{
						$query .= " AND CONVERT(VARCHAR(23),View_RSS_news.Date,121) >= '$sd'";
					}
					if($esd != "")
					{
						$query .= " AND CONVERT(VARCHAR(23),View_RSS_news.Date,121) <= '$ed'";
					}
					if($sea != "")
					{
						$query .= " AND View_RSS_news.Title LIKE '%$sea%'";
					}
			$query .= " ORDER BY View_RSS_news.Date DESC";
			$get_news = $this->db->query($query)->result();
			$lastid['id'] = $this->rss_m->last_rssid();
			$sql = "";
			foreach ($lastid['id'] as $last) 
			{
				$mainid = $last->Main_RssID;
			}
			foreach ($get_news as $item_getnews) 
			{
				$sql = "INSERT INTO [NNT_RSSFEED].dbo.Detail_RSS (Main_RssID,Detail_NewsID,Detail_CatagoryID,Detail_SubCatagoryID)";
				$sql .= "VALUES ('";
				$sql .= $mainid."','";
				$sql .= $item_getnews->NewsID."','";
				$sql .= $item_getnews->NT02_TypeID."','";
				$sql .= $item_getnews->NT03_SubTypeID."');";
				$this->db_rss->query($sql);
			}
		}
		else if($di != "")
		{
			$status = 7;
			$query = "
				SELECT TOP $news_count NewsID,NT02_TypeID,NT03_SubTypeID 
				FROM View_RSS_news
				WHERE Department = 
				(	
					SELECT View_RSS_department.SC07_DepartmentName 
					FROM View_RSS_department
					WHERE View_RSS_department.SC07_DepartmentId = '$di'
				)";
					if($mty != "")
					{
						$query .= " AND NT06_MoreTypeID = '$mty'";
					}
					if($sty != "")
					{
						$query .= " AND NT03_SubTypeID = '$sty'";
					}
					if($ty != "")
					{
						$query .= " AND NT02_TypeID = '$ty'";
					}
					if($ssd != "")
					{
						$query .= " AND CONVERT(VARCHAR(23),View_RSS_news.Date,121) >= '$sd'";
					}
					if($esd != "")
					{
						$query .= " AND CONVERT(VARCHAR(23),View_RSS_news.Date,121) <= '$ed'";
					}
					if($sea != "")
					{
						$query .= " AND View_RSS_news.Title LIKE '%$sea%'";
					}
			$query .= " ORDER BY View_RSS_news.Date DESC";
			$get_news = $this->db->query($query)->result();
			$lastid['id'] = $this->rss_m->last_rssid();
			$sql = "";
			foreach ($lastid['id'] as $last) 
			{
				$mainid = $last->Main_RssID;
			}
			foreach ($get_news as $item_getnews) 
			{
				$sql = "INSERT INTO [NNT_RSSFEED].dbo.Detail_RSS (Main_RssID,Detail_NewsID,Detail_CatagoryID,Detail_SubCatagoryID)";
				$sql .= "VALUES ('";
				$sql .= $mainid."','";
				$sql .= $item_getnews->NewsID."','";
				$sql .= $item_getnews->NT02_TypeID."','";
				$sql .= $item_getnews->NT03_SubTypeID."');";
				$this->db_rss->query($sql);
			} 
		}
		else if($mty != "") 
		{
			
			$status = 6;
			$query = "
				SELECT TOP $news_count NewsID,NT02_TypeID,NT03_SubTypeID 
				FROM View_RSS_news
				WHERE NT06_MoreTypeID = '$mty'";
				if($sty != "")
				{
					$query .= " AND NT03_SubTypeID = '$sty'";
				}
				if($ty != "")
				{
					$query .= " AND NT02_TypeID = '$ty'";
				}
				if($ssd != "")
				{
					$query .= " AND CONVERT(VARCHAR(23),View_RSS_news.Date,121) >= '$sd'";
				}
				if($esd != "")
				{
					$query .= " AND CONVERT(VARCHAR(23),View_RSS_news.Date,121) <= '$ed'";
				}
				if($sea != "")
				{
					$query .= " AND View_RSS_news.Title LIKE '%$sea%'";
				}
			$query .= " ORDER BY View_RSS_news.Date DESC";
			$get_news = $this->db->query($query)->result();
			$lastid['id'] = $this->rss_m->last_rssid();
			$sql = "";
			foreach ($lastid['id'] as $last) 
			{
				$mainid = $last->Main_RssID;
			}
			foreach ($get_news as $item_getnews) 
			{
				$sql = "INSERT INTO [NNT_RSSFEED].dbo.Detail_RSS (Main_RssID,Detail_NewsID,Detail_CatagoryID,Detail_SubCatagoryID)";
				$sql .= "VALUES ('";
				$sql .= $mainid."','";
				$sql .= $item_getnews->NewsID."','";
				$sql .= $item_getnews->NT02_TypeID."','";
				$sql .= $item_getnews->NT03_SubTypeID."');";
				$this->db_rss->query($sql);
			} 	
		}
		else if($sty != "")
		{
			$status = 5;
			$query = "
				SELECT TOP $news_count NewsID,NT02_TypeID,NT03_SubTypeID 
				FROM View_RSS_news
				WHERE NT03_SubTypeID = '$sty'";
				if($ty != "")
				{
					$query .= " AND NT02_TypeID = '$ty'";
				}
				if($ssd != "")
				{
					$query .= " AND CONVERT(VARCHAR(23),View_RSS_news.Date,121) >= '$sd'";
				}
				if($esd != "")
				{
					$query .= " AND CONVERT(VARCHAR(23),View_RSS_news.Date,121) <= '$ed'";
				}
				if($sea != "")
				{
						$query .= " AND View_RSS_news.Title LIKE '%$sea%'";
				}
			$query .= " ORDER BY View_RSS_news.Date DESC";
			$get_news = $this->db->query($query)->result();
			$lastid['id'] = $this->rss_m->last_rssid();
			$sql = "";
			foreach ($lastid['id'] as $last) 
			{
				$mainid = $last->Main_RssID;
			}
			foreach ($get_news as $item_getnews) 
			{
				$sql = "INSERT INTO [NNT_RSSFEED].dbo.Detail_RSS (Main_RssID,Detail_NewsID,Detail_CatagoryID,Detail_SubCatagoryID)";
				$sql .= "VALUES ('";
				$sql .= $mainid."','";
				$sql .= $item_getnews->NewsID."','";
				$sql .= $item_getnews->NT02_TypeID."','";
				$sql .= $item_getnews->NT03_SubTypeID."');";
				$this->db_rss->query($sql);
			} 
		}
		else if($ty != "")
		{
			$status = 4;
			$query = "
				SELECT TOP $news_count NewsID,NT02_TypeID,NT03_SubTypeID 
				FROM View_RSS_news
				WHERE NT02_TypeID = '$ty'";
				if($ssd != "")
				{
					$query .= " AND CONVERT(VARCHAR(23),View_RSS_news.Date,121) >= '$sd'";
				}
				if($esd != "")
				{
					$query .= " AND CONVERT(VARCHAR(23),View_RSS_news.Date,121) <= '$ed'";
				}
				if($sea != "")
				{
					$query .= " AND View_RSS_news.Title LIKE '%$sea%'";
				}
			$query .= " ORDER BY View_RSS_news.Date DESC";
			$get_news = $this->db->query($query)->result();
			$lastid['id'] = $this->rss_m->last_rssid();
			$sql = "";
			foreach ($lastid['id'] as $last) 
			{
				$mainid = $last->Main_RssID;
			}
			foreach ($get_news as $item_getnews) 
			{
				$sql = "INSERT INTO [NNT_RSSFEED].dbo.Detail_RSS (Main_RssID,Detail_NewsID,Detail_CatagoryID,Detail_SubCatagoryID)";
				$sql .= "VALUES ('";
				$sql .= $mainid."','";
				$sql .= $item_getnews->NewsID."','";
				$sql .= $item_getnews->NT02_TypeID."','";
				$sql .= $item_getnews->NT03_SubTypeID."');";
				$this->db_rss->query($sql);
			} 	
		}
		else if($ssd != "")
		{
			$status = 3;
			$query = "
				SELECT TOP $news_count NewsID,NT02_TypeID,NT03_SubTypeID 
				FROM View_RSS_news
				WHERE CONVERT(VARCHAR(23),View_RSS_news.Date,121) >= '$sd'";
				if($esd != "")
				{
					$query .= " AND CONVERT(VARCHAR(23),View_RSS_news.Date,121) <= '$ed'";
				}
				if($sea != "")
				{
					$query .= " AND View_RSS_news.Title LIKE '%$sea%'";
				}
			$query .= " ORDER BY View_RSS_news.Date DESC";
			$get_news = $this->db->query($query)->result();
			$lastid['id'] = $this->rss_m->last_rssid();
			$sql = "";
			foreach ($lastid['id'] as $last) 
			{
				$mainid = $last->Main_RssID;
			}
			foreach ($get_news as $item_getnews) 
			{
				$sql = "INSERT INTO [NNT_RSSFEED].dbo.Detail_RSS (Main_RssID,Detail_NewsID,Detail_CatagoryID,Detail_SubCatagoryID)";
				$sql .= "VALUES ('";
				$sql .= $mainid."','";
				$sql .= $item_getnews->NewsID."','";
				$sql .= $item_getnews->NT02_TypeID."','";
				$sql .= $item_getnews->NT03_SubTypeID."');";
				$this->db_rss->query($sql);
			}
		}
		else if($esd != "")
		{
			$status = 2;
			$query = "
				SELECT TOP $news_count NewsID,NT02_TypeID,NT03_SubTypeID 
				FROM View_RSS_news
				WHERE CONVERT(VARCHAR(23),View_RSS_news.Date,121) <= '$ed'";
				if($sea != "")
				{
					$query .= " AND View_RSS_news.Title LIKE '%$sea%'";
				}
			$query .= " ORDER BY View_RSS_news.Date DESC";
			$get_news = $this->db->query($query)->result();
			$lastid['id'] = $this->rss_m->last_rssid();
			$sql = "";
			foreach ($lastid['id'] as $last) 
			{
				$mainid = $last->Main_RssID;
			}
			foreach ($get_news as $item_getnews) 
			{
				$sql = "INSERT INTO [NNT_RSSFEED].dbo.Detail_RSS (Main_RssID,Detail_NewsID,Detail_CatagoryID,Detail_SubCatagoryID)";
				$sql .= "VALUES ('";
				$sql .= $mainid."','";
				$sql .= $item_getnews->NewsID."','";
				$sql .= $item_getnews->NT02_TypeID."','";
				$sql .= $item_getnews->NT03_SubTypeID."');";
				$this->db_rss->query($sql);
			}	
		}
		else
		{
			$status = 1;
			$query = "
				SELECT TOP $news_count NewsID,NT02_TypeID,NT03_SubTypeID 
				FROM View_RSS_news
				WHERE Title LIKE '%$sea%' 
				";
			$query .= " ORDER BY View_RSS_news.Date DESC";
			$get_news = $this->db->query($query)->result();
			$lastid['id'] = $this->rss_m->last_rssid();
			$sql = "";
			foreach ($lastid['id'] as $last) 
			{
				$mainid = $last->Main_RssID;
			}
			foreach ($get_news as $item_getnews) 
			{
				$sql = "INSERT INTO [NNT_RSSFEED].dbo.Detail_RSS (Main_RssID,Detail_NewsID,Detail_CatagoryID,Detail_SubCatagoryID)";
				$sql .= "VALUES ('";
				$sql .= $mainid."','";
				$sql .= $item_getnews->NewsID."','";
				$sql .= $item_getnews->NT02_TypeID."','";
				$sql .= $item_getnews->NT03_SubTypeID."');";
				$this->db_rss->query($sql);
			}
		}
		$sql_update = "
			UPDATE [NNT_RSSFEED].dbo.Main_RSS 
			SET Main_RssID_Encode = '".md5($mainid)."',
			Main_Status = '".$status."'
			WHERE Main_RssID = '".$mainid."';";
		$this->db_rss->query($sql_update);
		return md5($mainid);
	}
	public function count_css_news()
	{
		$query = $this->db->select('
				View_RSS_news.NewsID,
			')->
			get('View_RSS_news');	
		return $query->num_rows();
	}
	public function get_detail($id)
	{
		$query = $this->db->select('
				View_RSS_news.NewsID,
				View_RSS_news.Date,
				View_RSS_news.Title,
				View_RSS_news.Detail,
				View_RSS_news.Department,
				View_RSS_news.Reporter,
				View_RSS_news.Rewrite,
				View_RSS_news.Views
			')->
			where('View_RSS_news.NewsID', $id)->
			get('View_RSS_news');	
		return $query->result();
	}
	public function get_pic($id)
	{
		$query = $this->db->select('*')->
			where('NT01_NewsID', $id)->
			get('View_RSS_Picture');
		return $query->result();
	}
	public function get_video($id)
	{
		$query = $this->db->select('*')->
			where('NT01_NewsID', $id)->
			get('View_RSS_VDO');
		return $query->result();
	}
	public function get_voice($id)
	{
		$query = $this->db->select('*')->
			where('NT01_NewsID', $id)->
			get('View_RSS_Voice');
		return $query->result();
	}
	public function get_other($id)
	{
		$query = $this->db->select('*')->
			where('NT01_NewsID', $id)->
			get('View_RSS_OtherFile');
		return $query->result();
	}
	public function last_rssid()
	{
		$query = "
			SELECT TOP 1 Main_RssID,Main_RssID_Encode
			FROM [NNT_RSSFEED].dbo.Main_RSS
			ORDER BY Main_RssID DESC";
		return $this->db_rss->query($query)->result();
	}
	public function get_status()
	{
		$id = $this->input->get('mid');
		$query = "
			SELECT Main_StatusVDO,Main_StatusPicture,Main_StatusOther,Main_StatusVoice
			FROM [NNT_RSSFEED].dbo.Main_RSS
			WHERE Main_RssID= '$id';";
		return $this->db_rss->query($query)->result();
	}
	public function get_rss_newsid($page)
	{
		$query = "
			SELECT Detail_RSS.Detail_NewsID,Detail_RSS.Main_RssID,Main_RSS.Main_StatusVDO,Main_RSS.Main_StatusPicture,Main_RSS.Main_StatusVoice,Main_RSS.Main_StatusOther
			FROM [NNT_RSSFEED].dbo.Detail_RSS
			INNER JOIN [NNT_RSSFEED].dbo.Main_RSS
			ON Detail_RSS.Main_RssID = Main_RSS.Main_RssID
			WHERE Main_RSS.Main_RssID_Encode = '$page'";
		return $this->db_rss->query($query)->result();
	}
	public function get_rss_mainid($page)
	{
		$query = "
			SELECT Main_RssID, Main_Status
			FROM Main_Rss
			WHERE Main_Rss.Main_RssID_Encode = '".$page."'
		";
		return $this->db_rss->query($query)->result();
	}
	public function get_rss_newscount($mainid)
	{
		$query = "
			SELECT count(Detail_NewsID) as count_news
			FROM Detail_RSS
			WHERE Main_RssID = '".$mainid."'
		";
		return $this->db_rss->query($query)->result();
	}
	public function update_rss($mainid,$newsid,$first_mainid)
	{
		$query = "
			UPDATE Detail_RSS
			SET Detail_NewsID = '".$newsid."'
			WHERE Main_RssID = '".$mainid."'
			AND Detail_RssID = '".$first_mainid."';
		";
		return $this->db_rss->query($query);
	}
	public function get_rss($page)
	{
		$query = "
			SELECT Title,Date,Detail,Reporter,Rewrite,Department
			FROM View_RSS_news
			WHERE NewsID = '$page'
		";
		return $this->db->query($query)->result();
	}
	public function insertlog($userid)
	{
		$date = date("Y-m-d H:i:s");
		$time = date("H:i:s");
		$data = array(
		   'Log_Date' => $date,
		   'Log_IP' => $_SERVER['REMOTE_ADDR'],
		   'Log_startLogin' => $time,
		   'Mem_ID' => $userid
		);
		$this->db_rss->insert('[NNT_RSSFEED].dbo.UserLog', $data); 
	}
	public function last_log()
	{
		$query = "
			SELECT TOP 1 Log_ID
			FROM [NNT_RSSFEED].dbo.UserLog
			ORDER BY Log_ID DESC";
		return $this->db_rss->query($query)->result();
	}
	public function updatelog($id)
	{
		$time = date("H:i:s");
		$sql_update = "
			UPDATE [NNT_RSSFEED].dbo.UserLog 
			SET Log_EndLogin = '".$time."'
			WHERE Log_ID = '".$id."';";
		$this->db_rss->query($sql_update);
	}
	public function insert_count($news_id)
	{
		$data = array(
		   'count_newsid' => $news_id
		);
		$this->db_rss->insert('[NNT_RSSFEED].dbo.Count_News', $data); 
	}
	public function news_count($news_id)
	{
		$sql = "
			SELECT COUNT(count_newsid) AS total
			FROM [NNT_RSSFEED].dbo.Count_News
			WHERE count_newsid = '$news_id'
		";
		return $this->db_rss->query($sql)->row();


	}
	public function get_news_rss_default()
	{
		$sql = "
			SELECT TOP 20 View_RSS_news.NewsID, View_RSS_news.Date, View_RSS_news.Title, View_RSS_news.Detail
			FROM View_RSS_news
			ORDER BY View_RSS_news.Date DESC;
		";
		return $this->db->query($sql)->result();
	}
	public function get_first_detail_mainid($mainid)
	{
		$sql = "
			SELECT TOP 1 Detail_RssID
			FROM Detail_RSS
			WHERE Main_RssID = '".$mainid."'
		";
		return $this->db_rss->query($sql)->row();
	}
}  
?>