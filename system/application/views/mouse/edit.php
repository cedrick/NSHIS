					<?php 
						
						echo form_open(base_url() . 'mouse/edit/' . $this->uri->segment(3));
						
						$row = $data->row();
						
						$mouse_name = array(
							'name'	=>	'mouse_name',
							'id'	=>	'mouse_name',
							'readonly' =>	true,
							'value'	=>	$row->mouse_name
						);
						
						$mouse_other_name = array(
							'name'	=>	'mouse_other_name',
							'id'	=>	'mouse_other_name',
							'value'	=>	$row->other_name
						);
						
						$mouse_sn = array(
							'name'	=>	'mouse_sn',
							'id'	=>	'mouse_sn',
							'value'	=>	$row->serial_number
						);
						
						$mouse_date_purchased = array(
							'name'	=>	'mouse_date_purchased',
							'id'	=>	'mouse_date_purchased',
							'value'	=>	$row->date_purchased,
							'onclick' => "fPopCalendar('mouse_date_purchased')"
						);
						
						$mouse_notes = array(
							'name'	=>	'mouse_notes',
							'id'	=>	'mouse_notes',
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
						<div class="sectionHeader">Edit Mouse</div>
						<div class="sectionBody">
							<form action="" method="get">
							 <table width="100%" border="0" cellpadding="10">
							 	<tr>
									<td width="30%">
										Name:
									</td>
									<td width="70%">
										<?php echo form_input($mouse_name); ?>
									</td>
								</tr>
								<tr>
									<td width="30%">
										Other Name:
									</td>
									<td width="70%">
										<?php echo form_input($mouse_other_name); ?>
									</td>
								</tr>
								<tr>
									<td width="30%">
										Serial Number:
									</td>
									<td width="70%">
										<?php echo form_input($mouse_sn); ?>
									</td>
								</tr>
								<tr>
									<td width="30%">
										Date Purchased:
									</td>
									<td width="70%">
										<?php echo form_input($mouse_date_purchased); ?>
									</td>
								</tr>
								<tr>
									<td width="30%">
										Notes:
									</td>
									<td width="70%">
										<?php echo form_textarea($mouse_notes); ?>
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