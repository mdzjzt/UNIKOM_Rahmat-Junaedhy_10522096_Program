<style>
	.select2-hidden-accessible {
	    display: none;
	}
	.spanspasi {
	    padding: 0 10px;
	}
</style>

<div class="container-fluid fuelux">

	<div class="portlet light">

		<div class="portlet-title">
			<div class="caption font-dark">
				<span class="caption-subject bold uppercase">ADD DATABASE VENDOR MATERIAL</span>
				<span class="caption-helper"></span>
			</div>
		</div>

		<div class="portlet-body">

        <?php echo anchor(null, '<i class="fa fa-plus"></i> Tambah', array('class' => 'btn blue', 'onclick' => 'add_equipment_form()')); ?>
        
        <?php $hidden_form = array('id' => !empty($id) ? $id : '');
            echo form_open_multipart($form_action, ['id' => 'finput', 'class' => 'form-horizontal'], $hidden_form);
        ?>
          <fieldset>
			<div class="form-group form-group-md ">
               <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover datatable dataTable" width="100%">
                            <thead>
                                <tr>

                                    <th class="">No</th>
                                    <th class="" width="">DESCRIPTION</th>
                                   <!--  <th class="">RADIUS</th>
                                    <th class="">DEGREE</th>  -->
                                    <th class="">SIZE</th>
                                    <th class="">QTY</th>
                                    <th class="">UNIT</th>
                                    <th class="">SPECIFICATION</th>
                                    <th class="">VENDOR</th>
                                    <th class="">ORIGIN</th>
                                 	<th class="" >UNIT PRICE</th> 
                                    <th class="">TOTAL PRICE</th>
                                    <th class="">REMARKS</th>
                                    <th class=""></th>
                    
                                </tr>
                            </thead>
                            <tbody id="lk_temp" style="display: none;">
                                <tr class="lk_tr">
                                	<td class="text-center no_lk">1</td>
                                    <td class="text-center" width="200px">
                                    	<?php echo form_input('',!empty($data->description) ? $data->description : NULL, 'class="form-control description" placeholder="ELBOW" id=""') ?>
                                    </td>
                                  <!--   <td class="text-center">
                                    	<?php // echo form_input('',!empty($data->radius) ? $data->radius : NULL, 'class="form-control radius" placeholder="5D" id=""') ?>
                                    </td>
                                    <td class="text-center" >
                                    	<?php // echo form_input('',!empty($data->degree) ? $data->degree : NULL, 'class="form-control degree" placeholder="90" id=""') ?>
                                    </td>  -->
                                    <td class="text-center" width="90px">
                                    	<?php echo form_input('',!empty($data->size) ? $data->size : NULL, 'class="form-control size" placeholder="3&quot;" id=""') ?>
                                    </td>
                                    <td class="text-center" width="90px">
                                    	<?php echo form_input('',!empty($data->qty) ? $data->qty : NULL, 'class="form-control qty" placeholder="2" id=""  onkeyup="hitung_cost()"') ?>
                                    </td>
                                    <td class="text-center" width="90px">
                                    	<?php echo form_input('',!empty($data->unit) ? $data->unit : NULL, 'class="form-control unit" placeholder="EA" id=""') ?>
                                    </td>
                                    <td class="text-center" width="400px">
                                    	<?php echo form_textarea('',!empty($data->specification) ? $data->specification : NULL, 'class="form-control specification" placeholder="SCH. 160 ASTM A234 Gr. WPB. SMLS. BW" rows="4" id=""') ?>
                                    </td>
                                	<td class="text-center" width="200px">
                                		<?php echo form_input('',!empty($data->unit) ? $data->unit : NULL, 'class="form-control vendor" placeholder="PT. BLA BLA" id=""') ?>
                                	</td>
                                	<td class="text-center" width="200px">
                                		<?php echo form_input('',!empty($data->origin) ? $data->origin : NULL, 'class="form-control origin" placeholder="CHINA" id=""') ?>
                                	</td>
                                    <td class="text-center" width="400px">
                                    <?php echo form_input('',!empty($data->unit_price) ? $data->unit_price : NULL, 'class="form-control unit_price"  onkeyup="hitung_cost()" placeholder="4200" id=""') ?>
                                    	 <select class="form-control simbolcurrency" style="padding: 0px;" id="" name=""  onchange="">
                                              <option value="IDR">IDR</option>
                                              <option value="USD">USD</option>
  										</select>
  										
                                    </td>
                                    <td class="text-center" width="400px">
                                    	<?php echo form_input('',!empty($data->unit_price) ? $data->unit_price : NULL, 'class="form-control total_price" placeholder="8400" id="" readonly=""') ?>
                                    </td>
                                    <td width="200px">
                                    		<?php echo form_textarea('',!empty($data->remarks) ? $data->remarks : NULL, 'class="form-control remarks" placeholder="" rows="4" cols="4" id=""') ?>
                                    </td>
                                    <td>
                                        <?php echo anchor(null, '<i class="fa fa-minus"></i>', array('class' => 'btn red btn_lk btn-xs')); ?>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody id="lk_list">
                                <tr id="tr_lk_1" class="lk_tr">
                                    <td class="text-center no_lk">1</td>
                                    <td class="text-center" width="200px">
                                    	<?php echo form_input('description[]',!empty($data->description) ? $data->description : NULL, 'class="form-control" placeholder="ELBOW" id="description_1"') ?>
                                    </td>
                                   <!--  <td class="text-center">
                                    	<?php // echo form_input('radius[]',!empty($data->radius) ? $data->radius : NULL, 'class="form-control" placeholder="5D" id="radius_1"') ?>
                                    </td>
                                    <td class="text-center" >
                                    	<?php // echo form_input('degree[]',!empty($data->degree) ? $data->degree : NULL, 'class="form-control" placeholder="90" id="degree_1"') ?>
                                    </td>  -->
                                    <td class="text-center" width="90px">
                                    	<?php echo form_input('size[]',!empty($data->size) ? $data->size : NULL, 'class="form-control" placeholder="3&quot;" id="size_1"') ?>
                                    </td>
                                    <td class="text-center" width="90px">
                                    	<?php echo form_input('qty[]',!empty($data->qty) ? $data->qty : NULL, 'class="form-control" placeholder="2"  onkeyup="hitung_cost(1)" id="qty_1" ') ?>
                                    </td>
                                    <td class="text-center" width="90px">
                                    	<?php echo form_input('unit[]',!empty($data->unit) ? $data->unit : NULL, 'class="form-control" placeholder="EA" id="unit_1"') ?>
                                    </td>
                                    <td class="text-center" width="400px">
                                    	<?php echo form_textarea('specification[]',!empty($data->specification) ? $data->specification : NULL, 'class="form-control" placeholder="SCH. 160 ASTM A234 Gr. WPB. SMLS. BW" rows="4" id="specification_1"') ?>
                                    </td>
                                	<td class="text-center" width="200px">
                                		<?php echo form_input('vendor[]',!empty($data->unit) ? $data->unit : NULL, 'class="form-control" placeholder="PT. BLA BLA" id="vendor_1"') ?>
                                	</td>
                                	<td class="text-center" width="200px">
                                		<?php echo form_input('origin[]',!empty($data->origin) ? $data->origin : NULL, 'class="form-control" placeholder="CHINA" id="origin_1"') ?>
                                	</td>
                                    <td class="text-center" width="400px">
                                    <?php echo form_input('unit_price[]',!empty($data->unit_price) ? $data->unit_price : NULL, 'class="form-control number"  onkeyup="hitung_cost(1)" placeholder="4200" id="unit_price_1"') ?>
                                    	 <select class="form-control" style="padding: 0px;" id="" name="simbolcurrency[]"  onchange="">
                                              <option value="IDR">IDR</option>
                                              <option value="USD">USD</option>
  										</select>
  										
                                    </td>
                                    <td class="text-center" width="400px">
                                    	<?php echo form_input('total_price[]',!empty($data->unit_price) ? $data->unit_price : NULL, 'class="form-control" placeholder="8400" id="total_price_1" readonly=""') ?>
                                    </td>
                                    <td width="200px">
                                    		<?php echo form_textarea('remarks[]',!empty($data->remarks) ? $data->remarks : NULL, 'class="form-control" placeholder="" rows="4" cols="4" id="specification_1"') ?>
                                    </td>

                                    <td>
                                        <?php echo anchor(null, '<i class="fa fa-minus"></i>', array('class' => 'btn red btn_lk btn-xs', 'onclick' => 'remove_equipment_form(1)')); ?>
                                    </td>
                                </tr>
                            </tbody>
                          <!--   <tfoot>
                              <tr>
                                <td align="right" colspan="7"><b>Grand Total</b></td>
                                <td align="left" colspan=""><b>  <?php // echo form_input('gran_total', '', 'class="form-control gran_total" id= "gran_total" readonly') ?></b></td>
                                <td align="left" colspan="4"></td>
                              </tr>
                            </tfoot> -->
                    </table>
                </div>
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
	</div>

