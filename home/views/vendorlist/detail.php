<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
        <i class="fa fa-times"></i>
    </button>
    <h6 class="modal-title" id="myModalLabel">
        <span class="widget-icon"> <i class="fa fa-edit"></i> </span> DETAIL
    </h6>
</div>
<div class="modal-body">

    <div class="col-sm-12">
        <ul id="tab-menu" class="nav nav-tabs">
            <li class="active">
                <a href="#tab1" data-toggle="tab">Profil</a>
            </li> 
            <li>
                <a href="#tab2" data-toggle="tab">Dokumen Legal</a>
            </li>
            <li>
                <a href="#tab3" data-toggle="tab">Jenis Usaha</a>
            </li>
            <li>
                <a href="#tab4" data-toggle="tab">Daftar Project</a>
            </li>
			<li>
                <a href="#tab5" data-toggle="tab">History Blacklist</a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="tab1">
                <br>
                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget jarviswidget-color-greenLight jarviswidget-sortable" id="wid-id-3" data-widget-editbutton="false" role="widget">

                    <!-- widget div-->
                    <div role="content">

                        <!-- widget content -->
                        <div class="widget-body no-padding">

                            <div class="table-responsive">

                                <table class="table table-striped">
                                    <tbody>
                                        <tr>
                                            <td class="col-md-3">Jenis</td>
                                            <td ><?php echo !empty($data_edit->jenis) ? $data_edit->jenis : '' ?></td>
                                        </tr>
                                        <tr>
                                            <td>Nama</td>
                                            <td><?php echo !empty($data_edit->nama_perusahaan) ? $data_edit->nama_perusahaan : '' ?></td>
                                        </tr>
                                        <tr>
                                            <td>Pimpinan</td>
                                            <td><?php echo !empty($data_edit->nama_pimpinan) ? $data_edit->nama_pimpinan : '' ?></td>
                                        </tr>
                                        <tr>
                                            <td>NPWP</td>
                                            <td><?php echo !empty($data_edit->npwp) ? $data_edit->npwp : '' ?></td>
                                        </tr>
                                        <tr>
                                            <td>No Rek</td>
                                            <td>
                                                   <?php echo !empty($data_edit->norek) ? $data_edit->norek : '' ?>                                         
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Direksi</td>
                                            <td>
                                                <div class="table-responsive">
                                                    <table class="table table-striped">
                                                        <tbody>
                                                            <tr>
                                                                <td class="col-md-3">Nama</td>
                                                                <td >Jabatan</td>
                                                            </tr>
                                                            <?php
                                                            if (!empty($decode_direksi)) {
                                                                foreach ($decode_direksi as $row_dir) {
                                                                    $nama_direksi = $row_dir->nama_direksi;
                                                                    $jabatan_direksi = $row_dir->jabatan_direksi;
                                                                    ?>                                                    
                                                                    <tr>
                                                                        <td ><?php echo $nama_direksi ?></td>
                                                                        <td ><?php echo $jabatan_direksi ?></td>
                                                                    </tr>
                                                                <?php }
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>

                                                </div>                                                
                                                
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Pemilik saham</td>
                                            <td>
                                                <div class="table-responsive">
                                                    <table class="table table-striped">
                                                        <tbody>
                                                            <tr>
                                                                <td class="col-md-3">Nama</td>
                                                                <td >Saham (%)</td>
                                                            </tr>
                                                            <?php
                                                            if (!empty($decode_saham)) {
                                                                foreach ($decode_saham as $row_saham) {
                                                                    $nama_saham = $row_saham->nama_saham;
                                                                    $persen_saham = $row_saham->persen_saham;
                                                                    ?>                                                            
                                                            <tr>
                                                                <td ><?php echo $nama_saham ?></td>
                                                                <td ><?php echo $persen_saham ?></td>
                                                            </tr>
                                                            <?php } } ?>
                                                        </tbody>
                                                    </table>

                                                </div>                                                
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Alamat</td>
                                            <td><?php echo !empty($data_edit->alamat) ? $data_edit->alamat : '' ?></td>
                                        </tr>
                                        <tr>
                                            <td>Provinsi</td>
                                            <td><?php echo !empty($data_edit->provinsi_name) ? $data_edit->provinsi_name : '' ?></td>
                                        </tr>
                                        <tr>
                                            <td>Kab./Kota</td>
                                            <td><?php echo !empty($data_edit->kotamadya_name) ? $data_edit->kotamadya_name : '' ?></td>
                                        </tr>

                                    </tbody>
                                </table>

                            </div>
                        </div>
                        <!-- end widget content -->

                    </div>
                    <!-- end widget div -->

                </div>
                <!-- end widget -->
            </div>

            <div class="tab-pane" id="tab2">
                <br>
                <div class="table-responsive">

                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <td class="col-md-3">Akte Notaris</td>
                                <td ><?php echo !empty($data_edit->akte) ? $data_edit->akte : '' ?></td>
                            </tr>
                            <tr>
                                <td>SIUP</td>
                                <td>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <tbody>
                                                <tr>
                                                    <td class="col-md-3">Nomor</td>
                                                    <td >Pejabat Pengesah</td>
                                                    <td >Tanggal Dikeluarkan</td>
                                                    <td >Tanggal Kadaluarsa</td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo !empty($data_edit->siup_nomor) ? $data_edit->siup_nomor : '' ?></td>
                                                    <td><?php echo !empty($data_edit->siup_pejabat) ? $data_edit->siup_pejabat : '' ?></td>
                                                    <?php 
                                                        $siup_dikeluarkan = date("d-M-Y", strtotime($data_edit->siup_dikeluarkan)); 
                                                        $siup_kadaluarsa = date("d-M-Y", strtotime($data_edit->siup_kadaluarsa)); 

                                                    ?>
                                                    <td>
                                                        <?php echo !empty($siup_dikeluarkan) ? $siup_dikeluarkan : '' ?></td>
                                                    <td><?php echo !empty($siup_kadaluarsa) ? $siup_kadaluarsa : '' ?></td>
                                                    
                                                </tr>
<?php 
                      if(!empty($data_edit->dok_siup) && $data_edit->dok_siup !== '[]'){
                        $no = 1;
                        $dokumen_siup = json_decode($data_edit->dok_siup);
                        foreach($dokumen_siup as $dt_siup):
                        endforeach;
                      
?>                                              <tr>
    <td><a target="_blank" href="<?php echo base_url() ?>uploads/vendor/<?php echo $dt_siup->filename ?>">View file </a></td>
                                                </tr>  
<?php } ?>                                                
                                            </tbody>
                                        </table>

                                    </div>                                
                                </td>
                            </tr>
                            <tr>
                                <td>IDP</td>
                                <td>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <tbody>
                                                <tr>
                                                    <td class="col-md-3">Nomor</td>
                                                    <td >Pejabat Pengesah</td>
                                                    <td >Tanggal Dikeluarkan</td>
                                                    <td >Tanggal Kadaluarsa</td>
                                                </tr>
                                                <?php
                                                if (!empty($decode_idp)) {
                                                    foreach ($decode_idp as $row_idp) {
                                                        $nomor_idp = $row_idp['nomor'];
                                                        $nama_pejabat_idp = $row_idp['pejabat'];

                                                        $tgl_dikeluarkan_idp = date("d-M-Y", strtotime($row_idp['tgl_dikeluarkan']));
                                                        $tgl_kadaluarsa_idp = date("d-M-Y", strtotime($row_idp['tgl_kadaluarsa']));
                                                                                                                
                                                    }
                                                }
                                                ?>                                                
                                                <tr>
                                                    <td ><?php echo !empty($nomor_idp) ? $nomor_idp : '' ?></td>
                                                    <td ><?php echo !empty($nama_pejabat_idp) ? $nama_pejabat_idp : '' ?></td>
                                                    <td ><?php echo !empty($tgl_dikeluarkan_idp) ? $tgl_dikeluarkan_idp : '' ?></td>
                                                    <td ><?php echo !empty($tgl_kadaluarsa_idp) ? $tgl_kadaluarsa_idp : '' ?></td>
                                                </tr>
<?php 
                      if(!empty($data_edit->dok_idp) && $data_edit->dok_idp !== '[]'){
                        $no = 1;
                        $dokumen_idp = json_decode($data_edit->dok_idp);
                        foreach($dokumen_idp as $dt_idp):
                        endforeach;
?>                        
                                                <tr>
    <td><a target="_blank" href="<?php echo base_url() ?>uploads/vendor/<?php echo $dt_idp->filename ?>">View file </a></td>
                                                </tr>
<?php
    }
?>               
                                            </tbody>
                                        </table>

                                    </div>                                       
                                </td>
                            </tr>
                            <tr>
                                <td>SITU</td>
                                <td>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <tbody>
                                                <tr>
                                                    <td class="col-md-3">Nomor</td>
                                                    <td >Pejabat Pengesah</td>
                                                    <td >Tanggal Dikeluarkan</td>
                                                    <td >Tanggal Kadaluarsa</td>
                                                </tr>
                                                <?php
                                                if (!empty($decode_situ)) {
                                                    foreach ($decode_situ as $row_situ) {
                                                        $nomor_situ = $row_situ['nomor'];
                                                        $nama_pejabat_situ = $row_situ['pejabat'];

                                                        $tgl_dikeluarkan_situ = date("d-M-Y", strtotime($row_situ['tgl_dikeluarkan']));
                                                        $tgl_kadaluarsa_situ = date("d-M-Y", strtotime($row_situ['tgl_kadaluarsa']));
                                                        
                                                    }
                                                }
                                                ?> 
                                                <tr>
                                                    <td ><?php echo !empty($nomor_situ) ? $nomor_situ : '' ?></td>
                                                    <td ><?php echo !empty($nama_pejabat_situ) ? $nama_pejabat_situ : '' ?></td>
                                                    <td ><?php echo !empty($tgl_dikeluarkan_situ) ? $tgl_dikeluarkan_situ : '' ?></td>
                                                    <td ><?php echo !empty($tgl_kadaluarsa_situ) ? $tgl_kadaluarsa_situ : '' ?></td>
                                                </tr>  
<?php 
                      if(!empty($data_edit->dok_situ) && $data_edit->dok_situ !== '[]'){
                        $no = 1;
                        $dokumen_situ = json_decode($data_edit->dok_situ);
                        foreach($dokumen_situ as $dt_situ):
                        endforeach;
                      
?>                                              <tr>
    <td><a target="_blank" href="<?php echo base_url() ?>uploads/vendor/<?php echo $dt_situ->filename ?>">View file </a></td>
                                                </tr>
<?php } ?>
                                            </tbody>
                                        </table>

                                    </div>                                       
                                </td>
                            </tr>
                            <tr>
                                <td>Data Upload Dokumen</td>
                                <td>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <tbody>
                                                <tr>
                                                    <td class="col-md-3">Nama Dokuemen</td>
                                                    <td>File</td>
                                                </tr>
                                                       <?php
                                                        if (!empty($decode_dokumen)) {
                                                            foreach ($decode_dokumen as $row_dok) {
                                                                $deskripsi = $row_dok['deskripsi'];
                                                                $file = $row_dok['file'];
                                                                $filename = $row_dok['filename'];
                                                                ?>                                                
                                                            <tr>
                                                                <td class="col-md-3"><?php echo $deskripsi ?></td>
                                                                <td><a target="_blank" href="<?php base_url() ?><?php echo $file ?>"><?php echo $filename ?></a></td>
                                                            </tr>
                                                            <?php }} ?>
                                            </tbody>
                                        </table>

                                    </div>   
                                </td>
                            </tr>


                        </tbody>
                    </table>

                </div>
            </div>

            <div class="tab-pane" id="tab3">
                <br>
                <div class="table-responsive">

                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <td class="col-md-3">Bidang</td>
                                <td >Sub Bidang</td>
                            </tr>
                            <tr>
                                <td class="col-md-3"><?php echo !empty($data_edit->provinsi_name) ? $data_edit->provinsi_name : '' ?></td>
                                <td ><?php echo !empty($data_edit->kotamadya_name) ? $data_edit->kotamadya_name : '' ?></td>
                            </tr>                            
                            
                            
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="tab-pane" id="tab4">
                <br>
                <!--<div class="table-responsive">//-->
                    <table id="dt_project" 
                           class="table table-striped table-bordered table-hover" 
                           width="100%" style="margin-top: 0 !important;"
                           data-source="<?php echo base_url() . $_modul . '/load_project/' . $id; ?>"
                           data-filter="#filter_table_detail">
                        <thead>                         
                            <tr>
                                <th class="text-align-center">NO</th>
                                <th>NAMA PERUSAHAAN</th>
                                <th>TANGGAL</th>
                                <th>NO SPK</th>
                                <th>NAMA PROJECT</th>
                                <th>RATING</th>
                            </tr>
                        </thead>
                    </table>
                <!--</div>//-->
            </div>
			
			<div class="tab-pane" id="tab5">
                <br>
                <div class="table-responsive">
					<table class="table table-bordered" id="dt_blacklist">
                        <thead>                         
                            <tr>
                                <th class="text-align-center">#</th>
                                <th class="text-align-center">NO</th>
                                <th class="text-align-center">Nama Perusahaan</th>
                                <th>Tanggal Blacklist</th>
                                <th>Akhir Blacklist</th>
                            </tr>
                        </thead>
						<tbody>
							<?php
								if(!empty($datablacklist)):
								  $no = 1;
								  
								  foreach($datablacklist->result() as $db):
									  ?>
									  <tr>
										  <td>
											  <a href="javascript:;" class="btn btn-success btn-xs" data-row-source="<?php echo $_modul.'/row_blacklist/' .$db->id.'/'.$db->id_blacklist ?>" onClick="myTable.rowDetail(this)"><i class="fa fa-plus-square-o"></i></a>
										  </td>
										  <td><?php echo $no++ ?></td>
										  <td>
											  <?php echo $db->nama_perusahaan ?>
										  </td>
										  <td>
											  <?php echo $db->tgl_blacklist ?>
										  </td>
										  <td>
											  <?php echo $db->tgl_akhir_blacklist ?>
										  </td>
									  </tr>
							<?php endforeach; 
								endif; ?>
					  </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="modal-footer">
    <?php
    echo anchor(NULL, '<span class="btn-label"><i class="glyphicon glyphicon-chevron-left"></i></span> Back', array(
        'id' => 'mybutton-add',
        'class' => 'btn btn-labeled btn-default margin-right-2',
        'data-dismiss' => 'modal'
    ));
    ?>
</div>
<script type="text/javascript">
	pageSetUp();
    my_data_table.init('#dt_project');

    
	
    // pageSetUp();
    // my_form.init();
    // my_data_table.init('#dt_detail');
</script>
