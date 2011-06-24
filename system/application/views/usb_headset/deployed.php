          <div class="section width500" >
            <div class="sectionHeader">View Available USB Headset</div>
            <div class="sectionBody">
              <table width="100%" border="0" cellpadding="0" id="latestStatusTable">
                <tr class="latestStatusTableHeader"><td>NAME</td><td>ASSIGNED PERSON</td><td></td></tr>
              <?php 
                if ($data)
                {
                  $ctr = 0;
                  foreach ($data->result() as $row)
                  {
                    if ($row->flag_assigned == 1)
                    {
                      if($ctr%2==0){
                        $color=" bgcolor='#d8ebeb'";
                      }else{
                        $color=" bgcolor='#FFFFFF'";
                      }
                      echo "<tr $color><td width=35%>";
                      echo anchor('usb_headset/view/'.$row->usb_headset_id,$row->name);
                      echo "</td><td width=40%>".$row->assigned_person."</td><td width=25%>".anchor('usb_headset/edit/'.$row->usb_headset_id,'edit')." | ".anchor('usb_headset/delete/'.$row->usb_headset_id,'delete')."</td></tr>";
                      $ctr ++;
                    }
                    else 
                    {
                      next($row);
                    }
                  }
                }
                else 
                {
                  echo "<tr><td>";
                  echo "No usb_headset added on the system.";
                  echo "</td></tr>";
                }
              ?>
              </table>
            </div>
          </div>