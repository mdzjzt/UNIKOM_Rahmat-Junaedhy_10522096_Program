        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                <i class="fa fa-times"></i>
            </button>
            <h4 class="modal-title" style="font-weight: bold;">
                <i class="fa fa-user"></i> USER  <?php echo $nama_project ; ?>
            </h4>
        </div>
        <div class="modal-body">
           <table class="table table-bordered" style="margin-top: 0 !important;" id="tbl_user_project" data-table-source="<?php echo base_url() . $_modul . '/load_data_user_project/'.$id.'' ?>">
             <thead>
               <tr>
                 <th>No</th>
                 <th>Nama User</th>
                 <th>Jabatan</th>
                <th>Aksi</th>
               </tr>
             </thead>
            
           </table>
        </div>

          <?php
              $hidden_form = array('id' => !empty($id) ? $id : '');
              echo form_open_multipart($form_action, ['id' => 'finput', 'class' => 'form-horizontal'], $hidden_form);
          ?>
              <div class="form-group form-group-md">
                <div class="container" style="width:80%;">
                    <?php echo anchor(null, '<i class="fa fa-plus"></i> Tambah User', array('class' => 'btn blue', 'onclick' => 'add_biaya_form()')); ?>
                    <table class="table table-striped table-bordered table-hover datatable dataTable" style="margin-top: 10px;">
                            <thead>
                                <tr>
                                    <th class="span1">No</th>
                                    <th class="span2">Nama User</th>
                                    <th class="span1">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="lk_temp" style="display: none;">
                                <tr class="lk_tr">
                                    <td class="text-center no_lk">1</td>
                                    <td>
                                      <div class="input-group">

                                     <?php echo form_input('user_nam',!empty($data->no_spb) ? $data->no_spb : NULL, 'class="form-control usnm" id= "user_nama"') ?>
                                       <?php echo form_hidden('user_i', !empty($data->barang_id) ? $data->barang_id : NULL , 'id = "user_id" class="usid" ') ?>

                                       <div class="input-group-btn">
                                          <button class="btn btn-info" type="button" id="btn_modal" onclick="modal_user(0)"><i class="fa fa-user"></i></button>
                                      </div>
                                    </div>
                                    </td>
                                    <td>
                                        <?php echo anchor(null, '<i class="fa fa-minus"></i>', array('class' => 'btn red btn_lk')); ?>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody id="lk_list">
                                <tr id="tr_lk_1" class="lk_tr">
                                    <td class="text-center no_lk">1</td>
                                    <td class="text-center">
                                    <div class="input-group">

                                      <?php echo form_input('user_name[]',!empty($data->no_spb) ? $data->no_spb : NULL, 'class="form-control" id= "user_nama_1"') ?>
                                       <?php echo form_hidden('user_id[]', !empty($data->barang_id) ? $data->barang_id : NULL , 'id = "user_id_1"') ?>
                                       
                                       <div class="input-group-btn">
                                          <button class="btn btn-info" type="button" onclick="modal_user(1)"><i class="fa fa-user"></i></button>
                                      </div>
                                    </div>
                                    </td>
                                    <td>
                                        <?php echo anchor(null, '<i class="fa fa-minus"></i>', array('class' => 'btn red btn_lk', 'onclick' => 'remove_biaya_form(1)')); ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
               <?php echo form_close() ?>   
        <div class="modal-footer">
            <?php 
              echo anchor(NULL, '<i class="glyphicon glyphicon-chevron-left"></i> Close',
              [
                  'class' => 'btn btn-default margin-right-2',
                  'data-dismiss' => 'modal'
              ]);
            ?>

             <?php 
             echo anchor(NULL, '<i class="glyphicon glyphicon-floppy-disk"></i> Simpan', array(
                    'id' => 'mybutton-add',
                    'class' => 'btn btn-success',
                    'onclick' => '$(\'form#finput\').submit()'
                ));
            ?>
        </div>


