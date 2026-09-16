  <div class="container-fluid">
  <div class="portlet light">
      <div class="portlet-title">
          <div class="caption font-dark">
            <span class="caption-subject bold uppercase"><?php echo $page_title; ?></span>
            <span class="caption-helper"></span>
          </div>
      </div>
     
              <?php
                echo anchor(NULL, '<i class="glyphicon glyphicon-chevron-left"></i> Kembali', 
                [
                    'class'   => 'btn btn-default margin-right-2 pull-right',
                    'onclick' => 'my_form.go_back()'
                ]);
                
               ?>
      
      <div class="portlet-body">
          <?php
              $hidden_form = array('id' => !empty($id) ? $id : '');
              echo form_open_multipart($form_action, ['id' => 'finput', 'class' => 'form-horizontal'], $hidden_form);
          ?>

          <fieldset>
              <legend></legend>
              <div class="form-group form-group-sm">
                <label class="col-md-2 control-label">Pilih Transaksi CPM</label>
                <div class="col-md-3">
                   <select class="form-control" id="project" name="chosee_project">
                     <?php if (!empty($data->status_buat_projek)) {  ?>  
                              <option <?php if($data->status_buat_projek== 1){echo 'selected';} ?> value="1" >HEAD OFFICE</option>
                              <option <?php if($data->status_buat_projek== 2){echo 'selected';} ?> value="2">EQUIPMENT</option>
                              <option <?php if($data->status_buat_projek== 3){echo 'selected';} ?> value="3">PROJECT</option>
                     <?php  }else{ ?>
                              <option >-- Pilih Transaksi CPM- -</option>
                              <option value="1">HEAD OFFICE</option>
                              <option value="2">EQUIPMENT</option>
                              <option value="3">PROJECT</option>
                   <?php } ?> 
                  </select>
                </div>

              <?php if (!empty($data->site_project)) { ?>
                <label class="col-md-2 control-label site" >Pilih Site</label>
                <div class="col-md-3 site">
             <?php } else{ ?>
                <label class="col-md-2 control-label site" style="display: none;">Pilih Site</label>
                <div class="col-md-3 site" style="display: none;">
              <?php } ?>

               
                   <select class="form-control" id="site_project" name="site_project">
                     <?php if (!empty($data->site_project)) {  ?>  
                              <option <?php if($data->site_project== 1){echo 'selected';} ?> value="1" >HEAD OFFICE</option>
                              <option <?php if($data->site_project== 2){echo 'selected';} ?> value="2">PROJECT</option>
                     <?php  }else{ ?>
                              <option value="0" >-- Pilih Site- -</option>
                              <option value="1">HEAD OFFICE</option>
                              <option value="2">SITE</option>
                   <?php } ?> 
                  </select>
                </div>
              </div>

             

              <div class="form-group form-group-sm">
                <label class="col-md-2 control-label kd_pro">Kode Area</label>
               <?php if (!empty($id)) { ?>
                 <div class="col-md-3">
                      <?php echo form_input('kode_project',!empty($data->kode_project) ? $data->kode_project : NULL, 'class="form-control kode_project" ') ?>
                    </div>
              <?php }else{ ?>
                     <div class="col-md-3">
                      <?php echo form_input('kode_project','', 'class="form-control kode_project" ') ?>
                    </div>
              <?php  } ?>
               

                 <label class="col-md-2 control-label nm_pro">Nama Transaksi HO / Project <sup>*</sup></label>
                <div class="col-md-3">
                  <?php echo form_textarea('nama_project',!empty($data->nama_project) ? $data->nama_project : NULL, 'class="form-control" id="nama_project" rows="4" ') ?>
                </div>
              </div>
              

           

               <div class="form-group form-group-sm">
                <label class="col-md-2 control-label cl_pro">Client HO Department / Project</label>
                <div class="col-md-3">
                  <?php echo form_input('client_project',!empty($data->client_project) ? $data->client_project : NULL, 'class="form-control" ') ?>
                </div>
                  <label class="col-md-2 control-label">End User</label>
                <div class="col-md-3">
                  <?php echo form_input('end_user',!empty($data->end_user) ? $data->end_user : NULL, 'class="form-control" ') ?>
                </div>
              </div>

              

              <div class="form-group form-group-sm">
                <label class="col-md-2 control-label">No. Kontrak</label>
                <div class="col-md-3">
                  <?php echo form_input('no_kontrak',!empty($data->no_kontrak) ? $data->no_kontrak : NULL, 'class="form-control" ') ?>
                </div>

                 <label class="col-md-2 control-label">Tanggal Pembuatan </label>
                <div class="col-md-3">
                   <div class='input-group date'>
                      <?php echo form_input('tanggal_pembuatan_project',!empty($data->tanggal_pembelian) ? date('d-m-Y',strtotime($data->tanggal_pembelian))  : date('d-m-Y'), 'class="form-control date"') ?>
                      <span class="input-group-addon"><span class="fa fa-calendar"></span></span>                    
                  </div>
                </div>
              </div>
             
             
              <?php if (empty($id)) {?>
              <legend>Kota</legend>
             
              <div class="form-group form-group-md">
                <div class="col-md-8">
                    <?php echo anchor(null, '<i class="fa fa-plus"></i> Tambah Kota', array('class' => 'btn blue', 'onclick' => 'add_kota_form()')); ?>
                    <table class="table table-striped table-bordered table-hover datatable dataTable" style="margin-top: 10px;">
                            <thead>
                                <tr>
                                    <th class="span1">No</th>
                                    <th class="span2">Nama Kota</th>
                                    <th class="span1">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="lk_temp_kota" style="display: none;">
                                <tr class="lk_tr_kota">
                                    <td class="text-center no_lk_kota">1</td>
                                    <td>
                                      <div class="input-group">

                                     <?php echo form_input('kota_nam','', 'class="form-control ktnm" id= "kota_nama"') ?>
                                       <?php echo form_hidden('kota_i', '' , 'id = "kota_id" class="ktid" ') ?>

                                       <div class="input-group-btn">
                                          <button class="btn btn-info" type="button" id="btn_modal_kota" onclick="modal_kota(0)"><i class="fa fa-map-marker"></i></button>
                                      </div>
                                    </div>
                                    </td>
                                    <td>
                                        <?php echo anchor(null, '<i class="fa fa-minus"></i>', array('class' => 'btn red btn_lk_kota')); ?>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody id="lk_list_kota">
                                <tr id="tr_lk_kota_1" class="lk_tr_kota">
                                    <td class="text-center no_lk_kota">1</td>
                                    <td class="text-center">
                                    <div class="input-group">

                                      <?php echo form_input('kota_name[]', '', 'class="form-control" id= "kota_nama_1" onclick="modal_kota(1)"') ?>
                                       <?php echo form_hidden('kota_id[]', '' , 'id = "kota_id_1"') ?>

                                       <div class="input-group-btn">
                                          <button class="btn btn-info" type="button" onclick="modal_kota(1)"><i class="fa fa-map-marker"></i></button>
                                      </div>
                                    </div>
                                    </td>
                                    <td>
                                        <?php echo anchor(null, '<i class="fa fa-minus"></i>', array('class' => 'btn red btn_lk_kota', 'onclick' => 'remove_kota_form(1)')); ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                   <legend>Choose User Project</legend>
             
              <div class="form-group form-group-md">
                <div class="col-md-8">
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

                                      <?php echo form_input('user_name[]',!empty($data->no_spb) ? $data->no_spb : NULL, 'class="form-control" id= "user_nama_1" onclick="modal_user(1)"') ?>
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
              
              <?php } ?>
               
          </fieldset>
      </div> 
      <div class="portlet-footer">
          <div class="modal-footer">
              <?php
                echo anchor(NULL, '<i class="glyphicon glyphicon-chevron-left"></i> Kembali', array(
                    'id' => 'mybutton-add',
                    'class' => 'btn btn-default margin-right-2',
                    'onclick' => 'my_form.go_back()'
                ));
                echo anchor(NULL, '<i class="glyphicon glyphicon-floppy-disk"></i> Simpan', array(
                    'id' => 'mybutton-add',
                    'class' => 'btn btn-success',
                    'onclick' => '$(\'form#finput\').submit()'
                ));
               ?>
          </div>
      </div>
      <?php echo form_close() ?>   
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
                        <button class="btn btn-info btn-sm" type="button" onclick="search_user()"><i class="fa fa-search"></i></button>
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

