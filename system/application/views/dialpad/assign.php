					<?php 

						echo form_open(base_url() . 'dialpad/assign/' . $this->uri->segment(3));
						
						if ($data)
						{
							$dialpad_options = array();
							foreach ($data->result() as $row)
							{
								$array2 = array($row->dialpad_id => $row->name);
								$dialpad_options = $dialpad_options + $array2;
							}
						}
						
						$cub_info = $cubicle->row();
						
						$dialpad_location = array(
							'name'	=>	'dialpad_location',
							'id'	=>	'dialpad_location',
							'disabled' =>	true,
							'value'	=>	$cub_info->name
						);
						
						$submit = array(
							'name'	=>	'submit',
							'value'	=>	'Submit'
						);
											
					?>
					
					<div class="section width400" >
						<div class="sectionHeader">Assign Dialpad</div>
						<div class="sectionBody">
						<?php 
							if(!isset($dialpad_options))
							{
								echo "No available dialpads. You can add ".anchor('dialpad/add','HERE');
							} 
							else 
							{
						?>
							<form action="" method="get">
							 <table width="100%" border="0" cellpadding="10">
							 	<tr>
									<td width="30%">
										Dialpad:
									</td>
									<td width="70%">
										<?php
											echo form_dropdown('dialpad_id', $dialpad_options); 
										?>
									</td>
								</tr>
								<tr>
									<td width="30%">
										Cubicle:
									</td>
									<td width="70%">
										<?php echo form_input($dialpad_location); ?>
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
						<?php 		
							}
						
						?>
						
							
						</div>
					</div>