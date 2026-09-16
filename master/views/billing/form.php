<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
        <i class="fa fa-times"></i>
    </button>
    <h4 class="modal-title" id="myModalLabel">
        <i class="fa fa-edit"></i>  <?php echo $page_title; ?>
    </h4>
</div>
<div class="modal-body">
    <?php
    $hidden_form = array('edit_id' => !empty($edit_id) ? $edit_id : '');
    echo form_open_multipart($form_action, array('id' => 'finput', 'class' => 'form-horizontal'), $hidden_form);
    ?>
    <fieldset>
        <div class="form-group">
            <label class="col-md-3 control-label">Kualifikasi<sup>*</sup></label>
            <div class="col-md-6">
                <?php echo form_input('billing_kualifikasi', !empty($data_edit->billing_kualifikasi) ? $data_edit->billing_kualifikasi : '', 'class="form-control" data-rule-required="true"'); ?>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label">Posisi<sup>*</sup></label>
            <div class="col-md-8">
                    <?php echo form_input('billing_posisi', !empty($data_edit->billing_posisi) ? $data_edit->billing_posisi : '', 'class="form-control" data-rule-required="true"'); ?>
                <span id="error_menu_url"></span>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label">Pengalaman Kerja<sup>*</sup></label>
            <div class="col-md-8">
                <div class="input-group">
                     <span class="input-group-addon">Tahun</span>
                    <?php echo form_input('billing_pengalaman_kerja', !empty($data_edit->billing_pengalaman_kerja) ? $data_edit->billing_pengalaman_kerja : '', 'class="form-control" data-rule-required="true"'); ?>
                    <span id="error_menu_url"></span>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label">Harga Min<sup>*</sup></label>
            <div class="col-md-8">
                <div class="input-group">
                     <span class="input-group-addon">Rp</span>
                    <?php echo form_input('billing_harga_min', !empty($data_edit->billing_harga_min) ? $data_edit->billing_harga_min : '', 'class="form-control number" data-rule-required="true" id="billing-min"'); ?>
                    <span id="error_menu_url"></span>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label">Harga Max<sup>*</sup></label>
            <div class="col-md-8">
                <div class="input-group">
                     <span class="input-group-addon">Rp</span>
                    <?php echo form_input('billing_harga_max', !empty($data_edit->billing_harga_max) ? $data_edit->billing_harga_max : '', 'class="form-control number" data-rule-required="true"'); ?>
                    <span id="error_menu_url"></span>
                </div>
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
    
    jQuery.validator.addMethod("greaterThan", 
        function(value, element, params) {

            if (!/Invalid|NaN/.test(new Date(value))) {
                return new Date(value) > new Date($(params).val());
            }

            return isNaN(value) && isNaN($(params).val()) 
                || (Number(value) > Number($(params).val())); 
        },'Must be greater than Harga Min.');


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
        
        rules: {
            billing_harga_max: { greaterThan: "#billing-min" }
        },

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