<div id="modal-data-kota" class="modal container" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
            <i class="fa fa-times"></i>
      </button>
      <span class="modal-title">LIST Kota</span>
    </div>
    <div class="modal-body">
      <form class="form-inline pull-right" id="form-filter-kota">
      <input type="hidden" id="param_tbl_kota" value="0">
          <div class="form-group">
              <?php echo form_dropdown('column', array(
                                    
                                      'kota_nama' => 'Nama Kota',
                      ), '','class="input-sm form-control"'); ?>
          </div>
          <div class="form-group">
               <div class="input-group">
                      <?php echo form_input('keyword','' , 'class="form-control input-sm" ') ?>
                      <div class="input-group-btn">
                        <button type="button" onclick="search_kota()" class="btn btn-info btn-sm"><i class="fa fa-search"></i></button>
                    </div>
              </div>
          </div>
      </form>

      <table id="table-data-kota" 
             class="table table-bordered table-hover" 
             width="100%" style="margin-top: 0 !important;"
             data-table-source="<?php echo base_url() . $_modul . '/load_data_kota/mproject' ?>"
             data-table-filter="#form-filter-kota">
          <thead>
            <tr>
              <th class="text-center" data-sorting="false" style="width: 20px;">No</th>
              <th>KODE KOTA</th>
              <th>NAMA KAB</th>
              <th>NAMA KOTA</th>
              <th>SINGKATAN</th>
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

   var modalDataUser = $('#modal-data-user');

    var modalDataKota = $('#modal-data-kota');

    function search_kota(){
      $.ajax({
        url: '<?php echo base_url() . $_modul . '/load_data_kota/mproject' ?>',
        data: $("#form-filter-kota").serialize(),
        async: 'true',
        cache: 'false',
        type: 'post',
        success: function (data) {
             dataTableKota.reload();
        }
      });
    }

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

 

  var __afterSubmit = function() {
      //setTimeout(function(){
        my_form.go_back();
      //},200);
    };

  var globalFormUser = {

      getField : function(index, param) {
          _this = index;
          
          var id     = _this.find('.id').data('id');
          var nama   = _this.find('.nama').data('id');
          
          $('#user_id_'+param, formBasic).val(id);
          $('#user_nama_'+param, formBasic).val(nama);
      }
  }

 var globalFormKota = {

      getField : function(index, param) {
          _this = index;
          
          var id_kota     = _this.find('.id_kota').data('id');
          var nama_kota   = _this.find('.nama_kota').data('id');
          
          $('#kota_id_'+param, formBasic).val(id_kota);
          $('#kota_nama_'+param, formBasic).val(nama_kota);
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

var dataTableKota = $('#table-data-kota').myDataTable({
        columns: [
            {orderable : false},
            {name: 'kota_id'},
            {name: 'nama_kab'},
            {name: 'nama_kota'},
            {name: 'singkatan'},
          
            
        ],
    });

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

 $('table#table-data-kota > tbody tr').livequery('click', function (event) {
     var param = $('#param_tbl_kota').val();
    
      event.preventDefault();
      _this = $(this);
      globalFormKota.getField(_this, param);
      modalDataKota.modal('hide');
  });
 
$('.a-kode-kota', $('#table-data-kota')).livequery('click', function (event) {
      event.preventDefault();
      _this = $(this).parents('tr');
      globalFormUser.getField(_this);
      modalDataKota.modal('hide');
  }); 

   function render_biaya_form() {
        var no = 0;
        $.each($('#lk_list tr.lk_tr'), function () {
            no++;
            $(this).attr('id', 'tr_lk_' + no);
            $('#user_id', this).attr('id', 'user_id_' + no);
            $('#user_nama', this).attr('id', 'user_nama_' + no);
            $('.usid', this).attr('name', 'user_id[]' );
            $('.usnm', this).attr('name', 'user_name[]');
            $('.usnm', this).attr('onclick', 'modal_user(' + no + ')');
            $('#btn_modal', this).attr('onclick', 'modal_user(' + no + ')');
            $('.no_lk', this).html(parseInt(no));
            // $('.target_lk', this).attr('name', 'user_id[]');
            $('.btn_lk', this).attr('onclick', 'remove_biaya_form(' + no + ')');
        });

    }

    function render_kota_form() {
        var no = 0;
        $.each($('#lk_list_kota tr.lk_tr_kota'), function () {
            no++;
            $(this).attr('id', 'tr_lk_kota' + no);
            $('#kota_id', this).attr('id', 'kota_id_' + no);
            $('#kota_nama', this).attr('id', 'kota_nama_' + no);
            $('.ktid', this).attr('name', 'kota_id[]' );
            $('.ktnm', this).attr('name', 'kota_name[]');
            $('.ktnm', this).attr('onclick', 'modal_kota('+ no+')');
            $('#btn_modal_kota', this).attr('onclick', 'modal_kota(' + no + ')');
            $('.no_lk_kota', this).html(parseInt(no));
            // $('.target_lk', this).attr('name', 'user_id[]');
            $('.btn_lk_kota', this).attr('onclick', 'remove_kota_form(' + no + ')');
        });

    }

    function add_kota_form(){
        var temp_kota_form = $('#lk_temp_kota').html();
        $('#lk_list_kota').append(temp_kota_form);
        render_kota_form();
    }

    function remove_kota_form(id) {
        bootbox.setBtnClasses({
            CANCEL: 'red',
            CONFIRM: 'blue'
        });

        bootbox.confirm("Anda yakin akan menghapus Kota ini?", "Tidak", "Ya", function (e) {
            if (e) {
                $('#tr_lk_kota' + id).remove();
                if ($('#lk_list_kota tr.lk_tr_kota').length === 0) {
                    add_biaya_form();
                }
            }
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

    function modal_user(param){
      $("#modal-data-user").modal("show");
      $('#param_tbl').val(param);
    
    }

    function modal_kota(param){
      $("#modal-data-kota").modal("show");
      $('#param_tbl_kota').val(param);
    }

    $('#site_project').on('change', function() {
     
       if(this.value == 1 ){
          $('#kota_id_1').val('1001');
          $('#kota_nama_1').val('Head Office');
          $('#kota_nama_1').prop('readonly', true);
       }else{
          $('#kota_id_1').val('');
          $('#kota_nama_1').val('');
          $('#kota_nama_1').prop('readonly', false);
       }
    })

    $('#project').on('change', function() {


      if(this.value == 1 ){
          $('.kode_project').val('001');
          $('.kd_pro').html('Kode HO');
          $('.nm_pro').html('Department');
          $('.cl_pro').html('Client');
          $('.kode_project').prop('readonly', true);
          $('.site').css('display', 'none');
          $('#kota_id_1').val('1001');
          $('#kota_nama_1').val('Head Office');
           $('#kota_nama_1').prop('readonly', true);
         

      }else if(this.value == 2){
          $('.kode_project').val('003');
          $('.kode_project').prop('readonly', true);
          $('.kd_pro').html('Kode HO');
          $('.nm_pro').html('Department');
          $('.cl_pro').html('Client');
          $('.site').css('display', 'none');
          $('#kota_id_1').val('1001');
          $('#kota_nama_1').val('Head Office');
           $('#kota_nama_1').prop('readonly', true);
         


      }
      else if(this.value == 3){

          $('.site').css('display', 'block');  
          $('.kode_project').prop('readonly', false);
          $('.kd_pro').html('Kode Project');
          $('.nm_pro').html('Nama Project');
          $('.cl_pro').html('Client Project');
          $('#kota_id_1').val('');
          $('#kota_nama_1').val('');
           $('#kota_nama_1').prop('readonly', false);
         


         $.ajax({
            url: '<?php echo base_url() . $_modul . '/kode_pro/mproject' ?>',
            async: 'true',
            cache: 'false',
            type: 'post',
            success: function (data) {
             var obj = JSON.parse(data);
                $('.kode_project').val(obj.id);
            }
          });
      }
    })


</script>