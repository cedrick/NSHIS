<html>
<head>
<title>Register</title>

</head>
<body>
<h1>User Registration Form</h1>

<?php 

	echo form_open(base_url() . 'user/register');
	
	$username = array(
		'name'	=>	'username',
		'id'	=>	'username',
		'value'	=>	set_value('username')
	);
	
	$password = array(
		'name'	=>	'password',
		'id'	=>	'password',
		'value'	=>	''
	);
	
	$password_conf = array(
		'name'	=>	'password_conf',
		'id'	=>	'password_conf',
		'value'	=>	''
	);
	
	$user_level = array (
		'1'  => '1',
        '2'    => '2',
        '3'   => '3',
        '4' => '4',
		'5' => '5'
	);
	
	$secrete_phrase = array(
		'name'	=>	'secrete_phrase',
		'id'	=>	'secrete_phrase',
		'value'	=>	set_value('secrete_phrase')
	);
	
	$submit = array(
		'name'	=>	'reg_submit',
		'value'	=>	'Submit'
	);

?>

<table>
	<tr>
		<td>Username</td>
		<td><?php echo form_input($username); ?></td>
	</tr>
	<tr>
		<td>Password</td>
		<td><?php echo form_password($password); ?></td>
	</tr>
	<tr>
		<td>Password Confirm</td>
		<td><?php echo form_password($password_conf); ?></td>
	</tr>
	<!--<tr>
		<td>User Level</td>
		<td><?php echo form_dropdown('user_level',$user_level); ?></td>
	</tr>	
	--><tr>
		<td>Secrete Phrase</td>
		<td><?php echo form_password($secrete_phrase); ?></td>
	</tr>
	<tr>
		<td></td>
		<td><?php echo form_submit($submit); echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".anchor('/user/login/','Login');?></td>
	</tr>
	<tr>
		<td></td>
		<td><?php echo validation_errors(); ?></td>
	</tr>
</table>


<?php echo form_close(); ?>
</body>
</html>