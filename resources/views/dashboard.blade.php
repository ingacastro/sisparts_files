@extends('layouts.admin.master')
@section('content')
@section('breadcumb')
<ul class="page-breadcrumb">
    <li>
        <a>Home</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <span>Dashboard</span>
    </li>
</ul>
@endsection
@section('page-title')
<h1 class="page-title"> Dashboard
    <small></small>
</h1>
@endsection
@section('page-content')
<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat2 ">
            <div class="display">
                <div class="number">
                    <h3 class="font-green-sharp">
                        <span>{{ $dashboard_stats['daily_pcts']['amount'] }}/{{ $dashboard_stats['daily_pcts']['expected'] }} ({{ $dashboard_stats['daily_pcts']['percentage'] }}%)</span>
                    </h3>
                    <small>Meta PCT diarias</small>
                </div>
                <div class="icon">
                    <i class="icon-pie-chart"></i>
                </div>
            </div>
            <div class="progress-info">
                <div class="progress">
                    <span style="width: {{ $dashboard_stats['daily_pcts']['percentage']  }}%;" class="progress-bar progress-bar-success green-sharp"></span>
                </div>
                <div class="status"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat2 ">
            <div class="display">
                <div class="number">
                    <h3 class="font-green-sharp">
                        <span>{{ $dashboard_stats['daily_items']['amount'] }}/{{ $dashboard_stats['daily_items']['expected'] }} ({{ $dashboard_stats['daily_items']['percentage'] }}%)</span>
                    </h3>
                    <small>Meta items diarios</small>
                </div>
                <div class="icon">
                    <i class="icon-pie-chart"></i>
                </div>
            </div>
            <div class="progress-info">
                <div class="progress">
                    <span style="width: {{ $dashboard_stats['daily_items']['percentage'] }}%;" class="progress-bar progress-bar-success green-sharp"></span>
                </div>
                <div class="status"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat2 ">
            <div class="display">
                <div class="number">
                    <h3 class="font-green-sharp">
                        <span>{{ $dashboard_stats['monthly_pcts']['amount'] }}/{{ $dashboard_stats['monthly_pcts']['expected'] }} ({{ $dashboard_stats['monthly_pcts']['percentage'] }}%)</span>
                    </h3>
                    <small>Meta PCT mensual</small>
                </div>
                <div class="icon">
                    <i class="icon-pie-chart"></i>
                </div>
            </div>
            <div class="progress-info">
                <div class="progress">
                    <span style="width: {{ $dashboard_stats['monthly_pcts']['percentage'] }}%;" class="progress-bar progress-bar-success green-sharp"></span>
                </div>
                <div class="status"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat2 ">
            <div class="display">
                <div class="number">
                    <h3 class="font-green-sharp">
                        <span>{{ $dashboard_stats['monthly_items']['amount'] }}/{{ $dashboard_stats['monthly_items']['expected'] }} ({{ $dashboard_stats['monthly_items']['percentage'] }}%)</span>
                    </h3>
                    <small>Meta items mensual</small>
                </div>
                <div class="icon">
                    <i class="icon-pie-chart"></i>
                </div>
            </div>
            <div class="progress-info">
                <div class="progress">
                    <span style="width: {{ $dashboard_stats['monthly_items']['percentage'] }}%;" class="progress-bar progress-bar-success green-sharp"></span>
                </div>
                <div class="status"></div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat2 ">
            <div class="display">
                <div class="number">
                    <h3 class="font-green-sharp">
                        <span>{{ $dashboard_stats['pending_ppas'] }}</span>
                    </h3>
                    <small>PPA pendientes</small>
                </div>
                <div class="icon">
                </div>
            </div>
            <div class="progress-info">
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat2 ">
            <div class="display">
                <div class="number">
                    <h3 class="font-green-sharp">
                        <span>{{ $dashboard_stats['rejected_ppas'] }}</span>
                    </h3>
                    <small>PPA rechazadas</small>
                </div>
                <div class="icon">
                </div>
            </div>
            <div class="progress-info">
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat2 ">
            <div class="display">
                <div class="number">
                    <h3 class="font-green-sharp">
                        <span>{{ $dashboard_stats['monthly_rejected_ppas'] }}</span>
                        {{-- <small class="font-green-sharp">$</small> --}}
                    </h3>
                    <small>PPA rechazadas mes</small>
                </div>
                <div class="icon">
                </div>
            </div>
            <div class="progress-info">
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat2 ">
            <div class="display">
                <div class="number">
                    <h3 class="font-green-sharp">
                        <span>{{ $dashboard_stats['rejected_ppas_percentage'] }}%</span>
                        {{-- <small class="font-green-sharp">$</small> --}}
                    </h3>
                    <small>PPA rechazadas</small>
                </div>
                <div class="icon">
                </div>
            </div>
            <div class="progress-info">
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat2 ">
            <div class="display">
                <div class="number">
                    <h3 class="font-green-sharp">
                        <span>{{ $dashboard_stats['quotation_average_time'] }} días</span>
                    </h3>
                    <small>Tiempo promedio</small>
                </div>
                <div class="icon">
                </div>
            </div>
            <div class="progress-info">
            </div>
        </div>
    </div>
</div>
@endsection
@endsection
@push('scripts')
<script type="text/javascript">
    $('#sidebar_dashboard').addClass('active');
</script>
@endpush