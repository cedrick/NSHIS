					<div class="section width500" >
						<div class="sectionHeader">User Logs</div>
						<div class="sectionBody">
							<form action="" method="post">
							 <table width="100%" border="0" cellpadding="10">
							 	<tr>
									<td width="10%">
										User:
									</td>
									<td width="90%">
										<?php 
											//get users for filter dropdown
											$this->db->order_by('username');
											$users = $this->db->get('nshis_users');
											
											$user_options = array('ALL' => '-User-');
											foreach ($users->result() as $user) {
												$array = array($user->ID => $user->username);
												$user_options = $user_options + $array;
											}
											
											echo form_dropdown('id', $user_options, $data['id'])
										?>
										<input type="submit" name="submit_user" value="GO" />
									</td>
								</tr>
								<tr>
									<td></td>
									<td><?php echo validation_errors(); ?>
									</td>
								</tr>
							 </table>
							</form>
						</div>
					</div>
					<div class="section width700" >
						<div class="sectionHeader">Logs for <?php echo $data['id']; ?></div>
						<div class="sectionBody">
							<?php 
								//get parent class
								$class = $this->router->fetch_class();
								//generate id format
								$id = $this->router->fetch_class().'_id';
								//generate logs.
								$this->devicelog->generate_user_logs($data['id']);	
							?>
						</div>
					</div>