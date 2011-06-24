					<?php 

						echo form_open(base_url() . 'keyboard/add');
						
						$keyboard_name = array(
							'name'	=>	'keyboard_name',
							'id'	=>	'keyboard_name',
							'value'	=>	set_value('keyboard_name')
						);
						
						$keyboard_sn = array(
							'name'	=>	'keyboard_sn',
							'id'	=>	'keyboard_sn',
							'value'	=>	set_value('keyboard_sn')
						);
						
						if(isset($name))
						{
							$location = $name;
						}
						else 
						{
							$location = set_value('keyboard_location');
						}
						
						$keyboard_location = array(
							'name'	=>	'keyboard_location',
							'id'	=>	'keyboard_location',
							'value'	=>	$location
						);
						
						$submit = array(
							'name'	=>	'submit',
							'value'	=>	'Submit'
						);
											
					?>
					
					<div class="section width500" >
						<div class="sectionHeader">Keyboard Replace Confirmation</div>
						<div class="sectionBody">
							<p>There's already a keyboard assign for this cubicle. Do you want to replace it with this new one?</p>
						</div>
					</div>