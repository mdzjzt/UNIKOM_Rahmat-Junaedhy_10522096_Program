<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
        <i class="fa fa-times"></i>
    </button>
    <h4 class="modal-title" id="myModalLabel">
        <?php echo $page_title; ?>
    </h4>
</div>
<div class="modal-body">
    <?php
        $hidden_form = array('edit_id' => !empty($edit_id) ? $edit_id : '');
        echo form_open_multipart($form_action, array('id' => 'finput', 'class' => 'form-horizontal'), $hidden_form);
    ?>
    <fieldset>
        <div class="form-group">
            <label class="col-md-3 control-label">Kode <sup>*</sup></label>
            <div class="col-md-6">
                <?php echo form_input('letak_kode', !empty($data_edit->letak_kode) ? $data_edit->letak_kode : '', 'class="form-control" data-rule-required="true"'); ?>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label">Letak <sup>*</sup></label>
            <div class="col-md-8">
                <?php echo form_input('letak_name', !empty($data_edit->letak_name) ? $data_edit->letak_name : '', 'class="form-control" data-rule-required="true"'); ?>
            </div>
        </div>

    </fieldset>
    <?php echo form_close(); ?>
</div>
<div class="modal-footer">
    <?php
    echo anchor(NULL, '<i class="glyphicon glyphicon-chevron-left"></i> Back', array(
        'id' => 'mybutton-add',
        'class' => 'btn btn-default margin-right-2',
        'data-dismiss' => 'modal'
    ));
    echo anchor(NULL, '<i class="glyphicon glyphicon-floppy-disk"></i> Save', array(
        'id' => 'mybutton-add',
        'class' => 'btn btn-success',
        'onclick' => '$(\'#finput\').submit()'
    ));
    ?>
</div>

<script type="text/javascript">

    pageSetUp();
    my_form.init();

    var __after_process = function(ket) {
        $('#remoteModal').modal('hide');
        my_data_table.reload('#dt_basic');
    };

    $("#finput").validate({
        errorElement : 'span',
        errorClass : 'help-block',

        invalidHandler: function (event, validator) { 
            command: toastr["error"]('Terjadi kesalahan ! <br>Periksa kembali data input');
        },

        highlight : function(element) {
            $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
        },

        unhighlight : function(element) {
            $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
        },
        
        errorPlacement : function(error, element) {
            
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        },

        submitHandler: function (form) {
           my_form.submit('#finput');
        }
    });
</script>
