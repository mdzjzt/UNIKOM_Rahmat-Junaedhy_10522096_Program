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
            <label class="col-md-3 control-label">Kode<sup>*</sup></label>
            <div class="col-md-6">
                <?php echo form_input('jabatan_id', !empty($data->jabatan_id) ? $data->jabatan_id : '', 'class="form-control"'); ?>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label">Nama Jabatan<sup>*</sup></label>
            <div class="col-md-8">
                    <?php echo form_input('jabatan_nama', !empty($data->jabatan_nama) ? $data->jabatan_nama : '', 'class="form-control"'); ?>
            </div>
        </div>

       <!--  <div class="form-group">
            <label class="col-md-3 control-label">Jenis Jabatan</label>
            <div class="col-md-8">
                    <?php // echo form_dropdown('jenis_jabatan_id', $jenis, !empty($data->jenis_jabatan_id) ? $data->jenis_jabatan_id : '', 'class="form-control select2"'); ?>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label">Kelompok Jabatan</label>
            <div class="col-md-8">
                    <?php // echo form_dropdown('kelompok_jabatan_id', $kelompok, !empty($data->kelompok_jabatan_id) ? $data->kelompok_jabatan_id : '', 'class="form-control select2"'); ?>
            </div>
        </div> -->

        <!-- <div class="form-group">
            <label class="col-md-3 control-label">Tunjangan</label>
            <div class="col-md-8">
                <?php echo form_input('jabatan_tunjangan',!empty($data->jabatan_tunjangan) ? $data->jabatan_tunjangan : '', 'class="form-control number"'); ?>
            </div>
        </div> -->

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
    var myform = $('form#finput').myForm();

    var __afterSubmit = function(refresh) {
        $('.modal').modal('hide');
        mydatatable.reload(refresh);

    };

    $('form#finput').submit(function(event) {
        event.preventDefault();

        myform.submit();
    });
</script>
