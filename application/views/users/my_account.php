<h2>My Account</h2>


<?php

if (isset($custom_error_message))
{
	echo app::div($custom_error_message, array('class'=>'error'));
}

echo validation_errors();

echo form_open('users/my_account');
echo app::div_open(array('class'=>'form-row'));
	echo form_label('First Name');
	echo form_input('first_name', $user->first_name);
echo app::div_close();

echo app::div_open(array('class'=>'form-row'));
	echo form_label('Last Name');
	echo form_input('last_name', $user->last_name);
echo app::div_close();

echo app::div_open(array('class'=>'form-row'));
	echo form_label('Email Address');
	echo form_input('email', $user->email);
	echo app::div('Required. Please enter a valid email address.', array('class'=>'input-description'));
echo app::div_close();

echo app::div_open(array('class'=>'form-row'));
	echo form_label('Username');
	echo form_input('username', $user->username);
	echo app::div('Required. At least 6 characters.', array('class'=>'input-description'));
echo app::div_close();

echo app::div_open(array('class'=>'form-row'));
	echo form_label('Password');
	echo anchor('users/change_password','Change Password');
echo app::div_close();

echo app::div_open(array('class'=>'form-row'));
	echo form_submit('submit','Save');
echo app::div_close();

echo form_close();