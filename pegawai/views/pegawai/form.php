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
                <label class="col-md-3 control-label">NIK <sup>*</sup></label>
                <div class="col-md-6">
                    <?php echo form_input('pegawai_nik', !empty($data->pegawai_nik) ? $data->pegawai_nik : '', 'class="form-control" data-rule-required="true"'); ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">Nama <sup>*</sup></label>
                <div class="col-md-8">
                        <?php echo form_input('pegawai_nama', !empty($data->pegawai_nama) ? $data->pegawai_nama : '', 'class="form-control" data-rule-required="true"'); ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">Jabatan <sup>*</sup></label>
                <div class="col-md-8">
                        <?php echo form_dropdown('jabatan_id', $jabatan, !empty($data->jabatan_id) ? $data->jabatan_id : '', 'class="form-control select2" data-rule-required="true"'); ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">Department Project</label>
                <div class="col-md-8">
                 <?php echo form_dropdown('deparment', $department_project, !empty($data->department_pegawai) ? $data->department_pegawai : NULL, 'class="form-control select2"') ?>
                       <!--  <?php // echo form_dropdown('cabang_id', $cabang, !empty($data->cabang_id) ? $data->cabang_id : '', 'class="form-control select2" data-rule-required="true"'); ?> -->
                </div>
            </div> 

          <!--   <div class="form-group">
                <label class="col-md-3 control-label">Unit Kerja <sup>*</sup></label>
                <div class="col-md-8">
                        <?php // echo form_dropdown('unit_kerja_id', $unit, !empty($data->unit_kerja_id) ? $data->unit_kerja_id : '', 'class="form-control select2" data-rule-required="true"'); ?>
                </div>
            </div> -->

            <div class="form-group">
                <label class="col-md-3 control-label">Alamat</label>
                <div class="col-md-8">
                        <?php echo form_textarea('pegawai_alamat',!empty($data->pegawai_alamat) ? $data->pegawai_alamat : '', 'class="form-control" rows="3"'); ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">Telepon</label>
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                        <?php echo form_input('pegawai_contact',!empty($data->pegawai_contact) ? $data->pegawai_contact : '', 'class="form-control numeric"'); ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                    <label class="col-md-3 control-label">Email 1 <sup>*</sup></label>
                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                        <?php echo form_input('pegawai_email',!empty($data->pegawai_email) ? $data->pegawai_email : '', 'class="form-control" data-rule-email="true"'); ?>
                    </div>
                </div>
            </div>

             <div class="form-group">
                    <label class="col-md-3 control-label">Email 2</label>
                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                        <?php echo form_input('pegawai_email_2',!empty($data->pegawai_email_new) ? $data->pegawai_email_new : '', 'class="form-control" data-rule-email="true"'); ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">Foto Pegawai</label>
                <div class="col-md-8">
                  <div class="fileinput <?php echo !empty($data->foto) && count($data->foto) ? 'fileinput-exists' : 'fileinput-new'; ?>" data-provides="fileinput">
                      <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
                          <?php 
                            if(!empty($data->foto) && count($data->foto)) : 
                                $image = json_decode($data->foto); 
                                if(!empty($image)):
                          ?> 
                              <img src="<?php echo $image[0]->file ?>" alt="...">
                          <?php 
                                endif;
                            endif; ?>
                      </div>
                      <div>
                        <span class="btn btn-default btn-file"><span class="fileinput-new">Pilih Gambar</span><span class="fileinput-exists">Ubah</span>
                        <input type="file" name="image"></span>
                        <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Hapus</a>
                      </div>
                    </div>
                </div>
              </div>

               <div class="form-group">
                <label class="col-md-3 control-label">TTD Pegawai</label>
                <div class="col-md-8">
                  <div class="fileinput <?php echo !empty($data->ttd_pegawai) && count($data->ttd_pegawai) ? 'fileinput-exists' : 'fileinput-new'; ?>" data-provides="fileinput">
                      <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
                          <?php 
                            if(!empty($data->ttd_pegawai) && count($data->ttd_pegawai)) : 
                                $imagettd = json_decode($data->ttd_pegawai); 
                                if(!empty($imagettd)):
                          ?> 
                              <img src="<?php echo $imagettd[0]->file ?>" alt="...">
                          <?php 
                                endif;
                            endif; ?>
                      </div>
                      <div>
                        <span class="btn btn-default btn-file"><span class="fileinput-new">Pilih Gambar</span><span class="fileinput-exists">Ubah</span>
                        <input type="file" name="imagettd"></span>
                        <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Hapus</a>
                      </div>
                    </div>
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
