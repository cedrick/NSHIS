					<?php 
						
						echo form_open(base_url() . 'keyboard/edit/' . $this->uri->segment(3));
						
						$row = $data->row();
						
						$keyboard_name = array(
							'name'	=>	'keyboard_name',
							'id'	=>	'keyboard_name',
							'readonly' =>	true,
							'value'	=>	$row->keyboard_name
						);
						
						$keyboard_other_name = array(
							'name'	=>	'keyboard_other_name',
							'id'	=>	'keyboard_other_name',
							'value'	=>	$row->other_name
						);
						
						$keyboard_sn = array(
							'name'	=>	'keyboard_sn',
							'id'	=>	'keyboard_sn',
							'value'	=>	$row->serial_number
						);
						
						$keyboard_date_purchased = array(
							'name'	=>	'keyboard_date_purchased',
							'id'	=>	'keyboard_date_purchased',
							'value'	=>	$row->date_purchased,
							'onclick' => "fPopCalendar('keyboard_date_purchased')"
						);
						
						$keyboard_notes = array(
							'name'	=>	'keyboard_notes',
							'id'	=>	'keyboard_notes',
							'rows'	=>	'4',
							'cols'	=>	'30',
							'value'	=>	$row->notes
						);
						
						$submit = array(
							'name'	=>	'submit',
							'value'	=>	'Submit'
						);
											
					?>
					
					<div class="section width500" >
						<div class="sectionHeader">Edit Keyboard</div>
						<div class="sectionBody">
							<form action="" method="get">
							 <table width="100%" border="0" cellpadding="10">
							 	<tr>
									<td width="30%">
										Name:
									</td>
									<td width="70%">
										<?php echo form_input($keyboard_name); ?>
									</td>
								</tr>
								<tr>
									<td width="30%">
										Other Name:
									</td>
									<td width="70%">
										<?php echo form_input($keyboard_other_name); ?>
									</td>
								</tr>
								<tr>
									<td width="30%">
										Serial Number:
									</td>
									<td width="70%">
										<?php echo form_input($keyboard_sn); ?>
									</td>
								</tr>
								<tr>
									<td width="30%">
										Date Purchased:
									</td>
									<td width="70%">
										<?php echo form_input($keyboard_date_purchased); ?>
									</td>
								</tr>
								<tr>
									<td width="30%">
										Notes:
									</td>
									<td width="70%">
										<?php echo form_textarea($keyboard_notes); ?>
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