<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- IE Compatibility modes -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><!--   -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RSS FEEDS</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../favicon.ico"> 

  <?php echo css_asset('reset.css'); ?>
	<?php echo css_asset('style.css'); ?>
	<!-- Add jQuery library -->
	<script type="text/javascript" src="<?php echo other_asset_url('lib/jquery-1.10.1.min.js') ;?>"></script>

	<!-- Add mousewheel plugin (this is optional) -->
	<script type="text/javascript" src="<?php echo other_asset_url('lib/jquery.mousewheel-3.0.6.pack.js') ;?>"></script>

	<!-- Add fancyBox main JS and CSS files -->
	<script type="text/javascript" src="<?php echo other_asset_url('source/jquery.fancybox.js?v=2.1.5'); ?>"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo other_asset_url('source/jquery.fancybox.css?v=2.1.5') ;?>" media="screen" />

	<!-- Add Button helper (this is optional) -->
	<link rel="stylesheet" type="text/css" href="<?php echo other_asset_url('source/helpers/jquery.fancybox-buttons.css?v=1.0.5') ;?>" />
	<script type="text/javascript" src="<?php echo other_asset_url('source/helpers/jquery.fancybox-buttons.js?v=1.0.5'); ?>"></script>

	<!-- Add Thumbnail helper (this is optional) -->
	<link rel="stylesheet" type="text/css" href="<?php echo other_asset_url('source/helpers/jquery.fancybox-thumbs.css?v=1.0.7');?>" />
	<script type="text/javascript" src="<?php echo other_asset_url('source/helpers/jquery.fancybox-thumbs.js?v=1.0.7'); ?>"></script>

	<!-- Add Media helper (this is optional) -->
	<script type="text/javascript" src="<?php echo other_asset_url('source/helpers/jquery.fancybox-media.js?v=1.0.6'); ?>"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			/*
			 *  Simple image gallery. Uses default settings
			 */

			$('.fancybox').fancybox();

		});
	</script>
	<style type="text/css">
		.fancybox-custom .fancybox-skin {
			box-shadow: 0 0 50px #222;
		}
	</style>
	<link rel="stylesheet" type="text/css" href="<?php echo other_asset_url('skin/minimalist.css');?>" />
	<script type="text/javascript" src="<?php echo other_asset_url('js/flowplayer.min.js'); ?>"></script>
