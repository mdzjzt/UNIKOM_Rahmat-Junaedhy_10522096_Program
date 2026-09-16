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
                <label class="col-md-2 control-label">NAMA CURRENCY <sup>*</sup></label>
                <div class="col-md-3">
                    <?php  echo form_input('nama_currency',!empty($data->nama_currency) ? $data->nama_currency : NULL, 'class="form-control " placeholder="US Dollar" ') ?>
                </div>
              </div>

              <div class="form-group form-group-sm">
                <label class="col-md-2 control-label">CURRENCY <sup>*</sup></label>
                <div class="col-md-3">
                    <?php  echo form_input('currency',!empty($data->currency) ? $data->currency : NULL, 'class="form-control " placeholder="USD" ') ?>
                </div>
              </div>
              
               <div class="form-group form-group-sm">
                <label class="col-md-2 control-label">SIMBOL CURRENCY <sup>*</sup></label>
                <div class="col-md-3">
                   <?php  echo form_input('simbol_currency',!empty($data->simbol_currency) ? $data->simbol_currency : NULL, 'class="form-control " placeholder="$"  ') ?>
                </div>
              </div>
               <div class="form-group form-group-sm">
                <label class="col-md-2 control-label">NEGARA <sup>*</sup></label>
                <div class="col-md-3">
                    <?php  echo form_input('negara',!empty($data->negara) ? $data->negara : NULL, 'class="form-control " placeholder="United States of America" ') ?>
                </div>
              </div>
               <div class="form-group form-group-sm">
                <label class="col-md-2 control-label">DESCRIPTION<sup>*</sup></label>
                <div class="col-md-3">
                   <?php  echo form_textarea('desc',!empty($data->desc) ? $data->desc : NULL, 'class="form-control "  ') ?>
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