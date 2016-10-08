
<?php 
foreach($list->result() as $v){
?>
<div class="box-body no-padding">
                  <table class="table table-condensed">
                    <tbody><tr>
                      <th></th>
                      <th></th>
                    </tr>
                    <tr>
                      <td><strong>Username</strong><td> :</td></td>
                      <td>
						<?php echo $v->username;?>
                      </td>
                    </tr>
                    <tr>
                      <td><strong>Nama </strong><td> :</td></td>
                      <td>
						<?php echo $v->name;?>
                      </td>
                    </tr>
                    <tr>
                      <td><strong>Email </strong><td> :</td></td>
                      <td>					  
						<?php echo $v->email;?>
                      </td>
                    </tr>
                    <tr>
                      <td><strong>Alamat </strong><td> :</td></td>
                      <td>
						<?php echo $v->address;?>
                      </td>
                    </tr>
                    <tr>
                      <td><strong>phone </strong><td> :</td></td>
                      <td>
						<?php echo $v->phone;?>
                      </td>
                    </tr>
                  </tbody></table>
                </div>
<?php
		}
?>
<?php
/* End of file list_tugas_detail.php */
/* Location: ./application/views/list_tugas_detail.php */
?>