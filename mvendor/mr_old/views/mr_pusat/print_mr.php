<!DOCTYPE html>
<html>
<head>

<style type="text/css">
  
  .content {
    margin-left: 1cm;     
  }

  .data {
    margin-left: 1cm;   
  }

  .content p {
    line-height: 6px;
  }

  .pull-right {
    float: right !important;
  }
  .pull-left {
    float: left !important;
  }

  .tbl_ttd{
  	border-spacing: 0px;
  	border-collapse: collapse;
  }

  .tbl_ttd tr td{
  	border: 1px solid black;
  	border-spacing: 0px;
  	 border-collapse: collapse;
  	padding:2px !important;
  	margin: 0px !important; 

  }
  .tbl-head-ttd tr td{
  	border: none;
  	padding:0px !important;
  	margin: 0px !important; 
  }

  .table {

    font-family: verdana,arial,sans-serif;
    font-size:11px;

    border-collapse: collapse;
      border: 1px solid black;
    
    -moz-border-radius-bottomleft:0px;
    -webkit-border-bottom-left-radius:0px;
    border-bottom-left-radius:0px;
    
    -moz-border-radius-bottomright:0px;
    -webkit-border-bottom-right-radius:0px;
    border-bottom-right-radius:0px;
    
    -moz-border-radius-topright:0px;
    -webkit-border-top-right-radius:0px;
    border-top-right-radius:0px;
    
    -moz-border-radius-topleft:0px;
    -webkit-border-top-left-radius:0px;
    border-top-left-radius:0px;
  }

  .table td, th{
      border: 1px solid black;
      padding: 5px 5px;
  }

  .body {
    padding: 12px 20px 15px 20px;
    background-color: #fff;
  }
  .image-header{
  	height: 90px;
  }
  .header{
  	padding-left:40px;
  }
	.kiri{
		width:50%;
		height:130px;
		/*background-color:#FF0;*/
		float:left;
	}
	.kanan{
		width:50%;
		height:130px;
		/*background-color:#0C0;*/
		float:right;
	}
	.kiri-1{
		width:30%;
		height:130px;
		/*background-color:#FF0;*/
		float:left;
	}
	.kiri-2{
		width:70%;
		height:130px;
		/*background-color:#0C0;*/
		float:right;
	}
	.kanan-1{
		width:50%;
		height:130px;
		/*background-color:#FF0;*/
		float:left;
	}
	.kanan-2{
		width:50%;
		height:130px;
		/*background-color:#0C0;*/
		float:right;
		position:relative;
	}
	.titik-header{
		padding-left: 22px;
	}
	.clear{
		display: block;
		clear: both;
	}

	.kanan-atas, .kanan-bawah {
	    position:absolute;
	}
	.kanan-atas{
		top: 0;
		text-align: right;

		padding-bottom: 80px
	}
	.kanan-bawah{
		bottom: 0;
		text-align: right;
		font-size: 16px;
		font-weight: bold;
	}

  </style>
