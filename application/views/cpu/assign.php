					<?php 

						echo form_open(base_url() . 'cpu/assign/' . $this->uri->segment(3));
						
						if ($data)
						{
							$cpu_options = array('' => '');
							foreach ($data->result() as $row)
							{
								$array2 = array($row->cpu_id => $row->name);
								$cpu_options = $cpu_options + $array2;
							}
						}
						
						$cub_info = $cubicle->row();
						
						$cpu_location = array(
							'name'	=>	'cpu_location',
							'id'	=>	'cpu_location',
							'disabled' =>	true,
							'value'	=>	$cub_info->name
						);
						
						$submit = array(
							'name'	=>	'submit',
							'value'	=>	'Submit'
						);
											
					?>
					
					<div class="section width400" >
						<div class="sectionHeader">Assign CPU</div>
						<div class="sectionBody">
						<?php 
							if(!isset($cpu_options))
							{
								echo "No available cpus. You can add ".anchor('cpu/add','HERE');
							} 
							else 
							{
						?>
							<form action="" method="get">
							 <table width="100%" border="0" cellpadding="10">
							 	<tr>
									<td width="30%">
										CPU:
									</td>
									<td width="70%">
										<?php
											echo form_dropdown('cpu_id', $cpu_options, NULL , 'id="combobox"'); 
										?>
									</td>
								</tr>
								<tr>
									<td width="30%">
										Cubicle:
									</td>
									<td width="70%">
										<?php echo form_input($cpu_location); ?>
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