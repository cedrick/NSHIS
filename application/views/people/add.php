					<div class="section width500" >
						<div class="sectionHeader">Add New User</div>
						<div class="sectionBody">
							<form action="" method="post">
							 <table width="100%" border="0" cellpadding="10">
							 	<tr>
									<td width="30%">
										First Name:
									</td>
									<td width="70%">
										<input type="text" name="fname" />
									</td>
								</tr>
								<tr>
									<td width="30%">
										Last Name:
									</td>
									<td width="70%">
										<input type="text" name="lname" />
									</td>
								</tr>
								<tr>
									<td>
										
									</td>
									<td>
										<input type="submit" name="save" value="Save"/>
									</td>
								</tr>
								<tr>
									<td></td>
									<td><?php echo validation_errors().$this->session->flashdata('error'); ?>
									</td>
								</tr>
							 </table>
							</form>
						</div>
					</div>