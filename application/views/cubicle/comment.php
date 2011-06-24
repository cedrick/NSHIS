				<?php 
					if ($data)
					{
						$row = $data->row();
						
						echo form_open(base_url() . 'cubicle/comment/' . $this->uri->segment(3));
						
						$cubicle_comment = array(
							'name'	=>	'cubicle_comment',
							'id'	=>	'cubicle_comment',
							'rows'	=>	'4',
							'cols'	=>	'30',
							'value'	=>	set_value('cubicle_comment')
						);
						
						$submit = array(
							'name'	=>	'submit',
							'value'	=>	'Submit'
						);
				?>
					<div class="section width500" >
						<div class="sectionHeader">Add New Comment</div>
						<div class="sectionBody">
							<form action="" method="get">
							 <table width="100%" border="0" cellpadding="10">
								<tr>
									<td width="30%">
										Comment:
									</td>
									<td width="70%">
										<?php echo form_textarea($cubicle_comment); ?>
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
					
				<?php
					}
				?>
