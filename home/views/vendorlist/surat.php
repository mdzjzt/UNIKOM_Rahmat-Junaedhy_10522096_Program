<!DOCTYPE html>
<html>
<head>

<style type="text/css">
  
  body {
   
  }
  
  .content {
    margin-left: 1cm;    
  }

  .data {
    margin-left: 1cm;    
  }

  .content p {
    line-height:20px;
  }

  .pull-right {
    float: right !important;
  }
  .pull-left {
    float: left !important;
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
      padding: 10px 20px;
  }

  </style>
</head>
<body style="font-family: centurygothic;">
   
    <htmlpageheader name="MyHeader">
       <img src="<?php echo base_url() ?>assets/img/logo/client/bankaltim.png" height="40">
    </htmlpageheader>

    <htmlpagefooter name="MyFooter">
        <table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt; 
            color: #000000; font-weight: bold; font-style: italic;" border="0"><tr>
            <td width="33%"><span style="font-weight: bold; font-style: italic;">{DATE j-m-Y}</span></td>
            <td width="33%" align="center" style="font-weight: bold; font-style: italic;">{PAGENO}/{nbpg}</td>
            <td width="33%" style="text-align: right;">  
                <img src="<?php echo base_url() ?>/uploads/barcode/vendor/NO-<?php echo $get_data_daftar_rekanan->id_vendor ?>.jpg" height="40">
            </td>
            </tr></table>
    </htmlpagefooter>

  <setpageheader name="MyHeader" show-this-page="1"/>
  <sethtmlpagefooter name="MyFooter" value="on"/>

<p align="center" style="font-weight: bold; font-size: 14pt;">SERTIFIKAT <br>
TANDA REKANAN</p>
 
  <br>

  <div class="content">
     <p style="text-align: justify">
        Dengan surat ini, dinyatakan bahwa perusahaan yang disebutkan dibawah ini :
     </p>

     <table border="0">
       <tr>
         <td style="width: 180px">Nama Perusahaan</td>
         <td>: <?php echo $data->nama_perusahaan ?></td>
       </tr>

       <tr>
         <td style="width: 180px">Alamat</td>
         <td>: <?php echo $data->alamat ?></td>
       </tr>
       <tr>
         <td style="width: 180px">Nama Pimpinan</td>
         <td>: <?php echo $data->nama_pimpinan; ?></td>
       </tr>

       </tr>
     </table>
    
     <p style="text-align: justify">
       Berdasarkan hasil verifikasi persyaratan dinyatakan memenuhi syarat untuk jenis pengadaan sebagai berikut:
     </p>

     <?php
        $bidang = $data->bidang;
        $decode_bidang = json_decode($bidang);

        $bidangsub = $data->bidangsub;
        $decode_bidangsub = json_decode($bidangsub);
        
        $nohitforid = 1;
        $takedata = '';
        
        if(count($decode_bidang)) {
          foreach ($decode_bidang as $keyas => $_bidang) {
            
            $golongan_id = $_bidang->golongan_id;
            $bidangsub = $decode_bidangsub[$keyas]->bidang_id;
            
            foreach ($option_bidang as $keyopt => $isi_optionbidang){
              if ($keyopt == $golongan_id){
                $stop = 0;
                foreach ($option_sub_bidang as $keyopt2 => $isi_optionsubbidang){
                  if ($keyopt2 == $bidangsub AND $stop == 0){
                    echo '<p>'.$nohitforid++.'.  Bidang '.$isi_optionbidang.' Sub Bidang '.$isi_optionsubbidang.' </p>';
                    $stop = 1;
                  }
                }
              }
            }
          }
        }
      ?>

      <p style="text-align: justify">
        Terhitung mulai tanggal <b><?php echo date('d F Y',strtotime($get_data_daftar_rekanan->tgl_laporan)); ?></b> sampai dengan tanggal 
        <b><?php echo date('d F Y',strtotime($get_data_daftar_rekanan->sampai_tgl_laporan)); ?></b> dengan nomer rekanan <b><?php echo $get_data_daftar_rekanan->nomor ?></b>
        Atas dasar tersebut perusahaan yang disebutkan diatas dapat mengikuti kegiatan pengadaan di dalam 
        lingkungan bankaltim dengan tetap terikat pada peraturan-peraturan yang berlaku di bankaltim.
      </p>

  </div>
 
 

   
  <div style="height: 100px"></div>
  <div class="footer">
  <p>Samarinda, <?php echo date('d F Y',strtotime($get_data_daftar_rekanan->tgl_laporan)); ?> </p>
    <br>
    <table width="100%" style="font-size: 10pt" align="center">
      <tr>
        <td></td>
        <td align="center">
            
            <p><b>Kepala bagian Umum</b></p>
            <p></p>
            <p>&nbsp;</p>
            <br><br>
            <br><br>
          <p style="font-weight: bold;"></p>
          <p> ____________________</p>
          <p><?php echo $listpegawai->pegawai_nama ?></p>
          
        </td>
      </tr>
    </table>
   </div>
</body>
</html>


