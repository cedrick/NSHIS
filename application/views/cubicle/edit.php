					<?php 
						
						echo form_open(base_url() . 'cubicle/edit/' . $this->uri->segment(3));
						
						$row = $data->row();
						
						$cubicle_name = array(
							'name'	=>	'cubicle_name',
							'id'	=>	'cubicle_name',
							'readonly' => true,
							'value'	=>	$row->name
						);
						
						$submit = array(
							'name'	=>	'submit',
							'value'	=>	'Submit'
						);
											
					?>
					
					<div class="section width400" >
						<div class="sectionHeader">Edit Cubicle</div>
						<div class="sectionBody">
							<form action="" method="get">
							 <table width="100%" border="0" cellpadding="10">
							 	<tr>
									<td width="30%">
										Name:
									</td>
									<td width="70%">
										<?php echo form_input($cubicle_name); ?>
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