<div id="masthead">
	<h1><img src="/assets/images/rowndly-logo-with-tagline.gif" alt="rowndly"/></h1>
</div>

<div id="content">
	<h2>Rowndly stores your daily rownd of sites. Features include:</h2>
	<ul class="left-column">
		<li>One step url entry</li>
		<li>Drag and drop sorting.</li>
		<li>Inline editing.</li>
		<li>RSS, XML and JSON api's.</li>
	</ul>
	<ul class="right-column">
		<li>Public or private profile.</li>
		<li>Keeps track when rownds were visited.</li>
		<li>Bookmarklet</li>
		<li>Clean minimalistic design.</li>
	</ul>
	<div class="clearfix"></div>
	<h3>Sign up to get an invitation to our public beta when it's ready.</h3>
	<?php
	echo form_open('beta/sign_up', 'id="beta-form"');
	echo form_input('email', 'Email Address');
	echo form_submit('submit', 'Sign Up', 'class="gradient-button"');
	echo form_close();
	?>
</div>