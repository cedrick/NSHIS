					<?php 
						
						echo form_open(base_url() . 'usb_headset/unassign/' . $this->uri->segment(3));
						
						$row = $data->row();
						
						$yes = array(
							'name'	=>	'unassign',
							'id'	=>	'unassign',
							'value'	=>	'yes'
						);
						
						$no = array(
							'name'	=>	'unassign',
							'id'	=>	'unassign',
						 	'checked' => TRUE,
							'value'	=>	'no'
						);
						
						$submit = array(
							'name'	=>	'submit',
							'value'	=>	'Submit'
						);
											
					?>
					
					<div class="section width400" >
						<div class="sectionHeader">Unassign <?php echo $row->usb_headset_name; ?>?</div>
						<div class="sectionBody">
							<form action="" method="get">
							 <table width="100%" border="0" cellpadding="10">
							 	
							 	<tr>
									<td width="30%">
										Yes
									</td>
									<td width="70%">
										<?php echo form_radio($yes); ?>
									</td>
								</tr>
								<tr>
									<td width="30%">
										No
									</td>
									<td width="70%">
										<?php echo form_radio($no); ?>
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