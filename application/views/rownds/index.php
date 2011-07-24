<?php
echo form_open('rownds/create', array('id'=>'form'));
echo form_input(array('name'=>'url','id'=>'url', 'value'=>'enter a url'));
echo form_submit('submit','Add Rownd', 'id="add-rownd"');
echo app::div('<img src="/assets/images/loader.gif" alt="loader"/>', array('class'=>'loader'));
echo form_close();
echo anchor('#','Edit', array('class'=>'edit-mode like-button'));

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
		echo anchor($rownd->url, character_limiter($rownd->title, 70), 
					array('id'=>'anchor_title_for_'.$rownd->id,'target'=>'_blank'));
		echo app::div($rownd->url, array('class'=>'rownd-url', 'id'=>'anchor_url_for_'.$rownd->id));
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