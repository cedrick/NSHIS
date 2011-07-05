					<?php 

						echo form_open(base_url() . 'monitor/assign/' . $this->uri->segment(3));
						
						if ($data)
						{
							$monitor_options = array('' => '');
							foreach ($data->result() as $row)
							{
								$array2 = array($row->monitor_id => $row->name);
								$monitor_options = $monitor_options + $array2;
							}
						}
						
						$cub_info = $cubicle->row();
						
						$monitor_location = array(
							'name'	=>	'monitor_location',
							'id'	=>	'monitor_location',
							'disabled' =>	true,
							'value'	=>	$cub_info->name
						);
						
						$submit = array(
							'name'	=>	'submit',
							'value'	=>	'Submit'
						);
											
					?>
					<div class="section width400" >
						<div class="sectionHeader">Assign Monitor</div>
						<div class="sectionBody">
						<?php 
							if(!isset($monitor_options))
							{
								echo "No available monitors. You can add ".anchor('monitor/add','HERE');
							} 
							else 
							{
						?>
							<form action="" method="get">
							 <table width="100%" border="0" cellpadding="10">
							 	<tr>
									<td width="30%">
										Monitor:
									</td>
									<td width="70%">
										<?php
											echo form_dropdown('monitor_id', $monitor_options, NULL , 'id="combobox"'); 
										?>
									</td>
								</tr>
								<tr>
									<td width="30%">
										Cubicle:
									</td>
									<td width="70%">
										<?php echo form_input($monitor_location); ?>
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