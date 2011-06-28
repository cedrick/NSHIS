					<?php 
					
						foreach ($data['device_info']->result() as $row)
						{
							echo '
								<div class="section width500" >
									<div class="sectionHeader">Hardware Summary</div>
									<div class="sectionBody">
										 <table width="100%" border="0" cellpadding="10" id="latestStatusTable">
										 	<tr class="latestStatusTableHeader"><td>Hardware</td><td>Available</td><td>Deployed</td><td>Total</td></tr>
										 	<tr><td>'.$row->name_cpu.'</td><td>'.anchor('cpu/available',$row->unassigned_cpu).'</td><td>'.anchor('cpu/deployed',$row->assigned_cpu).'</td><td>'.$row->total_cpu.'</td></tr>
										 	<tr><td>'.$row->name_kyb.'</td><td>'.anchor('keyboard/available',$row->unassigned_kyb).'</td><td>'.anchor('keyboard/deployed',$row->assigned_kyb).'</td><td>'.$row->total_kyb.'</td></tr>
										 	<tr><td>'.$row->name_mse.'</td><td>'.anchor('mouse/available',$row->unassigned_mse).'</td><td>'.anchor('mouse/deployed',$row->assigned_mse).'</td><td>'.$row->total_mse.'</td></tr>
										 	<tr><td>'.$row->name_mon.'</td><td>'.anchor('monitor/available',$row->unassigned_mon).'</td><td>'.anchor('monitor/deployed',$row->assigned_mon).'</td><td>'.$row->total_mon.'</td></tr>
										 	<tr><td>'.$row->name_dlp.'</td><td>'.anchor('dialpad/available',$row->unassigned_dlp).'</td><td>'.anchor('dialpad/deployed',$row->assigned_dlp).'</td><td>'.$row->total_dlp.'</td></tr>
										 	<tr><td>'.$row->name_con.'</td><td>'.anchor('connector/available',$row->unassigned_con).'</td><td>'.anchor('connector/deployed',$row->assigned_con).'</td><td>'.$row->total_con.'</td></tr>
										 	<tr><td>'.$row->name_hst.'</td><td>'.anchor('headset/available',$row->unassigned_hst).'</td><td>'.anchor('headset/deployed',$row->assigned_hst).'</td><td>'.$row->total_hst.'</td></tr>
										 	<tr><td>'.$row->name_usbhst.'</td><td>'.anchor('usb_headset/available',$row->unassigned_usbhst).'</td><td>'.anchor('usb_headset/deployed',$row->assigned_usbhst).'</td><td>'.$row->total_usbhst.'</td></tr>
										 	<tr><td>'.$row->name_ups.'</td><td>'.anchor('ups/available',$row->unassigned_ups).'</td><td>'.anchor('ups/deployed',$row->assigned_ups).'</td><td>'.$row->total_ups.'</td></tr>
										 </table>
									</div>
								</div>
							';
						}
					?>
					
					<div class="section width700" >
            <div class="sectionHeader">Logs</div>
            <div class="sectionBody">
              <?php 
	              //get parent class
	              $class = $this->router->fetch_class();
	              //generate id format
	              $id = $this->router->fetch_class().'_id';
	              //generate logs.
	              $this->devicelog->generate_logs('', $class);
              ?>
            </div>
          </div>
					