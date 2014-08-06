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
    <link rel="shortcut icon" href="../favicon.ico"> 
	
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
        $(".select-menu > select > option:eq(0)").attr("selected","selected");
        $(".select-menu > select").live("change",function(){
            var selectmenu_txt = $(this).find("option:selected").text();
            $(this).prev("span").text(selectmenu_txt);
        });
    });
    </script>
</head>
<body>
<!--<form action="<?=$_SERVER["PHP_SELF"];?>" method="post" name="share">-->
<form action="<?php echo base_url()."index.php/rss/find";?>" method="post" name="share" id="search">
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
                <p><b style=" color: #0808A7;font-weight: bold;">Welcome to: </b><span style="color: #0404F5;"><?php echo $this->session->userdata('user_name');?></span> | <a href="<?php echo base_url();?>index.php/rss/logout">logout</a></p>
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
                                        <option selected="selected" value="0">เลือกหมวดหมู่ข่าว</option>
											 <?php foreach ($subtype as $item2){;
											  if ( isset( $_POST['TypeID'] ) and ( $_POST['TypeID'] == $item2->NT02_TypeID ) ) {
												$selectedTypeID = ' Selected ';
											  } else {
												$selectedTypeID = '';
											  }
											?>
										 <option value="<?php echo $item2->NT02_TypeID; ?>" <?php echo $selectedTypeID; ?> ><?php echo $item2->TypeNews; ?></option>
								  <?php };?>
                                    </select>
                                    </span> 
								  <!--<span class="select-menu">
                                  <select name="TypeID" id="TypeID" class="form-control" placeholder="">
								   <span><option value="0"> เลือกหมวดหมู่ข่าว </option> </span>
								 
								  </select>
								  </span>-->
                              </div>
							  <!--<div class="col-lg-6">
                                  <label >หมวดหมู่ข่าวย่อย</label>
                                  <select name="SubTypeID" id="SubTypeID" class="form-control" placeholder="">
									<option value="0"> เลือกหมวดหมู่ข่าวย่อย</option>
								  </select>
                              </div>-->
                              <div class="col-lg-6">
                                  <label >หมวดหมู่ข่าวย่อย</label>
								  <span class="select-menu">
								  <span>เลือกหมวดหมู่ข่าวย่อย</span>
                                  <select name="SubTypeID" id="SubTypeID" class="form-control">
								  <option selected="selected" value="0"> เลือกหมวดหมู่ข่าวย่อย</option>
								  <?php foreach ($query3 as $item3){;
								  if ( isset( $_POST['SubTypeID'] ) and ( $_POST['SubTypeID'] == $item3->NT03_SubTypeID ) ) {
									$selectedTypeID = ' Selected ';
								  } else {
									$selectedTypeID = '';
								  }
								?>
								<option value="<?php echo $item3->NT03_SubTypeID; ?>" <?php echo $selectedTypeID; ?> ><?php echo $item3->SubType; ?></option>
								  <?php };?>
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
								  <option value="0"> เลือกหน่วยงาน</option>
								  <?php foreach ($query4 as $item4){;
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
								  <option value="0"> เลือกนักข่าว</option>
								  <?php foreach ($query10 as $item10){;
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
                            <input class="bt" type="submit" value="ค้นหาข่าว" name="share" style="width:18%;padding: 4px;">
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
                           <img src="<?php echo image_asset_url('rss_btn.png')?>" style="margin-top:-30px"  class="icon"  id="makeRss">
                           <!--<a class="icon" href="#">--><img src="<?php echo image_asset_url('rss.png')?>" style="margin: -10px 10px 0;"><!--</a>-->
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
						$i = 0;
						//var_dump($query5);
						//echo $query5[0];
						foreach ($query->result() as $item){;
							$id = $item->NewsID;
							$title = $item->Title;
							$row = $item->RowNumber;
							/*$pic_id = $item->pic_id;
							$voice_id = $item->voice_id;
							$other_id = $item->other_id;*/
							//if($query5[$i])
								$vdo_id = $query5[$i];
							/*else
								echo $vdo_id = "";*/
							//if($query6[$i])
								$pic_id = $query6[$i];
							/*else
								$pic_id = "";*/
							//if($query7[$i])
								$voice_id = $query7[$i];
							/*else
								$voice_id = "";*/
							//if($query8[$i])
								$other_id = $query8[$i];
							/*else
								$other_id = "";*/
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
                          <p class="col-1" style="width: 5%;float: left;text-align:center;"><?php echo $row;?></p>
                          <p class="col-2" style="width: 15%;float: left; "><?php echo $d."<br/>&nbsp;".$t;?></p>
                          <p class="col-3" style="width: 60%;float: left; "><a target ="_blank" href="<?php echo base_url()?>index.php/rss/detail?id=<?php echo $id;?>"><?php echo substr($title,0,550);?></a></p>
                          <p class="col-4" style="width: 20%;float: left;  text-align: center;">
						  
						  <?php if($vdo_id == "0"){?>
                            <img src="<?php echo image_asset_url('icon/null.png')?>" style="margin: -10px 10px 0;">
						  <?php }else{?>
							<img src="<?php echo image_asset_url('icon/vdo.png')?>" style="margin: -10px 10px 0;">
						  <?php }?>
						  <?php if($pic_id == "0"){?>
                            <img src="<?php echo image_asset_url('icon/null.png')?>" style="margin: -10px 10px 0;">
						  <?php }else{?>
							<img src="<?php echo image_asset_url('icon/pic.png')?>" style="margin: -10px 10px 0;">
						  <?php }?>
						  <?php if($voice_id == "0"){?>
                            <img src="<?php echo image_asset_url('icon/null.png')?>" style="margin: -10px 10px 0;">
						  <?php }else{?>
							<img src="<?php echo image_asset_url('icon/voice.png')?>" style="margin: -10px 10px 0;">
						  <?php }?>
                          <?php if($other_id == "0"){?>
                            <img src="<?php echo image_asset_url('icon/null.png')?>" style="margin: -10px 10px 0;">
						  <?php }else{?>
							<img src="<?php echo image_asset_url('icon/doc.png')?>" style="margin: -10px 10px 0;">
						  <?php }?>  
                          </p>
                        </div>
							<?php
								$i++;
								$count++;
							}?>
                        <div class="footer-table">
						  <?php
							//echo $query9;
							//echo $count;
							if($count > "1")
							{
						  ?>
                          <p style="width: 70%;float: left;margin-top: 20px;">ทั้งหมด: <?php echo $query9; ?> รายการ (<?php echo ceil($query9/20) ?> หน้า)</p>   <p style="width: 30%;float: left;margin-top: 20px;text-align: right;">
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
								?>" onKeyUp="if(this.value*1!=this.value) this.value='' ;">/<?php echo ceil($query9/20) ;?>
								<!--<img src="<?php echo image_asset_url('table/next.png')?>" style="margin: -5px 10px 0;"></a>-->
							</span>
                            <span style="margin-top: 10px;">
                            <select id ="jump" name="jump" onchange="jumpPage()">
							<option value="1" <?php if ($this->uri->segment(3)/20 == 0)echo "selected" ;?>>1</option>
							<option value="2" <?php if ($this->uri->segment(3)/20 == 1)echo "selected" ;?>>2</option>
							<?php
								$total = ceil($query9/20);
								for($i = 3 ; $i <= $total ; $i++ )
								{
									$s = $i-1;
							?>
                                <option value="<?php echo $i ;?>" <?php if ($this->uri->segment(3)/20 == $s ) echo "selected";?>><?php echo $i ;?></option>
                     
							<?php 
								}
							?>
                            </select> / <?php echo ceil($query9/20) ;?></span>
							<?php
								$n = $this->uri->segment(3)+20;
								$e = $query9-20;
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

<!--<script type="text/javascript">
$(document).ready(function(){
	$('#makeRss').click(function(){
		var attrfile = ""
		$('.chk:checked').each(function () {
			  attrfile += $(this).attr("name");
		});
        $("#InputRss").val(attrfile);
	});
})
</script>-->
<script type="text/javascript">
$(function(){
	 $("#makeRss").click(function(){
		 var url="<?php echo base_url()?>index.php/rss/rss_feed";
		 //alert(url);
		 var dataSet={ search: $("input#search").val(), start_date: $("input#fromdate").val(), end_date: $("input#todate").val() 
		 ,type: $("#TypeID").val(),subtype: $("#SubTypeID").val(),department: $("#DepartmentID").val(),reporter: $("#UserId").val() 	
		 ,video: $("#vdo").is(":checked"),sound: $("#sound").is(":checked"),image: $("#image").is(":checked"),other: $("#other").is(":checked")};
		 $.post(url,dataSet,function(data){
			//alert(data);
			var url = "<?php echo base_url()?>index.php/rss/view_rss/"+data;
			$("#InputRss").val(url).select();
		 });
		 //alert(dataSet.search+dataSet.start_date+dataSet.end_date+dataSet.type+dataSet.subtype+" "+dataSet.department+" "+dataSet.reporter);
	 });
});
/*$(function(){
	 $("#go").click(function(){
		 var page = parseInt($("input#link").val());
		 //alert(page);
		 if(page == 1)
		 {
			var link="<?php echo base_url()?>rss/find/";
			//alert(link);
			window.location.replace(link);
		 }
		 else if(page == 2)
		 {
			var link="<?php echo base_url()?>rss/find/20";
			//alert(link);
			window.location.replace(link);
		 }
		 else if(page > 2)
		 {
			var link="<?php echo base_url()?>rss/find/"+(page-1)*20;
			//alert(link);
			window.location.replace(link);
		 }
		 else
		 {
			var link="<?php echo base_url()?>rss/find/";
			//alert(link);
			window.location.replace(link);
		 }
		 //alert(dataSet.search+dataSet.start_date+dataSet.end_date+dataSet.type+dataSet.subtype+" "+dataSet.department+" "+dataSet.reporter);
	 });
});*/
</script>
<script type="text/javascript">
$('#TypeID').change(function(){
    var type_id = $('#TypeID').val();
    if (type_id != ""){
			if (type_id == "0"){
				$('#SubTypeID').empty();
				var opt = $('<option />'); 
                      opt.val('0');
                      opt.text('หมวดหมู่ข่าวย่อย');
				$('#SubTypeID').append(opt);
			}else{
			var post_url = "<?php echo base_url();?>"+"index.php/rss/get_subtype/" + type_id;
			//alert(post_url);
			$.ajax({
				 type: "POST",
				 url: post_url,
				 dataType :'json',
				 success: function(subtype) //we're calling the response json array
				  {
				
					$('#SubTypeID').empty();
					 var opt = $('<option />'); 
						  opt.val(0);
						  opt.text(" - ทั้งหมด - ");
						  $('#SubTypeID').append(opt);
					   $.each(subtype,function(index,val) 
					   {
					   /* var opt = $('<option />'); // here we're creating a new select option for each group
						  opt.val(id);
						  opt.text(city);
						  $('#SubTypeID').append(opt); */
						  var opt = $('<option />'); 
						  opt.val(val.NT03_SubTypeID);
						  opt.text(val.SubType);
						  $('#SubTypeID').append(opt);
						 
					});
				   } //end success
			 });} //end AJAX
    } else {
       $('#SubTypeID').empty();
		
    }//end if
}); //end change 
</script>
<script type="text/javascript">
var url = "<?php echo base_url()."/rss"?>";
$('#DepartmentID').change(function(){
    var dep_id = $('#DepartmentID').val();
    if (dep_id != ""){
		if (dep_id == "0"){
				$('#UserId').empty();
				var opt = $('<option />'); 
                      opt.val('0');
                      opt.text('เลือกนักข่าว');
				$('#UserId').append(opt);
			}else{
        var post_url = "<?php echo base_url();?>"+ "index.php/rss/get_user/" + dep_id;
        $.ajax({
             type: "POST",
             url: post_url,
			 dataType :'json',
             success: function(UserId) //we're calling the response json array 'cities'
             {
			
				   $('#UserId').empty();
					var opt = $('<option />'); 
						  opt.val(0);
						  opt.text(" - ทั้งหมด - ");
						  $('#UserId').append(opt);
                   $.each(UserId,function(index,val) 
                   {
                   /* var opt = $('<option />'); // here we're creating a new select option for each group
                      opt.val(id);
                      opt.text(city);
                      $('#SubTypeID').append(opt); */
					  var opt = $('<option />'); 
                      opt.val(val.SC03_UserId);
                      opt.text(val.Name);
                      $('#UserId').append(opt);
                });
               } //end success
         })}; //end AJAX
    } else {
        $('#UserId').empty();
    }//end if
}); //end change
function jumpPage(){
	var page = parseInt($("#jump").val());
	//alert(page);
	if(page == 1)
	{
		$("#search").attr("action","<?php echo base_url()."index.php/rss/find/" ?>");
		$("#search").submit();
	}
	else if(page == 2)
	{
		$("#search").attr("action","<?php echo base_url()."index.php/rss/find/20" ?>");
		$("#search").submit();
	}
	else if(page > 2)
	{
		var get_page = (page-1)*20;
		$("#search").attr("action","<?php echo base_url()."index.php/rss/find/" ?>"+get_page);
		$("#search").submit();
	}
	else
	{
		$("#search").attr("action","<?php echo base_url()."index.php/rss/find/" ?>");
		$("#search").submit();
	}
	/*$("#search").attr("action","<?php echo base_url()."rss/find/" ?>");
	$("#search").submit();*/
}
function prePage(){
	$("#search").attr("action","<?php echo base_url()."index.php/rss/find/" ?>");
	$("#search").submit();
}
function nextPage(){
	$("#search").attr("action","<?php echo base_url()."index.php/rss/find/".$n ?>");
	$("#search").submit();
}
function endPage(){
	$("#search").attr("action","<?php echo base_url()."index.php/rss/find/".$e ?>");
	$("#search").submit();
}
</script>
<!--<script type="text/javascript">
    var config = {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
      $(selector).live('chosen',(config[selector]));
    }
</script>-->
<?php
}
else
	echo '<meta http-equiv="refresh" content="0;URL=index" />';
?>
</html>