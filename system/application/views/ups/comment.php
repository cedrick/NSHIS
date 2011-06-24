				<?php 
					if ($data)
					{
						$row = $data->row();
						
						echo form_open(base_url() . 'ups/comment/' . $this->uri->segment(3));
						
						$ups_comment = array(
							'name'	=>	'ups_comment',
							'id'	=>	'ups_comment',
							'rows'	=>	'4',
							'cols'	=>	'30',
							'value'	=>	set_value('ups_comment')
						);
						
						$submit = array(
							'name'	=>	'submit',
							'value'	=>	'Submit'
						);
				?>
					<div class="section width500" >
						<div class="sectionHeader">Add New Comment for <?php echo $row->ups_name; ?></div>
						<div class="sectionBody">
							<form action="" method="get">
							 <table width="100%" border="0" cellpadding="10">
								<tr>
									<td width="30%">
										Comment:
									</td>
									<td width="70%">
										<?php echo form_textarea($ups_comment); ?>
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