</head>
<body class="body">
   
    <!-- <htmlpageheader name="MyHeader"> -->
    	<div class="header">
    		<div class="kiri">
			<div class="kiri-1">
				<img class="image-header" src="<?php echo base_url() ?>assets/img/theme/logo-kaltim-white.png">
			</div>
			<div class="kiri-2">




				<div style="font-weight: bold; font-size: 18px;">PT CITRA PANJI MANUNGGAL</div>
	    		<div style="padding-left: 0px;">Jl. Ciputat Raya No. 16, Kebayoran Lama Selatan,</div>
	    		<div style="padding-left: 0px;">Jakarta Selatan 12240, Indonesia</div>
	    		<div style="padding-left: 0px;">Ph: 021-7653723 <br>Fx: 021-7658806</div>
	    		<div style="padding-left: 0px; padding-top: 12px; font-size: 12px">DATE REQUIRED : <?php echo $data->tanggal_buat_mr ?></td></div>
	    	</div>
    			
    		</div>
			<div class="kanan">
				<div class="kanan-1">
					<!-- <div style="font-size: 12px;font-weight: bold">NAME OF PROJECT <b class="titik-header">:</b></div>
					<div style="font-size: 12px;font-weight: bold">REQUISITION NUMBER <b class="titik-header">:</b></div>
					<div style="font-size: 12px;font-weight: bold">DATE<b class="titik-header">:</b></div> -->
					<table  style="font-size: 12px;font-weight: bold">
						<tr>
							<td>NAME OF PROJECT</td>
							<td>:</td>
							<td><?php echo $data->nama_proyek ?></td>
						</tr>
						<div class="clear"></div>
						<tr>
							<td>REQUISITION NUMBER</td>
							<td>:</td>
							<td><?php echo $data->kode_mr ?></td>
						</tr>
						<div class="clear"></div>

						<tr>
							<td>DATE</td>
							<td>:</td>
							<td><?php echo $data->tanggal_buat_mr ?></td>
						</tr>
					</table>

				</div>
				<div class="kanan-2">
					<div class="kanan-atas">

						<!-- <?php // $image = json_decode($logo_tuv->image) ?> -->
 							<img src="<?php echo $image[0]->file ?>" alt="..." width="150px;"> 
					</div>
					<div class="kanan-bawah">MATERIAL REQUISITION</div>
				</div>
			</div>
			
    	</div>       
    <!-- </htmlpageheader> -->
	<div class="content">
		<table class="table" width="100%" style="font-size: 9px !important">
		      <thead>
		          <tr>
		              <th style="color: #000;text-align: left; border-bottom: hidden;padding: 2px 20px;" colspan="5">EQUIPMENT OR MATERIAL GROUP <?php echo $data->nama_permintaan ?></th>
		              <th style="color: #000;text-align: left; border-bottom: hidden;padding: 2px 20px" colspan="5"></th>
		          </tr>
		          <tr>
		              <th style="color: #000;text-align: left;padding: 2px 20px" colspan="5">(GIVE MODEL & SERIAL NO)</th>
		              <th style="color: #000;text-align: center;padding: 2px 20px" colspan="5">THIS AREA FOR MATERIALSMAN USE ONLY</th>
		          </tr>
		          <tr>
		              <th style="color: #000" width="3%">NO</th>
		              <th style="color: #000" width="18%">DESCRIPTION</th>
		              <th style="color: #000" width="8%">Size</th>
		              <th style="color: #000" width="6%">QTY</th>
		              <th style="color: #000" width="8%">UNIT</th>
		              <th style="color: #000" width="8%">PART NUMBER</th>
		              <th style="color: #000" width="10%">UNIT COST</th>
		              <th style="color: #000" width="10%">TOTAL COST</th>
		              <th style="color: #000" width="8%">ON ORDER</th>
		              <th style="color: #000">MATERIALSMAN NOTATION</th>
		          </tr>
		      </thead>
		      <tbody>
		      <?php $no=1; foreach ($table as $value) { ?>
		          <tr>
		          	  <td style="color: #000" ><?php echo $no++ ?></td>
		          	  <td style="color: #000" width="25%"><?php echo $value->description ?><br><?php echo $value->desc_detail ?></td>
		          	   <td style="color: #000" width="8%"><?php echo $value->size ?></td>
		              <td style="color: #000;text-align: center" width="3%"><?php echo $value->quantity ?></td>
		              <td style="color: #000;text-align: center" width="6%"><?php echo $value->unit ?></td>
		              <td style="color: #000;text-align: center" width="5%"><?php echo $value->part_number ?></td>
		              <td style="color: #000;text-align: right" width="10%" ><?php echo $value->currency ?> <?php echo number_format($value->unit_cost) ?></td>
		              <td style="color: #000;text-align: right" width="10%"><?php echo $value->currency ?> <?php echo number_format($value->total_cost) ?></td>
		              <td style="color: #000" width="8%"><?php echo $value->on_order ?></td>
		              <td style="color: #000"></th>
		          </tr>
		      <?php } ?>
					<tr>
						<td style="color: #000;text-align: left; border-bottom: hidden;padding: 2px 20px;" colspan="5">NOTE :</td>
						<td style="color: #000;text-align: left; border-bottom: hidden;padding: 2px 20px" colspan="5"><!-- SPECIAL INTRUCTION --></td>
					</tr>
					<tr>
						<td style="color: #000;text-align: left;padding: 2px 20px" colspan="5"><?php echo $data->note ?></td>
						<td style="color: #000;text-align: left;padding: 2px 20px" colspan="5"><!-- INDICATE IF CONFIRMING A PHONE OR RADIO ORDER -->
							
						</td>
					</tr>
					<tr>
						<td style="color: #000;text-align: left; border-bottom: hidden; border-top: hidden;padding: 2px 20px;" colspan="5"><!-- RECHARGE TO --></td>
						<td style="color: #000;text-align: left; border-bottom: hidden; border-top: hidden;padding: 2px 20px" colspan="5"></td>
					</tr>
					<tr>
						<td style="color: #000;text-align: left;padding: 2px 20px" colspan="5"><!-- OBTAIN COMPANY --></td>
						<td style="color: #000;text-align: left;border-bottom: hidden;padding: 2px 20px"  colspan="5" valign="top">
						
							
						 </td>
					<!-- 	<td style="color: #000;text-align: left;padding: 2px 20px" colspan="2"></td>
						<td style="color: #000;text-align: left;border: hidden;padding: 2px 20px">APPROVED BY SITE MANAGER</td>
						<td style="color: #000;text-align: left;padding: 2px 20px"></td> -->

					</tr>
					<tr>
						<td style="color: #000;text-align: left;border-top: hidden;padding: 2px 20px" colspan="5"><!-- REPRESENTATIVES SIGNATURE HERE --></td>
						
						<td  colspan="5" style="color: #000;text-align: left; border-bottom: hidden;border-top: hidden;padding: 2px 19px">
						<table class="tbl-head-ttd">
							<tr>
							<td >
								<table class="tbl_ttd" width="100%" style="margin-right: 10px;"> 
									<tr>
										<td>REQUISITIONED BY</td>
										<td rowspan="2"> <img class="image-check" width="20px" src="<?php echo base_url() ?>assets/img/check-print.png"></td>
									</tr>
									<tr><td><?php echo $name_request->pegawai_nama ?><br><?php echo $name_request->nama_role ?></td></tr>

								</table>
							</td>
							<?php if ($status_approve == 1) { ?>
								<?php foreach ($data_app as $key => $valuee) { ?>
								<td>
									<table width="90%" class="tbl_ttd">
										<tr>
											<td>APPROVED BY</td>
											<td rowspan='2'><img width="20px" class="image-check" src="<?php echo base_url() ?>assets/img/check-print.png"></td>
										</tr>
										<tr><td><?php echo $valuee->pegawai_nama ;?><br><?php echo $valuee->jabatan_nama ?></td></tr>
									</table>
								</td>
							 <?php } ?>
							<?php } ?>
							
							</tr>
						</table>
							
						</td>
					<!-- 	<td style="border: hidden;" colspan="1">
							<img class="image-check" width="20px" src="<?php //echo base_url() ?>assets/img/check-print.png">
						</td> -->
						<!-- <td style="color: #000;text-align: left;border: hidden;padding: 2px 20px">APPROVED BY<br> GEN MANAGER</td>
						<td style="color: #000;text-align: left;padding: 2px 20px"></td> -->
					
					</tr>
					<tr>
						<td style="color: #000;text-align: left;border-top: hidden;padding: 2px 20px; height: 9px" colspan="5"></td>
						<td style="color: #000;text-align: left;padding: 2px 20px" colspan="5"></td>
					</tr>
					<tr>
						<td style="color: #000;text-align: left;padding: 2px 20px;border-top: hidden; " colspan="5">
						<!-- PURCHASE INTRUCTION 
							( LP<input name="LP" value=<?php// echo $data->purchase_instruction == 'LP' ? 'X':'';?> style="width: 15px;text-align: center;"></input>
							 JKT<input name="JKT" value=<?php //echo $data->purchase_instruction == 'JKT' ? 'X':'';?> style="width: 15px;text-align: center;"></input> 
							 OR OTHER<input name="OTHER" value=<?php// echo $data->purchase_instruction == 'OTHER' ? 'X':'';?> style="width: 15px;text-align: center;"></input> ) -->
						</td>
						<td style="color: #000;text-align: left;padding: 2px 20px;border-top: hidden;" colspan="5">
						<!-- SHIPPING INTRUCTION
							( ROAD<input name="ROAD" value=<?php // echo $data->shipping_instruction == 'ROAD' ? 'X':'';?> style="width: 15px;text-align: center;"></input> 
							OR OFF<input name="OFF" value=<?php// echo $data->shipping_instruction == 'OFF' ? 'X':'';?> style="width: 15px;text-align: center;"></input> 
							OFS<input name="OFS" value=<?php //echo $data->shipping_instruction == 'OFS' ? 'X':'';?> style="width: 15px;text-align: center;"></input> 
							AF<input name="AF" value=<?php// echo $data->shipping_instruction == 'AF' ? 'X':'';?> style="width: 15px;text-align: center;"></input> 
							UAF<input name="UAF" value=<?php //echo $data->shipping_instruction == 'UAF' ? 'X':'';?> style="width: 15px;text-align: center;"></input> ) -->
						</td>
					</tr>
					
		     
		      </tbody>
		</table>
	</div>

    <htmlpagefooter name="MyFooter">
        <table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt; 
            color: #000000; font-weight: bold; font-style: italic;" border="0"><tr>
            <td width="33%"><span style="font-weight: bold; font-style: italic;"></span></td>
            <td  align="right" style="font-weight: bold; font-style: italic;">This Document Original And Approved By System E-PROC PT. CPM</td>
            </tr></table>
    </htmlpagefooter>

  <sethtmlpagefooter name="MyFooter" value="on"/>
  <setpageheader name="MyHeader" show-this-page="1"/>
  
</body>
</html>


