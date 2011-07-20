<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class is use to insert logs on the device. It also use to generate
 * HTML table which contains logs for a specific device
 *
 * @author ambet
 *
 */
class Devicelog {
	public $CI;
 	public $device_id;
 	public $device_type;
 	public $date_filter;
 	public $filter_userid;
	
	// --------------------------------------------------------------------
	
	/**
	 * Constructor. Instantiate CI to load database class and table library.
	 * It also create the defualt template for HTML table.
	 * 
	 */
	public function __construct()
	{
		$this->CI =& get_instance();

		$this->CI->load->database();

		$this->CI->load->library('table');

		//set table template
		$tmpl = array (
			'table_open' => '<table width="100%" border="0" cellpadding="10" cellspacing="3" id="latestStatusTable">',
			'heading_row_start' => '<tr class="latestStatusTableHeader">',
			'row_start'           => '<tr style="background-color:#EFEFEF">',
			'row_alt_start'       => '<tr style="background-color:WHITE">'
			);
			$this->CI->table->set_template($tmpl);
	}
	
	// --------------------------------------------------------------------

	/**
	 * Get logs for the given parameters
	 * 
	 * @param	string	unique device id
	 * @param 	string	type of device
	 */
	function generate_logs($device_id, $device_type, $date_filter = NULL, $params = NULL)
	{
		$this->device_id = $device_type == 'stats' || $device_type == 'date' ? 0 : $device_id;
		$this->device_type = $device_type;
		$this->date_filter = $date_filter;
		
		$this->CI->db->select('*, DATE_FORMAT(nshis_logs.cdate, "%M %e, %Y %l:%i %p") as log_date', FALSE);
		$this->CI->db->from('nshis_logs');
		$this->CI->db->join('nshis_users', 'nshis_logs.user_id = nshis_users.ID');
		
		//if something were passed on params
		if ($params != NULL) {
			$this->CI->db->where($params);
			$this->filter_userid = $params['user_id'];
		}
		
		//no condition if it was requested by stats controller and limit the result to 50.. VIEW ALL LOGS
		if ($device_type != 'stats' and $device_type != 'date') {
			if ($device_type == 'cubicle') {
				$this->CI->db->where('(nshis_logs.cubicle_id = '.$device_id.' OR nshis_logs.swap_cubicle_id = '.$device_id.')');
				//$this->CI->db->or_where('nshis_logs.swap_cubicle_id', $device_id);
			}
			else {
				$this->CI->db->where(array('nshis_logs.device_id' => $device_id,'nshis_logs.device' => $device_type));
				$this->CI->db->or_where('nshis_logs.swap_device_id = '.$device_id.' AND nshis_logs.device = \''.$device_type.'\'');
			}
			//$device_type == 'cubicle' ? $this->CI->db->where('nshis_logs.cubicle_id', $device_id) : $this->CI->db->where(array('nshis_logs.device_id' => $device_id,'nshis_logs.device' => $device_type));
			//search also on swap logs
			//$device_type == 'cubicle' ? $this->CI->db->or_where('nshis_logs.swap_cubicle_id', $device_id) : $this->CI->db->or_where('nshis_logs.swap_device_id = '.$device_id.' AND nshis_logs.device = \''.$device_type.'\'');
		}
		elseif ($device_type == 'date') {
			$this->CI->db->where("date_format(nshis_logs.cdate, '%m/%d/%Y') = '" . $date_filter . "'");
		}
		else {
			$this->CI->db->limit(50);
		}

		$this->CI->db->order_by('nshis_logs.log_id', 'DESC');

		$query = $this->CI->db->get();

		$this->generate_table($query);
	}
	
	// --------------------------------------------------------------------

