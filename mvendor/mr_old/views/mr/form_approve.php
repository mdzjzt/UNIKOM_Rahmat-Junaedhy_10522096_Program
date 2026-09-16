  <style type="text/css">
    .blue.btn {
      margin-bottom: 7px !important;

  }
  .form-horizontal .radio, .form-horizontal .checkbox, .form-horizontal .radio-inline, .form-horizontal .checkbox-inline {
   padding-top: 0px !important;


}
.select2-results .select2-disabled {
    background: none !important;
   color: darkgrey !important;
}
/*.info-div {
  position: relative;
 /* margin-top: -100px;*/
 /* z-index: 10;
  height: 450px;*/
 /* max-height: 1200px;*/
/*  overflow-y: scroll;
  overflow-x: scroll;
}*/
@media (min-width: 480px) {
  .select2-drop {
   width: 600px !important;
  }
  .dataTable {
    width: 100%;
  }
  .form-group.form-group-sm > a {
    margin-left: 40px;
  }
}

@media (min-width: 220px) and (max-width: 480px){
  body{
    font-size: 10px;
  }
}

</style>
  <div class="container-fluid">
  <div class="portlet light">
      <div class="portlet-title">
          <div class="caption font-dark">
            <span class="caption-subject bold uppercase"><?php echo $page_title; ?></span>
            <span class="caption-helper"></span>
          </div>
      </div>

              <?php
                echo anchor(NULL, '<i class="glyphicon glyphicon-chevron-left"></i> Kembali',
                [
                    'class'   => 'btn btn-default margin-right-2 pull-right',
                    'onclick' => 'go_back()'
                ]);

               ?>

      <div class="portlet-body">
          <?php
              $hidden_form = array('id' => !empty($id) ? $id : '');
              echo form_open_multipart($form_action, ['id' => 'finput', 'class' => 'form-horizontal'], $hidden_form);
              echo form_hidden('limit_app', !empty($limit_app) ? $limit_app : NULL);

          ?>

         
              <div class="form-group form-group-sm">
                  <?php echo form_hidden('id_project', !empty($id_project) ?$id_project : NULL, 'id = "id_project" class="id_project" ') ?>
                   <?php echo form_hidden('status_approve', '', 'id = "status_approve" class="status_approve" ') ?>

               <!--  <label class="col-md-2 col-xs-12 ">No Proyek :</label> -->
                  <!-- <div class="col-md-3 col-xs-12 mb col-sm-12">
                   <b> <?php// echo !empty($no_proyek) ?$no_proyek : NULL ;
                    // echo form_hidden('no_project',!empty($no_proyek) ?$no_proyek : NULL, 'class="form-control" readonly') ; ?></b>
                  </div> -->
                   <label class="col-md-2 col-xs-12 ">Tanggal MR :</label>
                <div class="col-md-3 col-xs-12 mb col-sm-12">
                
                     <b> <?php echo  date('d-m-Y',strtotime($tanggal_buat_mr))  ?></b>
                     
                </div>
           
                <label class="col-md-2 col-xs-12">Nama Proyek /  Department :</label>
                <div class="col-md-3 col-xs-12 mb col-sm-12">
                 <b> <?php echo !empty($nama_proyek) ? $nama_proyek : NULL ;
                  echo form_hidden('nama_project',!empty($nama_proyek) ? $nama_proyek : NULL, 'class="form-control" readonly'); ?></b>
                </div>
              </div>

              <div class="form-group form-group-sm">
                <label class="col-md-2 col-xs-12">Kode MR :</label>
                <div class="col-md-3 col-xs-12 mb col-sm-12">
                 <b> <?php  echo !empty($kode_mr) ? $kode_mr : NULL ;
                  echo form_hidden('kode_mr',!empty($kode_mr) ? $kode_mr : NULL, 'class="form-control" readonly') ; ?></b>
                </div>
            
                <label class="col-md-2 col-xs-12">Nama MR :</label>
                <div class="col-md-3 col-xs-12 mb col-sm-12">
                  <b><?php echo !empty($nama_permintan) ? $nama_permintan : NULL ;
                  form_hidden('nama_permintaan',!empty($nama_permintan) ? $nama_permintan : NULL, 'class="form-control" readonly ') ;?></b>
                </div>
              </div>

            

              <div class=" ">
                  <div class="table-responsive">
                    <table class="table table-striped table-bordered " style="margin-top: 10px;">
                            <thead>
                                <tr>
                                    <th class="span1">No</th>
                                  <!--   <th class="span1">Type MR</th> -->
                                    <th >Description</th>
                                    <th class="span1">Size</th> 
                                    <th class="span1">QTY</th>
                                    <th class="span1">Unit Satuan</th>
                                    <th class="span1">Part Number</th>
                                    <th class="span1">Account Code</th>
                                    <th class="span1">Unit Cost</th>
                                    <th class="span1">Total Cost</th> 
                                  <!--   <th class="span1">Lokasi (Station)</th>
                                    <th class="span1">Tgl Kebutuhan</th> -->

                                   <!--  <th>Remarks</th> -->
                                    <th>Lampiran</th>
                                    

                                </tr>
                            </thead>

                             <tbody >
                              <?php if (empty($id)) { ?>

                              <?php }else { ?>
                                <?php  $jml = count($data_equipment->result())+1 ;  echo form_hidden('jumlah_equipment', $jml , 'id = "jumlah_equipment" class="jumlah_equipment" ') ?>
                                <?php $no=1; $acc1 = 1; $n=1; $n2=1; $n3=1;
                                  foreach ($data_equipment->result() as $value) { ?>
                                      <tr  >
                                        <td > 
                                         
                                          <?php echo $no++; ?>
                                       
                                        </td>
                                        <!--  <td class="text-center" >
                                        
                                           

                                                 <?php// if ($value->type_equipment == 1) { echo "Asset";} ?>
                                                 <?php// if ($value->type_equipment == 2) { echo "Material Supply";} ?>
                                                <?php //if ($value->type_equipment == 3) { echo "Persediaan";} ?> 
                                               <?php //if ($value->type_equipment == 4) { echo "Jasa Sewa";} ?> 
                                                 <?php //if ($value->type_equipment == 5) { echo "Jasa Non Sewa";} ?>
                                           
                                         
                                        </td> -->
                                         
                                        <td class="text-center" > 
                                        
                                            <?php if ($value->type_equipment == 4 || $value->type_equipment == 5 ) { ?>

                                                 <?php echo !empty($value->description) ?$value->description : NULL ; ?>
                                             
                                            <?php } else { ?>
                                                 <?php echo !empty($value->description) ?$value->description : NULL ;?>
                                                
                                       
                                               <?php  echo !empty($value->desc_detail) ? $value->desc_detail: NULL; ?>
                                           
                                             <?php } ?>
                                        </td>

                                      <td class="text-center" >
                                    
                                       <?php echo !empty($value->size) ? $value->size : NULL; ?> 
                                     
                                     </td>
                                      <td class="text-center" >
                                         
                                           <?php echo !empty($value->quantity) ? $value->quantity: NULL ; ?>

                                        
                                        </td>
                                     <td class="text-center">
                                         
                                            <?php echo !empty($value->unit) ? $value->unit : NULL; ?>
                                        
                                        </td>
                                      
                                       
                                        <td class="text-center">
                                         
                                            <?php echo !empty($value->part_number) ? $value->part_number : NULL; ?>
                                        
                                        </td>
                                         <td class="text-center" >
                                          <?php echo form_hidden('id_equipment_'.$n++, $value->mr_equipment_id , 'id = "id_equipment" class="id_equipment" ') ?>
                                          <?php echo form_hidden('barang_id_'.$n2++, !empty($value->id_barang) ? $value->id_barang : NULL , 'id = "barang_id_'.$n3++.'" readonly') ?>
                                        <?php if( !is_null($value->acc_no) ){ ?>
                                               <?php echo form_dropdown('acc_no_'.$acc1++, $account_code, !empty($value->acc_no) ? $value->acc_no : NULL, 'class="form-control select2" readonly="" ') ?>
                                       <?php     }else if($value->acc_no == 0){ ?>
                                                <?php echo form_dropdown('acc_no_'.$acc1++, $account_code, !empty($value->acc_no) ? $value->code_account : NULL, 'class="form-control select2"') ?>
                                         <?php   }else{ ?>
                                               <?php echo form_dropdown('acc_no_'.$acc1++, $account_code, !empty($value->acc_no) ? $value->code_account : NULL, 'class="form-control select2"') ?>
                                         <?php } ?>
                                        </td>
                                        <td class="text-center" >
                                       
                                           <?php echo !empty($value->unit_cost) ? ''.$value->currency.' '.number_format($value->unit_cost, 2).'' : NULL ; ?>
                                        
                                        </td>
                                   <td class="text-center" >
                                       
                                            <?php echo !empty($value->total_cost) ? ''.$value->currency.' '.number_format($value->total_cost, 2).'': NULL ?>
                                         
                                        </td> 
                                     <!--    <td class="text-center">
                                          
                                            <?php ///echo !empty($value->lokasi_station) ? $value->lokasi_station : NULL; ?>
                                          
                                        </td> -->
                                       <!--  <td class="text-center">
                                         

                                           <?php //echo !empty($value->tgl_butuh) ? date('d-m-Y',strtotime($value->tgl_butuh))  : date('d-m-Y') ;?>

                                             <?php //if ($value->type_equipment == 4  || $value->type_equipment == 5 ) { 
                                               // $display = 'style="width:100px;"';
                                                //$text = '<div style="font-size:12px;"><b>masa sewa sampai</b></div>';
                                                //echo !empty($value->date_lama_sewa) ? date('d-m-Y',strtotime($value->date_lama_sewa))  : ////date('d-m-Y');
                                           //  } ?>
                                          
                                         
                                        </td> -->

                                    <!--     <td width="200px"> -->
                                        <!--  <?php //echo form_textarea('remarks_'.$oo2++,!empty($value->remarks) ? $value->remarks : NULL, 'class="form-control detaild" rows="4" id= "" placeholder="" readonly') ?> -->
                                        <!--  <?php //echo !empty($value->remarks) ? $value->remarks : NULL?>
                                        </td> -->

                                        <td>
                                         
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
                                             
                                            endif;
                                      ?>
                                     <a href="<?php echo $file_; ?>" target="_blank"> <?php echo $filename_ ?> </a>
                                        </td>
                                       
                                    </tr>
                                <?php } ?>
                              <?php } ?>
                            </tbody>
                         
                    </table>
                  </div>
              </div>
          
              <div class="form-group form-group-sm">
               <div class="col-md-12 col-xs-12">
                  <label class="col-md-1 col-xs-12">Note :  </label>
                  <div class="col-md-4 col-xs-12">
                     <?php echo  !empty($note) ? $note : '';?>
                  </div>
                  <div class="col-md-7 col-xs-12" >
                     <?php if (!empty($data_app)){ ?>
                       <b>Sudah Di Approve Oleh :</b>
                    <?php } ?>
                    <div class="table-responsive">
                    <table class="tbl-head-ttd table-bordered tbl_appr" width="">
                      <tr>
                      <td >
                        <table class="tbl_ttd table-bordered" width="100%" style="margin-right: 10px;"> 
                          <tr>
                            <td>REQUISITIONED BY,</td>
                            <td rowspan="2"> <img class="image-check" width="20px" src="<?php echo base_url() ?>assets/img/check-print.png"></td>
                          </tr>
                          <tr><td><?php echo $name_request->pegawai_nama ?><br><?php echo $name_request->nama_role ?></td></tr>

                        </table>
                      </td>
                     
                        <?php foreach ($data_app as $key => $valuee) { ?>
                        <td>
                          <table width="100%" class="tbl_ttd table-bordered">
                            <tr>
                              <td>APPROVED BY,</td>
                              <td rowspan='2'><img width="20px" class="image-check" src="<?php echo base_url() ?>assets/img/check-print.png"></td>
                            </tr>
                            <tr><td><?php echo $valuee->pegawai_nama ;?><br><?php echo $valuee->jabatan_nama ?></td></tr>
                          </table>
                        </td>
                      
                      <?php } ?>
                      
                      </tr>
                    </table>
                    </div>
                  </div>

                </div>
              </div>

              

            <div class="form-group form-group-sm">
             <div class="col-md-12 ">
                <label class="col-md-2 ">Keterangan Approve </label>
               <!--   <label class="col-md-1 col-xs-1">: </label> -->
                  <div class="col-md-8 ">
                     <?php echo form_textarea('catatan' ,!empty($value->catatan) ?  $value->catatan : NULL, 'class="form-control"  id="catatan" cols="4"  rows="4"') ?>
                  </div>
              </div>
            </div>

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
                <div class="">
                <?php if (!empty($id)) { ?>
                    <label class="col-md-2 col-xs-12">Lampiran MR </label>
                 <!--   <label class="col-md-1 col-xs-1">: </label> -->
                 <?php     if(!empty($lampiran_file_mr)){ 
                      foreach ($lampiran_file_mr->result() as $value) {
                      $file = json_decode($value->lampiran_new);
                      $file_ = $file->file;
                      $filename_ = $file->filename;
                ?>
              
                        <div class="col-md-2 col-xs-12  fileinput <?php echo!empty($lampiran_file_mr) ? 'fileinput-exists' : 'fileinput-new' ?>" data-provides="fileinput">

                          <span class="fileinput-filename del_<?php echo $value->id_lampiran ?>"> <a href="<?php echo $file_; ?>" target="_blank">  <?php echo $filename_ ?> </a></span>
                         
                        </div>
                   <?php 
                             } 
                         }
                    }
                  ?>
            </div>


         
      </div> 
      <div class="portlet-footer">
          <div class="modal-footer">

              <?php

              if ($nothing_approve == 2) {
                echo anchor(NULL, '<i class="glyphicon glyphicon-chevron-left"></i> Kembali',
                [
                    'class'   => 'btn btn-default margin-right-2',
                    'onclick' => 'go_back()'
                ]);

                 echo anchor(NULL, '<i class="fa fa-close"></i> Tolak', array(
                    'id' => 'mybutton-add',
                    'class' => 'btn btn-danger margin-right-2',
                    'onclick' => 'save_approve(3)'
                  ));

                  echo anchor(NULL, '<i class="fa fa-retweet" aria-hidden="true"></i> Revisi', array(
                      'id' => 'mybutton-add',
                      'class' => 'btn btn-warning',
                      'onclick' => 'save_approve(2)'
                  ));

                  echo anchor(NULL, '<i class="fa fa-gavel" aria-hidden="true"></i> Approve', array(
                      'id' => 'mybutton-add',
                      'class' => 'btn btn-success',
                      'onclick' => 'save_approve(1)'
                  ));
               }else{
                  echo $msg;
                 
               }

                


               ?>
          </div>
      </div>
      <?php echo form_close() ?>
