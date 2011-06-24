					<div class="section width500" >
						<div class="sectionHeader">View Deployed Connectors</div>
						<div class="sectionBody">
							<table width="100%" border="0" cellpadding="0" id="latestStatusTable">
								<tr class="latestStatusTableHeader"><td>NAME</td><td>ASSIGNED CUBICLE</td><td></td></tr>
							<?php 
								if ($data)
								{
									$ctr = 0;
									foreach ($data->result() as $row)
									{
										if ($row->flag_assigned == 1)
										{
											if($ctr%2==0){
												$color=" bgcolor='#d8ebeb'";
											}else{
												$color=" bgcolor='#FFFFFF'";
											}
											echo "<tr $color><td width=35%>";
											echo anchor('connector/view/'.$row->connector_id,$row->connector_name);
											if ($row->cb_name)
											{
												$cubicle_link = anchor('cubicle/view/'.$row->cubicle_id,$row->cb_name);
											}
											else 
											{
												$cubicle_link = "";
											}
											echo "</td><td width=40%>".$cubicle_link."</td><td width=25%>".anchor('connector/edit/'.$row->connector_id,'edit')." | ".anchor('connector/delete/'.$row->connector_id,'delete')."</td></tr>";
											$ctr ++;
										}
										else 
										{
											next($row);
										}
									}
								}
								else 
								{
									echo "<tr><td>";
									echo "No connectors added on the system.";
									echo "</td></tr>";
								}
								
							
							?>
							</table>
						</div>
					</div>