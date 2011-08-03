<?php
if(isset($message))
{
	echo app::show_js_message($message, $message_type);
}

echo app::div_open(array('class'=>'single-column'));

if (app::get_flash('notice'))
{
	echo app::div(app::get_flash('notice'), array('class'=>'message '. app::get_flash('notice_type')));
}

if (isset($custom_error_message))
{
	echo app::div($custom_error_message, array('class'=>'message error'));
}

echo validation_errors();

echo form_open('users/change_password');
echo app::div_open(array('class'=>'form-row'));
	echo form_label('Current Password');
	echo form_password('current_password');
echo app::div_close();

echo app::div_open(array('class'=>'form-row'));
	echo form_label('New Password');
	echo form_password('password');
echo app::div_close();

echo app::div_open(array('class'=>'form-row'));
	echo form_label('Confirm New Password');
	echo form_password('confirm_password');
echo app::div_close();

echo app::div_open(array('class'=>'form-row'));
	echo form_submit('submit', 'Save', 'class="gradient-button"');
echo app::div_close();
echo form_close();

echo app::div_close();