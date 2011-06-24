<html>
<head>
<title>Login</title>

</head>
<body>
<h1>User Login Form</h1>

<?php 

	echo form_open(base_url() . 'user/login');
	
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
	
	$submit = array(
		'name'	=>	'submit',
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
		<td></td>
		<td><?php echo form_submit($submit); echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".anchor('/user/register/','Register');?> </td>
	</tr>
	<tr>
		<td></td>
		<td><?php 
				echo validation_errors(); 
				if(isset($err))
				{
					echo $err;
				}
			?>
		</td>
	</tr>
</table>



<?php echo form_close(); ?>
</body>
</html>