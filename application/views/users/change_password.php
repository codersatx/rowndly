<h2>Change Password</h2>
<?php
echo app::get_flash('notice');

if (isset($custom_error_message))
{
	echo app::div($custom_error_message, array('class'=>'error'));
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
	echo form_submit('submit', 'Save');
echo app::div_close();
echo form_close();
