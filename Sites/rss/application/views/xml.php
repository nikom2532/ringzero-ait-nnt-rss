<?php
	header("Content-Type: application/xml; charset=UTF-8");
	$text_rss = "";
	$img = "";
	$i=0; 	//set values of array
	$j=0;	//set items of array
	$k=0;	//set picture items of array
	if (is_array($title))
	{
		foreach($title as $item_title)
		{	
			$t[$i] = $item_title[0]->Title;	//set title news array
			$u[$i] = $item_title[0]->Date;	//set date news array
			$v[$i] = $item_title[0]->Detail;	//set detail news array
			$w[$i] = $item_title[0]->Rewrite;	//set rewrite news array
			$x[$i] = $item_title[0]->Reporter;	//set reporter news array
			$y[$i] = $item_title[0]->Department;	//set department news array

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
		$vdo = $item->Main_StatusVDO;
		$voice = $item->Main_StatusVoice;
		$picture = $item->Main_StatusPicture;
		$other = $item->Main_StatusOther;
		$first_rss = '<?xml version="1.0" encoding="utf-8"?>';
		$first_rss .= '<rss xmlns:a10="http://www.w3.org/2005/Atom" version="2.0"';

		$first_rss .= '>';
		
		$first_rss .= '<channel>';
		$first_rss .= '<title>NNT NEWS</title>';
		$first_rss .= '<link>'.base_url().'rss/view_rss/'.$item->Main_RssID.'</link>';
		$first_rss .= '<description src="http://localhost:8080/rss/rss/assets/images/RSS_Logo.png">NNT News Feed</description>';
		$first_rss .= '<a10:id>NNT NEWS FEED</a10:id>';

		$text_rss .= '<item>';
		$text_rss .= '<guid isPermaLink="false">'.$item->Detail_NewsID;
		$text_rss .= '</guid>';
		$text_rss .= '<link>'.base_url().'rss/detail?id='.$item->Detail_NewsID.'&amp;mid='.$item->Main_RssID;
		$text_rss .= '</link>';
		$text_rss .= '<title>'.$t[$j];
		$text_rss .= '</title>';


		$text_rss .= '<description>';
		$text_rss .= '<![CDATA[
		<img src="'.$img[$j].'" height="150" width="250" title="" />&nbsp;&nbsp;'.$v[$j].'<br/><br/>ผู้สื่อข่าว&nbsp;&nbsp;'.$x[$j].'<br/>Rewriter&nbsp;&nbsp;'.$w[$j].'
		<br/>แหล่งที่มา&nbsp;&nbsp;'.$y[$j].'<br/>สำนักข่าวแห่งชาติ&nbsp;กรมประชาสัมพันธ์
		]]>';
		$text_rss .= '</description>';

		$text_rss .= '<a10:updated>'.date("c",strtotime($u[$j]));
		$text_rss .= '</a10:updated>';

		$text_rss .= '<enclosure type="image/jpeg" url="'.$img[$j].'"></enclosure>';
		$text_rss .= '<image>
					     <url>'.$img[$j].'</url>
					     <title>NNT NEWS</title>
					     <link>http://thainews.prd.go.th</link>
					   </image>';

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
	$f = fopen( 'rss.xml' , 'w' ); //ส่วนของการสร้างไฟล์ XML 
	fputs( $f , $rss_file );
	fclose( $f );
?>
	