<?php
echo form_open('rownds/create', array('id'=>'form'));
echo form_input(array('name'=>'url','id'=>'url', 'value'=>$url));
echo form_submit('submit','Add Rownd', 'id="post-rownd-button" class="gradient-button"');
echo app::div('<img src="/assets/images/loader.gif" alt="loader"/>', array('class'=>'loader'));
echo form_close();