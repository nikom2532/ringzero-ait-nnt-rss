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
<form action ="http://111.223.32.9/prdservice/api/authenticate" method="post">
<body>
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
                <div id="login-form">
                    <!--<form action="<?php echo base_url();?>rss/sharing" method="post">-->
                        <ul>
                          <li style="text-align:center;">
                            <input class="txt-field" type="text" value="" name="username"  placeholder="Username" style="width: 60%" id="username">
                          </li>
                          <li style="margin-top:15px;text-align:center;">
                            <input class="txt-field" type="password" value="" name="password"  placeholder="Password" style="width: 60%" id="password">
                          </li>
                          <li style="margin-top:40px;text-align:center;">
                            <input class="bt" type="submit" value="Login" name="submit" style="width:18%;padding: 4px;" id="">
                          </li>
                        </ul> 
                    <!--</form>-->
                </div>
            </div>
        </div>
    </div>
</form>
</body>
</html>