@extends('admin.components.template')

@section('lib_css_ext')
<link rel="stylesheet" href="{{ asset('plugins/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/iCheck/all.css') }}">
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="{{ asset('plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endsection

@section('content')
	<div class="form-group">
		<button class="btn btn-primary btn-flat" id="btn_input_depot" data-toggle="modal" data-target="#input_depot">
			<i class="fa fa-arrow-down"></i> Nhập hàng
		</button>
	</div>
	<div class="box">
		<div class="box-header">
			<h3 class="box-title text-info">Danh sách các đơn hàng</h3>
		</div>
		<div class="box-body">
			<table id="products-table" class="table table-bordered table-hover">
				<thead>
					<tr>
						<td>Mã</td>
						<td>Tên sản phẩm</td>
						<td>Nhà sản xuất</td>
						<td>Ghi chú</td>
						<td>Ngày tạo</td>
					</tr>
				</thead>
			</table>
		</div>
	</div>

	<!-- Modal Input Depot-->
	<div id="input_depot" class="modal fade" role="dialog">
	  	<div class="modal-dialog">
	    <!-- Modal content-->
		    <div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title text-green">Thêm mới đơn hàng nhập kho</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal">
					    <div class="box-body">
					    	<div class="form-group">
					        	<label for="saler" class="col-sm-3 control-label">Hàng nhập từ</label>
					        	<div class="col-sm-9">
						        	<input type="text" class="form-control" id="saler" placeholder="Nhập người bán">
			                  	</div>
					        </div>
					        <div class="form-group">
					        	<label for="productName" class="col-sm-3 control-label">Sản phẩm</label>
					        	<div class="col-sm-9">
						        	<select class="form-control" id="productName">
				                  	</select>
			                  	</div>
					        </div>
					        <div class="form-group">
					        	<label for="qualityProduct" class="col-sm-3 control-label">Chất lượng</label>
					        	<div class="col-sm-9">
					        		<div class="col-sm-4">
							        	<input id="quality_95" class="form-control" name="qualityProduct" type="radio" value="1">
							        	<label for="quality_95" class="control-label"> 95%</label>
						        	</div>
						        	<div class="col-sm-4">
							        	<input id="quality_99" class="form-control" name="qualityProduct" type="radio" value="2" checked>
							        	<label for="quality_99" class="control-label"> 99%</label>
						        	</div>
						        	<div class="col-sm-4">
							        	<input id="quality_new" class="form-control" name="qualityProduct" type="radio" value="3">
							        	<label for="quality_new" class="control-label"> New</label>
						        	</div>
			                  	</div>
					        </div>
					        <div class="form-group">
					        	<label for="colorProduct" class="col-sm-3 control-label">Màu sắc</label>
					        	<div class="col-sm-9">
						        	<select class="form-control" id="colorProduct">
						        		<option value="1">Vàng</option>
						        		<option value="2">Xám</option>
						        		<option value="3">Bạc</option>
						        		<option value="4">Đen bóng</option>
						        		<option value="5">Đen nhám</option>
						        		<option value="6">Đỏ</option>
				                  	</select>
			                  	</div>
					        </div>
					        <div class="form-group">
					            <label for="quantityProduct" class="col-sm-3 control-label">Số lượng</label>
					            <div class="col-sm-9">
					                <input type="number" min="1" value="1" class="form-control" id="quantityProduct">
					            </div>
					        </div>
					        <div class="form-group">
					            <label for="inputDate" class="col-sm-3 control-label">Ngày nhập</label>
					            <div class="col-sm-9">
					                <div class="input-group">
					                  	<span class="input-group-addon">
					                    	<i class="fa fa-calendar"></i>
					                  	</span>
					                  	<input class="form-control pull-right" value="{{ \Carbon\Carbon::now()->format('d/m/Y') }}" id="inputDate" data-date-format="dd/mm/yyyy">
					                </div>
					            </div>
					        </div>
					        <div class="form-group">
					            <label for="priceProduct" class="col-sm-3 control-label">Giá thành</label>
					            <div class="col-sm-9">
					                <div class="input-group">
						                <span class="input-group-addon">
						                	<i class="fa fa-dollar"></i>
						                </span>
						                <input class="form-control" id="priceProduct">
					              	</div>
					            </div>
					        </div>
					        <div class="form-group">
					            <label for="totalPrice" class="col-sm-3 control-label">Thành tiền</label>
					            <div class="col-sm-9">
					                <div class="input-group">
						                <span class="input-group-addon">
						                	<i class="fa fa-dollar"></i>
						                </span>
						                <input class="form-control bg-orange" id="totalPrice" disabled>
					              	</div>
					            </div>
					        </div>
					        <div class="form-group">
					            <label for="depotNote" class="col-sm-3 control-label">Ghi chú</label>
					            <div class="col-sm-9">
					                <textarea rows="3" class="form-control" id="depotNote" placeholder="Nhập thông tin về đơn hàng"></textarea>
					            </div>
					        </div>
					    </div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-rotate-left"></i> Hủy bỏ</button>
					<button type="button" id="btn_save_input_depot" class="btn btn-default btn-flat btn-success"><i class="fa fa-save"></i> Lưu</button>
				</div>
		    </div>
	  	</div>
	</div>
	<!-- Modal Input Depot-->