</div>

<script type="text/javascript">

	 pageSetUp();

	 var formBasic = $('form#finput');
    $('form#finput').submit(function(event) {
        event.preventDefault();
        formBasic.myForm().submit();
    });

    $("form#filter_table").bind('submit',function(){
       my_data_table.reload('#dt_akun');
       return false;
    });

   var __afterSubmit = function() {
        setTimeout(function(){
          my_form.go_back();
        },200);
      };


    function add_equipment_form() {
        var temp_equipment_form = $('#lk_temp').html();
        $('#lk_list').append(temp_equipment_form );
        render_equipment_form();
    }

    function render_equipment_form() {
        var no = 0;
        $.each($('#lk_list tr.lk_tr'), function () {
        
            no++;
            $(this).attr('id', 'tr_lk_' + no);
           	
           	$('.description', this).attr('name', 'description[]');
            $('.description', this).attr('id', 'description_' + no);

            $('.radius', this).attr('name', 'radius[]');
            $('.radius', this).attr('id', 'radius_' + no);

            $('.degree', this).attr('name', 'degree[]');
            $('.degree', this).attr('id', 'degree_' + no);

            $('.size', this).attr('name', 'size[]');
            $('.size', this).attr('id', 'size_' + no);

            $('.qty', this).attr('name', 'qty[]');
            $('.qty', this).attr('id', 'qty_' + no);
            $('.qty', this).attr('onkeyup', 'hitung_cost('+ no +')');


            $('.unit_price', this).number(true, 2).val();
            $('.unit', this).attr('name', 'unit[]');
            $('.unit', this).attr('id', 'unit_' + no);

            $('.specification', this).attr('name', 'specification[]');
            $('.specification', this).attr('id', 'specification_' + no);

            $('.vendor', this).attr('name', 'vendor[]');
            $('.vendor', this).attr('id', 'vendor_' + no);

            $('.origin', this).attr('name', 'origin[]');
            $('.origin', this).attr('id', 'origin_' + no);

            $('.unit_price', this).attr('name', 'unit_price[]');
            $('.unit_price', this).attr('id', 'unit_price_' + no);
            $('.unit_price', this).attr('onkeyup', 'hitung_cost('+ no +')');


            $('.total_price', this).attr('name', 'total_price[]');
            $('.total_price', this).attr('id', 'total_price_' + no);

            $('.simbolcurrency', this).attr('name', 'simbolcurrency[]');

            $('.remarks', this).attr('name', 'remarks[]');
            $('.remarks', this).attr('id', 'remarks_' + no);

            
            $('.no_lk', this).html(parseInt(no));
            $('.btn_lk', this).attr('onclick', 'remove_equipment_form(' + no + ')');
        });

    }

    function hitung_cost(id){
    	  var quan = $('#qty_'+id).val();
	      var unit_cost = $('#unit_price_'+id).val();
	      var result = parseInt(quan) * parseInt(unit_cost);

	      if (!isNaN(result)) {
	         $('#total_price_'+id).val(result).number(true, 2);
	          var no = 0;
	          var total = 0;
	            $.each($('#lk_list tr.lk_tr'), function () {
	                no++;
	               var jumlah = $('input.total_cost',this).val();
	               if(jumlah){
	                  total  += parseFloat(jumlah);
	                }

	            });
	        $('#gran_total').val(total).number(true, 2);
	      }
    }

</script>