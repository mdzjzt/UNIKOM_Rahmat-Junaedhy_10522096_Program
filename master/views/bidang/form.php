<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
        <i class="fa fa-times"></i>
    </button>
    <h6 class="modal-title" id="myModalLabel">
        <span class="widget-icon"> <i class="fa fa-edit"></i> </span> <?php echo $page_title; ?>
    </h6>
</div>
<div class="modal-body">
    <?php
    $hidden_form = array('edit_id' => !empty($edit_id) ? $edit_id : '');
    echo form_open_multipart($form_action, array('id' => 'finput', 'class' => 'form-horizontal'), $hidden_form);
    ?>
    <fieldset>
        <div class="form-group">
            <label class="col-md-3 control-label">Kode<sup>*</sup></label>
            <div class="col-md-6">
                <?php echo form_input('bidang_kode', !empty($data_edit->bidang_kode) ? $data_edit->bidang_kode : '', 'class="form-control" data-rule-required="true"'); ?>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label">Nama Bidang<sup>*</sup></label>
            <div class="col-md-8">
                    <?php echo form_input('bidang_name', !empty($data_edit->bidang_name) ? $data_edit->bidang_name : '', 'class="form-control" data-rule-required="true"'); ?>
                <span id="error_menu_url"></span>
            </div>
        </div>

    </fieldset>
    <?php echo form_close(); ?>
</div>
<div class="modal-footer">
    <?php
    echo anchor(NULL, '<span class="btn-label"><i class="glyphicon glyphicon-chevron-left"></i></span> Back', array(
        'id' => 'mybutton-add',
        'class' => 'btn btn-labeled btn-default margin-right-2',
        'data-dismiss' => 'modal'
    ));
    echo anchor(NULL, '<span class="btn-label"><i class="glyphicon glyphicon-floppy-disk"></i></span> Save', array(
        'id' => 'mybutton-add',
        'class' => 'btn btn-labeled btn-success',
        'onclick' => '$(\'#finput\').submit()'
    ));
    ?>
</div>

<script type="text/javascript">

    pageSetUp();
    my_form.init();

    var __after_process = function(ket) {

        if(ket == 1) {
            my_form.reset('#finput');
            $('#remoteModal').modal('hide');
        }
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
