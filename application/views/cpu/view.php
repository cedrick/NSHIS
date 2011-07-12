					<?php if($data['info']): ?>
					<?php $row = $data['info']->row(); ?>
					<div class="section width500" >
						<div class="sectionHeader">CPU <?php echo $row->cpu_name;?> Info</div>
						<div class="sectionBody">
							<table width="100%" border="0" cellpadding="0" id="latestStatusTable" style="whitespace: nowrap;">
								<tr>
									<td id="resultName" width="30%">CPU Name</td><td><?php echo $row->cpu_name; ?></td>
								</tr>
								<tr>
									<td id="resultName" width="30%">Status</td>
									<td class="ui-state-highlight">
										<?php 
											//get parent class
											$class = $this->router->fetch_class();
											//generate id format
											$id = $this->router->fetch_class().'_id';
											echo $this->devicestatus->get_status($this->router->fetch_class(), $row->$id);
										?>
									</td>
								</tr>
								<tr>
									<td id="resultName" width="30%">Other Name</td><td><?php echo $row->other_name; ?></td>
								</tr>
								<tr>
									<td id="resultName">Serial Number</td><td><?php echo $row->serial_number; ?></td>
								</tr>
								<tr>
									<td id="resultName">Location</td><td><?php echo $row->cb_id?anchor('cubicle/view/'.$row->cb_id,$row->cb_name):""; ?></td>
								</tr>
								<tr>
									<td id="resultName">Processor</td><td><?php echo $row->processor_name; ?></td>
								</tr>
								<tr>
									<td id="resultName">Memory 1</td><td><?php echo $row->memory1_name.' '.$row->memory1_type_name; ?></td>
								</tr>
								<tr>
									<td id="resultName">Memory 2</td><td><?php echo $row->memory2_name.' '.$row->memory2_type_name; ?></td>
								</tr>
								<tr>
									<td id="resultName">Hard Disk 1</td><td><?php echo $row->hd1_name.' '.$row->hd1_type_name; ?></td>
								</tr>
								<tr>
									<td id="resultName">Hard Disk 2</td><td><?php echo $row->hd2_name.' '.$row->hd2_type_name; ?></td>
								</tr>
								<tr>
									<td id="resultName">Date Purchased</td><td><?php echo $row->date_purchased;?></td>
								</tr>
								<tr>
									<td id="resultName">Hostname</td><td><?php echo $row->hostname; ?></td>
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
							<?php 
								//get parent class
								$class = $this->router->fetch_class();
								//generate id format
								$id = $this->router->fetch_class().'_id';
								//generate logs.
								$this->devicelog->generate_logs($row->$id, $class);	
							?>
						</div>
					</div>
					<?php else: ?>
					<div class="section width500" >
						<div class="sectionHeader">CPU Info</div>
						<div class="sectionBody">
							CPU dont exist.
						</div>
					</div>
					<?php endif; ?>