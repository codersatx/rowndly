<?php

echo form_open('rownds/update');
echo form_label('Url');
echo form_input('url', $rownd->url);
echo form_label('Title');
echo form_input('title', $rownd->title);
echo form_hidden('user_id', $rownd->user_id);
echo form_hidden('id', $rownd->id);
echo form_submit('submit','Save');
echo form_close();

?>