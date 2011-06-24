					<?php 

						echo form_open(base_url() . 'headset/assign/' . $this->uri->segment(3));
						
						if ($data)
						{
							$headset_options = array();
							foreach ($data->result() as $row)
							{
								$array2 = array($row->headset_id => $row->name);
								$headset_options = $headset_options + $array2;
							}
						}
						
						$cub_info = $cubicle->row();
						
						$headset_location = array(
							'name'	=>	'headset_location',
							'id'	=>	'headset_location',
							'disabled' =>	true,
							'value'	=>	$cub_info->name
						);
						
						$submit = array(
							'name'	=>	'submit',
							'value'	=>	'Submit'
						);
											
					?>
					
					<div class="section width400" >
						<div class="sectionHeader">Assign Headset</div>
						<div class="sectionBody">
						<?php 
							if(!isset($headset_options))
							{
								echo "No available headsets. You can add ".anchor('headset/add','HERE');
							} 
							else 
							{
						?>
							<form action="" method="get">
							 <table width="100%" border="0" cellpadding="10">
							 	<tr>
									<td width="30%">
										Headset:
									</td>
									<td width="70%">
										<?php
											echo form_dropdown('headset_id', $headset_options); 
										?>
									</td>
								</tr>
								<tr>
									<td width="30%">
										Cubicle:
									</td>
									<td width="70%">
										<?php echo form_input($headset_location); ?>
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