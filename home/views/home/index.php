
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* =========================================================
   REKAP DATA
   ========================================================= */

$total_permintaan = 0;
$total_approved   = 0;
$total_pending    = 0;
$total_ditolak    = 0;

if (isset($rekap_jenis) && is_object($rekap_jenis)) {
    $rekap_jenis = $rekap_jenis->result();
}

if (isset($rekap_jenis) && is_array($rekap_jenis)) {

    foreach ($rekap_jenis as $row) {

        $total_permintaan += isset($row->total)
            ? (int)$row->total : 0;

        $total_approved += isset($row->approved)
            ? (int)$row->approved : 0;

        $total_pending += isset($row->pending)
            ? (int)$row->pending : 0;

        $total_ditolak += isset($row->nonapproved)
            ? (int)$row->nonapproved : 0;
    }
}


/* =========================================================
   BULAN
   ========================================================= */

$bulan_label = array(
    1  => 'Jan',
    2  => 'Feb',
    3  => 'Mar',
    4  => 'Apr',
    5  => 'Mei',
    6  => 'Jun',
    7  => 'Jul',
    8  => 'Agu',
    9  => 'Sep',
    10 => 'Okt',
    11 => 'Nov',
    12 => 'Des'
);


/* =========================================================
   DATA BULANAN
   ========================================================= */

$chart_approved = array_fill(1, 12, 0);
$chart_pending  = array_fill(1, 12, 0);
$chart_ditolak  = array_fill(1, 12, 0);

$tahun_sekarang = date('Y');

if (isset($data_bulan) && is_array($data_bulan)) {

    foreach ($data_bulan as $bulan => $tahun_data) {

        if (isset($tahun_data[$tahun_sekarang])) {

            $dt = $tahun_data[$tahun_sekarang];

            $chart_approved[(int)$bulan] =
                isset($dt->approved)
                ? (int)$dt->approved
                : 0;

            $chart_pending[(int)$bulan] =
                isset($dt->pending)
                ? (int)$dt->pending
                : 0;

            $chart_ditolak[(int)$bulan] =
                isset($dt->nonapproved)
                ? (int)$dt->nonapproved
                : 0;
        }
    }
}


/* =========================================================
   DATA TAHUN
   ========================================================= */

$year_label    = array();
$year_total    = array();
$year_approved = array();
$year_pending  = array();

if (isset($data_tahun) && is_array($data_tahun)) {

    foreach ($data_tahun as $row) {

        $year_label[] =
            isset($row->year) ? $row->year : '';

        $year_total[] =
            isset($row->total) ? (int)$row->total : 0;

        $year_approved[] =
            isset($row->approved) ? (int)$row->approved : 0;

        $year_pending[] =
            isset($row->pending) ? (int)$row->pending : 0;
    }
}


/* =========================================================
   PAYMENT
   ========================================================= */

$payment_label = array();
$payment_data  = array();

if (isset($payment_year) && is_array($payment_year)) {

    foreach ($payment_year as $row) {

        $payment_label[] =
            isset($row->year) ? $row->year : '';

        $payment_data[] =
            isset($row->total) ? (int)$row->total : 0;
    }
}

?>


<style>

.dashboard-content {
    width: 100%;
    font-family: Arial, Helvetica, sans-serif;
    color: #273142;
}

/* =========================================================
   HEADER DASHBOARD
   ========================================================= */

.dashboard-content .dashboard-title {
    margin-bottom: 25px;
}

.dashboard-content .dashboard-title h2 {
    margin: 0 0 6px;
    font-size: 25px;
    font-weight: 600;
}

.dashboard-content .dashboard-title p {
    margin: 0;
    color: #8b95a7;
    font-size: 13px;
}


/* =========================================================
   STAT CARD
   ========================================================= */

.dashboard-content .stat-card {
    position: relative;
    background: #ffffff;
    border: 1px solid #edf0f4;
    border-radius: 12px;
    padding: 22px;
    margin-bottom: 22px;
    min-height: 135px;
    box-shadow: 0 4px 14px rgba(0,0,0,.04);
    overflow: hidden;
}

.dashboard-content .stat-icon {
    position: absolute;
    right: 20px;
    top: 20px;

    width: 48px;
    height: 48px;

    border-radius: 10px;

    text-align: center;
    line-height: 48px;

    font-size: 19px;
}

.dashboard-content .blue {
    background: #edf4ff;
    color: #3978e8;
}

.dashboard-content .green {
    background: #eaf8f0;
    color: #28a745;
}

.dashboard-content .yellow {
    background: #fff7df;
    color: #e5a400;
}

.dashboard-content .red {
    background: #fff0f0;
    color: #d9534f;
}

.dashboard-content .stat-label {
    color: #8b95a7;
    font-size: 12px;
    margin-bottom: 8px;
}

