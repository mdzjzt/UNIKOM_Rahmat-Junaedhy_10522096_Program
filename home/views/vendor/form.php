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
				<span class="caption-subject bold uppercase">KETERANGAN DOKUMEN</span>
				<span class="caption-helper"></span>
			</div>
		</div>

		<div class="portlet-body">
		
			<div class="wizard" data-initialize="wizard" id="myWizard">

				<ul class="steps" id="steps">
					<li data-step="1" class="active"><span class="badge badge-info">1</span>Step 1<span class="chevron"></span></li>
					<li data-step="2"><span class="badge">2</span>Step 2<span class="chevron"></span></li>
					<!-- <li data-step="3"><span class="badge">3</span>Step 3<span class="chevron"></span></li> -->
				</ul>

				<div class="actions">
				<button type="button" class="btn btn-sm btn-primary btn-prev"><span class="glyphicon glyphicon-arrow-left"></span>Prev</button>
				<button type="button" class="btn btn-sm btn-success btn-next" data-last="Complete">Next<span class="glyphicon glyphicon-arrow-right"></span></button>
				</div>

				<?php
					$hidden_form = array('edit_id' => !empty($edit_id) ? $edit_id : '');
					echo form_open_multipart($form_action, array('id' => 'finput', 'class' => 'form-horizontal'), $hidden_form);
				?>

				<div class="step-content">
				
					<div class="step-pane active" data-step="1">
						<legend><b>Profile</b></legend>
						<fieldset>
						<table class="table table-bordered table-striped">
							<tr>
								<td class="col-md-2"><strong>Jenis Vendor</strong></td>
								<td>
									
									<div class="col-md-4">

									<!-- 	<label class="radio-inline">
											<input type="radio" name="jenis" value="PT" 
													<?php //if(!empty($jenis)): ?> 
														<?php //if($jenis == 'PT'): ?>
														checked 
														<?php //endif; ?>
													<?php //else : ?>
														checked
													<?php //endif; ?>
											>PT
										</label>
										<label class="radio-inline">
											<input type="radio" name="jenis" value="CV" <?php //if(!empty($jenis) && $jenis == 'CV'): ?> checked <?php// endif; ?>>CV
										</label>
										<label class="radio-inline">
											<input type="radio" name="jenis" value="Firma" <?php// if(!empty($jenis) && $jenis == 'Firma'): ?> checked <?php// endif; ?>>Firma
										</label> -->
							<?php echo form_input('jenis', !empty($jenis) ? $jenis : NULL, 'class="form-control" placeholder="PT" onkeyup="this.value = this.value.toUpperCase()"') ?>
									</div>
									<div class="col-md-3">
										 <select class="form-control" name="jenis_perusahaan" id="jenis_perusahaan">
					                      <option value="1">Perusahaan</option>
					                      <option value="2">Perorangan</option>
					                    </select> 
									</div>
									
								</td>
							</tr>
							
							<tr>
								<td>
									<strong>Perusahaan <sup>*</sup></strong>
									<div class="note">Nama Perusahaan </div>
								</td>
								<td>
									<div class="form-group">
									<div class="col-md-6">

									<?php 
										if ($edit_id) {
											echo form_input('nama_perusahaan', !empty($data_edit->nama_perusahaan) ? $data_edit->nama_perusahaan : NULL, 'class="form-control" data-rule-required="true" readonly placeholder="Nama Perusahaan" id="nama_perusahaan" onkeyup="this.value = this.value.toUpperCase()"') ;
										}else{
											echo form_input('nama_perusahaan', !empty($data_edit->nama_perusahaan) ? $data_edit->nama_perusahaan : NULL, 'class="form-control" data-rule-required="true" placeholder="Nama Perusahaan" id="nama_perusahaan" onkeyup="this.value = this.value.toUpperCase()"') ;
										}
									?>
									
									</div>
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<strong>Sub Category<sup>*</sup></strong>
									
								</td>
								<td>
									<div class="form-group">
									<div class="col-md-6">
										<?php echo form_input('sub_category', !empty($data_edit->sub_category) ? $data_edit->sub_category : NULL, 'class="form-control" id="sub_category"data-rule-required="true"  placeholder="Sablon / Screen printing, Sticker logo, Business card" ') ?>
									
									</div>
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<strong>Pimpinan </strong>
									<div class="note">Nama Direktur Utama </div>
								</td>
								<td>
									<div class="form-group">
									<div class="col-md-6">
									<?php echo form_input('nama_pimpinan', !empty($data_edit->nama_pimpinan) ? $data_edit->nama_pimpinan : NULL, 'class="form-control" data-rule-required="true"') ?>
									
									</div>
									</div>
								</td>
							</tr>
							
						
							<tr>
								<td>
									<strong>Komisaris</strong>
								</td>
								<td>
									<div class="form-group">
									<div class="col-md-6">
									<?php echo form_input('komisaris', !empty($data_edit->komisaris) ? $data_edit->komisaris : NULL, 'class="form-control" data-rule-required="true"') ?>
									</div>
									</div>
								</td>
							</tr>
							
							
							<tr>
							    <td class="col-md-2"><strong>Alamat </strong></td>
							    <td>
								<div class="form-group">
								    <div class="col-md-6">
									<textarea name="alamat" class="form-control" rows="3"><?php echo!empty($data_edit->alamat) ? $data_edit->alamat : '' ?></textarea>
									
								    </div>
								</div>
							    </td>
							</tr>

							<tr>
							    <td class="col-md-2"><strong>Provinsi </strong></td>
							    <td>
								<div class="form-group">
								    <div class="col-md-6">
									<?php echo form_dropdown('provinsi_id', $provinsi, !empty($data_edit->propinsi) ? $data_edit->propinsi : '', 'class="form-control select2" id="provinsi_id" target-options="kotamadya_id" data-rule-required="true"'); ?>
								    </div>
								</div>
							    </td>
							</tr>

							<tr>
							    <td class="col-md-2"><strong>Kab./Kota</strong></td>
							    <td>
								<div class="form-group">
								    <div class="col-md-6">
									<?php echo form_dropdown('kotamadya_id', $kotamadya, !empty($data_edit->kota_id) ? $data_edit->kota_id : '', 'class="form-control select2"  id="kotamadya_id" data-source="' . base_url('master/kecamatan') . '/load_regency_all" data-rule-required="true"'); ?>
								    </div>
								</div>
							    </td>
							</tr>
							<tr>
								<td class="col-md-2">
									<strong>Main Email </strong>
								</td>
								<td>
									<div class="form-group">
									<div class="col-md-6">
									<?php echo form_input('email', !empty($data_edit->email) ? $data_edit->email : NULL, 'class="form-control" data-rule-required="true"') ?>
									
									</div>
									</div>
								</td>
							</tr>
							<tr>
								<td class="col-md-2">
									<strong>second Email </strong>
								</td>
								<td>
									<div class="form-group">
									<div class="col-md-6">
									<?php echo form_input('email_second', !empty($data_edit->second_email) ? $data_edit->second_email : NULL, 'class="form-control"') ?>
									
									</div>
									</div>
								</td>
							</tr>
							<tr>
								<td class="col-md-2">
									
									<strong>Contact Person <sup>*</sup></strong>
								</td>
								<td>
									<div class="form-group">
									<div class="col-md-6">
									<?php echo form_input('contact_person', !empty($data_edit->contact_person) ? $data_edit->contact_person : NULL, 'class="form-control" id="contact_person" onkeyup="this.value = this.value.toUpperCase()" data-rule-required="true"') ?>
									
									</div>
									</div>
								</td>
							</tr>
							<tr>
								<td class="col-md-2">
									
									<strong>NIK KTP <sup>*</sup></strong>
								</td>
								<td>
									<div class="form-group">
									<div class="col-md-6">
									<?php echo form_input('nik_vendor', !empty($data_edit->nik_vendor) ? $data_edit->nik_vendor : NULL, 'class="form-control numeric" minlength="16" id="nik_vendor"  data-rule-required="true"') ?>
									 <label class="errornik" style="color: red"></label>
									</div>
									</div>
								</td>
							</tr>
							<tr>
								<td class="col-md-2">
									
									<strong>Telp </strong>
								</td>
								<td>
									<div class="form-group">
									<div class="col-md-6">
									<?php echo form_input('telp', !empty($data_edit->no_telpon) ? $data_edit->no_telpon : NULL, 'class="form-control" data-rule-required="true"') ?>
									
									</div>
									</div>
								</td>
							</tr>
							<tr>
								<td class="col-md-2">
									<strong>HP</strong>
								</td>
								<td>
									<div class="form-group">
									<div class="col-md-6">
									<?php echo form_input('hp', !empty($data_edit->hp) ? $data_edit->hp : NULL, 'class="form-control" data-rule-required="true"') ?>
									
									</div>
									</div>
								</td>
							</tr>
							<tr>
								<td class="col-md-2"><strong>FAX</strong> 
								</td>
								<td>
									<div class="form-group">
									<div class="col-md-6">
									<?php echo form_input('fax', !empty($data_edit->fax) ? $data_edit->fax : NULL, 'class="form-control" data-rule-required="true"') ?>
									
									</div>
									</div>
								</td>
							</tr>
							
							<tr>
								<td class="col-md-2"><strong>NPWP</strong><sup>*</sup></td>
								<td>
									<div class="form-group">
									<div class="col-md-3">
									<?php echo form_input('npwp', !empty($data_edit->npwp) ? $data_edit->npwp : NULL, 'class="form-control numeric" id="npwp" data-rule-required="true"') ?>
									 <label class="errornpwp" style="color: red"></label>
									</div>
									</div>
								</td>
							</tr>
							
							<tr>
								<td class="col-md-2">
									<strong>No. Rek</strong> (Rek Aktif)
								</td>
								<td>
									<div class="form-group">
									<div class="col-md-3">
									<?php echo form_input('norek', !empty($data_edit->norek) ? $data_edit->norek : NULL, 'class="form-control" data-rule-required="true"') ?>
									
									</div>
									</div>
								</td>
							</tr>
							<tr>
								<td class="col-md-2">
									<strong>Nama. Rekening</strong>
								</td>
								<td>
									<div class="form-group">
										<div class="col-md-3">
											<?php echo form_input('nama_rek', !empty($data_edit->nama_rek) ? $data_edit->nama_rek : NULL, 'class="form-control"') ?>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td class="col-md-2">
									<strong>Nama Bank</strong>
								</td>
								<td>
									<div class="form-group">
										<div class="col-md-3">
											<?php echo form_dropdown('bank_id', $bank, !empty($data_edit->bank_id) ? $data_edit->bank_id : null, 'class="form-control select2"'); ?>
										</div>
									</div>
								</td>
							</tr>

							<tr>
								<td class="col-md-2"><strong>Direksi</strong></td>
								<td>
									<div class="form-group">
									<div class="col-md-5">
										<table class="table table-bordered" id="table-dokumen2">
											<thead>
												<tr>
													<th colspan="4">
														Daftar Pejabat
														<button type="button" class="btn btn-xs btn-primary pull-right" onclick="my_table_dokumen2.append('#table-dokumen2')"><i class="fa fa-plus"></i></button>
													</th>
												</tr>
												<tr>
													<td class="no">#</td>
													<td>Nama</td>
													<td colspan="2">Jabatan</td>
												</tr>
											</thead>
											<tbody class="data-row">
											<?php if (!empty($decode_direksi)) {?>
												<?php foreach ($decode_direksi as $row_dir) {?>
												<?php $nama_direksi = $row_dir->nama_direksi; $jabatan_direksi = $row_dir->jabatan_direksi; ?>
													<tr class="row-clone">
														<td style="width:50px" class="no"></td>
														<td>
														<div class="form-group">
														<div class="col-md-12">
														<?php echo form_input('nama_direksi[]', !empty($nama_direksi) ? $nama_direksi : '', 'class="form-control dokumen-deskripsi"') ?>
														</div>
														</div>
														</td>
														<td>
														<div class="form-group">
														<div class="col-md-12">
														<?php echo form_input('jabatan_direksi[]', !empty($jabatan_direksi) ? $jabatan_direksi : '', 'class="form-control dokumen-deskripsi"') ?>
														</div>
														</div>
														</td>
														<td><a class="btn btn-danger btn-xs remove-row" onclick="my_table_dokumen2.remove('#table-dokumen2', this.id)"><i class="fa fa-remove"></i></a></td>
													</tr>
												<?php } ?>
											<?php } else { ?>
												<tr class="row-clone">
												<td style="width:50px" class="no"></td>
												<td>
												<div class="form-group">
												<div class="col-md-12">
												<?php echo form_input('nama_direksi[]', NULL, 'class="form-control dokumen-deskripsi"') ?>
												</div>
												</div>
												</td>
												<td>
												<div class="form-group">
												<div class="col-md-12">
												<?php echo form_input('jabatan_direksi[]', NULL, 'class="form-control dokumen-deskripsi"') ?>
												</div>
												</div>
												</td>
												<td><a class="btn btn-danger btn-xs remove-row" onclick="my_table_dokumen2.remove('#table-dokumen2', this.id)"><i class="fa fa-remove"></i></a></td>
												</tr>
											<?php } ?>
											</tbody>
										</table> 
									</div>
									</div>
								</td>
							</tr>

							<tr>
							    <td class="col-md-2"><strong>Pemilikan Saham</strong></td>
							    <td>
								<div class="form-group">
								    <div class="col-md-5">
									<table class="table table-bordered" id="table-dokumen3">
									    <thead>
										<tr>
										    <th colspan="4">
											Daftar Pemilik Saham
											<button type="button" class="btn btn-xs btn-primary pull-right" onclick="my_table_dokumen3.append('#table-dokumen3')"><i class="fa fa-plus"></i></button>
										    </th>
										</tr>
										<tr>
										    <td class="no">#</td>
										    <td>Nama</td>
										    <td colspan="2">Saham</td>
										</tr>
									    </thead>
									    <tbody class="data-row">
										<?php
										if (!empty($decode_saham)) {
										    //print_r($decode_saham);
										    foreach ($decode_saham as $row_saham) {
											$nama_saham = $row_saham->nama_saham;
											$jabatan_saham = $row_saham->persen_saham;
											?>
											<tr class="row-clone">
											    <td style="width:50px" class="no"></td>
											    <td>
												<div class="form-group">
												    <div class="col-md-12">
													<?php echo form_input('nama_saham[]', !empty($nama_saham) ? $nama_saham : '', 'class="form-control dokumen-deskripsi"') ?>
												    </div>
												</div>
											    </td>
											    <td>
												<div class="form-group">
												    <div class="col-md-12">
													<?php echo form_input('persen_saham[]', !empty($jabatan_saham) ? $jabatan_saham : '', 'class="form-control dokumen-deskripsi"') ?>
												    </div>
												</div>
											    </td>
											    <td><a class="btn btn-danger btn-xs remove-row" onclick="my_table_dokumen3.remove('#table-dokumen3', this.id)"><i class="fa fa-remove"></i></a></td>
											</tr>
										    <?php
										    }
										} else {
										    ?>
										    <tr class="row-clone">
											<td style="width:50px" class="no"></td>
											<td>
											    <div class="form-group">
												<div class="col-md-12">
													<?php echo form_input('nama_saham[]', NULL, 'class="form-control dokumen-deskripsi"') ?>
												</div>
											    </div>
											</td>
											<td>
											    <div class="form-group">
												<div class="col-md-12">
													<?php echo form_input('persen_saham[]', NULL, 'class="form-control dokumen-deskripsi"') ?>
												</div>
											    </div>
											</td>
											<td><a class="btn btn-danger btn-xs remove-row" onclick="my_table_dokumen3.remove('#table-dokumen3', this.id)"><i class="fa fa-remove"></i></a></td>
										    </tr>
										<?php } ?>
									    </tbody>
									</table>
								    </div>
								</div>
							    </td>
							</tr>
							
						</table>
						</fieldset>
					</div>
					
					<!-- <div class="step-pane" data-step="3">
						<legend><b>Penilaian</b></legend>
						<table class="table table-bordered table-striped">
							<tr>
								<td>
									<strong>Specification </strong>
								</td>
								<td>
									<div class="form-group">
										<div class="col-md-6">
											<?php echo form_input('specification', !empty($data_edit->specification) ? $data_edit->specification : NULL, 'class="form-control specification" onkeyup="penilaian()" data-rule-required="true"') ?>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<strong>On time delivery </strong>
								</td>
								<td>
									<div class="form-group">
										<div class="col-md-6">
											<?php echo form_input('on_time', !empty($data_edit->on_time) ? $data_edit->on_time : NULL, 'class="form-control on_time" onkeyup="penilaian()" data-rule-required="true"') ?>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<strong>Competitive Price </strong>
								</td>
								<td>
									<div class="form-group">
										<div class="col-md-6">
											<?php echo form_input('competitive_price', !empty($data_edit->competitive_price) ? $data_edit->competitive_price : NULL, 'class="form-control competitive_price" onkeyup="penilaian()" data-rule-required="true"') ?>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<strong>Term of payment </strong>
								</td>
								<td>
									<div class="form-group">
										<div class="col-md-6">
											<?php echo form_input('term_pay', !empty($data_edit->term_pay) ? $data_edit->term_pay : NULL, 'class="form-control term_pay" onkeyup="penilaian()" data-rule-required="true"') ?>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<strong>Communication</strong>
								</td>
								<td>
									<div class="form-group">
										<div class="col-md-6">
											<?php echo form_input('communication', !empty($data_edit->communication) ? $data_edit->communication : NULL, 'class="form-control communication" onkeyup="penilaian()" data-rule-required="true"') ?>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<strong>Documentation</strong>
								</td>
								<td>
									<div class="form-group">
										<div class="col-md-6">
											<?php echo form_input('documentation', !empty($data_edit->documentation) ? $data_edit->documentation : NULL, 'class="form-control documentation" onkeyup="penilaian()" data-rule-required="true"') ?>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<strong>SMK3L</strong>
								</td>
								<td>
									<div class="form-group">
										<div class="col-md-6">
											<?php echo form_input('smkl', !empty($data_edit->smkl) ? $data_edit->smkl : NULL, 'class="form-control smkl" onkeyup="penilaian()" data-rule-required="true"') ?>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<strong>Total Value</strong>
								</td>
								<td>
									<div class="form-group">
										<div class="col-md-6">
											<?php echo form_input('total', !empty($data_edit->smkl) ? $data_edit->smkl : NULL, 'class="form-control total" data-rule-required="true" readonly=""') ?>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<strong>Ranking</strong>
								</td>
								<td>
									<div class="form-group">
										<div class="col-md-6">
											<?php echo form_input('ranking', !empty($data_edit->ranking) ? $data_edit->ranking : NULL, 'class="form-control ranking" data-rule-required="true" readonly="" ') ?>
										</div>
									</div>
								</td>
							</tr>
						</table>
						<fieldset>

						</fieldset>
					</div> -->
					
					<div class="step-pane" data-step="2">
						<legend><b>Dokumen Legal</b></legend>
						<fieldset>
						<table class="table table-bordered table-striped">
							
							<!--
							<tr>
								<td>
									<strong>Akte Notaris </strong>
								</td>
								<td>
									<div class="form-group">
										<div class="col-md-3">
											<?php //echo form_input('akte', !empty($data_edit->akte) ? $data_edit->akte : '', 'class="form-control" data-rule-required="true"') ?>
											
										</div>
									</div>
								</td>
							</tr>
							//-->
							 <tr>
				                <td class="col-md-2">
				                                    <strong>Upload Dokumen QHSE</strong>
				                                    <div class="note">Kelengkapan Dokumen</div>
				                </td>                                
				                <td>

				                    <div class="form-group">
				                        <div class="col-md-10">
				                			<table class="table table-bordered" id="table-dokumen">
										        <thead>
										            <tr>
										                <th colspan="4">
										                         Daftar Dokumen
										                        <button type="button" class="btn btn-xs btn-primary pull-right" onclick="my_table_dokumen.append('#table-dokumen')"><i class="fa fa-plus"></i> Add Row</button>
										                        </th>
										                      </tr>
										                      <tr>
										                        <td class="no">#</td>
										                        <td width="45%">Deskripsi</td>
										                        <td colspan="2">File</td>
										                      </tr>
										                    </thead>
										                    <tbody class="data-row">
										                    <?php 
										                      if(!empty($data_edit->dokumen) && $data_edit->dokumen !== '[]'): 

										                        $no = 1;
										                        $dokumen = json_decode($data_edit->dokumen);
										                        foreach($dokumen as $dt):
										                    ?>

										                      <tr class="row-clone">
										                        <td style="width:50px" class="no"><?php echo $no++ ?></td>
										                        <td>
										                          <div class="form-group">
										                            <div class="col-md-12">
										                             <?php echo form_input('dokumen_deskripsi_qhse[]',$dt->deskripsi, 'class="form-control dokumen_deskripsi_qhse"') ?>
										                            </div>
										                          </div>
										                        </td>
										                        <td>
										                          <div class="form-group">
										                            
										                            <?php echo form_hidden('dokumen_path_qhse[]', $dt->file,'class="dokumen-path"') ?>
										                            <?php echo form_hidden('dokumen_name_qhse[]', $dt->filename,'class="dokumen-name"') ?>

										                            <div class="col-md-8">
										                               <div class="fileinput fileinput-new" data-provides="fileinput">
										                                  <span class="btn btn-default btn-file">
										                                    <span class="fileinput-new">Pilih File</span>
										                                    <span class="fileinput-exists">Change</span>
										                                    <?php echo form_upload('dokumen_file_qhse[]',NULL,'class="dokumen-file"') ?>
										                                  </span>
										                                  <span class="fileinput-filename"><?php echo $dt->filename ?></span>
										                                  
										                                  <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
										                                </div>
										                            </div>
										                          </div>
										                        </td>
										                        <td><a class="btn btn-danger btn-xs remove-row" onclick="my_table_dokumen.remove('#table-dokumen', this.id)"><i class="fa fa-remove"></i></a></td>
										                      </tr>
										                    <?php endforeach; else: ?>
										                      <tr class="row-clone">
										                        <td style="width:50px" class="no"></td>
										                        <td>
										                          <div class="form-group">
										                            <div class="col-md-12">
										                             <?php echo form_input('dokumen_deskripsi_qhse[]', NULL, 'class="form-control dokumen-deskripsi"') ?>
										                            </div>
										                          </div>
										                        </td>
										                        <td>
										                          <div class="form-group">
										                            <div class="col-md-8">
										                               <div class="fileinput fileinput-new" data-provides="fileinput">
										                                  <span class="btn btn-default btn-file">
										                                  <span class="fileinput-new">Pilih File</span>
										                                  <span class="fileinput-exists">Change</span>
										                                  <?php echo form_upload('dokumen_file_qhse[]',NULL,'class="dokumen-file"') ?>
										                                  </span>
										                                  <span class="fileinput-filename"></span>
										                                  <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
										                                </div>
										                            </div>
										                          </div>
										                        </td>
										                        <td><a class="btn btn-danger btn-xs remove-row" onclick="my_table_dokumen.remove('#table-dokumen', this.id)"><i class="fa fa-remove"></i></a></td>
										                      </tr>
										                    <?php endif; ?>
										                    </tbody>
										    </table>                                                                                            
				                        </div>
				                    </div>
				                </td>
				            </tr>

							<tr>
				                <td class="col-md-2">
				                                    <strong>Upload Dokumen FINANCE</strong>
				                                    <div class="note">Kelengkapan Dokumen</div>
				                </td>                                
				                <td>

				                    <div class="form-group">
				                        <div class="col-md-10">
				                			<table class="table table-bordered" id="table-dokumen-finance">
										        <thead>
										            <tr>
										                <th colspan="4">
										                         Daftar Dokumen
										                        <button type="button" class="btn btn-xs btn-primary pull-right" onclick="my_table_dokumen_finance.append('#table-dokumen-finance')"><i class="fa fa-plus"></i> Add Row</button>
										                        </th>
										                      </tr>
										                      <tr>
										                        <td class="no">#</td>
										                        <td width="45%">Deskripsi</td>
										                        <td colspan="2">File</td>
										                      </tr>
										                    </thead>
										                    <tbody class="data-row">
										                    <?php 
										                      if(!empty($data_edit->dokumen_finance) && $data_edit->dokumen_finance !== '[]'): 

										                        $no = 1;
										                        $dokumen = json_decode($data_edit->dokumen_finance);
										                        foreach($dokumen as $dt):
										                    ?>

										                      <tr class="row-clone">
										                        <td style="width:50px" class="no"><?php echo $no++ ?></td>
										                        <td>
										                          <div class="form-group">
										                            <div class="col-md-12">
										                             <?php echo form_input('dokumen_deskripsi_finance[]',$dt->deskripsi, 'class="form-control dokumen-deskripsi"') ?>
										                            </div>
										                          </div>
										                        </td>
										                        <td>
										                          <div class="form-group">
										                            
										                            <?php echo form_hidden('dokumen_path_finance[]', $dt->file,'class="dokumen-path"') ?>
										                            <?php echo form_hidden('dokumen_name_finance[]', $dt->filename,'class="dokumen-name"') ?>

										                            <div class="col-md-8">
										                               <div class="fileinput fileinput-new" data-provides="fileinput">
										                                  <span class="btn btn-default btn-file">
										                                    <span class="fileinput-new">Pilih File</span>
										                                    <span class="fileinput-exists">Change</span>
										                                    <?php echo form_upload('dokumen_file_finance[]',NULL,'class="dokumen-file"') ?>
										                                  </span>
										                                  <span class="fileinput-filename"><?php echo $dt->filename ?></span>
										                                  
										                                  <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
										                                </div>
										                            </div>
										                          </div>
										                        </td>
										                        <td><a class="btn btn-danger btn-xs remove-row" onclick="my_table_dokumen_finance.remove('#table-dokumen-finance', this.id)"><i class="fa fa-remove"></i></a></td>
										                      </tr>
										                    <?php endforeach; else: ?>
										                      <tr class="row-clone">
										                        <td style="width:50px" class="no"></td>
										                        <td>
										                          <div class="form-group">
										                            <div class="col-md-12">
										                             <?php echo form_input('dokumen_deskripsi_finance[]', NULL, 'class="form-control dokumen-deskripsi"') ?>
										                            </div>
										                          </div>
										                        </td>
										                        <td>
										                          <div class="form-group">
										                            <div class="col-md-8">
										                               <div class="fileinput fileinput-new" data-provides="fileinput">
										                                  <span class="btn btn-default btn-file">
										                                  <span class="fileinput-new">Pilih File</span>
										                                  <span class="fileinput-exists">Change</span>
										                                  <?php echo form_upload('dokumen_file_finance[]',NULL,'class="dokumen-file"') ?>
										                                  </span>
										                                  <span class="fileinput-filename"></span>
										                                  <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
										                                </div>
										                            </div>
										                          </div>
										                        </td>
										                        <td><a class="btn btn-danger btn-xs remove-row" onclick="my_table_dokumen_finance.remove('#table-dokumen-finance', this.id)"><i class="fa fa-remove"></i></a></td>
										                      </tr>
										                    <?php endif; ?>
										                    </tbody>
										    </table>                                                                                            
				                        </div>
				                    </div>
				                </td>
				            </tr>

				            <tr>
				                <td class="col-md-2">
				                                    <strong>Upload Dokumen LEGAL</strong>
				                                    <div class="note">Kelengkapan Dokumen</div>
				                </td>                                
				                <td>

				                    <div class="form-group">
				                        <div class="col-md-10">
				                			<table class="table table-bordered" id="table-dokumen-legal">
										        <thead>
										            <tr>
										                <th colspan="4">
										                         Daftar Dokumen
										                        <button type="button" class="btn btn-xs btn-primary pull-right" onclick="my_table_dokumen_legal.append('#table-dokumen-legal')"><i class="fa fa-plus"></i> Add Row</button>
										                        </th>
										                      </tr>
										                      <tr>
										                        <td class="no">#</td>
										                        <td width="45%">Deskripsi</td>
										                        <td colspan="2">File</td>
										                      </tr>
										                    </thead>
										                    <tbody class="data-row">
										                    <?php 
										                      if(!empty($data_edit->dokumen_legal) && $data_edit->dokumen_legal !== '[]'): 

										                        $no = 1;
										                        $dokumen = json_decode($data_edit->dokumen_legal);
										                        foreach($dokumen as $dt):
										                    ?>

										                      <tr class="row-clone">
										                        <td style="width:50px" class="no"><?php echo $no++ ?></td>
										                        <td>
										                          <div class="form-group">
										                            <div class="col-md-12">
										                             <?php echo form_input('dokumen_deskripsi_legal[]',$dt->deskripsi, 'class="form-control dokumen-deskripsi"') ?>
										                            </div>
										                          </div>
										                        </td>
										                        <td>
										                          <div class="form-group">
										                            
										                            <?php echo form_hidden('dokumen_path_legal[]', $dt->file,'class="dokumen-path"') ?>
										                            <?php echo form_hidden('dokumen_name_legal[]', $dt->filename,'class="dokumen-name"') ?>

										                            <div class="col-md-8">
										                               <div class="fileinput fileinput-new" data-provides="fileinput">
										                                  <span class="btn btn-default btn-file">
										                                    <span class="fileinput-new">Pilih File</span>
										                                    <span class="fileinput-exists">Change</span>
										                                    <?php echo form_upload('dokumen_file_legal[]',NULL,'class="dokumen-file"') ?>
										                                  </span>
										                                  <span class="fileinput-filename"><?php echo $dt->filename ?></span>
										                                  
										                                  <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
										                                </div>
										                            </div>
										                          </div>
										                        </td>
										                        <td><a class="btn btn-danger btn-xs remove-row" onclick="my_table_dokumen_legal.remove('#table-dokumen-legal', this.id)"><i class="fa fa-remove"></i></a></td>
										                      </tr>
										                    <?php endforeach; else: ?>
										                      <tr class="row-clone">
										                        <td style="width:50px" class="no"></td>
										                        <td>
										                          <div class="form-group">
										                            <div class="col-md-12">
										                             <?php echo form_input('dokumen_deskripsi_legal[]', NULL, 'class="form-control dokumen-deskripsi"') ?>
										                            </div>
										                          </div>
										                        </td>
										                        <td>
										                          <div class="form-group">
										                            <div class="col-md-8">
										                               <div class="fileinput fileinput-new" data-provides="fileinput">
										                                  <span class="btn btn-default btn-file">
										                                  <span class="fileinput-new">Pilih File</span>
										                                  <span class="fileinput-exists">Change</span>
										                                  <?php echo form_upload('dokumen_file_legal[]',NULL,'class="dokumen-file"') ?>
										                                  </span>
										                                  <span class="fileinput-filename"></span>
										                                  <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
										                                </div>
										                            </div>
										                          </div>
										                        </td>
										                        <td><a class="btn btn-danger btn-xs remove-row" onclick="my_table_dokumen_legal.remove('#table-dokumen-legal', this.id)"><i class="fa fa-remove"></i></a></td>
										                      </tr>
										                    <?php endif; ?>
										                    </tbody>
										    </table>                                                                                            
				                        </div>
				                    </div>
				                </td>
				            </tr>

				            <tr>
				                <td class="col-md-2">
				                                    <strong>Upload Dokumen OTHERS</strong>
				                                    <div class="note">Kelengkapan Dokumen</div>
				                </td>                                
				                <td>

				                    <div class="form-group">
				                        <div class="col-md-10">
				                			<table class="table table-bordered" id="table-dokumen-others">
										        <thead>
										            <tr>
										                <th colspan="4">
										                         Daftar Dokumen
										                        <button type="button" class="btn btn-xs btn-primary pull-right" onclick="my_table_dokumen_others.append('#table-dokumen-others')"><i class="fa fa-plus"></i> Add Row</button>
										                        </th>
										                      </tr>
										                      <tr>
										                        <td class="no">#</td>
										                        <td width="45%">Deskripsi</td>
										                        <td colspan="2">File</td>
										                      </tr>
										                    </thead>
										                    <tbody class="data-row">
										                    <?php 
										                      if(!empty($data_edit->dokumen_others) && $data_edit->dokumen_others !== '[]'): 

										                        $no = 1;
										                        $dokumen = json_decode($data_edit->dokumen_others);
										                        foreach($dokumen as $dt):
										                    ?>

										                      <tr class="row-clone">
										                        <td style="width:50px" class="no"><?php echo $no++ ?></td>
										                        <td>
										                          <div class="form-group">
										                            <div class="col-md-12">
										                             <?php echo form_input('dokumen_deskripsi_others[]',$dt->deskripsi, 'class="form-control dokumen-deskripsi"') ?>
										                            </div>
										                          </div>
										                        </td>
										                        <td>
										                          <div class="form-group">
										                            
										                            <?php echo form_hidden('dokumen_path_others[]', $dt->file,'class="dokumen-path"') ?>
										                            <?php echo form_hidden('dokumen_name_others[]', $dt->filename,'class="dokumen-name"') ?>

										                            <div class="col-md-8">
										                               <div class="fileinput fileinput-new" data-provides="fileinput">
										                                  <span class="btn btn-default btn-file">
										                                    <span class="fileinput-new">Pilih File</span>
										                                    <span class="fileinput-exists">Change</span>
										                                    <?php echo form_upload('dokumen_file_others[]',NULL,'class="dokumen-file"') ?>
										                                  </span>
										                                  <span class="fileinput-filename"><?php echo $dt->filename ?></span>
										                                  
										                                  <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
										                                </div>
										                            </div>
										                          </div>
										                        </td>
										                        <td><a class="btn btn-danger btn-xs remove-row" onclick="my_table_dokumen_others.remove('#table-dokumen-others', this.id)"><i class="fa fa-remove"></i></a></td>
										                      </tr>
										                    <?php endforeach; else: ?>
										                      <tr class="row-clone">
										                        <td style="width:50px" class="no"></td>
										                        <td>
										                          <div class="form-group">
										                            <div class="col-md-12">
										                             <?php echo form_input('dokumen_deskripsi_others[]', NULL, 'class="form-control dokumen-deskripsi"') ?>
										                            </div>
										                          </div>
										                        </td>
										                        <td>
										                          <div class="form-group">
										                            <div class="col-md-8">
										                               <div class="fileinput fileinput-new" data-provides="fileinput">
										                                  <span class="btn btn-default btn-file">
										                                  <span class="fileinput-new">Pilih File</span>
										                                  <span class="fileinput-exists">Change</span>
										                                  <?php echo form_upload('dokumen_file_others[]',NULL,'class="dokumen-file"') ?>
										                                  </span>
										                                  <span class="fileinput-filename"></span>
										                                  <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
										                                </div>
										                            </div>
										                          </div>
										                        </td>
										                        <td><a class="btn btn-danger btn-xs remove-row" onclick="my_table_dokumen_others.remove('#table-dokumen-others', this.id)"><i class="fa fa-remove"></i></a></td>
										                      </tr>
										                    <?php endif; ?>
										                    </tbody>
										    </table>                                                                                            
				                        </div>
				                    </div>
				                </td>
				            </tr>

							<tr>
								<td colspan="2">
								<div class="alert alert-success fade in">
								<strong>Akte Notaris</strong>
								</div>
								</td>
								
							</tr> 
							<tr>
								<td class="col-md-2">
									<strong>Dokumen Akte Notaris</strong>
									<div class="note"></div>
								</td>
								<td>
								<table class="table table-bordered" id="table-dokumen-akte-notaris">
									<thead>
										<tr>
											<td class="no">#</td>
											<td width="45%">Deskripsi</td>
											<td colspan="2">File</td>
										</tr>
									</thead>
									<tbody class="data-row">
										<?php 
											if(!empty($data_edit->dok_akte_notaris) && $data_edit->dok_akte_notaris !== '[]'): 
											$no = 1;
											$dokumen_akte_notaris = json_decode($data_edit->dok_akte_notaris);
											foreach($dokumen_akte_notaris as $dt_akte_notaris):
										?>

											<tr class="row-clone">
											<td style="width:50px" class="no"><?php echo $no++ ?></td>
											<td>
											<div class="form-group">
											<div class="col-md-12">
											<?php echo form_input('dokumen_deskripsi_akte_notaris[]',$dt_akte_notaris->deskripsi, 'class="form-control dokumen-deskripsi"') ?>
											</div>
											</div>
											</td>
											<td>
											<div class="form-group">
											<?php echo form_hidden('dokumen_path_akte_notaris[]', $dt_akte_notaris->file,'class="dokumen-path"') ?>
											<?php echo form_hidden('dokumen_name_akte_notaris[]', $dt_akte_notaris->filename,'class="dokumen-name"') ?>
											<div class="col-md-8">
											<div class="fileinput fileinput-new" data-provides="fileinput">
											<span class="btn btn-default btn-file">
											<span class="fileinput-new">Pilih File</span>
											<span class="fileinput-exists">Change</span>
											<?php echo form_upload('dokumen_file_akte_notaris[]',NULL,'class="dokumen-file"') ?>
											</span>
											<span class="fileinput-filename"><?php echo $dt_akte_notaris->filename ?></span>
											<a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
											</div>
											</div>
											</div>
											</td>
											</tr>
											<?php endforeach; else: ?>
											<tr class="row-clone">
											<td style="width:50px" class="no"></td>
											<td>
											<div class="form-group">
											<div class="col-md-12">
											<?php echo form_input('dokumen_deskripsi_akte_notaris[]', NULL, 'class="form-control dokumen-deskripsi"') ?>
											</div>
											</div>
											</td>
											<td>
											<div class="form-group">
											<div class="col-md-8">
											<div class="fileinput fileinput-new" data-provides="fileinput">
											<span class="btn btn-default btn-file">
											<span class="fileinput-new">Pilih File</span>
											<span class="fileinput-exists">Change</span>
											<?php echo form_upload('dokumen_file_akte_notaris[]',NULL,'class="dokumen-file"') ?>
											</span>
											<span class="fileinput-filename"></span>
											<a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
											</div>
											</div>
											</div>
											</td>
											</tr>
										<?php endif; ?>
									</tbody>
								</table>
								</td>
							</tr>

							<tr>
								<td class="col-md-2">
								<strong>Nomor</strong>
								<div class="note"></div>
								</td>
								<td>
								<div class="form-group">
								<div class="col-md-3">
								<?php echo form_input('akte_notaris_nomor', !empty($data_edit->akte_notaris_nomor) ? $data_edit->akte_notaris_nomor : '', 'class="form-control" data-rule-required="true"') ?>
								
								</div>
								</div>
								</td>
							</tr>
							
							<tr>
								<td class="col-md-2">
								<strong>Nama Notaris</strong>
								<div class="note">Pejabat yang mengesahkan</div>
								</td>
								<td>
								<div class="form-group">
								<div class="col-md-3">
								<?php echo form_input('akte_notaris_pejabat', !empty($data_edit->akte_notaris_pejabat) ? $data_edit->akte_notaris_pejabat : '', 'class="form-control" data-rule-required="true"') ?>
								
								</div>
								</div>
								</td>
							</tr>          
							
							<tr>
								<td class="col-md-2">
								<strong>Tanggal Keluar</strong>
								</td>
								<td>
								<div class="form-group">
								<div class="col-md-2">
								<div class='input-group date'>
								<?php echo form_input('akte_notaris_dikeluarkan', !empty($data_edit->akte_notaris_dikeluarkan) ? date('d-m-Y', strtotime($data_edit->akte_notaris_dikeluarkan)) : date('d-m-Y'), 'class="form-control date" data-rule-required="true"') ?>
								<span class="input-group-addon"><span class="fa fa-calendar"></span></span>                    
								</div>
								
								</div>
								</div>
								</td>
							</tr>
							
							<tr>
								<td class="col-md-2">
								<strong>Tanggal Kadaluarsa</strong>
								</td>
								<td>
								<div class="form-group">
								<div class="col-md-2">
								<div class='input-group date'>
								<?php echo form_input('akte_notaris_kadaluarsa', !empty($data_edit->akte_notaris_kadaluarsa) ? date('d-m-Y', strtotime($data_edit->akte_notaris_kadaluarsa)) : date('d-m-Y'), 'class="form-control date" data-rule-required="true"') ?>
								<span class="input-group-addon"><span class="fa fa-calendar"></span></span>                    
								</div>
								
								</div>
								</div>
								</td>
							</tr>   
			    
							<tr>
							<td colspan="2">
							<div class="alert alert-danger fade in">
							<strong>SIUP</strong>
							</div>
							</td>
							</tr> 

							<tr>
								<td class="col-md-2">
								    <strong>Dokumen SIUP</strong>
								    <div class="note"></div>
								</td>
								<td>

									<table class="table table-bordered" id="table-dokumen-siup">

										<thead>
											<tr>
											<td class="no">#</td>
											<td width="45%">Deskripsi</td>
											<td colspan="2">File</td>
											</tr>
										</thead>
										
										<tbody class="data-row">
										<?php 
										if(!empty($data_edit->dok_siup) && $data_edit->dok_siup !== '[]'): 

										$no = 1;
										$dokumen_idp = json_decode($data_edit->dok_siup);
										foreach($dokumen_idp as $dt_siup):
										?>

										<tr class="row-clone">
										<td style="width:50px" class="no"><?php echo $no++ ?></td>
										<td>
										<div class="form-group">
										<div class="col-md-12">
										<?php echo form_input('dokumen_deskripsi_siup[]',$dt_siup->deskripsi, 'class="form-control dokumen-deskripsi"') ?>
										</div>
										</div>
										</td>
										<td>
										<div class="form-group">

										<?php echo form_hidden('dokumen_path_siup[]', $dt_siup->file,'class="dokumen-path"') ?>
										<?php echo form_hidden('dokumen_name_siup[]', $dt_siup->filename,'class="dokumen-name"') ?>

										<div class="col-md-8">
										<div class="fileinput fileinput-new" data-provides="fileinput">
										<span class="btn btn-default btn-file">
										<span class="fileinput-new">Pilih File</span>
										<span class="fileinput-exists">Change</span>
										<?php echo form_upload('dokumen_file_siup[]',NULL,'class="dokumen-file"') ?>
										</span>
										<span class="fileinput-filename"><?php echo $dt_siup->filename ?></span>

										<a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
										</div>
										</div>
										</div>
										</td>
										</tr>
										<?php endforeach; else: ?>
										<tr class="row-clone">
										<td style="width:50px" class="no"></td>
										<td>
										<div class="form-group">
										<div class="col-md-12">
										<?php echo form_input('dokumen_deskripsi_siup[]', NULL, 'class="form-control dokumen-deskripsi"') ?>
										</div>
										</div>
										</td>
										<td>
										<div class="form-group">
										<div class="col-md-8">
										<div class="fileinput fileinput-new" data-provides="fileinput">
										<span class="btn btn-default btn-file">
										<span class="fileinput-new">Pilih File</span>
										<span class="fileinput-exists">Change</span>
										<?php echo form_upload('dokumen_file_siup[]',NULL,'class="dokumen-file"') ?>
										</span>
										<span class="fileinput-filename"></span>
										<a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
										</div>
										</div>
										</div>
										</td>
										</tr>
										<?php endif; ?>
										</tbody>
										
									</table>
								</td>
							</tr>


							<tr>
								<td class="col-md-2">
								<strong>Nomor</strong>
								<div class="note"></div>
								</td>
								<td>
								<div class="form-group">
								<div class="col-md-3">
								<?php echo form_input('siup_nomor', !empty($data_edit->siup_nomor) ? $data_edit->siup_nomor : '', 'class="form-control" data-rule-required="true"') ?>
								
								</div>
								</div>
								</td>
							</tr>
							
							<tr>
								<td class="col-md-2">
								<strong>Nama</strong>
								<div class="note">Pejabat yang mengesahkan</div>
								</td>
								<td>
								<div class="form-group">
								<div class="col-md-3">
								<?php echo form_input('siup_pejabat', !empty($data_edit->siup_pejabat) ? $data_edit->siup_pejabat : '', 'class="form-control" data-rule-required="true"') ?>
								
								</div>
								</div>
								</td>
							</tr>          
							
							<tr>
								<td class="col-md-2">
								<strong>Tanggal Keluar</strong>
								</td>
								<td>
								<div class="form-group">
								<div class="col-md-2">
								<div class='input-group date'>
								<?php echo form_input('siup_dikeluarkan', !empty($data_edit->siup_dikeluarkan) ? date('d-m-Y', strtotime($data_edit->siup_dikeluarkan)) : date('d-m-Y'), 'class="form-control date" data-rule-required="true"') ?>
								<span class="input-group-addon"><span class="fa fa-calendar"></span></span>                    
								</div>
								
								</div>
								</div>
								</td>
							</tr>
							
							<tr>
								<td class="col-md-2">
								<strong>Tanggal Kadaluarsa</strong>
								</td>
								<td>
								<div class="form-group">
								<div class="col-md-2">
								<div class='input-group date'>
								<?php echo form_input('siup_kadaluarsa', !empty($data_edit->siup_kadaluarsa) ? date('d-m-Y', strtotime($data_edit->siup_kadaluarsa)) : date('d-m-Y'), 'class="form-control date" data-rule-required="true"') ?>
								<span class="input-group-addon"><span class="fa fa-calendar"></span></span>                    
								</div>
								
								</div>
								</div>
								</td>
							</tr>   
							
							<tr>
								<td colspan="2">
								<div class="alert alert-info fade in">
								<strong>TDP</strong>                                        
								</div>
								</td>
							</tr> 

							
							<tr>
								<td class="col-md-2">
									<strong>Dokumen TDP</strong>
									<div class="note"></div>
								</td>
								<td>
								<table class="table table-bordered" id="table-dokumen-idp">
									<thead>
										<tr>
											<td class="no">#</td>
											<td width="45%">Deskripsi</td>
											<td colspan="2">File</td>
										</tr>
									</thead>
									<tbody class="data-row">
										<?php 
											if(!empty($data_edit->dok_idp) && $data_edit->dok_idp !== '[]'): 
											$no = 1;
											$dokumen_idp = json_decode($data_edit->dok_idp);
											foreach($dokumen_idp as $dt_idp):
										?>

											<tr class="row-clone">
											<td style="width:50px" class="no"><?php echo $no++ ?></td>
											<td>
											<div class="form-group">
											<div class="col-md-12">
											<?php echo form_input('dokumen_deskripsi_idp[]',$dt_idp->deskripsi, 'class="form-control dokumen-deskripsi"') ?>
											</div>
											</div>
											</td>
											<td>
											<div class="form-group">
											<?php echo form_hidden('dokumen_path_idp[]', $dt_idp->file,'class="dokumen-path"') ?>
											<?php echo form_hidden('dokumen_name_idp[]', $dt_idp->filename,'class="dokumen-name"') ?>
											<div class="col-md-8">
											<div class="fileinput fileinput-new" data-provides="fileinput">
											<span class="btn btn-default btn-file">
											<span class="fileinput-new">Pilih File</span>
											<span class="fileinput-exists">Change</span>
											<?php echo form_upload('dokumen_file_idp[]',NULL,'class="dokumen-file"') ?>
											</span>
											<span class="fileinput-filename"><?php echo $dt_idp->filename ?></span>
											<a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
											</div>
											</div>
											</div>
											</td>
											</tr>
											<?php endforeach; else: ?>
											<tr class="row-clone">
											<td style="width:50px" class="no"></td>
											<td>
											<div class="form-group">
											<div class="col-md-12">
											<?php echo form_input('dokumen_deskripsi_idp[]', NULL, 'class="form-control dokumen-deskripsi"') ?>
											</div>
											</div>
											</td>
											<td>
											<div class="form-group">
											<div class="col-md-8">
											<div class="fileinput fileinput-new" data-provides="fileinput">
											<span class="btn btn-default btn-file">
											<span class="fileinput-new">Pilih File</span>
											<span class="fileinput-exists">Change</span>
											<?php echo form_upload('dokumen_file_idp[]',NULL,'class="dokumen-file"') ?>
											</span>
											<span class="fileinput-filename"></span>
											<a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
											</div>
											</div>
											</div>
											</td>
											</tr>
										<?php endif; ?>
									</tbody>
								</table>
								</td>
							</tr>                 


							<?php
							if (!empty($decode_idp)) {
							foreach ($decode_idp as $row_idp) {
							$nomor_idp = $row_idp['nomor'];
							$nama_pejabat_idp = $row_idp['pejabat'];
							$tgl_dikeluarkan_idp = $row_idp['tgl_dikeluarkan'];
							$tgl_kadaluarsa_idp = $row_idp['tgl_kadaluarsa'];
							}
							}
							?>
							<tr>
							<td class="col-md-2">
							<strong>Nomor</strong>
							<div class="note"></div>
							</td>

							<td>
							<div class="form-group">
							<div class="col-md-3">
							<?php echo form_input('idp_nomor', !empty($nomor_idp) ? $nomor_idp : '', 'class="form-control" data-rule-required="true"') ?>
							
							</div>
							</div>
							</td>
							</tr>
							<tr>
							<td class="col-md-2">
							<strong>Nama</strong>
							<div class="note">Pejabat yang mengesahkan</div>
							</td>

							<td>
							<div class="form-group">
							<div class="col-md-3">
							<?php echo form_input('idp_nama_pejabat', !empty($nama_pejabat_idp) ? $nama_pejabat_idp : '', 'class="form-control" data-rule-required="true"') ?>
							
							</div>
							</div>
							</td>
							</tr>                                
							<tr>
							<td class="col-md-2">
							<strong>Tanggal Keluar</strong>
							</td>
							<td>
							<div class="form-group">
							<div class="col-md-2">
							<div class='input-group date'>
							<?php echo form_input('idp_dikeluarkan', !empty($tgl_dikeluarkan_idp) ? date('d-m-Y', strtotime($tgl_dikeluarkan_idp)) : date('d-m-Y'), 'class="form-control date" data-rule-required="true"') ?>
							<span class="input-group-addon"><span class="fa fa-calendar"></span></span>                    
							</div>
							
							</div>
							</div>
							</td>
							</tr>
							<tr>
							<td class="col-md-2">
							<strong>Tanggal Kadaluarsa</strong>
							</td>
							<td>
							<div class="form-group">
							<div class="col-md-2">
							<div class='input-group date'>
							<?php echo form_input('idp_kadaluarsa', !empty($tgl_kadaluarsa_idp) ? date('d-m-Y', strtotime($tgl_kadaluarsa_idp)) : date('d-m-Y'), 'class="form-control date" data-rule-required="true"') ?>
							<span class="input-group-addon"><span class="fa fa-calendar"></span></span>                    
							</div>
							
							</div>
							</div>
							</td>
							</tr>              

			    		<tr>
                                <td colspan="2">
                                    <div class="alert alert-warning fade in">
                                    <strong>SITU</strong>                                        
                                    </div>
                                </td>
                                
                            </tr>
                            <tr>
                                <td>
                                    
                                        <strong>Dokumen SITU</strong>		

                                </td>
                                <td>
	            		<table class="table table-bordered" id="table-dokumen-situ">
	                    <thead>
	                      <tr>
	                        <td class="no">#</td>
	                        <td width="45%">Deskripsi</td>
	                        <td colspan="2">File</td>
	                      </tr>
	                    </thead>
	                    <tbody class="data-row">
	                    <?php 
	                      if(!empty($data_edit->dok_situ) && $data_edit->dok_situ !== '[]'): 

	                        $no = 1;
	                        $dokumen_situ = json_decode($data_edit->dok_situ);
	                        foreach($dokumen_situ as $dt_situ):
	                    ?>

	                      <tr class="row-clone">
	                        <td style="width:50px" class="no"><?php echo $no++ ?></td>
	                        <td>
	                          <div class="form-group">
	                            <div class="col-md-12">
	                             <?php echo form_input('dokumen_deskripsi_situ[]',$dt_situ->deskripsi, 'class="form-control dokumen-deskripsi"') ?>
	                            </div>
	                          </div>
	                        </td>
	                        <td>
	                          <div class="form-group">
	                            
	                            <?php echo form_hidden('dokumen_path_situ[]', $dt_situ->file,'class="dokumen-path"') ?>
	                            <?php echo form_hidden('dokumen_name_situ[]', $dt_situ->filename,'class="dokumen-name"') ?>

	                            <div class="col-md-8">
	                               <div class="fileinput fileinput-new" data-provides="fileinput">
	                                  <span class="btn btn-default btn-file">
	                                    <span class="fileinput-new">Pilih File</span>
	                                    <span class="fileinput-exists">Change</span>
	                                    <?php echo form_upload('dokumen_file_situ[]',NULL,'class="dokumen-file"') ?>
	                                  </span>
	                                  <span class="fileinput-filename"><?php echo $dt_situ->filename ?></span>
	                                  
	                                  <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
	                                </div>
	                            </div>
	                          </div>
	                        </td>
	                      </tr>
	                    <?php endforeach; else: ?>
	                      <tr class="row-clone">
	                        <td style="width:50px" class="no"></td>
	                        <td>
	                          <div class="form-group">
	                            <div class="col-md-12">
	                             <?php echo form_input('dokumen_deskripsi_situ[]', NULL, 'class="form-control dokumen-deskripsi"') ?>
	                            </div>
	                          </div>
	                        </td>
	                        <td>
	                          <div class="form-group">
	                            <div class="col-md-8">
	                               <div class="fileinput fileinput-new" data-provides="fileinput">
	                                  <span class="btn btn-default btn-file">
	                                  <span class="fileinput-new">Pilih File</span>
	                                  <span class="fileinput-exists">Change</span>
	                                  <?php echo form_upload('dokumen_file_situ[]',NULL,'class="dokumen-file"') ?>
	                                  </span>
	                                  <span class="fileinput-filename"></span>
	                                  <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
	                                </div>
	                            </div>
	                          </div>
	                        </td>
	                      </tr>
	                    <?php endif; ?>
	                    </tbody>
	                  </table>
	                                </td>
	                            </tr>                                    
	                            <?php
	                            if (!empty($decode_situ)) {
	                                foreach ($decode_situ as $row_situ) {
	                                    $nomor_situ = $row_situ['nomor'];
	                                    $nama_pejabat_situ = $row_situ['pejabat'];
	                                    $tgl_dikeluarkan_situ = $row_situ['tgl_dikeluarkan'];
	                                    $tgl_kadaluarsa_situ = $row_situ['tgl_kadaluarsa'];
	                                }
	                            }
	                            ?>  
	                            
	                            <tr>
	                                <td class="col-md-2">
	                                    <strong>Nomor</strong>
	                                    <div class="note"></div>
	                                </td>

	                                <td>
	                                    <div class="form-group">
	                                        <div class="col-md-3">
						<?php echo form_input('situ_nomor', !empty($nomor_situ) ? $nomor_situ : '', 'class="form-control" data-rule-required="true"') ?>
	                                            
	                                        </div>
	                                    </div>
	                                </td>
	                            </tr>
	                            <tr>
	                                <td class="col-md-2">
	                                    <strong>Nama</strong>
	                                    <div class="note">Pejabat yang mengesahkan</div>
	                                </td>

	                                <td>
	                                    <div class="form-group">
	                                        <div class="col-md-3">
						<?php echo form_input('situ_nama_pejabat', !empty($nama_pejabat_situ) ? $nama_pejabat_situ : '', 'class="form-control" data-rule-required="true"') ?>
	                                            
	                                        </div>
	                                    </div>
	                                </td>
	                            </tr>                                      
	                            <tr>
	                                <td class="col-md-2">
	                                    <strong>Tanggal Keluar</strong>
	                                </td>
	                                <td>
	                                    <div class="form-group">
	                                        <div class="col-md-2">
	                                            <div class='input-group date'>
						<?php echo form_input('situ_dikeluarkan', !empty($tgl_dikeluarkan_situ) ? date('d-m-Y', strtotime($tgl_dikeluarkan_situ)) : date('d-m-Y'), 'class="form-control date" data-rule-required="true"') ?>

	                                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>                    
	                                            </div>
	                                            
	                                        </div>
	                                    </div>
	                                </td>
	                            </tr>
	                            <tr>
	                                <td class="col-md-2">
	                                    <strong>Tanggal Kadaluarsa</strong>
	                                </td>
	                                <td>
	                                    <div class="form-group">
	                                        <div class="col-md-2">
	                                            <div class='input-group date'>
						<?php echo form_input('situ_kadaluarsa', !empty($tgl_dikeluarkan_situ) ? date('d-m-Y', strtotime($tgl_dikeluarkan_situ)) : date('d-m-Y'), 'class="form-control date" data-rule-required="true"') ?>
	                                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>                    
	                                            </div>
	                                            
	                                        </div>
	                                    </div>
	                                </td>
	                            </tr>
	                           
                	</div>

                	
		
		</table>
	</fieldset>
        
            </div>
            <?php echo form_close() ?>
        </div>
        <div class="modal-footer">
            <?php
            echo anchor(NULL, '<i class="glyphicon glyphicon-chevron-left"></i> Back', array(
                'id' => 'mybutton-add',
                'class' => 'btn btn-default margin-right-2',
                'data-dismiss' => 'modal',
                'onclick' => 'my_form.go_back()'
            ));
            echo anchor(NULL, '<i class="glyphicon glyphicon-floppy-disk"></i> Save', array(
                'id' => 'mybutton-add',
                'class' => 'btn btn-success',
                'onclick' => 'form_submit()'
            ));
            //'onclick' => 'my_form.submit(\'#finput\')'
            ?>

        </div>
      </div>
    </div>
