function show_message(message, type)
{
	$('html, body').animate({scrollTop:0}, 'slow');
	$('#message').text(message);
	$('#message').removeClass('success');
	$('#message').removeClass('error');
	$('#message').removeClass('notice');
	$('#message').addClass(type);
	$('#message').slideDown('fast');
	$('#message').delay(3000).slideUp('fast');
}

$(function() {
	$( "#sortable" ).sortable({
		stop: function(event, ui){
			$('#sortable').sortable('refresh');
			var pages = $('#sortable').sortable('serialize');
			
			$.post('/rownds/sort', pages, function(data){
				show_message('Rownds sorted.', 'success');
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
				show_message('Rownd deleted.', 'success');
			}
		});
	});
	
	$('#sortable li').mouseover(function(){
		$(this).find('.delete-link, .edit-link').show();
	}).mouseleave(function(){
		$(this).find('.delete-link, .edit-link').hide();
	});
	
	$('#add-rownd-button').click(function(e){
		e.preventDefault();
		
		var url = $('#url').val();
		if (url == '' || url == 'enter a url')
		{
			show_message('Please enter a url.','error');
			return false;
		}
		
		$('.loader').show();
		var str = $('form').serialize();
		$.post('/rownds/create', str, function(data){
			show_message('Rownd added.', 'success');
			$('.loader').hide();
			$('#url').val('');
			$('#sortable').append(data);
			
			s$('#sortable li').mouseover(function(){
				$(this).find('.delete-link, .edit-link').show();
			}).mouseleave(function(){
				$(this).find('.delete-link, .edit-link').hide();
			});
			
		
			
			$('.delete-link').click(function(e){
				e.preventDefault();
				var url = $(this).attr('href');
				var rel = $(this).attr('rel');
				$.post(url, function(data){
					if (data == 'OK')
					{
						$('#rownd_'+rel).fadeOut('slow');
						show_message('Rownd deleted.', 'success');
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
	
	$('.edit-link').click(function(e){
		e.preventDefault();
		var id = $(this).attr('rel');
		$('#form_for_'+id).slideToggle('fast');
		$('#title_url_for_'+id).slideToggle('fast');
	});
	
	$('.inline-submit').click(function(e){
		e.preventDefault();
		var form_action = $(this).parent().attr('action');
		var $form = $(this).parent().serialize();
		
		$.post(form_action, $form, function(data){
			var id = data.id;
			var url = data.url;
			var title = data.title;
		
			$('#form_for_'+id).slideToggle('fast');
			$('#anchor_title_for_'+id +', #anchor_url_for_'+id).attr('href', url);
			$('#anchor_url_for_'+id).text(url);
			$('#anchor_title_for_'+id).text(title);
			$('#title_url_for_'+id).slideToggle('fast');
			show_message('Changes saved succesfully.', 'success');
		}, 'json');
	});
	
	$('.edit-rownds-link').click(function(e){
		e.preventDefault();
		if ($(this).text() == 'Edit')
		{
			$(this).text('Done');
			$('.edit-link, .delete-link').fadeIn('fast');
		}
		else
		{
			$(this).text('Edit');
			$('.edit-link, .delete-link').fadeOut('fast');
		}
	});
	
	
	$('#submit-login').click(function(e){
		e.preventDefault();
		$(this).hide();
		$('.loading').show();
		var str = $('#login-form').serialize();
		$.post('/users/login', str, function(data){
			$('#submit-login').show();
			$('.loading').hide();
			if (data.status == 'OK')
			{
				window.location.href = data.redirect;
			}
			else
			{
				show_message('Sorry, login failed.','error');
			}
		}, 'json');
	});
	
	$('.rownd-link').click(function(){
		var id = $(this).attr('rel');
		var str  = '';
		$.post('/rownds/track/'+id, str, function(data){
			$('#last_visited_for_'+id).text(data.last_visited);
		}, 'json');
	});
	
	$('.edit-options').click(function(){
		if ($('#edit-options-wrapper').is(':visible'))
		{
			$(this).removeClass('edit-options-open');
			// $('.edit-rownds-link').text('Edit');
			// 			$('.edit-link, .delete-link').fadeOut('fast');
		}
		else
		{
			$(this).addClass('edit-options-open');
		}
	
		$('#edit-options-wrapper').slideToggle('fast');
	});
	
	function show_message(message, type)
	{
 		$('html, body').animate({scrollTop:0}, 'slow');
		$('#message').text(message);
		$('#message').removeClass('success');
		$('#message').removeClass('error');
		$('#message').removeClass('notice');
		$('#message').addClass(type);
		$('#message').slideDown('fast');
		$('#message').delay(3000).slideUp('fast');
	}
});
