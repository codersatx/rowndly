My Rownds
<?php foreach($rownds as $rownd)
{
	echo $rownd->url . ' '. $rownd->email .' '. $rownd->user_id .' '. $rownd->id .'<br/>';
}
app::debug($rownds);

echo form_open('rownds/create');
echo form_label('Url');
echo form_input('url');
echo form_label('Title');
echo form_input('title');
echo form_hidden('user_id', '1');
echo form_submit('submit','Save');
echo form_close();

?>
