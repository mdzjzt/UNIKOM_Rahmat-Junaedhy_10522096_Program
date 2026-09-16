<?php if($blacklistdata): ?>
	<legend>Detail</legend>
	<table class="table table-bordered table-striped" id="spesifikasi_blacklist" width="80%">
	  <thead>
		<tr>
		  <th style="width:50px">No</th>
		  <th>Alasan</th>
		</tr>
	  </thead>
	  <tbody>
		<?php
			if(!empty($blacklistdata)):
			  $no = 1;
			  
			  foreach($blacklistdata->result() as $db):
				  ?>
				  <tr>
					  <td><?php echo $no++ ?></td>
					  <td>
						  <?php echo $db->deskripsi ?>
					  </td>
				  </tr>
		<?php endforeach; 
			endif; ?>
		
	  </tbody>
	</table>  
<?php else: ?>
	<p class="text-center"> Tidak ada spesifikasi untuk barang ini 
<?php endif; ?>