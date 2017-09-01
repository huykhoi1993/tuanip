@extends('admin.components.template')

@section('lib_css_ext')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
<!-- iCheck -->
<link rel="stylesheet" href="{{ asset('plugins/iCheck/all.css') }}">
<style type="text/css">
table#products-table thead tr td,
.text-bold {
	font-weight: bold;
}

.text-bold {
	text-align: center;
}

@media screen and (min-width: 768px), screen and (min-height: 768px) {
	#colorProduct, 
	#storageProduct, 
	#qualityProduct {
		margin: 0;
		padding-left: 0;
	}

	#qualityProduct {
		padding-right: 0;
	}
}
</style>
@endsection

@section('title_header')
	<h1>Thống kê chi tiết</h1>
@endsection

@section('content')
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
	        <div class="box box-success">
	            <div class="box-header with-border">
					<h3 class="box-title">Toàn bộ Công Nợ tháng này</h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
						</button>
						<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
					</div>
	            </div>
	            <div class="box-body">
					<div class="chart">
						<canvas id="chart_this_month"></canvas>
					</div>
	            </div>
            <!-- /.box-body -->
          	</div>
	    </div>
	    <!-- /.col -->
	</div>
	<div class="row">
		<div class="col-md-6 col-sm-12 col-xs-12">
	        <div class="box box-info">
	            <div class="box-header with-border">
					<h3 class="box-title">Top 10 Công chưa thanh toán</h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
						</button>
						<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
					</div>
	            </div>
	            <div class="box-body">
					<div class="chart">
						<canvas id="top_10_no_pay_credit"></canvas>
					</div>
	            </div>
            <!-- /.box-body -->
          	</div>
	    </div>
	    <!-- /.col -->
	    <div class="col-md-6 col-sm-12 col-xs-12">
	        <div class="box box-primary">
	            <div class="box-header with-border">
					<h3 class="box-title">Top 10 Nợ chưa thanh toán</h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
						</button>
						<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
					</div>
	            </div>
	            <div class="box-body">
					<div class="chart">
						<canvas id="top_10_no_pay_debit"></canvas>
					</div>
	            </div>
            <!-- /.box-body -->
          	</div>
	    </div>
	    <!-- /.col -->
	</div>
@endsection

@section('lib_js_ext')
<!-- DataTables -->
<script src="{{ asset('plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<!-- iCheck -->
<script src="{{ asset('plugins/iCheck/icheck.min.js') }}"></script>
<!-- Chart.js -->
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
@endsection

@section('js_ext')
@isset ($results_this_month)
{
	var labels = [];
	var data_debits = [];
	var data_crebits = [];

	@foreach ($results_this_month as $result)
		labels.push('{{ $result->day }}');
		data_crebits.push({{ $result->total_credits }});
		data_debits.push({{ - $result->total_debits }});
	@endforeach
	var areaChartData = {
	  	labels  : labels,
	  	datasets: [
		    {
		    	label 				: 'Công',
				fillColor           : '#00A65A',
	           	strokeColor         : '#00A65A',
	          	pointColor          : '#00A65A',
	          	pointStrokeColor    : 'rgba(220,220,220,1)',
	          	pointHighlightFill  : '#fff',
	          	pointHighlightStroke: 'rgba(220,220,220,1)',
				data                : data_crebits
		    },
		    {
		    	label 				: 'Nợ',
				fillColor           : '#ffc107',
				strokeColor         : '#ffc107',
				pointColor          : '#ffc107',
				pointStrokeColor    : 'rgba(60,141,188,1)',
				pointHighlightFill  : '#fff',
				pointHighlightStroke: 'rgba(60,141,188,1)',
				data                : data_debits
		    }
	  	]
	}

	var areaChartCanvas          = $('#chart_this_month').get(0).getContext('2d')
	var areaChart                = new Chart(areaChartCanvas)
	var areaChartOptions         = {
		scaleLabel: function (label) {
	    	return label.value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
		},
		multiTooltipTemplate: function(label){
			return label.datasetLabel + ': ' + label.value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + ' VNĐ';
		}
	};

	areaChartOptions.datasetFill = false
	areaChart.Line(areaChartData, areaChartOptions)
}
@endisset
@isset($top_10_no_pay_credit)
{
	var labels = [];
	var data = [];

	@foreach ($top_10_no_pay_credit as $credit)
		labels.push('{{ $credit->member_name }}');
		data.push({{ $credit->total_amount }});
	@endforeach

	var barChartCanvas 	 = $('#top_10_no_pay_credit').get(0).getContext('2d')
    var chart_every_type = new Chart(barChartCanvas)
    var barChartData 	 = {
		labels  : labels,
		datasets: [
			{
				label 		: 'Cái',
				fillColor	: '#00A65A',
				strokeColor	: '#00A65A',
				pointColor	: '#00A65A',
				data 		: data
			}
		]
    }
    var barChartOptions = {
    	scaleLabel: function (label) {
	    	return label.value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
		},
    	tooltipTemplate: function(label){
    		return label.label + ': ' + label.value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + ' VNĐ';
    	}
    }
    chart_every_type.Bar(barChartData, barChartOptions)
}
@endisset
@isset($top_10_no_pay_debit)
{
	var labels = [];
	var data = [];

	@foreach ($top_10_no_pay_debit as $debit)
		labels.push('{{ $debit->member_name }}');
		data.push({{ $debit->total_amount }});
	@endforeach

	var barChartCanvas 	 = $('#top_10_no_pay_debit').get(0).getContext('2d')
    var chart_every_type = new Chart(barChartCanvas)
    var barChartData 	 = {
		labels  : labels,
		datasets: [
			{
				label 		: 'Cái',
				fillColor	: '#1976d2',
				strokeColor	: '#1976d2',
				pointColor	: '#1976d2',
				data 		: data
			}
		]
    }
    var barChartOptions = {
    	scaleLabel: function (label) {
	    	return label.value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
		},
    	tooltipTemplate: function(label){
    		return label.label + ': ' + label.value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + ' VNĐ';
    	}
    }
    chart_every_type.Bar(barChartData, barChartOptions)
}
@endisset
@endsection