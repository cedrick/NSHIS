<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class is use to manage status of the devices. 
 * 
 * @author ambet
 *
 */
class Devicestatus {
	public $CI;

	// --------------------------------------------------------------------
	
	/**
	 * Constructor. Instantiate CI to load database class.
	 * 
	 */
	public function __construct()
	{
		$this->CI =& get_instance();

		$this->CI->load->database();
	}
	
	// --------------------------------------------------------------------
	
	function get_status($item, $item_id)
	{
		$this->CI->db->select('*');
		$this->CI->db->from('nshis_'.$item.'s');
		$this->CI->db->join('nshis_device_statuses', 'nshis_'.$item.'s.status = nshis_device_statuses.status_id');
		$this->CI->db->where('nshis_'.$item.'s.'.$item.'_id', $item_id);
		$query = $this->CI->db->get();
		
		$result = $query->row();
		
		if ($result->flag_assigned == 0) {
			$statuses = $this->get_statuses();
			$output = array();
			foreach ($statuses as $status) {
				$output[$status['status_id']] = $status['status_name'];
			}
			
			$form = '
				<div id="change-status">(change)</div>
				<div id="dialog-form" title="Change item status">
					<p class="validateTips"><strong>Comment field is required</strong></p>
					<form>
						<table>
							<tr>
								<td>Status</td>
								<td>'.form_dropdown('statuses', $output, $result->status_id, 'id = "status" class="ui-widget-content ui-corner-all"').'</td>
							</tr>
							<tr>
								<td>Comment</td>
								<td><textarea rows="8" cols="32" id="status-comment"></textarea></td>
							</tr>
						</table>
					</form>
				</div>
				<script type="text/javascript">
					$(document).ready(function() {
						var base_url = "'.base_url().'";
						var myitem = "'.$item.'";
						var myitem_id = "'.$item_id.'";
						
						var status_comment = $( "#status-comment" ),
							allFields = $( [] ).add( status_comment ),
							tips = $( ".validateTips" );
				
						function updateTips( t ) {
							tips
								.text( t )
								.addClass( "ui-state-highlight" );
							setTimeout(function() {
								tips.removeClass( "ui-state-highlight", 1500 );
							}, 500 );
						}
				
						function checkLength( o, n, min, max ) {
							if ( $.trim(o.val()).length > max || $.trim(o.val()).length < min ) {
								o.addClass( "ui-state-error" );
								updateTips( "Length of " + n + " must be between " +
									min + " and " + max + "." );
								return false;
							} else {
								return true;
							}
						}
						
						$( "#dialog-form" ).dialog({
							autoOpen: false,
							height: 300,
							width: 350,
							modal: true,
							buttons: {
								"Change Status": function() {
									var bValid = true;
									allFields.removeClass( "ui-state-error" );
									if (checkLength(status_comment, "Comment", 2, 1000)) {
										$.post(base_url + "ajax/status_change", {
											item : myitem,
											item_id : myitem_id,
											status : $( "#status" ).val(),
											status_comment : $( "#status-comment" ).val()
										}, function() {
											window.location.reload(true);
										});
									}
								},
								Cancel: function() {
									$( this ).dialog( "close" );
								}
							}
						});
						
						$( "#change-status" )
							.click(function() {
								$( "#dialog-form" ).dialog( "open" );
							});
					});
				</script>
			';
		}
		else {
			$form = NULL;
		}
			return '<div class="device-status status-'.$result->shorthand.'" style="float:left;">'.$result->status_name.'</div>'.$form;
	}
	
	// --------------------------------------------------------------------
	
	function get_statuses()
	{
		$this->CI->db->order_by('status_name');
		$query = $this->CI->db->get('nshis_device_statuses');
		
		return $query->result_array();
	}
	
	// --------------------------------------------------------------------
	
	function get_status_id($id)
	{
		$this->CI->db->order_by('status_name');
		$query = $this->CI->db->get_where('nshis_device_statuses', array('status_id' => $id));
		
		return $query->row_array();
	}
	
	// --------------------------------------------------------------------
	
	function current_status($item, $item_id)
	{
		$query = $this->CI->db->get_where('nshis_'.$item.'s', array($item.'_id' => $item_id));
		
		if ($query->num_rows() > 0) {
			$info = $query->row();
			return $this->get_status_id($info->status);
		}
		else {
			return FALSE;
		}
	}
	
	// --------------------------------------------------------------------
	
	function update_status($item, $item_id, $status)
	{
		$this->CI->db->where($item.'_id', $item_id);
		$update_status = $this->CI->db->update('nshis_'.$item.'s', array('status' => $status));
	}
	
	// --------------------------------------------------------------------
	
	function insert_status_log($item, $item_id, $status, $status_comment)
	{
	
	}
	
}