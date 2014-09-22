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

    <link rel="shortcut icon" href="<?php echo image_asset_url('favicon.ico')?>"> 

	<?php echo css_asset('reset.css'); ?>
	<?php echo css_asset('style.css'); ?>
	<?php echo js_asset('jquery-1.8.3.min.js'); ?>

</head>
<form action="<?php echo base_url();?>rss/signin" method="post">
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
						<p id="" style="color: red; margin-bottom: 10px; font-size: large;font-family:supermarketregular"><?php echo $status;?></p>
					  </li>
					  <li style="text-align:center;">
						<input class="txt-field" type="text" value="" name="username"  placeholder="Username" style="width: 60%" id="username">
					  </li>
					  <li style="margin-top:15px;text-align:center;">
						<input class="txt-field" type="password" value="" name="password"  placeholder="Password" style="width: 60%" id="password">
					  </li>
					  <li style="margin-top:40px;text-align:center;">
						<input class="bt" type="submit" value="Login" name="submit" style="width:18%;padding:4px;cursor:pointer;" id="login">
					  </li>
					</ul> 
                </div>
            </div>
        </div>
    </div>
</body>
</html>