<?php
	header("Content-Type: application/rss+xml; charset=UTF-8");
	$text_rss = "";
	$i=0;
	$j=0;
	foreach($title as $titles)
	{	
		$t[$i] = $titles[0]->Title;
		$i++;
	}
	foreach($query as $item)
	{	
		$vdo = $item->Main_StatusVDO;
		$voice = $item->Main_StatusVoice;
		$picture = $item->Main_StatusPicture;
		$other = $item->Main_StatusOther;
		$first_rss = '<?xml version="1.0" encoding="utf-8"?>';
		$first_rss .= '<rss xmlns:a10="http://www.w3.org/2005/Atom" version="2.0">';
		$first_rss .= '<channel>';
		$first_rss .= '<title>NNT News RSS/XML Feed</title>';
		$first_rss .= '<link>'.base_url().'index.php/rss/view_rss/'.$item->Main_RssID.'</link>';
		$first_rss .= '<description>NNT News Feed</description>';
		$first_rss .= '<a10:id>NNT News Feed</a10:id>';
		
	
		$text_rss .= '<item>';
		$text_rss .= '<guid isPermaLink="false">'.$item->Detail_NewsID;
		$text_rss .= '</guid>';
		$text_rss .= '<link>'.base_url().'index.php/rss/detail?id='.$item->Detail_NewsID.'&amp;mid='.$item->Main_RssID;
		$text_rss .= '</link>';
		$text_rss .= '<title>'.$t[$j];
		$text_rss .= '</title>';
		/*$text_rss .= '<description>'.$item->Detail.'&lt;b&gt;ผู้สื่อข่าว : &lt;/b&gt;'.$item->Reporter;
		$text_rss .= '&lt;br /&gt;&lt;b&gt;หน่วยงาน : &lt;/b&gt;'.$item->Department;
		$text_rss .= '&lt;br /&gt;&lt;b&gt;ที่มาของข่าว :'.$item->Rewrite;
		$text_rss .= ':&lt;/b&gt;';
		$text_rss .= '</description>';*/
		$text_rss .= '<a10:updated>'.date('c');
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
	