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
<div class="row" style="margin: 25px 0">
    <div class="col-md-6" style="padding: 0">
        <h1 style="margin: 0; color: #e7505a; font-weight: normal; font-size: 24px"> Dashboard
            <small></small>
        </h1>
    </div>
    <div class="col-md-6" style="padding: 0">
        @role('Administrador')
        <div class="form-group">
            {{-- <label class="control-label" for="country"><span class="required">* </span>Country</label> --}}
            {!! Form::select('dealership', $dealerships_pairs, null, ['class' => 'form-control', 
            'id' => 'dashboard_dealership']) !!}
            {{-- <input type="hidden" name="countries_id" value="{{ $model->countries_id }}" id="country_hidden"> --}}
        </div>
        @endrole
    </div>
</div>
@endsection
@section('page-content')
<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat2 ">
            <div class="display">
                <div class="number">
                    <h3 class="font-green-sharp">
                        <span id="daily_pcts_amount">{{ $dashboard_stats['daily_pcts']['amount'] }}</span>
                    </h3>
                    <small>PCT diarias</small>
                </div>
                <div class="icon">
                    <i class="icon-pie-chart"></i>
                </div>
            </div>
            <div class="progress-info">
                <div class="progress">
                    <span id="daily_pcts_percentage" style="width: {{ $dashboard_stats['daily_pcts']['percentage'] }}%;" class="progress-bar progress-bar-success green-sharp"></span>
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
                        <span id="daily_items_amount" >{{ $dashboard_stats['daily_items']['amount'] }}</span>
                    </h3>
                    <small>items diarios</small>
                </div>
                <div class="icon">
                    <i class="icon-pie-chart"></i>
                </div>
            </div>
            <div class="progress-info">
                <div class="progress">
                    <span id="daily_items_percentage" style="width: {{ $dashboard_stats['daily_items']['percentage'] }}%;" class="progress-bar progress-bar-success green-sharp"></span>
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
                        <span id="monthly_pcts_amount" >{{ $dashboard_stats['monthly_pcts']['amount'] }}</span>
                    </h3>
                    <small>PCT mensual</small>
                </div>
                <div class="icon">
                    <i class="icon-pie-chart"></i>
                </div>
            </div>
            <div class="progress-info">
                <div class="progress">
                    <span id="monthly_pcts_percentage" style="width: {{ $dashboard_stats['monthly_pcts']['percentage'] }}%;" class="progress-bar progress-bar-success green-sharp"></span>
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
                        <span id="monthly_items_amount">{{ $dashboard_stats['monthly_items']['amount'] }}</span>
                    </h3>
                    <small>items mensual</small>
                </div>
                <div class="icon">
                    <i class="icon-pie-chart"></i>
                </div>
            </div>
            <div class="progress-info">
                <div class="progress">
                    <span id="monthly_items_percentage" style="width: {{ $dashboard_stats['monthly_items']['percentage'] }}%;" class="progress-bar progress-bar-success green-sharp"></span>
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
                        <span id="pending_ppas">{{ $dashboard_stats['pending_ppas'] }}</span>
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
                        <span id="rejected_ppas">{{ $dashboard_stats['rejected_ppas'] }}</span>
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
                        <span id="monthly_rejected_ppas">{{ $dashboard_stats['monthly_rejected_ppas'] }}</span>
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
                        <span id="rejected_ppas_percentage">{{ $dashboard_stats['rejected_ppas_percentage'] }}%</span>
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
                        <span id="quotation_average_time">{{ $dashboard_stats['quotation_average_time'] }} días</span>
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
    var root_url = $('#root_url').attr('content');
    $('#dashboard_dealership').change(function() {
        let dealership_id = $(this).val();
        
        $.get(root_url + '/dashboard/get-user-stats/' + dealership_id, function(response) { 

            let daily_pcts = response.daily_pcts;
            $('#daily_pcts_amount').text(daily_pcts.amount);
            $('#daily_pcts_percentage').css('width', daily_pcts.percentage + '%');

            let daily_items = response.daily_items;
            $('#daily_items_amount').text(daily_items.amount);
            $('#daily_items_percentage').css('width', daily_items.percentage + '%');

            let monthly_pcts = response.monthly_pcts;
            $('#monthly_pcts_amount').text(monthly_pcts.amount);
            $('#monthly_pcts_percentage').css('width', monthly_pcts.percentage + '%');

            let monthly_items = response.monthly_items;
            $('#monthly_items_amount').text(monthly_items.amount);
            $('#monthly_items_percentage').css('width', monthly_items.percentage + '%');

            $('#monthly_rejected_ppas').text(response.monthly_rejected_ppas);
            $('#pending_ppas').text(response.pending_ppas);
            $('#quotation_average_time').text(response.quotation_average_time);
            $('#rejected_ppas').text(response.rejected_ppas);
            $('#rejected_ppas_percentage').text(response.rejected_ppas_percentage);
        });
    });
</script>
@endpush