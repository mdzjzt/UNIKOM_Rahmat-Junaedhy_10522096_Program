    <style type="text/css">
    
    	.table tr td{
    		border:1px solid black;
    	}

    </style>
    
<div class="container-fluid">
	<div class="portlet light">

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
	        <div class="form-group">
	           <div class="col-md-8" >
	           		<table width="100%" class="table">
	           			<tr>
	           				<td style="border:1px solid black;">Nama Vendor</td>
	           				<td style="border:1px solid black;">:</td>
	           				<td style="border:1px solid black;"> <?php echo form_input('data_vendor', !empty($data->vendor) ? $data->vendor : '','class="form-control" placeholder="PT. Citra Panji Manunggal"') ?></td>
	           			</tr>
	           			<tr>
	           				<td>Alamat </td>
	           				<td>:</td>
	           				<td> <?php echo form_textarea('alamat', !empty($data->alamat) ? $data->alamat : '','class="form-control" rows="4" cols="4"') ?></td>
	           			</tr>
	           			<tr>
	           				<td>PH </td>
	           				<td>:</td>
	           				<td> <?php echo form_input('ph', !empty($data->ph) ? $data->ph : '','class="form-control" placeholder="0812335XXXXXX"') ?></td>
	           			</tr>
	           			<tr>
	           				<td>Fax </td>
	           				<td>:</td>
	           				<td> <?php echo form_input('fax', !empty($data->fax) ? $data->fax : '','class="form-control" placeholder=""') ?></td>
	           			</tr>
	           			<tr>
	           				<td>Attn </td>
	           				<td>:</td>
	           				<td> <?php echo form_input('attn', !empty($data->attn) ? $data->attn : '','class="form-control" placeholder="Budi S."') ?></td>
	           			</tr>
	           		</table>
	           	
	            </div>
	            <div class="col-md-4">
	            	
	            	<table width="100%" >
		              <tr>
		                <td style="text-align: center;border: 1px solid;background-color: #9ea2a6;font-size: 18px">Purchase Order</td>
		              </tr>
		              <tr>
		                <td style="text-align: center;border: 1px solid;font-size: 17px;">
		                  <p style="margin: 0px 10px 10px">Number</p>
		                  <p style="margin: 0px 10px 10px"><?php  echo form_input('no_po',!empty($data->no_po) ? $data->no_po : NULL, 'class="form-control" placeholder="159-PO-HO-0005-19" ') ?></p>

		                </td>
		                
		              </tr>
		              <tr>
		                <td style="text-align: center;border: 1px solid;font-size: 17px;padding: 0px 10px 10px;">
		                 </br> <p style="margin: 0px 10px 10px">Date</p>
		                  <div class='input-group date'>
	                         <?php echo form_input('tgl_po',!empty($data->tgl_po) ? date('d-m-Y',strtotime($data->tgl_po)) : date('d-m-Y'), 'class="form-control date"') ?>
	                             <span class="input-group-addon"><span class="fa fa-calendar"></span></span>                 
	                        </div>
	                     </td>
		               
		              </tr>
		              <tr>
		                <td style="text-align: center;border: 1px solid;"></td>
		              </tr>
		              <tr>
		                <td style="text-align: center;border: 1px solid;">
		                </br>
		                  <p style="margin: 0px 10px 10px"><span style="font-size: 17px">Material Requisition</span></p>
		                  <p style="margin: 0px 10px 10px"><?php  echo form_input('no_mr',!empty($data->no_mr) ? $data->no_mr : NULL, 'class="form-control" placeholder="159-MR-HO-0008-19" ') ?></p>
		                </td>               
		                
		              </tr>
		            </table>
				</div>

				<div class="col-md-12">
				<br>
					<table width="100%" style="border: 1px solid black;font-size: 18px !important" >
				        <tr style="border: 1px solid ;background-color: white">
				        <th  width="18%" style="border: 1px solid ;background-color: white;padding: 5px;" rowspan="3">Material Description</th>
				        <th  width="57%" style="border: 1px solid ;background-color: white;padding: 10px 10px 10px" rowspan="3">
				       		<?php  echo form_textarea('nama_po',!empty($data->judul_po) ? $data->judul_po : NULL, 'class="form-control" placeholder="Judul PO " rows="4" ') ?>
				        	
				        </th>
				        <th  width="25%"  style="border: 1px solid black;background-color: white;text-align: center" colspan="2"> Cost Account</th>
				        </tr>
				        <tr style="">
				          <td style="border: 1px solid ;background-color: white;padding: 5px;" class="tg-s268" align="right">Area</td>
				          <td style="border: 1px solid ;background-color: white;padding: 5px;" class="tg-s268">
				          <?php  echo form_input('no_proyek',!empty($data->area) ? $data->area : NULL, 'class="form-control" placeholder="001" ') ?></td>
				        </tr>
				        <tr style="">
				           <td style="border: 1px solid ;background-color: white;padding: 5px;" class="tg-s268" align="right">Currency</td>
				          <td style="border: 1px solid ;background-color: white;padding: 5px;" class="tg-s268">
				          	 <?php  echo form_input('currency',!empty($data->currency) ? $data->currency : NULL, 'class="form-control" placeholder="IDR" ') ?>
				          </td>

				        </tr>
				     </table>
				</div>
				<div class="col-md-12">
					<table width="100%" style="border: 1px solid ;font-size:18px !important" >
				        <tr>
				          <td width="18%" style="border: 1px solid ;padding: 5px;"><b>Project Name</td>
				          <td width="" style="padding: 10px 10px 10px"> <?php  echo form_textarea('project_name',!empty($data->nama_project) ? $data->nama_project : NULL, 'class="form-control" placeholder="Civil Works Blawan - Ijen Geothermal Project (HO)" ') ?></td>
				        </tr>
				      
				      </table>
				</div>
	        </div>

	        <div class="form-group form-group-sm">
	          
	                <div class="panel panel-default">
	                  <div class="panel-heading clearfix">
	                    <span class="panel-title">ITEM-ITEM MATERIAL PO <i class="fa fa-cart-arrow-down"></i> </span>
	                      <?php echo anchor(null, '<i class="fa fa-plus"></i> Tambah', array('class' => 'btn blue pull-right', 'onclick' => 'add_equipment_form()')); ?>
	                  </div>
	                  <div class="panel-body">
	                   <div class=""> 
	                 <!--    <div class=""> -->
	                      <table class="table table-striped table-bordered table-hover datatable dataTable  " style="margin-top: 10px;">
	                            <thead>
	                                <tr>
	                                    <th class="span1">No</th>
	                                    <th class="span1">QTY</th>
	                                    <th class="span1">Unit</th> 
	                                    <th class="span1">Description</th>
	                                    <th class="span1">Account Code</th>
	                                    <th class="span1">Unit Price</th>
	                                    <th class="span1">Total</th>
	                                    <th class="span1">Action</th>
	                                </tr>
	                            </thead>
	                            <tbody id="lk_temp" style="display: none;">
	                                <tr class="lk_tr">
	                                	<td class="text-center no_lk"><div class="input-group"></div></td>
	                                    <td class="text-center ">
	                                      <div class="input-group qty_" id=""  width="100px">
	                                          <?php echo form_input('','', 'class="form-control quan" onkeyup="hitung_cost()" id= "quantity_" placeholder="1"') ?>
	                                         </div>
	                                    </td>
	                                    <td class="text-center"  width="100px">
	                                      <div class="input-group">
	                                          <?php echo form_input('','', 'class="form-control unit" id= "unit_" placeholder="Unit"') ?>
	                                        </div>
	                                     
	                                    </td>
	                                    <td class="text-center" width="300px">
	                                       
											   <?php echo form_textarea('', NULL , 'class="form-control barang_nama" rows="2" id="barang_nama_" placeholder="Laptop "') ?>
											
	                                    </td>
	                                    <td>
	                                        <div class="input-group">
                                          	<?php echo form_input('','', 'class="form-control part_number" id= "part_number_" placeholder="12345"') ?>
                                        	</div>
	                                    </td>
	                                     <td>
	                                        <?php echo form_input('','', 'class="form-control unit_cost uc" onkeyup="hitung_cost()" id= "unit_cost_" placeholder="3,0000,000.00"') ?>
	                                    </td>
	                                     <td>
	                                        <div class="input-group">
                                          		<?php echo form_input('','', 'class="form-control total_cost" id= "total_cost_" readonly') ?>
                                        	</div>
	                                    </td>
	                                    <td>
	                                        <?php echo anchor(null, '<i class="fa fa-minus"></i>', array('class' => 'btn red btn_lk')); ?>
	                                    </td>

	                                </tr>
	                        </tbody>
	                        <tbody id="lk_list">
	                            <?php if ($id) { ?>
		                            	<?php $sub_total = NULL; $no=1;$no1=1;$no2=1;$no3=1;$no4=1;$no5=1;$no6=1;$no7=1;$no8=1;$no9=1;$no10=1;$no11=1;$no12=1;
		                            	 foreach ($data_item->result() as $key => $dt) { 
		                            	 	 $total_cost = $dt->qty * $dt->unit_price;
		                            	 	  $sub_total  += $total_cost;
		                            	 	?>
		                            	
		                                      <tr id="tr_lk_<?php echo $no++ ;?>" class="lk_tr">
		                                        <td class="text-center no_lk"> 
		                                          <div class="input-group">
		                                         		<?php echo $no12++ ?>
		                                          </div>
		                                        </td>
		                                        <td class="text-center" width="100px"> 
		                                           <div class="input-group qty" id="qty_<?php echo $no1++ ;?>">
		                                     	 	<?php echo form_hidden('id_item_po[]', !empty($dt->id_item_po) ? $dt->id_item_po: NULL, 'id = "id_kota" class="id_kota" ') ?> 

	                                        		<?php echo form_input('quantity[]',!empty($dt->qty) ? $dt->qty : NULL, 'class="form-control" onkeyup="hitung_cost('.$no2++.')" id= "quantity_'.$no4++.'" placeholder="1"') ?>
	                                      			</div>
		                                        </td>
		                                        <td class="text-center" width="100px" >
		                                            <div class="input-group">
			                                        	<?php echo form_input('unit[]',!empty($dt->unit) ? $dt->unit : NULL, 'class="form-control" id="unit_'.$no3++.'" placeholder="Unit"') ?>
			                                      	</div>
		                                        </td> 
		                                        <td class="text-center" width="300px">
		                                          
													 <?php echo form_textarea('barang_nama[]',!empty($dt->description) ? $dt->description : NULL , 'class="form-control" rows="2"  placeholder="Laptop" id="barang_nama_'.$no5++.'" ') ?>
													
		                                        </td>
		                                        <td class="text-center">
		                                          <div class="input-group">
			                                        <?php echo form_input('part_number[]',!empty($dt->account_code) ? $dt->account_code : NULL, 'class="form-control" id= "part_number_'.$no6++.'" placeholder="12345"') ?>
			                                      </div>
		                                        </td>
		                                        <td class="text-center">
		                                            <div class="input-group">
	 													<?php echo form_input('unit_cost[]',!empty($dt->unit_price) ? $dt->unit_price : NULL, 'class="form-control number" onkeyup="hitung_cost('.$no7++.')" id= "unit_cost_'.$no8++.'" placeholder="3,000,000.00"') ?>
	                                      			</div>
		                                        </td>
		                                        <td class="text-center" >
		                                           <div class="input-group">
			                                        <?php echo form_input('total_cost[]',!empty($total_cost) ? $total_cost : NULL, 'class="form-control total_cost number" id= "total_cost_'.$no9++.'" readonly') ?>
			                                      </div>
		                                        </td> 
		                                        <td>
		                                            <?php echo anchor(null, '<i class="fa fa-minus"></i>', array('class' => 'btn red btn_lk', 'onclick' => 'remove_equipment_form('.$no10++.','.$dt->id_item_po.')')); ?>
		                                        </td>
			                                    </tr>
			                            	
		                            	<?php } ?>
		                        <?php }else{ ?>
		                             	
		                                      <tr id="tr_lk_1" class="lk_tr">
		                                        <td class="text-center no_lk"> 
		                                          <div class="input-group">
		                                         		1
		                                          </div>
		                                        </td>
		                                        <td class="text-center" width="100px"> 
		                                           <div class="input-group qty" id="qty_1">
		                                     
	                                        		<?php echo form_input('quantity[]',NULL, 'class="form-control" onkeyup="hitung_cost(1)" id= "quantity_1" placeholder="1"') ?>
	                                      			</div>
		                                        </td>
		                                        <td class="text-center" width="100px" >
		                                            <div class="input-group">
			                                        	<?php echo form_input('unit[]', NULL, 'class="form-control" id= "unit_1" placeholder="Unit"') ?>
			                                      	</div>
		                                        </td> 
		                                        <td class="text-center" width="300px">
		                                          
													 <?php echo form_textarea('barang_nama[]',NULL , 'class="form-control" rows="2"  placeholder="Laptop" id="barang_nama_1" ') ?>
													
		                                        </td>
		                                        <td class="text-center">
		                                          <div class="input-group">
			                                        <?php echo form_input('part_number[]', NULL, 'class="form-control" id= "part_number_1" placeholder="12345"') ?>
			                                      </div>
		                                        </td>
		                                        <td class="text-center">
		                                            <div class="input-group">
	 													<?php echo form_input('unit_cost[]',NULL, 'class="form-control number" onkeyup="hitung_cost(1)" id= "unit_cost_1" placeholder="3,000,000.00"') ?>
	                                      			</div>
		                                        </td>
		                                        <td class="text-center" >
		                                           <div class="input-group">
			                                        <?php echo form_input('total_cost[]',NULL, 'class="form-control total_cost" id= "total_cost_1" readonly') ?>
			                                      </div>
		                                        </td> 
		                                        <td>
		                                            <?php echo anchor(null, '<i class="fa fa-minus"></i>', array('class' => 'btn red btn_lk', 'onclick' => 'remove_equipment_form(1)')); ?>
		                                        </td>
		                                    </tr>
		                        <?php } ?>
		                    </tbody>	
		                    <?php if ($id) { ?>
		                     	<tfoot>
		                       		<tr>
							            <td colspan="6" align="right">Sub Total</td>
							            <td width="15%" align="right" ><input type="text" value="<?php echo !empty($sub_total) ? $sub_total : NULL ?>" name="" class="sub_total_item form-control number" readonly=""> </td>
							            <td></td>
						          	</tr>   
						          	<tr>
							            <td colspan="6" align="right">Discount  </td>
							            <td width="15%" align="right" >
							             <?php echo form_input('diskon',!empty($data->diskon) ? $data->diskon : NULL,'class="number" onkeyup="hitung_cost(1)" id="diskon_nilai" ') ?>
							            </td>
							            <td></td>
							        </tr>
							        <tr>
							            <td  colspan="6" align="right">Gross Total</td>
							            <td width="15%" align="right"><input type="text" value="<?php echo !empty($data->jumlah_diskon) ? $data->jumlah_diskon: NULL ?>" name="gros_total" class="gross_total_item form-control number" readonly=""></td>
							            <td></td>
						          	</tr>
						         	<tr>
							            <td colspan="6" align="right">VAT <?php echo form_input('vat',!empty($data->vat) ? $data->vat : NULL,  'placeholder="10" id="vat_persen" onkeyup="hitung_cost(1)" ') ?>%</td>
							            <td width="15%" align="right" ><?php echo form_input('jumlah_vat',!empty($data->jumlah_vat) ? $data->jumlah_vat: NULL,'placeholder="100000" id="vat_nilai" onkeyup="hitung_cost(1)" class="form-control number" readonly="" ') ?></td>
							            <td></td>
							        </tr>
						          	<tr >
							            <td colspan="5" align="left"></td>
							            <td align="right">Net Total</td>
							            <td width="15%" align="right" ><input type="text" name="" value="<?php echo $data->jumlah_diskon - $data->jumlah_vat ?>" class="net_total_item form-control number" readonly=""></td>
							            <td></td>
						          	</tr> 
							         <tr>
							            <td  colspan="5" align="left">
							            Purchase/Service Order must be quoted on all packages, invoices, delivery dockets and correspondence.
							            </td>
							            <td  align="right">TOTAL</td>
							            <td width="15%" align="right"><b><p class="total_all_item"><?php echo number_format($data->jumlah_diskon + $data->jumlah_vat,2)?></p></b></td>
							            <td></td>
							        </tr>     
		                       </tfoot>
							<?php }else{ ?>
							 	<tfoot>
		                       		<tr>
							            <td colspan="6" align="right">Sub Total</td>
							            <td width="15%" align="right" ><input type="text" value="" name="" class="sub_total_item form-control" readonly=""> </td>
							            <td></td>
						          	</tr>   
						          	<tr>
							            <td colspan="6" align="right">Discount  </td>
							            <td width="15%" align="right" >
							             <?php echo form_input('diskon', NULL,'class="number" onkeyup="hitung_cost(1)" id="diskon_nilai" ') ?>
							            </td>
							            <td></td>
							        </tr>
							        <tr>
							            <td  colspan="6" align="right">Gross Total</td>
							            <td width="15%" align="right"><input type="text" value="" name="gros_total" class="gross_total_item form-control" readonly=""></td>
							            <td></td>
						          	</tr>
						         	<tr>
							            <td colspan="6" align="right">VAT <?php echo form_input('vat',NULL,  'placeholder="10" id="vat_persen" onkeyup="hitung_cost(1)" ') ?>%</td>
							            <td width="15%" align="right" ><?php echo form_input('jumlah_vat', NULL,'placeholder="100000" id="vat_nilai" onkeyup="hitung_cost(1)" class="form-control" readonly="" ') ?></td>
							            <td></td>
							        </tr>
						          	<tr >
							            <td colspan="5" align="left"></td>
							            <td align="right">Net Total</td>
							            <td width="15%" align="right" ><input type="text" name="" value="" class="net_total_item form-control" readonly=""></td>
							            <td></td>
						          	</tr> 
							         <tr>
							            <td  colspan="5" align="left">
							            Purchase/Service Order must be quoted on all packages, invoices, delivery dockets and correspondence.
							            </td>
							            <td  align="right">TOTAL</td>
							            <td width="15%" align="right"><b><p class="total_all_item"></p></b></td>
							            <td></td>
							        </tr>     
		                       </tfoot>
							<?php } ?>
	                      
	                      </table>
	                    </div>
	                  </div>
	                </div>
	        </div>
	        
	        <div class="form-group">
	           	<div class="col-md-12">
	           		<p style="font-size: 18px"><b>Terms And Conditions :</b></p>
	                <?php echo form_input('term_conditions', !empty($data->term_conditions) ? $data->term_conditions : '','class="tinymce"') ?>
	            </div>
	        </div> 

	         <div class="form-group">
	           	<div class="col-md-6">
	           		<p style="font-size: 18px"><b>NOTES PO :</b></p>
	                <?php echo form_input('notes', !empty($data->notes) ? $data->notes : '','class="tinymce"') ?>
	            </div>
	        </div> 

	        <div class="form-group form-group-md">
                <div class="container" style="width:80%;">
                    <?php echo anchor(null, '<i class="fa fa-plus"></i> Tambah List Approval', array('class' => 'btn blue', 'onclick' => 'add_biaya_form()')); ?>
                    <table class="table table-striped table-bordered table-hover datatable dataTable" style="margin-top: 10px;">
                            <thead>
                                <tr>
                                    <th class="span1">No</th>
                                    <th class="span1">Type Approval</th>
                                    <th class="span2">Nama Approval</th>
                                    <th class="span1">Tanggal</th>
                                   <th class="span1">Time</th> 
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="lk_temp_user" style="display: none;">
                                <tr class="lk_tr_user">
                                    <td class="text-center ">
                                    	<p class="no_lk_user"> 1</p>
                                    <?php echo form_hidden('', NULL , ' class="urut_" ') ?>
                                    </td>
                                    <td>
                                    	<div class="input-group">
                                      		<?php  echo form_dropdown('', $type_approval, !empty($value->type_approve) ? $value->type_approve : NULL, 'class="form-control type_approve_" id="typ"') ?> 
                                      	</div>
                                    </td>
                                    <td>
                                      <div class="input-group">

                                     <?php echo form_input('user_nam', NULL, 'class="form-control usnm" id= "user_nama"') ?>
                                       <?php echo form_hidden('user_i', NULL , 'id = "user_id" class="usid" ') ?>

                                       <div class="input-group-btn">
                                          <button class="btn btn-info" type="button" id="btn_modal" onclick="modal_user(0)"><i class="fa fa-user"></i></button>
                                      </div>
                                    </div>
                                    </td>
                                    <td>
                                    	<div class='input-group date'>
                                            <?php echo form_input('',date('d-m-Y '), 'class="form-control tgl_kebutuhan_ date"') ?>
                                             <span class="input-group-addon"><span class="fa fa-calendar"></span></span>                 
                                        </div>
                                    </td>
                                     <td>
                                          <?php echo form_input('', NULL, 'class="form-control jam_1" ') ?>
                                    </td>
                                    <td>
                                        <?php echo anchor(null, '<i class="fa fa-minus"></i>', array('class' => 'btn red btn_lk_user')); ?>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody id="lk_list_user">
	                            <?php if ($id) { ?>
	                            	<?php $noo=1;$noo1=1;$noo2=1;$noo3=1;$noo4=1;$noo5=1;$noo6=1;$noo7=1;$noo8=1;
	                            	 foreach ($data_approve->result() as $key => $value) { ?>
		                            	
			                                <tr id="tr_lk_user_<?php echo $noo++; ?>" class="lk_tr_user">
			                                    <td class="text-center ">
			                                    <p class="no_lk_user"> <?php echo $noo5++ ?></p>
			                                    	<?php echo form_hidden('no_urut[]', $value->urutan , ' class="urut_" ') ?>
			                                    </td>
			                                    <td>
			                                    	<div class="input-group">
			                                      		<?php  echo form_dropdown('type[]', $type_approval, !empty($value->type_approve) ? $value->type_approve : NULL, 'class="form-control type_approve" id="typ_'.$noo6++.'"') ?> 
			                                      	</div>
			                                    </td>
			                                    <td class="text-center">
			                                    <div class="input-group">
			                                    <?php echo form_hidden('id_approve[]', !empty($value->id_approve) ? $value->id_approve: NULL, '') ?> 
			                                      <?php echo form_input('user_name[]',!empty($value->pegawai_nama) ? $value->pegawai_nama :NULL , 'class="form-control" id= "user_nama_'.$noo1++.'"') ?>
			                                      <?php echo form_hidden('user_id[]',!empty($value->id_user_approve) ? $value->id_user_approve :NULL  , 'id = "user_id_'.$noo2++.'"') ?>
			                                       
			                                       <div class="input-group-btn">
			                                          <button class="btn btn-info" type="button" onclick="modal_user(<?php echo $noo3++ ?>)"><i class="fa fa-user"></i></button>
			                                      </div>
			                                    </div>
			                                    </td>
			                                    <td>
			                                    	<div class='input-group date' id='datetimepicker1'>
													<?php echo form_input('tgl_kebutuhan[]',!empty($value->date_approve) ? date('d-m-Y',strtotime($value->date_approve))  : date('d-m-Y'), 'class="form-control tgl_kebutuhan_ date"') ?>
													 <span class="input-group-addon"><span class="fa fa-calendar"></span></span>  
													 </div>
			                                    </td>
			                                    <td>
		                                    		<?php echo form_input('jam[]', !empty($value->jam) ? $value->jam :NULL , 'class="form-control" id= "jam_'.$noo8++.'" placeholder="00:00:00"') ?>
		                                    	</td>
			                                    <td>
			                                        <?php echo anchor(null, '<i class="fa fa-minus"></i>', array('class' => 'btn red btn_lk_user', 'onclick' => 'remove_biaya_form('.$noo4++.','.$value->id_approve.')')); ?>
			                                    </td>
			                                </tr>
			                         
			                        <?php } ?>
	                            <?php }else{ ?>
		                           
		                                <tr id="tr_lk_user_1" class="lk_tr_user">
		                                    <td class="text-center ">
		                                   	<p class="no_lk_user"> 1</p>
		                                    <?php echo form_hidden('no_urut[]', 1 , ' class="urut_" ') ?>
		                                    </td>
		                                    <td>
			                                   	<div class="input-group">
			                                      <?php  echo form_dropdown('type[]', $type_approval, !empty($value->type_approve) ? $value->type_approve : NULL, 'class="form-control type_approve" id="typ_1"') ?> 
			                                    </div>
			                                </td>
		                                    <td class="text-center">
		                                    <div class="input-group">

		                                      <?php echo form_input('user_name[]', NULL, 'class="form-control" id= "user_nama_1"') ?>
		                                       <?php echo form_hidden('user_id[]',  NULL , 'id = "user_id_1"') ?>
		                                       
		                                       <div class="input-group-btn">
		                                          <button class="btn btn-info" type="button" onclick="modal_user(1)"><i class="fa fa-user"></i></button>
		                                      </div>
		                                    </div>
		                                    </td>
		                                    <td>
		                                    	<div class='input-group date'>
												<?php echo form_input('tgl_kebutuhan[]',date('d-m-Y'), 'class="form-control tgl_kebutuhan_ date"') ?>
												 <span class="input-group-addon"><span class="fa fa-calendar"></span></span>  
												 </div>
		                                    </td>
		                                     <td>
		                                    	<?php echo form_input('jam[]', NULL, 'class="form-control" id= "jam_1" placeholder="00:00:00"') ?>
		                                    </td>
		                                    <td>
		                                        <?php echo anchor(null, '<i class="fa fa-minus"></i>', array('class' => 'btn red btn_lk_user', 'onclick' => 'remove_biaya_form(1)')); ?>
		                                    </td>
		                                </tr>
		                           
	                            <?php } ?>
	                        </tbody>  
                        </table>
                    </div>
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
                      <?php echo form_input('keyword','' , 'class="form-control input-sm" id="myInputID" onkeypress="search_user()"') ?>
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



