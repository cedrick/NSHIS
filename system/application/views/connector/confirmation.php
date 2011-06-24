					<?php 

						echo form_open(base_url() . 'connector/add');
						
						$connector_name = array(
							'name'	=>	'connector_name',
							'id'	=>	'connector_name',
							'value'	=>	set_value('connector_name')
						);
						
						$connector_sn = array(
							'name'	=>	'connector_sn',
							'id'	=>	'connector_sn',
							'value'	=>	set_value('connector_sn')
						);
						
						if(isset($name))
						{
							$location = $name;
						}
						else 
						{
							$location = set_value('connector_location');
						}
						
						$connector_location = array(
							'name'	=>	'connector_location',
							'id'	=>	'connector_location',
							'value'	=>	$location
						);
						
						$submit = array(
							'name'	=>	'submit',
							'value'	=>	'Submit'
						);
											
					?>
					
					<div class="section width500" >
						<div class="sectionHeader">Connector Replace Confirmation</div>
						<div class="sectionBody">
							<p>There's already a connector assign for this cubicle. Do you want to replace it with this new one?</p>
						</div>
					</div>