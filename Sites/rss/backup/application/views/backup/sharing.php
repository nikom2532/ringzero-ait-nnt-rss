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
	<?php echo js_asset('jquery-1.10.1.min.js'); ?>

</head>
<body>
<form action="#" method="post">
    <div class="container">
    <!-- HEADER -->
        <div class="wrapper">
            <div class="bg-header">
                <div id="header">
                    <div class="logo">
                        <img src="<?php echo image_asset_url('NNT_Logo.png')?>" alt="Logo" style="width:110px;">
                        <h1>                        
                            <label class="th">ระบบช่องทางเผยแพร่ ข้อมูลข่าวสาร </br>
                            <span class="bold">RSS FEEDS</span></label>
                        </h1>
                        <img src="<?php echo image_asset_url('sh_logo_header.png')?>" alt="Logo" style="width:100%">
                    </div>
                </div>
            </div>
        </div>
    <!-- Content -->

        <div class="wrapper">
            <div class="content">
                <div class="welcome">
                <p><b style=" color: #0808A7;font-weight: bold;">Welcome to: </b><span style="color: #0404F5;">admin</span> | <a href="index">logout</a></p>
                </div>
                <div id="share-form">
                    <div id="search-form">

                          <div class="row">
                              <div class="col-lg-12">
                                <label style="float: left;text-align: right;width: 14%;">SEARCH</label>
                                <input class="txt-field" type="text" value="" name="date-from"  placeholder="" style=" margin-left: 15px;width: 77%;">
                              </div>
                          </div>
                    
  
                          <div class="row">
                              <div class="col-lg-6">
                                  <label >วันที่</label>
                                  <input type="text" class="form-control" id="InputKeyword" placeholder="" >
                              </div>
                              <div class="col-lg-6">
                                  <label >ถึง</label>
                                  <input type="text" class="form-control" id="InputKeyword" placeholder="" >
                              </div>
                           </div>
                      
                           <div class="row">
                              <div class="col-lg-6">
                                  <label >หมวดหมู่ข่าว</label>
                                  <input type="text" class="form-control" id="InputKeyword" placeholder="" >
                              </div>
                              <div class="col-lg-6">
                                  <label >หมวดหมู่ข่าวย่อย</label>
                                  <input type="text" class="form-control" id="InputKeyword" placeholder="" >
                              </div>
                            </div>

                         <div class="row">
                              <div class="col-lg-6">
                                  <label >หน่วยงาน</label>
                                  <input type="text" class="form-control" id="InputKeyword" placeholder="" >
                              </div>
                          </div>
                         <div class="col-lg-12" style="text-align: center;">
                            <input class="bt" type="submit" value="ค้นหาข่าว" name="share" style="width:18%;padding: 4px;">
                         </div>
                      
                    </div>
                </div>
				<form name="form1" action="get_rss" method="post">
                <div id="table-list">
                   <div class="row">
                        <div class="col-lg-left">
                            <label style="font-weight:bold;">ไฟล์ประกอบข่าว</label>
                            <input type="checkbox" name="vdo"  class="chk" value="0">วิดีโอ
                            <input type="checkbox" name="sound" class="chk" value="1">เสียง
                            <input type="checkbox" name="image" class="chk" value="2">ภาพ
                            <input type="checkbox" name="other" class="chk" value="3">อื่นๆ
                        </div>
                        <div class="col-lg-left" style="text-align: right;">
                           <img src="<?php echo image_asset_url('rss_btn.png')?>" style="margin-top:-30px"  class="icon"  id="makeRss">
                           <a class="icon" href="#"><img src="<?php echo image_asset_url('rss.png')?>" style="margin: -10px 10px 0;"></a>
                          <input type="text" class="form-control" id="InputRss" placeholder="" style="margin-top: -30px;
    padding: 20px 18px 0;
    vertical-align: baseline;width:50%">
                        </div>
                   </div>
				   </form>
                   <div class="row">
                        <div class="header-table">
                          <p class="col-1" style="width: 20%;float: left; ">วันที่ข่าว</p>
                          <p class="col-2" style="width: 60%;float: left; ">หัวข้อข่าว</p>
                          <p class="col-3" style="width: 20%;float: left; ">Icon ไฟล์แนบ</p>
                        </div>
						<?php 
						$count = 1;
						foreach ($query as $item){;
							$id = $item->NewsID;
							$title = $item->Title;
							$vdo_id = $item->vdo_id;
							$pic_id = $item->pic_id;
							$voice_id = $item->voice_id;
							$other_id = $item->other_id;
							$date = $item->Date;
							$d = date("d-m-Y",strtotime($date));
							$t = date("H:i:s",strtotime($date));
							$c = "";
							if($count%2 != 0){
								$c = "odd";
							}
							else if($count%2 == 0){
								$c = "event";
							}
						?>
						<div class="<?php echo $c;?>">
                          <p class="col-1" style="width: 5%;float: left;text-align:center;"><?php echo $count;?></p>
                          <p class="col-2" style="width: 15%;float: left; "><?php echo $d."<br/>&nbsp;".$t;?></p>
                          <p class="col-3" style="width: 60%;float: left; "><a target ="_blank" href="<?php echo base_url()?>rss/detail?id=<?php echo $id;?>"><?php echo $title;?></a></p>
                          <p class="col-4" style="width: 20%;float: left;  text-align: center;">
						  
						  <?php if($vdo_id == "" || $vdo_id == NULL){?>
                            <img src="<?php echo image_asset_url('icon/null.png')?>" style="margin: -10px 10px 0;">
						  <?php }else{?>
							<img src="<?php echo image_asset_url('icon/vdo.png')?>" style="margin: -10px 10px 0;">
						  <?php }?>
						  <?php if($pic_id == "" || $pic_id == NULL){?>
                            <img src="<?php echo image_asset_url('icon/null.png')?>" style="margin: -10px 10px 0;">
						  <?php }else{?>
							<img src="<?php echo image_asset_url('icon/pic.png')?>" style="margin: -10px 10px 0;">
						  <?php }?>
						  <?php if($voice_id == "" || $voice_id == NULL){?>
                            <img src="<?php echo image_asset_url('icon/null.png')?>" style="margin: -10px 10px 0;">
						  <?php }else{?>
							<img src="<?php echo image_asset_url('icon/voice.png')?>" style="margin: -10px 10px 0;">
						  <?php }?>
                          <?php if($other_id == "" || $other_id == NULL){?>
                            <img src="<?php echo image_asset_url('icon/null.png')?>" style="margin: -10px 10px 0;">
						  <?php }else{?>
							<img src="<?php echo image_asset_url('icon/doc.png')?>" style="margin: -10px 10px 0;">
						  <?php }?>  
                          </p>
                        </div>
							<?php
								$count++;
							}?>
                        <div class="footer-table">
                          <p style="width: 70%;float: left;margin-top: 20px;">ทั้งหมด: <?php echo $count-1; ?> รายการ (<?php echo ($count-1)/20 ?> หน้า)</p>
                          <p style="width: 30%;float: left;margin-top: 20px;text-align: right;">
						  <?php echo $this->pagination->create_links();?>
                            <!--<img src="<?php echo image_asset_url('table/pev.png')?>" style="margin: -5px 10px 0;">
                            <span style="margin-top: 10px;">
                            <select style="">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                              </select> / 100</span>
                            <img src="<?php echo image_asset_url('table/next.png')?>" style="margin: -5px 10px 0;">
                            <img src="<?php echo image_asset_url('table/end.png')?>" style="margin: -5px 10px 0;">-->
                          </p>
                        </div>
                   </div>
                </div>

            </div>
        </div>
    </div>
</form>
</body>

<script type="text/javascript">
$(document).ready(function(){
	$('#makeRss').click(function(){
		var attrfile = ""
		$('.chk:checked').each(function () {
			  attrfile += $(this).attr("name");
		});
        $("#InputRss").val(attrfile);
	});
})
</script>

</html>