					<script type="text/javascript">
						$(function() {
							$( "#datepicker" ).datepicker();
						});
					</script>
					<div class="section width500" >
						<div class="sectionHeader">Daily Logs</div>
						<div class="sectionBody">
							<form action="" method="post">
							 <table width="100%" border="0" cellpadding="10">
							 	<tr>
									<td width="30%">
										Date:
									</td>
									<td width="70%">
										<input id="datepicker" type="text" name="mdate" value="<?php echo $data['date']; ?>"> <input type="submit" name="submit_date" value="GO" />
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
						<div class="sectionHeader">Logs for <?php echo $data['date']; ?></div>
						<div class="sectionBody">
							<?php 
								//get parent class
								$class = $this->router->fetch_class();
								//generate id format
								$id = $this->router->fetch_class().'_id';
								//generate logs.
								$this->devicelog->generate_logs(0, 'date', array('cdate' => $data['date']));	
							?>
						</div>
					</div>