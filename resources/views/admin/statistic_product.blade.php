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
		<div class="col-md-6 col-sm-12 col-xs-12">
	        <div class="box box-success">
	            <div class="box-header with-border">
					<h3 class="box-title">Toàn bộ sản phẩm</h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
						</button>
						<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
					</div>
	            </div>
	            <div class="box-body">
					<div class="chart">
						<canvas id="chart_all_products"></canvas>
					</div>
	            </div>
            <!-- /.box-body -->
          	</div>
	    </div>
	    <!-- /.col -->
	    <div class="col-md-6 col-sm-12 col-xs-12">
	        <div class="box box-success">
	            <div class="box-header with-border">
					<h3 class="box-title">Thống kê với các loại</h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
						</button>
						<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
					</div>
	            </div>
	            <div class="box-body">
					<div class="chart">
						<canvas id="chart_every_type"></canvas>
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
{
	var labels = [];
	var data = [];
    @foreach ($total_every_products as $product)
    	labels.push('{{ $product->product_name }}');
    	data.push('{{ $product->total_products }}');
    @endforeach
    var barChartCanvas 	 = $('#chart_all_products').get(0).getContext('2d')
    var chart_every_type = new Chart(barChartCanvas)
    var barChartData 	 = {
		labels  : labels,
		datasets: [
			{
				label 		: 'Cái',
				fillColor	: '#00a65a',
				strokeColor	: '#00a65a',
				pointColor	: '#00a65a',
				data 		: data
			}
		]
    }
    var barChartOptions = {
		animation: false,
	    responsive : true,
	    tooltipTemplate: "<%= value %>",
	    tooltipFillColor: "rgba(0,0,0,0)",
	    tooltipFontColor: "#616161",
	    tooltipEvents: [],
	    tooltipCaretSize: 0,
	    onAnimationComplete: function()
	    {
	        this.showTooltip(this.datasets[0].bars, true);
	    }
    }
    chart_every_type.Bar(barChartData, barChartOptions)
}
@isset ($total_every_products)
{
	var labels = [];
	var data = [];
    @foreach ($total_every_products as $product)
    	labels.push('{{ $product->product_name }}');
    	data.push('{{ $product->total_products }}');
    @endforeach
    var barChartCanvas 	 = $('#chart_every_type').get(0).getContext('2d')
    var chart_every_type = new Chart(barChartCanvas)
    var barChartData 	 = {
		labels  : labels,
		datasets: [
			{
				label 		: 'Cái',
				fillColor	: '#00a65a',
				strokeColor	: '#00a65a',
				pointColor	: '#00a65a',
				data 		: data
			}
		]
    }
    var barChartOptions = {
		animation: false,
	    responsive : true,
	    tooltipTemplate: "<%= value %>",
	    tooltipFillColor: "rgba(0,0,0,0)",
	    tooltipFontColor: "#616161",
	    tooltipEvents: [],
	    tooltipCaretSize: 0,
	    onAnimationComplete: function()
	    {
	        this.showTooltip(this.datasets[0].bars, true);
	    }
    }
    chart_every_type.Bar(barChartData, barChartOptions)
}
@endisset
@endsection