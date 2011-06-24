					<?php 
						if ($data)
						{
							$row = $data->row();
					?>
					<div class="section width500" >
						<div class="sectionHeader">Cubicle <?php echo $row->name;?> Info</div>
						<div class="sectionBody">
							<table width="100%" border="0" cellpadding="0" id="latestStatusTable">
								<tr>
									<td id="resultName">Cubicle Name</td><td><?php echo $row->name;?></td><td>&nbsp;</td>
								</tr>
								<tr>
									<td id="resultName">CPU</td><td><?php echo anchor('cpu/view/'.$row->cpu_id, $row->cpu_name.' ', 'title="View"');?></td><td><?php echo anchor('cpu/assign/'.$row->cubicle_id, 'A', 'title="Assign"')." - "; echo anchor('cpu/edit/'.$row->cpu_id, 'E', 'title="Edit"')." - "; echo anchor('cpu/transfer/'.$row->cpu_id, 'T', 'title="Transfer"')." - "; echo anchor('cpu/swap/'.$row->cpu_id, 'S', 'title="Swap"');?></td>
								</tr>
								<tr>
									<td id="resultName">Keyboard</td><td><?php echo anchor('keyboard/view/'.$row->keyboard_id, $row->kyb_name.' ', 'title="View"');?></td><td><?php echo anchor('keyboard/assign/'.$row->cubicle_id, 'A', 'title="Assign"')." - "; echo anchor('keyboard/edit/'.$row->keyboard_id, 'E', 'title="Edit"')." - "; echo anchor('keyboard/transfer/'.$row->keyboard_id, 'T', 'title="Transfer"')." - "; echo anchor('keyboard/swap/'.$row->keyboard_id, 'S', 'title="Swap"');?></td>
								</tr>
								<tr>
									<td id="resultName">Mouse</td><td><?php echo anchor('mouse/view/'.$row->mouse_id, $row->mse_name.' ', 'title="View"');?></td><td><?php echo anchor('mouse/assign/'.$row->cubicle_id, 'A', 'title="Assign"')." - "; echo anchor('mouse/edit/'.$row->mouse_id, 'E', 'title="Edit"')." - "; echo anchor('mouse/transfer/'.$row->mouse_id, 'T', 'title="Transfer"')." - "; echo anchor('mouse/swap/'.$row->mouse_id, 'S', 'title="Swap"');?></td>
								</tr>
								<tr>
									<td id="resultName">Monitor</td><td><?php echo anchor('monitor/view/'.$row->monitor_id, $row->mon_name.' ', 'title="View"');?></td><td><?php echo anchor('monitor/assign/'.$row->cubicle_id, 'A', 'title="Assign"')." - "; echo anchor('monitor/edit/'.$row->monitor_id, 'E', 'title="Edit"')." - "; echo anchor('monitor/transfer/'.$row->monitor_id, 'T', 'title="Transfer"')." - "; echo anchor('monitor/swap/'.$row->monitor_id, 'S', 'title="Swap"');?></td>
								</tr>
								<tr>
									<td id="resultName">Dial Pad</td><td><?php echo anchor('dialpad/view/'.$row->dialpad_id, $row->dlp_name.' ', 'title="View"');?></td><td><?php echo anchor('dialpad/assign/'.$row->cubicle_id, 'A', 'title="Assign"')." - "; echo anchor('dialpad/edit/'.$row->dialpad_id, 'E', 'title="Edit"')." - "; echo anchor('dialpad/transfer/'.$row->dialpad_id, 'T', 'title="Transfer"')." - "; echo anchor('dialpad/swap/'.$row->dialpad_id, 'S', 'title="Swap"');?></td>
								</tr>
								<tr>
									<td id="resultName">Connector</td><td><?php echo anchor('connector/view/'.$row->connector_id, $row->con_name.' ', 'title="View"');?></td><td><?php echo anchor('connector/assign/'.$row->cubicle_id, 'A', 'title="Assign"')." - "; echo anchor('connector/edit/'.$row->connector_id, 'E', 'title="Edit"')." - "; echo anchor('connector/transfer/'.$row->connector_id, 'T', 'title="Transfer"')." - "; echo anchor('connector/swap/'.$row->connector_id, 'S', 'title="Swap"');?></td>
								</tr>
								<tr>
									<td id="resultName">Headset(Analog)</td><td><?php echo anchor('headset/view/'.$row->headset_id, $row->hst_name.' ', 'title="View"');?></td><td><?php echo anchor('headset/assign/'.$row->cubicle_id, 'A', 'title="Assign"')." - "; echo anchor('headset/edit/'.$row->headset_id, 'E', 'title="Edit"')." - "; echo anchor('headset/transfer/'.$row->headset_id, 'T', 'title="Transfer"')." - "; echo anchor('headset/swap/'.$row->headset_id, 'S', 'title="Swap"');?></td>
								</tr>
								<tr>
									<td id="resultName">UPS</td><td><?php echo anchor('ups/view/'.$row->ups_id, $row->ups_name.' ', 'title="View"');?></td><td><?php echo anchor('ups/assign/'.$row->cubicle_id, 'A', 'title="Assign"')." - "; echo anchor('ups/edit/'.$row->ups_id, 'E', 'title="Edit"')." - "; echo anchor('ups/transfer/'.$row->ups_id, 'T', 'title="Transfer"')." - "; echo anchor('ups/swap/'.$row->ups_id, 'S', 'title="Swap"');?></td>
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
							if ($comments)
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