.dashboard-content .stat-number {
    font-size: 28px;
    font-weight: 600;
    color: #202938;
    margin-bottom: 7px;
}

.dashboard-content .stat-desc {
    font-size: 11px;
    color: #a2a9b5;
}


/* =========================================================
   PANEL
   ========================================================= */

.dashboard-content .dash-panel {
    background: #ffffff;
    border: 1px solid #edf0f4;
    border-radius: 12px;
    margin-bottom: 22px;
    box-shadow: 0 4px 14px rgba(0,0,0,.04);
}

.dashboard-content .dash-panel-head {
    padding: 20px 20px 5px;
}

.dashboard-content .dash-panel-title {
    font-size: 15px;
    font-weight: 600;
}

.dashboard-content .dash-panel-desc {
    margin-top: 5px;
    color: #9aa3b1;
    font-size: 11px;
}

.dashboard-content .dash-panel-body {
    padding: 15px 20px 20px;
}


/* =========================================================
   STATUS
   ========================================================= */

.dashboard-content .status-row {
    margin-bottom: 23px;
}

.dashboard-content .status-row:last-child {
    margin-bottom: 0;
}

.dashboard-content .status-head {
    margin-bottom: 8px;
    font-size: 12px;
}

.dashboard-content .status-number {
    float: right;
    font-weight: 600;
}

.dashboard-content .progress {
    height: 7px;
    margin-bottom: 0;
    background: #eef1f5;
    border-radius: 10px;
    box-shadow: none;
}

.dashboard-content .progress-bar {
    border-radius: 10px;
}

.dashboard-content .progress-approved {
    background: #28a745;
}

.dashboard-content .progress-pending {
    background: #f0ad00;
}

.dashboard-content .progress-rejected {
    background: #d9534f;
}


/* =========================================================
   TABLE
   ========================================================= */

.dashboard-content .dashboard-table {
    width: 100%;
    border-collapse: collapse;
}

.dashboard-content .dashboard-table th {
    padding: 11px 8px;
    border-bottom: 1px solid #edf0f4;
    color: #8993a4;
    font-size: 10px;
    text-transform: uppercase;
}

.dashboard-content .dashboard-table td {
    padding: 13px 8px;
    border-bottom: 1px solid #f1f3f6;
    font-size: 12px;
}

.dashboard-content .dashboard-table tr:last-child td {
    border-bottom: none;
}

.dashboard-content .badge {
    padding: 5px 8px;
    border-radius: 20px;
    font-size: 10px;
}

.dashboard-content .badge-approved {
    background: #eaf8f0;
    color: #28a745;
}

.dashboard-content .badge-pending {
    background: #fff7df;
    color: #d49a00;
}

.dashboard-content .badge-rejected {
    background: #fff0f0;
    color: #d9534f;
}


/* =========================================================
   RESPONSIVE
   ========================================================= */

@media(max-width: 767px) {

    .dashboard-content .dashboard-title h2 {
        font-size: 21px;
    }

    .dashboard-content .dash-panel-body {
        padding: 12px;
    }

}

</style>


