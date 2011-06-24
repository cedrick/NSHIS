					<div class="section width950" >
						<div class="sectionHeader">View All Usb_headsets</div>
						<div class="sectionBody">
							<table width="100%" border="0" cellpadding="0" id="latestStatusTable">
								<tr class="latestStatusTableHeader"><td>#</td><td>NAME</td><td>OTHER NAME</td><td>ASSIGNED TO</td><td></td></tr>
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
										echo "<tr $color><td>".($ctr+1)."</td><td width=150px>";
										echo anchor('usb_headset/view/'.$row->usb_headset_id,$row->usb_headset_name);
										echo "</td><td width=250px>".$row->other_name."</td><td width=250px>".$row->assigned_person."</td><td>".anchor('usb_headset/edit/'.$row->usb_headset_id,'edit')." | ".anchor('usb_headset/delete/'.$row->usb_headset_id,'delete')."</td></tr>";
										$ctr ++;
									}
								}
								else 
								{
									echo "<tr><td>";
									echo "No usb_headsets added on the system.";
									echo "</td></tr>";
								}
								
							
							?>
							</table>
						</div>
					</div>