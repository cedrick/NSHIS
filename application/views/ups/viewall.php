					<div class="section width500" >
						<div class="sectionHeader">View All <?php echo strtoupper($this->router->fetch_class());?></div>
						<div class="sectionBody">
							<?php 
								$this->deviceaction->view_all();
							?>
						</div>
					</div>