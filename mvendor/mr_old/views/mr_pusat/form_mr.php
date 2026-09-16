 <style type="text/css">
  .blue.btn {
      margin-bottom: 7px !important;

  }
  .form-horizontal .radio, .form-horizontal .checkbox, .form-horizontal .radio-inline, .form-horizontal .checkbox-inline {
   padding-top: 0px !important;
  }
  .entry:not(:first-of-type)
  {
      margin-top: 10px;
  }

  .glyphicon
  {
      font-size: 12px;
  }
  .dt-desc{
    text-align: left;
  }
  .input-group {
    width: 100%;
  }

  .form-control.barang_nama.tt-hint.tt-input {
      display: none;

  }
  .tt-input{
    background: white !important;
  }

  </style>
  <div class="container-fluid">
  <div class="portlet light">
      <div class="portlet-title">
          <div class="caption font-dark">
            <span class="caption-subject bold uppercase"><?php echo $page_title; ?></span>
            <span class="caption-helper"></span>
          </div>
              <?php
                echo anchor(NULL, '<i class="glyphicon glyphicon-chevron-left"></i> Kembali', 
                [
                    'class'   => 'btn btn-default margin-right-2 pull-right',
                    'onclick' => 'go_back()'
                ]);
                
               ?>
      </div>
     
          
      
      <div class="portlet-body">
          <?php
              $hidden_form = array('id' => !empty($id) ? $id : '');
              echo form_open_multipart($form_action, ['id' => 'finput', 'class' => 'form-horizontal'], $hidden_form);
          ?>

          <fieldset>
             
              <div class="form-group form-group-sm">
                  <?php echo form_hidden('id_project', !empty($id_project) ?$id_project : NULL, 'id = "id_project" class="id_project" ') ?>
                  <?php echo form_hidden('status_save', '', 'id = "status_save" class="status_save" ') ?>
                  <?php echo form_hidden('status_approve', '', 'id = "status_approve" class="status_approve" ') ?>
                  <?php echo form_hidden('id_kota', !empty($idkota) ? $idkota : NULL, 'id = "id_kota" class="id_kota" ') ?>
                  <?php echo form_hidden('kode_unik', !empty($kode_unik) ? $kode_unik : NULL, 'id ="kd_unik" ') ?>
                  <?php echo form_hidden('kode_unik_ho', !empty($kode_unik_ho) ? $kode_unik_ho : NULL, 'id ="kd_unik_ho" ') ?>
                  <?php echo form_hidden('type_transaksi', !empty($type_transaksi) ? $type_transaksi : NULL, 'id ="type_transaksi" ') ?>
                  <?php echo form_hidden('site_project', !empty($site_project) ? $site_project : NULL, 'id ="site_project" ') ?>
                   

                <label class="col-md-2 ">Kode Area</label>
                <div class="col-md-3">
                  <?php echo form_input('no_project',!empty($no_proyek) ?$no_proyek : NULL, 'class="form-control" readonly') ?>
                </div>

                <label class="col-md-3" style="text-align: right;">Nama Transaksi HO / Project</label>
                <div class="col-md-3">
                  <?php echo form_input('nama_project',!empty($nama_proyek) ? $nama_proyek : NULL, 'class="form-control" readonly') ?>
                </div>
              </div>

            <!--   <div class="form-group form-group-sm">
              
              </div>
 -->
              <div class="form-group form-group-sm">
                <label class="col-md-2 ">Kode MR</label>
                <div class="col-md-3">
                  <?php echo form_input('kode_mr',!empty($kode_mr) ? $kode_mr : NULL, 'class="form-control" id="kode_mr" readonly') ?>
                </div>
                <label class="col-md-3 " style="text-align: right;">Nama MR <sup>*</sup></label>
                <div class="col-md-3">
                  <?php echo form_input('nama_permintaan',!empty($nama_permintan) ? $nama_permintan : NULL, 'class="form-control" ') ?>
                </div>
                
              </div>

              <div class="form-group form-group-sm">
              <label class="col-md-2 ">Tanggal MR</label>
                <div class="col-md-3">
                <?php if ($roleId == 1) {

                      $disable= '';
                   
                  }else{
                     $disable= 'readonly';
                  }
                 ?>
                 
                 <div class='input-group date'>
                      <?php echo form_input('tanggal_pembuatan_mr',!empty($tanggal_buat_mr) ? date('d-m-Y',strtotime($tanggal_buat_mr))  : date('d-m-Y'), 'class="form-control date" '.$disable.' ') ?>
                      <span class="input-group-addon"><span class="fa fa-calendar"></span></span>                    
                  </div>
                </div>
               <?php if ($id) { ?>
                 
                <?php }else{ ?>
                       <?php 
                        $datakota = $this->db->query("select * from kota_master_projek a
                                                      LEFT JOIN m_m_kota b on b.kota_id = a.id_kota 
                                                       where id_master_project = '".$id_project."' ")->result();
                            if(count($datakota) != 1){
                   ?> 
                 
                    
                       <label class=" col-md-3" style="text-align: right;">Pilih Lokasi</label>
                       <div class="col-md-3">
                       <select   id="nama_kota" class="form-control required">
                              <?php 
                              $datakota = $this->db->query("select * from kota_master_projek a
                                                            LEFT JOIN m_m_kota b on b.kota_id = a.id_kota 
                                                             where id_master_project = '".$id_project."' ")->result();
                                  foreach($datakota as $kota){
                              ?>
                    
                                   <option value="<?php echo $kode_mr_dropdown;?><?php echo $kota->singkatan;?>-<?php echo $kota->id_kota;?>"><?php echo $kota->ibu_kota;?> (<?php echo $kota->singkatan;?>) </option> 
                                 
                              <?php } ; ?>  
                           </select>
                      </div>
                   
                 <?php } ?>
                <?php  } ?>
               
              </div>

              <!-- <div class="form-group form-group-sm">
                
              </div> -->
              <div class="form-group form-group-sm"> 
                <div class="col-md-12">
                   <label class="">Material / Barang</label>
                  <?php if ($param  != 2) { ?>
                    <?php echo anchor(null, '<i class="fa fa-plus"></i> Tambah', array('class' => 'btn blue pull-right', 'onclick' => 'add_equipment_form()')); ?>
                 <?php } ?>
                </div>
              
              </div>
            
                
              <div class="info-div">
                    <table class="table table-striped table-bordered table-hover datatable dataTable dataTablemr" style="margin-top: 10px;">
                            <thead>
                                <tr>

                                    <th class="span1">No</th>
                                    <th class="span1">Type MR</th>
                                    <th class="span1">NO Rak</th>
                                    <th class="span1">Description</th>
                                    <th class="span1">Size</th> 
                                    <th class="span1">QTY</th>
                                    <th class="span1">Unit </th>
                                    <th class="span1">Part Number</th>
                                    <th class="span1">Unit Cost</th>
                                    <th class="span1">Total Cost</th> 
                                    <th class="span1">Lokasi (Station)</th>
                                    <th class="span1">Tgl Kebutuhan</th>
                                   <!--  <th>Remarks</th> -->
                                    <th>Lampiran</th>
                                    <th class="span1">Action</th>
                    
                                </tr>
                            </thead>
                            <tbody id="lk_temp" style="display: none;">
                                <tr class="lk_tr">
                                <td class="text-center no_lk">

                                        <div class="input-group">
                                         
                                        </div>
                                    </td>
                                     <td>
                                        <div class="input-group">
                                           <select class="form-control type_equipment" id="type_equipment_" onchange="typemr()">
                                              <option value="3">Persediaan</option>
                                              <option value="2">Material Supply</option>
                                              <option value="1">Asset</option>
                                              <option value="4">Jasa Sewa</option>
                                              <option value="5">Jasa Non Sewa</option>
                                         </select>
                                        </div>
                                    </td>
                                    <td> <div class="input-group">
                                          <?php echo form_input('','', 'class="form-control no_rak" id= "no_rak_" placeholder="2.1.1"') ?>
                                        </div></td>
                                    <td class="text-center ">
                                        <div class="input-group input_" id="">
                                             <!--  <?php// echo form_input('','', 'class="form-control description" id= "description_"') ?> -->
                                                <?php echo form_hidden('', !empty($data->barang_id) ? $data->barang_id : NULL , 'id = "barang_id_" class="barang_id"') ?>
                                                <?php echo form_input('',!empty($data->barang_nama_lengkap) ? $data->barang_nama_lengkap : NULL , 'class="form-control barang_nama" id="barang_nama_" placeholder="Laptop Acer"') ?>

                                        <!--    <div class="input-group-btn">
                                           <button class="btn btn-info" id="modal_barang_param" type="button" onclick="modal_data_barang()"><i class="fa fa-book"></i></button>
                                            </div> -->
                                         
                                        </div>
                                      <div class="dt-des"  style="text-align: left">
                                          SPECIFICATION  <i class="fa fa-level-down"></i>
                                        </div>
                                         <div class="dt-des">
                                        <?php echo form_textarea('','', 'class="form-control detaild" rows="4" id= "detail_desc_" placeholder="1. TYPE 3200 RAM 4 Gigabyte"') ?>
                                        </div>
                                    </td>
                                     <td class="text-center">
                                      <div class="input-group">
                                        <?php echo form_input('size','', 'class="form-control" id="size_" placeholder="" ') ?>
                                      </div>
                                  </td> 
                                    <td class="text-center">
                                        <div class="input-group qty_" id="">
                                          <?php echo form_input('','', 'class="form-control quan" onkeyup="hitung_cost()" id= "quantity_" placeholder="1"') ?>
                                          
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                          <?php echo form_input('','', 'class="form-control unit" id= "unit_" placeholder="Unit"') ?>
                                        </div>
                                    </td>
                                     <td>
                                        <div class="input-group">
                                          <?php echo form_input('','', 'class="form-control part_number" id= "part_number_" placeholder="12345"') ?>
                                        </div>
                                    </td>
                                     <td>
                                        <div class="input-group">
                                         <?php echo form_dropdown('curren', $currency, 5, 'class="form-control curr" id="curry"') ?>  <?php echo form_input('','', 'class="form-control unit_cost uc" onkeyup="hitung_cost()" id= "unit_cost_" placeholder="3,0000,000.00"') ?>
                                        </div>
                                    </td>
                                      <td>
                                        <div class="input-group">
                                          <?php echo form_input('','', 'class="form-control total_cost" id= "total_cost_" readonly') ?>
                                        </div>
                                    </td> 
                                     <td>
                                        <div class="input-group">
                                          <?php echo form_input('','', 'class="form-control lokasi" id= "lokasi_" placeholder="0"') ?>
                                          <?php echo form_hidden('','', 'class="form-control total_cost" id= "total_cost_" readonly') ?>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                      
                                        <?php // echo form_input('','', 'class="form-control on_order" id= "on_order_" placeholder="0"') ?>
                                        <div class='input-group date'>
                                            <?php echo form_input('',date('d-m-Y'), 'class="form-control tgl_kebutuhan_ date"') ?>
                                             <span class="input-group-addon"><span class="fa fa-calendar"></span></span>                 
                                        </div>

                                          <div class="ms_sewa_" style="display: none;font-size: 12px;">Masa Sewa Sampai :</div>
                                          <div class='input-group date' >
                                               <?php echo form_input('','', 'class="form-control month date" style="display:none;"') ?>
                                            <span class="date_sewa_ input-group-addon" style="display: none;"><span class="fa fa-calendar"></span></span>                 
                                          </div>
                                     
                                    </td>
                                    <!--  <td> -->
                                         <?php echo form_hidden('','', 'class="form-control remarsk" rows="4" id= "" placeholder=""') ?>
                                    <!--  </td>  -->
                                    <td>
                                      <div class="form-group form-group-sm">
                                            <?php

                                                $file_ = $filename_ = '';
                                                if(!empty($dt->image_realisasi)):
                                                  $file = json_decode($dt->image_realisasis);

                                                    if(!empty($file)){
                                                        if (!empty($file->file)){
                                                            $file_ = $file->file;
                                                            $filename_ = $file->filename;
                                                        }else{
                                                            $file_ = $file[0]->file;
                                                            $filename_ = $file[0]->filename;
                                                        }
                                                    }
                                                  echo form_hidden('lampiran_path[]', $file_,'class="lampiran-path"');
                                                  echo form_hidden('lampiran_name[]', $filename_,'class="lampiran-name"');
                                                endif;
                                          ?>
                                          <div class="col-md-12">
                                             <div class="fileinput <?php echo!empty($file) ? 'fileinput-exists' : 'fileinput-new' ?>" data-provides="fileinput">
                                                <span class="btn btn-sm btn-default btn-file">
                                                  <span class="fileinput-new">Pilih File</span>
                                                  <span class="fileinput-exists">Change</span>
                                                  <?php echo form_upload('lampiran_fi',NULL,'class="lampiran-file lm" accept="image/*,pdf/*" ') ?>
                                                </span>
                                                <span class="fileinput-filename"> <a href="<?php echo $file_; ?>" target="_blank"> <?php echo $filename_ ?> </a></span>

                                                <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
                                              </div>
                                          </div>
                                      </div>
                                    </td>
                                    <td>
                                        <?php echo anchor(null, '<i class="fa fa-minus"></i>', array('class' => 'btn red btn_lk')); ?>
                                    </td>
                                </tr>
                            </tbody>
                             <tbody id="lk_list">
                              <?php if (empty($id)) { ?>
                                <tr id="tr_lk_1" class="lk_tr">
                                    <td class="text-center no_lk"> 
                                      <div class="input-group">
                                       1
                                      </div>
                                    </td>
                                     <td class="text-center" width="100px">
                                      <div class="input-group">
                                         <select class="form-control" style="padding: 0px;" id="type_equipment_1" name="type_equipment[]"  onchange="typemr(1)">
                                              <option value="3">Persediaan</option>
                                              <option value="2">Material Supply</option>
                                              <option value="1">Asset</option>
                                              <option value="4">Jasa Sewa</option>
                                              <option value="5">Jasa Non Sewa</option>
                                         </select>
                                      </div>
                                    </td>
                                     <td class="text-center" >
                                      <div class="input-group">
                                        <?php echo form_input('no_rak[]',!empty($data->no_rak) ? $data->no_rak : NULL, 'class="form-control no_rakk" id="no_rak_1" placeholder="2.1.1"') ?>
                                      </div>
                                    </td>
                                    <td class="text-center" width="300px"> 
                                     <?php echo form_hidden('jumlah_equipment', 2, 'id = "jumlah_equipment" class="jumlah_equipment" ') ?>
                                      <div class="input-group input-1" id="input_1">
                                       <?php echo form_hidden('barang_id[]', !empty($data->barang_id) ? $data->barang_id : NULL , 'id = "barang_id_1"') ?>
                                        
                                     
                                        <?php echo form_input('barang_nama[]',!empty($data->barang_nama_lengkap) ? $data->barang_nama_lengkap : NULL , 'class="form-control" placeholder="Laptop Acer" id="barang_nama_1" ') ?>
                                        <!--  <div class="input-group-btn">
                                            <button class="btn btn-info" type="button" onclick="modal_data_barang(1)"><i class="fa fa-book"></i></button> -->
                                       <!--  </div> -->
                                       
                                      </div>
                                      <div class="dt-desc1">
                                          SPECIFICATION <i class="fa fa-level-down"></i>
                                        </div>
                                       <div class="dt-desc1">
                                        <?php echo form_textarea('detail_desc[]',!empty($data->no_spb) ? $data->no_spb : NULL, 'class="form-control" rows="4" placeholder="1. TYPE 3200 RAM 4 Gigabyte" id= "detail_desc_1"') ?>
                                      </div>
                                    </td>
                                    <td class="text-center" width="70px">
                                      <div class="input-group">
                                        <?php echo form_input('size[]',!empty($data->size) ? $data->size : NULL, 'class="form-control" id="size_1"') ?>
                                      </div>
                                    </td>
                                    <td class="text-center" width="60px">
                                      <div class="input-group qty" id="qty_1">
                                        <?php echo form_input('quantity[]',!empty($data->no_spb) ? $data->no_spb : NULL, 'class="form-control" onkeyup="hitung_cost(1)" id= "quantity_1" placeholder="1"') ?>
                                      
                                      </div>
                                    </td>
                                    <td class="text-center" width="70px">
                                      <div class="input-group">
                                        <?php echo form_input('unit[]',!empty($data->no_spb) ? $data->no_spb : NULL, 'class="form-control" id= "unit_1" placeholder="Unit"') ?>
                                      </div>
                                    </td>
                                    <td class="text-center">
                                      <div class="input-group">
                                        <?php echo form_input('part_number[]',!empty($data->no_spb) ? $data->no_spb : NULL, 'class="form-control" id= "part_number_1" placeholder="12345"') ?>
                                      </div>
                                    </td>
                                    <td class="text-center"  width="150px">
                                      <div class="input-group">
                                      <?php  echo form_dropdown('currency[]', $currency, NULL, 'class="form-control " id="currency"') ?> 
                                        <?php echo form_input('unit_cost[]',!empty($data->no_spb) ? $data->no_spb : NULL, 'class="form-control number" onkeyup="hitung_cost(1)" id= "unit_cost_1" placeholder="3,000,000.00"') ?>
                                      </div>
                                    </td>
                                     <td class="text-center" width="125px">
                                      <div class="input-group">
                                        <?php echo form_input('total_cost_1',!empty($data->no_spb) ? $data->no_spb : NULL, 'class="form-control total_cost" id= "total_cost_1" readonly') ?>
                                      </div>
                                    </td> 
                                    <td class="text-center">
                                      <div class="input-group">
                                        <?php echo form_input('lokasi_station[]',!empty($data->no_spb) ? $data->no_spb : NULL, 'class="form-control" id= "lokasi_station_1" placeholder="HO"') ?>
                                         <?php echo form_hidden('total_cost[]',!empty($data->no_spb) ? $data->no_spb : NULL, 'class="form-control total_cost" id= "total_cost_1" readonly') ?>
                                      </div>
                                    </td>
                                    <td class="">
                                      
                                        <?php // echo form_input('on_order_1',!empty($data->no_spb) ? $data->no_spb : NULL, 'class="form-control" id= "on_order_1" placeholder="0"') ?>
                                          <div class='input-group date'>
                                            <?php echo form_input('tgl_kebutuhan[]',!empty($tanggal_buat_mr) ? date('d-m-Y',strtotime($tanggal_buat_mr))  :  date('d-m-Y'), 'class="form-control date"') ?>
                                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>    
                                        </div>
                                          <div class="ms_sewa_1" id="ms_sewa_1" style="display: none;font-size: 12px;">Masa Sewa Sampai :</div>
                                          <div class='input-group date'>
                                              <?php echo form_input('month[]',!empty($tanggal_buat_mr) ? date('d-m-Y',strtotime($tanggal_buat_mr))  : date('d-m-Y'), 'class="form-control date" style="display:none;" id="month_1"') ?>
                                          <span style="display: none;" id="date_sewa_1" class="date_sewa_1 input-group-addon">
                                              <span class="fa fa-calendar"></span>
                                          </span>
                                       </div>
                                      
                                    </td>
                                    <!--  <td width="200px">-->
                                         <?php echo form_hidden('remarks[]',!empty($data->remarks) ? $data->remarks : NULL, 'class="form-control" rows="4" id= ""  placeholder=""') ?>
                                   <!--   </td>  -->
                                     <td>
                                        <div class="form-group form-group-sm">
                                      <?php

                                            $file_ = $filename_ = '';
                                            if(!empty($dt->image_realisasi)):
                                              $file = json_decode($dt->image_realisasis);

                                                if(!empty($file)){
                                                    if (!empty($file->file)){
                                                        $file_ = $file->file;
                                                        $filename_ = $file->filename;
                                                    }else{
                                                        $file_ = $file[0]->file;
                                                        $filename_ = $file[0]->filename;
                                                    }
                                                }
                                              echo form_hidden('lampiran_path[]', $file_,'class="lampiran-path"');
                                              echo form_hidden('lampiran_name[]', $filename_,'class="lampiran-name"');
                                            endif;
                                      ?>
                                      <div class="col-md-12">
                                         <div class="fileinput <?php echo!empty($file) ? 'fileinput-exists' : 'fileinput-new' ?>" data-provides="fileinput">
                                            <span class="btn btn-sm btn-default btn-file">
                                              <span class="fileinput-new">Pilih File</span>
                                              <span class="fileinput-exists">Change</span>
                                              <?php echo form_upload('lampiran_file[0]',NULL,'class="lampiran-file lampiran-1" accept="image/*,pdf/*" ') ?>
                                            </span>
                                            <span class="fileinput-filename"> <a href="<?php echo $file_; ?>" target="_blank"> <?php echo $filename_ ?> </a></span>

                                            <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
                                          </div>
                                      </div>
                                  </div>
                                     </td>
                                   
                                    <td>
                                        <?php echo anchor(null, '<i class="fa fa-minus"></i>', array('class' => 'btn red btn_lk', 'onclick' => 'remove_equipment_form(1)')); ?>
                                    </td>
                                </tr>
                           
                              <?php }else { ?>
                                <?php  $jml = count($data_equipment->result())+1 ;  echo form_hidden('jumlah_equipment', $jml , 'id = "jumlah_equipment" class="jumlah_equipment" ') ?>
                                <?php $lmp=0; $si=1; $dtt=1; $dt=1; $lk=1; $rm=1; $k1=1; $k2=1; $no = 1; $n1 = 1; $n = 1; $n2=1;$n3=1;$n4=1;$n44=1; $q1 = 1; $rak=1; $q2 = 1; $q3=1; $u1 = 1; $u2=1; $p1=1; $p2=1; $un1=1;  $un2=1; $un3=1; $t1=1; $t2=1; $oh1 = 1; $oh2 = 1; $oo1=1; $oo2=1; $tp1=1; $tp2=1;$dtdes1=1;$dtdes=1;
                                  foreach ($data_equipment->result() as $value) { ?>
                                      <tr id="tr_lk_<?php echo $lk++ ;?>" class="lk_tr">
                                        <td class="text-center no_lk"> 
                                          <div class="input-group">
                                          <?php echo $no++; ?>
                                          </div>
                                        </td>
                                         <td class="text-center" width="100px">
                                          <div class="input-group" >
                                             <select class="form-control" id="<?php echo 'type_equipment_'.$tp2++.'' ?>" name="type_equipment[]" onchange="typemr(1)">

                                                  <option <?php if ($value->type_equipment == 1) { echo "selected";} ?> value="1" >Asset</option>
                                                  <option <?php if ($value->type_equipment == 2) { echo "selected";} ?> value="2">Material Supply</option>
                                                  <option <?php if ($value->type_equipment == 3) { echo "selected";} ?>  value="3">Persediaan</option>
                                                  <option <?php if ($value->type_equipment == 4) { echo "selected";} ?>  value="4"> Jasa Sewa</option>
                                                  <option <?php if ($value->type_equipment == 5) { echo "selected";} ?>  value="5"> Jasa Non Sewa</option>
                                             </select>
                                          </div>
                                        </td>
                                        <td class="text-center" >
                                          <div class="input-group">
                                            <?php echo form_input('no_rak[]',!empty($value->no_rak) ? $value->no_rak : NULL, 'class="form-control no_rakk" id="no_rak_1" placeholder="2.1.1"') ?>
                                          </div>
                                        </td>
                                        <td class="text-center" width="250px"> 
                                          <?php echo form_hidden('id_equipment[]', $value->mr_equipment_id , 'id = "id_equipment" class="id_equipment" ') ?>
                                              <?php echo form_hidden('barang_id[]', !empty($value->id_barang) ? $value->id_barang : NULL , 'id = "barang_id_'.$n3++.'"') ?>
                                          <div class="input-group" id="input_1">
                                           
                                            
                                            <?php if ($value->type_equipment == 4 || $value->type_equipment == 5 ) { ?>

                                                 <?php echo form_textarea('barang_nama[]',!empty($value->description) ?$value->description : NULL , 'class="form-control" rows="4" cols="42" id="barang_nama_'.$n4++.'"') ?>

                                                  <?php  echo form_hidden('detail_desc[]',!empty($value->desc_detail) ? $value->desc_detail: NULL, 'class="form-control"  rows="4" id= "detail_desc_'.$dtt++.'" ') ?>
                                             
                                            <?php } else { ?>
                                                 <?php echo form_input('barang_nama[]',!empty($value->description) ?$value->description : NULL , 'class="form-control" id="barang_nama_'.$n44++.'"') ?>
                                              
                                          </div>
                                          <div class="dt-desc<?php echo $dtdes++ ?>">
                                            SPECIFICATION  <i class="fa fa-level-down"></i>
                                          </div>
                                             <div class="dt-desc<?php echo $dtdes1++ ?>">
                                              <?php  echo form_textarea('detail_desc[]',!empty($value->desc_detail) ? $value->desc_detail: NULL, 'class="form-control"  rows="4" id= "detail_desc_'.$dtt++.'" ') ?>
                                            </div>
                                             <?php } ?>
                                        </td>
                                        <td class="text-center" width="80px">
                                      <div class="input-group">
                                        <?php echo form_input('size[]',!empty($value->size) ? $value->size : NULL, 'class="form-control" id="size_"') ?>
                                      </div>
                                    </td>
                                        <td class="text-center" width="80px">
                                          <div class="input-group">
                                            <?php echo form_input('quantity[]',!empty($value->quantity) ? $value->quantity: NULL, 'class="form-control"   id= "quantity_'.$q2++.'" onkeyup="hitung_cost('.$q3++.')" ') ?>

                                          </div>
                                        </td>
                                        <td class="text-center">
                                          <div class="input-group">
                                            <?php echo form_input('unit[]',!empty($value->unit) ? $value->unit : NULL, 'class="form-control"   id= "unit_'.$u2++.'"') ?>
                                          </div>
                                        </td>
                                        <td class="text-center">
                                          <div class="input-group">
                                            <?php echo form_input('part_number[]',!empty($value->part_number) ? $value->part_number : NULL, 'class="form-control" id= "part_number_'.$p2++.'"') ?>
                                          </div>
                                        </td>
                                        <td class="text-center" width="150px">
                                          <div class="input-group">
                                            <?php  echo form_dropdown('currency[]', $currency, !empty($value->currency) ? $value->currency : 'Rp', 'class="form-control " id="currency"') ?> 
                                            <?php echo form_input('unit_cost[]',!empty($value->unit_cost) ? $value->unit_cost : NULL, 'class="form-control number"  id= "unit_cost_'.$un2++.'" onkeyup="hitung_cost('.$un3++.')"  ') ?>
                                          </div>
                                        </td>
                                    <td class="text-center" width="150px">
                                          <div class="input-group"> 
                                           <?php echo form_input('total_cost[]',!empty($value->total_cost) ? $value->total_cost : NULL, 'class="form-control number  total_cost" id= "total_cost_'.$t2++.'" readonly') ?> 
                                         </div>
                                        </td> 
                                        <td class="text-center">
                                          <div class="input-group">
                                            <?php echo form_input('lokasi_station[]',!empty($value->lokasi_station) ? $value->lokasi_station : NULL, 'class="form-control" id= "lokasi_station_'.$oh2++.'"') ?>
                                          </div>
                                          <!--   <?php //echo form_hidden('total_cost[]',!empty($value->total_cost) ? $value->total_cost : NULL, 'class="form-control total_cost" id= "total_cost_'.$t2++.'" readonly') ?> -->
                                        </td>
                                        <td class="text-center">
                                          <div class='input-group date'>
                                           <?php if ($value->date_lama_sewa == '1970-01-01') { ?>
                                                 <?php echo form_input('tgl_kebutuhan[]','', 'class="form-control tgl_kebutuhan_ date"') ?>
                                           <?php }else{ ?>
                                            <?php echo form_input('tgl_kebutuhan[]',!empty($value->tgl_butuh) ? date('d-m-Y',strtotime($value->tgl_butuh))  : date('d-m-Y'), 'class="form-control tgl_kebutuhan_ date"') ?>
                                          <?php } ?>
                                           
                                             <span class="input-group-addon"><span class="fa fa-calendar"></span></span>                 
                                        </div>
                                           <?php if ($value->type_equipment == 4 ) { 
                                                $display = 'style=""';
                                                $text = '<div style="font-size:12px;">masa sewa sampai</div>';
                                             }else {
                                               $display = 'style="display:none;"';
                                                $text = '';
                                             } ?>
                                             <?php echo $text; ?>
                                              <div class="input-group date">
                                              <?php if ($value->date_lama_sewa == '1970-01-01') { ?>
                                                 <?php echo form_input('month[]','', 'class="form-control date" '.$display.' id="month_'.$k2++.'"') ?>
                                             <?php }else{ ?>
                                                    <?php echo form_input('month[]',!empty($value->date_lama_sewa) ? date('d-m-Y',strtotime($value->date_lama_sewa))  : date('d-m-Y'), 'class="form-control date" '.$display.' id="month_'.$k2++.'"') ?>
                                             <?php } ?>
                                              
                                               <span class="input-group-addon" <?php echo $display ?> > <span class="fa fa-calendar"></span></span>      
                                             </div>
                                        </td>

                                      <!--   <td width="200px"> -->
                                         <?php echo form_hidden('remarks[]',!empty($value->remarks) ? $value->remarks : NULL, 'class="form-control remarks_" rows="4" id= "" placeholder=""') ?>
                                      <!--   </td>  -->

                                        <td>
                                          <div class="form-group form-group-sm">
                                      <?php

                                            $file_ = $filename_ = '';
                                            if(!empty($value->lampiran)):
                                              $file = json_decode($value->lampiran);

                                                if(!empty($file)){
                                                    if (!empty($file->file)){
                                                        $file_ = $file->file;
                                                        $filename_ = $file->filename;
                                                    }else{
                                                        $file_ = $file[0]->file;
                                                        $filename_ = $file[0]->filename;
                                                    }
                                                }
                                              echo form_hidden('lampiran_path[]', $file_,'class="lampiran-path"');
                                              echo form_hidden('lampiran_name[]', $filename_,'class="lampiran-name"');
                                            endif;
                                      ?>
                                      <div class="col-md-12">
                                         <div class="fileinput <?php echo!empty($file) ? 'fileinput-exists' : 'fileinput-new' ?>" data-provides="fileinput">
                                            <span class="btn btn-sm btn-default btn-file">
                                              <span class="fileinput-new">Pilih File</span>
                                              <span class="fileinput-exists">Change</span>
                                              <?php echo form_upload('lampiran_file['.$lmp++.']',NULL,'class="lampiran-file lampiran-1" accept="image/*,pdf/*" ') ?>
                                            </span>
                                            <span class="fileinput-filename"> <a href="<?php echo $file_; ?>" target="_blank"> <?php echo $filename_ ?> </a></span>

                                            <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
                                          </div>
                                      </div>
                                  </div>
                                        </td>
                                        
                                       
                                        <td>
                                            <?php echo anchor(null, '<i class="fa fa-minus"></i>', array('class' => 'btn red btn_lk', 'onclick' => 'remove_equipment_form('.$rm++.', '.$value->mr_equipment_id.')')); ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                              <?php } ?>
                            </tbody>
                          <!--   <tfoot>
                              <tr>
                                <td align="right" colspan="7"><b>Grand Total</b></td>
                                <td align="left" colspan=""><b>  <?php // echo form_input('gran_total', '', 'class="form-control gran_total" id= "gran_total" readonly') ?></b></td>
                                <td align="left" colspan="4"></td>
                              </tr>
                            </tfoot> -->
                    </table>
              
              </div>
              <br>
              <?php echo form_hidden('exix','') ;?>
              <div class="form-group form-group-sm">
                  <label class="col-md-1 ">Note MR : </label>
                  <div class="col-md-6">
                     <?php echo form_textarea('note', !empty($note) ? $note : '', 'class="form-control" rows="4" cols="4"') ?>
                  </div>
              </div>

               <?php 
                  if($status_approve == 2){ ?>
                  <div class="form-group form-group-sm">
                    <label class="col-md-2 "> <span style="color: red"> Keterangan Revisi : </span> </label>
                    <div class="col-md-6">
                       <?php $in=1;
                          foreach ($queryrevisi->result() as $key => $value) { ?>
                          <span style="color: red">  <?php echo $in++ ?>. <?php echo $value->catatan_approve ; ?></span><br>
                        <?php   } ?>
                    </div>
                  </div>
               <?php  } ?>

             <!--  <div class="form-group form-group-sm">
                <label class="col-md-2 ">Purchase Instruction</label>
                <div class="col-md-3">
                   <label class="radio-inline">
                    <input type="radio" name="purchase" <?php// if(!empty($purchase)){ if ($purchase == 'LP'){ echo 'checked';}} ?>  value="LP">LP
                  </label>
                   <label class="radio-inline">
                   OR
                  </label>
                  <label class="radio-inline">
                    <input type="radio" <?php/// if(!empty($purchase)){ if ($purchase == 'JKT'){ echo 'checked';}} ?> name="purchase" value="JKT">JKT
                  </label>
                  <label class="radio-inline">
                    <input type="radio" <?php// if(!empty($purchase)){ if ($purchase == 'OTHER'){ echo 'checked';}} ?>  name="purchase" value="OTHER">OTHER
                  </label>
                </div>
              </div>
              

              <div class="form-group form-group-sm">
                <label class="col-md-2 ">Shipping Instruction</label>
                <div class="col-md-8">
                   <label class="radio-inline">
                    <input type="radio" <?php// if(!empty($shipping)){ if ($shipping == 'ROAD'){ echo 'checked';}} ?>  name="shipping" value="ROAD">ROAD
                  </label>
                   <label class="radio-inline">
                    OR
                  </label>
                  <label class="radio-inline">
                    <input type="radio" <?php// if(!empty($shipping)){ if ($shipping == 'OFF'){ echo 'checked';}} ?> name="shipping" value="OFF">OFF
                  </label>
                  <label class="radio-inline">
                    <input type="radio"  <?php// if(!empty($shipping)){ if ($shipping == 'OFS'){ echo 'checked';}} ?> name="shipping" value="OFS">OFS
                  </label>
                   <label class="radio-inline">
                    <input type="radio"  <?php// if(!empty($shipping)){ if ($shipping == 'AF'){ echo 'checked';}} ?> name="shipping" value="AF">AF
                  </label>
                  <label class="radio-inline">
                    <input type="radio"  <?php// if(!empty($shipping)){ if ($shipping == 'UAF'){ echo 'checked';}} ?> name="shipping" value="UAF">UAF
                  </label>
                </div>
              </div>
 -->
				<div class="form-group form-group-sm">
            <?php
          $file = null;
          $file_ = $filename_ = '';
          if(!empty($lampiran_file_mr)): 
            foreach ($lampiran_file_mr->result() as $value) {
              $file = json_decode($value->lampiran_new);
              $file_ = $file->file;
              $filename_ = $file->filename;
              echo form_hidden('lampiran_file_new[]', $file_,'class="lampiran-path"');
              echo form_hidden('name[]', $filename_,'class="lampiran-path"');
            }
          endif;
          ?>
          <div class="col-md-12">
          <?php if (!empty($id)) {
                if(!empty($lampiran_file_mr)){ 
                foreach ($lampiran_file_mr->result() as $value) {
                $file = json_decode($value->lampiran_new);
                $file_ = $file->file;
                $filename_ = $file->filename;
          ?>
                  <div class="fileinput <?php echo!empty($lampiran_file_mr) ? 'fileinput-exists' : 'fileinput-new' ?>" data-provides="fileinput">
                     <!-- <span class="btn btn-sm btn-default btn-file">
                     <span class="fileinput-new">Pilih File</span>
                    <span class="fileinput-exists">Change</span>
                     <?php echo form_upload('lampiran_file_new[]',NULL,'class="lampiran-file lampiran-1" accept="image/*,pdf/*" ') ?>
                    </span> -->
                    <span class="fileinput-filename del_<?php echo $value->id_lampiran ?>"> <a href="<?php echo $file_; ?>" target="_blank"> <?php echo $filename_ ?> </a></span>
                    <a href="javascript:void[0]" onclick="delete_file(<?php echo $value->id_lampiran ?>)" class="close fileinput-exists del_<?php echo $value->id_lampiran ?>"  style="float: none">&times;</a>
                  </div>
             <?php 
                       } 
                   }
              }
            ?>
            </div>

               <?php if ($param  != 2) { ?>
 
				
					<div class="col-md-3">
         
						<div class="control-group" id="fields">
							<label class="control-label" for="field1" style="font-size: 14px !important">
							Lampiran
							</label>
							<div class="controls">
								<div class="entry input-group col-xs-3">
									<input class="btn btn-primary" name="lampiran_file_new[]" type="file">
									<span class="input-group-btn">
										<button class="btn btn-success btn-add" type="button">
											<span class="glyphicon glyphicon-plus"></span>
										</button>
									</span>
								</div>
							</div>
						</div>

					</div>
				</div>
               <?php } ?>

				
          </fieldset>
      </div> 
      <div class="portlet-footer">
          <div class="modal-footer">

            <?php if ($param  != 2) { ?>
         
              <?php
               if (empty($id)){
                  echo anchor(NULL, '<i class="glyphicon glyphicon-chevron-left"></i> Kembali', array(
                    'id' => 'mybutton-add',
                    'class' => 'btn btn-default margin-right-2',
                    'onclick' => 'go_back()'
                  ));
                   echo anchor(NULL, '<i class="glyphicon glyphicon-floppy-disk"></i> Draft', array(
                      'id' => 'mybutton-add',
                      'class' => 'btn btn-warning',
                      'onclick' => 'draft(2)'
                  ));
                  echo anchor(NULL, '<i class="glyphicon glyphicon-floppy-disk"></i> Ajukan', array(
                      'id' => 'mybutton-add',
                      'class' => 'btn btn-success',
                      'onclick' => '$(\'form#finput\').submit()'
                  ));
               }else{
                  echo anchor(NULL, '<i class="glyphicon glyphicon-chevron-left"></i> Kembali', array(
                    'id' => 'mybutton-add',
                    'class' => 'btn btn-default margin-right-2',
                    'onclick' => 'go_back()'
                  ));

                if ($status_save == 2 || $status_approve == 2) {
                  echo anchor(NULL, '<i class="glyphicon glyphicon-floppy-disk"></i> Ajukan', array(
                      'id' => 'mybutton-add',
                      'class' => 'btn btn-warning',
                      'onclick' => 'draft(1)'
                   
                  ));
                   echo anchor(NULL, '<i class="glyphicon glyphicon-floppy-disk"></i> Save', array(
                      'id' => 'mybutton-add',
                      'class' => 'btn btn-success',
                      'onclick' => 'draft(2)'
                  ));
                }else{
                  echo anchor(NULL, '<i class="glyphicon glyphicon-floppy-disk"></i> save', array(
                      'id' => 'mybutton-add',
                      'class' => 'btn btn-success',
                      'onclick' => 'draft(0)'
                  ));
                }
                  
               }
                
               ?>

               <?php } ?>
          </div>
      </div>
      <?php echo form_close() ?>   
</div>

<div id="modal-data-barang" class="modal container" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
            <i class="fa fa-times"></i>
      </button>
      <span class="modal-title">LIST BARANG</span>
      <input type="hidden" id="param_barang">
    </div>
    <div class="modal-body">
      <form class="form-inline pull-right" id="form-filter-barang">
          <div class="form-group">
              <?php echo form_dropdown('column', array(
                                      '' => 'semua',
                                      'barang_nama' => 'Nama Barang',
                                      'barang_merk' => 'Merk',
                                      'barang_type' => 'Type',
                      ), '','class="input-sm form-control"'); ?>
          </div>
          <div class="form-group">
               <div class="input-group">
                      <?php echo form_input('keyword','' , 'class="form-control input-sm"') ?>
                      <div class="input-group-btn">
                        <button class="btn btn-info btn-sm"><i class="fa fa-search"></i></button>
                    </div>
              </div>
          </div>
      </form>

      <table id="table-data-barang" 
             class="table table-bordered table-hover" 
             width="100%" style="margin-top: 0 !important;"
             data-table-source="<?php echo base_url() . $_modul . '/load_data_barang/mr' ?>"
             data-table-filter="#form-filter-barang">
          <thead>
            <tr>
              <th class="text-center" data-sorting="false">No</th>
              <th>KODE</th>
              <th>NAMA BARANG</th>
              <th>JENIS</th>
              <th>SATUAN</th>
              <th>HARGA</th>
            </tr>
          </thead>
      </table>
    </div>
</div>

<div class="modal" id="modal-add-barang" data-backdrop="static" aria-hidden="true" data-width="700"></div>

<script type="text/javascript">
  pageSetUp();

  <?php if ($param  == 2) { ?>
    $("#finput :input").prop('readonly', true);
  <?php } ?>
  
  // if( window.localStorage )
  // {
  //   if( !localStorage.getItem('firstLoad') )
  //   {
  //     localStorage['firstLoad'] = true;
  //     window.location.reload();
  //   }  
  //   else
  //     localStorage.removeItem('firstLoad');
  // }
    var no = 0;
          var total = 0;
            $.each($('#lk_list tr.lk_tr'), function () {
                no++;
               var jumlah = $('input.total_cost',this).val();
               if(jumlah){
                  total  += parseFloat(jumlah);
                }

            });
        $('#gran_total').val(total).number(true, 2);

  $('#nama_kota').on('change', function() {
       //alert( this.value );
       var kd = $('#kd_unik').val();
      var str = this.value;
      var kod= str.substr(0, 11);
      var kode = kod + kd;
      var res = str.substr(11, 8);
      // alert(kode)
       $('#kode_mr').val(kode)
       $('#id_kota').val(res)
  })

  var formBasic = $('form#finput');

 $('form#finput').submit(function(event) {
        $('#status_save').val(1)
        event.preventDefault();
        formBasic.myForm().submit();
    });

 function draft(status){
    $('#status_save').val(status);
     $('#status_approve').val(status);
    formBasic.myForm().submit();
 }

  var __afterSubmit = function() {
     $('.loading-save-form').css('display', 'none');
      setTimeout(function(){
        my_form.go_back();
      },200);
    };

   function hitung_cost(id) {
      //$('#quantity_'+id).number(true);
      //$('#unit_cost_'+id).number(true, 2).val();
      // $('input.number_new', tableListTermin).number(true, 2);
      // $('.number', this).number(true, 2).val(jumlah);
      var quan = $('#quantity_'+id).val();
      var unit_cost = $('#unit_cost_'+id).val();
      var result = parseInt(quan) * parseInt(unit_cost);


      if (!isNaN(result)) {
         $('#total_cost_'+id).val(result).number(true, 2);
          var no = 0;
          var total = 0;
            $.each($('#lk_list tr.lk_tr'), function () {
                no++;
               var jumlah = $('input.total_cost',this).val();
               if(jumlah){
                  total  += parseFloat(jumlah);
                }

            });
        $('#gran_total').val(total).number(true, 2);
      }
    }


   function render_equipment_form() {
        var no = 0;
       
        $.each($('#lk_list tr.lk_tr'), function () {
         var today = new Date();
          var dd = today.getDate();
          var mm = today.getMonth()+1; //January is 0!

          var yyyy = today.getFullYear();
          if(dd<10){
              dd='0'+dd;
          } 
          if(mm<10){
              mm='0'+mm;
          } 
          var today = dd+'-'+mm+'-'+yyyy;
            no++;
            var kurang =  no - 1 ;
            $(this).attr('id', 'tr_lk_' + no);
           // $('#jumlah_equipment', this).attr('name', 'jumlah');
             $('#jumlah_equipment').val(no+1);
              $('#modal_barang_param', this).attr('onclick', 'modal_data_barang(' + no + ')');

            // $('.description', this).attr('name', 'description_'+ no );
            // $('#description_', this).attr('id', 'description_' + no);
            $('.barang_id', this).attr('name', 'barang_id[]' );
            $('.barang_id', this).attr('id', 'barang_id_' + no);

             $('.no_rak', this).attr('name', 'no_rak[]' );
            $('.no_rak', this).attr('id', 'no_rak_'+ no );


            $('.detaild', this).attr('name', 'detail_desc[]');
             $('.detaild', this).attr('id', 'detail_desc_' + no);

            $('.input_', this).attr('id', 'input_' + no);

            $('.month', this).attr('name', 'month[]' );
            $('.month', this).attr('id', 'month_'+ no );
            // $('.month', this).attr('value', today);

            $('.ms_sewa_', this).attr('id', 'date_sewa_'+ no);

            $('.date_sewa_', this).attr('id', 'ms_sewa_'+ no);

            $('.dt-des', this).attr('class', 'dt-desc'+no);
            
            $('.barang_nama', this).attr('name', 'barang_nama[]' );
            $('.barang_nama', this).attr('id', 'barang_nama_' + no);
            // $('input#barang_nama_'+no).typeahead({
            //       hint: true,
            //       highlight: true,

            //    },
            //    {
            //     display: 'name',
            //     source: sourceBarang,
            //     templates: {
            //       empty: [
            //         '<div class="empty-message">',
            //           '',
            //         '</div>'
            //       ].join('\n'),
            //     }
            //   }).bind('typeahead:selected', function(obj, datum, name) {
            //       // $(this).data('seletectedId', datum.id);
            //       // $(this).data('seletectedName', datum.name);

            //       // if($(this).val() == datum.name) {
            //       //   $(this).closest('.form-group').removeClass('has-error');

            //       //   $('input#barang-id', formBasic).val(datum.id);
            //       //   $('input#project_id', formBasic).val(datum.id_project);
            //       //   $('input#account_code', formBasic).val(datum.id_acc_code);
            //       //   $('input#lokasi', formBasic).val(datum.id_kota);
            //       //   $('input#tanggal', formBasic).focus();
            //       //   $('input#currency', formBasic).val(datum.id_currency);
            //       //   $('input#client', formBasic).val(datum.client);

            //       // } else {
            //       //    $(this).closest('.form-group').addClass('has-error');
            //       //    $('input#barang-id', formBasic).val('');
            //       // }

            //   }).bind('typeahead:change', function(obj, datum, name) {
            //       // var id   = $(this).data('seletectedId');
            //       // var name = $(this).data('seletectedName');

            //       // if(typeof id !== 'undefined') {
            //       //   if($(this).val() == name) {
            //       //     $(this).closest('.form-group').removeClass('has-error');
            //       //   } else {
            //       //     $(this).closest('.form-group').addClass('has-error');
            //       //     $('input#barang-id', formBasic).val('');
            //       //   }
            //       // } else {
            //       //   $(this).closest('.form-group').addClass('has-error');
            //       //   $('input#barang-id', formBasic).val('');
            //       // }
            //   });

            $('.quan', this).attr('name', 'quantity[]');
            $('.quan', this).attr('onkeyup', 'hitung_cost('+ no +')');
            $('#quantity_', this).attr('id', 'quantity_' + no);
             $('.qty_', this).attr('id', 'qty_'+ no);


            $('.unit', this).attr('name', 'unit[]');
            $('#unit_', this).attr('id', 'unit_' + no);

            $('.part_number', this).attr('name', 'part_number[]');
            $('#part_number_', this).attr('id', 'part_number_' + no);

            $('.date', this).datetimepicker({format: 'DD-MM-YYYY'});

            $('.unit_cost', this).attr('name', 'unit_cost[]' );
           
            $('.unit_cost', this).number(true, 2).val();
            $('.unit_cost', this).attr('onkeyup', 'hitung_cost('+ no +')');
            $('#unit_cost_', this).attr('id', 'unit_cost_' + no);

            $('.total_cost', this).attr('name', 'total_cost[]' );
            $('#total_cost_', this).attr('id', 'total_cost_' + no);

            $('#size_', this).attr('name', 'size[]');
            $('#size_', this).attr('id', 'size_' + no);

            $('.lokasi', this).attr('name', 'lokasi_station[]');
            $('#lokasi_', this).attr('id', 'lokasi_station_' + no);

            $('.tgl_kebutuhan_', this).attr('name', 'tgl_kebutuhan[]');
            $('.tgl_kebutuhan_', this).attr('id', 'tgl_kebutuhan_'+ no );

            $('.remarsk', this).attr('name', 'remarks[]');
            $('.remarsk', this).attr('id', 'remarks_'+ no );

             $('.curr', this).attr('name', 'currency[]');
            

             $('.lm', this).attr('name', 'lampiran_file['+ kurang  +']');


            $('.type_equipment', this).attr('name', 'type_equipment[]');
            $('#type_equipment_', this).attr('id', 'type_equipment_' + no);
            $('.type_equipment', this).attr('onchange', 'typemr(' + no + ')' );


            $('.no_lk', this).html(parseInt(no));
            $('.btn_lk', this).attr('onclick', 'remove_equipment_form(' + no + ')');
        });

    }

     function remove_e_form() {
        var no = 0;
        $.each($('#lk_list tr.lk_tr'), function () {
            no++;
             $('#jumlah_equipment').val(no+1);
         });

    }


    function add_equipment_form() {
        var temp_equipment_form = $('#lk_temp').html();
        $('#lk_list').append(temp_equipment_form );
        render_equipment_form();
    }

    function remove_equipment_form(id, id_equipment) {



        bootbox.setBtnClasses({
            CANCEL: 'red',
            CONFIRM: 'blue'
        });


        bootbox.confirm("Anda yakin akan menghapus Field ini?", "Tidak", "Ya", function (e) {
            if (e) {

                  if(id_equipment){
                       $.ajax({
                 			url : "<?php echo base_url() ?>mr/mr_pusat/delete_mr_equipment/"+id_equipment,
                            type: "POST",
                            dataType: "JSON",
                            success: function(data)
                            {
                              $('#tr_lk_' + id).remove();
                               remove_e_form();  

                              if ($('#lk_list tr.lk_tr').length === 0) {
                                  add_equipment_form();
                              }

                              location.reload(); 
                               
                            },
                            error: function (jqXHR, textStatus, errorThrown)
                            {
                                alert('Error deleting data');
                            }
                        });
                                 
                  }else{
                     $('#tr_lk_' + id).remove();
                     remove_e_form();  

                    if ($('#lk_list tr.lk_tr').length === 0) {
                        add_equipment_form();
                                     }
                  }
               
            }
        });
    }

     var modalDataBarang = $('#modal-data-barang');


    function modal_data_barang(param){
        // alert(param)
        $('#param_barang').val(param);
        modalDataBarang.modal('show');
    }

    
    var dataTableBarang = $('#table-data-barang').myDataTable({
        columns: [
            {orderable : false},
            {name: 'barang_id'},
            {name: 'barang_nama'},
            {name: 'nama_jenis_barang'},
            {name: 'satuan'},
            {name: 'harga'},
        ],
    });

    $("form#form-filter-barang").bind('submit',function(){
		__reloadTable();
	return false;
	});
	var __reloadTable = function(refresh) {
     $('.loading-save-form').css('display', 'none');
		dataTableBarang.reload(refresh);
	};

    $('table#table-data-barang > tbody tr').livequery('click', function (event) {
         var param = $('#param_barang').val();
          event.preventDefault();
          _this = $(this);

          globalFormBarang.getField(_this, param);
          modalDataBarang.modal('hide');
      });

      $('.a-kode', $('#table-data-barang')).livequery('click', function (event) {
          event.preventDefault();
          _this = $(this).parents('tr');
          globalFormBarang.getField(_this);
          modalDataBarang.modal('hide');
      }); 

     var globalFormBarang = {

        getField : function(index, param) {
            _this = index;

            var id     = _this.find('.id').data('id');
            var nama   = _this.find('.nama').data('id');
            var satuan   = _this.find('.satuan').data('id');
             var harga   = _this.find('.harga').data('id');

            $('#barang_id_'+param, formBasic).val(id);
            $('#barang_nama_'+param).val(nama);
            $('#unit_'+param).val(satuan);
            $('#unit_cost_'+param).val(harga);
            $('#part_number_'+param).val(id);
             
        }
    }

    function typemr(param){
      var x = document.getElementById("type_equipment_"+param).value;
      if (x == 4 ) {
        $('#input_'+param).html('<input id="barang_id_'+param+'" class="barang_id" name="barang_id[]" value="" type="hidden"><textarea cols="34" rows="4" class="form-control" placeholder="Sewa Mobil Avansa" name="barang_nama[]"> </textarea>');
        $('#month_'+param).css('display', 'block');
        $('#quantity_'+param).css('margin-bottom', '10px');
        // $('#month_'+param).css('width', '100px');
        $('#ms_sewa_'+param).css('display', '');
        $('#date_sewa_'+param).css('display', '');
        $('.dt-desc'+param).attr('style', 'display:none;')
      }else if(x == 5){
        $('#input_'+param).html('<input id="barang_id_'+param+'"   class="barang_id" name="barang_id[]" value="" type="hidden"><textarea cols="34" rows="4" class="form-control" name="barang_nama[]" placeholder="Buat Applikasi Eproc CPM"> </textarea>');
        $('#month_'+param).css('display', 'none');
        $('#ms_sewa_'+param).css('display', 'none');
        $('#date_sewa_'+param).css('display', 'none');
        $('.dt-desc'+param).attr('style', 'display:none;')

      }
    }

$(function()
{
    $(document).on('click', '.btn-add', function(e)
    {
        e.preventDefault();

        var controlForm = $('.controls:first'),
            currentEntry = $(this).parents('.entry:first'),
            newEntry = $(currentEntry.clone()).appendTo(controlForm);

        newEntry.find('input').val('');
        controlForm.find('.entry:not(:last) .btn-add')
            .removeClass('btn-add').addClass('btn-remove')
            .removeClass('btn-success').addClass('btn-danger')
            .html('<span class="glyphicon glyphicon-minus"></span>');
    }).on('click', '.btn-remove', function(e)
    {
      $(this).parents('.entry:first').remove();

		e.preventDefault();
		return false;
	});
});

 var sourceBarang = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    prefetch: '<?php echo $_modul.'/list_data_barang/?jenis=Persediaan' ?> ',
    remote: {
      url: '<?php echo $_modul.'/list_data_barang/?jenis=Persediaan&keyword=%QUERY' ?> ',
      wildcard: '%QUERY'
    }
  });

  $('input#barang_nama_1', formBasic).typeahead({
      hint: true,
      highlight: true,

   },
   {
    display: 'name',
    source: sourceBarang,
    templates: {
      empty: [
        '<div class="empty-message">',
          '',
        '</div>'
      ].join('\n'),
    }
  }).bind('typeahead:selected', function(obj, datum, name) {
      $(this).data('seletectedId', datum.id);
      $(this).data('seletectedName', datum.name);

      if($(this).val() == datum.name) {
        $(this).closest('.form-group').removeClass('has-error');

        $('input#barang-id', formBasic).val(datum.id);
        $('input#project_id', formBasic).val(datum.id_project);
        $('input#account_code', formBasic).val(datum.id_acc_code);
        $('input#lokasi', formBasic).val(datum.id_kota);
        $('input#tanggal', formBasic).focus();
        $('input#currency', formBasic).val(datum.id_currency);
        $('input#client', formBasic).val(datum.client);

      } else {
         $(this).closest('.form-group').addClass('has-error');
         $('input#barang-id', formBasic).val('');
      }

  }).bind('typeahead:change', function(obj, datum, name) {
      var id   = $(this).data('seletectedId');
      var name = $(this).data('seletectedName');

      if(typeof id !== 'undefined') {
        if($(this).val() == name) {
          $(this).closest('.form-group').removeClass('has-error');
        } else {
          $(this).closest('.form-group').addClass('has-error');
          $('input#barang-id', formBasic).val('');
        }
      } else {
        $(this).closest('.form-group').addClass('has-error');
        $('input#barang-id', formBasic).val('');
      }
  });
    function delete_file(id){
      // alert(id)
      $('.del_'+id).css('display', 'none');
      formBasic.append('<input type="hidden" name="remove_lampiran[]" value="'+id+'">');
    }

    function go_back(){
       window.location = '<?php echo base_url(); ?>home#mr/mr_pusat/page_list_mr/<?php echo $id_project ;?>';
    }
     $('.144').addClass('active');
</script>