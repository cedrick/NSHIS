					<?php 

						echo form_open(base_url() . 'dialpad/add');
						
						$dialpad_name = array(
							'name'	=>	'dialpad_name',
							'id'	=>	'dialpad_name',
							'value'	=>	set_value('dialpad_name')
						);
						
						$dialpad_other_name = array(
							'name'	=>	'dialpad_other_name',
							'id'	=>	'dialpad_other_name',
							'value'	=>	set_value('dialpad_other_name')
						);
						
						$dialpad_sn = array(
							'name'	=>	'dialpad_sn',
							'id'	=>	'dialpad_sn',
							'value'	=>	set_value('dialpad_sn')
						);
						
						$dialpad_date_purchased = array(
							'name'	=>	'dialpad_date_purchased',
							'id'	=>	'dialpad_date_purchased',
							'value'	=>	set_value('dialpad_date_purchased'),
							'onclick' => "fPopCalendar('dialpad_date_purchased')"
						);
						
						$dialpad_notes = array(
							'name'	=>	'dialpad_notes',
							'id'	=>	'dialpad_notes',
							'rows'	=>	'4',
							'cols'	=>	'30',
							'value'	=>	set_value('dialpad_notes')
						);
						
						$submit = array(
							'name'	=>	'submit',
							'value'	=>	'Submit'
						);
											
					?>
					
					<div class="section width500" >
						<div class="sectionHeader">Add New Dialpad</div>
						<div class="sectionBody">
							<form action="" method="get">
							 <table width="100%" border="0" cellpadding="10">
							 	<tr>
									<td width="30%">
										Name:
									</td>
									<td width="70%">
										<?php echo form_input($dialpad_name); ?>
									</td>
								</tr>
								<tr>
									<td width="30%">
										Other Name:
									</td>
									<td width="70%">
										<?php echo form_input($dialpad_other_name); ?>
									</td>
								</tr>
								<tr>
									<td width="30%">
										Serial Number:
									</td>
									<td width="70%">
										<?php echo form_input($dialpad_sn); ?>
									</td>
								</tr>
								<tr>
									<td width="30%">
										Date Purchased:
									</td>
									<td width="70%">
										<?php echo form_input($dialpad_date_purchased); ?>
									</td>
								</tr>
								<tr>
									<td width="30%">
										Notes:
									</td>
									<td width="70%">
										<?php echo form_textarea($dialpad_notes); ?>
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