					<?php 

						echo form_open(base_url() . 'usb_headset/assign/' . $this->uri->segment(3));
						
						$row = $data['headsets']->row();
            
			            $usb_headset_name = array(
			              'name'  =>  'usb_headset_name',
			              'id'  =>  'usb_headset_name',
			              'readonly' => true,
			              'value' =>  $row->usb_headset_name
			            );
			            
			            $usb_headset_assignto = array(
			              'name'  =>  'usb_headset_assignto',
			              'id'  =>  'usb_headset_assignto',
			              'value' =>  $row->assigned_person
			            );
						
						$submit = array(
							'name'	=>	'submit',
							'value'	=>	'Submit'
						);
						
						$person = array('' => '');
						foreach ($data['people']->result() as $row)
						{
							$array = array($row->id => $row->first_name.' '.$row->last_name);
							$person = $person + $array;
						}
											
					?>
					
					<div class="section width400" >
						<div class="sectionHeader">Assign Usb_headset</div>
						<div class="sectionBody">
							<form action="" method="get">
							 <table width="100%" border="0" cellpadding="10">
							 	<tr>
									<td width="30%">
										Usb_headset:
									</td>
									<td width="70%">
										<?php
											echo form_input($usb_headset_name); 
										?>
									</td>
								</tr>
								<tr>
									<td width="30%">
										Assign To:
									</td>
									<td width="70%">
										<?php echo form_dropdown('assign', $person, NULL, 'id = "combobox"'); ?>
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
						</div>
					</div>