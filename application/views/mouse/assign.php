					<?php 

						echo form_open(base_url() . 'mouse/assign/' . $this->uri->segment(3));
						
						if ($data)
						{
							$mouse_options = array();
							foreach ($data->result() as $row)
							{
								$array2 = array($row->mouse_id => $row->name);
								$mouse_options = $mouse_options + $array2;
							}
						}
						
						$cub_info = $cubicle->row();
						
						$mouse_location = array(
							'name'	=>	'mouse_location',
							'id'	=>	'mouse_location',
							'disabled' =>	true,
							'value'	=>	$cub_info->name
						);
						
						$submit = array(
							'name'	=>	'submit',
							'value'	=>	'Submit'
						);
											
					?>
					
					<div class="section width400" >
						<div class="sectionHeader">Assign Mouse</div>
						<div class="sectionBody">
						<?php 
							if(!isset($mouse_options))
							{
								echo "No available mouses. You can add ".anchor('mouse/add','HERE');
							} 
							else 
							{
						?>
							<form action="" method="get">
							 <table width="100%" border="0" cellpadding="10">
							 	<tr>
									<td width="30%">
										Mouse:
									</td>
									<td width="70%">
										<?php
											echo form_dropdown('mouse_id', $mouse_options); 
										?>
									</td>
								</tr>
								<tr>
									<td width="30%">
										Cubicle:
									</td>
									<td width="70%">
										<?php echo form_input($mouse_location); ?>
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