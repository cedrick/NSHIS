					<?php 

						echo form_open(base_url() . 'keyboard/assign/' . $this->uri->segment(3));
						
						if ($data)
						{
							$keyboard_options = array('' => '');
							foreach ($data->result() as $row)
							{
								$array2 = array($row->keyboard_id => $row->name);
								$keyboard_options = $keyboard_options + $array2;
							}
						}
						
						$cub_info = $cubicle->row();
						
						$keyboard_location = array(
							'name'	=>	'keyboard_location',
							'id'	=>	'keyboard_location',
							'disabled' =>	true,
							'value'	=>	$cub_info->name
						);
						
						$submit = array(
							'name'	=>	'submit',
							'value'	=>	'Submit'
						);
											
					?>
					
					<div class="section width400" >
						<div class="sectionHeader">Assign Keyboard</div>
						<div class="sectionBody">
						<?php 
							if(!isset($keyboard_options))
							{
								echo "No available keyboards. You can add ".anchor('keyboard/add','HERE');
							} 
							else 
							{
						?>
							<form action="" method="get">
							 <table width="100%" border="0" cellpadding="10">
							 	<tr>
									<td width="30%">
										Keyboard:
									</td>
									<td width="70%">
										<?php
											echo form_dropdown('keyboard_id', $keyboard_options, NULL , 'id="combobox"'); 
										?>
									</td>
								</tr>
								<tr>
									<td width="30%">
										Cubicle:
									</td>
									<td width="70%">
										<?php echo form_input($keyboard_location); ?>
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