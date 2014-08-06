<?php
	header('Access-Control-Allow-Origin:*');
?>
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
	<?php echo js_asset('jquery-1.8.3.min.js'); ?>
</head>
<body>
    <div class="container">
    <!-- HEADER -->
        <div class="wrapper">
            <div class="bg-header">
                <div id="header">
                    <div class="logo">
                        <img src="<?php echo image_asset_url('logo_rss.png')?>" alt="Logo" style="width:auto;">
                    </div>
                </div>
            </div>
        </div>
    <!-- Content -->
        <div class="wrapper">
            <div class="content">
                <div id="login-form">
					<ul>
					  <li style="text-align:center;">
						<p id="error" style="color: red; margin-bottom: 10px; font-size: large; display: none;font-family:supermarketregular">ไม่พบข้อมูลผู้ใช้งาน</p>
					  </li>
					  <li style="text-align:center;">
						<input class="txt-field" type="text" value="" name="username"  placeholder="Username" style="width: 60%" id="username">
					  </li>
					  <li style="margin-top:15px;text-align:center;">
						<input class="txt-field" type="password" value="" name="password"  placeholder="Password" style="width: 60%" id="password">
					  </li>
					  <li style="margin-top:40px;text-align:center;">
						<input class="bt" type="button" value="Login" name="submit" style="width:18%;padding: 4px;" id="login">
					  </li>
					</ul> 
                </div>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript">
$(function(){
	 $("#login").click(function(){
		 console.log('onclick');
		 var post_url = "http://111.223.32.9/prdservice/api/authenticate";
		 $.ajax({
			type: 'POST',
			url: 'http://111.223.32.9/prdservice/api/authenticate',
			crossDomain: true,
			data: { username:$("#username").val(), password:$("#password").val() },
			dataType: 'json',
			success: function(responseData) {
				console.log(responseData);
				var UserID = responseData.UserID;
				var Authen = responseData.Authenticated;
				var Username = responseData.UserName;
				var redirectURL = '<?php echo base_url()?>index.php/rss/login';
				redirect(redirectURL,UserID,Authen,Username);
			},
			error: function (responseData) {
				alert('POST failed.');
			}
		});
	 });
});
function redirect(page,value,authen,username)
{
	$.ajax({
		type: 'POST',
		url: page,
		data: {UserId: value , Authenticated: authen , Username: username},
		success:function(rs){
			if(rs == 'Success')
			{
				window.location="<?php echo base_url();?>index.php/rss/sharing";
			}
			else
			{
				//alert(rs);
				$("#error").show();
			}
		}
	});
}
</script>
</html>