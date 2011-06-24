					<?php 

						echo form_open(base_url() . 'monitor/add');
						
						$monitor_name = array(
							'name'	=>	'monitor_name',
							'id'	=>	'monitor_name',
							'value'	=>	set_value('monitor_name')
						);
						
						$monitor_sn = array(
							'name'	=>	'monitor_sn',
							'id'	=>	'monitor_sn',
							'value'	=>	set_value('monitor_sn')
						);
						
						if(isset($name))
						{
							$location = $name;
						}
						else 
						{
							$location = set_value('monitor_location');
						}
						
						$monitor_location = array(
							'name'	=>	'monitor_location',
							'id'	=>	'monitor_location',
							'value'	=>	$location
						);
						
						$submit = array(
							'name'	=>	'submit',
							'value'	=>	'Submit'
						);
											
					?>
					
					<div class="section width500" >
						<div class="sectionHeader">Monitor Replace Confirmation</div>
						<div class="sectionBody">
							<p>There's already a monitor assign for this cubicle. Do you want to replace it with this new one?</p>
						</div>
					</div>