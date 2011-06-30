				<?php 
					if ($data)
					{
						$row = $data['info']->row();
				?>
					<div class="section width500" >
						<div class="sectionHeader">Connector <?php echo $row->connector_name;?> Info</div>
						<div class="sectionBody">
							<table width="100%" border="0" cellpadding="0" id="latestStatusTable" style="whitespace: nowrap;">
								<tr>
									<td id="resultName" width="30%">Connector Name</td><td><?php echo $row->connector_name; ?></td>
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
									<td id="resultName">Date Purchased</td><td><?php echo $row->date_purchased;?></td>
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
						<div class="sectionHeader">Connector Info</div>
						<div class="sectionBody">
							Connector dont exist.
						</div>
					</div>
				<?php		
					}
				?>
