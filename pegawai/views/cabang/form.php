<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
        <i class="fa fa-times"></i>
    </button>
    <h4 class="modal-title" id="myModalLabel">
        <?php echo $pageTitle; ?>
    </h4>
</div>
    <?php
        echo form_open_multipart($formAction, ['id' => 'finput', 'class' => 'form-horizontal']);
    ?>
<div class="modal-body">
    <fieldset>
        <div class="form-group">
            <label class="col-md-3 control-label">Kode <sup>*</sup></label>
            <div class="col-md-6">
                <?php echo form_input('cabang_id', !empty($data->cabang_id) ? $data->cabang_id : '', 'class="form-control"'); ?>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label">Nama Cabang <sup>*</sup></label>
            <div class="col-md-8">
                    <?php echo form_input('cabang_nama', !empty($data->cabang_nama) ? $data->cabang_nama : '', 'class="form-control"'); ?>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label">Alamat</label>
            <div class="col-md-8">
                    <?php echo form_textarea('cabang_alamat', !empty($data->cabang_alamat) ? $data->cabang_alamat : '', 'class="form-control"'); ?>
            </div>
        </div>
        <div class="form-group">
           <label class="col-md-3 control-label">Kotamadya<sup>*</sup></label>   
            <div class="col-md-8">
                <?php echo form_dropdown('kota_id', $kotamadya, !empty($data_edit->kota_id) ? $data_edit->kota_id : '', 'class="form-control select2"  id="kotamadya_id" data-source="' . base_url('master/kecamatan') . '/load_regency" data-rule-required="true"'); ?>
            </div>
        </div> 

         <div class="form-group">
            <label class="col-md-3 control-label">Telepon</label>
            <div class="col-md-8">
                    <?php echo form_input('cabang_telepon', !empty($data->cabang_telepon) ? $data->cabang_telepon : '', 'class="form-control numeric"'); ?>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label">Rekening</label>
            <div class="col-md-8">
                    <?php echo form_input('cabang_rekening', !empty($data->cabang_rekening) ? $data->cabang_rekening : '', 'class="form-control numeric"'); ?>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label">Kode Lokasi</label>
            <div class="col-md-4">
                    <?php echo form_input('kode_lokasi', !empty($data->kode_lokasi) ? $data->kode_lokasi : '', 'class="form-control numeric"'); ?>
            </div>
        </div>

    </fieldset>
    
</div>
<div class="modal-footer">
    <?php
        echo anchor(NULL, '<i class="glyphicon glyphicon-chevron-left"></i> Back', 
            [
                'class' => 'btn btn-labeled btn-default margin-right-2',
                'data-dismiss' => 'modal'
            ]);

        echo form_button(
            [  
                'type'    => 'submit',
                'content' => '<i class="glyphicon glyphicon-floppy-disk"></i> Save',
                'class'   => 'btn btn-success',
            ]);
    ?>
</div>
<?php echo form_close(); ?>

<script type="text/javascript"> 
    pageSetUp();
    var myform = $('form#finput').myForm({validation : true});

    var __afterSubmit = function(refresh) {
        $('.modal').modal('hide');
        mydatatable.reload(refresh);
    
    };
    
    $('form#finput').submit(function(event) {
        event.preventDefault();
        
        myform.submit();
    });
</script>