					<?php 

						echo form_open(base_url() . 'headset/add');
						
						$headset_name = array(
							'name'	=>	'headset_name',
							'id'	=>	'headset_name',
							'value'	=>	set_value('headset_name')
						);
						
						$headset_other_name = array(
							'name'	=>	'headset_other_name',
							'id'	=>	'headset_other_name',
							'value'	=>	set_value('headset_other_name')
						);
						
						$headset_sn = array(
							'name'	=>	'headset_sn',
							'id'	=>	'headset_sn',
							'value'	=>	set_value('headset_sn')
						);
						
						$headset_date_purchased = array(
							'name'	=>	'headset_date_purchased',
							'id'	=>	'headset_date_purchased',
							'value'	=>	set_value('headset_date_purchased'),
							'onclick' => "fPopCalendar('headset_date_purchased')"
						);
						
						$headset_notes = array(
							'name'	=>	'headset_notes',
							'id'	=>	'headset_notes',
							'rows'	=>	'4',
							'cols'	=>	'30',
							'value'	=>	set_value('headset_notes')
						);
						
						$submit = array(
							'name'	=>	'submit',
							'value'	=>	'Submit'
						);
											
					?>
					
					<div class="section width500" >
						<div class="sectionHeader">Add New Headset</div>
						<div class="sectionBody">
							<form action="" method="get">
							 <table width="100%" border="0" cellpadding="10">
							 	<tr>
									<td width="30%">
										Name:
									</td>
									<td width="70%">
										<?php echo form_input($headset_name); ?>
									</td>
								</tr>
								<tr>
									<td width="30%">
										Other Name:
									</td>
									<td width="70%">
										<?php echo form_input($headset_other_name); ?>
									</td>
								</tr>
								<tr>
									<td width="30%">
										Serial Number:
									</td>
									<td width="70%">
										<?php echo form_input($headset_sn); ?>
									</td>
								</tr>
								<tr>
									<td width="30%">
										Date Purchased:
									</td>
									<td width="70%">
										<?php echo form_input($headset_date_purchased); ?>
									</td>
								</tr>
								<tr>
									<td width="30%">
										Notes:
									</td>
									<td width="70%">
										<?php echo form_textarea($headset_notes); ?>
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