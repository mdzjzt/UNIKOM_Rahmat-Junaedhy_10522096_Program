<div class="container-fluid">
  <div class="portlet light">
      <div class="portlet-title">
          <div class="caption font-dark">
            <span class="caption-subject bold uppercase"><?php echo $page_title; ?></span>
            <span class="caption-helper"></span>
          </div>
      </div>
    <?php echo form_open_multipart($form_action, ['id' => 'finput', 'class' => 'form-horizontal'] ) ?>
      <div class="portlet-body">
        <fieldset>
            <div class="form-group">
                <label class="col-md-2 control-label">Username <sup>*</sup></label>
                <div class="col-md-3">
                    <?php echo form_input('username_user', !empty($data_edit->username_user) ? $data_edit->username_user : '', 'class="form-control"'); ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label">Pegawai <sup>*</sup></label>
                <div class="col-md-5"  id="participan_name">
                    <?php echo form_dropdown('id_pegawai', $opt_pegawai, !empty($data_edit->id_pegawai) ? $data_edit->id_pegawai : '', 'class="form-control select2" id="pegawai" '); ?>
                    <div class="note">
                        <table>
                            <tr>
                                <td><strong>Nik</strong></td>
                                <td> : <span id="txt-nik"></span></td>
                            </tr>
                         <!--    <tr>
                                <td><strong>Cabang</strong></td>
                                <td> : <span id="txt-cabang"></span></td>
                            </tr> -->
                            <tr>
                                <td><strong>Jabatan</strong></td>
                                <td> : <span id="txt-jabatan"></span></td>
                            </tr>
                           <!--  <tr>
                                <td><strong>Unit Kerja</strong></td>
                                <td> : <span id="txt-unitkerja"></span></td>
                            </tr> -->
                        </table>
                        
                    </div>
                    <span id="error_employee_name"></span>
                </div>
            </div>
          <!--   <div class="form-group">
                <label class="col-md-2 control-label">Divisi Pengadaan ?</label>
                <div class="col-md-2">
                    <?php // echo form_checkbox('is_staff', 1,!empty($data_edit->is_staff) ? TRUE : FALSE,'class="checkbox"'); ?>
                </div>
            </div><div class="form-group">
                <label class="col-md-2 control-label">Petugas Pengadaan (Bukan Pejabat) ?</label>
                <div class="col-md-2">
                    <?php // echo form_checkbox('is_petugas', 1,!empty($data_edit->is_petugas) ? TRUE : FALSE,'class="checkbox"'); ?>
                </div>
            </div> -->

           <!--  <div class="form-group">
                <label class="col-md-2 control-label">Kategori</label>
                <div class="col-md-2">
                    <?php // echo form_dropdown('kategori',array('1' => 'Konven','2' => 'Syariah'), !empty($data_edit->kategori) ? $data_edit->kategori : NULL,'class="form-control"') ?>
                </div>
            </div> -->

            <div class="form-group">
                <label class="col-md-2 control-label">Role <sup>*</sup></label>
                <div class="col-md-5">
                    <?php echo form_dropdown('id_role', $opt_role, !empty($data_edit->id_role) ? $data_edit->id_role : '', 'class="form-control select2"'); ?>                    
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label">Status</label>
                <div class="col-md-2">
                    <?php echo form_dropdown('active_user', $opt_st, !empty($data_edit->active_user) ? $data_edit->active_user : NULL, 'class="form-control"'); ?>
                </div>
            </div>

          <!--   <div class="form-group">
                <label class="col-md-2 control-label">Filter Data Inventaris</label>
                <div class="col-md-9">
                    <?php // echo form_dropdown('cabang_id[]', $opt_cabang, !empty($data_edit->data_cabang) ? json_decode($data_edit->data_cabang) : NULL, 'class="form-control select2" multiple'); ?>
                </div>
            </div> -->
        </fieldset>
      </div>
      <div class="portlet-title">
          <div class="modal-footer">
              <?php
                echo anchor(NULL, '<i class="glyphicon glyphicon-chevron-left"></i> Kembali', array(
                    'class' => 'btn btn-labeled btn-default margin-right-2',
                    'onclick' => 'my_global.go_back()'
                ));

                echo form_button([  
                        'type'    => 'submit',
                        'content' => '<i class="glyphicon glyphicon-floppy-disk"></i> Simpan',
                        'class'   => 'btn btn-success',
                ]);
              ?>
          </div>
      </div>
      <?php echo form_close(); ?>
  </div>
</div>


<script type="text/javascript">
    pageSetUp();

    var __afterSubmit = function(refresh) {
        my_global.go_back();
    };

    var myform = $('form#finput').myForm();

    $('form#finput').submit(function(event) {
        event.preventDefault();
        myform.submit();
    });

    var get_field = function (id) {
        $.post('<?php echo base_url().$_modul ?>/get_detail', {id: id}, function(data) {
            var response = $.parseJSON(data);
            $('#txt-nik').text(response.nik);
            // $('#txt-cabang').text(response.cabang);
            $('#txt-jabatan').text(response.jabatan);
            // $('#txt-unitkerja').text(response.unitkerja);
        });
    };

    $('#pegawai').change(function(event) {
        var _this = $(this);
        var id    = _this.val();
        get_field(id);
    });

    if($('#pegawai').val()) get_field($('#pegawai').val());
</script>