	/**
	 * Function to generate table log
	 * @param	sql result	
	 */
	private function generate_table($query_result)
	{
		$this->CI->table->set_heading('Trace ID', 'Description', 'Date');
		
		//javascript
		echo '
		<script type="text/javascript">
			$(document).ready(function() {
				var base_url = "'.base_url().'";
				
				$(".textarea-log").autoGrow();
				$(".hidden_first").hide();
				$(".hidden_first").blur(function() {
				  $(this).hide();
				});
	
				$(".comment_btn").click(function() {
					$("#ta_" + $(this).attr("id")).show();
					$("#ta_" + $(this).attr("id")).focus();
					return false;
				});
	
				$(".textarea-log").keypress(
					function(event) {
						if (event.keyCode == 13 && event.shiftKey) {
							var content = this.value;
							var caret = getCaret(this);
							this.value = content.substring(0, caret)
									+ "\n"
									+ content.substring(carent,
											content.length - 1);
							event.stopPropagation();

						} else if (event.keyCode == 13 && $.trim($(this).val()).length > 0) {
							$(this).attr("disabled", true);
							var logid = $(this).attr("id");
							mytext = $(this).val().replace(/(\r\n)|(\n)/g,"<br />"); 
							$.post(base_url + "ajax/comment_add", {
								log_id : logid.substring(3),
								comment : mytext
							}, function() {
								window.location.reload(true);
							});
						} else if (event.keyCode == 13
								&& $.trim($(this).val().length == 0)) {
							return false;
						}
					});
				
				function getCaret(el) {
					if (el.selectionStart) {
						return el.selectionStart;
					} else if (document.selection) {
						el.focus();
	
						var r = document.selection.createRange();
						if (r == null) {
							return 0;
						}
	
						var re = el.createTextRange(), rc = re.duplicate();
						re.moveToBookmark(r.getBookmark());
						rc.setEndPoint("EndToStart", re);
						
						return rc.text.length;
					}
					return 0;
				}
				
				$("#log_filter_user").change(function(){
					var f_user = 0;
					
					f_user = $(this).val();
					
					 $("#log_content#").block({ 
		                message: "Please wait.....", 
		                css: { 
				            border: "none", 
				            padding: "15px", 
				            backgroundColor: "#000", 
				            "-webkit-border-radius": "10px", 
				            "-moz-border-radius": "10px", 
				            opacity: .5, 
				            color: "#fff"
				        }
		            }); 
		            
					$.post(base_url + "ajax/comment_filter", {
						device_id : '.$this->device_id.',
						device_type : "'.$this->device_type.'",
						date_filter : "'.$this->date_filter.'",
						user_filter : f_user
					}, function(data) {
						//alert(data);
						$("#log_content").replaceWith(data);
						//window.location.reload(true);
					});
				});
				
				$("#f_toggle").click(function(){
					$("#log_filter").animate({height: "toggle"});
					$("#f_toggle p").toggle();
				});
			});
		</script>';
		
		//parent wrapper
		echo '<div id="log_content">';
		
		//get users for filter dropdown
		$this->CI->db->order_by('username');
		$users = $this->CI->db->get('nshis_users');
		
		$user_options = array('' => '-User-');
		foreach ($users->result() as $user) {
			$array = array($user->ID => $user->username);
			$user_options = $user_options + $array;
		}
		
		echo '<div id="log_filter"><ul><li>Filter: '.form_dropdown('log_filter_user', $user_options, $this->filter_userid, 'id="log_filter_user"').'</li></ul></div>';
		echo '<div id="f_toggle">
				<p style="display: none">Show Filter +</p>
				<p>Hide Filter -</p>
			</div>';
		
		foreach ($query_result->result() as $row)
		{
			//format operation to be display
			if ($row->process == 'add') {
				$operation = 'add new';
			}
			elseif ($row->process == 'comment') {
				$operation = 'add comment on';
			}
			else {
				$operation = $row->process;
			}
				
			//format preposition to be display
			if ($row->device == 'cubicle' || $row->process == 'add' || $row->process == 'edit') {
				//ignore preposition where delete cubicle
				$preposition = '';
			} 
			elseif ($row->process == 'swap' && $row->swap_cubicle_id != '') {
				$preposition = 'with';
			}
			else {
				$preposition = ($row->process == 'assign' || $row->process == 'transfer') ? 'to' : ($row->process == 'pullout' ? 'from' : 'from ' . '<strong>'.str_replace('to', '</strong>to<strong>', $row->status_change).'</strong>');
			}
				
			//display cubicle or assigned USB headset if applicable.
			$cubicle = $row->cubicle_id != 0 ? anchor('cubicle/view/'.$row->cubicle_id,$row->cubicle_name) : ($row->usb_headset_assignment != NULL ? '<strong>'.$row->usb_headset_assignment.'</strong>' : NULL);
			
			//remove hyperlink if operation was DELETE
			$device = $row->process == 'delete' ? '<strong>'.$row->device.' ['.$row->device_name.']</strong>' : anchor($row->device.'/view/'.$row->device_id,$row->device.' ['.$row->device_name.'] ');
			
            //log wrapper
            echo '<div class="log-wrapper">';
			echo '<div class="log_header">';
			echo '
				<ul>
					<li>';
			if ($row->process == 'swap' && $row->swap_cubicle_id != '') {
				echo '<strong>'.strtoupper($row->username).'</strong>'.' '.$operation.' '.anchor($row->device.'/view/'.$row->device_id, $row->device.' ['.$row->device_name.']').'/'.anchor('cubicle/view/'.$row->cubicle_id, '['.$row->cubicle_name.']').' '.$preposition.' '.anchor($row->device.'/view/'.$row->swap_device_id, $row->device.' ['.$this->get_device_name($row->swap_device_id, $row->device).']').'/'.anchor('cubicle/view/'.$row->swap_cubicle_id, '['.$this->get_device_name($row->swap_cubicle_id, 'cubicle').']');
			} 
			else {
				echo '<strong>'.strtoupper($row->username).'</strong>'.' '.$operation.' '.$device.' '.$preposition.' '.$cubicle;
			}
			
			echo '
					</li>
					<li class="isDate">'.$row->log_date.' | <a href="#" class="comment_btn" id="'.$row->log_id.'">Comment</a>'.'</li>
				</ul>
				';
			
			echo '</div>';
			
			//comments wrapper
			echo '<div class="log_comments"><ul>';
			
			//get comments per log id
			
			$this->CI->db->select('*, DATE_FORMAT(nshis_comments.cdate, "%M %e, %Y %l:%i %p") as comment_date');
			$this->CI->db->from('nshis_comments');
			$this->CI->db->join('nshis_users', 'nshis_comments.user_id = nshis_users.ID');
			$this->CI->db->where('nshis_comments.log_id', $row->log_id);
			$this->CI->db->order_by('nshis_comments.comment_id', 'ASC');
			$query_comment = $this->CI->db->get();
			
			foreach ($query_comment->result() as $row_comment)
			{
				echo '<li><ul class="comments">';
				echo '<li><strong>'.strtoupper($row_comment->username).'</strong>: '.$row_comment->comment.'</li>';
				echo '<li class="isDate">'.$row_comment->comment_date.'</li>';
				echo '</ul></li>';
			}
			echo '<li id="li_'.$row->log_id.'" ><ul class="comments"><textarea cols="115" id="ta_'.$row->log_id.'" class="hidden_first textarea-log"></textarea></ul></li></ul></div></div>';
		}
		echo '</div>';

	}
	
