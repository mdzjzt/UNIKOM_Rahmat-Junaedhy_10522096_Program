<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
        <i class="fa fa-times"></i>
    </button>
    <h4 class="modal-title" id="myModalLabel">
        <?php echo $page_title; ?>
    </h4>
</div>
<?php
    echo form_open_multipart($form_action, ['id' => 'finput', 'class' => 'form-horizontal']);
?>
<div class="modal-body">
    <fieldset>
       <!--  <div class="form-group">
            <label class="col-md-3 control-label">Cabang<sup>*</sup></label>
            <div class="col-md-8">
                <?php // echo form_dropdown('cabang_id', $cabang, !empty($data->cabang_id) ? $data->cabang_id : NULL, 'class="form-control select2"') ?>
            </div>
        </div> -->

        <div class="form-group">
            <label class="col-md-3 control-label">Type Logo</label>
            <div class="col-md-8">
                <?php echo form_dropdown('type_logo', $logotype ,!empty($data->type_logo) ? $data->type_logo : '' ,'class="form-control"') ?>
            </div>
        </div>


        <div class="form-group">
            <label class="col-md-3 control-label">Nama Logo</label>
            <div class="col-md-8">
                 <?php echo form_input('nama_logo', !empty($data->nama_logo) ? $data->nama_logo : NULL, 'class="form-control"') ?>
            </div>
        </div>

        <div class="form-group">
             <label class="col-md-3 control-label">Logo Image</label>
                <div class="col-md-8">
                  <div class="fileinput <?php echo !empty($data->ttd_pegawai) && count($data->ttd_pegawai) ? 'fileinput-exists' : 'fileinput-new'; ?>" data-provides="fileinput">
                      <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
                          <?php 
                            if(!empty($data->image) && count($data->image)) : 
                                $image = json_decode($data->image); 
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
            <label class="col-md-3 control-label">Keterangan</label>
            <div class="col-md-8">
                 <?php echo form_textarea('keterangan', !empty($data->keterangan) ? $data->keterangan : NULL, 'class="form-control" rows="4"') ?>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label">Status Aktip</label>
            <div class="col-md-8">
           
                <select class="form-control" name="st_aktips">
                   
                    <?php if (!empty($data->status_aktip)){ ?>
                    <option value="0">Pilih Status</option>
                    <option <?php if ($data->status_aktip == 1) { echo "selected";} ?> value="1">Aktip</option>
                    <option <?php if ($data->status_aktip == 0) { echo "selected";} ?> value="0">Not Aktip</option>
                    <?php    }else { ?>  
                     <option value="0">Pilih Status</option>
                     <option value="1">Aktip</option>
                    <option value="0">Not Aktip</option>                      
                      <?php  } ?>
                   
                </select>
            </div>
        </div>


    </fieldset>
</div>
<div class="modal-footer">
    <?php
        echo anchor(NULL, '<i class="glyphicon glyphicon-chevron-left"></i> Batal', array(
            'class' => 'btn btn-labeled btn-default margin-right-2',
            'data-dismiss' => 'modal'
        ));

        echo form_button([  
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
        __reloadTable(refresh);
    
    };

    $('form#finput').submit(function(event) {
        event.preventDefault();
        myform.submit();
    });
</script>
