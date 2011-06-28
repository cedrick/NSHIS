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
	function generate_logs($device_id, $device_type)
	{
		$this->CI->db->select('*, nshis_logs.cdate as log_date');
		$this->CI->db->from('nshis_logs');
		$this->CI->db->join('nshis_users', 'nshis_logs.user_id = nshis_users.ID');
		
		//no condition if it was requested by stats controller and limit the result to 100.. VIEW ALL LOGS
		if ($device_type != 'stats') {
			$device_type == 'cubicle' ? $this->CI->db->where('nshis_logs.cubicle_id', $device_id) : $this->CI->db->where(array('nshis_logs.device_id' => $device_id,'nshis_logs.device' => $device_type));
		}
		else {
			$this->CI->db->limit(100);
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
			$preposition = ($row->process == 'assign' || $row->process == 'swap' || $row->process == 'transfer') ? 'to' : ($row->process == 'pullout' ? 'from' : '');
				
			//display cubicle if applicable.
			$cubicle = $row->cubicle_id != 0 ? anchor('cubicle/view/'.$row->cubicle_id,$row->cubicle_name) : NULL;
			
			//remove hyperlink if operation was DELETE
			$device = $row->process == 'delete' ? '<strong>'.$row->device.' ['.$row->device_name.']<strong>' : anchor($row->device.'/view/'.$row->device_id,$row->device.' ['.$row->device_name.'] ');
			
			$this->CI->table->add_row($row->log_id, '<strong>'.$row->username.'</strong>'.' '.$operation.' '.$device.' '.$preposition.' '.$cubicle, $row->log_date);
		}
		echo $this->CI->table->generate();

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
	function insert_log($user_id, $device_id, $device, $process, $cubicle_id = 0, $usb_headset_assigned = NULL)
	{
		$cubicle_name = $cubicle_id != 0 ? $this->get_device_name($cubicle_id, 'cubicle') : NULL;

		$data = array(
			'user_id'	=>	$user_id,
			'process'	=>	$process,
			'device_id'	=>	$device_id,
			'device'	=>	$device,
			'device_name'	=>	$this->get_device_name($device_id, $device),
			'cubicle_id' =>	$cubicle_id,
			'cubicle_name' => $cubicle_name,
			'usb_headset_assignment' => $usb_headset_assigned
		);

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