					<?php 

						echo form_open(base_url() . 'ups/assign/' . $this->uri->segment(3));
						
						if ($data)
						{
							$ups_options = array();
							foreach ($data->result() as $row)
							{
								$array2 = array($row->ups_id => $row->name);
								$ups_options = $ups_options + $array2;
							}
						}
						
						$cub_info = $cubicle->row();
						
						$ups_location = array(
							'name'	=>	'ups_location',
							'id'	=>	'ups_location',
							'disabled' =>	true,
							'value'	=>	$cub_info->name
						);
						
						$submit = array(
							'name'	=>	'submit',
							'value'	=>	'Submit'
						);
											
					?>
					
					<div class="section width400" >
						<div class="sectionHeader">Assign Ups</div>
						<div class="sectionBody">
						<?php 
							if(!isset($ups_options))
							{
								echo "No available upss. You can add ".anchor('ups/add','HERE');
							} 
							else 
							{
						?>
							<form action="" method="get">
							 <table width="100%" border="0" cellpadding="10">
							 	<tr>
									<td width="30%">
										Ups:
									</td>
									<td width="70%">
										<?php
											echo form_dropdown('ups_id', $ups_options); 
										?>
									</td>
								</tr>
								<tr>
									<td width="30%">
										Cubicle:
									</td>
									<td width="70%">
										<?php echo form_input($ups_location); ?>
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