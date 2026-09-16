        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                <i class="fa fa-times"></i>
            </button>
            <h4 class="modal-title" id="myModalLabel">
                FORM GOLONGAN
            </h4>
        </div>
        <div class="modal-body">
            <?php
                $hidden_form = array('edit_id' => !empty($edit_id) ? $edit_id : '', 'm_m_id_menu' => !empty($m_m_id_menu) ? $m_m_id_menu : '');
                echo form_open_multipart($form_action, array('id' => 'finput', 'class' => 'form-horizontal'), $hidden_form);
            ?>
            <fieldset>

                <div class="form-group">
                    <label class="col-md-3 control-label">Kode GL Konven<sup>*</sup></label>
                    <div class="col-md-8">
                        <?php echo form_input('gl_kode', !empty($data_edit->gl_kode) ? $data_edit->gl_kode : '', 'class="form-control" data-rule-required="true"') ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Kode GL Syariah<sup>*</sup></label>
                    <div class="col-md-8">
                        <?php echo form_input('gl_kode_syariah', !empty($data_edit->gl_kode_syariah) ? $data_edit->gl_kode_syariah : '', 'class="form-control" ') ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Kode Golongan<sup>*</sup></label>
                    <div class="col-md-8">
                        <?php echo form_input('gl_nama', !empty($data_edit->gl_nama) ? $data_edit->gl_nama : '', 'class="form-control" data-rule-required="true"') ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Nama Rekening<sup>*</sup></label>
                    <div class="col-md-8">
                        <?php echo form_input('gl_rekening', !empty($data_edit->gl_rekening) ? $data_edit->gl_rekening : '', 'class="form-control" data-rule-required="true"') ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Deskripsi</label>
                    <div class="col-md-8">
                        <?php echo form_textarea('gl_dk', !empty($data_edit->gl_dk) ? $data_edit->gl_dk : '', 'rows = 3 class="form-control"') ?>
                    </div>
                </div>

                <div class="form-group form-group-sm">
                    <label class="col-md-3 control-label">Masa Penyusutan</label>
                    <div class="col-md-3">
                        <div class="input-group">
                            <?php echo form_input('masa_penyusutan', !empty($data_edit->masa_penyusutan) ? $data_edit->masa_penyusutan : NULL, 'class="form-control"'); ?>
                            <span class="input-group-addon">Tahun</span>
                        </div>
                        
                    </div>
                </div>

                <div class="form-group form-group-sm">
                    <label class="col-md-3 control-label">Presentasi Penyusutan</label>
                    <div class="col-md-2">
                        <div class="input-group">
                            <?php echo form_input('persen_penyusutan', !empty($data_edit->persen_penyusutan) ? $data_edit->persen_penyusutan : NULL, 'class="form-control"'); ?>
                            <span class="input-group-addon">%</span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Kategori</label>
                    <div class="col-md-5">
                        <?php echo form_dropdown('gl_kategori',array('barang' => 'Barang','jasa' => 'Jasa','perbaikan' => 'Lainnya'),!empty($data_edit->kategori) ? $data_edit->kategori : NULL,'class="form-control"') ?>
                    </div>
                </div>


            </fieldset>
            <?php echo form_close(); ?>
        </div>
        <div class="modal-footer">
            <?php
            echo anchor(NULL, '<i class="glyphicon glyphicon-chevron-left"></i> Back', array(
                'id' => 'mybutton-add',
                'class' => 'btn btn-labeled btn-default margin-right-2',
                'data-dismiss' => 'modal'
            ));
            echo anchor(NULL, '<i class="glyphicon glyphicon-floppy-disk"></i> Save', array(
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
