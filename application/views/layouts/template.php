<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $head_title?></title>
<meta name="description" content="<?php echo $head_description?>"/>
<link href="/assets/css/base.css" rel="stylesheet">
<script src="/assets/js/jquery-1.5.1.min.js"></script>
<script src="/assets/js/jquery-ui-1.8.14.custom.min.js"></script>
<script src="/assets/js/base.js"></script>
</head>
<body>
	<div id="message"></div>
	
	<div id="header">
		<div id="logo-wrapper">
			<a href="/"><img src="/assets/images/logo-small.gif" alt="rowndly"/></a>
		</div>
		<div id="account-wrapper">
			<?php if ($this->auth->is_logged_in()):?>
			<a href="/rownds">My Rownds</a>  
			<a href="/users/my_account">My Account</a> 
				<a href="javascript:javascript:(function(){var%20url%20=%20location.href;window.open('http://rowndly.com/post.php?url='%20+%20encodeURIComponent(url)%20+%20'&','_blank','location=0,menubar=no,height=300,width=800,toolbar=no,scrollbars=no,status=no');})();">Add To Rowndly</a>
				<a href="/users/logout">Logout</a>
			<?php else:?>
				<a href="/users/register">Register</a> <a href="/users/login">Login</a>
			<?php endif;?>
		</div>
	<div class="clearfix"></div>
	</div>
	
	<div id="title-wrapper"><h1><?php echo $title;?></h1></div>
	
	<div id="wrapper" class="radius-4444">
		<?php echo $content?>
	</div>
	
	<div id="footer">rowndly - &copy; 2011 - agevio</div>
</body>
</html>
