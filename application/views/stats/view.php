					<?php 
						switch ($data['status']) {
							case 0 :
								$status = 'Deployed';
								break;
							case 1 :
								$status = 'Available';
								break;
							case 2 :
								$status = 'Defective';
								break;
							case 3 :
								$status = 'Missing';
								break;
							case 4 :
								$status = 'Under Repair';
								break;
							case 5 :
								$status = 'EOL';
								break;
						}
					?>
					
					<div class="section width500" >
						<div class="sectionHeader">View <?php echo $status . ' ' . $data['device']; ?></div>
						<div class="sectionBody">
							<table width="100%" border="0" cellpadding="0" id="latestStatusTable">
								<tr class="latestStatusTableHeader"><td>NAME</td><td>STATUS</td><td>ASSIGNED CUBICLE</td></tr>
								<?php 
									$this->Stats_model->fetch_items($data['device'], $data['status'], $this->uri->segment(5));
								?>
							</table>
						</div>
					</div>