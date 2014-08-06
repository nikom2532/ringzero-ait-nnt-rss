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

</head>
<body>
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

                <div id="table-list">
                   <div class="row">
                        <div class="col-lg-left">
                            <label style="font-weight:bold;">ไฟล์ประกอบข่าว</label>
                            <input type="checkbox" name="vdo" value="0">วิดีโอ
                            <input type="checkbox" name="sound" value="1">เสียง
                            <input type="checkbox" name="image" value="2">ภาพ
                            <input type="checkbox" name="other" value="3">อื่นๆ
                        </div>
                        <div class="col-lg-left" style="text-align: right;">
                           <a class="icon" href="#"><img src="<?php echo image_asset_url('rss_btn.png')?>" style="margin-top:-30px"></a>
                           <a class="icon" href="#"><img src="<?php echo image_asset_url('rss.png')?>" style="margin: -10px 10px 0;"></a>
                          <input type="text" class="form-control" id="InputKeyword" placeholder="" style="margin-top: -30px;
    padding: 20px 18px 0;
    vertical-align: baseline;width:50%">
                        </div>
                   </div>

                   <div class="row">
                        <div class="header-table">
                          <p class="col-1" style="width: 10%;float: left; ">วันที่ข่าว</p>
                          <p class="col-2" style="width: 70%;float: left; ">หัวข้อข่าว</p>
                          <p class="col-3" style="width: 20%;float: left; ">Icon ไฟล์แนบ</p>
                        </div>
                        <div class="odd">
                          <p class="col-1" style="width: 5%;float: left; ">999</p>
                          <p class="col-2" style="width: 15%;float: left; ">03/02/2557</br>00:00:00</p>
                          <p class="col-3" style="width: 60%;float: left; "><a href="detail">Icon ไฟล์แนบ</a></p>
                          <p class="col-4" style="width: 20%;float: left;  text-align: center;">
                            <img src="<?php echo image_asset_url('icon/vdo.png')?>" style="margin: -10px 10px 0;">
                            <img src="<?php echo image_asset_url('icon/pic.png')?>" style="margin: -10px 10px 0;">
                            <img src="<?php echo image_asset_url('icon/null.png')?>" style="margin: -10px 10px 0;">
                            <img src="<?php echo image_asset_url('icon/null.png')?>" style="margin: -10px 10px 0;">
                          </p>
                        </div>
                        <div class="event">
                          <p class="col-1" style="width: 5%;float: left; ">999</p>
                          <p class="col-2" style="width: 15%;float: left; ">หัวข้อข่าว</p>
                          <p class="col-3" style="width: 60%;float: left; "><a href="detail">Icon ไฟล์แนบ</a></p>
                          <p class="col-4" style="width: 20%;float: left;  text-align: center;">
                            <img src="<?php echo image_asset_url('icon/vdo.png')?>" style="margin: -10px 10px 0;">
                            <img src="<?php echo image_asset_url('icon/pic.png')?>" style="margin: -10px 10px 0;">
                            <img src="<?php echo image_asset_url('icon/null.png')?>" style="margin: -10px 10px 0;">
                            <img src="<?php echo image_asset_url('icon/null.png')?>" style="margin: -10px 10px 0;">
                          </p>
                        </div>
                        <div class="footer-table">
                          <p style="width: 70%;float: left;margin-top: 20px;">ทั้งหมด: 73 รายการ (4หน้า)</p>
                          <p style="width: 30%;float: left;margin-top: 20px;text-align: right;">
                            <img src="<?php echo image_asset_url('table/pev.png')?>" style="margin: -5px 10px 0;">
                            <span style="margin-top: 10px;">
                            <select style="">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                              </select> / 100</span>
                            <img src="<?php echo image_asset_url('table/next.png')?>" style="margin: -5px 10px 0;">
                            <img src="<?php echo image_asset_url('table/end.png')?>" style="margin: -5px 10px 0;">
                          </p>
                        </div>
                   </div>
                </div>

            </div>
        </div>
    </div>
</body>
</html>