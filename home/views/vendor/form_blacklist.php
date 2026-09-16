<html>
    <head>
        <script id="tinyhippos-injected">
            if (window.top.ripple) {
                window.top.ripple("bootstrap").inject(window, document);
            }
        </script>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
    </head>
    <body>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                <i class="fa fa-times"></i>
            </button>
            <h6 class="modal-title" id="myModalLabel">
                <span class="widget-icon"> <i class="fa fa-edit"></i> </span> <?php echo $page_title; ?>
            </h6>
        </div>
        <div class="modal-body">
            <?php
            $hidden_form = array('edit_id' => !empty($edit_id) ? $edit_id : '', 'm_m_id_menu' => !empty($m_m_id_menu) ? $m_m_id_menu : '');
            echo form_open_multipart($form_action, array('id' => 'finput', 'class' => 'form-horizontal'), $hidden_form);
            ?>
            <fieldset>
                <div class="form-group">
                    <label class="col-md-3 control-label">Nama Perusahaan</label>
                    <div class="col-md-6">
                        <?php echo form_input('nama_perusahaan', !empty($data_edit->nama_perusahaan) ? $data_edit->nama_perusahaan : '', 'class="form-control state-disabled "'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Alamat</label>
                    <div class="col-md-8">
                            <?php echo form_input('alamat', !empty($data_edit->alamat) ? $data_edit->alamat : '', 'class="form-control state-disabled"'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Nama Pimpinan</label>
                    <div class="col-md-8">
                            <?php echo form_input('nama_pimpinan', !empty($data_edit->nama_pimpinan) ? $data_edit->nama_pimpinan : '', 'class="form-control input state-disabled"'); ?>
                    </div>
                </div>
				
                <div class="form-group">
				<?php
				$options = array(
                  'ya'  => 'Ya',
                  'tidak'    => 'Tidak',
                );
				?>
                    <label class="col-md-3 control-label">Status Black List</label>
                    <div class="col-md-8">
                            <?php echo form_dropdown('status', $options, !empty($data_edit->status) ? $data_edit->status : '', 'class="select2"'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Sampai Tanggal</label>
                    <div class="col-md-8">
					 <div class='input-group date'>
						<?php echo form_input('tgl_blacklist',!empty($data_edit->tgl_blacklist) ? $data_edit->tgl_blacklist : '', 'class="form-control date"') ?>
						<span class="input-group-addon"><span class="fa fa-calendar"></span></span>                    
					</div>					
                    </div>
                </div>
			
		<!--
                <div class="form-group">
                    <label class="col-md-3 control-label">Alasan</label>
                    <div class="col-md-8">
                            <?php echo form_textarea('alasan',!empty($data_edit->alasan) ? $data_edit->alasan : '', 'class="form-control" rows="3"'); ?>
                    </div>
                </div>
		//-->
		

                    <h3>
			Alasan
			<?php
					$jsonDecode = explode("&", $data_edit->alasan);
					$nodata = 1;
					$inputdata = '';
					foreach($jsonDecode as $index => $dt):
					if ($dt != ''){
						if ($nodata == 1){
							$inputdata = $dt;
							$nodata = 2;
						}else{
							$inputdata = $inputdata.'&'.$dt;
						}
					}; 
					endforeach;
			?>
			<input type="hidden" name="alasan" value="<?php echo !empty($inputdata) ? $inputdata : '';?>" >
			<input type="hidden" name="id_blacklist" value="<?php echo $id_blacklist;?>" >
		</h3>
                    <div class="form-group">
                        <div class="col-md-12">
                     <div class="panel panel-default">
                        <div class="panel-heading">
                          <button class="btn btn-default" type="button" data-toggle="modal" data-target="#modal-form-barang" id="btn-tambah-barang">
                            <i class="fa fa-plus"></i> Tambah Alasan</button>
                        </div>
                        <div class="panel-body">
                          <table class="table table-bordered" id="table-barang">
                            <thead>
                              <tr>
                                <th>No</th>
                                <th class="text-center">Alasan</th>
                                <th></th>
                              </tr>
                            </thead>
                            <tbody class="data-row">
			<?php
				if(!empty($data_edit->alasan)):
					$jsonDecode = explode("&", $data_edit->alasan);
					$no = 1;
					foreach($jsonDecode as $index => $dt):
					if ($dt != ''){
			?>
                            <tr class="row-clone" data-id="<?php echo $dt;?>" >
			<td class="no"><?php echo $noTEST = $no++ ?></td>
			    <?php foreach ($blacklistdata as $dtM){ ?>
				<?php if ($dtM->id == $dt){ ?>
					<td> <span class="desc"><?php echo $dtM->deskripsi; ?></span></td>
				<?php } ?>
			    <?php }; ?>
			<td> 
			<a class="btn btn-danger btn-xs remove-row" onclick="my_table_barang.remove('#table-barang',this.id)"><i class="fa fa-remove"></i></a>
			</td>
                            </tr>
			    
                          <?php }; endforeach; endif; ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <?php echo form_input('', NULL, 'style="display:none" id="txt-barang" data-rule-required="true"') ?>
                      <span class="help-block error" style="color:#b94a48"></span>
                        </div>
                    </div>

                    


















            </fieldset>
            <?php echo form_close(); ?>
        </div>
        <div class="modal-footer">
            <?php
            echo anchor(NULL, '<span class="btn-label"><i class="glyphicon glyphicon-chevron-left"></i></span> Back', array(
                'id' => 'mybutton-add',
                'class' => 'btn btn-labeled btn-default margin-right-2',
                'data-dismiss' => 'modal'
            ));
            echo anchor(NULL, '<span class="btn-label"><i class="glyphicon glyphicon-floppy-disk"></i></span> Save', array(
                'id' => 'mybutton-add',
                'class' => 'btn btn-labeled btn-success',
                'onclick' => 'my_form.submit(\'#finput\')'
            ));
            ?>
        </div>

<!-- Dynamic Modal -->  
<div class="modal" id="modal-form-barang" data-backdrop="static" role="dialog" aria-hidden="true">
      <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                <i class="fa fa-times"></i>
            </button>
            <h4 class="modal-title">
                PILIH BARANG
            </h4>
        </div>
        <div class="modal-body">
            <form class="form-horizontal" id="fbarang">
	    <?php foreach ($blacklistdata as $dtM){ ?>
                <div class="form-group" id="getcheked_<?php echo $dtM->id; ?>" >
		<label class="col-md-2 control-label"><?php echo form_checkbox('checkbox', $dtM->id, FALSE);?></label>
                  <div class="col-md-10" id="isidiv_<?php echo $dtM->id; ?>" >
			<?php echo $dtM->deskripsi; ?>
                  </div>
                </div>
		<?php }; ?>
            </form>
        </div>
        <div class="modal-footer">
           <button class="btn btn-primary" id="btn-submit-barang">Tambah</button>
        </div>
    </div>
<!-- /.modal -->

<!-- Clone Table -->  
<table>
    <tbody data-table="#table-barang" style="display: none;">
        <tr class="row-clone">
            <td class="no"></td>
            <td> <span class="desc"></span></td>
            <td> <a class="btn btn-danger btn-xs remove-row" onclick="my_table_barang.remove('#table-barang', this.id)"><i class="fa fa-remove"></i></a></td>
        </tr>
    </tbody>
</table>
        <script type="text/javascript">
            pageSetUp();
            my_form.init();

            var load_and_reset_form = function () {
                pagefunction();
                my_form.reset('#finput');
            };

            var __after_process = function(ket) {
        
                if(ket == 1)
                    my_form.reset('#finput');

                    $('#remoteModal').modal('hide');
                    $('#remoteModalBar').modal('hide');
                    my_data_table.reload('#dt_basic');
            };

            $('.number').number(true);
			$('.date').datetimepicker({pickTime: false, format: 'YYYY-MM-DD'});

           
        $('#modal-form-barang').modal('hide');

  var my_table_barang = {
    append : function(table) {
      var $init  = $(table);
      var $clone = $('[data-table="'+table+'"]').children('.row-clone').clone();
      var $spec  = $('[data-table="'+table+'"]').children('.row-spec').clone();
      $('.data-row',$init).append($clone);
      $('.data-row',$init).append($spec);

      my_table_barang.render_row(table); 
    },

    remove : function(table,index) {
      var $init  = $(table);
      var id    = $('#' + index, $init).closest('.row-clone').data('id');
      
		$('#' + index, $init).closest('.row-clone').remove();
		var splitdata = $("input[name='alasan']").val().split("&");
		var inputsplitdata = '';
		
		for(i = 0; i < splitdata.length; i++){
			//alert(splitdata[i]);
		    if (splitdata[i] != id){
			inputsplitdata = inputsplitdata + splitdata[i] + '&';
		    }
		};
		
		if (inputsplitdata == '&'){
			$("input[name='alasan']").val('');
		}else{
			$("input[name='alasan']").val(inputsplitdata);
		}
		
		/*
      if(id)
          $('#finput').append('<input type="hidden" name="remove_detail[]" value="'+id+'"/> ');
	  */
      my_table_barang.render_row(table); 
    },

    render_row : function(table) {
      var $init = $(table);
      var no = 0;
      var grandtotal = 0;
      $.each($('.data-row',$init).children('.row-clone'), function() {
         no++;
         $(this).attr('data-id',no);
         $('.no', this).html(no);
         $('.remove-row', this).attr('data-row', no);
         $('.remove-row', this).attr('id', 'remove-row-' + no);

         $('.show-barang-spec',this).attr('data-target', '#data-spec-'+ no);
         $(this).next().find('.data-barang-spec').attr('id','data-spec-'+no);
         $(this).next().find('table > tbody').attr('id','data-spec-'+no);

         $total = $(this).find('input.total').val();
         grandtotal += parseInt($total);
      });
        $('#grandtotal').val(grandtotal);

        var $row_count = $('.data-row', $init).children('.row-clone').length;
        if($row_count) {
          $('#txt-barang').val('true');
        } else {
          $('#txt-barang').val('');
        }
    },
  };
		//my_table_barang.append('#table-barang');
		my_table_barang.render_row('#table-barang');

	$('#btn-tambah-barang').click(function(event) {
		var splitdata = $("input[name='alasan']").val().split("&");
		for(i = 0; i < splitdata.length; i++){
		    var getchekeddata = '#getcheked_'+splitdata[i];
			//$(getchekeddata+" input[type='checkbox']").attr("checked", true);
			$(getchekeddata).css("display", 'none');
		};
	});
	
	$('#btn-submit-barang').click(function(event) {
		var forinput = $('#fbarang').serialize().split('checkbox=').join('');
		var serializeChecked    = $('#fbarang').serializeArray();
		var adddatainpu = $("input[name='alasan']").val();
		_clone = $('[data-table="#table-barang"]');
		$.each(serializeChecked, function(key,value) {
			var idnew = value.value;
			var getidisidiv = '#isidiv_'+idnew ;
			var textdiv = $(getidisidiv).text();
			$('.desc',_clone).html(textdiv); 
			$('.desc',_clone).val(textdiv);
			my_table_barang.append('#table-barang');
		}); 
		if ($("input[name='alasan']").val() == ''){
		
			$("input[name='alasan']").val(forinput);
		}else{
			$("input[name='alasan']").val(adddatainpu+'&'+forinput);
		
		}
		$('#modal-form-barang').modal('hide');
		my_form.reset('#fbarang');
	});
        </script>
    </body>
</html>