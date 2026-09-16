<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
        <i class="fa fa-times"></i>
    </button>
    <h6 class="modal-title" id="myModalLabel">
        <span class="widget-icon"> <i class="fa fa-edit"></i> </span> Tambah<?php //echo $page_title; ?>
    </h6>
</div>
<div class="modal-body" style="overflow:hidden" >
	<?php
		$hidden_form = array(
			'edit_id' => !empty($edit_id) ? $edit_id : '',
			'tanggal_berlaku' => !empty($default->tanggal_berlaku) ? hgenerator::switch_tanggal($default->tanggal_berlaku) : '',
			'tanggal_berakhir' => !empty($default->tanggal_berakhir) ? hgenerator::switch_tanggal($default->tanggal_berakhir) : ''
		);
		echo form_open_multipart($form_action, array('id' => 'finput', 'class' => 'form-horizontal'), $hidden_form);
	?>
    <fieldset>
    
        <div class="form-group">
            <label class="col-md-3 control-label">Nama Area<sup>*</sup></label>
            <div class="col-md-6">
                <?php echo form_dropdown('kd_cabang', $lokasikerja_options, !empty($default->kd_cabang) ? $default->kd_cabang : '', 'id="kd_cabang" class="select2"') ?>
            </div>
        </div>
    
        <div class="form-group">
            <label class="col-md-3 control-label">Nama Unit Kerja<sup>*</sup></label>
            <div class="col-md-6">
                <?php echo form_dropdown('kd_unit_kerja', $unitkerja_options, !empty($default->kd_unit_kerja) ? $default->kd_unit_kerja : '', 'id="kd_unit_kerja" class="select2" data-source="' . $unitkerja_source . '"') ?>
            </div>
        </div>
    
        <div class="form-group">
            <label class="col-md-3 control-label">Nama Jabatan<sup>*</sup></label>
            <div class="col-md-6">
                <?php echo form_dropdown('kd_jabatan', $jabatan_options, !empty($default->kd_jabatan) ? $default->kd_jabatan : '', 'id="kd_jabatan" class="select2"') ?>
            </div>
        </div>
    
        <div class="form-group">
            <label class="col-md-3 control-label">Pilih Parent </label>
            <div class="col-md-6">
                <?php echo form_dropdown('parent', $parent_options, !empty($default->parent) ? $default->parent : '', 'id="parent" class="select2"') ?>
            </div>
        </div>
    
        <div class="form-group">
            <label class="col-md-3 control-label">Status<sup>*</sup></label>
            <div class="col-md-6">
                      <?php echo form_dropdown('status', array(''=>'Semua Status','t'=>'Masih Berlaku','f'=>'Tidak Berlaku'), !empty($default->status) ? $default->status : '', 'id="tahun" class="select2"') ?>
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
    
    /*
	function get_options(target, data, chosen, type) {
	    var st_chosen = false;

	    if (typeof chosen !== 'undefined')
		st_chosen = chosen;

	    if (typeof type === 'undefined' || type === 'options') {
		$(target).html('<option value="">Loading...</option>');
		if (st_chosen)
		    $(target).trigger('liszt:updated');
	    } else {
		$(target).html('Loading...');
	    }
	    var link = $(target).attr('data-source');
		alert(link);
	    $.post(link, data, function(res) {
		if (typeof type === 'undefined' || type === 'options') {
		    $(target).html(res);
		    if (st_chosen)
			$(target).trigger('liszt:updated');
		} else {
		    $(target).val(res);
		}
	    }, 'json');
	};
        $('#kd_cabang').change(function() {
            var id = $(this).val();
            var selected = '';
            get_options('#kd_unit_kerja', {kode: id, selected: selected}, true);
        });
    
        get_options('#kd_unit_kerja', {kode: '<?php echo!empty($default->kd_cabang) ? $default->kd_cabang : ''; ?>', selected: '<?php echo!empty($default->kd_unit_kerja) ? $default->kd_unit_kerja : ''; ?>'}, true);
	*/
</script>