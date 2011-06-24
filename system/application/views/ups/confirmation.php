					<?php 

						echo form_open(base_url() . 'ups/add');
						
						$ups_name = array(
							'name'	=>	'ups_name',
							'id'	=>	'ups_name',
							'value'	=>	set_value('ups_name')
						);
						
						$ups_sn = array(
							'name'	=>	'ups_sn',
							'id'	=>	'ups_sn',
							'value'	=>	set_value('ups_sn')
						);
						
						if(isset($name))
						{
							$location = $name;
						}
						else 
						{
							$location = set_value('ups_location');
						}
						
						$ups_location = array(
							'name'	=>	'ups_location',
							'id'	=>	'ups_location',
							'value'	=>	$location
						);
						
						$submit = array(
							'name'	=>	'submit',
							'value'	=>	'Submit'
						);
											
					?>
					
					<div class="section width500" >
						<div class="sectionHeader">Ups Replace Confirmation</div>
						<div class="sectionBody">
							<p>There's already a ups assign for this cubicle. Do you want to replace it with this new one?</p>
						</div>
					</div>