	// --------------------------------------------------------------------

	/**
	 * Insert log for device from given parameters
	 * @param	integer	user id number
	 * @param	integer	device id
	 * @param	string	type of device
	 * @param 	string	what action did the user do
	 * @param 	integer	cubicle id
	 * @param 	integer	usb headset id
	 */
	function insert_log($user_id, $device_id, $device, $process, $cubicle_id = 0, $ex_info = NULL)
	{
		$cubicle_name = $cubicle_id != 0 ? $this->get_device_name($cubicle_id, 'cubicle') : NULL;
		
		$data = array(
			'user_id'	=>	$user_id,
			'process'	=>	$process,
			'device_id'	=>	$device_id,
			'device'	=>	$device,
			'device_name'	=>	$this->get_device_name($device_id, $device),
			'cubicle_id' =>	$cubicle_id,
			'cubicle_name' => $cubicle_name
			//'usb_headset_assignment' => $usb_headset_assigned
		);
		
		if (is_array($ex_info)) {
			$data = array_merge($data, $ex_info);
		} 
		else {
			$data = $process == 'update status' ? array_merge($data, array('status_change' => $ex_info)) : array_merge($data, array('usb_headset_assignment' => $ex_info));
		}
		
		//$data = is_array($ex_info) ? array_merge($data, $ex_info) : NULL;

		$this->CI->db->set('cdate', 'NOW()', FALSE);

		$this->CI->db->insert('nshis_logs', $data);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Just to get what name of the device
	 * @param	integer	device id
	 * @param	string	type of device
	 * @return 	boolean	
	 */
	private function get_device_name($device_id, $device_type)
	{
		$query = $this->CI->db->get_where('nshis_'.$device_type.'s', array($device_type.'_id' => $device_id));
		
		if ($query->num_rows() > 0) {
			$info = $query->row();
			return $info->name;
		}
		else {
			return FALSE;
		}
	}

}

/* End of file Devicelog.php */