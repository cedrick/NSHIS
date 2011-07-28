<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Deviceaction {
	public $CI;
 	
	public function __construct()
	{
		$this->CI =& get_instance();

		$this->CI->load->database();
		
		$this->CI->load->library('table');

		//set table template
		$tmpl = array (
			'table_open' => '<table width="100%" border="0" cellspacing="0" id="table_result" class="tablesorter">'
			);
		$this->CI->table->set_template($tmpl);
	}
	
	public function generate_actions($device_id, $device_type)
	{
		//check if status is OK
		$query = $this->CI->db->get_where('nshis_'.$device_type.'s', array($device_type.'_id' => $device_id, 'status' => 1, ));
		if ($query->num_rows() == 0) {
			return FALSE;
		}
		
		$this->print_assign();
	}
	
	
	private function print_assign()
	{
		echo '<div id="assign_btn">ASSIGN</div>';
	}
	
	
	public function view_all($param = array())
	{
		//check if something passed to param
		if (count($param) == 0) {
			$device_type = $this->CI->router->fetch_class();
		} else {
			$device_type = $param['device'];
			unset($param['device']);
			//add param to filters
			$this->CI->db->where($param);
		}
		
		//set table headings and $location variable
		if ($device_type == 'usb_headset') {
			//change heading if requested by USB Headset
			$this->CI->table->set_heading('Name', 'Status', 'User');
		} else {
			$this->CI->table->set_heading('Name', 'Status', 'Cubicle');
		}
		
		//query devices
		$this->CI->db->select('*');
		$this->CI->db->from('nshis_'.$device_type.'s');
		$this->CI->db->join('nshis_device_statuses', 'nshis_'.$device_type.'s.status = nshis_device_statuses.status_id');
		$this->CI->db->order_by('name');
		$query = $this->CI->db->get();
		
		//javascript
		echo '
			<script type="text/javascript">
				$(document).ready(function(){ 
					//vars
					var base_url = "'.base_url().'";
		';
		
		echo $query->num_rows() > 0 ? '$("#table_result").tablesorter(); //make table sortable' : NULL;
					
		echo '	
		        	//make assign links to be like buttons 
		        	$(".btnAssign").button();

					//show pop-up when assign button was clicked
		        	$(".btnAssign").click(function(){
		        		$( "#dialog-form" )
		        			.data("id", this.id)
		        			.dialog( "open" );
	        			return false;
			        });

			        //init dialog box
		        	$( "#dialog-form" ).dialog({
						autoOpen: false,
						height: 130,
						width: 250,
						modal: true,
						buttons: {
							"Assign": function() {
								item_info = $(this).data("id").split("_");
								$( this ).dialog( "close" );
								if ($.trim($( "#location" ).val()).length > 0) {
									show_saving();
									$.post(base_url + "ajax/assign_item", {
										item : item_info[0],
										item_id : item_info[1],
										location_id : $( "#location" ).val()
									}, function(data) {
										$.unblockUI;
										window.location.reload(true);
									});
								} else {
									alert("Location Field is required");
								}
							},
							Cancel: function() {
								$( this ).dialog( "close" );
							}
						}
					});

					//modal
		        	function show_saving(){
						$.blockUI({ css: { 
				            border: "none", 
				            padding: "15px", 
				            backgroundColor: "#000", 
				            "-webkit-border-radius": "10px", 
				            "-moz-border-radius": "10px", 
				            opacity: .5, 
				            color: "#fff"
				       		},
				       		message: "<h1>Processing</h1>" 
						}); 
					}
			    }); 
			</script>
		';
		
		foreach ($query->result() as $row)
		{
			//generate id field string
			$id = $device_type.'_id';
			
			//add table row
			if ($device_type == 'usb_headset') {
				$column3 = $row->assigned_person != 0 ? $this->get_person_name($row->assigned_person) : ($row->status_name == 'OK' ? anchor('', 'assign', 'title="Assign person" class="btnAssign" id="'.'usbheadset_'.$row->usb_headset_id.'"') : NULL);
			} else {
				$column3 = $row->cubicle_id != 0 ? anchor('cubicle/view/'.$row->cubicle_id, $this->get_cub_name($row->cubicle_id)) : ($row->status_name == 'OK' ? anchor('', 'assign', 'title="Assign cubicle" class="btnAssign" id="'.$device_type.'_'.$row->$id.'"') : NULL);
			}
			
			$this->CI->table->add_row(
				anchor($device_type.'/view/'.$row->$id, $row->name), 
				$row->status_name, 
				$column3
			);
		}
		
		//generate table
		echo $this->CI->table->generate();

		//generate dialog popup
		$output = array();
		$locations = $device_type == 'usb_headset' ? $this->get_avail_person() : $this->get_avail_cub($device_type);
		foreach ($locations->result() as $location)
		{
			$location_id = $device_type == 'usb_headset' ? $location->id : $location->cubicle_id;
			$location_name = $device_type == 'usb_headset' ? $location->first_name . ' ' . $location->last_name : $location->name;
			
			$output[$location_id] = $location_name;
		}
		echo 
		'
			<div id="dialog-form" title="Assign item">
				<form>
					<table>
						<tr>
							<td>Location</td>
							<td>'.form_dropdown('location', $output, NULL, 'id = "location" class="ui-widget-content ui-corner-all combobox"').'</td>
						</tr>
					</table>
				</form>
			</div>
		';
	}
	
	private function get_cub_name($cub_id)
	{
		//skip if ZERO
		if ($cub_id == 0)
			return FALSE;
		
		//query to get the name of the cubicle
		$this->CI->db->select('name');
		$query = $this->CI->db->get_where('nshis_cubicles', array('cubicle_id' => $cub_id));
		
		if ($query->num_rows() > 0)
		{
			$info = $query->row_array();
			
			//return the name only
			return $info['name'];
		} else {
			return FALSE;
		}
	}
	
	private function get_avail_cub($device_type)
	{
		$query = $this->CI->db->get_where('nshis_cubicles', array($device_type => 0));
		
		return $query;
	}
	
	private function get_person_name($user_id)
	{
		//skip if ZERO
		if ($user_id == 0)
			return FALSE;
		
		//query to get the name of the pereson
		$this->CI->db->select('first_name, last_name');
		$query = $this->CI->db->get_where('nshis_people', array('id' => $user_id));
		
		if ($query->num_rows() > 0)
		{
			$info = $query->row_array();
			
			//return the name only
			return $info['first_name'] . ' ' . $info['last_name'];
		} else {
			return FALSE;
		}
	}
	
	private function get_avail_person()
	{
		$query = $this->CI->db->get_where('nshis_people', array('flag_usb_headset' => 0));
		
		return $query;
	}
	
}