<div id="modal-data-user" class="modal container" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
            <i class="fa fa-times"></i>
      </button>
      <span class="modal-title">LIST USER</span>
    </div>
    <div class="modal-body">
      <form class="form-inline pull-right" id="form-filter-user">
      <input type="hidden" id="param_tbl" value="0">
          <div class="form-group">
              <?php echo form_dropdown('column', array(
                                      '' => 'semua',
                                      'user_nama' => 'Nama User',
                      ), '','class="input-sm form-control"'); ?>
          </div>
          <div class="form-group">
               <div class="input-group">
                      <?php echo form_input('keyword','' , 'class="form-control input-sm"') ?>
                      <div class="input-group-btn">
                        <button type="button" onclick="search_user()" class="btn btn-info btn-sm"><i class="fa fa-search"></i></button>
                    </div>
              </div>
          </div>
      </form>

      <table id="table-data-user" 
             class="table table-bordered table-hover" 
             width="100%" style="margin-top: 0 !important;"
             data-table-source="<?php echo base_url() . $_modul . '/load_data_user/mproject' ?>"
             data-table-filter="#form-filter-user">
          <thead>
            <tr>
              <th class="text-center" data-sorting="false">No</th>
              <th>KODE</th>
              <th>NAMA PEGAWAI</th>
              <th>USER NAME</th>
              <th>ROLE</th>
            </tr>
          </thead>
      </table>
    </div>
</div>

<script type="text/javascript">
  pageSetUp();
   


  var formBasic = $('form#finput');
    $('form#finput').submit(function(event) {
        event.preventDefault();
        formBasic.myForm().submit();
    });

  var dataTableUserProject = $('#tbl_user_project').myDataTable({
        columns: [
            {orderable : false},
            {name: 'nama'},
            {name: 'jabatan'},
            {orderable: false},
            
        ],
    }); 

  var modalDataUser = $('#modal-data-user');

  var globalFormUser = {

      getField : function(index, param) {
          _this = index;
          
          var id     = _this.find('.id').data('id');
          var nama   = _this.find('.nama').data('id');

         
          
          $('#user_id_'+param, formBasic).val(id);
          $('#user_nama_'+param, formBasic).val(nama);
      }
  }

var dataTableUser = $('#table-data-user').myDataTable({
        columns: [
            {orderable : false},
            {name: 'user_id'},
            {name: 'nama_pegawai'},
            {name: 'user_name'},
            {name: 'role'},
            
        ],
    });


     function search_user(){
      $.ajax({
        url: '<?php echo base_url() . $_modul . '/load_data_user/mproject' ?>',
        data: $("#form-filter-user").serialize(),
        async: 'true',
        cache: 'false',
        type: 'post',
        success: function (data) {
             dataTableUser.reload();
        }
      });
    }

 $('table#table-data-user > tbody tr').livequery('click', function (event) {
     var param = $('#param_tbl').val();
    
      event.preventDefault();
      _this = $(this);
      globalFormUser.getField(_this, param);
      modalDataUser.modal('hide');
  });
$('.a-kode', $('#table-data-user')).livequery('click', function (event) {
      event.preventDefault();
      _this = $(this).parents('tr');
      globalFormUser.getField(_this);
      modalDataUser.modal('hide');
  }); 
   function modal_user(param){

      $("#modal-data-user").modal("show");
      $('#param_tbl').val(param);
    
    }

  function render_biaya_form() {
        var no = 0;
        $.each($('#lk_list tr.lk_tr'), function () {
            no++;
            $(this).attr('id', 'tr_lk_' + no);
            $('#user_id', this).attr('id', 'user_id_' + no);
            $('#user_nama', this).attr('id', 'user_nama_' + no);
            $('.usid', this).attr('name', 'user_id[]' );
            $('.usnm', this).attr('name', 'user_name[]');
            $('#btn_modal', this).attr('onclick', 'modal_user(' + no + ')');
            $('.no_lk', this).html(parseInt(no));
            $('.btn_lk', this).attr('onclick', 'remove_biaya_form(' + no + ')');
        });

    }

    function add_biaya_form() {
        var temp_biaya_form = $('#lk_temp').html();
        $('#lk_list').append(temp_biaya_form);
        render_biaya_form();
    }

    function remove_biaya_form(id) {
        bootbox.setBtnClasses({
            CANCEL: 'red',
            CONFIRM: 'blue'
        });

        bootbox.confirm("Anda yakin akan menghapus user ini?", "Tidak", "Ya", function (e) {
            if (e) {
                $('#tr_lk_' + id).remove();
                if ($('#lk_list tr.lk_tr').length === 0) {
                    add_biaya_form();
                }
            }
        });
    }

     var __reloadTable = function(refresh) {
        dataTableUserProject.reload(refresh);
         mydatatable.reload(refresh);
    };

      var __afterSubmit = function(refresh) {
      var form = document.getElementById("finput");
      form.reset();
      dataTableUserProject.reload(refresh);
       mydatatable.reload(refresh);
    };
</script>
