					<?php 
						$this->Stats_model->hardware_summary();
					?>
					<div class="section width700">
						<div class="sectionHeader">Recent Logs</div>
						<div class="sectionBody">
						<?php
						//get parent class
						$class = $this->router->fetch_class();
						//generate id format
						$id = $this->router->fetch_class().'_id';
						//generate logs.
						$this->devicelog->generate_logs('', $class);
						?>
						</div>
					</div>
