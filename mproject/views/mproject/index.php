<div class="row">
  <div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-dark">
          <span class="caption-subject bold uppercase"><?php echo $pageTitle ?></span>
          <span class="caption-helper"></span>
        </div>
        <div class="actions">
          <a class="btn btn-circle btn-icon-only btn-info show-field" href="javascript:;" data-show-target="#div-filter">
                <i class="icon-magnifier"></i>
            </a>
            <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;" rel="tooltip" data-placement="top" title="fullscreen"></a>
        </div>
    </div>
  	<div class="portlet-title">
      <form class="form-horizontal" id="filter-table">

                 <div class="col-md-2">
                   <select class="form-control" name="project">
                       <option value="">--pilih--</option>
                       <option value="1">Head Office</option>
                       <option value="2">Equipment</option>
                       <option value="3">Project</option>
                   </select>
                </div>

                <div class="col-md-2">
                    <?php echo form_input('kode', NULL, 'class="form-control" placeholder="Kode Project"'); ?>
                </div>
      
				<div class="col-md-2">
					<?php echo form_input('name', NULL, 'class="form-control" placeholder="Nama Project"'); ?>
				</div>

                 <div class="col-md-2">
                    <?php echo form_input('client_name', NULL, 'class="form-control" placeholder="Client"'); ?>
                </div>
			
    			<div class="col-md-2">
    				
    				<div class='input-group date'>
    				  <?php echo form_input('tanggal',NULL, 'class="form-control date" placeholder="Tanggal"') ?>
    				  <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
    				</div>
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
				'onclick' => 'filtercls()'
				));
				?>
			</div>
       
       
				
      </form>
    </div>
    <div class="portlet-title">
        <?php
            if ($this->laccess->otoritas('add')) {
               echo anchor(NULL, '<i class="glyphicon glyphicon-plus"></i> Tambah Project / Transaksi HO', array(
                                    'id'              => 'mybutton-add',
                                    'class'           => 'btn btn-labeled btn-primary',
                                    'data-module'     => $_modul,
                                    'data-href'       => $_modul.'/form'
                    ));
            }
        ?>
    </div>
    <div class="portlet-body">
        <table id="dt_basic"
               class="table table-striped table-bordered table-hover"
               width="100%" style="margin-top: 0 !important;"
               data-table-source="<?php echo base_url() . $_modul . '/load'; ?>"
               data-table-filter="#filter-table">
            <thead>
                <tr>
                    <th data-sorting="false"> NO</th>
                    <th> TYPE TRANSAKSI</th>
                    <th>SITE</th>
                    <th>KODE AREA</th>
                    <th>NAMA TRANSAKSI HO / PROJECT</th>
                    <th>CLIENT HO / PROJECT</th>
                    <th>JUMLAH USER</th>
                    <th>JUMLAH KOTA</th>
                    <th>TANGGAL</th>
                    <th class="text-center" width="100">FUNCTION</th>
                </tr>
            </thead>
        </table>
    </div>
</div>


 <!-- Dynamic Modal -->
<div class="modal" id="modalDetail" data-backdrop="static" tabindex="-1" aria-hidden="true" data-width="1200"></div>
<div class="modal" id="modalKota" data-backdrop="static" tabindex="-1" aria-hidden="true" data-width="1200"></div>


<script type="text/javascript">
    pageSetUp();
    var mydatatable = $('#dt_basic').myDataTable({
        columns: [
            {orderable : false},
            {name: 'project'},
            {name: 'project'},
            {name: 'project'},
            {name: 'kode_project'},
            {name: 'nama_project'},
            {name: 'user',orderable : false},
            {name: 'kota_nama',orderable : false},
            {name: 'create_at',orderable : false},
            {orderable: false},
        ],
    });

    $("form#filter-table").bind('submit',function(){
       __reloadTable();
       return false;
    });

    var __reloadTable = function(refresh) {
        mydatatable.reload(refresh);
    };
	function filtercls(){
		$("#filter-table")[0].reset();
		mydatatable.reload();
	}
</script>
