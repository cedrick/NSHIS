					<script type="text/javascript">
						$(document).ready(function() {
							var base_url = "<?php echo base_url(); ?>";
							var _user_id = 0;
							var _headset_id = 0;
							
							$( ".assign-headset" )
								.button()
								.click(function() {
								var title = $(this).attr("name");
								_user_id = $(this).attr("id");
								$(".validateTips").text("Select headset to be assign to " + title);
								$( "#dialog-form" ).dialog( "open" );
							});
							
							$( ".unassign-headset" )
							.button();

							function show_saving(){
								$.blockUI({ css: { 
						            border: 'none', 
						            padding: '15px', 
						            backgroundColor: '#000', 
						            '-webkit-border-radius': '10px', 
						            '-moz-border-radius': '10px', 
						            opacity: .5, 
						            color: '#fff',
						            message: 'Saving...'
						        } }); 
							}
							
							$( "#dialog-form" ).dialog({
								autoOpen: false,
								height: 150,
								width: 300,
								modal: true,
								buttons: {
									"Assign": function() {
										$( this ).dialog( "close" );
										show_saving();
										$.post(base_url + "ajax/assign_headset", {
											user_id : _user_id,
											headset_id : $("#combobox").val()
											}, function() {
												$.unblockUI;
												window.location.reload(true);
										});
									},
									Cancel: function() {
										$( this ).dialog( "close" );
									}
								}
							});
							
						});
					</script>
					<div id="dialog-form" title="Assign Headset">
						<p class="validateTips"><strong>Select from available headsets</strong></p>
						<form>
							<table>
								<tr>
									<td>Headset</td>
									<td>
										<?php 
											$headsets = $this->Usb_headset_model->get_available_usb_headsets();
											$output = array();
											foreach ($headsets->result() as $headset) {
												$output[$headset->usb_headset_id] = $headset->name;
											}
											echo form_dropdown('headsets', $output, NULL, 'id = "combobox" class="ui-widget-content ui-corner-all"')
										?>
									</td>
								</tr>
							</table>
						</form>
					</div>
					<div class="section width600" >
						<div class="sectionHeader">View All Users</div>
						<div class="sectionBody">
							<table width="100%" border="0" cellpadding="0" id="latestStatusTable">
								<tr class="latestStatusTableHeader"><td>#</td><td>FULL NAME</td><td>ASSIGNED HEADSET</td><td></td></tr>
								<?php $ctr = 0; ?>
								<?php foreach ($data->result() as $row):?>
								<tr id="<?php echo $row->first_name.' '.$row->last_name;?>">
									<td><?php echo ++$ctr; ?></td>
									<td><?php echo $row->last_name.', '.$row->first_name;?></td>
									<td><?php echo $row->usb_headset_id != 0 ? anchor('/usb_headset/view/'.$row->usb_headset_id, $row->name) : ''; ?></td>
									<td>
										<?php if($row->usb_headset_id == 0) :?>
											<a class="assign-headset" id="<?php echo $row->id; ?>" name="<?php echo $row->first_name.' '.$row->last_name;?>">assign</a>
										<?php else: ?>
											<a class="unassign-headset" href="<?php echo base_url(); ?>usb_headset/unassign/<?php echo $row->usb_headset_id; ?>" >unassign</a>
										<?php endif;?>
									</td>
								</tr>
								<?php endforeach;?>
							</table>
						</div>
					</div>