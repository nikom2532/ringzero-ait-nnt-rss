<!-- <script src="<?php echo base_url(); ?>js/jquery-1.8.3.min.js"></script> -->
<div class="content">
	<div id="share-form">
		<div id="search-form">
			<form name="search_form" id="homeSearch" action="<?php echo base_url().index_page(); ?>rss" method="post">
				<input type="hidden" name="rss_is_search" value="yes" />
				<div class="row">
					<div class="col-lg-12">
						<label style="float: left;text-align: right;width: 14%;">SEARCH</label>
						<input class="txt-field" type="text" name="news_title" id="news_title" style="margin-left: 15px;width: 77%;" value="<?php if(isset($post_news_title)){ echo $post_news_title; } ?>" / >
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6">
						<label >วันที่</label>
						<input type="text" class="form-control fromdate" name="start_date" id="start_date" value="<?php
							if(isset($post_start_date)){
								echo $post_start_date;
							}
						?>" placeholder="" >
					</div>
					<div class="col-lg-6">
						<label >ถึง</label>
						<input type="text" class="form-control todate" name="end_date" id="end_date" value="<?php 
							if(isset($post_end_date)){
								echo $post_end_date;
							}
						?>" placeholder="" >
					</div>
				</div>
				
				<div class="row">
					<div class="col-lg-6">
						<label >หมวดหมู่ข่าว</label>
						<span class="select-menu">
							<span>เลือกหมวดหมู่ข่าว</span>
							<select name="NewsTypeID" id="NewsTypeID" class="form-control" style="width: 100%;">
								<option value="">เลือกหมวดหมู่ข่าว</option><?php
								// var_dump($NT02_NewsType);
								foreach ($NT02_NewsType as $newType_item) {
									?><option value="<?php echo $newType_item->NT02_TypeID; ?>" <?php 
										//*
										if($newType_item->NT02_TypeID == $post_News_type_id){
											?>selected='selected'<?php
										}
										//*/
									?>><?php echo $newType_item->NT02_TypeName; ?></option><?php
								}
							?></select>
						</span>
					</div>
					<div class="col-lg-6">
						<label >หมวดหมู่ข่าวย่อย</label>
						<span class="select-menu">
							<span>เลือกหมวดหมู่ข่าวย่อย</span>
							<select name="NewsSubTypeID" id="NewsSubTypeID" class="form-control" style="width: 100%;">
								<option value="">เลือกหมวดหมู่ข่าวย่อย</option><?php
								foreach ($NT03_NewsSubType as $newType_item) {
									// if($newType_item->NT02_TypeID == $post_News_type_id){
										?><option value="<?php echo $newType_item->NT03_SubTypeID; ?>" <?php
											
											if($newType_item->NT03_SubTypeID == $post_News_subtype_id){
												?>selected='selected'<?php
											}
											
										?>><?php echo $newType_item->NT03_SubTypeName; ?></option><?php
									// }
								}
							?></select>
						</span>
					</div>
				</div>
				
				<?php //var_dump($NT03_NewsSubType); ?>
				
				<div class="row">
					<div class="col-lg-6">
						<label >หน่วยงาน</label>
						<span class="select-menu">
						<span>เลือกหน่วยงาน</span>
							<select name="grov_active" id="grov_active">
								<option value="">เลือกหน่วยงาน</option>
<?php
								foreach ($SC07_Department as $Department_item) {
									?><option value="<?php echo $Department_item->SC07_DepartmentId;?>" <?php 
										if(isset($post_grov_active)){
											if($Department_item->SC07_DepartmentId == $post_grov_active){
												?>selected='selected'<?php
											}
										}
									?>><?php echo $Department_item->SC07_DepartmentName; ?></option><?php
								}
?>
							</select>
						</span>
					</div>
					<div class="" style="width: 50%; float: left; ">
						<label style="margin-left: 17%">ชื่อนักข่าว</label>
						<!-- <span class="select-menu"> -->
						<!-- <span>เลือกนักข่าว</span> -->
						<span style="margin-left: 7%;">
							<select name="reporter_id" id="reporter_id" class="reporter_id_chosen" style="width:285px; margin-left: 5%;">
								<option value="">เลือกนักข่าว</option>
<?php
								foreach ($SC03_User as $SC03_User_item) {
									?><option value="<?php echo $SC03_User_item->SC03_UserId; ?>" <?php
										if($post_reporter_id != ""){ 	
											?>selected='selected'<?php
										}
									?>><?php echo $SC03_User_item->ReporterName; ?></option><?php
								}
