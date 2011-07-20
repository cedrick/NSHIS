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
	
	$submit = array(
		'name'	=>	'submit',
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
					<div class="section width350" >
						<div class="sectionHeader">User Login</div>
						<div class="sectionBody">
							 <?php echo form_open(base_url() . 'user/login'); ?>
							 <table width="100%" border="0" cellpadding="10">
							 	<tr>
									<td width="10%">
										Username:
									</td>
									<td width="80%">
										<?php echo form_input($username); ?>
									</td>
								</tr>
							 	<tr>
									<td>
										Password:
									</td>
									<td>
										<?php echo form_password($password); ?>
									</td>
								</tr>
								<tr>
									<td>
										
									</td>
									<td>
										<?php echo form_submit($submit); echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".anchor('/user/register/','Register');?>
									</td>
								</tr>
								
							 </table>
							<?php echo form_close(); ?>
						</div>
						<?php 
							echo validation_errors(); 
							if(isset($err))
							{
								echo $err;
							}
						?>
					</div>
				</div>
				
			</div>
			<div id="contentFooter">
				<?php include 'pageTemplate/footer.php' ;?>
			</div>
		</div>
	</body>
</html>