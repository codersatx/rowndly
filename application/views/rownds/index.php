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
	});
	
	
	</script>
	
	<style>
		#sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
		#sortable li { margin: 0 5px 5px 5px; padding: 5px 5px 5px 15px; font-size: 1.2em; height: 1.5em;border:1px solid #ccc; clear:both;}
		#sortable li:hover{ background:transparent url(/assets/css/i/icon_sortable.png) no-repeat 0px 10px;cursor:move;}
		html>body #sortable li { height: 1.5em; line-height: 1.2em; }
		.ui-state-highlight { height: 1.5em; line-height: 1.2em; background-color:#f2f2f2;border:1px solid #ccc; }
		.delete-link{float:right;display:none;}
		#url{font-size:24px;width:80%;}
		
	</style>

My Rownds
<form>
<input type="checkbox" value="yes" name="open-in-new-window" id="window-target"> Open Links In New Window
</form>
<?php 
echo app::get_flash('notice');
echo app::get_flash('type');
echo form_open('rownds/create');
echo form_label('Url');
echo form_input(array('name'=>'url','id'=>'url'));
echo form_hidden('user_id', '1');
echo form_hidden('group_id', '1');
echo form_submit('submit','Save');
echo form_close();
if (isset($rownds) and is_array($rownds))
{
	echo '<ul id="sortable">';
	foreach($rownds as $rownd)
	{
		$delete = anchor('/rownds/destroy/'. $rownd->id, 'Delete', array('class'=>'delete-link','rel'=>$rownd->id));
		echo '<li class="ui-state-default" id="rownd_'. $rownd->id .'">'. anchor($rownd->url, character_limiter($rownd->title, 70)) . $delete .'</li>';
	}
	echo '</ul>';
}

?>