?>
							</select>
						</span>
						<script>
							jQuery(document).ready(function(){
								jQuery(".reporter_id_chosen").chosen();
							});
						</script>
						<!-- </span> -->
					</div>
				</div>
				<div class="col-lg-12" style="text-align: center;">
					<input class="bt" type="submit" value="ค้นหาข่าว" name="share" style="width:18%;padding: 4px;">
				</div>
			</form>
		</div>
	</div>

	<div id="table-list">
		<div class="row">
			<div class="col-lg-left" style="">
				<img src="<?php echo base_url(); ?>images/rss_btn.png" style="cursor: pointer;" id="makeRss" />
				<!-- <img src="<?php echo base_url(); ?>images/rss.png" style=""> -->
				<input type="text" class="form-control" id="InputRss" placeholder="" style="margin-top: -30px;
				padding: 20px 18px 0;
				vertical-align: baseline;width:50%">
			</div>
		</div>

		<div class="row">
			<div class="header-table">
				<p class="col-1" style="width: 15%;float: left; ">
					
				</p>
				<p class="col-2" style="width: 10%;float: left; text-align: left; ">
					วันที่ข่าว
				</p>
				<p class="col-3" style="width: 55%;float: left; ">
					หัวข้อข่าว
				</p>
				<p class="col-4" style="width: 20%;float: left; ">
					Icon ไฟล์แนบ
				</p>
			</div>
<?php
		//Start to count News's rows
		$i=0;
		foreach($news as $news_item){
			if($i % 2 == 0){
				?><div class="odd"><?php
			}
			elseif($i % 2 == 1){
				?><div class="event"><?php
			}
?>
					<p class="col-1" style="width: 15%;float: left; ">
						<?php echo $news_item->NT01_NewsID; ?>
					</p>
					<p class="col-2" style="width: 10%;float: left; ">
						<!-- 03/02/2557</br>00:00:00 -->
<?php
						echo date("d/m/Y", strtotime($news_item->NT01_NewsDate))."<br />".date("h:m:s", strtotime($news_item->NT01_NewsDate));
?>
					</p>
					<p class="col-3" style="width: 55%;float: left; ">
						<a href="<?php echo base_url().index_page(); ?>rss_detail_prd?news_id=<?php echo $news_item->NT01_NewsID; ?>"><?php 
						$News_Title = $news_item->NT01_NewsTitle;
						if(mb_strlen($News_Title)>=150){
							$News_Title = mb_substr($News_Title, 0, 150, 'UTF-8')."...";
						}
						echo $News_Title;
						
						// echo $news_item->NT01_NewsTitle; 
						?></a>
					</p>
					<p class="col-4" style="width: 20%;float: left;  text-align: center; text-align: center; ">
						<img src="<?php echo base_url(); ?>images/icon/<?php
						if($news_item->NT10_FileStatus == "Y"){ //Video
							?>vdo<?php
						}else{
							?>null<?php
						}
					?>.png" width="17" style="margin: -10px 10px 0;">
					
					<img src="<?php echo base_url(); ?>images/icon/<?php 
						if($news_item->NT12_FileStatus == 'Y'){ //Voice
							?>voice_512x512<?php
						}else{
							?>null<?php
						}
					?>.png" width="17" style="margin: -10px 10px 0;">
					
					
					<img src="<?php echo base_url(); ?>images/icon/<?php 
						if($news_item->NT13_FileStatus == 'Y'){ //Document
							?>Document.jpg<?php
						}else{
							?>null.png<?php
						}
					?>" width="17" style="margin: -10px 10px 0;">
					
					<img src="<?php echo base_url(); ?>images/icon/<?php
						if($news_item->NT11_FileStatus == 'Y'){ //Picture
							?>pic<?php
						}else{
							?>null<?php
						}
					?>.png" width="17" style="margin: -10px 10px 0;">
					</p>
				</div>
<?php
			$i++;
		}
		//End Count News's Row 
		
		if($i == 0){
?>
			<div class="news-form" style="color: red; text-align: center;">ไม่มีข้อความ</div>
<?php
		}
?>
			<div class="footer-table">
				<p style="width: 70%;float: left;margin-top: 20px;">
					<span><?php echo "ทั้งหมด : ".$count_row." รายการ (".$total_page." หน้า )"; ?></span>
				</p>
	            
	            <p style="width: 30%;float: left;margin-top: 20px;text-align: right;">
	            	<a href="javascript:firstPage()"><img src="<?php echo base_url(); ?>img/prew.png"></a>
	            	<a href="javascript:prevPage('<?php echo $current_page; ?>')"><img src="<?php echo base_url(); ?>img/prev.png"></a>
	                <span style="margin-top: 10px;">
						<!-- <span><?php //echo $current_page; ?></span> -->
						<select onchange="jump_page(this.value)">
<?php 
							// var_dump($page_url);
							foreach ($page_url as $item) {
								?><option value="<?php echo $item['value']; ?>" <?php echo $item['selected']; ?>><?php echo $item['value']; ?></option><?php
							}
