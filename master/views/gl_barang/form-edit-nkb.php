<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
        <i class="fa fa-times"></i>
    </button>
    <h4 class="modal-title">
        <?php echo $pageTitle; ?>

        <?php 
            switch ($type) {
                case '01':
                    echo "(Golongan Barang)";
                    break;

                case '02':
                    echo "(Bidang Barang)";
                    break;

                case '03':
                    echo "(Kelompok Barang)";
                    break;

                case '04':
                    echo "(Sub Kelompok 1)";
                    break;

                case '05':
                    echo "(Sub Kelompok 2)";
                    break;
                
                default:
                    # code...
                    break;
            }
        ?>

    </h4>
</div>
<?php
    echo form_open_multipart($formAction, array('id' => 'form-nkb', 'class' => 'form-horizontal'));
    echo form_hidden('id', $data->ID);
?>
<div class="modal-body">

    <table class="table borderless">
        <?php if ($type == '02' || $type == '03' || $type == '04' || $type == '05'): ?>
            <tr>
                <th style="width: 150px">Golongan Barang</th>
                <td> : <?php echo !empty($qNkb1) ? $qNkb1->Rek1.' - ' .$qNkb1->Uraian : null ?></td>
            </tr>
        <?php endif ?>
        <?php if ($type == '03' || $type == '04' || $type == '05'): ?>
            <tr>
                <th>Bidang Barang</th>
                <td> : <?php echo !empty($qNkb2) ? $qNkb2->Rek2.' - ' .$qNkb2->Uraian : null ?></td>
            </tr>
        <?php endif; ?>
        <?php if ($type == '04' || $type == '05'): ?>
            <tr>
                <th>Kelompok Barang</th>
                <td> : <?php echo !empty($qNkb3) ? $qNkb3->Rek3.' - ' .$qNkb3->Uraian : null ?></td>
            </tr>
        <?php endif; ?>
        <?php if ($type == '05'): ?>
            <tr>
                <th>Sub Kelompok 1</th>
                <td> : <?php echo !empty($qNkb4) ? $qNkb4->Rek4.' - ' .$qNkb4->Uraian : null ?></td>
            </tr>
        <?php endif; ?>
    </table>

    <?php if($type != '01'): ?> <hr class="clearfix"> <?php endif ?>

    <fieldset>
        <div class="form-group">
            <label class="col-md-3 control-label">Kode<sup>*</sup></label>   
            <div class="col-md-4">
                <?php echo form_input('code', $code, 'class="form-control" data-rule-required="true"'); ?>
            </div>
        </div> 
        <div class="form-group">
            <label class="col-md-3 control-label">Nama<sup>*</sup></label>   
            <div class="col-md-8">
                <?php echo form_input('name', $data->Uraian, 'class="form-control" data-rule-required="true"'); ?>
            </div>
        </div> 
    </fieldset>


</div>
<div class="modal-footer">
    <?php
    echo anchor(NULL, '<i class="glyphicon glyphicon-chevron-left"></i> Back', array(
        'id' => 'mybutton-add',
        'class' => 'btn btn-default margin-right-2',
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
    $( function() {
        pageSetUp();

        _form = $('form#form-nkb');

        _form.submit(function(event) {
            event.preventDefault();
            $(this).myForm({
              success : function(data) {
                $('.modal').modal('hide');

                _parent = $('form#my-form');
                switch(data.nType) {
                  case '01':
                      $("#nkb1 option[value='"+data.id+"']", _parent).text(data.code+' - '+data.name);
                      $("#nkb1", _parent).select2('val', data.id);
                  break;

                  case '02':
                      $("#nkb2 option[value='"+data.id+"']", _parent).text(data.code+' - '+data.name);
                      $("#nkb2", _parent).select2('val', data.id);
                  break;

                  case '03':
                      $("#nkb3 option[value='"+data.id+"']", _parent).text(data.code+' - '+data.name);
                      $("#nkb3", _parent).select2('val', data.id);
                  break;

                  case '04':
                      $("#nkb4 option[value='"+data.id+"']", _parent).text(data.code+' - '+data.name);
                      $("#nkb4", _parent).select2('val', data.id);
                  break;

                  case '05':
                      $("#nkb5 option[value='"+data.id+"']", _parent).text(data.code+' - '+data.name);
                      $("#nkb5", _parent).select2('val', data.id);
                  break;
                }

              }
            }).submit();
        });
    });
</script>