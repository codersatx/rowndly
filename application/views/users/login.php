<?php

echo form_open('users/login', array('id'=>'login-form'));
echo form_label('Username');
echo form_input('username');
echo form_label('Password');
echo form_password('password');
echo form_submit('submit', 'Login', 'id="submit-login"');
echo app::div('Processing...', array('class'=>'loading'));
echo app::div('', array('class'=>'clearfix'));
echo form_close();