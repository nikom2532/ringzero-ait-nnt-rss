<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<?php if($this->session->userdata('user_id')){?>
    <!-- IE Compatibility modes -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><!--   -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RSS FEEDS</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?php echo image_asset_url('favicon.ico')?>">  
	
    <?php echo css_asset('reset.css'); ?>
	<?php echo css_asset('style.css'); ?>
	<?php echo js_asset('jquery-1.8.3.min.js'); ?>

	<link rel="stylesheet" media="all" type="text/css" href="<?php echo other_asset_url('date-js/jquery-ui.css'); ?>" />
	<link rel="stylesheet" media="all" type="text/css" href="<?php echo other_asset_url('date-js/jquery-ui-timepicker-addon.css'); ?>" />

	<script type="text/javascript" src="<?php echo other_asset_url('date-js/jquery-ui.min.js'); ?>"></script>

	<script type="text/javascript" src="<?php echo other_asset_url('date-js/jquery-ui-timepicker-addon.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo other_asset_url('date-js/jquery-ui-sliderAccess.js'); ?>"></script>
	
	<link rel="stylesheet" media="all" type="text/css" href="<?php echo other_asset_url('docsupport/prism.css'); ?>" />
	<link rel="stylesheet" media="all" type="text/css" href="<?php echo other_asset_url('docsupport/chosen.css'); ?>" />
	<script type="text/javascript" src="<?php echo other_asset_url('docsupport/chosen.jquery.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo other_asset_url('docsupport/prism.js'); ?>"></script>

	<!--<script type="text/javascript" src="<?php echo other_asset_url('js/close_browser.js'); ?>"></script>-->
	
	<script type="text/javascript">

	$(function(){
		$("#fromdate").datepicker({
			dateFormat: 'dd-mm-yy',
			numberOfMonths: 1,
			changeYear: true,
			onSelect: function(selected) {
				$("#todate").datepicker("option","minDate", selected)
			}
		});
	});
	$(function(){
		$("#todate").datepicker({
			dateFormat: 'dd-mm-yy',
			numberOfMonths: 1,
			changeYear: true,
			onSelect: function(selected) {
				$("#fromdate").datepicker("option","maxDate", selected)
			}
		});
	});

	</script>
	<script>
    $(function(){
		var selectmenu_txt = $("#TypeID").find("option:selected").text();
			$("#TypeID").prev("span").text(selectmenu_txt);
			selectmenu_txt = $("#SubTypeID").find("option:selected").text();
			$("#SubTypeID").prev("span").text(selectmenu_txt);
			selectmenu_txt = $("#DepartmentID").find("option:selected").text();
			$("#DepartmentID").prev("span").text(selectmenu_txt);
			selectmenu_txt = $("#UserId").find("option:selected").text();
			$("#UserId").prev("span").text(selectmenu_txt);
			selectmenu_txt = $("#MoreTypeID").find("option:selected").text();
			$("#MoreTypeID").prev("span").text(selectmenu_txt);

        //$(".select-menu > select > option:eq(0)").attr("selected","selected");
        $(".select-menu > select").live("change",function(){
            var selectmenu_txt = $(this).find("option:selected").text();
            $(this).prev("span").text(selectmenu_txt);
        });
    });
    </script>
</head>
<body>
<?php $n="";$e="";?>
<div id>


<!--<form action="<?=$_SERVER["PHP_SELF"];?>" method="post" name="share">-->
<form action="<?php echo base_url()."rss/find";?>" method="post" name="share" id="search">
    <div class="container">
    <!-- HEADER -->
        <div class="wrapper">
            <div class="bg-header">
                <div id="header">
                    <div class="logo">
                        <img src="<?php echo image_asset_url('logo_rss.png')?>" alt="Logo" style="width:auto;">
                        
                        <!--<img src="<?php echo image_asset_url('sh_logo_header.png')?>" alt="Logo" style="width:100%">-->
                    </div>
                </div>
            </div>
        </div>
    <!-- Content -->

        <div class="wrapper">
            <div class="content">
                <div class="welcome">
                <p><b style=" color: #0808A7;font-weight: bold;">Welcome to: </b><span style="color: #0404F5;"><?php echo $this->session->userdata('user_name');?></span> | <a href="<?php echo base_url();?>rss/logout">logout</a></p>
                </div>
                <div id="share-form">
                    <div id="search-form">

                          <div class="row">
                              <div class="col-lg-12">
                                <label style="float: left;text-align: right;width: 14%;">SEARCH</label>
								<?php
								  if ( isset( $_POST['search'] ) ) {
									$keyword = $_POST['search'];
								  } else {
									$keyword = '';
								  }
								?>
                                <input class="txt-field" type="text" value="<?php echo $keyword;?>" name="search" id="search" placeholder="" style=" margin-left: 15px;width: 77%;">
                              </div>
                          </div>
                    
  
                          <div class="row">
                              <div class="col-lg-6">
                                  <label >วันที่</label>
								  <?php
								  if ( isset( $_POST['start_date'] ) ) {
									$start_date = $_POST['start_date'];
								  } else {
									$start_date = '';
								  }
								?>
                                  <input type="text" value="<?php echo $start_date ;?>" name="start_date" class="form-control" id="fromdate" placeholder="" >
                              </div>
                              <div class="col-lg-6">
                                  <label >ถึง</label>
								  <?php
								  if ( isset( $_POST['end_date'] ) ) {
									$end_date = $_POST['end_date'];
								  } else {
									$end_date = '';
								  }
								?>
                                  <input type="text" value= "<?php echo $end_date ;?>" name="end_date" class="form-control" id="todate" placeholder="" >
                              </div>
                           </div>
                      
                           <div class="row">
                              <div class="col-lg-6">
                                  <label >หมวดหมู่ข่าว</label>
								  <span class="select-menu">
                                  <span>เลือกหมวดหมู่ข่าว</span>
                                  <select name="TypeID" id="TypeID" class="form-control">
                                  <option value="">เลือกหมวดหมู่ข่าว</option>
								  <?php foreach ($newstype as $item2){;
								  if ( isset( $_POST['TypeID'] ) and ( $_POST['TypeID'] == $item2->NT02_TypeID ) ) {
									$selectedTypeID = ' Selected ';
								  } else {
									$selectedTypeID = '';
								  }
								  ?>
								  <option value="<?php echo $item2->NT02_TypeID; ?>" <?php echo $selectedTypeID; ?> ><?php echo $item2->NT02_TypeName; ?></option>
								  <?php };?>
                                    </select>
                                    </span> 
                              </div>
                              <div class="col-lg-6">
                                  <label >หมวดหมู่ข่าวย่อย</label>
								  <span class="select-menu">
								  <span>เลือกหมวดหมู่ข่าวย่อย</span>
                                  <select name="SubTypeID" id="SubTypeID" class="form-control">
								  <option value=""> เลือกหมวดหมู่ข่าวย่อย</option>
								  <?php foreach ($subtype as $item3){;
								  if ( isset( $_POST['SubTypeID'] ) and ( $_POST['SubTypeID'] == $item3->NT03_SubTypeID ) ) {
									$selectedTypeID = ' Selected ';
								  } else {
									$selectedTypeID = '';
								  }
								?>
								<option value="<?php echo $item3->NT03_SubTypeID; ?>" <?php echo $selectedTypeID; ?> ><?php echo $item3->NT03_SubTypeName; ?></option>
								  <?php };?>
								  </select>
								  </span>
                              </div>
                            </div>

                            <div class="row">
                           		<div class="col-lg-6">
                                	<label >หมวดหมู่ข่าวเพิ่มเติม</label>
                                  	<span class="select-menu">
								  		<span>เลือกหมวดหมู่ข่าวเพิ่มเติ่ม</span>
                                  		<select name="MoreTypeID" id="MoreTypeID" class="form-control">
								  			<option value=""> เลือกหมวดหมู่ข่าวเพิ่มเติม</option>
								  			<?php foreach ($moretype as $item_moretype){;
								  			if ( isset( $_POST['MoreTypeID'] ) and ( $_POST['MoreTypeID'] == $item_moretype->NT06_MoreTypeID ) ) 
								  			{
												$selectedSubTypeID = ' Selected ';
								  			} 
								  			else 
								  			{
												$selectedSubTypeID = '';
								  			}
											?>
											<option value="<?php echo $item_moretype->NT06_MoreTypeID; ?>" <?php echo $selectedSubTypeID; ?> ><?php echo $item_moretype->NT06_MoreTypeName; ?></option>
								  			<?php 
								  			}
								  			;?>
								  		</select>
								  	</span>
                            	</div>
                           	</div> 

                         <div class="row">
                              <div class="col-lg-6">
                                  <label >หน่วยงาน</label>
								  <span class="select-menu">
								  <span>เลือกหน่วยงาน</span>
                                  <select name="DepartmentID" id="DepartmentID" class="form-control" placeholder="">
								  <!--<option value="0"> เลือกหน่วยงาน</option>-->
								  <option value=""> เลือกหน่วยงาน</option>
								  <?php foreach ($department as $item4){;
								  if ( isset( $_POST['DepartmentID'] ) and ( $_POST['DepartmentID'] == $item4->SC07_DepartmentId ) ) {
									$selectedTypeID = ' Selected ';
								  } else {
									$selectedTypeID = '';
								  }
								?>
                            <option value="<?php echo $item4->SC07_DepartmentId; ?>" <?php echo $selectedTypeID; ?> ><?php echo $item4->SC07_DepartmentName; ?></option>
								  <?php };?>
								  </select>
								  </span>
                              </div>
							  <div class="col-lg-6">
                                  <label >ชื่อนักข่าว</label>
								  <span class="select-menu">
								  <span>เลือกนักข่าว</span>
                                  <select name="UserId" id="UserId" class="chosen-select" placeholder="" >
								  <!--<option value="0"> เลือกนักข่าว</option>-->
								  <option value=""> เลือกนักข่าว</option>
								  <?php foreach ($reporter as $item10){;
								  if ( isset( $_POST['UserId'] ) and ( $_POST['UserId'] == $item10->SC03_UserId ) ) {
									$selectedTypeID = ' Selected ';
								  } else {
									$selectedTypeID = '';
								  }
								?>
                            <option value="<?php echo $item10->SC03_UserId; ?>" <?php echo $selectedTypeID; ?> ><?php echo $item10->Name; ?></option>
								  <?php };?>
								  </select>
								  </span>
                              </div>
                          </div>
						  
                         <div class="col-lg-12" style="text-align: center;">
                            <input class="bt" type="submit" value="ค้นหาข่าว" name="share" style="width:18%;padding: 4px;cursor:pointer;">
                         </div>
                      
                    </div>
                </div>
				<form name="form1" action="get_rss" method="post">
                <div id="table-list">
                   <div class="row">
                        <div class="col-lg-left">
                            <label style="font-weight:bold;">ไฟล์ประกอบข่าว</label>
                            <input type="checkbox" id="vdo" name="vdo"  class="chk" value="0">วิดีโอ
                            <input type="checkbox" id="sound" name="sound" class="chk" value="1">เสียง
                            <input type="checkbox" id="image" name="image" class="chk" value="2">ภาพ
                            <input type="checkbox" id="other" name="other" class="chk" value="3">อื่นๆ
                        </div>
                        <div class="col-lg-left" style="text-align: right;">
                           <img data-other-src="<?php echo image_asset_url('rss_btn_click.png')?>" src="<?php echo image_asset_url('rss_btn.png')?>" style="margin-top:-30px;cursor:pointer;"  class="icon"  id="makeRss">
                           <!--<a class="icon" href="#">--><img src="<?php echo image_asset_url('rss.png')?>" style="margin: -10px 10px 0;"><!--</a>-->
                          <input type="text" value= "" class="form-control" id="InputRss" placeholder="" style="margin-top: -30px;
    padding: 20px 18px 0;
    vertical-align: baseline;width:50%">
                        </div>
                   </div>
				   </form>
                   
                   <div class="row">
				   		<table style="width: 100%;">
                   			<tr class="header-table">
                   				<td style="width: 5%;float: left; "><p>ลำดับ</p></td>
                   				<td style="width: 15%;float: left; "><p>วันที่ข่าว</p></td>
                   				<td style="width: 40%;float: left; "><p>หัวข้อข่าว</p></td>
                   				<td style="width: 20%;float: left; "><p>ผู้สื่อข่าว</p></td>
                   				<td style="width: 20%;float: left; "><p>Icon ไฟล์แนบ</p></td>
                   			</tr>
                   			<?php 
							$count = 1;
							$i = 0;
							foreach ($query->result() as $item){;
								$id = $item->NewsID;
								//$title = $item->Title;
								$title = $item->Title;
								$reporter = $item->Reporter;
								if($reporter == "")
								{
									$reporter = "ไม่มีผู้สื่อข่าว";
								}
								$row = $item->RowNumber;
								$vdo_id = $video_status[$i];
								$pic_id = $picture_status[$i];
								$voice_id = $voice_status[$i];
								$other_id = $other_status[$i];
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
                   			<tr class="<?php echo $c ;?>">
                   				<td style="width: 5%;float: left;text-align: center; "><p><?php echo $row;?></p></td>
                   				<td style="width: 15%;float: left;text-align: center; "><p><?php echo $d."<br/>&nbsp;".$t;?></p></td>
                   				<td style="width: 40%;float: left; "><p><a target ="_blank" href="<?php echo base_url()?>rss/detail?id=<?php echo $id;?>"><?php echo $title;?></a></p></td>
                   				<td style="width: 20%;float: left; "><p><?php echo $reporter; ?></p></td>
                   				<td style="width: 20%;float: left;text-align: center; "><p>
                   					<?php if($vdo_id == "0"){?>
                            			<img src="<?php echo image_asset_url('icon/null.png')?>" style="margin: -10px 10px 0;" alt="วีดีโอ" title="วีดีโอ">
								  	<?php }else{?>
										<img src="<?php echo image_asset_url('icon/vdo.png')?>" style="margin: -10px 10px 0;" alt="วีดีโอ" title="วีดีโอ">
								  	<?php }?>
                   			
                   					<?php if($pic_id == "0"){?>
                           				<img src="<?php echo image_asset_url('icon/null.png')?>" style="margin: -10px 10px 0;" alt="รูปภาพ" title="รูปภาพ">
						  			<?php }else{?>
										<img src="<?php echo image_asset_url('icon/pic.png')?>" style="margin: -10px 10px 0;" alt="รูปภาพ" title="รูปภาพ">
						  			<?php }?>
                   				
                   					<?php if($voice_id == "0"){?>
                            			<img src="<?php echo image_asset_url('icon/null.png')?>" style="margin: -10px 10px 0;" alt="เสียง" title="เสียง">
						  			<?php }else{?>
										<img src="<?php echo image_asset_url('icon/voice.png')?>" style="margin: -10px 10px 0;" alt="เสียง" title="เสียง">
						  			<?php }?>
                   				
                   					<?php if($other_id == "0"){?>
                            			<img src="<?php echo image_asset_url('icon/null.png')?>" style="margin: -10px 10px 0;" alt="ไฟล์อื่นๆ" title="ไฟล์อื่นๆ">
						  			<?php }else{?>
										<img src="<?php echo image_asset_url('icon/doc.png')?>" style="margin: -10px 10px 0;" alt="ไฟล์อื่นๆ" title="ไฟล์อื่นๆ">
						  			<?php }?></p>
                   				</td>
                   			</tr>
                   			<?php
								$i++;
								$count++;
							?>	
                   			<?php }?>
                   		</table>

                        <div class="footer-table">
						  <?php
							//echo $rows;
							//echo $count;
							if($count > "1")
							{
						  ?>
                          <p style="width: 70%;float: left;margin-top: 20px;">ทั้งหมด: <?php echo $rows; ?> รายการ (<?php echo ceil($rows/20) ?> หน้า)</p>   <p style="width: 30%;float: left;margin-top: 20px;text-align: right;">
						  <!--<?php 
							echo $pagination;
						  ?>-->
                            <a href="#" onClick="prePage()"><img src="<?php echo image_asset_url('table/pev.png')?>" style="margin: -5px 10px 0;"></a>
							<input type="hidden" name="onpage" id="onpage">
							<!--<span style="margin-top: 10px;">
								<input type="textbox" name="link" style="width: 15%;text-align:right;" value="<?php 
								if ($this->uri->segment(3)/20 == 0)
									echo 1; 
								else if ($this->uri->segment(3)/20 == 1)
									echo 2;
								else
									echo ceil(($this->uri->segment(3)/20)+1);
								?>" onKeyUp="if(this.value*1!=this.value) this.value='' ;">/<?php echo ceil($rows/20) ;?>
								<!--<img src="<?php echo image_asset_url('table/next.png')?>" style="margin: -5px 10px 0;"></a>-->
							</span>
                            <span style="margin-top: 10px;">
                            <select id ="jump" name="jump" onchange="jumpPage()">
							<option value="1" <?php if ($this->uri->segment(3)/20 == 0)echo "selected" ;?>>1</option>
							<option value="2" <?php if ($this->uri->segment(3)/20 == 1)echo "selected" ;?>>2</option>
							<?php
								$total = ceil($rows/20);
								for($i = 3 ; $i <= $total ; $i++ )
								{
									$s = $i-1;
							?>
                                <option value="<?php echo $i ;?>" <?php if (ceil($this->uri->segment(3)/20) == $s ) echo "selected";?>><?php echo $i;?></option>
                     
							<?php 
								}
							?>
                            </select> / <?php echo ceil($rows/20) ;?></span>
							<?php
								$n = $this->uri->segment(3)+20;
								$e = $rows-20;
							?>
							<!--<a href="#" id="go"><img src="<?php echo image_asset_url('table/go.png')?>" style="margin: -5px 10px 0;"></a>-->
                            <a href="#" onclick="nextPage()"><img src="<?php echo image_asset_url('table/next.png')?>" style="margin: -5px 10px 0;"></a>
                            <a href="#" onclick="endPage()"><img src="<?php echo image_asset_url('table/end.png')?>" style="margin: -5px 10px 0;"></a>
							<!--<?php echo "<br>Segment : ".$this->uri->segment(3) ;?>-->
							<?php
							}
							else
							{?>
								 <p style="width: 100%;float: left;margin-top: 20px;text-align: center;"> ไม่พบข้อมูลรายการที่ค้นหา	</p>
							<?php 
							} 
							?>
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
$('img').bind('mouseenter mouseleave', function() {
    $(this).attr({
        src: $(this).attr('data-other-src') 
        , 'data-other-src': $(this).attr('src') 
    })
});
</script>
<script type="text/javascript">
$(function(){
	 $("#makeRss").click(function(){
		 var url="<?php echo base_url()?>rss/rss_feed";
		 //alert(url);
		 var dataSet={ search: $("input#search").val(), start_date: $("input#fromdate").val(), end_date: $("input#todate").val() 
		 ,type: $("#TypeID").val(),subtype: $("#SubTypeID").val(),department: $("#DepartmentID").val(),reporter: $("#UserId").val() 	
		 ,video: $("#vdo").is(":checked"),sound: $("#sound").is(":checked"),image: $("#image").is(":checked"),other: $("#other").is(":checked")
		 ,moretype: $("#MoreTypeID").val()};
		 $.post(url,dataSet,function(data){
			//alert(data);
			var url = "<?php echo base_url()?>rss/view_rss/"+data;
			$("#InputRss").val(url).select();
		 });
		 //alert(dataSet.search+dataSet.start_date+dataSet.end_date+dataSet.type+dataSet.subtype+" "+dataSet.department+" "+dataSet.reporter);
	 });
});
</script>
<script type="text/javascript">
$('#TypeID').change(function(){
    var type_id = $('#TypeID').val();
    if (type_id != "")
    {
		var post_url = "<?php echo base_url();?>"+"rss/get_subtype/" + type_id;
		$.ajax({
			type: "POST",
			url: post_url,
			dataType :'json',
			success: function(subtype) //we're calling the response json array
			{
				$('#SubTypeID').empty();
				var opt = $('<option />'); 
				opt.val(null);
				var sub = opt.val(null);
				opt.text(" - ทั้งหมด - ");
				$('#SubTypeID').append(opt);
				$.each(subtype,function(index,val) 
				{
					var opt = $('<option />'); 
				  	opt.val(val.NT03_SubTypeID);
				  	opt.text(val.NT03_SubTypeName);
				  	$('#SubTypeID').append(opt); 

					var sub_id = $('#SubTypeID').val();
				    if (sub_id != "")
				    {
						var post_url = "<?php echo base_url();?>"+"rss/get_moretype/" + sub_id;
						$.ajax({
							type: "POST",
							url: post_url,
							dataType :'json',
							success: function(moretype) //we're calling the response json array
							{
								$('#MoreTypeID').empty();
								var opt = $('<option />'); 
								opt.val(null);
								opt.text(" - ทั้งหมด - ");
								$('#MoreTypeID').append(opt);
								$.each(moretype,function(index,val) 
								{
									var opt = $('<option />'); 
								  	opt.val(val.NT06_MoreTypeID);
								  	opt.text(val.NT06_MoreTypeName);
								  	$('#MoreTypeID').append(opt); 
								});
								var selectmenu_txt = $("#MoreTypeID").find("option:selected").text();
								$("#MoreTypeID").prev("span").text(selectmenu_txt);
							} //end success
						}); //end AJAX*/
				    }else	{
				       	$('#MoreTypeID').empty();
				       	var opt = $('<option />'); 
				        opt.val(null);
				        opt.text('เลือกหมวดหมู่ข่าวเพิ่มเติม');
						$('#MoreTypeID').append(opt);
						$("#MoreTypeID").prev("span").text('เลือกหมวดหมู่ข่าวเพิ่มเติม');
						
				    }//end if
									  	
				});
				var selectmenu_txt = $("#SubTypeID").find("option:selected").text();
				$("#SubTypeID").prev("span").text(selectmenu_txt);
			} //end success
		}); //end AJAX
    }else	{
       	$('#SubTypeID').empty();
       	var opt = $('<option />'); 
        opt.val(null);
        opt.text('เลือกหมวดหมู่ข่าวย่อย');
		$('#SubTypeID').append(opt);
		$("#SubTypeID").prev("span").text('เลือกหมวดหมู่ข่าวย่อย');

		$('#MoreTypeID').empty();
       	var opt = $('<option />'); 
        opt.val(null);
        opt.text('เลือกหมวดหมู่ข่าวเพิ่มเติม');
		$('#MoreTypeID').append(opt);
		$("#MoreTypeID").prev("span").text('เลือกหมวดหมู่ข่าวเพิ่มเติม');
		
    }//end if
}); //end change 
</script>

<script type="text/javascript">
$('#SubTypeID').change(function(){
    var sub_id = $('#SubTypeID').val();
    if (sub_id != "")
    {
		var post_url = "<?php echo base_url();?>"+"rss/get_moretype/" + sub_id;
		$.ajax({
			type: "POST",
			url: post_url,
			dataType :'json',
			success: function(moretype) //we're calling the response json array
			{
				$('#MoreTypeID').empty();
				var opt = $('<option />'); 
				opt.val(null);
				opt.text(" - ทั้งหมด - ");
				$('#MoreTypeID').append(opt);
				$.each(moretype,function(index,val) 
				{
					var opt = $('<option />'); 
				  	opt.val(val.NT06_MoreTypeID);
				  	opt.text(val.NT06_MoreTypeName);
				  	$('#MoreTypeID').append(opt); 
				});
				var selectmenu_txt = $("#MoreTypeID").find("option:selected").text();
				$("#MoreTypeID").prev("span").text(selectmenu_txt);
			} //end success
		}); //end AJAX*/
    }else	{
       	$('#MoreTypeID').empty();
       	var opt = $('<option />'); 
        opt.val(null);
        opt.text('เลือกหมวดหมู่ข่าวเพิ่มเติม');
		$('#MoreTypeID').append(opt);
		$("#MoreTypeID").prev("span").text('เลือกหมวดหมู่ข่าวเพิ่มเติม');
		
    }//end if
}); //end change 
</script>
<script type="text/javascript">
var url = "<?php echo base_url()."/rss"?>";
$('#DepartmentID').change(function(){
    var dep_id = $('#DepartmentID').val();
    if (dep_id != ""){
        var post_url = "<?php echo base_url();?>"+ "rss/get_user/" + dep_id;
        $.ajax({
            type: "POST",
            url: post_url,
			dataType :'json',
            success: function(UserId) //we're calling the response json array 'cities'
            {
			   	$('#UserId').empty();
				var opt = $('<option />'); 
					opt.val(null);
					opt.text(" - ทั้งหมด - ");
					$('#UserId').append(opt);
               	$.each(UserId,function(index,val) 
               	{
				 	var opt = $('<option />'); 
                  	opt.val(val.SC03_UserId);
                  	opt.text(val.Name);
                  	$('#UserId').append(opt);
                });
				var selectmenu_txt = $("#UserId").find("option:selected").text();
				$("#UserId").prev("span").text(selectmenu_txt);
            }
         });
    } else {
        $('#UserId').empty();
		var opt = $('<option />'); 
        opt.val(null);
        opt.text('เลือกนักข่าว');
		$('#UserId').append(opt);
		$("#UserId").prev("span").text('เลือกนักข่าว');
    }
});
</script>
<script type="text/javascript">
function jumpPage(){
	var page = parseInt($("#jump").val());
	//alert(page);
	if(page == 1)
	{
		$("#search").attr("action","<?php echo base_url()."rss/find/" ;?>");
		$("#search").submit();
	}
	else if(page == 2)
	{
		$("#search").attr("action","<?php echo base_url()."rss/find/20" ;?>");
		$("#search").submit();
	}
	else if(page > 2)
	{
		var get_page = (page-1)*20;
		$("#search").attr("action","<?php echo base_url()."rss/find/" ;?>"+get_page);
		$("#search").submit();
	}
	else
	{
		$("#search").attr("action","<?php echo base_url()."rss/find/" ;?>");
		$("#search").submit();
	}
}
function prePage(){
	$("#search").attr("action","<?php echo base_url()."rss/find/" ;?>");
	$("#search").submit();
}
function nextPage(){
	$("#search").attr("action","<?php echo base_url()."rss/find/".$n ;?>");
	$("#search").submit();
}
function endPage(){
	$("#search").attr("action","<?php echo base_url()."rss/find/".$e ;?>");
	$("#search").submit();
}
</script>
<?php
}
else
	echo '<meta http-equiv="refresh" content="0;URL=index" />';
?>
</html>