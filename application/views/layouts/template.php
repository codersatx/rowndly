<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $head_title?></title>
<meta name="description" content="<?php echo $head_description?>"/>
<link href="/assets/css/base.css" rel="stylesheet">
</head>
<body>
	<div id="message"></div>
	<div id="header">
		<div id="logo-wrapper">
			<img src="/assets/images/rowndly-logo-small.jpg" alt="rowndly" id="logo"/>
		</div>
		<div id="account-wrapper">
			<?php if ($this->auth->is_logged_in()):?>
				Welcome  <a href="/users/my_account">My Account</a> 
				<a href="javascript:javascript:(function(){var%20url%20=%20location.href;window.open('http://rowndly.com/post.php?url='%20+%20encodeURIComponent(url)%20+%20'&','_blank','location=0,menubar=no,height=300,width=800,toolbar=no,scrollbars=no,status=no');})();">Add To Rowndly</a>
				<a href="/users/logout">Logout</a>
			<?php else:?>
				<a href="/users/register">Register</a> <a href="/users/login">Login</a>
			<?php endif;?>
		</div>
	<div class="clearfix"></div>
	</div>
	<div id="wrapper">
		<div id="content-left">
			<?php echo $content?>
		</div>
	</div>
<script src="/assets/js/jquery-1.5.1.min.js"></script>
<script src="/assets/js/jquery-ui-1.8.14.custom.min.js"></script>
<script src="/assets/js/base.js"></script>
</body>
</html>
