<?php
$public_profile = app::session('allow_public') == 1 ? 'Public Profile' : 'Private Profile';

echo app::div_open(array('class'=>'two-column-wrapper radius-4444'));
echo app::div_open(array('id'=>'add-rownd-wrapper','class'=>'radius-4400'));
	echo form_open('rownds/create', array('id'=>'form','class'=>'radius-4400'));
	echo form_input(array('name'=>'url','id'=>'url', 'value'=>'enter a url'));
	echo form_submit('submit','Add Rownd', 'id="add-rownd-button"');
	echo app::div('<img src="/assets/images/loader.gif" alt="loader"/>', array('class'=>'loader'));
	echo form_close();
echo app::div_close();

echo app::div_open(array('id'=>'content-left'));
	echo app::div(app::gravatar($email, NULL, 100), array('id'=>'gravatar'));
	echo '<ul id="profile">';
		echo '<li><strong>'. app::session('first_name') .' '. app::session('last_name') .'</strong></li>';
		echo '<li>'. app::session('email') .'</li>';
		echo '<li>'. $public_profile .'</li>';
	echo '</ul>';
	
	echo '<ul id="syndication-options">';
	if (app::session('allow_public'))
	{
		echo '<li>'. anchor('/api/json/'. $user_id , 'JSON', array('target'=>'_blank')) .'</li>';
		echo '<li>'. anchor('/api/xml/'. $user_id, 'XML', array('target'=>'_blank')) .'</li>';
		echo '<li>'. anchor('/api/rss/'. $user_id, 'RSS', array('target'=>'_blank')) .'</li>';
	}
	else
	{		
		echo '<li>'. anchor('/api/json/'. $user_id .'/'. app::session('private_key'), 'JSON', array('target'=>'_blank')) .'</li>';
		echo '<li>'. anchor('/api/xml/'. $user_id .'/'. app::session('private_key'), 'XML', array('target'=>'_blank')) .'</li>';
		echo '<li>'. anchor('/api/rss/'. $user_id.'/'. app::session('private_key'), 'RSS', array('target'=>'_blank')) .'</li>';
	}
	echo '</ul>';
	
	echo app::div_open(array('class'=>'add-to-rowndly-wrapper'));
	echo app::div('Bookmarklet', array('class'=>'add-to-rowndly-label'));
	echo app::div("<a href=\"javascript:javascript:(function(){var%20url%20=%20location.href;window.open('http://rowndly.com/post.php?url='%20+%20encodeURIComponent(url)%20+%20'&','_blank','location=0,menubar=no,height=130,width=650,toolbar=no,scrollbars=no,status=no');})();\" title=\"Drag this to your bookmark bar.\">Add To Rowndly</a>", array('class'=>'add-to-rowndly-link'));
	echo app::div_close();

echo app::div_close();

echo app::div_open(array('id'=>'content-right'));
if (isset($rownds) and is_array($rownds))
{		
		echo '<ul id="sortable">';
		echo '<li class="empty"></li>';
		foreach($rownds as $rownd)
		{
			$edit = anchor('/rownds/edit/'. $rownd->id,
				'<img src="/assets/images/pencil.png" alt="Edit Rownd"/>', 
				array('class'=>'edit-link','rel'=>$rownd->id));
		
			$delete = anchor('/rownds/destroy/'. $rownd->id, 
				'<img src="/assets/images/minus.png" alt="Delete Rownd"/>', 
				array('class'=>'delete-link','rel'=>$rownd->id));
			
			echo '<li class="ui-state-default" id="rownd_'. $rownd->id .'">';
			echo '<div id="title_url_for_'. $rownd->id .'"/>';
			echo anchor($rownd->url, character_limiter($rownd->title, 56), 
						array('id'=>'anchor_title_for_'.$rownd->id,'target'=>'_blank','class'=>'rownd-link','rel'=>$rownd->id));
			echo app::div($rownd->url, array('class'=>'rownd-url', 'id'=>'anchor_url_for_'.$rownd->id));
			if ($rownd->last_visited)
			{
				echo app::div('Last Rownd: '. date("m/d/Y @ h:i a", strtotime($rownd->last_visited)), array('class'=>'last-visited','id'=>'last_visited_for_'.$rownd->id));
			}
			else
			{
				echo app::div('Last Rownd: Never', array('class'=>'last-visited','id'=>'last_visited_for_'.$rownd->id));
			}
		
			echo '</div>';
		
			echo '<form method="post" action="/rownds/update" class="inline-form" id="form_for_'. $rownd->id .'">
			<input type="input" value="'. $rownd->title .'" name="inline-title" class="inline-title"/>
			<input type="input" value="'. $rownd->url .'" name="inline-url" class="inline-url"/>
			<input type="hidden" value="'.$rownd->id.'" name="inline-id" id="id_for_'.$rownd->id.'"/>
			<input type="submit" value="Save" class="inline-submit"/>
			</form>';
			echo $edit; 
			echo $delete .'</li>';
		}
		echo '</ul>';
}
echo app::div_close();

echo app::div('', array('class'=>'clearfix'));
echo app::div_close();