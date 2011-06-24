					<?php 

						echo form_open(base_url() . 'cpu/add');
						
						$cpu_name = array(
							'name'	=>	'cpu_name',
							'id'	=>	'cpu_name',
							'value'	=>	set_value('cpu_name')
						);
						
						$cpu_sn = array(
							'name'	=>	'cpu_sn',
							'id'	=>	'cpu_sn',
							'value'	=>	set_value('cpu_sn')
						);
						
						if(isset($name))
						{
							$location = $name;
						}
						else 
						{
							$location = set_value('cpu_location');
						}
						
						$cpu_location = array(
							'name'	=>	'cpu_location',
							'id'	=>	'cpu_location',
							'value'	=>	$location
						);
						
						$submit = array(
							'name'	=>	'submit',
							'value'	=>	'Submit'
						);
											
					?>
					
					<div class="section width500" >
						<div class="sectionHeader">CPU Replace Confirmation</div>
						<div class="sectionBody">
							<p>There's already a cpu assign for this cubicle. Do you want to replace it with this new one?</p>
						</div>
					</div>