</div>


<script type="text/javascript">
  pageSetUp();

   if( window.localStorage )
  {
    if( !localStorage.getItem('firstLoad') )
    {
      localStorage['firstLoad'] = true;
      window.location.reload();
    }  
    else
      localStorage.removeItem('firstLoad');
  }
 

  var no = 0;
          var total = 0;
            $.each($('#lk_list tr.lk_tr'), function () {
                no++;
               var jumlah = $('input.total_cost',this).val();
               if(jumlah){
                  total  += parseFloat(jumlah);
                }

            });
        $('#gran_total').val(total).number(true,2);

  var formBasic = $('form#finput');

  $('.radio .radio-inline .btn.disabled').click(function(event) {
     event.stopPropagation();
  });

  $(".radio").addClass("disabled");


 $('form#finput').submit(function(event) {
        event.preventDefault();
        formBasic.myForm().submit();
    });

 function save_approve(param){
    $('#status_approve').val(param)
     formBasic.myForm().submit();
 }


  var __afterSubmit = function() {
     $('.loading-save-form').css('display', 'none');
      setTimeout(function(){
        // my_form.go_back();
        // http://localhost/cpm/home#mr/mr/page_list_mr/66
       window.location = '<?php echo base_url(); ?>home#mr/mr/page_list_mr/<?php echo $id_project ;?>';
      },200);
    };

    var __afterSubmit_approve = function() {
     $('.loading-save-form').css('display', 'none');
      setTimeout(function(){
       window.location = '<?php echo base_url(); ?>home#mr/mr/page_list_mr/<?php echo $id_project ;?>';

         setTimeout(function(){
                 $('.nav-tabs a[href="#listapprove"]').tab('show');
                },800);
       
      },400);
       // setTimeout(function(){
       //           $('.nav-tabs a[href="#list_approve"]').tab('show');
       //          },200);
    };

    

    function go_back(){
       window.location = '<?php echo base_url(); ?>home#mr/mr/page_list_mr/<?php echo $id_project ;?>';
    }
     $('.144').addClass('active');

</script>
