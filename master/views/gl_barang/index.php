<div class="row">
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption font-dark">
              <span class="caption-subject bold uppercase"><?php echo $pageTitle ?></span>
              <span class="caption-helper"></span>
            </div>
            <div class="actions">
                <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;" rel="tooltip" data-placement="top" title="fullscreen"></a>
            </div>
        </div>
      <?php echo form_open_multipart($formAction, ['id' => 'my-form', 'class' => 'form-horizontal']);?>
        <div class="portlet-body">
          <div class="row">
              <div class="col-md-10 col-md-offset-1">

                <div class="form-group">
                  <?php echo form_label('Golongan Barang', 'nkb1', array('class' => 'control-label col-md-2')); ?>
                    <div class="col-md-6">
                        <?php echo form_dropdown('nkb1', $nkb1,!empty($nkb) ? $nkb[0] : NULL, 'class="form-control nkb select2" id="nkb1" data-toggle="chain" data-target="#nkb2" data-url="'.$_modul .'/get_nkb?target=nkb2'.'"') ?>
                    </div>
                    <div class="col-md-2">
                        <?php echo anchor($_modul .'/add_nkb?type=01', '<i class="fa fa-plus"></i>', 
                            array(
                              'class' => 'btn btn-sm btn-primary btn-circle modal-nkb',
                            )); ?>

                        <?php echo anchor($_modul .'/edit_nkb?type=01', '<i class="fa fa-pencil"></i>', 
                            array(
                              'class' => 'btn btn-sm btn-success btn-circle btn-edit',
                            )); ?>

                        <?php echo anchor($_modul .'/delete_nkb?type=01', '<i class="fa fa-remove"></i>', 
                            array(
                              'class' => 'btn btn-sm btn-danger btn-circle btn-delete',
                            )); ?>
                    </div>
                </div>

                <div class="form-group">
                  <?php echo form_label('Bidang Barang', 'nkb2', array('class' => 'control-label col-md-2')); ?>
                    <div class="col-md-6">
                        <?php echo form_dropdown('nkb2', [],!empty($nkb) ? $nkb[0] : NULL, 'class="form-control nkb select2" id="nkb2" data-toggle="chain" data-target="#nkb3" data-url="'.$_modul .'/get_nkb?target=nkb3'.'"') ?>
                    </div>
                    <div class="col-md-2">
                        <?php echo anchor($_modul .'/add_nkb?type=02', '<i class="fa fa-plus"></i>', 
                            array(
                              'class' => 'btn btn-sm btn-primary btn-circle modal-nkb',
                            )); ?>

                        <?php echo anchor($_modul .'/edit_nkb?type=02', '<i class="fa fa-pencil"></i>', 
                            array(
                              'class' => 'btn btn-sm btn-success btn-circle btn-edit',
                            )); ?>

                        <?php echo anchor($_modul .'/delete_nkb?type=02', '<i class="fa fa-remove"></i>', 
                            array(
                              'class' => 'btn btn-sm btn-danger btn-circle btn-delete',
                            )); ?>
                    </div>
                </div>

                <div class="form-group">
                  <?php echo form_label('Kelompok Barang', 'nkb3', array('class' => 'control-label col-md-2')); ?>
                    <div class="col-md-6">
                        <?php echo form_dropdown('nkb3', [],!empty($nkb) ? $nkb[0] : NULL, 'class="form-control nkb select2" id="nkb3" data-toggle="chain" data-target="#nkb4" data-url="'.$_modul .'/get_nkb?target=nkb4'.'"') ?>
                    </div>
                    <div class="col-md-2">
                        <?php echo anchor($_modul .'/add_nkb?type=03', '<i class="fa fa-plus"></i>', 
                            array(
                              'class' => 'btn btn-sm btn-primary btn-circle modal-nkb',
                            )); ?>

                        <?php echo anchor($_modul .'/edit_nkb?type=03', '<i class="fa fa-pencil"></i>', 
                            array(
                              'class' => 'btn btn-sm btn-success btn-circle btn-edit',
                            )); ?>

                        <?php echo anchor($_modul .'/delete_nkb?type=03', '<i class="fa fa-remove"></i>', 
                            array(
                              'class' => 'btn btn-sm btn-danger btn-circle btn-delete',
                            )); ?>
                    </div>
                </div>

                <div class="form-group">
                  <?php echo form_label('Sub Kelompok 1', 'nkb4', array('class' => 'control-label col-md-2')); ?>
                    <div class="col-md-6">
                        <?php echo form_dropdown('nkb4', [],!empty($nkb) ? $nkb[0] : NULL, 'class="form-control nkb select2" id="nkb4" data-toggle="chain" data-target="#nkb5" data-url="'.$_modul .'/get_nkb?target=nkb5'.'"') ?>
                    </div>
                    <div class="col-md-2">
                        <?php echo anchor($_modul .'/add_nkb?type=04', '<i class="fa fa-plus"></i>', 
                            array(
                              'class' => 'btn btn-sm btn-primary btn-circle modal-nkb',
                            )); ?>

                        <?php echo anchor($_modul .'/edit_nkb?type=04', '<i class="fa fa-pencil"></i>', 
                            array(
                              'class' => 'btn btn-sm btn-success btn-circle btn-edit',
                            )); ?>

                        <?php echo anchor($_modul .'/delete_nkb?type=04', '<i class="fa fa-remove"></i>', 
                            array(
                              'class' => 'btn btn-sm btn-danger btn-circle btn-delete',
                            )); ?>
                    </div>
                </div>

                <div class="form-group">
                  <?php echo form_label('Sub Kelompok 2', 'nkb5', array('class' => 'control-label col-md-2')); ?>
                    <div class="col-md-6">
                        <?php echo form_dropdown('nkb5', [],!empty($nkb) ? $nkb[0] : NULL, 'class="form-control nkb select2" id="nkb5"') ?>
                    </div>
                    <div class="col-md-2">
                        <?php echo anchor($_modul .'/add_nkb?type=05', '<i class="fa fa-plus"></i>', 
                            array(
                              'class' => 'btn btn-sm btn-primary btn-circle modal-nkb',
                            )); ?>

                        <?php echo anchor($_modul .'/edit_nkb?type=05', '<i class="fa fa-pencil"></i>', 
                            array(
                              'class' => 'btn btn-sm btn-success btn-circle btn-edit',
                            )); ?>

                        <?php echo anchor($_modul .'/delete_nkb?type=05', '<i class="fa fa-remove"></i>', 
                            array(
                              'class' => 'btn btn-sm btn-danger btn-circle btn-delete',
                            )); ?>
                    </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      <?php echo form_close() ?>
    </div>