</div>


                <!-- /.Clone Table -->
                <table>
                    <tbody data-table="#table-dokumen" style="display: none;">
                        <tr class="row-clone">
                            <td style="width:50px" class="no"></td>
                            <td>
                                <div class="form-group">
                                    <div class="col-md-12">
							<?php echo form_input('dokumen_deskripsi_qhse[]', NULL, 'class="form-control dokumen-deskripsi"') ?>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <div class="col-md-8">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <span class="btn btn-default btn-file">
                                                <span class="fileinput-new">Pilih File</span>
                                                <span class="fileinput-exists">Change</span>
                                                <input type="file" name="dokumen_file_qhse[]" class="dokumen-file"></span>
                                            <span class="fileinput-filename"></span>
                                            <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td><a class="btn btn-danger btn-xs remove-row" onclick="my_table_dokumen.remove('#table-dokumen', this.id)"><i class="fa fa-remove"></i></a></td>
                        </tr>
                    </tbody>
                </table>

                <!-- finance -->

                <table>
                    <tbody data-table="#table-dokumen-finance" style="display: none;">
                        <tr class="row-clone">
                            <td style="width:50px" class="no"></td>
                            <td>
                                <div class="form-group">
                                    <div class="col-md-12">
									<?php echo form_input('dokumen_deskripsi_finance[]', NULL, 'class="form-control dokumen-deskripsi"') ?>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <div class="col-md-8">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <span class="btn btn-default btn-file">
                                                <span class="fileinput-new">Pilih File</span>
                                                <span class="fileinput-exists">Change</span>
                                                <input type="file" name="dokumen_file_finance[]" class="dokumen-file"></span>
                                            <span class="fileinput-filename"></span>
                                            <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td><a class="btn btn-danger btn-xs remove-row" onclick="my_table_dokumen_finance.remove('#table-dokumen-finance', this.id)"><i class="fa fa-remove"></i></a></td>
                        </tr>
                    </tbody>
                </table>

               <!--  legal -->
               	 <table>
                    <tbody data-table="#table-dokumen-legal" style="display: none;">
                        <tr class="row-clone">
                            <td style="width:50px" class="no"></td>
                            <td>
                                <div class="form-group">
                                    <div class="col-md-12">
									<?php echo form_input('dokumen_deskripsi_legal[]', NULL, 'class="form-control dokumen-deskripsi"') ?>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <div class="col-md-8">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <span class="btn btn-default btn-file">
                                                <span class="fileinput-new">Pilih File</span>
                                                <span class="fileinput-exists">Change</span>
                                                <input type="file" name="dokumen_file_legal[]" class="dokumen-file"></span>
                                            <span class="fileinput-filename"></span>
                                            <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td><a class="btn btn-danger btn-xs remove-row" onclick="my_table_dokumen_legal.remove('#table-dokumen-legal', this.id)"><i class="fa fa-remove"></i></a></td>
                        </tr>
                    </tbody>
                </table>

              <!--   others -->
               <table>
                    <tbody data-table="#table-dokumen-others" style="display: none;">
                        <tr class="row-clone">
                            <td style="width:50px" class="no"></td>
                            <td>
                                <div class="form-group">
                                    <div class="col-md-12">
									<?php echo form_input('dokumen_deskripsi_others[]', NULL, 'class="form-control dokumen-deskripsi"') ?>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <div class="col-md-8">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <span class="btn btn-default btn-file">
                                                <span class="fileinput-new">Pilih File</span>
                                                <span class="fileinput-exists">Change</span>
                                                <input type="file" name="dokumen_file_others[]" class="dokumen-file"></span>
                                            <span class="fileinput-filename"></span>
                                            <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td><a class="btn btn-danger btn-xs remove-row" onclick="my_table_dokumen_others.remove('#table-dokumen-others', this.id)"><i class="fa fa-remove"></i></a></td>
                        </tr>
                    </tbody>
                </table>


                <!-- Pejabat -->
                <table>
                    <tbody data-table="#table-dokumen2" style="display: none;">
                        <tr class="row-clone">
                            <td style="width:50px" class="no"></td>
                            <td>
                                <div class="form-group">
                                    <div class="col-md-12">
