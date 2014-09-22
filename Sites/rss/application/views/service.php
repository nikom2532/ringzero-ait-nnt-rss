<?php
	header("Content-Type: application/xml; charset=UTF-8");

	$text = '<?xml version="1.0" encoding="utf-8"?>';
	$text .= '<rss xmlns:a10="http://www.w3.org/2005/Atom" version="2.0">';
	$text .= '<channel>';
	$text .= '<title>'.$title.'</title>';
	$text .= '<link>'.$link.'</link>';
	$text .= '<description src="'.$description_img.'">'.$description.'</description>';
	$text .= '<a10:id>'.$id.'</a10:id>';
	foreach ($news as $news_item) 
	{
		$text .= '<item>';
		$text .= '<guid isPermaLink="false">'.$news_item->NT01_NewsID.'</guid>';
		$text .= '<title>'.$news_item->NT01_NewsTitle.'</title>';
		$text .= '<description>';
		$text .= '<![CDATA[';
		foreach ($pictures as $key) 
		{
			foreach ($key as $picture) 
			{
				if($news_item->NT01_NewsID == $picture->NT01_NewsID)
					$text .= '<img src="'.$url.$picture->NT11_PicPath.'" height="150" width="250" title="" /><br/>';
			}
		}
		$text .= $news_item->NT01_NewsDesc.'<br/><br/>';
		foreach ($users as $key) 
		{
			foreach ($key as $user) 
			{
				if($news_item->NT01_ReporterID == $user->SC03_UserId)
					$reporter_name = $user->SC03_FName;
				if($news_item->NT01_ReWriteID == $user->SC03_UserId)
					$rewriter_name = $user->SC03_FName;
			}
		}
		$text .= 'ผู้สื่อข่าว&nbsp;&nbsp;'.$reporter_name.'<br/>
			Rewriter&nbsp;&nbsp;'.$rewriter_name.'<br/>
			แหล่งที่มา&nbsp;&nbspสำนักข่าวแห่งชาติ&nbsp;กรมประชาสัมพันธ์
		]]>';
		$text .= '</description>';
		foreach ($pictures as $key) 
		{
			foreach ($key as $picture) 
			{
				if($news_item->NT01_NewsID == $picture->NT01_NewsID)
					$text .= '<enclosure type="image/jpeg" url="'.$url.$picture->NT11_PicPath.'"></enclosure>';
				if($news_item->NT01_NewsID == $picture->NT01_NewsID)
					$text .= '<image>
								<url>'.$url.$picture->NT11_PicPath.'</url>
								<title>'.$picture->NT11_PicID.'</title>
								<keyword>'.$picture->NT11_PicName.'</keyword>
							</image>';
			}
		}
		$text .= '<a10:updated>'.date("c",strtotime($news_item->NT01_NewsDate)).'</a10:updated>';
		$text .= '<pubDate>'.date('c').'</pubDate>';
		$text .= '<updated>'.date('c').'</updated>';
		$text .= '</item>';
	}
	$text .= '</channel>';
	$text .= '</rss>';
	echo $text;
?>