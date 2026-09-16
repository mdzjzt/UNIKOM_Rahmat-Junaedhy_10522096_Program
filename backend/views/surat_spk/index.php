<div class="row">
  <div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-dark">
            <span class="caption-subject bold uppercase"><?php echo $pageTitle; ?></span>
            <span class="caption-helper"></span>
        </div>
        <div class="actions">
            <a class="btn btn-circle btn-info" href="javascript:;" data-toggle="modal" data-target="#modal-help-ketentuan">
                Info Variabel
            </a>
        </div>
    </div>
<?php echo form_open_multipart($formAction, ['class' => 'form-horizontal', 'id' => 'finput']) ?>
    <div class="portlet-body">
            <div class="form-group">
              <div class="col-md-12">
                <?php echo form_input('value_setting', !empty($data->value_setting) ? $data->value_setting : '','class="tinymce"') ?>
              </div>
            </div>
    </div>
    <div class="portlet-footer">
        <div class="modal-footer">
             <?php
                echo anchor(NULL, '<i class="glyphicon glyphicon-floppy-disk"></i> Save', array(
                    'class'   => 'btn btn-labeled btn-success',
                    'onclick' => '$(\'#finput\').submit()'
                ));
            ?>
        </div>
    </div>
<?php echo form_close(); ?>
</div>

<div class="modal" id="modal-help-ketentuan" data-backdrop="static">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
        <i class="fa fa-times"></i>
    </button>
    <h4 class="modal-title">
        VARIABEL KHUSUS
    </h4>
  </div>
  <div class="modal-body">
      <table class="table table-consended">
          <thead>
            <tr>
              <th>Variabel</th>
              <th>Keterangan</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>{nama_vendor}</td>
              <td>Nama Vendor/Perusahaan</td>
            </tr>
            <tr>
              <td>{grandtotal_penawaran}</td>
              <td>Grandtotal Rupiah Penawaran / Harga penawaran deal</td>
            </tr>
            <tr>
              <td>{jangka_waktu}</td>
              <td>Jangka waktu pelaksanaan pekerjaan </td>
            </tr>
          </tbody>
      </table>
  </div>
</div>



<script type="text/javascript">

    pageSetUp();

    var __afterSubmitKetentuan = function(refresh) {
        $('.modal').modal('hide');
    };

    var myform = $('form#finput').myForm();

    $('form#finput').submit(function(event) {
        event.preventDefault();
        myform.submit();
    });

    function loadTinymce() {
        tinymce.remove();
        tinymce.init({
              selector: '.tinymce',
              height: 300,
              nonbreaking_force_tab: true,
              entity_encoding: 'named',         
              plugins: [
                'nonbreaking advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table contextmenu paste code'
              ],
              fontsize_formats: '8pt 10pt 11pt 12pt 14pt 18pt 24pt 36pt',
              toolbar: 'fontselect | fontsizeselect | insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
              setup: function (editor) {
                editor.on('change', function () {
                    tinymce.triggerSave();
                });
              },
        });
    };

    loadScript("<?php echo hconfig::base_assets(); ?>/libs/tinymce/js/tinymce/tinymce.min.js",loadTinymce);

</script>