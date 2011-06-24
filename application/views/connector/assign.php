					<?php 

						echo form_open(base_url() . 'connector/assign/' . $this->uri->segment(3));
						
						if ($data)
						{
							$connector_options = array();
							foreach ($data->result() as $row)
							{
								$array2 = array($row->connector_id => $row->name);
								$connector_options = $connector_options + $array2;
							}
						}
						
						$cub_info = $cubicle->row();
						
						$connector_location = array(
							'name'	=>	'connector_location',
							'id'	=>	'connector_location',
							'disabled' =>	true,
							'value'	=>	$cub_info->name
						);
						
						$submit = array(
							'name'	=>	'submit',
							'value'	=>	'Submit'
						);
											
					?>
					
					<div class="section width400" >
						<div class="sectionHeader">Assign Connector</div>
						<div class="sectionBody">
						<?php 
							if(!isset($connector_options))
							{
								echo "No available connectors. You can add ".anchor('connector/add','HERE');
							} 
							else 
							{
						?>
							<form action="" method="get">
							 <table width="100%" border="0" cellpadding="10">
							 	<tr>
									<td width="30%">
										Connector:
									</td>
									<td width="70%">
										<?php
											echo form_dropdown('connector_id', $connector_options); 
										?>
									</td>
								</tr>
								<tr>
									<td width="30%">
										Cubicle:
									</td>
									<td width="70%">
										<?php echo form_input($connector_location); ?>
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