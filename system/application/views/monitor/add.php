					<?php 

						echo form_open(base_url() . 'monitor/add');
						
						$monitor_name = array(
							'name'	=>	'monitor_name',
							'id'	=>	'monitor_name',
							'value'	=>	set_value('monitor_name')
						);
						
						$monitor_other_name = array(
							'name'	=>	'monitor_other_name',
							'id'	=>	'monitor_other_name',
							'value'	=>	set_value('monitor_other_name')
						);
						
						$monitor_sn = array(
							'name'	=>	'monitor_sn',
							'id'	=>	'monitor_sn',
							'value'	=>	set_value('monitor_sn')
						);
						
						$monitor_date_purchased = array(
							'name'	=>	'monitor_date_purchased',
							'id'	=>	'monitor_date_purchased',
							'value'	=>	set_value('monitor_date_purchased'),
							'onclick' => "fPopCalendar('monitor_date_purchased')"
						);
						
						$monitor_notes = array(
							'name'	=>	'monitor_notes',
							'id'	=>	'monitor_notes',
							'rows'	=>	'4',
							'cols'	=>	'30',
							'value'	=>	set_value('monitor_notes')
						);
						
						$submit = array(
							'name'	=>	'submit',
							'value'	=>	'Submit'
						);
											
					?>
					
					<div class="section width500" >
						<div class="sectionHeader">Add New Monitor</div>
						<div class="sectionBody">
							<form action="" method="get">
							 <table width="100%" border="0" cellpadding="10">
							 	<tr>
									<td width="30%">
										Name:
									</td>
									<td width="70%">
										<?php echo form_input($monitor_name); ?>
									</td>
								</tr>
								<tr>
									<td width="30%">
										Other Name:
									</td>
									<td width="70%">
										<?php echo form_input($monitor_other_name); ?>
									</td>
								</tr>
								<tr>
									<td width="30%">
										Serial Number:
									</td>
									<td width="70%">
										<?php echo form_input($monitor_sn); ?>
									</td>
								</tr>
								<tr>
									<td width="30%">
										Date Purchased:
									</td>
									<td width="70%">
										<?php echo form_input($monitor_date_purchased); ?>
									</td>
								</tr>
								<tr>
									<td width="30%">
										Notes:
									</td>
									<td width="70%">
										<?php echo form_textarea($monitor_notes); ?>
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