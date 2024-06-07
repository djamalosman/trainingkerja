@extends('../layouts.mainv2')

@section('headers')
<link rel="stylesheet" href="{{ asset('/') }}dist/css/mycss.css">
@endsection

@section('script')
<script src="{{ asset('/') }}plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="{{ asset('/') }}dist/js/main.js"></script>
<script src="{{ asset('/') }}plugins/chart.js/Chart.min.js"></script>

<script>
    $(function() {
        'use strict'

        var ticksStyle = {
            fontColor: '#495057',
            fontStyle: 'bold'
        }

        var mode = 'index'
        var intersect = true

        var labelDay = <?php echo json_encode($arrDay); ?>;
        var totals = <?php echo json_encode($arrMonthBefore); ?>;

        var $visitorsChart = $('#visitors-chart')
        // eslint-disable-next-line no-unused-vars        
        var visitorsChart = new Chart($visitorsChart, {
            data: {
                labels: labelDay,
                datasets: [{
                        type: 'line',

                        data: totals,
                        backgroundColor: 'transparent',
                        borderColor: '#ced4da',
                        pointBorderColor: '#ced4da',
                        pointBackgroundColor: '#ced4da',
                        fill: false
                        // pointHoverBackgroundColor: '#007bff',
                        // pointHoverBorderColor    : '#007bff'
                    },
                    {
                        type: 'line',
                        data: <?php echo json_encode($arrCurrentMonth); ?>,
                        backgroundColor: 'tansparent',
                        borderColor: '#ea0a2a',
                        pointBorderColor: '#ea0a2a',
                        pointBackgroundColor: '#ea0a2a',
                        fill: false
                        // pointHoverBackgroundColor: '#ced4da',
                        // pointHoverBorderColor    : '#ced4da'
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                    mode: mode,
                    intersect: intersect
                },
                hover: {
                    mode: mode,
                    intersect: intersect
                },
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        // display: false,
                        gridLines: {
                            display: true,
                            lineWidth: '4px',
                            color: 'rgba(0, 0, 0, .2)',
                            zeroLineColor: 'transparent'
                        },
                        ticks: $.extend({
                            beginAtZero: true,
                            suggestedMax: 200
                        }, ticksStyle)
                    }],
                    xAxes: [{
                        display: true,
                        gridLines: {
                            display: false
                        },
                        ticks: ticksStyle
                    }]
                }
            }
        })
    })

    // lgtm [js/unused-local-variable]
</script>
@endsection

@section('content')
<!-- Content Header (Page header) -->


<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dashboard Analytics</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#" class="text-danger">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header border-0 small-box">

                    <div class="card-body font-weight-bold">
                        <form method="GET">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="col-lg-12">
                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-sm-2 col-form-label">Month </label>
                                            <div class="col-sm-10">
                                                <select id="month" name="month" class="custom-select">
                                                    <option value="">--- Select Month ---</option>
                                                    <option value="january" <?= ($filterMonth == 'january') ? 'selected' : '' ?>>January</option>
                                                    <option value="february" <?= ($filterMonth == 'february') ? 'selected' : '' ?>>February</option>
                                                    <option value="march" <?= ($filterMonth == 'march') ? 'selected' : '' ?>>March</option>
                                                    <option value="april" <?= ($filterMonth == 'april') ? 'selected' : '' ?>>April</option>
                                                    <option value="may" <?= ($filterMonth == 'may') ? 'selected' : '' ?>>May</option>
                                                    <option value="june" <?= ($filterMonth == 'june') ? 'selected' : '' ?>>June</option>
                                                    <option value="july" <?= ($filterMonth == 'july') ? 'selected' : '' ?>>July</option>
                                                    <option value="august" <?= ($filterMonth == 'august') ? 'selected' : '' ?>>August</option>
                                                    <option value="september" <?= ($filterMonth == 'september') ? 'selected' : '' ?>>September</option>
                                                    <option value="october" <?= ($filterMonth == 'october') ? 'selected' : '' ?>>October</option>
                                                    <option value="november" <?= ($filterMonth == 'november') ? 'selected' : '' ?>>November</option>
                                                    <option value="december" <?= ($filterMonth == 'december') ? 'selected' : '' ?>>December</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-lg-6">
                                    <div class="col-lg-12">
                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-sm-2 col-form-label">Years </label>
                                            <div class="col-sm-10">
                                                <select id="year" name="year" class="custom-select">
                                                    <option value="">--- Select Years ---</option>

                                                    <?php
                                                    $year = date("Y", strtotime('-1 year'));
                                                    $cnt = $year + 1;
                                                    for ($year; $year <= $cnt; $year++) {
                                                    ?>
                                                        <option value="{{ $year }}" <?= ($filterYear == $year) ? 'selected' : '' ?>>{{ $year }}</option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <button type="submit" class="btn btn-danger start"> Search </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header border-0 small-box">
                            <h1 class="card-title">Active Visitor</h1>
                            <div class="card-body py-5 text-center font-weight-bold">
                                <span style="font-size:3rem; color:#ea0a2a; ">{{ $totalUsers + $totalUsersBefore }}</span>
                            </div>
                            <div class="icon">
                                <i class="fas fa-user-check"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header border-0 small-box">
                            <h1 class="card-title">Total Visitor</h1>
                            <div class="card-body py-5 text-center font-weight-bold">
                                <span style="font-size:3rem; color:#ea0a2a; ">{{ $totalCurrentMonth + $totalMonthBefore }}</span>
                            </div>
                            <div class="icon text-danger">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header small-box">
                            <h1 class="card-title">New Visitor</h1>
                            <div class="card-body py-5 text-center font-weight-bold">
                                <span style="font-size:3rem; color:#ea0a2a; ">{{ $newUsers + $newUsersBefore }}</span>
                            </div>
                            <div class="icon">
                                <i class="fas fa-user-plus"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">IFG Visitors</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span class="text-bold text-lg">{{ $totalMonthBefore + $totalCurrentMonth }}</span>
                                    <span>Visitors Over Time</span>
                                </p>
                                <p class="ml-auto d-flex flex-column text-right">
                                    @if($percentageOverTime <= 0) <span class="text-success">
                                        <i class="fas fa-arrow-up"></i> {{str_replace('-','',$percentageOverTime)}}%
                                        </span>
                                        @else
                                        <span class="text-danger">
                                            <i class="fas fa-arrow-down"></i> {{$percentageOverTime}}%
                                        </span>
                                        @endif
                                        <span class="text-muted">Since last month</span>
                                </p>
                            </div>
                            <!-- /.d-flex -->

                            <div class="position-relative mb-4">
                                <canvas id="visitors-chart" height="200"></canvas>
                            </div>

                            <div class="d-flex flex-row justify-content-end">
                                <span class="mr-2">
                                    <i class="fas fa-square text-danger"></i> This Month
                                </span>

                                <span>
                                    <i class="fas fa-square text-gray"></i> Last Month
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>


@endsection