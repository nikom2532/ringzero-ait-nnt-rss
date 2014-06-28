<?php
class Rss_m extends CI_model
{
	public function __construct() 
    {
           parent::__construct(); 
           $this->load->database();
		   $this->load->database('NNT_RSSFEED',true);
    }
	function get_newstype()
	{
		$query = $this->db->select('DISTINCT NT02_TypeID,TypeNews')->get('[NNT_DataCenter_2].dbo.View_RSS_NewsType');
		return $query->result();
	}
	function get_subtype()
	{
		$query = $this->db->select('NT03_SubTypeID,SubType')->get('[NNT_DataCenter_2].dbo.View_RSS_NewsType');
		return $query->result();
	}
	function get_newstype_by_subtype($newstype)
	{
        $this->db->select('NT03_SubTypeID, SubType');
        $this->db->where('NT02_TypeID', $newstype);
        return $query = $this->db->get('[NNT_DataCenter_2].dbo.View_RSS_NewsType')->result();
    } 
	function get_department()
	{
		$query = $this->db->select('SC07_DepartmentId,SC07_DepartmentName')->order_by('SC07_DepartmentSeq')->get('[NNT_DataCenter_2].dbo.View_RSS_department');
		return $query->result();
	}
	function get_reporter()
	{
		$query = $this->db->select('SC03_UserId,Name')->get('[NNT_DataCenter_2].dbo.View_RSS_Reporter');
		return $query->result();
	}
	function get_reporter_by_id($userid)
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
			View_RSS_news.Date, View_RSS_news.Title 
			from [NNT_DataCenter_2].dbo.View_RSS_news
		)
		SELECT DISTINCT * FROM row WHERE RowNumber BETWEEN $bet AND $page ;";
		return $this->db->query($query); 
	}
	public function search_news($page,$seg,$sea,$ssd,$esd,$ty,$sty,$di,$ui)
	{
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
		if($sea != "" && $ssd == "" && $esd == "" && $ty == "0" && $sty == "0" && $di == "0" && $ui == "0")
		{
			$query = "WITH row AS 
			(
				SELECT TOP $page View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title 
				FROM View_RSS_news 
				WHERE Title LIKE '%$sea%'
			)
			SELECT DISTINCT * 
			FROM row 
			WHERE RowNumber
			BETWEEN $bet AND $page;";
			//echo "1".$query;
		}
		else if($sea != "" && $ssd != "" && $esd != "" && $ty == "0" && $sty == "0" && $di == "0" && $ui == "0")
		{
			$query = "
			WITH row AS 
			(
				SELECT TOP $page View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title 
				FROM View_RSS_news 
				WHERE Title LIKE '%$sea%' AND View_RSS_news.Date BETWEEN '$sd' AND '$ed'
			)
			SELECT DISTINCT * 
			FROM row 
			WHERE RowNumber 
			BETWEEN $bet AND $page;";
			//echo "2".$query;
		}
		else if($sea != "" && $ssd != "" && $esd != "" && $ty != "0" && $sty == "0" && $ui == "0")
		{
			$query = "WITH row AS 
			(
				SELECT TOP $page View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title 
				FROM View_RSS_news 
				WHERE Title LIKE '%$sea%' AND (View_RSS_news.Date BETWEEN '$sd' AND '$ed') AND View_RSS_news.NT02_TypeID = '$ty'
			)
			SELECT DISTINCT * 
			FROM row 
			WHERE RowNumber 
			BETWEEN $bet AND $page;";
			//echo "3".$query;
		}
		else if($sea != "" && $ssd != "" && $esd != "" && $ty != "0" && $sty != "0" && $di == "0" && $ui == "0")
		{
			$query = "WITH row AS 
			(
				SELECT TOP $page View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title 
				FROM View_RSS_news 
				WHERE Title LIKE '%$sea%' AND (View_RSS_news.Date BETWEEN '$sd' AND '$ed')AND View_RSS_news.NT02_TypeID = '$ty' 
				AND NT03_SubTypeID = '$sty'
			)
			SELECT DISTINCT * 
			FROM row 
			WHERE RowNumber 
			BETWEEN $bet AND $page;";
			//echo "4".$query;
		}
		else if($sea != "" && $ssd != "" && $esd != "" && $ty != "0" && $sty != "0" && $di != "0" && $ui == "0")
		{
			$query = "WITH row AS 
			(
				SELECT TOP $page View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title 
				FROM View_RSS_news 
				WHERE Title LIKE '%$sea%' AND (View_RSS_news.Date BETWEEN '$sd' AND '$ed')AND View_RSS_news.NT02_TypeID = '$ty' 
				AND NT03_SubTypeID = '$sty' 
				AND Department = 
				(
					SELECT View_RSS_department.SC07_DepartmentName 
					FROM View_RSS_department
					WHERE View_RSS_department.SC07_DepartmentId = '$di'
				)
			)
			SELECT DISTINCT * 
			FROM row 
			WHERE RowNumber 
			BETWEEN $bet AND $page;";
			//echo "5".$query;
		}
		else if($sea != "" && $ssd != "" && $esd == "" && $ty == "0" && $sty == "0" && $di == "0" && $ui == "0")
		{
			$query = "WITH row AS 
			(
				SELECT TOP $page View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title 
				FROM View_RSS_news 
				WHERE Title LIKE '%$sea%' AND View_RSS_news.Date > '$sd'
			)
			SELECT DISTINCT * 
			FROM row 
			WHERE RowNumber 
			BETWEEN $bet AND $page;";
			//echo "6".$query;

		}
		else if($sea != "" && $ssd == "" && $esd == "" && $ty == "0" && $sty == "0" && $di != "0" && $ui == "0")
		{
			$query = "WITH row AS 
			(
				SELECT TOP $page View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title 
				FROM View_RSS_news 
				WHERE Title LIKE '%$sea%' 
				AND Department =
				(
					SELECT View_RSS_department.SC07_DepartmentName 
					FROM View_RSS_department
					WHERE View_RSS_department.SC07_DepartmentId = '$di'
				)
			)
			SELECT DISTINCT * 
			FROM row 
			WHERE RowNumber 
			BETWEEN $bet AND $page;";
			//echo "7".$query;
		}
		else if($sea == "" && $ssd == "" && $esd == "" && $ty == "0" && $sty == "0" && $di != "0" && $ui == "0")
		{
			$query = "WITH row AS 
			(
				SELECT TOP $page View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title 
				FROM View_RSS_news 
				WHERE Title LIKE '%$sea%' 
				AND Department =
				(
					SELECT View_RSS_department.SC07_DepartmentName 
					FROM View_RSS_department
					WHERE View_RSS_department.SC07_DepartmentId = '$di'
				)
			)
			SELECT DISTINCT * 
			FROM row 
			WHERE RowNumber 
			BETWEEN $bet AND $page;";
			//echo "8".$query;
		}
		else if($sea == "" && $ssd == "" && $esd == "" && $ty != "0" && $sty != "0" && $di == "0" && $ui == "0")
		{
			$query = "WITH row AS 
			(
				SELECT TOP $page View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title 
				FROM View_RSS_news 
				WHERE Title LIKE '%$sea%'AND View_RSS_news.NT02_TypeID = '$ty' AND NT03_SubTypeID = '$sty' 
			)
			SELECT DISTINCT * 
			FROM row 
			WHERE RowNumber 
			BETWEEN $bet AND $page;";
			//echo "9";
		}
		else if($sea == "" && $ssd == "" && $esd == "" && $ty != "0" && $sty != "0" && $di != "0" && $ui == "0")
		{
			$query = "WITH row AS 
			(
				SELECT TOP $page View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title 
				FROM View_RSS_news 
				WHERE Title LIKE '%$sea%' AND View_RSS_news.NT02_TypeID = '$ty' AND NT03_SubTypeID = '$sty' 
				AND Department = 
				(
					SELECT View_RSS_department.SC07_DepartmentName 
					FROM View_RSS_department
					WHERE View_RSS_department.SC07_DepartmentId = '$di'
				)
			)
			SELECT DISTINCT * 
			FROM row 
			WHERE RowNumber 
			BETWEEN $bet AND $page;";
			//echo "10";
		}
		else if($sea == "" && $ssd == "" && $esd == "" && $ty == "0" && $sty == "0" && $di == "0" && $ui != "0")
		{
			$query = "WITH row AS 
			(
				SELECT TOP $page View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title 
				FROM View_RSS_news 
				WHERE Title LIKE '%$sea%' 
				AND Reporter = 
				(
					SELECT View_RSS_Reporter.Name
					FROM View_RSS_Reporter
					WHERE View_RSS_Reporter.SC03_UserId = '$ui'
				)
			)
			SELECT DISTINCT * 
			FROM row 
			WHERE RowNumber 
			BETWEEN $bet AND $page;";
			//echo "11".$query;
		}
		else if($sea == "" && $ssd == "" && $esd == "" && $ty == "0" && $sty == "0" && $di != "0" && $ui != "0")
		{
			$query = "WITH row AS 
			(
				SELECT TOP $page View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title
				FROM View_RSS_news 
				WHERE Title LIKE '%$sea%' 
				AND Department = 
				(
					SELECT View_RSS_department.SC07_DepartmentName 
					FROM View_RSS_department
					WHERE View_RSS_department.SC07_DepartmentId = '$di'
				)
				AND Reporter = 
				(
					SELECT View_RSS_Reporter.Name
					FROM View_RSS_Reporter
					WHERE View_RSS_Reporter.SC03_UserId = '$ui'
				)
			)
			SELECT DISTINCT * 
			FROM row 
			WHERE RowNumber 
			BETWEEN $bet AND $page;";
			//echo "12".$query;
		}
		else if($sea != "" && $ssd == "" && $esd == "" && $ty == "0" && $sty == "0" && $di == "0" && $ui != "0")
		{
			$query = "WITH row AS 
			(
				SELECT TOP $page View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title 
				FROM View_RSS_news 
				WHERE Title LIKE '%$sea%'
				AND Reporter = 
				(
					SELECT View_RSS_Reporter.Name
					FROM View_RSS_Reporter
					WHERE View_RSS_Reporter.SC03_UserId = '$ui'
				)
			)
			SELECT DISTINCT * 
			FROM row 
			WHERE RowNumber 
			BETWEEN $bet AND $page;";
			//echo "13".$query;
		}
		else if($sea != "" && $ssd != "" && $esd != "" && $ty != "0" && $sty != "0" && $di != "0" && $ui != "0")
		{
			$query = "WITH row AS 
			(
				SELECT TOP $page View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title 
				FROM View_RSS_news 
				WHERE Title LIKE '%$sea%' AND (View_RSS_news.Date BETWEEN '$sd' AND '$ed')
				AND View_RSS_news.NT02_TypeID = '$ty' 
				AND NT03_SubTypeID = '$sty' 
				AND Department = 
				(
					SELECT View_RSS_department.SC07_DepartmentName 
					FROM View_RSS_department
					WHERE View_RSS_department.SC07_DepartmentId = '$di'
				)
				AND Reporter = 
				(
					SELECT View_RSS_Reporter.Name
					FROM View_RSS_Reporter
					WHERE View_RSS_Reporter.SC03_UserId = '$ui'
				)
			)
			SELECT DISTINCT * 
			FROM row 
			WHERE RowNumber 
			BETWEEN $bet AND $page;";
			//echo "14".$query;
		}
		else if($sea == "" && $ssd != "" && $esd != "" && $ty == "0" && $sty == "0" && $di == "0" && $ui != "0")
		{
			$query = "WITH row AS 
			(
				SELECT TOP $page View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title 
				FROM View_RSS_news 
				WHERE Title LIKE '%$sea%' AND (View_RSS_news.Date BETWEEN '$sd' AND '$ed')
				AND Reporter = 
				(
					SELECT View_RSS_Reporter.Name
					FROM View_RSS_Reporter
					WHERE View_RSS_Reporter.SC03_UserId = '$ui'
				)
			)
			SELECT DISTINCT * 
			FROM row 
			WHERE RowNumber 
			BETWEEN $bet AND $page;";
			//echo "15".$query;
		}
		else if($sea == "" && $ssd == "" && $esd == "" && $ty != "0" && $sty != "0" && $di == "0" && $ui != "0")
		{
			$query = "WITH row AS 
			(
				SELECT TOP $page View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title 
				FROM View_RSS_news WHERE Title LIKE '%$sea%' AND View_RSS_news.NT02_TypeID = '$ty' 
				AND NT03_SubTypeID = '$sty'
				AND Reporter = 
				(
					SELECT View_RSS_Reporter.Name
					FROM View_RSS_Reporter
					WHERE View_RSS_Reporter.SC03_UserId = '$ui'
				)
			)
			SELECT DISTINCT * 
			FROM row 
			WHERE RowNumber 
			BETWEEN $bet AND $page;";
			//echo "16";
		}
		else if($sea == "" && $ssd == "" && $esd == "" && $ty != "0" && $sty != "0" && $di != "0" && $ui != "0")
		{
			$query = "WITH row AS 
			(
				SELECT TOP $page View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title 
				FROM View_RSS_news WHERE Title LIKE '%$sea%' AND View_RSS_news.NT02_TypeID = '$ty' 
				AND NT03_SubTypeID = '$sty'
				AND Department = 
				(
					SELECT View_RSS_department.SC07_DepartmentName 
					FROM View_RSS_department
					WHERE View_RSS_department.SC07_DepartmentId = '$di'
				)
				AND Reporter = 
				(
					SELECT View_RSS_Reporter.Name
					FROM View_RSS_Reporter
					WHERE View_RSS_Reporter.SC03_UserId = '$ui'
				)
			)
			SELECT DISTINCT * 
			FROM row 
			WHERE RowNumber 
			BETWEEN $bet AND $page;";
			//echo "17".$query;
		}
		else if($sea != "" && $ssd != "" && $esd != "" && $ty == "0" && $sty == "0" && $di == "0" && $ui != "0")
		{
			$query = "WITH row AS 
			(
				SELECT TOP $page View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title 
				FROM View_RSS_news 
				WHERE Title LIKE '%$sea%' AND (View_RSS_news.Date BETWEEN '$sd' AND '$ed')
				AND Reporter = 
				(
					SELECT View_RSS_Reporter.Name
					FROM View_RSS_Reporter
					WHERE View_RSS_Reporter.SC03_UserId = '$ui'
				)
			)
			SELECT DISTINCT * 
			FROM row 
			WHERE RowNumber 
			BETWEEN $bet AND $page;";
			//echo "18".$query;
		}
		else if($sea != "" && $ssd != "" && $esd != "" && $ty != "0" && $sty != "0" && $di == "0" && $ui != "0")
		{
			$query = "WITH row AS 
			(
				SELECT TOP $page View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title 
				FROM View_RSS_news 
				WHERE Title LIKE '%$sea%' AND (View_RSS_news.Date BETWEEN '$sd' AND '$ed')
				AND View_RSS_news.NT02_TypeID = '$ty' 
				AND NT03_SubTypeID = '$sty' 
				AND Reporter = 
				(
					SELECT View_RSS_Reporter.Name
					FROM View_RSS_Reporter
					WHERE View_RSS_Reporter.SC03_UserId = '$ui'
				)
			)
			SELECT DISTINCT * 
			FROM row 
			WHERE RowNumber 
			BETWEEN $bet AND $page;";
			//echo "19".$query;
		}
		else if($sea != "" && $ssd != "" && $esd == "" && $ty == "0" && $sty == "0" && $di == "0" && $ui != "0")
		{	
			$query = "WITH row AS 
			(
				SELECT TOP $page View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title 
				FROM View_RSS_news 
				WHERE Title LIKE '%$sea%' AND View_RSS_news.Date > '$sd'
				AND Reporter = 
				(
					SELECT View_RSS_Reporter.Name
					FROM View_RSS_Reporter
					WHERE View_RSS_Reporter.SC03_UserId = '$ui'
				)
			)
			SELECT DISTINCT * 
			FROM row 
			WHERE RowNumber 
			BETWEEN $bet AND $page;";
			//echo "20".$query;
		}
		else if($sea == "" && $ssd != "" && $esd != "" && $ty != "0" && $sty != "0" && $di == "0" && $ui == "0")
		{	
			$query = "WITH row AS 
			(
				SELECT TOP $page View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title 
				FROM View_RSS_news 
				WHERE  (View_RSS_news.Date BETWEEN '$sd' AND '$ed')
				AND View_RSS_news.NT02_TypeID = '$ty' 
				AND NT03_SubTypeID = '$sty' 
			)
			SELECT DISTINCT * 
			FROM row 
			WHERE RowNumber 
			BETWEEN $bet AND $page;";
			//echo "21".$query;
		}
		else if($sea == "" && $ssd != "" && $esd != "" && $ty == "0" && $sty == "0" && $di == "0" && $ui == "0")
		{	
			$query = "WITH row AS 
			(
				SELECT TOP $page View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title 
				FROM View_RSS_news 
				WHERE  (View_RSS_news.Date BETWEEN '$sd' AND '$ed')
			)
			SELECT DISTINCT * 
			FROM row 
			WHERE RowNumber 
			BETWEEN $bet AND $page;";
			//echo "22".$query;
		}
		else if($sea == "" && $ssd != "" && $esd != "" && $ty != "0" && $sty != "0" && $di != "0" && $ui != "0")
		{
			$query = "WITH row AS 
			(
				SELECT TOP $page View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title 
				FROM View_RSS_news 
				WHERE  (View_RSS_news.Date BETWEEN '$sd' AND '$ed')
				AND View_RSS_news.NT02_TypeID = '$ty' 
				AND NT03_SubTypeID = '$sty'
				AND Department = 
				(
					SELECT View_RSS_department.SC07_DepartmentName 
					FROM View_RSS_department
					WHERE View_RSS_department.SC07_DepartmentId = '$di'
				)
				AND Reporter = 
				(
					SELECT View_RSS_Reporter.Name
					FROM View_RSS_Reporter
					WHERE View_RSS_Reporter.SC03_UserId = '$ui'
				)
			)
			SELECT DISTINCT * 
			FROM row 
			WHERE RowNumber 
			BETWEEN $bet AND $page;";
			//echo "23".$query;
		}
		else if($sea == "" && $ssd != "" && $esd != "" && $ty == "0" && $sty == "0" && $di != "0" && $ui != "0")
		{
			$query = "WITH row AS 
			(
				SELECT TOP $page View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title 
				FROM View_RSS_news 
				WHERE  (View_RSS_news.Date BETWEEN '$sd' AND '$ed')
				AND Department = 
				(
					SELECT View_RSS_department.SC07_DepartmentName 
					FROM View_RSS_department
					WHERE View_RSS_department.SC07_DepartmentId = '$di'
				)
				AND Reporter = 
				(
					SELECT View_RSS_Reporter.Name
					FROM View_RSS_Reporter
					WHERE View_RSS_Reporter.SC03_UserId = '$ui'
				)
			)
			SELECT DISTINCT * 
			FROM row 
			WHERE RowNumber 
			BETWEEN $bet AND $page;";
			//echo "24".$query;
		}
		else if($sea == "" && $ssd == "" && $esd == "" && $ty != "0" && $sty == "0" && $di == "0" && $ui == "0")
		{
			$query = "WITH row AS 
			(
				SELECT TOP $page View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title 
				FROM View_RSS_news 
				WHERE View_RSS_news.NT02_TypeID = '$ty' 
			)
			SELECT DISTINCT * 
			FROM row 
			WHERE RowNumber 
			BETWEEN $bet AND $page;";
			//echo "25".$query;
		}
		else
		{
			$query = "WITH row AS 
			(
				SELECT TOP $page View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title 
				FROM View_RSS_news 
				WHERE Title LIKE '%$sea%'
			)
			SELECT DISTINCT * 
			FROM row 
			WHERE RowNumber 
			BETWEEN $bet AND $page;";
			//echo "0".$query;
		}
		$rs = $this->db->query($query);
		return $rs;
	}
	public function count_search_news($sea,$ssd,$esd,$ty,$sty,$di,$ui)
	{
		$sd = date("Y-m-d",strtotime($ssd))." 00:00:00.000";
		$ed = date("Y-m-d",strtotime($esd))." 23:59:59.999";
		/*if($page == "" || $page == NULL)
		{
			$page = 20;
			$bet = 1;
			//echo ">>>" .$page;
			//echo ">>>" .$bet;
		}
		else if($page == "20")
		{
			$page = 40;
			$bet = 21;
			//echo ">>>" .$page;
			//echo ">>>" .$bet;
		}
		else
		{	
			$page = $page + 20;
			$bet = $page - 20;
			//echo ">>>" .$page;
			//echo ">>>" .$bet;
		}*/
		//echo $page.">>>".$seg.">>>".$sea.">>>".$ssd.">>>".$esd.">>>".$ty.">>>".$sty.">>>".$di."<br>";
		if($sea != "" && $ssd == "" && $esd == "" && $ty == "0" && $sty == "0" && $di == "0" && $ui == "0")
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
			FROM row ;";
			//echo "1".$query;
		}
		else if($sea != "" && $ssd != "" && $esd != "" && $ty == "0" && $sty == "0" && $di == "0" && $ui == "0")
		{
			$query = "
			WITH row AS 
			(
				SELECT View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title 
				FROM View_RSS_news 
				WHERE Title LIKE '%$sea%' AND (View_RSS_news.Date BETWEEN '$sd' AND '$ed')
			)
			SELECT DISTINCT * 
			FROM row ;";
			//echo "2".$query;
		}
		else if($sea != "" && $ssd != "" && $esd != "" && $ty != "0" && $sty == "0" && $ui == "0")
		{
			$query = "WITH row AS 
			(
				SELECT View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title 
				FROM View_RSS_news 
				WHERE Title LIKE '%$sea%' AND (View_RSS_news.Date BETWEEN '$sd' AND '$ed')AND View_RSS_news.NT02_TypeID = '$ty'
			)
			SELECT DISTINCT * 
			FROM row;";
			//echo "3".$query;
		}
		else if($sea != "" && $ssd != "" && $esd != "" && $ty != "0" && $sty != "0" && $di == "0" && $ui == "0")
		{
			$query = "WITH row AS 
			(
				SELECT View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title 
				FROM View_RSS_news 
				WHERE Title LIKE '%$sea%' AND (CONVERT(VARCHAR(44), View_RSS_news.Date, 110) BETWEEN '$sd' AND '$ed')AND View_RSS_news.NT02_TypeID = '$ty' 
				AND NT03_SubTypeID = '$sty'
			)
			SELECT DISTINCT * 
			FROM row;";
			//echo "4".$query;
		}
		else if($sea != "" && $ssd != "" && $esd != "" && $ty != "0" && $sty != "0" && $di != "0" && $ui == "0")
		{
			$query = "WITH row AS 
			(
				SELECT View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title 
				FROM View_RSS_news 
				WHERE Title LIKE '%$sea%' AND (CONVERT(VARCHAR(44), View_RSS_news.Date, 110) BETWEEN '$sd' AND '$ed')AND View_RSS_news.NT02_TypeID = '$ty' 
				AND NT03_SubTypeID = '$sty' 
				AND Department = 
				(
					SELECT View_RSS_department.SC07_DepartmentName 
					FROM View_RSS_department
					WHERE View_RSS_department.SC07_DepartmentId = '$di'
				) 
			)
			SELECT DISTINCT * 
			FROM row;";
			//echo "5".$query;
		}
		else if($sea != "" && $ssd != "" && $esd == "" && $ty == "0" && $sty == "0" && $di == "0" && $ui == "0")
		{
			$query = "WITH row AS 
			(
				SELECT View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title 
				FROM View_RSS_news 
				WHERE Title LIKE '%$sea%' AND View_RSS_news.Date > '$sd'
			)
			SELECT DISTINCT * 
			FROM row ;";
			//echo "6".$query;

		}
		else if($sea != "" && $ssd == "" && $esd == "" && $ty == "0" && $sty == "0" && $di != "0" && $ui == "0")
		{
			$query = "WITH row AS 
			(
				SELECT View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title 
				FROM View_RSS_news 
				WHERE Title LIKE '%$sea%' 
				AND Department = 
				(
					SELECT View_RSS_department.SC07_DepartmentName 
					FROM View_RSS_department
					WHERE View_RSS_department.SC07_DepartmentId = '$di'
				) 
			)
			SELECT DISTINCT * 
			FROM row;";
			//echo "7".$query;
		}
		else if($sea == "" && $ssd == "" && $esd == "" && $ty == "0" && $sty == "0" && $di != "0" && $ui == "0")
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
					WHERE View_RSS_department.SC07_DepartmentId = '$di'
				)
			)
			SELECT * 
			FROM row;";
			//echo "8".$query;
		}
		else if($sea == "" && $ssd == "" && $esd == "" && $ty != "0" && $sty != "0" && $di == "0" && $ui == "0")
		{
			$query = "WITH row AS 
			(
				SELECT View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title 
				FROM View_RSS_news 
				WHERE Title LIKE '%$sea%'AND View_RSS_news.NT02_TypeID = '$ty' AND NT03_SubTypeID = '$sty' 
			)
			SELECT DISTINCT * 
			FROM row ;";
			//echo "9";
		}
		else if($sea == "" && $ssd == "" && $esd == "" && $ty != "0" && $sty != "0" && $di != "0" && $ui == "0")
		{
			$query = "WITH row AS 
			(
				SELECT View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title 
				FROM View_RSS_news 
				WHERE Title LIKE '%$sea%' AND View_RSS_news.NT02_TypeID = '$ty' AND NT03_SubTypeID = '$sty' 
				AND Department = 
				(
					SELECT View_RSS_department.SC07_DepartmentName 
					FROM View_RSS_department
					WHERE View_RSS_department.SC07_DepartmentId = '$di'
				) 
			)
			SELECT DISTINCT * 
			FROM row ;";
			//echo "10";
		}
		else if($sea == "" && $ssd == "" && $esd == "" && $ty == "0" && $sty == "0" && $di == "0" && $ui != "0")
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
					WHERE View_RSS_Reporter.SC03_UserId = '$ui'
				) 
			)
			SELECT DISTINCT * 
			FROM row ;";
			//echo "11".$query;
		}
		else if($sea == "" && $ssd == "" && $esd == "" && $ty == "0" && $sty == "0" && $di != "0" && $ui != "0")
		{
			$query = "WITH row AS 
			(
				SELECT View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title
				FROM View_RSS_news 
				WHERE Title LIKE '%$sea%' 
				AND Department = 
				(
					SELECT View_RSS_department.SC07_DepartmentName 
					FROM View_RSS_department
					WHERE View_RSS_department.SC07_DepartmentId = '$di'
				) 
				AND Reporter = 
				(
					SELECT View_RSS_Reporter.Name
					FROM View_RSS_Reporter
					WHERE View_RSS_Reporter.SC03_UserId = '$ui'
				)
			)
			SELECT DISTINCT * 
			FROM row;";
			//echo "12".$query;
		}
		else if($sea != "" && $ssd == "" && $esd == "" && $ty == "0" && $sty == "0" && $di == "0" && $ui != "0")
		{
			$query = "WITH row AS 
			(
				SELECT View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title 
				FROM View_RSS_news 
				WHERE Title LIKE '%$sea%' 
				AND Reporter = 
				(
					SELECT View_RSS_Reporter.Name
					FROM View_RSS_Reporter
					WHERE View_RSS_Reporter.SC03_UserId = '$ui'
				)
			)
			SELECT DISTINCT * 
			FROM row ;";
			//echo "13".$query;
		}
		else if($sea != "" && $ssd != "" && $esd != "" && $ty != "0" && $sty != "0" && $di != "0" && $ui != "0")
		{
			$query = "WITH row AS 
			(
				SELECT View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title 
				FROM View_RSS_news 
				WHERE Title LIKE '%$sea%' AND (View_RSS_news.Date BETWEEN '$sd' AND '$ed')
				AND View_RSS_news.NT02_TypeID = '$ty' 
				AND NT03_SubTypeID = '$sty' 
				AND Department = 
				(
					SELECT View_RSS_department.SC07_DepartmentName 
					FROM View_RSS_department
					WHERE View_RSS_department.SC07_DepartmentId = '$di'
				) 
				AND Reporter = 
				(
					SELECT View_RSS_Reporter.Name
					FROM View_RSS_Reporter
					WHERE View_RSS_Reporter.SC03_UserId = '$ui'
				)
			)
			SELECT DISTINCT * 
			FROM row;";
			//echo "14".$query;
		}
		else if($sea == "" && $ssd != "" && $esd != "" && $ty == "0" && $sty == "0" && $di == "0" && $ui != "0")
		{
			$query = "WITH row AS 
			(
				SELECT TOP $page View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title 
				FROM View_RSS_news 
				WHERE Title LIKE '%$sea%' AND (View_RSS_news.Date BETWEEN '$sd' AND '$ed')
				AND Reporter = 
				(
					SELECT View_RSS_Reporter.Name
					FROM View_RSS_Reporter
					WHERE View_RSS_Reporter.SC03_UserId = '$ui'
				)
			)
			SELECT DISTINCT * 
			FROM row 
			WHERE RowNumber 
			BETWEEN $bet AND $page;";
			//echo "15".$query;
		}
		else if($sea == "" && $ssd == "" && $esd == "" && $ty != "0" && $sty != "0" && $di == "0" && $ui != "0")
		{
			$query = "WITH row AS 
			(
				SELECT View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title 
				FROM View_RSS_news WHERE Title LIKE '%$sea%' AND View_RSS_news.NT02_TypeID = '$ty' 
				AND NT03_SubTypeID = '$sty' 
				AND Reporter = 
				(
					SELECT View_RSS_Reporter.Name
					FROM View_RSS_Reporter
					WHERE View_RSS_Reporter.SC03_UserId = '$ui'
				)
			)
			SELECT DISTINCT * 
			FROM row;";
			//echo "16";
		}
		else if($sea == "" && $ssd == "" && $esd == "" && $ty != "0" && $sty != "0" && $di != "0" && $ui != "0")
		{
			$query = "WITH row AS 
			(
				SELECT View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title 
				FROM View_RSS_news WHERE Title LIKE '%$sea%' AND View_RSS_news.NT02_TypeID = '$ty' 
				AND NT03_SubTypeID = '$sty' 
				AND Department = 
				(
					SELECT View_RSS_department.SC07_DepartmentName 
					FROM View_RSS_department
					WHERE View_RSS_department.SC07_DepartmentId = '$di'
				) 
				AND Reporter = 
				(
					SELECT View_RSS_Reporter.Name
					FROM View_RSS_Reporter
					WHERE View_RSS_Reporter.SC03_UserId = '$ui'
				)
			)
			SELECT DISTINCT * 
			FROM row ;";
			//echo "17".$query;
		}
		else if($sea != "" && $ssd != "" && $esd != "" && $ty == "0" && $sty == "0" && $di == "0" && $ui != "0")
		{
			$query = "WITH row AS 
			(
				SELECT View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title 
				FROM View_RSS_news 
				WHERE Title LIKE '%$sea%' AND (View_RSS_news.Date BETWEEN '$sd' AND '$ed') 
				AND Reporter = 
				(
					SELECT View_RSS_Reporter.Name
					FROM View_RSS_Reporter
					WHERE View_RSS_Reporter.SC03_UserId = '$ui'
				)
			)
			SELECT DISTINCT * 
			FROM row ;";
			//echo "18".$query;
		}
		else if($sea != "" && $ssd != "" && $esd != "" && $ty != "0" && $sty != "0" && $di == "0" && $ui != "0")
		{
			$query = "WITH row AS 
			(
				SELECT View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title 
				FROM View_RSS_news 
				WHERE Title LIKE '%$sea%' AND (View_RSS_news.Date BETWEEN '$sd' AND '$ed')
				AND View_RSS_news.NT02_TypeID = '$ty' 
				AND NT03_SubTypeID = '$sty' 
				AND Reporter = 
				(
					SELECT View_RSS_Reporter.Name
					FROM View_RSS_Reporter
					WHERE View_RSS_Reporter.SC03_UserId = '$ui'
				)
			)
			SELECT DISTINCT * 
			FROM row ;";
			//echo "19".$query;
		}
		else if($sea != "" && $ssd != "" && $esd == "" && $ty == "0" && $sty == "0" && $di == "0" && $ui != "0")
		{	
			$query = "WITH row AS 
			(
				SELECT View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title 
				FROM View_RSS_news 
				WHERE Title LIKE '%$sea%' AND (View_RSS_news.Date > '$sd' 
				AND Reporter = 
				(
					SELECT View_RSS_Reporter.Name
					FROM View_RSS_Reporter
					WHERE View_RSS_Reporter.SC03_UserId = '$ui'
				)
			)
			SELECT DISTINCT * 
			FROM row ;";
			//echo "20".$query;
		}
		else if($sea == "" && $ssd != "" && $esd != "" && $ty != "0" && $sty != "0" && $di == "0" && $ui == "0")
		{	
			$query = "WITH row AS 
			(
				SELECT View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title 
				FROM View_RSS_news 
				WHERE (View_RSS_news.Date BETWEEN '$sd' AND '$ed')
				AND View_RSS_news.NT02_TypeID = '$ty' 
				AND NT03_SubTypeID = '$sty' 
			)
			SELECT DISTINCT * 
			FROM row ;";
			//echo "21".$query;
		}
		else if($sea == "" && $ssd != "" && $esd != "" && $ty == "0" && $sty == "0" && $di == "0" && $ui == "0")
		{	
			$query = "WITH row AS 
			(
				SELECT View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title 
				FROM View_RSS_news 
				WHERE  (View_RSS_news.Date BETWEEN '$sd' AND '$ed')
			)
			SELECT DISTINCT * 
			FROM row;";
			//echo "22".$query;
		}
		else if($sea == "" && $ssd != "" && $esd != "" && $ty != "0" && $sty != "0" && $di != "0" && $ui != "0")
		{
			$query = "WITH row AS 
			(
				SELECT View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title 
				FROM View_RSS_news 
				WHERE  (View_RSS_news.Date BETWEEN '$sd' AND '$ed')
				AND View_RSS_news.NT02_TypeID = '$ty' 
				AND NT03_SubTypeID = '$sty'
				AND Department = 
				(
					SELECT View_RSS_department.SC07_DepartmentName 
					FROM View_RSS_department
					WHERE View_RSS_department.SC07_DepartmentId = '$di'
				)
				AND Reporter = 
				(
					SELECT View_RSS_Reporter.Name
					FROM View_RSS_Reporter
					WHERE View_RSS_Reporter.SC03_UserId = '$ui'
				)
			)
			SELECT DISTINCT * 
			FROM row 
			WHERE RowNumber;";
			//echo "23".$query;
		}
		else if($sea == "" && $ssd != "" && $esd != "" && $ty == "0" && $sty == "0" && $di != "0" && $ui != "0")
		{
			$query = "WITH row AS 
			(
				SELECT View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title 
				FROM View_RSS_news 
				WHERE (View_RSS_news.Date BETWEEN '$sd' AND '$ed')
				AND Department = 
				(
					SELECT View_RSS_department.SC07_DepartmentName 
					FROM View_RSS_department
					WHERE View_RSS_department.SC07_DepartmentId = '$di'
				)
				AND Reporter = 
				(
					SELECT View_RSS_Reporter.Name
					FROM View_RSS_Reporter
					WHERE View_RSS_Reporter.SC03_UserId = '$ui'
				)
			)
			SELECT DISTINCT * 
			FROM row ;";
			//echo "24".$query;
		}
		else if($sea == "" && $ssd == "" && $esd == "" && $ty != "0" && $sty == "0" && $di == "0" && $ui == "0")
		{
			$query = "WITH row AS 
			(
				SELECT View_RSS_news.NewsID, ROW_NUMBER() 
				OVER (ORDER BY Date DESC) AS 'RowNumber',
				View_RSS_news.Date, View_RSS_news.Title 
				FROM View_RSS_news 
				WHERE View_RSS_news.NT02_TypeID = '$ty'
			)
			SELECT DISTINCT * 
			FROM row ";
			//echo "25".$query;
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
			FROM row ;";
			//echo "0".$query;
		}
		$rs = $this->db->query($query);
		return $rs;
	}
	public function count_css_news()
	{
		$query = $this->db->select('
				DISTINCT View_RSS_news.NewsID,
				View_RSS_news.Date,
				View_RSS_news.Title,
				View_RSS_VDO.NT01_NewsID as vdo_id,
				View_RSS_Picture.NT01_NewsID as pic_id,
				View_RSS_Voice.NT01_NewsID as voice_id,
				View_RSS_OtherFile.NT01_NewsID as other_id
			')->
			join('View_RSS_VDO', 'View_RSS_news.NewsID = View_RSS_VDO.NT01_NewsID','left')->
			join('View_RSS_Picture', 'View_RSS_news.NewsID = View_RSS_Picture.NT01_NewsID', 'left')->
			join('View_RSS_Voice', 'View_RSS_news.NewsID = View_RSS_Voice.NT01_NewsID', 'left')->
			join('View_RSS_OtherFile', 'View_RSS_news.NewsID = View_RSS_OtherFile.NT01_NewsID', 'left')->
			get('View_RSS_news');	
		return $query->num_rows();
	}
	public function get_detail()
	{
		$id = $this->input->get('id');
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
			
		//var_dump($query->num_rows());
		//var_dump($query);
		//var_dump($query->result());
		
		return $query->result();
		//return $id;
	}
	public function get_pic()
	{
		$id = $this->input->get('id');
		$query = $this->db->select('*')->
			where('NT01_NewsID', $id)->
			get('View_RSS_Picture');
		return $query->result();
	}
	public function get_video()
	{
		$id = $this->input->get('id');
		$query = $this->db->select('*')->
			where('NT01_NewsID', $id)->
			get('View_RSS_VDO');
		return $query->result();
	}
	public function get_voice()
	{
		$id = $this->input->get('id');
		$query = $this->db->select('*')->
			where('NT01_NewsID', $id)->
			get('View_RSS_Voice');
		return $query->result();
	}
	public function get_other()
	{
		$id = $this->input->get('id');
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
		return $this->db->query($query)->result();
	}
	public function generate_rss($sea,$ssd,$esd,$ty,$sty,$di,$ui,$vdo,$voice,$pic,$other,$userid)
	{
		$sd = date("Y-m-d",strtotime($ssd))." 00:00:00.000";
		$ed = date("Y-m-d",strtotime($esd))." 23:59:59.999";
		$today = date("Y-m-d H:i:s");
		$mainid = "";
		//echo $today;
		//echo $sea." ".$ssd." ".$esd." ".$ty." ".$sty." ".$di." ".$ui;
		if($ssd == NULL || $esd == NULL)
		{
			$query = 
				"INSERT INTO [NNT_RSSFEED].dbo.Main_RSS(Main_UserID,Main_Date,Main_CountNews,Main_StatusVDO,Main_StatusVoice,Main_StatusPicture,Main_StatusOther)
				 VALUES ('$userid','$today',20,'$vdo','$voice','$pic','$other');";
		}
		else
		{
			$query = 
				"INSERT INTO [NNT_RSSFEED].dbo.Main_RSS(Main_UserID,Main_Date,Main_CountNews,Main_StatusVDO,Main_StatusVoice,Main_StatusPicture,Main_StatusOther)
				 VALUES ('$userid','$today',100,'$vdo','$voice','$pic','$other');";
		}
		//echo $query;
		$this->db->query($query);
		if($sea != "" && $ssd == "" && $esd == "" && $ty == "0" && $sty == "0" && $di == "0" && $ui == "0")
		{
			//echo "1";
			$query_rss = "
				SELECT TOP 20 NewsID,NT02_TypeID,NT03_SubTypeID
				FROM View_RSS_news 
				WHERE Title LIKE '%$sea%';";
			//echo $query_rss;
			$qr = $this->db->query($query_rss);
			//$qr->Main_RssID;
			//var_dump($qr->result());
			$lastid['id'] = $this->rss_m->last_rssid();
			//var_dump($lastid);
			$mainid = "";
			$sql = "";
			foreach($lastid['id'] as $last)
			{
				$mainid = $last->Main_RssID;
			}
			foreach ($qr->result() as $item_qr)
			{
				$sql = "INSERT INTO [NNT_RSSFEED].dbo.Detail_RSS (Main_RssID,Detail_NewsID,Detail_CatagoryID,Detail_SubCatagoryID)";
				$sql .= "VALUES ('";
				$sql .= $mainid."','";
				$sql .= $item_qr->NewsID."','";
				$sql .= $item_qr->NT02_TypeID."','";
				$sql .= $item_qr->NT03_SubTypeID."');";
				$this->db->query($sql);
			}
		}
		else if($sea != "" && $ssd != "" && $esd != "" && $ty == "0" && $sty == "0" && $di == "0" && $ui == "0")
		{
			//echo "2";
			$query_rss = "
				SELECT TOP 100 NewsID,NT02_TypeID,NT03_SubTypeID
				FROM View_RSS_news 
				WHERE Title LIKE '%$sea%' AND (View_RSS_news.Date BETWEEN '$sd' AND '$ed')";
			$qr = $this->db->query($query_rss);
			//var_dump($qr);
			$lastid['id'] = $this->rss_m->last_rssid();
			//var_dump($lastid);
			$mainid = "";
			$sql = "";
			foreach($lastid['id'] as $last)
			{
				$mainid = $last->Main_RssID;
			}
			foreach ($qr->result() as $item_qr)
			{
				$sql = "INSERT INTO [NNT_RSSFEED].dbo.Detail_RSS (Main_RssID,Detail_NewsID,Detail_CatagoryID,Detail_SubCatagoryID)";
				$sql .= "VALUES ('";
				$sql .= $mainid."','";
				$sql .= $item_qr->NewsID."','";
				$sql .= $item_qr->NT02_TypeID."','";
				$sql .= $item_qr->NT03_SubTypeID."');";
				$this->db->query($sql);
			}
		}
		else if($sea != "" && $ssd != "" && $esd != "" && $ty != "0" && $sty == "0" && $ui == "0")
		{
			//echo "3";
			$query_rss = "
				SELECT TOP 100 NewsID,NT02_TypeID,NT03_SubTypeID
				FROM View_RSS_news 
				WHERE Title LIKE '%$sea%' AND (View_RSS_news.Date BETWEEN '$sd' AND '$ed') AND View_RSS_news.NT02_TypeID = '$ty'";
			$qr = $this->db->query($query_rss);
			$lastid['id'] = $this->rss_m->last_rssid();
			//var_dump($lastid);
			$mainid = "";
			$sql = "";
			foreach($lastid['id'] as $last)
			{
				$mainid = $last->Main_RssID;
			}
			foreach ($qr->result() as $item_qr)
			{
				$sql = "INSERT INTO [NNT_RSSFEED].dbo.Detail_RSS (Main_RssID,Detail_NewsID,Detail_CatagoryID,Detail_SubCatagoryID)";
				$sql .= "VALUES ('";
				$sql .= $mainid."','";
				$sql .= $item_qr->NewsID."','";
				$sql .= $item_qr->NT02_TypeID."','";
				$sql .= $item_qr->NT03_SubTypeID."');";
				$this->db->query($sql);
			}
		}
		else if($sea != "" && $ssd != "" && $esd != "" && $ty != "0" && $sty != "0" && $di == "0" && $ui == "0")
		{
			//echo "4";
			$query_rss = "
				SELECT TOP 100 NewsID,NT02_TypeID,NT03_SubTypeID
				FROM View_RSS_news 
				WHERE Title LIKE '%$sea%' AND (View_RSS_news.Date BETWEEN '$sd' AND '$ed') AND View_RSS_news.NT02_TypeID = '$ty' 
				AND NT03_SubTypeID = '$sty'";
			$qr = $this->db->query($query_rss);
			$lastid['id'] = $this->rss_m->last_rssid();
			//var_dump($lastid);
			$mainid = "";
			$sql = "";
			foreach($lastid['id'] as $last)
			{
				$mainid = $last->Main_RssID;
			}
			foreach ($qr->result() as $item_qr)
			{
				$sql = "INSERT INTO [NNT_RSSFEED].dbo.Detail_RSS (Main_RssID,Detail_NewsID,Detail_CatagoryID,Detail_SubCatagoryID)";
				$sql .= "VALUES ('";
				$sql .= $mainid."','";
				$sql .= $item_qr->NewsID."','";
				$sql .= $item_qr->NT02_TypeID."','";
				$sql .= $item_qr->NT03_SubTypeID."');";
				$this->db->query($sql);
			}
		} 
		else if($sea != "" && $ssd != "" && $esd != "" && $ty != "0" && $sty != "0" && $di != "0" && $ui == "0")
		{
			//echo "5";
			$query_rss = "
				SELECT TOP 100 NewsID,NT02_TypeID,NT03_SubTypeID
				FROM View_RSS_news 
				WHERE Title LIKE '%$sea%' AND (View_RSS_news.Date BETWEEN '$sd' AND '$ed') AND View_RSS_news.NT02_TypeID = '$ty' 
				AND NT03_SubTypeID = '$sty' 
				AND Department = 
				(
					SELECT View_RSS_department.SC07_DepartmentName 
					FROM View_RSS_department
					WHERE View_RSS_department.SC07_DepartmentId = '$di'
				)";
			$qr = $this->db->query($query_rss);
			$lastid['id'] = $this->rss_m->last_rssid();
			//var_dump($lastid);
			$mainid = "";
			$sql = "";
			foreach($lastid['id'] as $last)
			{
				$mainid = $last->Main_RssID;
			}
			foreach ($qr->result() as $item_qr)
			{
				$sql = "INSERT INTO [NNT_RSSFEED].dbo.Detail_RSS (Main_RssID,Detail_NewsID,Detail_CatagoryID,Detail_SubCatagoryID)";
				$sql .= "VALUES ('";
				$sql .= $mainid."','";
				$sql .= $item_qr->NewsID."','";
				$sql .= $item_qr->NT02_TypeID."','";
				$sql .= $item_qr->NT03_SubTypeID."');";
				$this->db->query($sql);
			}
		}
		else if($sea != "" && $ssd != "" && $esd == "" && $ty == "0" && $sty == "0" && $di == "0" && $ui == "0")
		{
			//echo "6";
			$query_rss = "
				SELECT TOP 20 NewsID,NT02_TypeID,NT03_SubTypeID
				FROM View_RSS_news 
				WHERE Title LIKE '%$sea%' AND View_RSS_news.Date > '$sd'";
			$qr = $this->db->query($query_rss);
			$lastid['id'] = $this->rss_m->last_rssid();
			//var_dump($lastid);
			$mainid = "";
			$sql = "";
			foreach($lastid['id'] as $last)
			{
				$mainid = $last->Main_RssID;
			}
			foreach ($qr->result() as $item_qr)
			{
				$sql = "INSERT INTO [NNT_RSSFEED].dbo.Detail_RSS (Main_RssID,Detail_NewsID,Detail_CatagoryID,Detail_SubCatagoryID)";
				$sql .= "VALUES ('";
				$sql .= $mainid."','";
				$sql .= $item_qr->NewsID."','";
				$sql .= $item_qr->NT02_TypeID."','";
				$sql .= $item_qr->NT03_SubTypeID."');";
				$this->db->query($sql);
			}

		}
		else if($sea != "" && $ssd == "" && $esd == "" && $ty == "0" && $sty == "0" && $di != "0" && $ui == "0")
		{
			//echo "7";
			$query_rss = "
				SELECT TOP 20 NewsID,NT02_TypeID,NT03_SubTypeID
				FROM View_RSS_news 
				WHERE Title LIKE '%$sea%' 
				AND Department =
				(
					SELECT View_RSS_department.SC07_DepartmentName 
					FROM View_RSS_department
					WHERE View_RSS_department.SC07_DepartmentId = '$di'
				)";
			$qr = $this->db->query($query_rss);
			$lastid['id'] = $this->rss_m->last_rssid();
			//var_dump($lastid);
			$mainid = "";
			$sql = "";
			foreach($lastid['id'] as $last)
			{
				$mainid = $last->Main_RssID;
			}
			foreach ($qr->result() as $item_qr)
			{
				$sql = "INSERT INTO [NNT_RSSFEED].dbo.Detail_RSS (Main_RssID,Detail_NewsID,Detail_CatagoryID,Detail_SubCatagoryID)";
				$sql .= "VALUES ('";
				$sql .= $mainid."','";
				$sql .= $item_qr->NewsID."','";
				$sql .= $item_qr->NT02_TypeID."','";
				$sql .= $item_qr->NT03_SubTypeID."');";
				$this->db->query($sql);
			}
		}
		else if($sea == "" && $ssd == "" && $esd == "" && $ty == "0" && $sty == "0" && $di != "0" && $ui == "0")
		{
			//echo "8";
			$query_rss = "
				SELECT TOP 20 NewsID,NT02_TypeID,NT03_SubTypeID
				FROM View_RSS_news 
				WHERE Title LIKE '%$sea%' 
				AND Department =
				(
					SELECT View_RSS_department.SC07_DepartmentName 
					FROM View_RSS_department
					WHERE View_RSS_department.SC07_DepartmentId = '$di'
				)";
			$qr = $this->db->query($query_rss);
			$lastid['id'] = $this->rss_m->last_rssid();
			//var_dump($lastid);
			$mainid = "";
			$sql = "";
			foreach($lastid['id'] as $last)
			{
				$mainid = $last->Main_RssID;
			}
			foreach ($qr->result() as $item_qr)
			{
				$sql = "INSERT INTO [NNT_RSSFEED].dbo.Detail_RSS (Main_RssID,Detail_NewsID,Detail_CatagoryID,Detail_SubCatagoryID)";
				$sql .= "VALUES ('";
				$sql .= $mainid."','";
				$sql .= $item_qr->NewsID."','";
				$sql .= $item_qr->NT02_TypeID."','";
				$sql .= $item_qr->NT03_SubTypeID."');";
				$this->db->query($sql);
			}
		}
		else if($sea == "" && $ssd == "" && $esd == "" && $ty != "0" && $sty != "0" && $di == "0" && $ui == "0")
		{
			//echo "9";
			$query_rss = "
				SELECT TOP 20 NewsID,NT02_TypeID,NT03_SubTypeID
				FROM View_RSS_news 
				WHERE Title LIKE '%$sea%'AND View_RSS_news.NT02_TypeID = '$ty' AND NT03_SubTypeID = '$sty' ";
			$qr = $this->db->query($query_rss);
			$lastid['id'] = $this->rss_m->last_rssid();
			//var_dump($lastid);
			$mainid = "";
			$sql = "";
			foreach($lastid['id'] as $last)
			{
				$mainid = $last->Main_RssID;
			}
			foreach ($qr->result() as $item_qr)
			{
				$sql = "INSERT INTO [NNT_RSSFEED].dbo.Detail_RSS (Main_RssID,Detail_NewsID,Detail_CatagoryID,Detail_SubCatagoryID)";
				$sql .= "VALUES ('";
				$sql .= $mainid."','";
				$sql .= $item_qr->NewsID."','";
				$sql .= $item_qr->NT02_TypeID."','";
				$sql .= $item_qr->NT03_SubTypeID."');";
				$this->db->query($sql);
			}
		}
		else if($sea == "" && $ssd == "" && $esd == "" && $ty != "0" && $sty != "0" && $di != "0" && $ui == "0")
		{
			//echo "10";
			$query_rss = "
				SELECT TOP 20 NewsID,NT02_TypeID,NT03_SubTypeID
				FROM View_RSS_news 
				WHERE Title LIKE '%$sea%' AND View_RSS_news.NT02_TypeID = '$ty' AND NT03_SubTypeID = '$sty' 
				AND Department = 
				(
					SELECT View_RSS_department.SC07_DepartmentName 
					FROM View_RSS_department
					WHERE View_RSS_department.SC07_DepartmentId = '$di'
				)";
			$qr = $this->db->query($query_rss);
			$lastid['id'] = $this->rss_m->last_rssid();
			//var_dump($lastid);
			$mainid = "";
			$sql = "";
			foreach($lastid['id'] as $last)
			{
				$mainid = $last->Main_RssID;
			}
			foreach ($qr->result() as $item_qr)
			{
				$sql = "INSERT INTO [NNT_RSSFEED].dbo.Detail_RSS (Main_RssID,Detail_NewsID,Detail_CatagoryID,Detail_SubCatagoryID)";
				$sql .= "VALUES ('";
				$sql .= $mainid."','";
				$sql .= $item_qr->NewsID."','";
				$sql .= $item_qr->NT02_TypeID."','";
				$sql .= $item_qr->NT03_SubTypeID."');";
				$this->db->query($sql);
			}
		}
		else if($sea == "" && $ssd == "" && $esd == "" && $ty == "0" && $sty == "0" && $di == "0" && $ui != "0")
		{
			//echo "11";
			$query_rss = "
				SELECT TOP 20 NewsID,NT02_TypeID,NT03_SubTypeID
				FROM View_RSS_news 
				WHERE Title LIKE '%$sea%' 
				AND Reporter = 
				(
					SELECT View_RSS_Reporter.Name
					FROM View_RSS_Reporter
					WHERE View_RSS_Reporter.SC03_UserId = '$ui'
				)";
			$qr = $this->db->query($query_rss);
			$lastid['id'] = $this->rss_m->last_rssid();
			//var_dump($lastid);
			$mainid = "";
			$sql = "";
			foreach($lastid['id'] as $last)
			{
				$mainid = $last->Main_RssID;
			}
			foreach ($qr->result() as $item_qr)
			{
				$sql = "INSERT INTO [NNT_RSSFEED].dbo.Detail_RSS (Main_RssID,Detail_NewsID,Detail_CatagoryID,Detail_SubCatagoryID)";
				$sql .= "VALUES ('";
				$sql .= $mainid."','";
				$sql .= $item_qr->NewsID."','";
				$sql .= $item_qr->NT02_TypeID."','";
				$sql .= $item_qr->NT03_SubTypeID."');";
				$this->db->query($sql);
			}
		}
		else if($sea == "" && $ssd == "" && $esd == "" && $ty == "0" && $sty == "0" && $di != "0" && $ui != "0")
		{
			//$query = "";
			//echo "12";
			$query_rss = "
				SELECT TOP 20 NewsID,NT02_TypeID,NT03_SubTypeID
				FROM View_RSS_news 
				WHERE Title LIKE '%$sea%' 
				AND Department = 
				(
					SELECT View_RSS_department.SC07_DepartmentName 
					FROM View_RSS_department
					WHERE View_RSS_department.SC07_DepartmentId = '$di'
				) 
				AND Reporter = 
				(
					SELECT View_RSS_Reporter.Name
					FROM View_RSS_Reporter
					WHERE View_RSS_Reporter.SC03_UserId = '$ui'
				)";
			$qr = $this->db->query($query_rss);
			$lastid['id'] = $this->rss_m->last_rssid();
			//var_dump($lastid);
			$mainid = "";
			$sql = "";
			foreach($lastid['id'] as $last)
			{
				$mainid = $last->Main_RssID;
			}
			foreach ($qr->result() as $item_qr)
			{
				$sql = "INSERT INTO [NNT_RSSFEED].dbo.Detail_RSS (Main_RssID,Detail_NewsID,Detail_CatagoryID,Detail_SubCatagoryID)";
				$sql .= "VALUES ('";
				$sql .= $mainid."','";
				$sql .= $item_qr->NewsID."','";
				$sql .= $item_qr->NT02_TypeID."','";
				$sql .= $item_qr->NT03_SubTypeID."');";
				$this->db->query($sql);
			}
		}
		else if($sea != "" && $ssd == "" && $esd == "" && $ty == "0" && $sty == "0" && $di == "0" && $ui != "0")
		{
			//echo "13";
			$query_rss = "
				SELECT TOP 20 NewsID,NT02_TypeID,NT03_SubTypeID
				FROM View_RSS_news 
				WHERE Title LIKE '%$sea%' 
				AND Reporter = 
				(
					SELECT View_RSS_Reporter.Name
					FROM View_RSS_Reporter
					WHERE View_RSS_Reporter.SC03_UserId = '$ui'
				)";
			$qr = $this->db->query($query_rss);
			$lastid['id'] = $this->rss_m->last_rssid();
			//var_dump($lastid);
			$mainid = "";
			$sql = "";
			foreach($lastid['id'] as $last)
			{
				$mainid = $last->Main_RssID;
			}
			foreach ($qr->result() as $item_qr)
			{
				$sql = "INSERT INTO [NNT_RSSFEED].dbo.Detail_RSS (Main_RssID,Detail_NewsID,Detail_CatagoryID,Detail_SubCatagoryID)";
				$sql .= "VALUES ('";
				$sql .= $mainid."','";
				$sql .= $item_qr->NewsID."','";
				$sql .= $item_qr->NT02_TypeID."','";
				$sql .= $item_qr->NT03_SubTypeID."');";
				$this->db->query($sql);
			}
		}
		else if($sea != "" && $ssd != "" && $esd != "" && $ty != "0" && $sty != "0" && $di != "0" && $ui != "0")
		{
			//echo "14";
			$query_rss = "
				SELECT TOP 100 NewsID,NT02_TypeID,NT03_SubTypeID
				FROM View_RSS_news 
				WHERE Title LIKE '%$sea%' AND (View_RSS_news.Date BETWEEN '$sd' AND '$ed')
				AND View_RSS_news.NT02_TypeID = '$ty' 
				AND NT03_SubTypeID = '$sty' AND Department = 
				(
					SELECT View_RSS_department.SC07_DepartmentName 
					FROM View_RSS_department
					WHERE View_RSS_department.SC07_DepartmentId = '$di'
				)
				AND Reporter = 
				(
					SELECT View_RSS_Reporter.Name
					FROM View_RSS_Reporter
					WHERE View_RSS_Reporter.SC03_UserId = '$ui'
				)";
			$qr = $this->db->query($query_rss);
			$lastid['id'] = $this->rss_m->last_rssid();
			//var_dump($lastid);
			$mainid = "";
			$sql = "";
			foreach($lastid['id'] as $last)
			{
				$mainid = $last->Main_RssID;
			}
			foreach ($qr->result() as $item_qr)
			{
				$sql = "INSERT INTO [NNT_RSSFEED].dbo.Detail_RSS (Main_RssID,Detail_NewsID,Detail_CatagoryID,Detail_SubCatagoryID)";
				$sql .= "VALUES ('";
				$sql .= $mainid."','";
				$sql .= $item_qr->NewsID."','";
				$sql .= $item_qr->NT02_TypeID."','";
				$sql .= $item_qr->NT03_SubTypeID."');";
				$this->db->query($sql);
			}
		}
		else if($sea == "" && $ssd != "" && $esd != "" && $ty == "0" && $sty == "0" && $di == "0" && $ui != "0")
		{
			//echo "15";
			$query_rss = "
				SELECT TOP 100 NewsID,NT02_TypeID,NT03_SubTypeID
				FROM View_RSS_news 
				WHERE Title LIKE '%$sea%' AND (View_RSS_news.Date BETWEEN '$sd' AND '$ed')
				AND Reporter = 
				(
					SELECT View_RSS_Reporter.Name
					FROM View_RSS_Reporter
					WHERE View_RSS_Reporter.SC03_UserId = '$ui'
				)";
			$qr = $this->db->query($query_rss);
			$lastid['id'] = $this->rss_m->last_rssid();
			//var_dump($lastid);
			$mainid = "";
			$sql = "";
			foreach($lastid['id'] as $last)
			{
				$mainid = $last->Main_RssID;
			}
			foreach ($qr->result() as $item_qr)
			{
				$sql = "INSERT INTO [NNT_RSSFEED].dbo.Detail_RSS (Main_RssID,Detail_NewsID,Detail_CatagoryID,Detail_SubCatagoryID)";
				$sql .= "VALUES ('";
				$sql .= $mainid."','";
				$sql .= $item_qr->NewsID."','";
				$sql .= $item_qr->NT02_TypeID."','";
				$sql .= $item_qr->NT03_SubTypeID."');";
				$this->db->query($sql);
			}
			
		}
		else if($sea == "" && $ssd == "" && $esd == "" && $ty != "0" && $sty != "0" && $di == "0" && $ui != "0")
		{
			//echo "16";
			$query_rss = "
				SELECT TOP 20 NewsID,NT02_TypeID,NT03_SubTypeID
				FROM View_RSS_news WHERE Title LIKE '%$sea%' AND View_RSS_news.NT02_TypeID = '$ty' 
				AND NT03_SubTypeID = '$sty' AND Reporter = 
				(
					SELECT View_RSS_Reporter.Name
					FROM View_RSS_Reporter
					WHERE View_RSS_Reporter.SC03_UserId = '$ui'
				)";
			$qr = $this->db->query($query_rss);
			$lastid['id'] = $this->rss_m->last_rssid();
			//var_dump($lastid);
			$mainid = "";
			$sql = "";
			foreach($lastid['id'] as $last)
			{
				$mainid = $last->Main_RssID;
			}
			foreach ($qr->result() as $item_qr)
			{
				$sql = "INSERT INTO [NNT_RSSFEED].dbo.Detail_RSS (Main_RssID,Detail_NewsID,Detail_CatagoryID,Detail_SubCatagoryID)";
				$sql .= "VALUES ('";
				$sql .= $mainid."','";
				$sql .= $item_qr->NewsID."','";
				$sql .= $item_qr->NT02_TypeID."','";
				$sql .= $item_qr->NT03_SubTypeID."');";
				$this->db->query($sql);
			}
		}
		else if($sea == "" && $ssd == "" && $esd == "" && $ty != "0" && $sty != "0" && $di != "0" && $ui != "0")
		{
			//echo "17";
			$query_rss = "
				SELECT TOP 20 NewsID,NT02_TypeID,NT03_SubTypeID
				FROM View_RSS_news WHERE Title LIKE '%$sea%' AND View_RSS_news.NT02_TypeID = '$ty' 
				AND NT03_SubTypeID = '$sty' 
				AND Department = 
				(
					SELECT View_RSS_department.SC07_DepartmentName 
					FROM View_RSS_department
					WHERE View_RSS_department.SC07_DepartmentId = '$di'
				) 
				AND Reporter = 
				(
					SELECT View_RSS_Reporter.Name
					FROM View_RSS_Reporter
					WHERE View_RSS_Reporter.SC03_UserId = '$ui'
				)";
			$qr = $this->db->query($query_rss);
			$lastid['id'] = $this->rss_m->last_rssid();
			//var_dump($lastid);
			$mainid = "";
			$sql = "";
			foreach($lastid['id'] as $last)
			{
				$mainid = $last->Main_RssID;
			}
			foreach ($qr->result() as $item_qr)
			{
				$sql = "INSERT INTO [NNT_RSSFEED].dbo.Detail_RSS (Main_RssID,Detail_NewsID,Detail_CatagoryID,Detail_SubCatagoryID)";
				$sql .= "VALUES ('";
				$sql .= $mainid."','";
				$sql .= $item_qr->NewsID."','";
				$sql .= $item_qr->NT02_TypeID."','";
				$sql .= $item_qr->NT03_SubTypeID."');";
				$this->db->query($sql);
			}
		}
		else if($sea != "" && $ssd != "" && $esd != "" && $ty == "0" && $sty == "0" && $di == "0" && $ui != "0")
		{
			//echo "18";
			$query_rss = "
				SELECT TOP 100 NewsID,NT02_TypeID,NT03_SubTypeID
				FROM View_RSS_news 
				WHERE Title LIKE '%$sea%' AND (View_RSS_news.Date BETWEEN '$sd' AND '$ed') AND Reporter = 
				(
					SELECT View_RSS_Reporter.Name
					FROM View_RSS_Reporter
					WHERE View_RSS_Reporter.SC03_UserId = '$ui'
				)";
			$qr = $this->db->query($query_rss);
			$lastid['id'] = $this->rss_m->last_rssid();
			//var_dump($lastid);
			$mainid = "";
			$sql = "";
			foreach($lastid['id'] as $last)
			{
				$mainid = $last->Main_RssID;
			}
			foreach ($qr->result() as $item_qr)
			{
				$sql = "INSERT INTO [NNT_RSSFEED].dbo.Detail_RSS (Main_RssID,Detail_NewsID,Detail_CatagoryID,Detail_SubCatagoryID)";
				$sql .= "VALUES ('";
				$sql .= $mainid."','";
				$sql .= $item_qr->NewsID."','";
				$sql .= $item_qr->NT02_TypeID."','";
				$sql .= $item_qr->NT03_SubTypeID."');";
				$this->db->query($sql);
			}
		}
		else if($sea != "" && $ssd != "" && $esd != "" && $ty != "0" && $sty != "0" && $di == "0" && $ui != "0")
		{
			//echo "19";
			$query_rss = "
				SELECT TOP 100 NewsID,NT02_TypeID,NT03_SubTypeID
				FROM View_RSS_news 
				WHERE Title LIKE '%$sea%' AND (View_RSS_news.Date BETWEEN '$sd' AND '$ed')
				AND View_RSS_news.NT02_TypeID = '$ty' 
				AND NT03_SubTypeID = '$sty' 
				AND Reporter = 
				(
					SELECT View_RSS_Reporter.Name
					FROM View_RSS_Reporter
					WHERE View_RSS_Reporter.SC03_UserId = '$ui'
				)";
			$qr = $this->db->query($query_rss);
			$lastid['id'] = $this->rss_m->last_rssid();
			//var_dump($lastid);
			$mainid = "";
			$sql = "";
			foreach($lastid['id'] as $last)
			{
				$mainid = $last->Main_RssID;
			}
			foreach ($qr->result() as $item_qr)
			{
				$sql = "INSERT INTO [NNT_RSSFEED].dbo.Detail_RSS (Main_RssID,Detail_NewsID,Detail_CatagoryID,Detail_SubCatagoryID)";
				$sql .= "VALUES ('";
				$sql .= $mainid."','";
				$sql .= $item_qr->NewsID."','";
				$sql .= $item_qr->NT02_TypeID."','";
				$sql .= $item_qr->NT03_SubTypeID."');";
				$this->db->query($sql);
			}
		}
		else if($sea != "" && $ssd != "" && $esd == "" && $ty == "0" && $sty == "0" && $di == "0" && $ui != "0")
		{	
			//echo "20";
			$query_rss = "
				SELECT TOP 100 NewsID,NT02_TypeID,NT03_SubTypeID
				FROM View_RSS_news 
				WHERE Title LIKE '%$sea%' AND View_RSS_news.Date > '$sd' 
				AND Reporter = 
				(
					SELECT View_RSS_Reporter.Name
					FROM View_RSS_Reporter
					WHERE View_RSS_Reporter.SC03_UserId = '$ui'
				)";
			$qr = $this->db->query($query_rss);
			$lastid['id'] = $this->rss_m->last_rssid();
			//var_dump($lastid);
			$mainid = "";
			$sql = "";
			foreach($lastid['id'] as $last)
			{
				$mainid = $last->Main_RssID;
			}
			foreach ($qr->result() as $item_qr)
			{
				$sql = "INSERT INTO [NNT_RSSFEED].dbo.Detail_RSS (Main_RssID,Detail_NewsID,Detail_CatagoryID,Detail_SubCatagoryID)";
				$sql .= "VALUES ('";
				$sql .= $mainid."','";
				$sql .= $item_qr->NewsID."','";
				$sql .= $item_qr->NT02_TypeID."','";
				$sql .= $item_qr->NT03_SubTypeID."');";
				$this->db->query($sql);
			}
		}
		else if($sea == "" && $ssd != "" && $esd != "" && $ty != "0" && $sty != "0" && $di == "0" && $ui == "0")
		{	
			//echo "21";
			$query_rss = "
				SELECT TOP 100 NewsID,NT02_TypeID,NT03_SubTypeID
				FROM View_RSS_news 
				WHERE (View_RSS_news.Date BETWEEN '$sd' AND '$ed')
				AND View_RSS_news.NT02_TypeID = '$ty' 
				AND NT03_SubTypeID = '$sty'";
			$qr = $this->db->query($query_rss);
			$lastid['id'] = $this->rss_m->last_rssid();
			//var_dump($lastid);
			$mainid = "";
			$sql = "";
			foreach($lastid['id'] as $last)
			{
				$mainid = $last->Main_RssID;
			}
			foreach ($qr->result() as $item_qr)
			{
				$sql = "INSERT INTO [NNT_RSSFEED].dbo.Detail_RSS (Main_RssID,Detail_NewsID,Detail_CatagoryID,Detail_SubCatagoryID)";
				$sql .= "VALUES ('";
				$sql .= $mainid."','";
				$sql .= $item_qr->NewsID."','";
				$sql .= $item_qr->NT02_TypeID."','";
				$sql .= $item_qr->NT03_SubTypeID."');";
				$this->db->query($sql);
			}
		}
		else if($sea == "" && $ssd != "" && $esd != "" && $ty == "0" && $sty == "0" && $di == "0" && $ui == "0")
		{	
			//echo "22";
			$query_rss = "
				SELECT TOP 100 NewsID,NT02_TypeID,NT03_SubTypeID
				FROM View_RSS_news 
				WHERE (View_RSS_news.Date BETWEEN '$sd' AND '$ed')";
			$qr = $this->db->query($query_rss);
			$lastid['id'] = $this->rss_m->last_rssid();
			//var_dump($lastid);
			$mainid = "";
			$sql = "";
			foreach($lastid['id'] as $last)
			{
				$mainid = $last->Main_RssID;
			}
			foreach ($qr->result() as $item_qr)
			{
				$sql = "INSERT INTO [NNT_RSSFEED].dbo.Detail_RSS (Main_RssID,Detail_NewsID,Detail_CatagoryID,Detail_SubCatagoryID)";
				$sql .= "VALUES ('";
				$sql .= $mainid."','";
				$sql .= $item_qr->NewsID."','";
				$sql .= $item_qr->NT02_TypeID."','";
				$sql .= $item_qr->NT03_SubTypeID."');";
				$this->db->query($sql);
			}
		}
		else if($sea == "" && $ssd != "" && $esd != "" && $ty != "0" && $sty != "0" && $di != "0" && $ui != "0")
		{
			//echo "23";
			$query_rss = "
				SELECT TOP 100 NewsID,NT02_TypeID,NT03_SubTypeID
				FROM View_RSS_news 
				WHERE (View_RSS_news.Date BETWEEN '$sd' AND '$ed')
				AND View_RSS_news.NT02_TypeID = '$ty' 
				AND NT03_SubTypeID = '$sty'
				AND Department = 
				(
					SELECT View_RSS_department.SC07_DepartmentName 
					FROM View_RSS_department
					WHERE View_RSS_department.SC07_DepartmentId = '$di'
				)
				AND Reporter = 
				(
					SELECT View_RSS_Reporter.Name
					FROM View_RSS_Reporter
					WHERE View_RSS_Reporter.SC03_UserId = '$ui'
				)";
			$qr = $this->db->query($query_rss);
			$lastid['id'] = $this->rss_m->last_rssid();
			//var_dump($lastid);
			$mainid = "";
			$sql = "";
			foreach($lastid['id'] as $last)
			{
				$mainid = $last->Main_RssID;
			}
			foreach ($qr->result() as $item_qr)
			{
				$sql = "INSERT INTO [NNT_RSSFEED].dbo.Detail_RSS (Main_RssID,Detail_NewsID,Detail_CatagoryID,Detail_SubCatagoryID)";
				$sql .= "VALUES ('";
				$sql .= $mainid."','";
				$sql .= $item_qr->NewsID."','";
				$sql .= $item_qr->NT02_TypeID."','";
				$sql .= $item_qr->NT03_SubTypeID."');";
				$this->db->query($sql);
			}
		}
		else if($sea == "" && $ssd == "" && $esd == "" && $ty != "0" && $sty == "0" && $di == "0" && $ui == "0")
		{
			//echo "24";
			$query_rss = "
				SELECT TOP 20 NewsID,NT02_TypeID,NT03_SubTypeID
				FROM View_RSS_news 
				WHERE View_RSS_news.NT02_TypeID = '$ty' 
				";
			$qr = $this->db->query($query_rss);
			$lastid['id'] = $this->rss_m->last_rssid();
			//var_dump($lastid);
			$mainid = "";
			$sql = "";
			foreach($lastid['id'] as $last)
			{
				$mainid = $last->Main_RssID;
			}
			foreach ($qr->result() as $item_qr)
			{
				$sql = "INSERT INTO [NNT_RSSFEED].dbo.Detail_RSS (Main_RssID,Detail_NewsID,Detail_CatagoryID,Detail_SubCatagoryID)";
				$sql .= "VALUES ('";
				$sql .= $mainid."','";
				$sql .= $item_qr->NewsID."','";
				$sql .= $item_qr->NT02_TypeID."','";
				$sql .= $item_qr->NT03_SubTypeID."');";
				$this->db->query($sql);
			}
		}
		else
		{
			//echo "0";
			$query_rss = "
				SELECT TOP 20 NewsID,NT02_TypeID,NT03_SubTypeID
				FROM View_RSS_news 
				ORDER BY Date DESC";
			$qr = $this->db->query($query_rss);
			$lastid['id'] = $this->rss_m->last_rssid();
			//var_dump($lastid);
			$mainid = "";
			$sql = "";
			foreach($lastid['id'] as $last)
			{
				$mainid = $last->Main_RssID;
			}
			foreach ($qr->result() as $item_qr)
			{
				$sql = "INSERT INTO [NNT_RSSFEED].dbo.Detail_RSS (Main_RssID,Detail_NewsID,Detail_CatagoryID,Detail_SubCatagoryID)";
				$sql .= "VALUES ('";
				$sql .= $mainid."','";
				$sql .= $item_qr->NewsID."','";
				$sql .= $item_qr->NT02_TypeID."','";
				$sql .= $item_qr->NT03_SubTypeID."');";
				$this->db->query($sql);
			}
		}
		$sql_update = "
			UPDATE [NNT_RSSFEED].dbo.Main_RSS 
			SET Main_RssID_Encode = '".md5($mainid)."'
			WHERE Main_RssID = '".$mainid."';";
		$this->db->query($sql_update);
		return md5($mainid);
	}
	public function get_status()
	{
		$id = $this->input->get('mid');
		$query = "
			SELECT Main_StatusVDO,Main_StatusPicture,Main_StatusOther,Main_StatusVoice
			FROM [NNT_RSSFEED].dbo.Main_RSS
			WHERE Main_RssID= '$id';";
		return $this->db->query($query)->result();
	}
	public function get_rss_newsid($page)
	{
		$query = "
			SELECT Detail_RSS.Detail_NewsID,Detail_RSS.Main_RssID,Main_RSS.Main_StatusVDO,Main_RSS.Main_StatusPicture,Main_RSS.Main_StatusVoice,Main_RSS.Main_StatusOther
			FROM [NNT_RSSFEED].dbo.Detail_RSS
			INNER JOIN [NNT_RSSFEED].dbo.Main_RSS
			ON Detail_RSS.Main_RssID = Main_RSS.Main_RssID
			WHERE Main_RSS.Main_RssID_Encode = '$page'";
		return $this->db->query($query)->result();
	}
	public function get_rss($page)
	{
		$query = "
			SELECT Title,Date
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
		$this->db->insert('[NNT_RSSFEED].dbo.UserLog', $data); 
	}
	public function last_log()
	{
		$query = "
			SELECT TOP 1 Log_ID
			FROM [NNT_RSSFEED].dbo.UserLog
			ORDER BY Log_ID DESC";
		return $this->db->query($query)->result();
	}
	public function updatelog($id)
	{
		$time = date("H:i:s");
		$sql_update = "
			UPDATE [NNT_RSSFEED].dbo.UserLog 
			SET Log_EndLogin = '".$time."'
			WHERE Log_ID = '".$id."';";
		$this->db->query($sql_update);
	}
}  
?>