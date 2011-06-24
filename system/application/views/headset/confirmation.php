					<?php 

						echo form_open(base_url() . 'headset/add');
						
						$headset_name = array(
							'name'	=>	'headset_name',
							'id'	=>	'headset_name',
							'value'	=>	set_value('headset_name')
						);
						
						$headset_sn = array(
							'name'	=>	'headset_sn',
							'id'	=>	'headset_sn',
							'value'	=>	set_value('headset_sn')
						);
						
						if(isset($name))
						{
							$location = $name;
						}
						else 
						{
							$location = set_value('headset_location');
						}
						
						$headset_location = array(
							'name'	=>	'headset_location',
							'id'	=>	'headset_location',
							'value'	=>	$location
						);
						
						$submit = array(
							'name'	=>	'submit',
							'value'	=>	'Submit'
						);
											
					?>
					
					<div class="section width500" >
						<div class="sectionHeader">Headset Replace Confirmation</div>
						<div class="sectionBody">
							<p>There's already a headset assign for this cubicle. Do you want to replace it with this new one?</p>
						</div>
					</div>