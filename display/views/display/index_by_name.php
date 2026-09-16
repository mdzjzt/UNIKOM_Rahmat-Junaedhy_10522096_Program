<!DOCTYPE html>
<html>
<head>
	<title>SIMBADA - MONITORING</title>


	<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/favicon.ico">
	<style type="text/css">
		body {
			margin: 0px;
			padding: 0px;
			font-family: arial;
			background: rgba(46,78,132,1);			
		}

		.header {
			width: 100%;
			height: 100px;			
		}

		.header_logo {
			margin: 20px 0 0 20px;
		}

		.header_title {
			float:right;
			color: #FFF;
			font-size: 38px;
			font-weight: bold;
			padding: 30px 20px 0 0;
		}

		.table_data {
			width: 100%;
			color: #C0D5F5;
		}

		.table_data th {
			text-align: center;
			color:#FFF;
			border-top: 1px #0A204F solid;
			border-bottom: 1px #0A204F solid;	
			padding: 10px;
			font-size:16px;
			background-color: #213C71;
		}

		.table_data td {
			font-size:20px;			
			padding: 10px 0px 10px 10px;
		}

		.tr_color {
			background-color: #4B6396;
		}

		.tr_alert {
			color:red;
		}

		.td_center {
			text-align: center;
		}

		/* vertical marquee */
		.container {
		    width: 100%;
		    height: 900px;
		    overflow: hidden;
		    position: relative;
		    box-sizing: border-box;
		}

		.marquee {
		    top: 6em;
		    height: auto;
		    position: relative;
		    box-sizing: border-box;
		    animation: marquee 15s linear infinite;
		    marquee-speed: fast;
		    -webkit-marquee-speed: fast;
		}

		.marquee:hover {
		    animation-play-state: paused
		}

		/* Make it move! */
		@keyframes marquee {
		    0%  {
			    	transform:translateY(0);
			  	}			
			100%{
			    	transform:translateY(-100%);
			  	}
		}
	</style>

	<script src="<?php echo base_url(); ?>assets/libs/jquery.min.js"></script>
</head>
<body>
	<div class="header">
		<div class="header_title">SIMBADA - MONITORING</div>
		<div class="header_logo">
			<img src="<?php echo base_url(); ?>assets/img/theme/logo-kaltim-white.png" width="250px">
		</div>		
	</div>
	<div class="frame_data">
		<table class="table_data" cellspacing="0" cellpadding="3px" border="0">
			<tr>
				<th width="700px">UNIT KERJA PEMOHON</th>
				<th width="1000px">NAMA PERMINTAAN</th>
				<th width="250px">TGL PERMINTAAN</th>
				<th>NAMA YANG DITUGASKAN</th>
			</tr>
		</table>
		<div id="content_table"class="container">
			<div class="tr_color">
				<div class="td_center">Tidak ada data yang ditampilkan</td>
			</div>
		</div>		
	</div>

<script type="text/javascript">

	$(function(){
        show_data();

        setInterval(function(){
        	show_loading();
	        $.get('<?php echo base_url(); ?>display/data_by_name', function(data) {
	            $('#content_table').html(data);
	            $('#content_table').append(data);
	        });
        }, 1800000);
    });

    function show_loading() {
        $('#content_table').html('<tr class="tr_color"><td class="td_center" colspan="5">loading...</td></tr>');
    }

    function show_data() {     
        show_loading();
        $.get('<?php echo base_url(); ?>display/data_by_name', function(data) {
            $('#content_table').html(data);
        });
    }     

</script>

</body>
</html>