<?php echo form_input('nama_direksi[]', NULL, 'class="form-control dokumen-deskripsi"') ?>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <div class="col-md-12">
<?php echo form_input('jabatan_direksi[]', NULL, 'class="form-control dokumen-deskripsi"') ?>
                                    </div>
                                </div>
                            </td>
                            <td><a class="btn btn-danger btn-xs remove-row" onclick="my_table_dokumen2.remove('#table-dokumen2', this.id)"><i class="fa fa-remove"></i></a></td>
                        </tr>
                    </tbody>
                </table>
		
                <!-- Saham -->
                <table>
                    <tbody data-table="#table-dokumen3" style="display: none;">
                        <tr class="row-clone">
                            <td style="width:50px" class="no"></td>
                            <td>
                                <div class="form-group">
                                    <div class="col-md-12">
<?php echo form_input('nama_saham[]', NULL, 'class="form-control dokumen-deskripsi"') ?>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <div class="col-md-12">
<?php echo form_input('persen_saham[]', NULL, 'class="form-control dokumen-deskripsi"') ?>
                                    </div>
                                </div>
                            </td>
                            <td><a class="btn btn-danger btn-xs remove-row" onclick="my_table_dokumen3.remove('#table-dokumen3', this.id)"><i class="fa fa-remove"></i></a></td>
                        </tr>
                    </tbody>
                </table>
		 
                <!-- Kantor Cabang -->
                <table>
                    <tbody data-table="#table-dokumen4" style="display:none" >
                        <tr class="row-clone">
                            <td style="width:50px" class="no"></td>
                            <td>
                                <div class="form-group">
                                    <div class="col-md-12">
				<textarea name="alamat_cabang[]" class="form-control" rows="3"></textarea>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <div class="col-md-12 provinsiMulti_test">  
 <?php echo form_dropdown('provinsi_cabang[]', $provinsi, NULL, 'class="" id="provinsi_test" target-options="kotamadya_test" style="width:100%" '); ?> 
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <div class="col-md-12 kotamadyaMulti_test">
<?php echo form_dropdown('kotamadya_cabang[]', $kotamadya, NULL, 'class=""  id="kotamadya_test" style="width:100%" data-source="' . base_url('master/kecamatan') . '/load_regency_all" '); ?>
                                    </div>
                                </div>
                            </td>
                            <td><a class="btn btn-danger btn-xs remove-row" onclick="my_table_dokumen4.remove('#table-dokumen4', this.id)"><i class="fa fa-remove"></i></a></td>
                        </tr>
                    </tbody>
                </table>
		 
                <!-- Bidang perusahaan -->
                <table>
                    <tbody data-table="#table-dokumen5" style="display:none" >
                        <tr class="row-clone">
                            <td style="width:50px" class="no"></td>
                            <td>
                                <div class="form-group">
                                    <div class="col-md-12">  
