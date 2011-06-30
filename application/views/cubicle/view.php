					<?php 
						if ($data)
						{
							$row = $data['info']->row();
					?>
					<script type="text/javascript">
					$(document).ready(function() {
						$('.cubLink a').button();

					});
					</script>
					<div class="section width600" >
						<div class="sectionHeader">Cubicle <?php echo $row->name;?> Info</div>
						<div class="sectionBody">
							<table width="100%" border="0" cellpadding="0" id="latestStatusTable">
								<tr>
									<td id="resultName" width="175">Cubicle Name</td><td><?php echo $row->name;?></td><td width="220">&nbsp;</td>
								</tr>
								<tr>
									<td id="resultName">CPU</td><td><?php echo anchor('cpu/view/'.$row->cpu_id, $row->cpu_name.' ', 'title="View"');?></td><td class="cubLink"><?php echo anchor('cpu/assign/'.$row->cubicle_id, 'assign', 'title="Assign"'); echo isset($row->cpu_id) ? anchor('cpu/transfer/'.$row->cpu_id, 'transfer', 'title="Transfer"').anchor('cpu/swap/'.$row->cpu_id, 'swap', 'title="Swap"').anchor('cpu/pullout/'.$row->cpu_id, 'pullout', 'title="Pullout"') : '';?></td>
								</tr>
								<tr>
									<td id="resultName">Keyboard</td><td><?php echo anchor('keyboard/view/'.$row->keyboard_id, $row->kyb_name.' ', 'title="View"');?></td><td class="cubLink"><?php echo anchor('keyboard/assign/'.$row->cubicle_id, 'assign', 'title="Assign"'); echo isset($row->keyboard_id) ? anchor('keyboard/transfer/'.$row->keyboard_id,'transfer', 'title="Transfer"').anchor('keyboard/swap/'.$row->keyboard_id, 'swap', 'title="Swap"').anchor('keyboard/pullout/'.$row->keyboard_id, 'pullout', 'title="Pullout"') : '';?></td>
								</tr>
								<tr>
									<td id="resultName">Mouse</td><td><?php echo anchor('mouse/view/'.$row->mouse_id, $row->mse_name.' ', 'title="View"');?></td><td class="cubLink"><?php echo anchor('mouse/assign/'.$row->cubicle_id, 'assign', 'title="Assign"'); echo isset($row->mouse_id) ? anchor('mouse/transfer/'.$row->mouse_id,'transfer', 'title="Transfer"').anchor('mouse/swap/'.$row->mouse_id, 'swap', 'title="Swap"').anchor('mosue/pullout/'.$row->mouse_id, 'pullout', 'title="Pullout"') : '';?></td>
								</tr>
								<tr>
									<td id="resultName">Monitor</td><td><?php echo anchor('monitor/view/'.$row->monitor_id, $row->mon_name.' ', 'title="View"');?></td><td class="cubLink"><?php echo anchor('monitor/assign/'.$row->cubicle_id, 'assign', 'title="Assign"'); echo isset($row->monitor_id) ? anchor('monitor/transfer/'.$row->monitor_id,'transfer', 'title="Transfer"').anchor('monitor/swap/'.$row->monitor_id, 'swap', 'title="Swap"').anchor('monitor/pullout/'.$row->monitor_id, 'pullout', 'title="Pullout"') : '';?></td>
								</tr>
								<tr>
									<td id="resultName">Dial Pad</td><td><?php echo anchor('dialpad/view/'.$row->dialpad_id, $row->dlp_name.' ', 'title="View"');?></td><td class="cubLink"><?php echo anchor('dialpad/assign/'.$row->cubicle_id, 'assign', 'title="Assign"'); echo isset($row->dialpad_id) ? anchor('dialpad/transfer/'.$row->dialpad_id,'transfer', 'title="Transfer"').anchor('dialpad/swap/'.$row->dialpad_id, 'swap', 'title="Swap"').anchor('dialpad/pullout/'.$row->dialpad_id, 'pullout', 'title="Pullout"') : '';?></td>
								</tr>
								<tr>
									<td id="resultName">Connector</td><td><?php echo anchor('connector/view/'.$row->connector_id, $row->con_name.' ', 'title="View"');?></td><td class="cubLink"><?php echo anchor('connector/assign/'.$row->cubicle_id, 'assign', 'title="Assign"'); echo isset($row->connector_id) ? anchor('connector/transfer/'.$row->connector_id,'transfer', 'title="Transfer"').anchor('connector/swap/'.$row->connector_id, 'swap', 'title="Swap"').anchor('connector/pullout/'.$row->connector_id, 'pullout', 'title="Pullout"') : '';?></td>
								</tr>
								<tr>
									<td id="resultName">Headset(Analog)</td><td><?php echo anchor('headset/view/'.$row->headset_id, $row->hst_name.' ', 'title="View"');?></td><td class="cubLink"><?php echo anchor('headset/assign/'.$row->cubicle_id, 'assign', 'title="Assign"'); echo isset($row->headset_id) ? anchor('headset/transfer/'.$row->headset_id,'transfer', 'title="Transfer"').anchor('headset/swap/'.$row->headset_id, 'swap', 'title="Swap"').anchor('headset/pullout/'.$row->headset_id, 'pullout', 'title="Pullout"') : '';?></td>
								</tr>
								<tr>
									<td id="resultName">UPS</td><td><?php echo anchor('ups/view/'.$row->ups_id, $row->ups_name.' ', 'title="View"');?></td><td class="cubLink"><?php echo anchor('ups/assign/'.$row->cubicle_id, 'assign', 'title="Assign"'); echo isset($row->ups_id) ? anchor('ups/transfer/'.$row->ups_id,'transfer', 'title="Transfer"').anchor('ups/swap/'.$row->ups_id, 'swap', 'title="Swap"').anchor('ups/pullout/'.$row->ups_id, 'pullout', 'title="Pullout"') : '';?></td>
								</tr>
								<!--<tr>
									<td id="resultName">Date Added</td><td><?php echo $row->cdate;?></td><td>&nbsp;</td>
								</tr>
							 --></table>
						</div>
					</div>
					<div class="section width500" >
						<div class="sectionHeader">Comments</div>
						<div class="sectionBody">
						<?php 
							if ($data['comments'])
							{
								
								foreach ($comments->result() as $row2)
								{
									echo "
										<div id='comments'>
											<div>
												<div class='comments-head'><span class='post-by'>".$row2->username."</span><span class='post-date'>".$row2->cdate."</span></div>
												<div class='comments-body'>".$row2->comment."</div>
											</div>
										</div>
									";
								}
							}
						?>
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
						<div class="sectionHeader">Cubicle Info</div>
						<div class="sectionBody">
							Cubicle dont exist.
						</div>
					</div>
					<?php		
						}
					?>