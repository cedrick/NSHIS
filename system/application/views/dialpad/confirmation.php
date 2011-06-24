					<?php 

						echo form_open(base_url() . 'dialpad/add');
						
						$dialpad_name = array(
							'name'	=>	'dialpad_name',
							'id'	=>	'dialpad_name',
							'value'	=>	set_value('dialpad_name')
						);
						
						$dialpad_sn = array(
							'name'	=>	'dialpad_sn',
							'id'	=>	'dialpad_sn',
							'value'	=>	set_value('dialpad_sn')
						);
						
						if(isset($name))
						{
							$location = $name;
						}
						else 
						{
							$location = set_value('dialpad_location');
						}
						
						$dialpad_location = array(
							'name'	=>	'dialpad_location',
							'id'	=>	'dialpad_location',
							'value'	=>	$location
						);
						
						$submit = array(
							'name'	=>	'submit',
							'value'	=>	'Submit'
						);
											
					?>
					
					<div class="section width500" >
						<div class="sectionHeader">Dialpad Replace Confirmation</div>
						<div class="sectionBody">
							<p>There's already a dialpad assign for this cubicle. Do you want to replace it with this new one?</p>
						</div>
					</div>