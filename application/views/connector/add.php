					<?php 

						echo form_open(base_url() . 'connector/add');
						
						$connector_name = array(
							'name'	=>	'connector_name',
							'id'	=>	'connector_name',
							'value'	=>	set_value('connector_name')
						);
						
						$connector_other_name = array(
							'name'	=>	'connector_other_name',
							'id'	=>	'connector_other_name',
							'value'	=>	set_value('connector_other_name')
						);
						
						$connector_sn = array(
							'name'	=>	'connector_sn',
							'id'	=>	'connector_sn',
							'value'	=>	set_value('connector_sn')
						);
						
						$connector_date_purchased = array(
							'name'	=>	'connector_date_purchased',
							'id'	=>	'connector_date_purchased',
							'value'	=>	set_value('connector_date_purchased'),
							'onclick' => "fPopCalendar('connector_date_purchased')"
						);
						
						$connector_notes = array(
							'name'	=>	'connector_notes',
							'id'	=>	'connector_notes',
							'rows'	=>	'4',
							'cols'	=>	'30',
							'value'	=>	set_value('connector_notes')
						);
						
						$submit = array(
							'name'	=>	'submit',
							'value'	=>	'Submit'
						);
											
					?>
					
					<div class="section width500" >
						<div class="sectionHeader">Add New Connector</div>
						<div class="sectionBody">
							<form action="" method="get">
							 <table width="100%" border="0" cellpadding="10">
							 	<tr>
									<td width="30%">
										Name:
									</td>
									<td width="70%">
										<?php echo form_input($connector_name); ?>
									</td>
								</tr>
								<tr>
									<td width="30%">
										Other Name:
									</td>
									<td width="70%">
										<?php echo form_input($connector_other_name); ?>
									</td>
								</tr>
								<tr>
									<td width="30%">
										Serial Number:
									</td>
									<td width="70%">
										<?php echo form_input($connector_sn); ?>
									</td>
								</tr>
								<tr>
									<td width="30%">
										Date Purchased:
									</td>
									<td width="70%">
										<?php echo form_input($connector_date_purchased); ?>
									</td>
								</tr>
								<tr>
									<td width="30%">
										Notes:
									</td>
									<td width="70%">
										<?php echo form_textarea($connector_notes); ?>
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