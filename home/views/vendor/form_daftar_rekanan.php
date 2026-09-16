        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                <i class="fa fa-times"></i>
            </button>
            <h4 class="modal-title" id="myModalLabel">
                <span class="widget-icon"> <i class="fa fa-edit"></i> </span> <?php echo $page_title; ?>
            </h4>
        </div>
        <div class="modal-body">
            <?php
            $hidden_form = array('edit_id' => !empty($edit_id) ? $edit_id : '');
            echo form_open_multipart($form_action, array('id' => 'finput', 'class' => 'form-horizontal'), $hidden_form);
            ?>
            <fieldset>
                <div class="form-group">
		
                <div class="form-group">
                    <label class="col-md-5 control-label">Mulai Tanggal <sup>*</sup></label>
                    <div class="col-md-5">
			    <div class='input-group date' id='event_start1'>
				<input name="tgl_laporan" id="tgl_laporan" type='text' class="form-control" />
				<span class="input-group-addon"><span class="fa fa-calendar"></span>
				</span>
			    </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-5 control-label">Sampai Dengan Tanggal<sup>*</sup></label>
                    <div class="col-md-5">
			    <div class='input-group date' id='event_start2'>
				<input name="sampai_tgl_laporan" id="sampai_tgl_laporan" type='text' class="form-control" />
				<span class="input-group-addon"><span class="fa fa-calendar"></span>
				</span>
			    </div>
                    </div>
                </div>
		
                <div class="form-group">
                    <label class="col-md-5 control-label">Nama Pejabat<sup>*</sup></label>
                    <div class="col-md-5">
                    <?php echo form_dropdown('listkaryawan', $pegawai_options, '', 'class="form-control select2" placeholder="" ') ?>
                    </div>
                </div>

            </fieldset>
            <?php echo form_close() ?>
        </form>
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
            'onclick' => 'my_form.submit(\'#finput\')'
        ));
        ?>
    </div>

    <script type="text/javascript">
        $(function () {
            $('#event_start1').datetimepicker({pickTime: false, format: 'YYYY-DD-MM'});
            $('#event_start2').datetimepicker({pickTime: false, format: 'YYYY-DD-MM'});
        });
        $('#glbaranglbu').change(function () {
            $.post("<?php echo base_url(); ?>home/inventarisasi/get_bidang/" + $('#glbaranglbu').val(), {}, function (obj) {
                $('#bidangbarang').html(obj);
            });
        });
        pageSetUp();
        my_form.init();

        var load_and_reset_form = function () {
            pagefunction();
            my_form.reset('#finput');
        };

        var __after_process = function (ket) {

            if (ket == 1)
                my_form.reset('#finput');

            my_data_table.reload('#dt_basic');
        };
    </script>
