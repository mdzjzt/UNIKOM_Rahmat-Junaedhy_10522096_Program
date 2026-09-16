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
                <label class="col-md-2 control-label">Code Account <sup>*</sup></label>
                <div class="col-md-3">
                    <?php  echo form_input('code_account',!empty($data->code_account) ? $data->code_account : NULL, 'class="form-control numberr" ') ?>
                </div>
              </div>
              
               <div class="form-group form-group-sm">
                <label class="col-md-2 control-label">Description <sup>*</sup></label>
                <div class="col-md-3">
                   <?php  echo form_input('description',!empty($data->description) ? $data->description : NULL, 'class="form-control "  ') ?>
                </div>
              </div>
               <div class="form-group form-group-sm">
                <label class="col-md-2 control-label">Masa Penyusutan <sup>*</sup></label>
                <div class="col-md-3">
                   <?php  echo form_input('masa_penyusutan',!empty($data->masa_penyusutan) ? $data->masa_penyusutan : NULL, 'class="form-control "  ') ?>
                </div>
              </div>
               <div class="form-group form-group-sm">
                <label class="col-md-2 control-label">Persen Penyusutan <sup>*</sup></label>
                <div class="col-md-3">
                   <?php  echo form_input('persen_penyusutan',!empty($data->persen_penyusutan) ? $data->persen_penyusutan : NULL, 'class="form-control "  ') ?>
                </div>
              </div>
               <div class="form-group form-group-sm">
                <label class="col-md-2 control-label">Remarks</label>
                <div class="col-md-3">
                   <?php  echo form_textarea('remarks',!empty($data->remarks) ? $data->remarks : NULL, 'class="form-control"  ') ?>
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