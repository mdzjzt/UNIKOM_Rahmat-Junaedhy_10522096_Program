<div class="row">
  <div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-dark">
            <span class="caption-subject bold uppercase"><?php echo $page_title;?></span>
            <span class="caption-helper"></span>
        </div>
         <div class="dropdown pull-right">
           <button class="btn btn-info btn-exc dropdown-toggle" type="button" data-toggle="dropdown">
               <i class="fa fa-gear"></i>
               <span class="caret"></span>
           </button>
           <ul class="dropdown-menu">
               <li><a href="#" id="btn-excel">Excel</a></li>
               <li><a href="#" target="_blank" id="btn-pdf">PDF</a></li>
           </ul>
       </div>
    </div>
    <div class="portlet-title">
        <form class="form-horizontal" id="filter-table">
            <div class="form-group form-group-sm">
               <!--  <label class="control-label col-md-3">Nama Perusahaan</label> -->
                <div class="col-md-3">
                    <?php echo form_input('keyword', NULL, 'class="form-control" placeholder="Nama Perusahaan"'); ?>
                </div>
                <div class="col-md-3">
                    <?php echo form_input('contact_person', NULL, 'class="form-control" placeholder="Contact Person"'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo form_input('sub_category', NULL, 'class="form-control" placeholder="Sub Category"'); ?>
                </div>
                <div class="col-md-2">
                    <?php
                        echo form_button([
                        'type'    => 'submit',
                        'content' => '<i class="fa fa-search"></i> Search',
                        'class'   => 'btn btn-info btn-sm',
                        ]);

                        echo anchor(NULL, '<i class="fa fa-refresh"></i> Reset', array(
                        'class' => 'btn btn-default btn-sm',
                        'onclick' => 'mydatatable.filterReset()'
                        ));
                        ?>
                  </div>
            </div>
        </form>
    </div>
    <div class="portlet-title">
        
    <!-- <div class="actions">
      <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="#" rel="tooltip" data-placement="top" title="fullscreen"></a>
    </div>
    <div style="clear:both" ></div> -->
        <?php
    if ($this->laccess->otoritas('add')) {
        echo anchor($_modul . '/add', '<i class="glyphicon glyphicon-plus"></i> Add ' . $_title, array(
      'id' => 'mybutton-add',
      'class' => 'btn btn-labeled btn-primary',
        ));
    }
    // echo anchor($_modul . '/create_daftar_rekanan', '<i class="glyphicon glyphicon-plus"></i> Create Daftar Rekanan', array(
    //  'id' => 'mybutton-add',
    //  'class' => 'btn btn-labeled btn-primary',
    //  'data-toggle' => "modal",
    //  'data-target' => "#remoteModalcreate_daftar_rekanan",
    //  'data-keyboard' => "false",
    //  'data-backdrop' => "static"
    // ));

    // echo anchor(NULL, ' Import Excel', array(
    //   'id'          => 'mybutton-add',
    //   'class'       => 'btn btn-labeled btn-success',
    //   'data-toggle' => 'modal',
    //   'data-target' => '#modal-import'
    // ));
  ?>
  <div style="text-align:right;float:right" >
    
  <!-- <?php
    //if ($data_daftar_rekanan){
      //echo 'Daftar Rekanan Terhitung mulai tanggal <b>'. $data_daftar_rekanan->tgl_laporan .'</b> sampai dengan tanggal <b>'.$data_daftar_rekanan->sampai_tgl_laporan.'</b>';
    //}
  ?> -->
  </div>
    </div>
    <div class="portlet-body">
        <table id="dt-basic" 
                 class="table table-striped table-bordered table-hover" 
                 width="100%" style="margin-top: 0 !important;"
                 data-table-source="<?php echo base_url() . $_modul . '/load'; ?>"
                data-table-filter="#filter-table">
            <thead>                         
                <tr>
                    <th >NO</th>
                    <th >NAMA PERUSAHAAN</th>
                    <th >GRADE</th>
                    <th >ADDRESS</th>
                    <th >CONTACT PERSON</th>
                    <th >Telp / HP</th>
                    <th >EMAIL</th>
                    <th >SUB CATEGORY</th>
                    <th >CREATOR</th>
                    <th >FUNCTION</th>
                </tr>
            </thead>
        </table>
    </div>
  </div>
</div>

 <!-- Dynamic Modal -->  
  <div class="modal" id="remoteModalcreate_daftar_rekanan" tabindex="-1" data-backdrop="static" aria-hidden="true"></div>  
  <div class="modal" id="remoteModal" tabindex="-1" data-backdrop="static" aria-hidden="true"></div>  
  <div class="modal" id="remoteModalBar" data-width="600" data-backdrop="static"></div>
  <div class="modal" id="modalDetail" tabindex="-1" data-backdrop="static" aria-hidden="true" data-width="800">  </div> 
   <div class="modal" id="modalDetailevaluated" tabindex="-1" data-backdrop="static" aria-hidden="true" data-width="800">  </div> 
  
  
  <div class="modal" id="modal-import" data-backdrop="static">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
              <i class="fa fa-times"></i>
          </button>
          <h4 class="modal-title">
            <span class="caption-subject bold uppercase"> 
                      IMPORT EXCEL
              </span>
        </h4>
      </div>

      <?php echo form_open_multipart($_modul .'/import', array('class' => 'form-horizontal', 'id' => 'form-import')) ?>

        <div class="modal-body">
          <div class="fileinput fileinput-new input-group" data-provides="fileinput">
            <div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
            <span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new">Select file</span><span class="fileinput-exists">Change</span>
            <input type="file" name="file"></span>
            <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
          </div>
        </div>

      

      <div class="modal-footer">
          <?php echo form_button(array(
                  'content' => 'Batal',
                  'type' => 'button',
                  'class' => 'btn default',
                  'data-dismiss' => 'modal'
          )) ?>

          <?php echo form_button(array(
                  'content' => '<i class="fa fa-import"></i> Import',
                  'type' => 'submit',
                  'class' => 'btn green'
          )) ?>   
      </div>
      <?php echo form_close() ?>
  </div>
  <!-- /.modal -->

<script type="text/javascript">
    pageSetUp();
    var formFilter = $('form#filter-table');
    // mydatatable.init('#dt_basic');
    var mydatatable = $('#dt-basic').myDataTable({
         columns: [
              {orderable : false},
              {name: 'nama_perusahaan'},
              {name: 'ranking'},
              {name: 'alamat'},
              {name: 'contact_person'},
              {name: 'no_telpon'},
              {name: 'email'},
              {name: 'sub_category'},
              {name: 'status'},
              {name: 'role',orderable : false},
              
          ],
    });

   $("form#filter-table").bind('submit',function(){
    __reloadTable();
  return false;
  });
   
  var __reloadTable = function(refresh) {
    // $('.loading-save-form').css('display', 'none');
    mydatatable.reload(refresh);
  };

  
    function showFieldDate() {
        var by = $('#date-by').val();

        $('#ftahun, #fbulan, #ftanggal').hide();
        $(':input', $('#filter-date')).attr('disabled','disabled');

        if(by) {
            switch(by) {
                case '1':
                    $('#ftahun').show();
                    $(':input', $('#ftahun')).removeAttr('disabled');
                    break;
                case '2':
                    $('#fbulan').show();
                    $(':input', $('#fbulan')).removeAttr('disabled');
                    break;
                case '3':
                    $('#ftanggal').show();
                    $(':input', $('#ftanggal')).removeAttr('disabled');
                    break;

                default:

                    break;
            }
        }
  }
    
  $(':input#date-by').on('change', function() {
      showFieldDate();
  });


    $('form#form-import').submit(function(event) {
          event.preventDefault();
          $(this).myForm({
            confirmMessage : 'Anda yakin akan mengimport file ke data vendor ?',
            success : function() {
                $('.modal').modal('hide');
                my_data_table.reload('#dt_basic');
            }
        }).submit();
    });

     function renderField() {
        $('#btn-excel').attr('href','<?php echo $_modul ?>/excel?' + formFilter.serialize());
        $('#btn-pdf').attr('href','<?php echo $_modul ?>/pdf?' + formFilter.serialize());
    }

    $(function() {
        renderField();
        showFieldDate();
    });

</script>

