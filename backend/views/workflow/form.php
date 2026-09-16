<style type="text/css">.se-pre-con {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url("<?php echo base_url(); ?>/assets/img/ezgif.gif") center no-repeat ;
    background-color: #eeeeee;
    opacity: 0.83;
  }
  .dd-handlee {
    background: #fafafa none repeat scroll 0 0;
    border: 1px solid #ccc;
    border-radius: 3px;
    box-sizing: border-box;
    color: #333;
    cursor: move;
    display: block;
    font-weight: 400;
    height: 30px;
    margin: 5px 0;
    padding: 5px 10px;
    text-decoration: none;
}
</style>

  <!-- <div class="se-pre-con" style="display: none;">
    <div  style="font-size: 16px; color: #E19F51; text-align: center; margin-top: 410px;"> Mohon Tunggu Beberapa Menit, Sedang Proses Penyimpanan</div>
  </div> -->
<div class="container-fluid">
  <div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-dark">
            <span class="caption-subject bold uppercase"><?php echo $page_title; ?></span>
            <span class="caption-helper"></span>
        </div>
        <div class="actions">
        <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="#" rel="tooltip" data-placement="top" title="fullscreen"></a>
      </div>
    </div>
    <div class="portlet-title">
    
      <?php echo form_open($_module . '/load_flow/'.$id, 'class="form-horizontal" id="form-filter"') ?>
      <fieldset>
       <!--  <div class="form-group">
          <label class="control-label col-md-1">Cabang</label>
          <div class="col-md-4">

          <?php// echo form_dropdown('cabang_id', $cabang,$this->session->userdata('cabang_id'), 'class="form-control select2" placeholder="" onchange="__pageFunction()"'); ?>

          </div>
        </div> -->

          <div class="form-group">
            <label class="control-label col-md-2">Project / Transaksi HO</label>
              <div class="col-md-4">
                 <?php echo form_dropdown('project_id', $project,$this->session->userdata('project_id'), 'class="form-control select2" placeholder="" onchange="__pageFunction2()"'); ?>
              </div>

               <label class="col-md-2">
               <button class="btn btn-danger" type="button" onclick="duplicate(<?php echo $type_duplicate ?>)"><i class="fa fa-files-o" aria-hidden="true"></i>
 Duplicate ROLE</button></label>
             
              
         </div>
      </fieldset>
      <?php echo form_close() ?>

    </div>
    <div class="portlet-title">
      <?php if ($this->laccess->otoritas('edit')) {
          echo anchor($_module . '/add_role/'.$id, '<i class="glyphicon glyphicon-plus"></i> Add ' . $_title, 
            [
                'id'            => 'btn-add-role',
                'class'         => 'btn btn-labeled btn-primary',
                'data-toggle'   => "modal",
                'data-target'   => "#remoteModal",
                'data-keyboard' => "false",
                'data-backdrop' => "static"
            ]);
          }
        ?>
    </div>
    <div class="portlet-body">
      <div>
         <h6>Drag node to sort flow order.</h6>
          <div id="dload"></div>
      </div>
       <!-- <div class="col-md-3">
         <h6>&nbsp;</h6>
          <div id="dloador"></div>
      </div> -->
     <!--  <div class="clearfix"></div> -->
      
    </div>

    <div class="portlet-footer" style="margin-top:20px">
      <div class="modal-footer">
        <?php
          echo anchor(NULL, '<i class="glyphicon glyphicon-chevron-left"></i> Kembali', 
                [
                    'class' => 'btn btn-labeled btn-default margin-right-2',
                    'onclick' => 'my_global.go_back()'
                ]);
        ?> 
      </div>
    </div>
  </div>
</div>

<div class="modal" data-width="1000" id="remoteModal" data-backdrop="static"></div>

