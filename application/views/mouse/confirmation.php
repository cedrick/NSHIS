					<?php 

						echo form_open(base_url() . 'mouse/add');
						
						$mouse_name = array(
							'name'	=>	'mouse_name',
							'id'	=>	'mouse_name',
							'value'	=>	set_value('mouse_name')
						);
						
						$mouse_sn = array(
							'name'	=>	'mouse_sn',
							'id'	=>	'mouse_sn',
							'value'	=>	set_value('mouse_sn')
						);
						
						if(isset($name))
						{
							$location = $name;
						}
						else 
						{
							$location = set_value('mouse_location');
						}
						
						$mouse_location = array(
							'name'	=>	'mouse_location',
							'id'	=>	'mouse_location',
							'value'	=>	$location
						);
						
						$submit = array(
							'name'	=>	'submit',
							'value'	=>	'Submit'
						);
											
					?>
					
					<div class="section width500" >
						<div class="sectionHeader">Mouse Replace Confirmation</div>
						<div class="sectionBody">
							<p>There's already a mouse assign for this cubicle. Do you want to replace it with this new one?</p>
						</div>
					</div>