<div class="dashboard-content">


    <!-- =====================================================
         JUDUL
         ===================================================== -->

    <div class="dashboard-title">

        <h2>Dashboard</h2>

        <p>
            Ringkasan informasi permintaan dan aktivitas sistem
        </p>

    </div>


    <!-- =====================================================
         STATISTIK
         ===================================================== -->

    <div class="row">


        <div class="col-md-3 col-sm-6">

            <div class="stat-card">

                <div class="stat-icon blue">
                    <i class="fa fa-file-text-o"></i>
                </div>

                <div class="stat-label">
                    Total Permintaan
                </div>

                <div class="stat-number">
                    <?php echo number_format($total_permintaan); ?>
                </div>

                <div class="stat-desc">
                    Seluruh permintaan
                </div>

            </div>

        </div>


        <div class="col-md-3 col-sm-6">

            <div class="stat-card">

                <div class="stat-icon green">
                    <i class="fa fa-check"></i>
                </div>

                <div class="stat-label">
                    Approved
                </div>

                <div class="stat-number">
                    <?php echo number_format($total_approved); ?>
                </div>

                <div class="stat-desc">
                    Permintaan disetujui
                </div>

            </div>

        </div>


        <div class="col-md-3 col-sm-6">

            <div class="stat-card">

                <div class="stat-icon yellow">
                    <i class="fa fa-clock-o"></i>
                </div>

                <div class="stat-label">
                    Pending
                </div>

                <div class="stat-number">
                    <?php echo number_format($total_pending); ?>
                </div>

                <div class="stat-desc">
                    Menunggu persetujuan
                </div>

            </div>

        </div>


        <div class="col-md-3 col-sm-6">

            <div class="stat-card">

                <div class="stat-icon red">
                    <i class="fa fa-times"></i>
                </div>

                <div class="stat-label">
                    Ditolak
                </div>

                <div class="stat-number">
                    <?php echo number_format($total_ditolak); ?>
                </div>

                <div class="stat-desc">
                    Permintaan ditolak
                </div>

            </div>

        </div>


    </div>


    <!-- =====================================================
         GRAFIK BULAN + STATUS
         ===================================================== -->

    <div class="row">


        <div class="col-md-8">

            <div class="dash-panel">

                <div class="dash-panel-head">

                    <div class="dash-panel-title">
                        Statistik Permintaan
                    </div>

                    <div class="dash-panel-desc">
                        Perkembangan permintaan berdasarkan bulan
                    </div>

                </div>

                <div class="dash-panel-body">

                    <canvas id="chartPermintaan"
                            height="120"></canvas>

                </div>

            </div>

        </div>


        <div class="col-md-4">

            <div class="dash-panel">

                <div class="dash-panel-head">

                    <div class="dash-panel-title">
                        Status Permintaan
                    </div>

                    <div class="dash-panel-desc">
                        Persentase status permintaan
                    </div>

                </div>

                <div class="dash-panel-body">


                    <?php

                    $persen_approved = 0;
                    $persen_pending  = 0;
                    $persen_ditolak  = 0;

                    if ($total_permintaan > 0) {

                        $persen_approved =
                            ($total_approved / $total_permintaan) * 100;

                        $persen_pending =
                            ($total_pending / $total_permintaan) * 100;

                        $persen_ditolak =
                            ($total_ditolak / $total_permintaan) * 100;
                    }

                    ?>


                    <div class="status-row">

                        <div class="status-head">

                            Approved

                            <span class="status-number">
                                <?php echo $total_approved; ?>
                            </span>

                        </div>

                        <div class="progress">

                            <div class="progress-bar progress-approved"
                                 style="width: <?php echo $persen_approved; ?>%;">
                            </div>

                        </div>

                    </div>


                    <div class="status-row">

                        <div class="status-head">

                            Pending

                            <span class="status-number">
                                <?php echo $total_pending; ?>
                            </span>

                        </div>

                        <div class="progress">

                            <div class="progress-bar progress-pending"
                                 style="width: <?php echo $persen_pending; ?>%;">
                            </div>

                        </div>

                    </div>


                    <div class="status-row">

                        <div class="status-head">

                            Ditolak

                            <span class="status-number">
                                <?php echo $total_ditolak; ?>
                            </span>

                        </div>

                        <div class="progress">

                            <div class="progress-bar progress-rejected"
                                 style="width: <?php echo $persen_ditolak; ?>%;">
                            </div>

                        </div>

                    </div>


                </div>

            </div>

        </div>


    </div>


    <!-- =====================================================
         GRAFIK TAHUN
         ===================================================== -->

    <div class="row">

        <div class="col-md-12">

            <div class="dash-panel">

                <div class="dash-panel-head">

                    <div class="dash-panel-title">
                        Perkembangan Tahunan
                    </div>

                    <div class="dash-panel-desc">
                        Perbandingan total permintaan setiap tahun
                    </div>

                </div>

                <div class="dash-panel-body">

                    <canvas id="chartTahunan"
                            height="90"></canvas>

                </div>

            </div>

        </div>

    </div>


    <!-- =====================================================
         REKAP JENIS + PAYMENT
         ===================================================== -->

    <div class="row">


        <!-- REKAP JENIS -->

        <div class="col-md-7">

            <div class="dash-panel">

                <div class="dash-panel-head">

                    <div class="dash-panel-title">
                        Rekap Permintaan
                    </div>

                    <div class="dash-panel-desc">
                        Rekap berdasarkan jenis permintaan
                    </div>

                </div>

                <div class="dash-panel-body">

                    <div class="table-responsive">

                        <table class="dashboard-table">

                            <thead>

                                <tr>

                                    <th>No</th>
                                    <th>Jenis</th>
                                    <th>Total</th>
                                    <th>Approved</th>
                                    <th>Pending</th>
                                    <th>Ditolak</th>

                                </tr>

                            </thead>

                            <tbody>

                            <?php

                            if (isset($rekap_jenis) &&
                                is_array($rekap_jenis) &&
                                count($rekap_jenis) > 0):

                                $no = 1;

                                foreach ($rekap_jenis as $row):

                            ?>

                                <tr>

                                    <td>
                                        <?php echo $no++; ?>
                                    </td>

                                    <td>
                                        <?php
                                        echo htmlspecialchars(
                                            $row->permintaan_jenis
                                        );
                                        ?>
                                    </td>

                                    <td>
                                        <?php
                                        echo number_format($row->total);
                                        ?>
                                    </td>

                                    <td>

                                        <span class="badge badge-approved">

                                            <?php
                                            echo $row->approved;
                                            ?>

                                        </span>

                                    </td>

                                    <td>

                                        <span class="badge badge-pending">

                                            <?php
                                            echo $row->pending;
                                            ?>

                                        </span>

                                    </td>

                                    <td>

                                        <span class="badge badge-rejected">

                                            <?php
                                            echo $row->nonapproved;
                                            ?>

                                        </span>

                                    </td>

                                </tr>

                            <?php

                                endforeach;

                            else:

                            ?>

                                <tr>

                                    <td colspan="6"
                                        style="text-align:center;color:#999;padding:25px;">

                                        Belum ada data permintaan.

                                    </td>

                                </tr>

                            <?php endif; ?>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>


        <!-- PAYMENT -->

        <div class="col-md-5">

            <div class="dash-panel">

                <div class="dash-panel-head">

                    <div class="dash-panel-title">
                        Statistik Payment
                    </div>

                    <div class="dash-panel-desc">
                        Jumlah transaksi payment berdasarkan tahun
                    </div>

                </div>

                <div class="dash-panel-body">

                    <canvas id="chartPayment"
                            height="190"></canvas>

                </div>

            </div>

        </div>


    </div>


