<?php

echo app::div_open(array('class'=>'single-column'));

if (isset($custom_error_message))
{
	echo app::div($custom_error_message, array('class'=>'error'));
}

echo validation_errors();

echo form_open('users/register');
echo app::div_open(array('class'=>'form-row'));
	echo form_label('First Name');
	echo form_input('first_name', set_value('first_name'));
echo app::div_close();

echo app::div_open(array('class'=>'form-row'));
	echo form_label('Last Name');
	echo form_input('last_name', set_value('last_name'));
echo app::div_close();

echo app::div_open(array('class'=>'form-row'));
	echo form_label('Email Address');
	echo form_input('email', set_value('email'));
	echo app::div('Required. Please enter a valid email address.', array('class'=>'input-description'));
echo app::div_close();

echo app::div_open(array('class'=>'form-row'));
	echo form_label('Username');
	echo form_input('username', set_value('username'));
	echo app::div('Required. At least 6 characters.', array('class'=>'input-description'));
echo app::div_close();

echo app::div_open(array('class'=>'form-row'));
	echo form_label('Password');
	echo form_password('password', set_value('password'));
	echo app::div('Required. At least 6 characters.', array('class'=>'input-description'));
echo app::div_close();

echo app::div_open(array('class'=>'form-row'));
	echo form_label('Confirm Password');
	echo form_password('confirm_password', set_value('confirm_password'));
	echo app::div('Required. At least 6 characters.', array('class'=>'input-description'));
echo app::div_close();

echo app::div_open(array('class'=>'form-row'));
	echo form_submit('submit','Register', 'class="gradient-button"');
echo app::div_close();

echo form_close();

echo app::div_close();