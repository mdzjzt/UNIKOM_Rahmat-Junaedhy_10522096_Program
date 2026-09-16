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
    $hidden_form = array('edit_id' => !empty($edit_id) ? $edit_id : '', 'm_m_id_menu' => !empty($m_m_id_menu) ? $m_m_id_menu : '');
    echo form_open_multipart($form_action, array('id' => 'finput', 'class' => 'form-horizontal'), $hidden_form);
    ?>
    <fieldset>
        <div class="form-group">
            <label class="col-md-4 control-label">Provinsi<sup>*</sup></label>   
            <div class="col-md-6">
                <?php echo form_dropdown('provinsi_id', $provinsi, !empty($data_edit->provinsi_id) ? $data_edit->provinsi_id : '', 'class="form-control select2" id="provinsi_id" target-options="kotamadya_id" data-rule-required="true"'); ?>
            </div>
        </div> 
        <div class="form-group">
            <label class="col-md-4 control-label">Kotamadya<sup>*</sup></label>   
            <div class="col-md-6">
                <?php echo form_dropdown('kotamadya_id', $kotamadya, !empty($data_edit->kota_id) ? $data_edit->kota_id : '', 'class="form-control select2"  id="kotamadya_id" data-source="' . base_url('master/kecamatan') . '/load_regency" data-rule-required="true"'); ?>
            </div>
        </div> 
        <div class="form-group">
            <label class="col-md-4 control-label">Nama Kecamatan<sup>*</sup></label>
            <div class="col-md-6">
                <?php echo form_input('kecamatan_name', !empty($data_edit->kecamatan_nama) ? $data_edit->kecamatan_nama : '', 'class="form-control" data-rule-required="true"'); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">Kode Pos<sup>*</sup></label>
            <div class="col-md-6">
                <?php echo form_input('kecamatan_kodepos', !empty($data_edit->kodepos) ? $data_edit->kodepos : '', 'class="form-control numeric" data-rule-required="true"'); ?>
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
    $('.numeric').numeric();
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

    $(function () {
        my_form.ajax.options("provinsi_id", 'select2');
        my_form.ajax.options("kotamadya_id", 'select2', $('#kotamadya_id').data('selected'));

        $('#provinsi_id').change(function () {
            my_form.ajax.options("provinsi_id", 'select2');
        });
        $('#kotamadya_id').change(function () {
            my_form.ajax.options("kotamadya_id");
        });
     });   

       
</script>

       
