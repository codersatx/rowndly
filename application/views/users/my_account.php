<?php

if(isset($status) && $status == 1)
{
	echo app::show_js_message('Your account was changed successfully.', 'success');
}

if (isset($message))
{
	echo app::show_js_message($message, $message_type);
}

echo app::div_open(array('class'=>'single-column'));

if (isset($custom_error_message))
{
	echo app::div($custom_error_message, array('class'=>'message error'));
}

echo validation_errors();

echo form_open('/my_account');
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
	echo form_label('Public Profile');
	echo form_checkbox(array('name'=>'allow_public', 'value'=>'1', 'checked'=>$user->allow_public));
	echo app::div('Allow others to see your rownds.', array('class'=>'input-description'));
echo app::div_close();

echo app::div_open(array('class'=>'form-row'));
	echo form_label('Private Key');
	echo form_input('private_key', $user->private_key);
	echo app::div('To allow private access to your rownds via the api enter a private key.', array('class'=>'input-description'));
echo app::div_close();

echo app::div_open(array('class'=>'form-row'));
	echo form_label('Show Thumbnails');
	echo form_checkbox(array('name'=>'show_thumbnails', 'value'=>'1', 'checked'=>$user->show_thumbnails));
	echo app::div('Show or hide thumbnail previews.', array('class'=>'input-description'));
echo app::div_close();

echo app::div_open(array('class'=>'form-row'));
	echo form_submit('submit','Save', 'class="gradient-button"');
echo app::div_close();

echo form_close();

echo app::div_close();