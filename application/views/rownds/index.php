<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<title>my daily rownds - rowndly</title>
<script src="/assets/js/jquery-1.5.1.min.js" type="text/javascript"></script>
<script src="/assets/js/jquery-ui-1.8.14.custom.min.js" type="text/javascript"></script>
<script>
	$(function() {
		$( "#sortable" ).sortable({
			stop: function(event, ui){
				$('#sortable').sortable('refresh');
				var pages = $('#sortable').sortable('serialize');
				
				$.post('/rownds/sort', pages, function(data){
					//alert(data);
				});
			},
			placeholder: "ui-state-highlight"
		});
		$( "#sortable" ).disableSelection();
		$('#window-target').click(function(){
			if ($(this).is(':checked') == true)
			{
				$('#sortable a').attr('target','_blank');
			}
			else
			{
				$('#sortable a').attr('target','_parent');
			}
		});
		
		$('.delete-link').click(function(e){
			e.preventDefault();
			var url = $(this).attr('href');
			var rel = $(this).attr('rel');
			$.post(url, function(data){
				if (data == 'OK')
				{
					$('#rownd_'+rel).fadeOut('slow');
				}
			});
		});
		
		$('#sortable li').mouseover(function(){
			$(this).find('.delete-link').show();
		}).mouseleave(function(){
			$(this).find('.delete-link').hide();
		});
		
		$('#add-rownd').click(function(e){
			e.preventDefault();
		
			$('.loader').show();
			var url = $('#url').val();
			var str = $('form').serialize();
			$.post('/rownds/create', str, function(data){
				$('.loader').hide();
				$('#url').val('');
				$('#sortable').append(data);
				$('#sortable li').mouseover(function(){
					$(this).find('.delete-link').show();
				}).mouseleave(function(){
					$(this).find('.delete-link').hide();
				});
				$('.delete-link').click(function(e){
					e.preventDefault();
					var url = $(this).attr('href');
					var rel = $(this).attr('rel');
					$.post(url, function(data){
						if (data == 'OK')
						{
							$('#rownd_'+rel).fadeOut('slow');
						}
					});
				});
				
			});
		});
		
		$('input#url').focus(function(){

			if ($(this).val() == 'enter a url')
			{
				$(this).val('');
				$(this).addClass('in-focus');
			}
		}).blur(function(){
			if ($(this).val() == '')
			{
				$(this).val('enter a url');
				$(this).removeClass('in-focus');
			}
		});
	});
	
	
	</script>
	
	<style>
		body
		{
			font: 12px "Lucida Sans", Arial;
			background:#00040f url(/assets/css/i/bg.jpg) repeat-x 0 0;
		}
		
		#sortable 
		{ 
			list-style-type: none; 
			margin: 0; 
			padding: 0;
		}
		
		#sortable li
		{ 
			text-align:left;
			margin: 0;
			padding: 10px 0 10px 15px; 
			font-size: 1.2em; 
			clear:both;
			border-bottom: 1px dotted #ccc;
			position:relative;
			height:30px;
		}
		
		#sortable li:hover
		{
			background:transparent url(/assets/css/i/icon_sortable.png) no-repeat 0px 15px;
			cursor:move;
		}
		
		a
		{
			color:#72a441;
		}
	
		.ui-state-highlight 
		{
			background-color:#f2f2f2;
			border:1px solid #ccc !important;
		}
		
		.delete-link
		{
			position:absolute;
			top:15px;
			right:0;
			display:none;
		}
		
		input#url
		{
			font-size:24px;
			width:585px;
			border:1px solid #7aafc3;
			background-color:#d5f0f6;
			color:#7aafc3;
			font-style:italic;
			padding:6px;
			outline:none;
			
		}
		
		.loader
		{
			display:none;
			position:absolute;
			top: 15px;
			right: 129px;
		}
		
		#sortable li.empty
		{
			display:none;
		}
		
		.rownd-url
		{
			font-size:10px;
			color:#999;
		}
		
		#wrapper
		{
			width:700px;
			margin:auto;
			padding:30px 25px;
			background:#fff;
			margin-top:20px;
			border-radius:6px;
			-moz-border-radius:6px;
			-webkit-border-radius:6px;
			
			-moz-box-shadow: 0 0 5px #135f79;
			-webkit-box-shadow: 0 0 5px #135f79;
			box-shadow: 0 0 5px #135f79;
		}
		
		#logo-wrapper
		{
			text-align:center;
			margin-bottom:30px;
		}
		
		#add-rownd
		{
			background-color:#1b83af;
		        background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#1b83af), to(#025688));
		        background: -moz-linear-gradient(center top , #1b83af 0pt, #025688 100%) repeat scroll 0 0 transparent;
		        border-color: initial;
		        border: 0px #3F733C;
		        color: #8cd8ef;
		        font-size: 15px;
		        margin-right: 12px;
		        padding: 12px 15px;
		        text-shadow: rgba(0, 0, 0, 0.398438) 0px 1px 0px;
		        -webkit-border-radius:0 4px 4px 0;
		        -moz-border-radius:0 4px 4px 0;
		        border-radius:0 4px 4px 0;
		        text-transform:uppercase;
		        cursor:pointer;
		position:absolute;
		top:0;
		right:-15px;
		}
		
		#form
		{
			position:relative;
			margin-bottom:20px;
		}
		
		input#url.in-focus
		{
			color:#000;
			font-style:normal;
		}
		
		#account-wrapper
		{
			width:700px;
			margin:auto;
			color:#fff;
			margin-top:20px;
			text-align:right;
			text-shadow:0 1px #0e5a74;
			background-color:#23a6d2;
			padding:10px 7px 10px 43px;
			
			border-radius:6px;
			-moz-border-radius:6px;
			-webkit-border-radius:6px;
		}
		
		#account-wrapper a
		{
			color:#68c1de;
			text-decoration:none;
			background-color:#16708e;
			padding:6px;
			border-radius:4px;
			font-size:10px;
			margin-left:2px;
			text-shadow:0 1px #0e5a74;
			
		}
		
		#account-wrapper a:hover
		{
			color:#fff;
		}
	</style>
	
</head>

<body>
	<div id="account-wrapper">
	Welcome Alex <a href="/user/account">My Account</a> <a href="/user/logout">Logout</a>
	</div>
<div id="wrapper">
<div id="logo-wrapper">
<img src="/assets/images/rowndly-logo.jpg" alt="rowndly" id="logo"/>
</div>

<?php 
echo app::get_flash('notice');
echo app::get_flash('type');

echo form_open('rownds/create', array('id'=>'form'));
echo form_input(array('name'=>'url','id'=>'url', 'value'=>'enter a url'));
echo form_hidden('user_id', '1');
echo form_hidden('group_id', '1');
echo form_submit('submit','Add Rownd', 'id="add-rownd"');
echo app::div('<img src="/assets/images/loader.gif" alt="loader"/>', array('class'=>'loader'));
echo form_close();
if (isset($rownds) and is_array($rownds))
{
	echo '<ul id="sortable">';
	echo '<li class="empty"></li>';
	foreach($rownds as $rownd)
	{
		$delete = anchor('/rownds/destroy/'. $rownd->id, '<img src="/assets/images/minus.png" alt="Delete Rownd"/>', array('class'=>'delete-link','rel'=>$rownd->id));
		echo '<li class="ui-state-default" id="rownd_'. $rownd->id .'">';
		echo anchor($rownd->url, character_limiter($rownd->title, 70));
		echo app::div($rownd->url, array('class'=>'rownd-url'));
		echo $delete .'</li>';
	}
	echo '</ul>';
}

?>
</div>
</body>
</html>
