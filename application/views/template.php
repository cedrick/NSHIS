<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Northstar Solutions - Hardware Inventory System</title>
		<link type="text/css" href="<?php echo base_url() ?>css/style2.css" rel="stylesheet" />  
		<link type="text/css" href="<?php echo base_url() ?>calendar/cwcalendar.css" rel="stylesheet" />
		<script type="text/javascript" src="<?php echo base_url() ?>calendar/calendar.js"></script>
		<script type="text/javascript" src="<?php echo base_url() ?>jquery/jquery-ui/js/jquery-1.6.1.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url() ?>jquery/jquery-ui/js/jquery-ui-1.8.14.custom.min.js"></script>
		<link type="text/css" href="<?php echo base_url() ?>jquery/jquery-ui/css/custom-theme/jquery-ui-1.8.14.custom.css" rel="stylesheet" />  
		<script type="text/javascript" src="<?php echo base_url() ?>jquery/plugins/jquery.autogrowtextarea.js"></script>
		<script type="text/javascript" src="<?php echo base_url() ?>jquery/plugins/ambet.autocomplete.js"></script>
		<style>
			.ui-autocomplete {
				max-height: 200px;
				overflow-y: auto;
				overflow-x: hidden;
				padding-right: 20px;
				width: 170px;
			}
			
			.ui-autocomplete li {
				margin-bottom: 4px;
			}
			
			.ui-autocomplete-loading {
				background: white url('<?php echo base_url() ?>css/images/ui-anim_basic_16x16.gif') right center no-repeat;
			}
		</style>
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
								$this->load->view($page, $data);	
							}
						}
					?>
				</div>
			</div>
			<div id="contentFooter">
				<?php $this->load->view('pageTemplate/footer'); ?>
			</div>
		</div>
		<div id="dialog-confirm" title="Delete Item">
			<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>These item will be permanently deleted and cannot be undone. Are you sure?</p>
		</div>
	</body>
</html>