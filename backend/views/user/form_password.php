<div class="container-fluid">
  <div class="portlet light">
      <div class="portlet-title">
          <div class="caption font-dark">
            <span class="caption-subject bold uppercase"><?php echo $pageTitle; ?></span>
            <span class="caption-helper"></span>
          </div>
      </div>
    <?php
        echo form_open_multipart($formAction, ['id' => 'finput', 'class' => 'form-horizontal']);
    ?>
    <div class="portlet-body">
        <fieldset>
            <div class="form-group">
                <label class="col-md-3 control-label">Password Lama : <sup>*</sup></label>
                <div class="col-md-3">
                    <?php echo form_password('password_lama', NULL, 'class="form-control"'); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">Password Baru  : <sup>*</sup></label>
                <div class="col-md-3">
                    <?php echo form_password('password_baru', NULL, 'class="form-control"'); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">Password Baru (konfirmasi) : <sup>*</sup></label>
                <div class="col-md-3">
                    <?php echo form_password('konf_password', NULL, 'class="form-control"'); ?>
                </div>
            </div>            
        </fieldset>
    </div>
      <div class="portlet-title">
          <div class="modal-footer">
              <?php
                echo anchor(NULL, '<i class="glyphicon glyphicon-chevron-left"></i> Kembali', 
                    [
                        'id' => 'mybutton-add',
                        'class' => 'btn btn-labeled btn-default margin-right-2',
                        'onclick' => 'my_form.go_back()'
                    ]);
                
                echo form_button(
                    [  
                        'type'    => 'submit',
                        'content' => '<i class="glyphicon glyphicon-floppy-disk"></i> Save',
                        'class'   => 'btn btn-success',
                    ]);
              ?>
          </div>
      </div>
    <?php echo form_close() ?>
  </div>

 
</div>


<script type="text/javascript">
    pageSetUp();
    var myForm = $('form#finput');

    myForm.submit(function(event) {
        event.preventDefault();
        $(this).myForm({
            success : function(data) {
                my_global.go_back();
            }
        }).submit();
    });
</script>