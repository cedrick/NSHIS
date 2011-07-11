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
									<td id="resultName">Date Purchased</td><td><?php echo $row->date_purchased;?></td>
								</tr>
								<tr>
				                  <td id="resultName" width="30%">Assigned To</td><td><?php echo $this->People_model->get_name($row->assigned_person); ?></td>
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
