<?php
echo app::div_open(array('class'=>'two-column-wrapper radius-4444'));
echo app::div_open(array('id'=>'add-rownd-wrapper','class'=>'radius-4400'));
	echo form_open('rownds/create', array('id'=>'form','class'=>'radius-4400'));
	echo form_input(array('name'=>'url','id'=>'url', 'value'=>'enter a url'));
	echo form_submit('submit','Add Rownd', 'id="add-rownd-button"');
	echo app::div('<img src="/assets/images/loader.gif" alt="loader"/>', array('class'=>'loader'));
	echo form_close();
echo app::div_close();

echo app::div_open(array('id'=>'content-left'));
	echo app::gravatar($email);
	echo '<ul id="syndication-options">';
	if (! $allow_public)
	{
		echo '<li>'. anchor('/api/json/'. $user_id .'/'. $private_key, 'Json', array('target'=>'_blank')) .'</li>';
		echo '<li>'. anchor('/api/xml/'. $user_id .'/'. $private_key, 'Xml', array('target'=>'_blank')) .'</li>';
		echo '<li>'. anchor('/api/rss/'. $user_id.'/'. $private_key, 'Rss', array('target'=>'_blank')) .'</li>';
	}
	else
	{		
		echo '<li>'. anchor('/api/json/'. $user_id , 'json', array('target'=>'_blank')) .'</li>';
		echo '<li>'. anchor('/api/xml/'. $user_id, 'xml', array('target'=>'_blank')) .'</li>';
		echo '<li>'. anchor('/api/rss/'. $user_id, 'rss', array('target'=>'_blank')) .'</li>';	
	}
	echo '</ul>';
echo app::div_close();

echo app::div_open(array('id'=>'content-right'));
if (isset($rownds) and is_array($rownds))
{
		echo anchor('#', img(array('src'=>'/assets/images/gear.png','class'=>'edit-options')));
		
		echo app::div_open(array('id'=>'edit-options-wrapper'));
			echo '<ul>';
			echo '<li><a href="" class="edit-rownds-link">Edit</a></li>';
			echo '</ul>';
		echo app::div_close();
		
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
			echo anchor($rownd->url, character_limiter($rownd->title, 70), 
						array('id'=>'anchor_title_for_'.$rownd->id,'target'=>'_blank','class'=>'rownd-link','rel'=>$rownd->id));
			echo app::div($rownd->url, array('class'=>'rownd-url', 'id'=>'anchor_url_for_'.$rownd->id));
			echo app::div('Last Rownd: '. date("m/d/Y @ h:i a", strtotime($rownd->last_visited)), array('class'=>'last-visited','id'=>'last_visited_for_'.$rownd->id));
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