</div>


<!-- =========================================================
     CHART.JS
     ========================================================= -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>

/* =========================================================
   DATA DARI PHP
   ========================================================= */

var bulanDashboard =
    <?php echo json_encode(array_values($bulan_label)); ?>;

var approvedDashboard =
    <?php echo json_encode(array_values($chart_approved)); ?>;

var pendingDashboard =
    <?php echo json_encode(array_values($chart_pending)); ?>;

var ditolakDashboard =
    <?php echo json_encode(array_values($chart_ditolak)); ?>;


/* =========================================================
   GRAFIK BULANAN
   ========================================================= */

var chartPermintaan =
    document.getElementById('chartPermintaan');

if (chartPermintaan) {

    new Chart(chartPermintaan, {

        type: 'line',

        data: {

            labels: bulanDashboard,

            datasets: [

                {
                    label: 'Approved',

                    data: approvedDashboard,

                    borderColor: '#28a745',

                    backgroundColor:
                        'rgba(40,167,69,0.08)',

                    fill: true,

                    tension: 0.3
                },

                {
                    label: 'Pending',

                    data: pendingDashboard,

                    borderColor: '#f0ad00',

                    backgroundColor:
                        'rgba(240,173,0,0.08)',

                    fill: true,

                    tension: 0.3
                },

                {
                    label: 'Ditolak',

                    data: ditolakDashboard,

                    borderColor: '#d9534f',

                    backgroundColor:
                        'rgba(217,83,79,0.08)',

                    fill: true,

                    tension: 0.3
                }

            ]

        },

        options: {

            responsive: true,

            legend: {
                position: 'bottom'
            },

            scales: {

                yAxes: [

                    {

                        ticks: {
                            beginAtZero: true,
                            precision: 0
                        }

                    }

                ]

            }

        }

    });

}


/* =========================================================
   GRAFIK TAHUNAN
   ========================================================= */

var chartTahunan =
    document.getElementById('chartTahunan');

if (chartTahunan) {

    new Chart(chartTahunan, {

        type: 'bar',

        data: {

            labels:
                <?php echo json_encode($year_label); ?>,

            datasets: [

                {
                    label: 'Total',

                    data:
                        <?php echo json_encode($year_total); ?>,

                    backgroundColor:
                        'rgba(79,140,255,0.75)'
                },

                {
                    label: 'Approved',

                    data:
                        <?php echo json_encode($year_approved); ?>,

                    backgroundColor:
                        'rgba(40,167,69,0.75)'
                },

                {
                    label: 'Pending',

                    data:
                        <?php echo json_encode($year_pending); ?>,

                    backgroundColor:
                        'rgba(240,173,0,0.75)'
                }

            ]

        },

        options: {

            responsive: true,

            scales: {

                yAxes: [

                    {

                        ticks: {

                            beginAtZero: true,

                            precision: 0

                        }

                    }

                ]

            }

        }

    });

}


/* =========================================================
   GRAFIK PAYMENT
   ========================================================= */

var chartPayment =
    document.getElementById('chartPayment');

if (chartPayment) {

    new Chart(chartPayment, {

        type: 'doughnut',

        data: {

            labels:
                <?php echo json_encode($payment_label); ?>,

            datasets: [

                {

                    data:
                        <?php echo json_encode($payment_data); ?>,

                    backgroundColor: [

                        '#3978e8',
                        '#28a745',
                        '#f0ad00',
                        '#d9534f',
                        '#6f42c1',
                        '#17a2b8'
                    ]

                }

            ]

        },

        options: {

            responsive: true,

            legend: {

                position: 'bottom'

            }

        }

    });

}

</script>
```
