					<?php 

						echo form_open(base_url() . 'usb_headset/add');
						
						$usb_headset_name = array(
							'name'	=>	'usb_headset_name',
							'id'	=>	'usb_headset_name',
							'value'	=>	set_value('usb_headset_name')
						);
						
						$usb_headset_other_name = array(
							'name'	=>	'usb_headset_other_name',
							'id'	=>	'usb_headset_other_name',
							'value'	=>	set_value('usb_headset_other_name')
						);
						
						$usb_headset_sn = array(
							'name'	=>	'usb_headset_sn',
							'id'	=>	'usb_headset_sn',
							'value'	=>	set_value('usb_headset_sn')
						);
						
						$usb_headset_date_purchased = array(
							'name'	=>	'usb_headset_date_purchased',
							'id'	=>	'usb_headset_date_purchased',
							'value'	=>	set_value('usb_headset_date_purchased'),
							'onclick' => "fPopCalendar('usb_headset_date_purchased')"
						);
						
						$usb_headset_notes = array(
							'name'	=>	'usb_headset_notes',
							'id'	=>	'usb_headset_notes',
							'rows'	=>	'4',
							'cols'	=>	'30',
							'value'	=>	set_value('usb_headset_notes')
						);
						
						$submit = array(
							'name'	=>	'submit',
							'value'	=>	'Submit'
						);
											
					?>
					
					<div class="section width500" >
						<div class="sectionHeader">Add New Usb_headset</div>
						<div class="sectionBody">
							<form action="" method="get">
							 <table width="100%" border="0" cellpadding="10">
							 	<tr>
									<td width="30%">
										Name:
									</td>
									<td width="70%">
										<?php echo form_input($usb_headset_name); ?>
									</td>
								</tr>
								<tr>
									<td width="30%">
										Other Name:
									</td>
									<td width="70%">
										<?php echo form_input($usb_headset_other_name); ?>
									</td>
								</tr>
								<tr>
									<td width="30%">
										Serial Number:
									</td>
									<td width="70%">
										<?php echo form_input($usb_headset_sn); ?>
									</td>
								</tr>
								<tr>
									<td width="30%">
										Date Purchased:
									</td>
									<td width="70%">
										<?php echo form_input($usb_headset_date_purchased); ?>
									</td>
								</tr>
								<tr>
									<td width="30%">
										Notes:
									</td>
									<td width="70%">
										<?php echo form_textarea($usb_headset_notes); ?>
									</td>
								</tr>
								<tr>
									<td>
										
									</td>
									<td>
										<?php echo form_submit($submit); ?>
									</td>
								</tr>
								<tr>
									<td></td>
									<td><?php echo validation_errors(); ?>
									</td>
								</tr>
							 </table>
							</form>
						</div>
					</div>