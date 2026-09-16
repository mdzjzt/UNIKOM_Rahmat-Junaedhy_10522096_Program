<div class="row">
  <div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-dark">
          <span class="caption-subject bold uppercase"><?php echo $page_title ?></span>
          <span class="caption-helper"></span>
        </div>
    </div>
    <div class="portlet-title">
      <form class="form-horizontal" id="filter-table">
        <div class="form-group form-group-sm">
			
				<div class="col-md-3">
					<?php echo form_input('keyword', NULL, 'class="form-control" placeholder="Nama Proyek"'); ?>
				</div>
          <div class="col-md-2">
          <?php echo form_input('kode_projek', NULL, 'class="form-control" placeholder="Kode Proyek"'); ?>
        </div>

          <div class="col-md-3">
          <?php echo form_input('client', NULL, 'class="form-control" placeholder="Client"'); ?>
        </div>
			
			<div class="col-md-2">
		
				<div class='input-group date'>
				  <?php echo form_input('tanggal',NULL, 'class="form-control date" placeholder="tanggal"') ?>
				  <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
				</div>
			</div>
			<div class="col-md-2" style="text-align: right;">
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
     <div class="portlet-body">    
      <div class="table-responsive">
          <table id="dt-basic"
                 class="table table-striped table-bordered table-hover"
                 width="100%" style="margin-top: 0 !important;"
                 data-table-source="<?php echo base_url() . $_modul . '/load'; ?>"
                 data-table-filter="#filter-table">
                  <thead>
                      <tr>
                          <th data-sorting="false" style="width: 10px">NO</th>
                          <th style="width:150px" >NAMA PROYEK</th>
                          <th style="width:60px" >KODE PROYEK</th>
                           <th style="width:150px">CLIENT PROYEK</th>
                          <th style="width:30px">TGL PEMBUATAN</th>
                          <th style="width:120px">INFO  MR</th>
                          <th style="width:10px">ACTION</th>

                      </tr>
                  </thead>
          </table>
        </div>
      </div>
  </div>
</div>



<script type="text/javascript">
  pageSetUp();

   var mydatatable = $('#dt-basic').myDataTable({
        columns: [
            {orderable : false},
            {name: 'nama_projek', orderable: false},
            {name: 'kode_projek', orderable: false},
            {name: 'tgl', orderable: false},
            {orderable : false},
            {orderable : false},
             {orderable : false},
        ],
    });
	$("form#filter-table").bind('submit',function(){
		__reloadTable();
	return false;
	});
	var __reloadTable = function(refresh) {
    $('.loading-save-form').css('display', 'none');
		mydatatable.reload(refresh);
	};

</script>
