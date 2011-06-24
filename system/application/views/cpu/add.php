					<?php 

						echo form_open(base_url() . 'cpu/add');
						
						$cpu_name = array(
							'name'	=>	'cpu_name',
							'id'	=>	'cpu_name',
							'value'	=>	set_value('cpu_name')
						);
						
						$cpu_other_name = array(
							'name'	=>	'cpu_other_name',
							'id'	=>	'cpu_other_name',
							'value'	=>	set_value('cpu_other_name')
						);
						
						$cpu_sn = array(
							'name'	=>	'cpu_sn',
							'id'	=>	'cpu_sn',
							'value'	=>	set_value('cpu_sn')
						);
						
						$cpu_date_purchased = array(
							'name'	=>	'cpu_date_purchased',
							'id'	=>	'cpu_date_purchased',
							'value'	=>	set_value('cpu_date_purchased'),
							'onclick' => "fPopCalendar('cpu_date_purchased')"
						);
						
						$cpu_hostname = array(
							'name'	=>	'cpu_hostname',
							'id'	=>	'cpu_hostname',
							'value'	=>	set_value('cpu_hostname')
						);
						
						if ($data['processor'])
						{
							$cpu_processor = array('' => '');
							foreach ($data['processor']->result() as $row)
							{
								$array2 = array($row->processor_id => $row->processor_name);
								$cpu_processor = $cpu_processor + $array2;
							}
						}
						
						if ($data['hd'])
						{
							$cpu_hd = array('' => '');
							foreach ($data['hd']->result() as $row)
							{
								$array2 = array($row->hd_id => $row->hd_name);
								$cpu_hd = $cpu_hd + $array2;
							}
						}
						
						if ($data['hd_types'])
						{
							$cpu_hd_type = array('' => '');
							foreach ($data['hd_types']->result() as $row)
							{
								$array2 = array($row->hd_type_id => $row->name_type);
								$cpu_hd_type = $cpu_hd_type + $array2;
							}
						}
						
						if ($data['memory'])
						{
							$cpu_memory = array('' => '');
							foreach ($data['memory']->result() as $row)
							{
								$array2 = array($row->memory_id => $row->memory_name);
								$cpu_memory = $cpu_memory + $array2;
							}
						}
						
						if ($data['memory_types'])
						{
							$cpu_memory_type = array('' => '');
							foreach ($data['memory_types']->result() as $row)
							{
								$array2 = array($row->memory_type_id => $row->name_type);
								$cpu_memory_type = $cpu_memory_type + $array2;
							}
						}
						
						$cpu_notes = array(
							'name'	=>	'cpu_notes',
							'id'	=>	'cpu_notes',
							'rows'	=>	'4',
							'cols'	=>	'30',
							'value'	=>	set_value('cpu_notes')
						);
						
						$submit = array(
							'name'	=>	'submit',
							'value'	=>	'Submit'
						);
											
					?>
					
					<div class="section width500" >
						<div class="sectionHeader">Add New CPU</div>
						<div class="sectionBody">
							<form action="" method="get">
							 <table width="100%" border="0" cellpadding="10">
							 	<tr>
									<td width="30%">
										Name:
									</td>
									<td width="70%">
										<?php echo form_input($cpu_name); ?>
									</td>
								</tr>
								<tr>
									<td width="30%">
										Other Name:
									</td>
									<td width="70%">
										<?php echo form_input($cpu_other_name); ?>
									</td>
								</tr>
								<tr>
									<td width="30%">
										Serial Number:
									</td>
									<td width="70%">
										<?php echo form_input($cpu_sn); ?>
									</td>
								</tr>
								<tr>
									<td width="30%">
										Date Purchased:
									</td>
									<td width="70%">
										<?php echo form_input($cpu_date_purchased); ?>
									</td>
								</tr>
								<tr>
									<td width="30%">
										Hostname:
									</td>
									<td width="70%">
										<?php echo form_input($cpu_hostname); ?>
									</td>
								</tr>
								<tr>
									<td width="30%">
										Processor:
									</td>
									<td width="70%">
										<?php echo form_dropdown('cpu_processor', $cpu_processor); ?>
									</td>
								</tr>
								<tr>
									<td width="30%">
										Memory 1:
									</td>
									<td width="70%">
										<?php echo form_dropdown('cpu_memory1', $cpu_memory); ?> <?php echo form_dropdown('cpu_memory1_type', $cpu_memory_type); ?>
									</td>
								</tr>
								<tr>
									<td width="30%">
										Memory 2:
									</td>
									<td width="70%">
										<?php echo form_dropdown('cpu_memory2', $cpu_memory); ?> <?php echo form_dropdown('cpu_memory2_type', $cpu_memory_type); ?>
									</td>
								</tr>
								<tr>
									<td width="30%">
										Hard Disk 1:
									</td>
									<td width="70%">
										<?php echo form_dropdown('cpu_hd1', $cpu_hd); ?> <?php echo form_dropdown('cpu_hd1_type', $cpu_hd_type); ?>
									</td>
								</tr>
								<tr>
									<td width="30%">
										Hard Disk 2:
									</td>
									<td width="70%">
										<?php echo form_dropdown('cpu_hd2', $cpu_hd); ?> <?php echo form_dropdown('cpu_hd2_type', $cpu_hd_type); ?>
									</td>
								</tr>
								<tr>
									<td width="30%">
										Notes:
									</td>
									<td width="70%">
										<?php echo form_textarea($cpu_notes); ?>
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