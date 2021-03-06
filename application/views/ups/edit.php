					<?php if($data): ?>
					<?php 
						echo form_open(base_url() . 'ups/edit/' . $this->uri->segment(3));
						
						$row = $data->row();
						
						$ups_name = array(
							'name'	=>	'ups_name',
							'id'	=>	'ups_name',
							'readonly' =>	true,
							'value'	=>	$row->ups_name
						);
						
						$ups_other_name = array(
							'name'	=>	'ups_other_name',
							'id'	=>	'ups_other_name',
							'value'	=>	$row->other_name
						);
						
						$ups_sn = array(
							'name'	=>	'ups_sn',
							'id'	=>	'ups_sn',
							'value'	=>	$row->serial_number
						);
						
						$ups_date_purchased = array(
							'name'	=>	'ups_date_purchased',
							'id'	=>	'ups_date_purchased',
							'value'	=>	$row->date_purchased,
							'onclick' => "fPopCalendar('ups_date_purchased')"
						);
						
						$ups_notes = array(
							'name'	=>	'ups_notes',
							'id'	=>	'ups_notes',
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
						<div class="sectionHeader">Edit Ups</div>
						<div class="sectionBody">
							<form action="" method="get">
							 <table width="100%" border="0" cellpadding="10">
							 	<tr>
									<td width="30%">
										Name:
									</td>
									<td width="70%">
										<?php echo form_input($ups_name); ?>
									</td>
								</tr>
								<tr>
									<td width="30%">
										Other Name:
									</td>
									<td width="70%">
										<?php echo form_input($ups_other_name); ?>
									</td>
								</tr>
								<tr>
									<td width="30%">
										Serial Number:
									</td>
									<td width="70%">
										<?php echo form_input($ups_sn); ?>
									</td>
								</tr>
								<tr>
									<td width="30%">
										Date Purchased:
									</td>
									<td width="70%">
										<?php echo form_input($ups_date_purchased); ?>
									</td>
								</tr>
								<tr>
									<td width="30%">
										Notes:
									</td>
									<td width="70%">
										<?php echo form_textarea($ups_notes); ?>
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
					<?php else: ?>
					<div class="section width500" >
						<div class="sectionHeader">Item Info</div>
						<div class="sectionBody">
							Item dont exist.
						</div>
					</div>
					<?php endif; ?>