<?php echo form_dropdown('golongan_id[]', $option_bidang, NULL, 'class="col-md-12" id="golongan_testing" target-options="bidang_testing" data-rule-required="true"'); ?>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <div class="col-md-12">
<?php echo form_dropdown('bidang_id[]', $option_sub_bidang, NULL, 'class="col-md-12"  id="bidang_testing" data-source="' . base_url('home/vendor') . '/load_regency" data-rule-required="true"'); ?>
                                    </div>
                                </div>
                            </td>
                            <td><a class="btn btn-danger btn-xs remove-row" onclick="my_table_dokumen5.remove('#table-dokumen5', this.id)"><i class="fa fa-remove"></i></a></td>
                        </tr>
                    </tbody>
                </table>
		
            </div>
            <!-- end widget content -->
        </div>
        <!-- end widget div -->            
    </div>


<script type="text/javascript">

    $('#glbaranglbu').change(function () {
        $.post("<?php echo base_url(); ?>home/inventarisasi/get_bidang/" + $('#glbaranglbu').val(), {}, function (obj) {
            $('#bidangbarang').html(obj);
        });
    });

    pageSetUp();
    my_form.init();
    //$('.date').datetimepicker({pickTime: false, format: 'YYYY-MM-DD'});

    var load_and_reset_form = function () {
        pagefunction();
        my_form.reset('#finput');
    };

    var __after_process = function (ket) {

        // if (ket != 1) my_form.go_back();
        // my_form.go_back();
        my_form.go_back();
    };

    var pagefunction = function () {
        // load bootstrap wizard
        loadScript("<?php echo hconfig::base_assets(); ?>/plugin/bootstrap-wizard/jquery.bootstrap.wizard.min.js", runBootstrapWizard);
        ////Bootstrap Wizard Validations
        function runBootstrapWizard() {

            $('#bootstrap-wizard-1').bootstrapWizard({
                'tabClass': 'form-wizard',
                'onNext': function (tab, navigation, index) {
                    var $valid = $("#wizard-1").valid();
                    if (!$valid) {
                        $validator.focusInvalid();
                        return false;
                    } else {
                        $('#bootstrap-wizard-1').find('.form-wizard').children('li').eq(index - 1).addClass('complete');
                        $('#bootstrap-wizard-1').find('.form-wizard').children('li').eq(index - 1).find('.step').html('<i class="fa fa-check"></i>');
                    }
                }
            });
        };

        // load fuelux wizard

        loadScript("<?php echo hconfig::base_assets(); ?>/plugin/fuelux/js/fuelux.min.js", fueluxWizard);

        function fueluxWizard() {
            var wizard = $('.wizard').wizard();
            wizard.on('finished', function (e, data) {
                form_submit();
                validasi_step();
            });
        };
    };

    var my_table_dokumen = {
        append: function (table) {
            var $init = $(table);
            var $clone = $('[data-table="' + table + '"]').children('.row-clone').clone();
            $('.data-row', $init).append($clone);

            my_table_dokumen.render_row(table);
        },
        remove: function (table, index) {
            var $init = $(table);
            $('#' + index, $init).closest('.row-clone').remove();

            my_table_dokumen.render_row(table);
        },
        render_remove: function (table) {
            var $init = $(table);
            var $row_count = $('.data-row', $init).children('.row-clone').length;
            if ($row_count == 1) {
                $('.remove-row', $init).hide();
            } else {
                $('.remove-row', $init).show();
            }
        },
        render_row: function (table) {
            var $init = $(table);
            var no = 0;
            $.each($('.data-row', $init).children('.row-clone'), function () {
                no++;
                $('.no', this).html(no);
                $('.remove-row', this).attr('data-row', no);
                $('.remove-row', this).attr('id', 'remove-row-' + no);
            });
            my_table_dokumen.render_remove(table);
        },
    };

    var my_table_dokumen_finance = {
        append: function (table) {
            var $init = $(table);
            var $clone = $('[data-table="' + table + '"]').children('.row-clone').clone();
            $('.data-row', $init).append($clone);

            my_table_dokumen_finance.render_row(table);
        },
        remove: function (table, index) {
            var $init = $(table);
            $('#' + index, $init).closest('.row-clone').remove();

            my_table_dokumen_finance.render_row(table);
        },
        render_remove: function (table) {
            var $init = $(table);
            var $row_count = $('.data-row', $init).children('.row-clone').length;
            if ($row_count == 1) {
                $('.remove-row', $init).hide();
            } else {
                $('.remove-row', $init).show();
            }
        },
        render_row: function (table) {
            var $init = $(table);
            var no = 0;
            $.each($('.data-row', $init).children('.row-clone'), function () {
                no++;
                $('.no', this).html(no);
                $('.remove-row', this).attr('data-row', no);
                $('.remove-row', this).attr('id', 'remove-row-' + no);
            });
            my_table_dokumen_finance.render_remove(table);
        },
    };

    var my_table_dokumen_legal = {
        append: function (table) {
            var $init = $(table);
            var $clone = $('[data-table="' + table + '"]').children('.row-clone').clone();
            $('.data-row', $init).append($clone);

            my_table_dokumen_legal.render_row(table);
        },
        remove: function (table, index) {
            var $init = $(table);
            $('#' + index, $init).closest('.row-clone').remove();

            my_table_dokumen_legal.render_row(table);
        },
        render_remove: function (table) {
            var $init = $(table);
            var $row_count = $('.data-row', $init).children('.row-clone').length;
            if ($row_count == 1) {
                $('.remove-row', $init).hide();
            } else {
                $('.remove-row', $init).show();
            }
        },
        render_row: function (table) {
            var $init = $(table);
            var no = 0;
            $.each($('.data-row', $init).children('.row-clone'), function () {
                no++;
                $('.no', this).html(no);
                $('.remove-row', this).attr('data-row', no);
                $('.remove-row', this).attr('id', 'remove-row-' + no);
            });
            my_table_dokumen_legal.render_remove(table);
        },
    };

     var my_table_dokumen_others = {
        append: function (table) {
            var $init = $(table);
            var $clone = $('[data-table="' + table + '"]').children('.row-clone').clone();
            $('.data-row', $init).append($clone);

            my_table_dokumen_others.render_row(table);
        },
        remove: function (table, index) {
            var $init = $(table);
            $('#' + index, $init).closest('.row-clone').remove();

            my_table_dokumen_others.render_row(table);
        },
        render_remove: function (table) {
            var $init = $(table);
            var $row_count = $('.data-row', $init).children('.row-clone').length;
            if ($row_count == 1) {
                $('.remove-row', $init).hide();
            } else {
                $('.remove-row', $init).show();
            }
        },
        render_row: function (table) {
            var $init = $(table);
            var no = 0;
            $.each($('.data-row', $init).children('.row-clone'), function () {
                no++;
                $('.no', this).html(no);
                $('.remove-row', this).attr('data-row', no);
                $('.remove-row', this).attr('id', 'remove-row-' + no);
            });
            my_table_dokumen_others.render_remove(table);
        },
    };


    var my_table_dokumen2 = {
        append: function (table) {
            var $init = $(table);
            var $clone = $('[data-table="' + table + '"]').children('.row-clone').clone();
            $('.data-row', $init).append($clone);

            my_table_dokumen2.render_row(table);
        },
        remove: function (table, index) {
            var $init = $(table);
            $('#' + index, $init).closest('.row-clone').remove();

            my_table_dokumen2.render_row(table);
        },
        render_remove: function (table) {
            var $init = $(table);
            var $row_count = $('.data-row', $init).children('.row-clone').length;
            if ($row_count == 1) {
                $('.remove-row', $init).hide();
            } else {
                $('.remove-row', $init).show();
            }
        },
        render_row: function (table) {
            var $init = $(table);
            var no = 0;
            $.each($('.data-row', $init).children('.row-clone'), function () {
                no++;
                $('.no', this).html(no);
                $('.remove-row', this).attr('data-row', no);
                $('.remove-row', this).attr('id', 'remove-row-' + no);
            });
            my_table_dokumen2.render_remove(table);
        },
    };

    var my_table_dokumen3 = {
        append: function (table) {
            var $init = $(table);
            var $clone = $('[data-table="' + table + '"]').children('.row-clone').clone();
            $('.data-row', $init).append($clone);

            my_table_dokumen3.render_row(table);
        },
        remove: function (table, index) {
            var $init = $(table);
            $('#' + index, $init).closest('.row-clone').remove();

            my_table_dokumen3.render_row(table);
        },
        render_remove: function (table) {
            var $init = $(table);
            var $row_count = $('.data-row', $init).children('.row-clone').length;
            if ($row_count == 1) {
                $('.remove-row', $init).hide();
            } else {
                $('.remove-row', $init).show();
            }
        },
        render_row: function (table) {
            var $init = $(table);
            var no = 0;
            $.each($('.data-row', $init).children('.row-clone'), function () {
                no++;
                $('.no', this).html(no);
                $('.remove-row', this).attr('data-row', no);
                $('.remove-row', this).attr('id', 'remove-row-' + no);
            });
            my_table_dokumen3.render_remove(table);
        },
    };

    var my_table_dokumen4 = {
        append: function (table) {
            var $init = $(table);
            var $clone = $('[data-table="' + table + '"]').children('.row-clone').clone();
            $('.data-row', $init).append($clone);
            my_table_dokumen4.render_row(table);
        },
        remove: function (table, index) {
            var $init = $(table);
            $('#' + index, $init).closest('.row-clone').remove();

            my_table_dokumen4.render_row(table);
        },
        render_remove: function (table) {
            var $init = $(table);
            var $row_count = $('.data-row', $init).children('.row-clone').length;
            if ($row_count == 1) {
                $('.remove-row', $init).hide();
            } else {
                $('.remove-row', $init).show();
            }
        },
        render_row: function (table) {
            var $init = $(table);
            var no = 0;
            $.each($('.data-row', $init).children('.row-clone'), function () {
                no++;
                $('.no', this).html(no);
                $('.remove-row', this).attr('data-row', no);
                $('.remove-row', this).attr('id', 'remove-row-' + no);
		
		
                $('#provinsi_test', this).attr('target-options', 'kotamadya_' + no);
                $('#provinsi_test', this).attr('id', 'provinsi_' + no).select2();
                $('#kotamadya_test', this).attr('id', 'kotamadya_' + no).select2();
		$('#provinsi_'+no).change(function () {
		    my_form.ajax.options('provinsi_'+no, 'select2');
		});
		
		/*
		my_form.ajax.options("provinsi_"+no, 'select2');
		my_form.ajax.options('kotamadya_' + no, 'select2', $('#kotamadya_' + no).data('selected'));
		$('#provinsi_'+no).change(function () {
		    my_form.ajax.options("provinsi_"+no, 'select2');
		});
		*/
            });
	    
            my_table_dokumen4.render_remove(table);
        },
    };
    
    var my_table_dokumen5 = {
        append: function (table) {
            var $init = $(table);
            var $clone = $('[data-table="' + table + '"]').children('.row-clone').clone();
            $('.data-row', $init).append($clone);
            my_table_dokumen5.render_row(table);
        },
        remove: function (table, index) {
            var $init = $(table);
            $('#' + index, $init).closest('.row-clone').remove();

            my_table_dokumen5.render_row(table);
        },
        render_remove: function (table) {
            var $init = $(table);
            var $row_count = $('.data-row', $init).children('.row-clone').length;
            if ($row_count == 1) {
                $('.remove-row', $init).hide();
            } else {
                $('.remove-row', $init).show();
            }
        },
        render_row: function (table) {
            var $init = $(table);
            var no = 0;
            $.each($('.data-row', $init).children('.row-clone'), function () {
                no++;
                $('.no', this).html(no);
                $('.remove-row', this).attr('data-row', no);
                $('.remove-row', this).attr('id', 'remove-row-' + no);
		
                $('#golongan_testing', this).attr('target-options', 'bidang_' + no);
                $('#golongan_testing', this).attr('id', 'golongan_' + no).select2();
                $('#bidang_testing', this).attr('id', 'bidang_' + no).select2();
		$('#golongan_'+no).change(function () {
		    my_form.ajax.options('golongan_'+no, 'select2');
		});
		
            });
	    
            my_table_dokumen5.render_remove(table);
        },
    };
    
    var my_table_dokumen_siup = {
        append: function (table) {
            var $init = $(table);
            var $clone = $('[data-table="' + table + '"]').children('.row-clone').clone();
            $('.data-row', $init).append($clone);

            my_table_dokumen_siup.render_row(table);
        },
        remove: function (table, index) {
            var $init = $(table);
            $('#' + index, $init).closest('.row-clone').remove();

            my_table_dokumen_siup.render_row(table);
        },
        render_remove: function (table) {
            var $init = $(table);
            var $row_count = $('.data-row', $init).children('.row-clone').length;
            if ($row_count == 1) {
                $('.remove-row', $init).hide();
            } else {
                $('.remove-row', $init).show();
            }
        },
        render_row: function (table) {
            var $init = $(table);
            var no = 0;
            $.each($('.data-row', $init).children('.row-clone'), function () {
                no++;
                $('.no', this).html(no);
                $('.remove-row', this).attr('data-row', no);
                $('.remove-row', this).attr('id', 'remove-row-' + no);
            });
            my_table_dokumen_siup.render_remove(table);
        },
    };

    var my_table_dokumen_idp = {
        append: function (table) {
            var $init = $(table);
            var $clone = $('[data-table="' + table + '"]').children('.row-clone').clone();
            $('.data-row', $init).append($clone);

            my_table_dokumen_idp.render_row(table);
        },
        remove: function (table, index) {
            var $init = $(table);
            $('#' + index, $init).closest('.row-clone').remove();

            my_table_dokumen_idp.render_row(table);
        },
        render_remove: function (table) {
            var $init = $(table);
            var $row_count = $('.data-row', $init).children('.row-clone').length;
            if ($row_count == 1) {
                $('.remove-row', $init).hide();
            } else {
                $('.remove-row', $init).show();
            }
        },
        render_row: function (table) {
            var $init = $(table);
            var no = 0;
            $.each($('.data-row', $init).children('.row-clone'), function () {
                no++;
                $('.no', this).html(no);
                $('.remove-row', this).attr('data-row', no);
                $('.remove-row', this).attr('id', 'remove-row-' + no);
            });
            my_table_dokumen_idp.render_remove(table);
        },
    };

    var my_table_dokumen_situ = {
        append: function (table) {
            var $init = $(table);
            var $clone = $('[data-table="' + table + '"]').children('.row-clone').clone();
            $('.data-row', $init).append($clone);

            my_table_dokumen_situ.render_row(table);
        },
        remove: function (table, index) {
            var $init = $(table);
            $('#' + index, $init).closest('.row-clone').remove();

            my_table_dokumen_situ.render_row(table);
        },
        render_remove: function (table) {
            var $init = $(table);
            var $row_count = $('.data-row', $init).children('.row-clone').length;
            if ($row_count == 1) {
                $('.remove-row', $init).hide();
            } else {
                $('.remove-row', $init).show();
            }
        },
        render_row: function (table) {
            var $init = $(table);
            var no = 0;
            $.each($('.data-row', $init).children('.row-clone'), function () {
                no++;
                $('.no', this).html(no);
                $('.remove-row', this).attr('data-row', no);
                $('.remove-row', this).attr('id', 'remove-row-' + no);
            });
            my_table_dokumen_situ.render_remove(table);
        },
    };    

    pagefunction();
    my_table_dokumen_finance.render_row('#table-dokumen-finance');
    my_table_dokumen_others.render_row('#table-dokumen-others'); 
    my_table_dokumen_legal.render_row('#table-dokumen-legal'); 
    my_table_dokumen5.render_row('#table-dokumen5');
    my_table_dokumen4.render_row('#table-dokumen4');
    my_table_dokumen3.render_row('#table-dokumen3');
    my_table_dokumen2.render_row('#table-dokumen2');
    my_table_dokumen.render_row('#table-dokumen');
    my_table_dokumen_siup.render_row('#table-dokumen-siup');
    my_table_dokumen_idp.render_row('#table-dokumen-idp');
    my_table_dokumen_situ.render_row('#table-dokumen-situ');
    
    $(function () {
		//provinsi data
        my_form.ajax.options("provinsi_id", 'select2');
        my_form.ajax.options("kotamadya_id", 'select2', $('#kotamadya_id').data('selected'));
	
        my_form.ajax.options("provinsi_test", 'select2');
        my_form.ajax.options("kotamadya_test", 'select2', $('#kotamadya_test').data('selected'));
        $('#provinsi_test').change(function () {
            my_form.ajax.options("provinsi_test", 'select2');
        });
	
        $('#provinsi_first').change(function () {
            my_form.ajax.options("provinsi_first", 'select2');
        });
	
        $('#provinsi_id').change(function () {
            my_form.ajax.options("provinsi_id", 'select2');
        });
        $('#kotamadya_id').change(function () {
            my_form.ajax.options("kotamadya_id");
        });
	
		//golongan data
        my_form.ajax.options("golongan_id", 'select2');
        my_form.ajax.options("bidang_id", 'select2', $('#bidang_id').data('selected'));
        my_form.ajax.options("golongan_first", 'select2');
        my_form.ajax.options("bidang_first", 'select2', $('#bidang_id').data('selected'));
        
        <?php if (!empty($data_edit->bidangsub)) { ?>
        $('#bidang_id').attr('radonly');
        <?php }else{ ?>
        $('#bidang_id').attr('disabled', 'disabled');
        <?php } ?>

        $('#golongan_id').change(function () {
            my_form.ajax.options("golongan_id", 'select2');
            $('#bidang_id').removeAttr('disabled');
        });
        $('#bidang_id').change(function () {
            my_form.ajax.options("bidang_id");
        });
        $('#golongan_first').change(function () {
            my_form.ajax.options("golongan_first", 'select2');
            $('#bidang_id').removeAttr('disabled');
        });
        $('#bidang_first').change(function () {
            my_form.ajax.options("bidang_first");
        });

    });

    var form_submit = function () 
    {

    	var nama_perusahaan = $('#nama_perusahaan').val();
 		var sub_category = $('#sub_category').val();
 		var contact_person = $('#contact_person').val();
 		
    	var jenis = $('#jenis_perusahaan').val();
 		var nik_vendor = $('#nik_vendor').val();
		var npwp = $('#npwp').val();
 		var npwple = npwp.length;
        var niklengh = nik_vendor.length;

         	if (nama_perusahaan == null || nama_perusahaan == "") {
                    $('#nama_perusahaan').css('border','1px solid red');
                    $('#nama_perusahaan').focus();
                  
                      return false;
            }else{
                        $('#nama_perusahaan').css('border','1px solid #E5E5E5' );
                        $('.errornpwp').css('display', 'none');
            }

            if (sub_category == null || sub_category == "") {
                    $('#sub_category').css('border','1px solid red');
                    $('#sub_category').focus();
                    
                      return false;
            }else{
                    $('#npwp').css('border','1px solid #E5E5E5' );
                    $('.sub_category').css('display', 'none');
            }


            if (contact_person == null || contact_person == "") {
                    $('#contact_person').css('border','1px solid red');
                    $('#contact_person').focus();
                    
                      return false;
            }else{
                        $('#contact_person').css('border','1px solid #E5E5E5' );
                        $('.errornpwp').css('display', 'none');
            }


    	 	if (jenis == 1) {
                    if (npwp == null || npwp == "") {
                    $('#npwp').css('border','1px solid red');
                    $('#npwp').focus();
                    $('.errornpwp').html('NPWP !!! Tidak boleh Kosong')
                      return false;
                    }else{
                        $('#npwp').css('border','1px solid #E5E5E5' );
                        $('.errornpwp').css('display', 'none');
                    }

                    if(npwple < 15){
                      $('#npwp').css('border','1px solid red');
                      $('#npwp').focus();
                       $('.errornpwp').css('display', 'block');
                      $('.errornpwp').html('ooppss !!! jumlah angka npwp lebih dari 15 digit angka, anda baru memasukan '+npwple+' angka ')
                        return false;
                     
                    }else{
                         $('#npwp').css('border','1px solid #E5E5E5' );
                        $('.errornpwp').css('display', 'none');
                      
                    }

                      my_form.submit('#finput');
            }else{
            	 if (nik_vendor == null || nik_vendor == "") {
                    $('#nik_vendor').css('border','1px solid red');
                    $('#nik_vendor').focus();
                    $('.errornik').html('NIK !!! Tidak boleh Kosong')
                      return false;
                    }else{
                        $('#nik_vendor').css('border','1px solid #E5E5E5' );
                        $('.errornik').css('display', 'none');
                    }


                    if(niklengh < 16){
                      $('#nik_vendor').css('border','1px solid red');
                      $('#nik_vendor').focus();
                      $('.errornik').css('display', 'block');
                      $('.errornik').html('ooppss !!! jumlah angka NIK tidak sesuai, jumlah nik adalah 16 digit angka, anda baru memasukan '+niklengh+' angka ');
                        return false;
                     
                    }else{
                         $('#errornik').css('border','1px solid #E5E5E5' );
                        $('.errornik').css('display', 'none');
                      
                    }

                    // if (npwp == null || npwp == "") {
                    //   $('#npwp').css('border','1px solid red');
                    //   $('#npwp').focus();
                    //   $('.errornpwp').html('NPWP !!! Tidak boleh Kosong');
                    //     return false;
                    // }else{
                    //   $('#npwp').css('border','1px solid #E5E5E5' );
                    //   $('.errornpwp').css('display', 'none');
                    // }
                    // // console.log(npwple)

                    // if(npwple < 15){
                    //   $('#npwp').css('border','1px solid red');
                    //   $('#npwp').focus();
                    //    $('.errornpwp').css('display', 'block');
                    //   $('.errornpwp').html('ooppss !!! jumlah angka npwp lebih dari 15 digit angka, anda baru memasukan '+npwple+' angka ');
                    //     return false;
                     
                    // }else{
                    //   $('#npwp').css('border','1px solid #E5E5E5' );
                    //   $('.errornpwp').css('display', 'none');
                      
                    // }
                      my_form.submit('#finput');
        	}

	      
	        validasi_step();
    };

    function validasi_step() 
    {
        $.each($('#steps li[data-step]'), function() {
              var _step = $(this).data('step');

              check_error = $('[data-step="'+_step+'"]').find('.has-error').length;
              if(check_error) {
                $(this).removeClass('complete');
                $(this).find('.badge').removeClass('bg-color-green').addClass('bg-color-red');
              } else {
                $(this).addClass('complete');
                $(this).find('.badge').removeClass('bg-color-red').addClass('bg-color-green');
              }

        });
    };

    function penilaian(){
    	var specification =  $('.specification').val();
    	if (specification == '') {
    		specification = 0;
    	}

    	var on_time =  $('.on_time').val();
    	if (on_time == '') {
    		on_time = 0;
    	}
    	var competitive_price =  $('.competitive_price').val();
    	if (competitive_price == '') {
    		competitive_price = 0;
    	}
    	var term_pay =  $('.term_pay').val();
    	if (term_pay == '') {
    		term_pay = 0;
    	}
    	var communication =  $('.communication').val();
    	if (communication == '') {
    		communication = 0;
    	}
    	var documentation =  $('.documentation').val();
    	if (documentation == '') {
    		documentation = 0;
    	}
    	var smkl =  $('.smkl').val();
    	if (smkl == '') {
    		smkl = 0;
    	}

    	var hasil  =  parseFloat(specification) +  parseFloat(on_time) +  parseFloat(competitive_price) +  parseFloat(term_pay) +  parseFloat(communication) +  parseFloat(documentation) +  parseFloat(smkl) ;

    	var hasill = Math.round(hasil * 100) / 100;
    	if (hasill <= 10 ) {
    		var ranking = 'D';
    	}else if(hasill <= 17 ){
    		var ranking = 'C';
    	}else if(hasill <= 24 ){
    		var ranking = 'B';
    	}else if(hasill <= 28 ){
    		var ranking = 'A';
    	}

    	$('.total').val(hasill);
    	$('.ranking').val(ranking);



    }

</script>