?>
						</select> / <?php echo $total_page; ?>
	                </span>
	                <a href="javascript:nextPage('<?php echo $current_page; ?>')"><img src="<?php echo base_url(); ?>img/next.png"></a>
	                <a href="javascript:lastPage('<?php echo $total_page; ?>')"><img src="<?php echo base_url(); ?>img/next2.png"></a>
	            </p>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(function(){
		$(".fromdate").datepicker({
			dateFormat: 'yy-mm-dd',
			numberOfMonths: 1,
			changeMonth: true,
			changeYear: true,
				onSelect: function(selected) {
					$(".todate").datepicker("option","minDate", selected)
			}
		});
	});
	$(function(){
		$(".todate").datepicker({
			dateFormat: 'yy-mm-dd',
			numberOfMonths: 1,
			changeMonth: true,
			changeYear: true,
			onSelect: function(selected) {
				$(".fromdate").datepicker("option","maxDate", selected)
			}
		});
	});
	
	function jump_page(val){
		location='<?php echo $jump_url; ?>/'+val;
	}
	function nextPage(val){
		// debugger;
		var nextpage = parseInt(val)+1;
		if(<?php echo $total_page; ?>==val){
			nextpage = val;
		}
		$("#homeSearch").attr("action","<?php echo base_url().index_page()."rss"; ?>/"+nextpage);
		$("#homeSearch").submit();
	}
	function lastPage(val){
		$("#homeSearch").attr("action","<?php echo base_url().index_page()."rss"; ?>/"+val);
		$("#homeSearch").submit();
	}
	function prevPage(val){
		var prevpage = parseInt(val)-1;
		$("#homeSearch").attr("action","<?php echo base_url().index_page()."rss"; ?>/"+prevpage);
		$("#homeSearch").submit();
	}
	function firstPage(){
		$("#homeSearch").attr("action","<?php echo base_url().index_page()."rss"; ?>/1");
		$("#homeSearch").submit();
	}

	$(function(){
		$("#makeRss").click(function(){
			var url="<?php echo base_url().index_page(); ?>prd_rss/rss_feed";
			//alert(url);
			var dataSet={ search: $("input#news_title").val(), start_date: $("input.fromdate").val(), end_date: $("input.todate").val() 
			,type: $("#NewsTypeID").val(),subtype: $("#NewsSubTypeID").val(),grov_active: $("#grov_active").val(),reporter: $("#reporter_id").val()};
			$.post(url,dataSet,function(data){
				// alert(data);
				var url = "<?php echo base_url().index_page(); ?>prd_rss/view_rss/"+data;
				$("#InputRss").val(url).select();
			});
		});
	});
	
	$('select#NewsTypeID').change(function(){
		// debugger;
	    var type_id = $('select#NewsTypeID').val();
		if (type_id != ""){
			var post_url = "<?php echo base_url().index_page(); ?>PRD_ManageNewPRD/get_NT02_TypeID/" + type_id;
		}
		else{
			var post_url = "<?php echo base_url().index_page(); ?>PRD_ManageNewPRD/get_NT02_TypeID/";
		}
		// debugger;
		// alert(post_url);
		$.ajax({
			type: "POST",
			url: post_url,
			dataType :'json',
			success: function(subtype)
			{
				// var a = JSON.parse(subtype);
				$('#NewsSubTypeID').empty();
				
				var text = "<option value=\"\">เลือกหมวดหมู่ข่าวย่อย</option>";
				$('#NewsSubTypeID').append(text);
				
				$.each(subtype,function(index,val)
				{
					var text = ""+
					"<option value=\""+val.NT03_SubTypeID+"\">"+val.NT03_SubTypeName+"</option>";
					$('#NewsSubTypeID').append(text);
				});
				var selectmenu_txt = $("#NewsSubTypeID").find("option:selected").text();
				$("#NewsSubTypeID").prev("span").text(selectmenu_txt);
				
			} //end success
		}); //end AJAX
	}); //end change 

    $(function(){
        // $(".select-menu > select > option:eq(0)").attr("selected","selected");
        var selectmenu_txt = $("#NewsTypeID").find("option:selected").text();
			$("#NewsTypeID").prev("span").text(selectmenu_txt);
        selectmenu_txt = $("#NewsSubTypeID").find("option:selected").text();
			$("#NewsSubTypeID").prev("span").text(selectmenu_txt);
		selectmenu_txt = $("#grov_active").find("option:selected").text();
			$("#grov_active").prev("span").text(selectmenu_txt);
        
        
        $(".select-menu > select").live("change",function(){
            var selectmenu_txt = $(this).find("option:selected").text();
            $(this).prev("span").text(selectmenu_txt);
        });
    });
    
</script>