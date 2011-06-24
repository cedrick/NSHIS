					<?php 
						
						echo form_open(base_url() . 'cpu/edit/' . $this->uri->segment(3));
						
						$row_data = $data['info']->row();
						
						$cpu_name = array(
							'name'	=>	'cpu_name',
							'id'	=>	'cpu_name',
							'readonly' => true,
							'value'	=>	$row_data->cpu_name
						);
						
						$cpu_other_name = array(
							'name'	=>	'cpu_other_name',
							'id'	=>	'cpu_other_name',
							'value'	=>	$row_data->other_name
						);
						
						$cpu_sn = array(
							'name'	=>	'cpu_sn',
							'id'	=>	'cpu_sn',
							'value'	=>	$row_data->serial_number
						);
						
						$cpu_date_purchased = array(
							'name'	=>	'cpu_date_purchased',
							'id'	=>	'cpu_date_purchased',
							'value'	=>	$row_data->date_purchased,
							'onclick' => "fPopCalendar('cpu_date_purchased')"
						);
						
						$cpu_hostname = array(
							'name'	=>	'cpu_hostname',
							'id'	=>	'cpu_hostname',
							'value'	=>	$row_data->hostname
						);
						
						if ($data['processor'])
						{
							$cpu_processor = array('' => '');
							$processor_ans = NULL;
							foreach ($data['processor']->result() as $row)
							{
								if ($row_data->processor_id == $row->processor_id)
								{
									$processor_ans = $row->processor_id;
								}
								$array2 = array($row->processor_id => $row->processor_name);
								$cpu_processor = $cpu_processor + $array2;
							}
						}
						
						if ($data['hd'])
						{
							$cpu_hd = array('' => '');
							$hd1_ans = NULL;
							$hd2_ans = NULL;
							
							foreach ($data['hd']->result() as $row)
							{
								if ($row_data->hd1_id == $row->hd_id)
								{
									$hd1_ans = $row->hd_id;
								}
								if ($row_data->hd2_id == $row->hd_id)
								{
									$hd2_ans = $row->hd_id;
								}
								$array2 = array($row->hd_id => $row->hd_name);
								$cpu_hd = $cpu_hd + $array2;
							}
						}
						
						if ($data['hd_types'])
						{
							$cpu_hd_type = array('' => '');
							$hd1_type_ans = NULL;
							$hd2_type_ans = NULL;
							foreach ($data['hd_types']->result() as $row)
							{
								if ($row_data->hd1_type_id == $row->hd_type_id)
								{
									$hd1_type_ans = $row->hd_type_id;
								}
								if ($row_data->hd2_type_id == $row->hd_type_id)
								{
									$hd2_type_ans = $row->hd_type_id;
								}
								$array2 = array($row->hd_type_id => $row->name_type);
								$cpu_hd_type = $cpu_hd_type + $array2;
							}
						}
						
						if ($data['memory'])
						{
							$cpu_memory = array('' => '');
							$memory1_ans = NULL;
							$memory2_ans = NULL;
							foreach ($data['memory']->result() as $row)
							{
								if ($row_data->memory1_id == $row->memory_id)
								{
									$memory1_ans = $row->memory_id;
								}
								if ($row_data->memory2_id == $row->memory_id)
								{
									$memory2_ans = $row->memory_id;
								}
								$array2 = array($row->memory_id => $row->memory_name);
								$cpu_memory = $cpu_memory + $array2;
							}
						}
						
						if ($data['memory_types'])
						{
							$cpu_memory_type = array('' => '');
							$memory1_type_ans = NULL;
							$memory2_type_ans = NULL;
							foreach ($data['memory_types']->result() as $row)
							{
								if ($row_data->memory1_type_id == $row->memory_type_id)
								{
									$memory1_type_ans = $row->memory_type_id;
								}
								if ($row_data->memory2_type_id == $row->memory_type_id)
								{
									$memory2_type_ans = $row->memory_type_id;
								}
								$array2 = array($row->memory_type_id => $row->name_type);
								$cpu_memory_type = $cpu_memory_type + $array2;
							}
						}
						
						$cpu_notes = array(
							'name'	=>	'cpu_notes',
							'id'	=>	'cpu_notes',
							'rows'	=>	'4',
							'cols'	=>	'30',
							'value'	=>	$row_data->notes
						);
						
						$submit = array(
							'name'	=>	'submit',
							'value'	=>	'Submit'
						);
											
					?>
					
					<div class="section width500" >
						<div class="sectionHeader">Edit CPU</div>
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
										<?php echo form_dropdown('cpu_processor', $cpu_processor, $processor_ans); ?>
									</td>
								</tr>
								<tr>
									<td width="30%">
										Memory 1:
									</td>
									<td width="70%">
										<?php echo form_dropdown('cpu_memory1', $cpu_memory, $memory1_ans); ?> <?php echo form_dropdown('cpu_memory1_type', $cpu_memory_type, $memory1_type_ans); ?>
									</td>
								</tr>
								<tr>
									<td width="30%">
										Memory 2:
									</td>
									<td width="70%">
										<?php echo form_dropdown('cpu_memory2', $cpu_memory, $memory2_ans); ?> <?php echo form_dropdown('cpu_memory2_type', $cpu_memory_type, $memory2_type_ans); ?>									</td>
								</tr>
								<tr>
									<td width="30%">
										Hard Disk 1:
									</td>
									<td width="70%">
										<?php echo form_dropdown('cpu_hd1', $cpu_hd, $hd1_ans); ?> <?php echo form_dropdown('cpu_hd1_type', $cpu_hd_type, $hd1_type_ans); ?>
									</td>
								</tr>
								<tr>
									<td width="30%">
										Hard Disk 2:
									</td>
									<td width="70%">
										<?php echo form_dropdown('cpu_hd2', $cpu_hd, $hd2_ans); ?> <?php echo form_dropdown('cpu_hd2_type', $cpu_hd_type, $hd2_type_ans); ?>
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