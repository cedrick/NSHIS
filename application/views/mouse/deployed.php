					<div class="section width500" >
						<div class="sectionHeader">View Deployed Mouses</div>
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
											echo anchor('mouse/view/'.$row->mouse_id,$row->mouse_name);
											if ($row->cb_name)
											{
												$cubicle_link = anchor('cubicle/view/'.$row->cubicle_id,$row->cb_name);
											}
											else 
											{
												$cubicle_link = "";
											}
											echo "</td><td width=40%>".$cubicle_link."</td><td width=25%>".anchor('mouse/edit/'.$row->mouse_id,'edit')."</td></tr>";
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
									echo "No mouses added on the system.";
									echo "</td></tr>";
								}
								
							
							?>
							</table>
						</div>
					</div>