</head>
<body>
    <div class="container">
    <!-- HEADER -->
        <div class="wrapper">
            <div class="bg-header">
                <div id="header">
                    <div class="logo">
                        <img src="<?php echo image_asset_url('logo_rss.png')?>" alt="Logo" style="width:auto;">
                        <h1>                        
                            <label class="th"></br>
                            <span class="bold"></span></label>
                        </h1>
                        <!--<img src="<?php echo image_asset_url('sh_logo_header.png')?>" alt="Logo" style="width:100%">-->
                    </div>
                </div>
            </div>
        </div>
    <!-- Content -->

        <div class="wrapper">
            <div class="content">
                <div id="detail-form">

					<?php foreach ($query as $item){;
						$id = $item->NewsID;
						$title = $item->Title;
						$detail = $item->Detail;
						$date = $item->Date;
						$views = $item->Views;
						$reporter = $item->Reporter;
						$rewrite = $item->Rewrite;
						$department = $item->Department;
						$d = date("d",strtotime($date));
						$m = date("m",strtotime($date));
						$y = date("Y",strtotime($date));
						$y = $y+543;
						$y = substr($y,-2);
						$video = "";
						$img = "";
						$voice = "";
						$other = "";
						$vdo_status = "";
						$voice_status = "";
						$picture_status = "";
						$other_status = "";
						foreach ($status as $item2)
						{
							$vdo_status = $item2->Main_StatusVDO;
							$voice_status = $item2->Main_StatusVoice;
							$picture_status = $item2->Main_StatusPicture;
							$other_status = $item2->Main_StatusOther;
						}
						?>
                          <div class="row">
                              <div class="col-lg-6">
								  <?php 
								  if($vdo_status != "false")
								  {
								  ?>	
                                  <div class="vdo">
								  <?php foreach ($query3 as $item3){;
									$video = $item3->url;
									$video_extension = $item3->NT10_Extension;
									$array = array('mp4','webm','ogg');
									if (in_array($video_extension, $array))
										echo "";
									else
										echo "ไม่สนับสนุนรูปแบบไฟล์"
								  ?>
								  <div class="flowplayer" data-swf="<?php echo other_asset_url('skin/flowplayer.swf'); ?>" data-ratio="0.4167">
								  <video width="482" height="270" controls>
									<source src="<?php echo $video;?>" type="video/mp4">
									<source src="<?php echo $video;?>" type="video/ogv">
									<source src="<?php echo $video;?>" type="video/webm">
								  </video>
								  </div>
								  <p style="width: 100%;float: left;margin-top: 10px;text-align: right;color:#868686;"><a href="<?php echo $video ;?>" style="text-decoration:none;text-decoration:none;color:#868686;" download>Download Video&nbsp;&nbsp;<img src="<?php echo image_asset_url('download.png')?>"></a></p>
								  <?php }?>
                                  </div>
								  <?php 
								  }
								  if($voice_status != "false")
								  {
								  ?>
								  <div class="vdo">
								  <?php foreach ($query4 as $item4){;
									$voice = $item4->url;
									/*$video_extension = $item3->NT10_Extension;
									$array = array('mp4','webm','ogg');
									if (in_array($video_extension, $array))
										echo "";
									else
										echo "ไม่สนับสนุนรูปแบบไฟล์"*/
								  ?>
								  <audio width="482" height="270" controls>
									<source src="<?php echo $voice;?>" type="audio/mpeg">
								  </audio>
								  <p style="width: 100%;float: left;margin-top: 10px;text-align: right;color:#868686;"><a href="<?php echo $video ;?>" style="text-decoration:none;text-decoration:none;color:#868686;" download>Download Audio&nbsp;&nbsp;<img src="<?php echo image_asset_url('download.png')?>"></a></p>
								  <?php }?>
                                  </div>
								  <?php 
								  }
								  if($picture_status != "false")
								  {
								  ?>
                                  <div class="image-list">
								  <?php foreach ($query2 as $item2){;
									$img = $item2->url;
								  ?>
									<a class="fancybox" href="<?php echo $img ?>" data-fancybox-group="gallery" title=""><img src="<?php echo $img ?>" alt="" / style="width:30%;margin-top:10px;"></a>
								  <?php }?>
                                  </div>
								  <?php 
								  }
								  if($other_status != "false")
								  {
								  ?>
								  <div class="vdo">
								  <?php foreach ($query5 as $item5){;
									$other = $item5->url;
								  ?>
								  <p style="width: 100%;float: left;margin-top: 10px;text-align: right;"><a href="<?php echo $other ;?>" style="text-decoration:none;text-decoration:none;color:#868686;" download><?php echo $item5->NT13_FileName ?>&nbsp;&nbsp;<img src="<?php echo image_asset_url('download.png')?>"></a></p>
								  <?php }?>
                                  </div>
								  <?php }?>
                              </div>
							  <?php
								if($video == NULL && $img == NULL && $other == NULL && $voice == NULL)
									$col="col-lg-12";
								else
									$col="col-lg-6";
							  ?>
                              <div class="<?php echo $col;?>" >
                                <div id="detail">
                                    <h1><?php echo $title;?></h1>
                                    <p><?php echo $d.".".$m.".".$y;?>  |  (<?php echo $views;?> ผู้เข้าชม )</p>
                                    <p><?php echo $detail?></p>
									<!--<p>นายกรัฐมนตรี ย้ำผู้ว่าราชการจังหวัดทั่วประเทศในแนวทางแก้ปัญหาภัยแล้ง ภัยหนาว และอุบัติเหตุใน
                                          ช่วงปีใหม่ โดยให้ทุกฝ่ายที่เกี่ยวข้องบูรณาการร่วมกันพร้อมเน้นในการจัดทำยุทธศาสตร์จังหวัดให้ต่อ
                                          เนื่องสอดคล้องกับภัยพิบัติต่างๆ ในพื้นที่
                                    </p>
                                    <p>
                                          นางสาวยิ่งลักษณ์ ชินวัตร นายกรัฐมนตรีและรัฐมนตรีว่าการกระทรวงกลาโหม เป็นประธานประชุมติด
                                          ตามแก้ปัญหาความเดือดร้อนของประชาชนในภาคตะวันออกเฉียงเหนือ ร่วมกับผู้ว่าราชการจังหวัดทั้ง 
                                          20 จังหวัดและ 11 กระทรวงที่เกี่ยวข้อง ที่ศาลากลางจังหวัดร้อยเอ็ด เพื่อเตรียมความพร้อมป้องกัน 
                                          แก้ไขปัญหาและให้การช่วยเหลือผู้ประสบภัยทั้งภัยหนาว ภัยแล้งและอุบัติเหตุในช่วงเทศกาลปีใหม่ 
                                          โดยประชุมผ่านระบบวีดีโอคอนเฟอร์เร้นซ์กับผู้ว่าราชการทั่วประเทศ
                                    </p>
                                    <p>
                                          นายกรัฐมนตรี ได้เน้นย้ำให้ป้องกันและบรรเทาสาธารณภัยจังหวัดและหน่วยงานที่เกี่ยวข้องบริหารจัด
                                          การภัยพิบัติในรูปแบบ Single Command Center นำหลัก 2 พี 2 อาร์ มาปฏิบัติโดยกำหนดมาตรการ
                                          รองรับและแก้ไขปัญหาให้สอดคล้องกับสภาพความเสี่ยง ระดับความรุนแรงในพื้นที่ พร้อมเร่งช่วยเหลือ
                                          ผู้ประสบภัยให้รวดเร็วทั่วถึง ครอบคลุมในทุกพื้นที่ โดยเฉพาะพื้นที่ห่างไกล ขณะที่เรื่องอุบัติเหตุช่วงปี
                                          ใหม่ขอให้ทุกฝ่ายช่วยกันป้องกันและรณรงค์ ซึ่งเป็นสิ่งที่รัฐบาลอยากเห็นการลดอุบัติเหตุและสูญเสีย
                                          ให้น้อยลงในทุกๆปี
                                    </p>
                                    <p>
                                          นอกจากนี้ นายกรัฐมนตรี ย้ำผู้ว่าราชการจังหวัดทุกจังหวัด ในการจัดทำยุทธศาสตร์จังหวัดให้ต่อเนื่อง 
                                          สอดคล้องกับภัยพิบัติต่างๆ ในพื้นที่ และให้วางแผนล่วงหน้าก่อนที่จะเกิดภัยพิบัติขึ้น โดยประเมินจาก
                                          ประสบการณ์ที่ผ่านมาในอดีต
                                    </p>-->
                                </div>
                                <div class="news-form">
                                    <h1 style="margin-bottom: 5px;">ข้อมูลข่าวและที่มา</h1>
                                    <p>ผู้สื่อข่าว : <?php echo $reporter;?></p>
                                    <p>Rewriter : <?php echo $rewrite;?></p>
                                    <p>แหล่งที่มา : <?php echo $department;?></p>
                                    <p>สำนักข่าวแห่งชาติ กรมประชาสัมพันธ์ : http://thainews.prd.go.th</p>
                                </div>
                              </div>
                           </div>

                 <?php } ?>   
                </div>

            </div>
        </div>
    </div>
</body>
</html>