</div>

 <!-- Dynamic Modal -->  
  <div class="modal" id="modal-nkb" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true" data-width="700">  
  </div>  
  <!-- /.modal -->

<script type="text/javascript">
  
  $(function() {
    pageSetUp();
    getActive();

    var _form = $('form#my-form');

    $('[data-toggle="chain"]', _form).change(function(event) {
        var key    = $(this).val();
        var target = $(this).data('target');
        var url    = $(this).data('url');
        var defaultValue = $(target).data('default');

        var html = '<option value="">-</option>';
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
    
    $('.modal-nkb', _form).click(function(event) {
        event.preventDefault();
        _this = $(this);

        var data = {};
        $.each(_form.serializeArray(), function(index, val) {
           data[val.name] = val.value;
        });
        
        loadRemoteModal({
            url : _this.attr('href'),
            param : data,
            target: '#modal-nkb'
        });
    });

    $('.btn-edit', _form).click(function(event) {
        event.preventDefault();
        _this = $(this);
        
        var data = {};
        $.each(_form.serializeArray(), function(index, val) {
           data[val.name] = val.value;
        });
        
        loadRemoteModal({
            url : _this.attr('href'),
            param : data,
            target: '#modal-nkb'
        });
    });

    $(':input.nkb', _form).change(function(event) {
        getActive();
    });

    function getActive() {
        $.each($(':input.nkb', _form), function(index, val) {
            var _this = $(this);
            
            if(_this.val() == '' || _this.val() == null) {
                _this.closest('.form-group').find('.btn-edit').addClass('disabled');
                _this.closest('.form-group').find('.btn-delete').addClass('disabled');
            } else {
               _this.closest('.form-group').find('.btn-edit').removeClass('disabled');
               _this.closest('.form-group').find('.btn-delete').removeClass('disabled');
            }
        });
    };

    $('.btn-delete', _form).click(function(event) {
        event.preventDefault();
        _this = $(this);

        swal({
          title: "Hapus",
          text : "Hapus data ini beserta turunannya ?",
          type : "warning",
          showCancelButton: true,
          confirmButtonClass: "#DD6B55",
          confirmButtonText: "Hapus",
        },
        function(){
          $.post(_this.attr('href'), _form.serialize(), function(data) {
              var response = jQuery.parseJSON(data);
              command: toastr['success'](response.message);

              switch(response.type) {
                case '01':
                  var nkb1 = $('#nkb1', _form).val();

                  $("#nkb1 option[value='"+nkb1+"']").remove();
                  $('#nkb1').select2('val', null);

                  $('#nkb2').select2('val', null);
                  $('#nkb2').select2('enable', false);
                  $('#nkb2').empty();
                  $('#nkb3').select2('val', null);
                  $('#nkb3').select2('enable', false);
                  $('#nkb3').empty();
                  $('#nkb4').select2('val', null);
                  $('#nkb4').select2('enable', false);
                  $('#nkb4').empty();
                  $('#nkb5').select2('val', null);
                  $('#nkb5').select2('enable', false);
                  $('#nkb5').empty();
                break;

                case '02':
                  var nkb2 = $('#nkb2', _form).val();

                  $("#nkb2 option[value='"+nkb2+"']").remove();
                  $('#nkb2').select2('val', null);
                  
                  $('#nkb3').select2('val', null);
                  $('#nkb3').select2('enable', false);
                  $('#nkb3').empty();
                  $('#nkb4').select2('val', null);
                  $('#nkb4').select2('enable', false);
                  $('#nkb4').empty();
                  $('#nkb5').select2('val', null);
                  $('#nkb5').select2('enable', false);
                  $('#nkb5').empty();
                break;

                case '03':
                  var nkb3 = $('#nkb3', _form).val();

                  $("#nkb3 option[value='"+nkb3+"']").remove();
                  $('#nkb3').select2('val', null);
                  
                  $('#nkb4').select2('val', null);
                  $('#nkb4').select2('enable', false);
                  $('#nkb4').empty();
                  $('#nkb5').select2('val', null);
                  $('#nkb5').select2('enable', false);
                  $('#nkb5').empty();
                break;

                case '04':
                  var nkb4 = $('#nkb4', _form).val();

                  $("#nkb4 option[value='"+nkb4+"']").remove();
                  $('#nkb4').select2('val', null);
                  
                  $('#nkb5').select2('val', null);
                  $('#nkb5').select2('enable', false);
                  $('#nkb5').empty();
                break;

                case '05':
                  var nkb5 = $('#nkb5', _form).val();
                  $("#nkb5 option[value='"+nkb5+"']").remove();
                  $('#nkb5').select2('val', null);
                break;
              }

          });
        });
    });
    
    $('#nkb1').change(function(event) {
        $('#nkb2').select2('val', null);
        $('#nkb2').select2('enable', false);
        $('#nkb2').empty();
        $('#nkb3').select2('val', null);
        $('#nkb3').select2('enable', false);
        $('#nkb3').empty();
        $('#nkb4').select2('val', null);
        $('#nkb4').select2('enable', false);
        $('#nkb4').empty();
        $('#nkb5').select2('val', null);
        $('#nkb5').select2('enable', false);
        $('#nkb5').empty();
    });

    $('#nkb2').change(function(event) {
        $('#nkb3').select2('val', null);
        $('#nkb3').select2('enable', false);
        $('#nkb3').empty();
        $('#nkb4').select2('val', null);
        $('#nkb4').select2('enable', false);
        $('#nkb4').empty();
        $('#nkb5').select2('val', null);
        $('#nkb5').select2('enable', false);
        $('#nkb5').empty();
    });

    $('#nkb3').change(function(event) {

        $('#nkb4').select2('val', null);
        $('#nkb4').select2('enable', false);
        $('#nkb4').empty();
        $('#nkb5').select2('val', null);
        $('#nkb5').select2('enable', false);
        $('#nkb5').empty();
    });

    $('#nkb4').change(function(event) {
        $('#nkb5').select2('val', null);
        $('#nkb5').select2('enable', false);
        $('#nkb5').empty();
    });

    $('#nkb2').select2('enable', false);
    $('#nkb3').select2('enable', false);
    $('#nkb4').select2('enable', false);
    $('#nkb5').select2('enable', false);
  });

</script>




