<?php 

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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Northstar Solutions - Hardware Inventory System</title>
		<link type="text/css" href="<?php echo base_url() ?>css/style2.css" rel="stylesheet" />  
	</head>
	<body>
		<div id="content">
			<div id="logoContentHeader">
				<div id="nslogo"></div>
				<div id="titleText">NSHIS <?php echo $this->config->item('version'); ?></div>
			</div>
			<div id="contentBody">
				<div id="leftcontentBody">
					<div class="section width500" >
						<div class="sectionHeader">User Register</div>
						<div class="sectionBody">
							 <?php echo form_open(base_url() . 'user/register'); ?>
							 <table width="100%" border="0" cellpadding="10">
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
								<tr>
									<td>Secrete Phrase</td>
									<td><?php echo form_password($secrete_phrase); ?></td>
								</tr>
								<tr>
									<td></td>
									<td><?php echo form_submit($submit); echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".anchor('/user/login/','Login');?></td>
								</tr>
							 </table>
							<?php echo form_close(); ?>
						</div>
						<?php echo validation_errors(); ?>
					</div>
				</div>
				
			</div>
			<div id="contentFooter">
				<?php include 'pageTemplate/footer.php' ;?>
			</div>
		</div>
	</body>
</html>