<?php
	header("Content-Type: application/xml; charset=UTF-8");
	$text_rss = "";
	$img = "";
	$i=0;
	$j=0;
	$k=0;
	if (is_array($title))
	{
		foreach($title as $item_title)
		{	
			$t[$i] = $item_title[0]->Title;
			$u[$i] = $item_title[0]->Date;
			$i++;
		}
	}
	if (is_array($picture))
	{
		foreach($picture as $item_picture)
		{	
			if(@$item_picture[0]->url != "")
				$img[$k] = @$item_picture[0]->url;
			else
				$img[$k] = base_url()."assets/images/default/".$k.".jpg";
			$k++;
		}
	}
	foreach($query as $item)
	{	
		
		$first_rss = '<?xml version="1.0" encoding="utf-8"?>';
		$first_rss .= '<rss xmlns:a10="http://www.w3.org/2005/Atom" version="2.0"';

		$first_rss .= '>';
		
		$first_rss .= '<channel>';
		$first_rss .= '<title>NNT News RSS/XML Feed</title>';
		$first_rss .= '<link>'.base_url().'rss/view_rss/'.$item->NewsID.'</link>';
		$first_rss .= '<description src="http://localhost:8080/rss/rss/assets/images/RSS_Logo.png">NNT News Feed</description>';
		$first_rss .= '<a10:id>NNT News Feed</a10:id>';

		//$first_rss .= '<image><url>'.base_url().'/assets/images/RSS_Logo.png</url><title>W3Schools.com</title><link>http://www.w3schools.com</link></image>';
		$text_rss .= '<item>';
		/*$text_rss .= '<content:encoded><![CDATA[';
		$text_rss .= '<figure><img src="'.base_url().'assets/images/RSS_Logo.png" width="400" height="300"></figure>';
		$text_rss .= ']]></content:encoded>';*/
		//$text_rss .= '<enclosure url="'.base_url().'/assets/images/RSS_Logo.png" type="image/png" />';
		$text_rss .= '<guid isPermaLink="false">'.$item->NewsID;
		$text_rss .= '</guid>';
		$text_rss .= '<link>'.base_url().'rss/detail?id='.$item->NewsID;
		$text_rss .= '</link>';
		$text_rss .= '<title>'.$t[$j];
		$text_rss .= '</title>';

		/*$text_rss .= '<description>';
		$text_rss .= '<![CDATA[
		<img src="'.base_url().'/assets/images/default.jpg" height="150" width="250" title="โออิชิเปิดความสนุกกับเกมส์โชว์ในตำนานจากญี่ปุ่น" />&nbsp;&nbsp;'.$t[$j].'
		]]>';
		$text_rss .= '</description>';*/

		$text_rss .= '<description>';
		$text_rss .= '<![CDATA[
		<img src="'.$img[$j].'" height="150" width="250" title="" />&nbsp;&nbsp;'.$item->Detail.'
		]]>';
		$text_rss .= '</description>';

		/*$text_rss .= '<description>'.$item->Detail.'&lt;b&gt;ผู้สื่อข่าว : &lt;/b&gt;'.$item->Reporter;
		$text_rss .= '&lt;br /&gt;&lt;b&gt;หน่วยงาน : &lt;/b&gt;'.$item->Department;
		$text_rss .= '&lt;br /&gt;&lt;b&gt;ที่มาของข่าว :'.$item->Rewrite;
		$text_rss .= ':&lt;/b&gt;';
		$text_rss .= '</description>';*/
		$text_rss .= '<a10:updated>'.date("c",strtotime($u[$j]));
		$text_rss .= '</a10:updated>';

		$text_rss .= '<pubDate>'.date('c');
		$text_rss .= '</pubDate>';
		$text_rss .= '<updated>'.date('c');
		$text_rss .= '</updated>';
		$text_rss .= '</item>';

		$last_rss = '</channel>';
		$last_rss .= '</rss>';
		$j++;
	}
	echo $rss_file = $first_rss.$text_rss.$last_rss;
?>
	