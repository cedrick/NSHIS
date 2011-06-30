				<?php 
					if ($data)
					{
						$row = $data['info']->row();
				?>
					<div class="section width500" >
						<div class="sectionHeader">Usb_headset <?php echo $row->usb_headset_name;?> Info</div>
						<div class="sectionBody">
							<table width="100%" border="0" cellpadding="0" id="latestStatusTable" style="whitespace: nowrap;">
								<tr>
									<td id="resultName" width="30%">Usb_headset Name</td><td><?php echo $row->usb_headset_name; ?></td>
								</tr>
								<tr>
									<td id="resultName" width="30%">Other Name</td><td><?php echo $row->other_name; ?></td>
								</tr>
								<tr>
									<td id="resultName">Serial Number</td><td><?php echo $row->serial_number; ?></td>
								</tr>
								<tr>
									<td id="resultName">Date Purchased</td><td><?php echo $row->date_purchased;?></td>
								</tr>
								<tr>
                  <td id="resultName" width="30%">Assigned To</td><td><?php echo $row->assigned_person; ?></td>
                </tr>
								<tr>
									<td id="resultName">Notes</td><td><?php echo $row->notes;?></td>
								</tr>
							 </table>
						</div>
					</div>
					<div class="section width700" >
						<div class="sectionHeader">Logs</div>
						<div class="sectionBody">
							<table width="100%" border="0" cellpadding="10" id="latestStatusTable">
								<tr class="latestStatusTableHeader"><td width=25%>Date</td><td>Description</td></tr>
								<?php
									if ($data['logs'])
									{
										foreach ($data['logs']->result() as $row)
										{
											$type = $row->device;
											$type_name = $type.'_name';
											
											//skip showing deleted items
											if (!$row->$type_name && $row->process != 'delete')
											{
												continue;	
											}else 
											{
												if ($row->cubicle_id != 0)
												{
													if($row->process == 'assign' || $row->process == 'swap' || $row->process == 'transfer')
													{
														$cubicle = ' to '.anchor('cubicle/view/'.$row->cubicle_id, $row->cubicle_deployed);
													}
													elseif($row->process == 'pullout')
													{
														$cubicle = ' from '.anchor('cubicle/view/'.$row->cubicle_id, $row->cubicle_deployed);
													} 
												}
												else
												{
												  if($row->usb_headset_assignment != NULL || $row->usb_headset_assignment != '')
                          {
                            $cubicle = ' to <strong>'.$row->usb_headset_assignment.'</strong>';
                          }else
                          {
  													$cubicle = NULL;
                          }
												}
												
												switch ($row->process){
													case 'add':
														$operation = ' add new';
														echo '
															<tr><td>'.$row->cdate.'</td><td><strong>'.$row->username.'</strong>'.$operation.' '.anchor($row->device.'/view/'.$row->device_id,$row->device.' ['.$row->$type_name.']').$cubicle.'</td></tr>
														';
														break;
													case 'comment':
														$operation = ' add comment on';
														echo '
															<tr><td>'.$row->cdate.'</td><td><strong>'.$row->username.'</strong>'.$operation.' '.anchor($row->device.'/view/'.$row->device_id,$row->$type_name).'</td></tr>
														';
														break;
													default:
														$operation = ' '.$row->process;
														echo '
															<tr><td>'.$row->cdate.'</td><td><strong>'.$row->username.'</strong>'.$operation.' '.anchor($row->device.'/view/'.$row->device_id,$row->device.' ['.$row->$type_name.']').$cubicle.'</td></tr>
														';
												}
											}
										}
									}
								?>
							</table>	 
						</div>
					</div>
					
				<?php
					}
					else 
					{
				?>
					<div class="section width500" >
						<div class="sectionHeader">Usb_headset Info</div>
						<div class="sectionBody">
							Usb_headset dont exist.
						</div>
					</div>
				<?php		
					}
				?>