<div class="modal container" id="modalPegawai" data-backdrop="static" tabindex="-1"> </div>
<!-- /.modal -->

<script type="text/javascript">
    pageSetUp();
  
    // $('#datetimepicker1').datetimepicker();
    var el = document.getElementById("myInputID");
    el.addEventListener("keypress", function(event) {
      if (event.key === "Enter") {
      search_user()
        event.preventDefault();
      }
    });

    var formBasic = $('form#finput');
    $('form#finput').submit(function(event) {
        event.preventDefault();
        formBasic.myForm().submit();
    });


  	var modalDataUser = $('#modal-data-user');

 	loadScript("<?php echo hconfig::base_assets(); ?>/libs/tinymce/js/tinymce/tinymce.min.js",loadTinymce);
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
         var today = new Date();
          var dd = today.getDate();
          var mm = today.getMonth()+1; //January is 0!

          var yyyy = today.getFullYear();
          if(dd<10){
              dd='0'+dd;
          } 
          if(mm<10){
              mm='0'+mm;
          } 
          var today = dd+'-'+mm+'-'+yyyy;
            no++;
            $(this).attr('id', 'tr_lk_' + no);
           // $('#jumlah_equipment', this).attr('name', 'jumlah');
           
            $('.id_rfqq', this).attr('name', 'id_rfq_equipment[]');
            $('#jumlah_equipment').val(no+1);
            $('#modal_barang_param', this).attr('onclick', 'modal_data_barang(' + no + ')');

            
            $('#id_equipmentt', this).attr('name', 'id_equipment[]');
            $('#id_equipmentt', this).attr('id', 'id_equipment_' + no);

            $('.br_id', this).attr('name', 'barang_id[]');
            $('.br_id', this).attr('id', 'br_id_' + no);
            
            $('.acc_', this).attr('name', 'acc_no[]');
             $('.acc_', this).attr('id', 'acc_' + no);

            // $('.detaild', this).attr('name', 'detail_desc[]');
            // $('#detaild', this).attr('id', 'detail_desc_' + no);

            $('.input_', this).attr('id', 'input_' + no);

            $('.specification', this).attr('name', 'specification[]');
            $('.datasheet', this).attr('name', 'datasheet[]');
            $('.certificate', this).attr('name', 'certificate[]');
            $('.testing', this).attr('name', 'testing[]');
            $('.inspection', this).attr('name', 'inspection[]');

            $('.month', this).attr('name', 'month[]');
            $('.month', this).attr('id', 'month_'+ no );
            $('.month', this).attr('value', today);

            $('.ms_sewa_', this).attr('id', 'ms_sewa_'+ no);
            
            $('.barang_nama', this).attr('name', 'barang_nama[]' );
            $('.barang_nama', this).attr('id', 'barang_nama_' + no);

            $('.quan', this).attr('name', 'quantity[]');
            $('.quan', this).attr('onkeyup', 'hitung_cost('+ no +')');
            $('#quantity_', this).attr('id', 'quantity_' + no);
            $('.qty_', this).attr('id', 'qty_'+ no);


            $('.unit', this).attr('name', 'unit[]' );
            $('#unit_', this).attr('id', 'unit_' + no);

            $('.part_number', this).attr('name', 'part_number[]');
            $('#part_number_', this).attr('id', 'part_number_' + no);

            $('.unit_cost', this).number(true, 2).val();
            $('.unit_cost', this).attr('name', 'unit_cost[]' );
            $('.unit_cost', this).attr('onkeyup', 'hitung_cost('+ no +')');
            $('#unit_cost_', this).attr('id', 'unit_cost_' + no);

            $('.total_cost', this).attr('name', 'total_cost[]');
            $('#total_cost_', this).attr('id', 'total_cost_' + no);

            $('.no_rak_', this).attr('name', 'no_rak[]');
            $('#no_rak_', this).attr('id', 'no_rak_' + no);

            $('.lokas', this).attr('name', 'lokasi[]');
            $('#lokas', this).attr('id', 'lokas_' + no);

            $('.detail_d', this).attr('name', 'detail_desc[]');
            $('#detail_d', this).attr('id', 'detail_desc_' + no);

            $('.sz', this).attr('name', 'size[]');
            $('#sz_', this).attr('id', 'sz_' + no);

            $('#tgll', this).attr('id', 'tgll_' + no);


            $('#speci_', this).attr('id', 'speci_' + no);
            $('.no_lk', this).html(parseInt(no));
            $('.btn_lk', this).attr('onclick', 'remove_equipment_form(' + no + ')');
        });

    }

     function remove_e_form() {
        var no = 0;
        $.each($('#lk_list tr.lk_tr'), function () {
            no++;
             $('#jumlah_equipment').val(no+1);
         });

    }

     function remove_equipment_form(id, id_item) {


                     $('#tr_lk_' + id).remove();
                     remove_e_form();  
                     formBasic.append('<input type="hidden" name="remove_item[]" value="'+id_item+'">');
                    if ($('#lk_list tr.lk_tr').length === 0) {
                        add_equipment_form();
                         g_total();
                    }
       
    }

    function render_biaya_form() {
        var no = 0;
        $.each($('#lk_list_user tr.lk_tr_user'), function () {
            no++;
            var today = new Date();
	          var dd = today.getDate();
	          var mm = today.getMonth()+1; //January is 0!

	          var yyyy = today.getFullYear();
	          if(dd<10){
	              dd='0'+dd;
	          } 
	          if(mm<10){
	              mm='0'+mm;
	          } 
	          var today = dd+'-'+mm+'-'+yyyy;
            $(this).attr('id', 'tr_lk_user_' + no);
            $('#user_id', this).attr('id', 'user_id_' + no);
            $('#user_nama', this).attr('id', 'user_nama_' + no);
            $('.usid', this).attr('name', 'user_id[]' );
            $('.usnm', this).attr('name', 'user_name[]');
            $('#btn_modal', this).attr('onclick', 'modal_user(' + no + ')');

           	$('.tgl_kebutuhan_', this).attr('name', 'tgl_kebutuhan[]');
            $('.tgl_kebutuhan_', this).attr('id', 'tgl_kebutuhan_'+ no );

            $('.urut_', this).attr('name', 'no_urut[]');
            $('.urut_', this).attr('id', 'urut_'+ no );
            $('.urut_', this).val(no);

            $('.jam_', this).attr('name', 'jam[]');
            $('.jam_', this).attr('id', 'jam_'+ no );

            $('.type_approve_', this).attr('name', 'type[]');
            $('.type_approve_', this).attr('id', 'typ_'+ no );

            $('.no_lk_user', this).html(parseInt(no));
            $('.btn_lk_user', this).attr('onclick', 'remove_biaya_form(' + no + ')');
        });

    }

    function add_biaya_form() {
        var temp_biaya_form = $('#lk_temp_user').html();
        $('#lk_list_user').append(temp_biaya_form);
        render_biaya_form();
    }

    function remove_biaya_form(id,id_approve) {
        bootbox.setBtnClasses({
            CANCEL: 'red',
            CONFIRM: 'blue'
        });

        bootbox.confirm("Anda yakin akan menghapus user ini?", "Tidak", "Ya", function (e) {
            if (e) {
                $('#tr_lk_user_' + id).remove();
                formBasic.append('<input type="hidden" name="remove_approve[]" value="'+id_approve+'">');
                if ($('#lk_list_user tr.lk_tr_user').length === 0) {
                    add_biaya_form();
                }
            }
        });
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


  var globalFormUser = {

      getField : function(index, param) {
          _this = index;
          
          var id     = _this.find('.id').data('id');
          var nama   = _this.find('.nama').data('id');

         
          
          $('#user_id_'+param, formBasic).val(id);
          $('#user_nama_'+param, formBasic).val(nama);
      }
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

     function modal_user(param){

      $("#modal-data-user").modal("show");
      $('#param_tbl').val(param);
    
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

	function hitung_cost(id) {
      //$('#quantity_'+id).number(true);
      //$('#unit_cost_'+id).number(true, 2).val();
      // $('input.number_new', tableListTermin).number(true, 2);
      // $('.number', this).number(true, 2).val(jumlah);
      var quan = $('#quantity_'+id).val();
      var unit_cost = $('#unit_cost_'+id).val();
      var result = parseFloat(quan) * parseFloat(unit_cost);

      var diskon = $('#diskon_nilai').val();
      var vat_persen = $('#vat_persen').val();
      var vat_nilai = $('#vat_persen').val();

      // alert(diskon)

     	if (!isNaN(result)) {
	         $('#total_cost_'+id).val(result).number(true, 2);
	          var no = 0;
	          var total = 0;
	            $.each($('#lk_list tr.lk_tr'), function () {
	                no++;
	               var jumlah = $('input.total_cost',this).val();
	               if(jumlah){
	                  total  += parseFloat(jumlah);
	                }

	            });


	        $('.sub_total_item').val(total).number(true, 2);
	        $('.net_total_item').val(total).number(true, 2);
	        $('.total_all_item').html(total).number(true, 2);

	        var gross = total - diskon ;
	        if (diskon == '' && vat_persen == '') {
	        	$('.gross_total_item').val(total).number(true, 2);
	        }else {
	        	
	        	$('.gross_total_item').val(gross).number(true, 2);
	        	$('.net_total_item').val(gross).number(true, 2);
	        	$('.total_all_item').html(gross).number(true, 2);
	        }



	        var vat_nilai = gross * (vat_persen/100);
	        var net = gross - vat_nilai ;

	         if (vat_persen == '' && diskon == '' ) {
	         	$('.net_total_item').val(gross).number(true, 2);
	        	$('.total_all_item').html(gross).number(true, 2);
			 }else{
			 	$('#vat_nilai').val(vat_nilai).number(true, 2);
			 	$('.net_total_item').val(vat_nilai).number(true, 2);
	        	$('.total_all_item').html(vat_nilai).number(true, 2);
			 }

			 if (diskon == '' && vat_persen == '') {
			 	$('.net_total_item').val(total).number(true, 2);
	        	$('.total_all_item').html(total).number(true, 2);
	        }else if(vat_nilai != ''){
	        	$('.net_total_item').val(net).number(true, 2);
	        	$('.total_all_item').html(net).number(true, 2);
	        }else{
	        	$('.net_total_item').val(vat_nilai).number(true, 2);
	        	$('.total_all_item').html(vat_nilai).number(true, 2);
	        }
	        
	      
	     

	        
	        
	     }
    }

    // function hitung_vat(){

    // }


    
</script>