<?php
echo '<h2>Add to Daily Rownd</h2>';
echo form_open('rownds/create', array('id'=>'form'));
echo form_input(array('name'=>'url','id'=>'url', 'value'=>$url));
echo form_submit('submit','Add Rownd', 'id="add-rownd"');
echo app::div('<img src="/assets/images/loader.gif" alt="loader"/>', array('class'=>'loader'));
echo form_close();