					<?php 

						echo form_open(base_url() . 'search/');
						
						$name = array(
							'name'	=>	'name',
							'id'	=>	'name',
							'value'	=>	set_value('name')
						);
						
						$options = array(
							'cubicle'	=>	'CUBICLE',
							'cpu'	=>	'CPU',
							'keyboard'	=>	'KEYBOARD',
							'mouse'	=>	'MOUSE',
							'monitor'	=>	'MONITOR',
							'dialpad'	=>	'DIALPAD',
							'connector'	=>	'CONNECTOR',
							'headset'	=>	'HEADSET',
							'ups'	=>	'UPS'
						);
						
						$submit = array(
							'name'	=>	'submit',
							'value'	=>	'Submit'
						);
											
					?>
					
					<div class="section width500" >
						<div class="sectionHeader">Search</div>
						<div class="sectionBody">
							<form action="" method="get">
							 <table width="100%" border="0" cellpadding="10">
							 	<tr>
									<td width="30%">
										Search for:
									</td>
									<td width="70%">
										<?php echo form_dropdown('item_type', $options); ?>
									</td>
								</tr>
							 	<tr>
									<td width="30%">
										Name:
									</td>
									<td width="70%">
										<?php echo form_input($name); ?>
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
            if ($result)
            {
              $id=$item_type.'_id';
          ?>
					<div class="section width400" >
            <div class="sectionHeader">Result - FOUND <?php echo $result->num_rows;?></div>
            <div class="sectionBody">
              <table width="100%" border="0" cellpadding="0" id="latestStatusTable">
                <tr class="latestStatusTableHeader"><td>#</td><td>TYPE</td><td>NAME</td></tr>
                <?php 
                  $ctr = 0;
                  foreach ($result->result() as $row)
                  {
                    if($ctr%2==0){
                      $color=" bgcolor='#d8ebeb'";
                    }else{
                      $color=" bgcolor='#FFFFFF'";
                    }
                    echo "<tr $color><td>".($ctr+1)."</td>";
                    echo "<td width=150px>$item_type</td><td width=150px>";
                    echo anchor($item_type.'/view/'.$row->$id,$row->name);
                    // if ($row->cb_name)
                    // {
                    //   $cubicle_link = anchor('cubicle/view/'.$row->cubicle_id,$row->cb_name);
                    // }
                    // else 
                    // {
                    //   $cubicle_link = "";
                    // }
                    echo "</td>";
                    $ctr ++;
                  }
                ?>
              </table>
            </div>
          </div>
          <?php 
            }
          ?>