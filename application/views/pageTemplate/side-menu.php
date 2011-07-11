<script type="text/javascript">
	$(function() {
		var base_url = "<?php echo base_url(); ?>";
		var device = "<?php echo $this->uri->segment(1); ?>";
		var device_id = "<?php echo $this->uri->segment(3); ?>";
		$(".delete_btn").click(function(){
			$( "#dialog-confirm" ).dialog('open');
		});

		$( "#dialog-confirm" ).dialog({
			autoOpen: false,
			resizable: false,
			height:140,
			modal: true,
			buttons: {
				"Delete this item?": function() {
					$.post(base_url + device + "/delete",{my_device_id : device_id},
						function() {
							$( this ).dialog( "close" );
							window.location = base_url + device + "/viewall";
						}
					);
				},
				Cancel: function() {
					$( this ).dialog( "close" );
				}
			}
		});
		
	});
</script>
<div id="menu7">
	<a href='#'>QUICK LINKS</a><br />
	<ul>
		<li><a href="<?php echo base_url();?>log/daily">Daily Item Logs</a></li>
		<li><a href="<?php echo base_url();?>search">Search Item</a></li>
		<li><a href="<?php echo base_url();?>cubicle/viewall">View All Cubicles</a></li>
	</ul>
	<?php
	if ($this->uri->segment(2) == 'view' || $this->uri->segment(2) == 'edit' || $this->uri->segment(2) == 'assign' && $this->uri->segment(1) == 'usb_headset')
	{
		echo '
			<br /><br />
			<a href="#">ITEM</a><br />
			<ul>
		';
		echo '<li>'.anchor($this->uri->segment(1).'/view/'.$this->uri->segment(3), 'Info').'</li>';
		echo '<li>'.anchor($this->uri->segment(1).'/edit/'.$this->uri->segment(3), 'Edit').'</li>';
		if ($this->uri->segment(1) != 'cubicle')
		{
			if($this->uri->segment(1) == 'usb_headset')
			{
				echo '<li>'.anchor($this->uri->segment(1).'/assign/'.$this->uri->segment(3), 'Assign').'</li>';
				echo '<li>'.anchor($this->uri->segment(1).'/unassign/'.$this->uri->segment(3), 'Unassign').'</li>';
			}else
			{
				echo '<li>'.anchor($this->uri->segment(1).'/pullout/'.$this->uri->segment(3), 'Pullout').'</li>';
			}

		}
		echo '<li><a href="#" class="delete_btn" id="'.$this->uri->segment(3).'">Delete</a></li></ul>';
		
		echo '
			<br /><br />
			<a href="#">'.strtoupper($this->uri->segment(1)).'</a><br />
			<ul>
		';
		echo '<li>'.anchor($this->uri->segment(1).'/add/', 'Add New').'</li>';
		echo '<li>'.anchor($this->uri->segment(1).'/viewall/', 'View All').'</li>';
		
		if ($this->uri->segment(1) == 'usb_headset') {
			echo '<li>'.anchor(base_url().'people/add', 'Add User').'</li>';
			echo '<li>'.anchor(base_url().'people/viewall', 'View All Users').'</li>';
		}
		
	}

	?>
	</ul>
</div>
