					<div class="section width500" >
						<div class="sectionHeader">View All Users</div>
						<div class="sectionBody">
							<table width="100%" border="0" cellpadding="0" id="latestStatusTable">
								<tr class="latestStatusTableHeader"><td>#</td><td>FULL NAME</td><td>ASSIGNED HEADSET</td></tr>
								<?php $ctr = 0; ?>
								<?php foreach ($data->result() as $row):?>
								<tr id="<?php echo $row->first_name.' '.$row->last_name;?>"><td><?php echo ++$ctr; ?></td><td><?php echo $row->first_name.' '.$row->last_name;?></td><td><?php echo $row->usb_headset_id != 0 ? anchor('/usb_headset/view/'.$row->usb_headset_id, $row->name) : ''; ?></td></tr>
								<?php endforeach;?>
							</table>
						</div>
					</div>