@endsection

@section('lib_js_ext')
<!-- DataTables -->
<script src="{{ asset('plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('plugins/iCheck/icheck.min.js') }}"></script>
<!-- InputMask -->
<script src="{{ asset('plugins/inputmask/dist/jquery.inputmask.bundle.js') }}"></script>
<!-- bootstrap datepicker -->
<script src="{{ asset('plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap-datepicker/dist/locales/bootstrap-datepicker.vi.min.js') }}" charset="UTF-8"></script>
@endsection

@section('js_ext')
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});

	$('input').iCheck({
	    checkboxClass: 'icheckbox_flat',
	    radioClass: 'iradio_flat-green'
	});

	//Date picker
    $('#inputDate').datepicker({
      autoclose: true,
      language: 'vi'
    });
	
	$('#btn_input_depot').on('click', function(){
		$.ajax({
			url: '{{ route('productsname') }}',
			type: 'GET'
		})
		.done(function(data) {
			$('#productName')
			    .find('option')
			    .remove()
			    .end();

			$.each( data, function( key, object ) {
				$('#productName').append($('<option>', { 
			        value: object.id,
			        text : object.product_name 
			    }));
			});
			
		});
	});

	$('#priceProduct, #totalPrice').inputmask("numeric", {
		radixPoint: "",
	    groupSeparator: ".",
	    autoGroup: true,
	    rightAlign: false,
	    autoUnmask: true,
	});

	$('#totalPrice').val($('#quantityProduct').val()*$('#priceProduct').val());
	
	$('#quantityProduct').on('input', function(){
		var quantityProduct = $('#quantityProduct').val();
		var priceProduct = $('#priceProduct').val();

		$('#totalPrice').val( quantityProduct * priceProduct);
	});

	$('#priceProduct').on('input',function(){
		var quantityProduct = $('#quantityProduct').val();
		var priceProduct = $('#priceProduct').val();

		$('#totalPrice').val( quantityProduct * priceProduct);
	});

	$('#btn_save_input_depot').on('click', function(){
		var saler = $('#saler').val();
		var product_id = $('#productName').val();
		var id = $(":radio[name=qualityProduct]:checked").attr("id");
		var qualityProduct = $('label[for='+id+']').text();
		var colorProduct = $('#colorProduct').find(":selected").text();
		var quantityProduct = $('#quantityProduct').val();
		var inputDate = $('#inputDate').val();
		var priceProduct = $('#priceProduct').val();
		var totalPrice = $('#totalPrice').val();
		var depotNote = $('#depotNote').val();
		
		var data = {
			saler: saler,
			product_id: product_id,
			qualityProduct: qualityProduct,
			colorProduct: colorProduct,
			quantityProduct: quantityProduct,
			inputDate: inputDate,
			priceProduct: priceProduct,
			totalPrice: totalPrice,
			depotNote: depotNote
		};

{{-- 		console.log('saler :' + saler);
		console.log('product_id :' + product_id);
		console.log('qualityProduct :' + qualityProduct);
		console.log('colorProduct : ' + colorProduct);
		console.log('quantityProduct : ' + quantityProduct);
		console.log('inputDate : ' + inputDate);
		console.log('priceProduct : ' + priceProduct);
		console.log('totalPrice : ' + totalPrice);
		console.log('depotNote : ' + depotNote); --}}

		$.ajax({
			url: '{{ route('depots.store') }}',
			type: 'POST',
			data: data,
		})
		.done(function(data) {
			console.log(data);
		});
		
	});
@endsection