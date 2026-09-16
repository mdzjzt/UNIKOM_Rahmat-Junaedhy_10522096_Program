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
                    'onclick' => 'my_form.go_back()'
                ]);
                
               ?>
      
      <div class="portlet-body">
          <?php
              $hidden_form = array('id' => !empty($id) ? $id : '');
              echo form_open_multipart($form_action, ['id' => 'finput', 'class' => 'form-horizontal'], $hidden_form);
          ?>

          <fieldset>
            
              <div class="form-group form-group-sm">
                <label class="col-md-2 control-label">NAMA CUSTOMER <sup>*</sup></label>
                <div class="col-md-3">
                    <?php  echo form_input('nama_customer',!empty($data->nama_customer) ? $data->nama_customer : NULL, 'class="form-control " placeholder="PT Citra Panji Manunggal" ') ?>
                </div>
              </div>

              <div class="form-group form-group-sm">
                <label class="col-md-2 control-label">ALAMAT LENGKAP<sup>*</sup></label>
                <div class="col-md-3">
                 <?php  echo form_textarea('alamat_customer',!empty($data->alamat_customer) ? $data->alamat_customer : NULL, 'class="form-control "  ') ?>
                 
                </div>
              </div>
              
              <div class="form-group form-group-sm">
                <label class="col-md-2 control-label">NAMA CONTACT  <sup>*</sup></label>
                <div class="col-md-3">
                   <?php  echo form_input('contact_nama',!empty($data->contact_nama) ? $data->contact_nama : NULL, 'class="form-control " placeholder="Alex Adam"  ') ?>
                </div>
              </div>
              <div class="form-group form-group-sm">
                <label class="col-md-2 control-label">NO HP CONTACT   <sup>*</sup></label>
                <div class="col-md-3">
                   <?php  echo form_input('contact_phone',!empty($data->contact_phone) ? $data->contact_phone : NULL, 'class="form-control " placeholder="08457647954554"  ') ?>
                </div>
              </div>
              
              <!--  <div class="form-group form-group-sm">
                <label class="col-md-2 control-label">NEGARA <sup>*</sup></label>
                <div class="col-md-3">
                    <?php // echo form_input('negara',!empty($data->negara) ? $data->negara : NULL, 'class="form-control " placeholder="United States of America" ') ?>
                </div>
              </div> -->
              <div class="form-group form-group-sm">
                <label class="col-md-2 control-label">EMAIL <sup>*</sup></label>
                <div class="col-md-3">
                     <?php  echo form_input('email_customer',!empty($data->email_customer) ? $data->email_customer : NULL, 'class="form-control " placeholder="Adam@gmail.com" ') ?>
                </div>
              </div>
              <div class="form-group form-group-sm">
                <label class="col-md-2 control-label">TAX NAME <sup>*</sup></label>
                <div class="col-md-3">
                   <?php  echo form_input('nama_tax',!empty($data->nama_tax) ? $data->nama_tax : NULL, 'class="form-control " placeholder="PPN"  ') ?>
                </div>
              </div>
              <div class="form-group form-group-sm">
                <label class="col-md-2 control-label">TAX NUMBER <sup>*</sup></label>
                <div class="col-md-3">
                   <?php  echo form_input('tax_number',!empty($data->tax_number) ? $data->tax_number : NULL, 'class="form-control " placeholder="869.009.857.986.000"  ') ?>
                </div>
              </div>
              <div class="form-group form-group-sm">
                <label class="col-md-2 control-label">TAX CODE <sup>*</sup></label>
                <div class="col-md-3">
                   <?php  echo form_input('tax_code',!empty($data->tax_code) ? $data->tax_code : NULL, 'class="form-control " placeholder="411211-100"  ') ?>
                </div>
              </div>
              </div>
          </fieldset>
      </div>
      <div class="portlet-footer">
          <div class="modal-footer">
              <?php
                echo anchor(NULL, '<i class="glyphicon glyphicon-chevron-left"></i> Kembali', array(
                    'id' => 'mybutton-add',
                    'class' => 'btn btn-default margin-right-2',
                    'onclick' => 'my_form.go_back()'
                ));
                echo anchor(NULL, '<i class="glyphicon glyphicon-floppy-disk"></i> Simpan', array(
                    'id' => 'mybutton-add',
                    'class' => 'btn btn-success',
                    'onclick' => '$(\'form#finput\').submit()'
                ));
               ?>
          </div>
      </div>
      <?php echo form_close() ?>
  </div>
</div>


<div class="modal container" id="modalPegawai" data-backdrop="static" tabindex="-1"> </div>
<!-- /.modal -->

<script type="text/javascript">
    pageSetUp();

    var formBasic = $('form#finput');
    $('form#finput').submit(function(event) {
        event.preventDefault();
        formBasic.myForm().submit();
    });

    $("form#filter_table").bind('submit',function(){
       my_data_table.reload('#dt_akun');
       return false;
    });

   var __afterSubmit = function() {
        setTimeout(function(){
          my_form.go_back();
        },200);
      };


    
</script>