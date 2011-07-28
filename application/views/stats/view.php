					<?php 
						switch ($data['status']) {
							case 1 :
								$status = $data['flag_assigned'] && ($data['flag_assigned']) == 1 ? 'Deployed':'Avaliable';
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
							<?php 
								if ($data['flag_assigned'] == -1)
									unset($data['flag_assigned']);
									
								$this->deviceaction->view_all($data);
							?>
							</table>
						</div>
					</div>