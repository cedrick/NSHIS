<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Northstar Solutions - Hardware Inventory System</title>
		<link type="text/css" href="<?php echo base_url() ?>css/style2.css" rel="stylesheet" />  
		<link type="text/css" href="<?php echo base_url() ?>calendar/cwcalendar.css" rel="stylesheet" />
		<script type="text/javascript" src="<?php echo base_url() ?>calendar/calendar.js"></script>
		<script type="text/javascript" src="<?php echo base_url() ?>jquery/jquery-1.6.1.min.js"></script>  
		<script type="text/javascript" src="<?php echo base_url() ?>jquery/plugins/jquery.autogrowtextarea.js"></script>  
	</head>
	<body>
		<div id="content">
			<div id="contentHeader">
				<?php $this->load->view('pageTemplate/top-menu'); ?>
			</div>
			<div id="contentBody">
				<div id="leftcontentBody">
					<?php $this->load->view('pageTemplate/side-menu'); ?>
				</div>
				<div id="rightcontentBody">
					<?php 
						if(isset($page) && !isset($data))
						{
							$this->load->view($page);
						}
						elseif(isset($page) && isset($data))
						{
							if(isset($cubicle))
							{
								$this->load->view($page, $data, $cubicle);
							}
							else 
							{
								if (isset($comments))
								{
									$this->load->view($page, $data, $comments);
								}
								else 
								{
									$this->load->view($page, $data);	
								}
								
							}
						}
					?>
				</div>
			</div>
			<div id="contentFooter">
				<?php $this->load->view('pageTemplate/footer'); ?>
			</div>
		</div>
	</body>
</html>