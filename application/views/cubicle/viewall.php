					<div class="section width400" >
						<div class="sectionHeader">View All Cubicles</div>
						<div class="sectionBody">
							<table width="100%" border="0" cellpadding="0" id="latestStatusTable">
								
							<?php 
								if ($data)
								{
									$ctr = 0;
									foreach ($data->result() as $row)
									{
										if($ctr%2==0){
											$color=" bgcolor='#d8ebeb'";
										}else{
											$color=" bgcolor='#FFFFFF'";
										}
										echo "<tr $color><td width=70%>";
										echo anchor('cubicle/view/'.$row->cubicle_id,$row->name);
										echo "</td><td width=30%>".anchor('cubicle/edit/'.$row->cubicle_id,'edit')."</td></tr>";
										$ctr ++;
									}
								}
								else 
								{
									echo "<tr><td>";
									echo "No cubicles added on the system.";
									echo "</td></tr>";
								}
								
							
							?>
							</table>
						</div>
					</div>