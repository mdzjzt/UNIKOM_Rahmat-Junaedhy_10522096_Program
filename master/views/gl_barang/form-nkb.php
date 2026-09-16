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
?>
<div class="modal-body">

    <?php if ($type == '02' || $type == '03' || $type == '04' || $type == '05'): ?>
        <div class="form-group">
          <?php echo form_label('Golongan Barang', 'nkb1', array('class' => 'control-label col-md-3')); ?>
            <div class="col-md-6">
                <?php echo form_dropdown('nkb1', $optNkb1, !empty($nkb1) ? $nkb1 : NULL, 'class="form-control select2" id="fnkb1" data-toggle="chain" data-target="#fnkb2" data-url="'.$_modul .'/get_nkb?target=nkb2'.'"') ?>
            </div>
        </div>
    <?php endif ?>

    <?php if ($type == '03' || $type == '04' || $type == '05'): ?>
        <div class="form-group">
          <?php echo form_label('Bidang Barang', 'nkb1', array('class' => 'control-label col-md-3')); ?>
            <div class="col-md-6">
                <?php echo form_dropdown('nkb2', $optNkb2, !empty($nkb2) ? $nkb2 : NULL, 'class="form-control select2" id="fnkb2" data-toggle="chain" data-target="#fnkb3" data-url="'.$_modul .'/get_nkb?target=nkb3'.'"') ?>
            </div>
        </div>
    <?php endif ?>

    <?php if ($type == '04' || $type == '05'): ?>
        <div class="form-group">
          <?php echo form_label('Kelompok Barang', 'nkb3', array('class' => 'control-label col-md-3')); ?>
            <div class="col-md-6">
                <?php echo form_dropdown('nkb3', $optNkb3, !empty($nkb3) ? $nkb3 : NULL, 'class="form-control select2" id="fnkb3" data-toggle="chain" data-target="#fnkb4" data-url="'.$_modul .'/get_nkb?target=nkb4'.'"') ?>
            </div>
        </div>
    <?php endif ?>

    <?php if ($type == '05'): ?>
        <div class="form-group">
          <?php echo form_label('Sub Kelompok 1', 'nkb4', array('class' => 'control-label col-md-3')); ?>
            <div class="col-md-6">
                <?php echo form_dropdown('nkb4', $optNkb4, !empty($nkb4) ? $nkb4 : NULL, 'class="form-control select2" id="fnkb4" data-toggle="chain" data-target="#fnkb5" data-url="'.$_modul .'/get_nkb?target=nkb5'.'"') ?>
            </div>
        </div>
    <?php endif ?>

    <?php if($type != '01'): ?> <hr class="clearfix"> <?php endif ?>

    <fieldset>
        <div class="form-group">
            <label class="col-md-3 control-label">Kode<sup>*</sup></label>   
            <div class="col-md-4">
                <?php echo form_input('code', null, 'class="form-control" data-rule-required="true"'); ?>
            </div>
        </div> 
        <div class="form-group">
            <label class="col-md-3 control-label">Nama<sup>*</sup></label>   
            <div class="col-md-8">
                <?php echo form_input('name', null, 'class="form-control" data-rule-required="true"'); ?>
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

    $('[data-toggle="chain"]', _form).change(function(event) {
      var key    = $(this).val();
      var target = $(this).data('target');
      var url    = $(this).data('url');
      var defaultValue = $(target).data('default');

      var html = '<option value=""></option>';
      $(target).html(html);
      
      $(target).select2('enable', false);
      $(target).select2('val', '');

      $.post(url, _form.serialize(), function(data) {
          var list = data.data;
          $.each(list, function(index, val) {
              html += '<option value='+val.id+'>'+val.name+'</option>';    
          });

          if(list.length > 0) {
              $(target).select2('enable', true);
          } else {
              $(target).select2('enable', false);
          }

          $(target).html(html);
          
          if(defaultValue) {  
              $(target).select2('val', defaultValue);
          }

      });
    });

    _form.submit(function(event) {
        event.preventDefault();
        $(this).myForm({
          success : function(data) {

            if(data.nType) {

                _parent = $('form#my-form');
                switch(data.nType) {
                  case '01':
                      $(':input#nkb1', _parent).append('<option value="'+data.id+'">'+data.code+' - '+data.name+' </option>');
                  break;

                  case '02':
                      $(':input#nkb2', _parent).append('<option value="'+data.id+'">'+data.code+' - '+data.name+' </option>');
                  break;

                  case '03':
                      $(':input#nkb3', _parent).append('<option value="'+data.id+'">'+data.code+' - '+data.name+' </option>');
                  break;

                  case '04':
                      $(':input#nkb4', _parent).append('<option value="'+data.id+'">'+data.code+' - '+data.name+' </option>');
                  break;

                  case '05':
                      $(':input#nkb5', _parent).append('<option value="'+data.id+'">'+data.code+' - '+data.name+' </option>');
                  break;
                }
            }

            $('.modal').modal('hide');
          }
        }).submit();
    });
});

</script>