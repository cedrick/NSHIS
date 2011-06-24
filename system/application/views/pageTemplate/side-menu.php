					<div id="menu7">
						<a href='#'>QUICK LINKS</a><br /><br />
							<ul>
								<?php 
									if ($this->uri->segment(2) == 'view')
									{
										echo '<li>'.anchor($this->uri->segment(1).'/edit/'.$this->uri->segment(3), 'Edit').'</li>';
										echo '<li>'.anchor($this->uri->segment(1).'/comment/'.$this->uri->segment(3), 'Add Comment').'</li>';
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
										echo '<li>'.anchor($this->uri->segment(1).'/delete/'.$this->uri->segment(3), 'Delete').'</li>';
	//									echo '<li><a href="keyboard/comment/'.$this->uri->segment(3).'">Add Comments</a></li>';
									}
									
								?>
	<!--							<li><a href="addcontact.php">Add New Contact</a></li>-->
	<!--							<li><a href="search.php">Search Contact</a></li>-->
	<!--							<li><a href="task.php">Add New Task</a></li>-->
	<!--							<li><a href="manage.php">Manage Inputs</a></li>-->
							</ul>
					</div>