<div class="modal container" id="modalduplicate" data-backdrop="static" tabindex="-1" aria-hidden="true" data-width="700">
  <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                <i class="fa fa-times"></i>
            </button>
            <h4 class="modal-title title-detail" style="font-weight: bold;">
                <i class="fa fa-file"></i> Duplicate Workflow Approved 
            </h4>
        </div>
        <div class="modal-body">
            <form name="form_duplicate" id="form_duplicate">
            <fieldset>
            <?php echo form_hidden('order','','class="order_id"') ?>
                <div class="form-group col-md-12">
                  <label class="control-label col-md-3">DUPLICATE FROM </label>
                    <div class="col-md-7">
                       <?php echo form_dropdown('project_id_from', $project,$this->session->userdata('project_id'), 'class="form-control select2" placeholder="'); ?>
                    </div>
                </div>

                 <div class="form-group col-md-12">
                  <label class="control-label col-md-3">DUPLICATE TO </label>
                    <div class="col-md-7">
                       <?php echo form_dropdown('project_id_to', $project,$this->session->userdata('project_id'), 'class="form-control select2" placeholder="" '); ?>
                    </div>
                </div>
                </fieldset>
            </form>
          
        </div>
         <div class="modal-footer">
            <?php 
              echo anchor(NULL, '<i class="glyphicon glyphicon-chevron-left"></i> Close',
              [
                  'class' => 'btn btn-default margin-right-2',
                  'data-dismiss' => 'modal',
                  
              ]);


              echo form_button([  
                 
                  'content' => '<i class="glyphicon glyphicon-floppy-disk"></i> Simpan',
                  'class'   => 'btn btn-success',
                  'onclick' => 'submit_form_duplicate()',
              ]);
            ?>
            

 
        </div>
</div> 

<script type="text/javascript">
    pageSetUp();
    
    var __pageFunction = function () {
        
        $.post('<?php echo base_url() . $_module. '/load_flow/'.$id; ?>', $('#form-filter').serialize(), function(data) {
            $('#dload').html(data);
            $('.modal').modal('hide');
            $('#btn-add-role').attr('href','<?php echo base_url().$_module . '/add_role/'.$id ?>?' + $('#form-filter').serialize());
              $('[data-action="collapse"]').attr('style', 'display:none;');
            $('[data-action="expand"]').attr('style', 'display:block;');
        });

        // $.post('<?php// echo base_url() . $_module. '/load_flow_or/'.$id; ?>', $('#form-filter').serialize(), function(data) {
          
        //     $('#dloador').html(data);
        //     $('.modal').modal('hide');
           // $('#btn-add-role').attr('href','<?php// echo base_url().$_module . '/add_role/'.$id ?>?' + $('#form-filter').serialize())
        // });
        
    };

    function duplicate(type_duplicate){
      $('.order_id').val(type_duplicate);
      $('#modalduplicate').modal('show');
    }

       var __pageFunction2 = function () {
        
        $.post('<?php echo base_url() . $_module. '/load_flow/'.$id; ?>', $('#form-filter').serialize(), function(data) {
            $('#dload').html(data);
            $('.modal').modal('hide');
            $('#btn-add-role').attr('href','<?php echo base_url().$_module . '/add_role/'.$id ?>?' + $('#form-filter').serialize());

            $('[data-action="collapse"]').attr('style', 'display:none;');
            $('[data-action="expand"]').attr('style', 'display:block;');
           
        });

    
        
    };

    function submit_form_duplicate(){
      swal({
        title: "Save Duplicate Workflow?",
        text: "Anda yakin akan Duplicate Workflow.",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Yes',
        cancelButtonText: "Cancel",
        closeOnConfirm: true,
        closeOnCancel: true
          },
          function(isConfirm) {
              if (isConfirm) {
                $('.se-pre-con').css('display', 'block');
                $.ajax({
                        type: "POST",
                        async: 'true',
                        cache: 'false',
                        url: 'backend/workflow/save_duplicate',
                        data: $("#form_duplicate").serialize(),
                        dataType: "JSON",
                        success: function (data) {
                         $('#modalduplicate').modal('hide');
                          swal("Success", "Success simpan Duplicate Workflow", "success");
                          $('.send_email_rfq').css('display', 'none');

                          location.reload();
                        },

                         error: function (jqXHR, textStatus, errorThrown){

                          swal("Gagal", "Gagal Menyimpan terjadi Kesalahan", "error");
                          $('.se-pre-con').css('display', 'none');
                         
                        }
                       
                });
              } 
          });

        
    }
 
loadScript("<?php echo hconfig::base_assets(); ?>/plugin/nestable/jquery.nestable.min.js", __pageFunction);
</script>
