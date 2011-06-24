					<?php 
						
						echo form_open(base_url() . 'headset/swap/' . $this->uri->segment(3));
						
						if ($data)
						{
							$cubicle_options = array();
							foreach ($data->result() as $row)
							{
								if ($this->uri->segment(3) == $row->headset_id)
								{
									$headset_to_swap = $row->headset_name;
									continue;
								}
								$array2 = array($row->cubicle_id.'|'.$row->headset_id => $row->cb_name.' - '.$row->headset_name);
								$cubicle_options = $cubicle_options + $array2;
							}
						}
						
						$submit = array(
							'name'	=>	'submit',
							'value'	=>	'Submit'
						);
											
					?>
					
					<div class="section width400" >
						<div class="sectionHeader">Swap <?php echo $headset_to_swap; ?></div>
						<div class="sectionBody">
							<form action="" method="get">
							 <table width="100%" border="0" cellpadding="10">
							 	<tr>
									<td width="30%">
										Destination:
									</td>
									<td width="70%">
										<?php echo form_dropdown('cubicle_id', $cubicle_options);  ?>
									</td>
								</tr>
								<tr>
									<td>
										
									</td>
									<td>
										<?php echo form_submit($submit); ?>
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