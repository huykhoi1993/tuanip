@extends('admin.components.template')

@section('lib_css_ext')
<link rel="stylesheet" href="{{ asset('plugins/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/iCheck/all.css') }}">
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="{{ asset('plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<style type="text/css">
table#depots-table thead tr td {
	font-weight: bold;
}

@media screen and (min-width: 768px), screen and (min-height: 768px) {
	#div_productName, 
	#div_storageProduct, 
	#div_qualityProduct,
	#div_colorProduct,
	#label_quantityProduct,
	#div_quantityProduct,
	#div_versionProduct,
	#label_thanhToan,
	#div_thanhToan {
		margin: 0;
		padding-left: 0;
	}

	#label_quantityProduct,
	#label_thanhToan {
		text-align: right;
	}

	#div_qualityProduct,
	#div_quantityProduct,
	#div_thanhToan {
		padding-right: 0;
	}
}
</style>
@endsection

@section('content')
	<div class="form-group">
		<button class="btn btn-primary btn-flat" id="btn_imp_depot" data-toggle="modal" data-target="#input_depot">
			<i class="fa fa-arrow-down"></i> Nhập hàng
		</button>
		<button class="btn btn-success btn-flat" id="btn_exp_depot" data-toggle="modal" data-target="#output_depot">
			<i class="fa fa-arrow-up"></i> Xuất hàng
		</button>
	</div>
	<div class="box">
		<div class="box-header">
			<h3 class="box-title text-info">Danh sách các đơn hàng</h3>
		</div>
		<div class="box-body">
			<div class="table-responsive">
				<table id="depots-table" class="table table-bordered table-responsive table-striped dataTable">
					<thead>
						<tr>
							<td>Mã đơn</td>
							<td>Người bán(mua)</td>
							<td>Sản phẩm</td>
							<td>Bộ nhớ</td>
							<td>Màu</td>
							<td>Slượng</td>
							<td>Clượng</td>
							<td>Loại</td>
							<td>Giá</td>
							<td>Tổng tiền</td>
							<td>Thanh toán</td>
							<td>Ghi chú</td>
							<td>Ngày tạo</td>
							<td>Đơn nhập</td>
						</tr>
					</thead>
				</table>
			</div>
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
					        		<div id="div_productName" class="col-sm-4 form-group">
							        	<select class="form-control" id="productName" disabled="true">
					                  	</select>
				                  	</div>
					        		<div id="div_storageProduct" class="col-sm-4 form-group">
					        			<select class="form-control" id="storageProduct" disabled="true">
					                  	</select>
					        		</div>
					        		<div id="div_qualityProduct" class="col-sm-4 form-group">
					        			<select class="form-control" id="qualityProduct" disabled="true">
					                  	</select>
					        		</div>
			                  	</div>
					        </div>
					        <div class="form-group">
					        	<label for="colorProduct" class="col-sm-3 control-label">Màu sắc</label>
					        	<div class="col-sm-9">
					        		<div id="div_colorProduct" class="col-sm-4 form-group">
							        	<select class="form-control" id="colorProduct" disabled="true">
					                  	</select>
				                  	</div>
					        		<div id="label_quantityProduct" class="col-sm-4 form-group">
					        			<label class="control-label">Số lượng</label>
					        		</div>
					        		<div id="div_quantityProduct" class="col-sm-4 form-group">
					                	<input type="number" min="1" value="1" class="form-control" id="quantityProduct">
					        		</div>
			                  	</div>
					        </div>
					        <div class="form-group">
					        	<label for="versionProduct" class="col-sm-3 control-label">Phiên bản</label>
					        	<div class="col-sm-9">
					        		<div id="div_versionProduct" class="col-sm-4 form-group">
							        	<select class="form-control" id="versionProduct">
							        		<option value="0">Lock</option>
							        		<option value="1" selected="true">Quốc tế</option>
					                  	</select>
				                  	</div>
					        		<div id="label_thanhToan" class="col-sm-4 form-group">
					        			<label class="control-label">Thanh toán</label>
					        		</div>
					        		<div id="div_thanhToan" class="col-sm-4 form-group">
					                	<select class="form-control" id="thanhToan">
							        		<option value="0">Tiền mặt</option>
							        		<option value="1" selected="true">Chuyển khoản</option>
					                  	</select>
					        		</div>
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
					<button type="button" id="btn_save_imp_depot" class="btn btn-default btn-flat btn-success"><i class="fa fa-save"></i> Lưu</button>
				</div>
		    </div>
	  	</div>
	</div>
	<!-- /Modal Input Depot-->
	
	<!-- Modal Output Depot-->
	<div id="output_depot" class="modal fade" role="dialog">
	  	<div class="modal-dialog">
	    <!-- Modal content-->
		    <div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title text-green">Thêm mới đơn hàng xuất kho</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal">
					    <div class="box-body">
					    	<div class="form-group">
					        	<label for="buyer" class="col-sm-3 control-label">Hàng xuất cho</label>
					        	<div class="col-sm-9">
						        	<input type="text" class="form-control" id="buyer" placeholder="Nhập người bán">
			                  	</div>
					        </div>
					        <div class="form-group">
					        	<label for="productName" class="col-sm-3 control-label">Sản phẩm</label>
					        	<div class="col-sm-9">
					        		<div id="div_productName" class="col-sm-4 form-group">
							        	<select class="form-control" id="exp_productName" disabled="true">
					                  	</select>
				                  	</div>
					        		<div id="div_storageProduct" class="col-sm-4 form-group">
					        			<select class="form-control" id="exp_storageProduct" disabled="true">
					                  	</select>
					        		</div>
					        		<div id="div_qualityProduct" class="col-sm-4 form-group">
					        			<select class="form-control" id="exp_qualityProduct" disabled="true">
					                  	</select>
					        		</div>
			                  	</div>
					        </div>
					        <div class="form-group">
					        	<label for="colorProduct" class="col-sm-3 control-label">Màu sắc</label>
					        	<div class="col-sm-9">
					        		<div id="div_colorProduct" class="col-sm-4 form-group">
							        	<select class="form-control" id="exp_colorProduct" disabled="true">
					                  	</select>
				                  	</div>
					        		<div id="label_quantityProduct" class="col-sm-4 form-group">
					        			<label class="control-label">Số lượng</label>
					        		</div>
					        		<div id="div_quantityProduct" class="col-sm-4 form-group">
					                	<input type="number" min="1" value="1" class="form-control" id="exp_quantityProduct">
					        		</div>
			                  	</div>
					        </div>
					        <div class="form-group">
					        	<label for="versionProduct" class="col-sm-3 control-label">Phiên bản</label>
					        	<div class="col-sm-9">
					        		<div id="div_versionProduct" class="col-sm-4 form-group">
							        	<select class="form-control" id="exp_versionProduct">
							        		<option value="0">Lock</option>
							        		<option value="1" selected="true">Quốc tế</option>
					                  	</select>
				                  	</div>
					        		<div id="label_thanhToan" class="col-sm-4 form-group">
					        			<label class="control-label">Thanh toán</label>
					        		</div>
					        		<div id="div_thanhToan" class="col-sm-4 form-group">
					                	<select class="form-control" id="exp_thanhToan">
							        		<option value="0">Tiền mặt</option>
							        		<option value="1" selected="true">Chuyển khoản</option>
					                  	</select>
					        		</div>
			                  	</div>
					        </div>
					        <div class="form-group">
					            <label for="exp_date" class="col-sm-3 control-label">Ngày xuất</label>
					            <div class="col-sm-9">
					                <div class="input-group">
					                  	<span class="input-group-addon">
					                    	<i class="fa fa-calendar"></i>
					                  	</span>
					                  	<input class="form-control pull-right" value="{{ \Carbon\Carbon::now()->format('d/m/Y') }}" id="exp_date" data-date-format="dd/mm/yyyy">
					                </div>
					            </div>
					        </div>
					        <div class="form-group">
					            <label for="exp_priceProduct" class="col-sm-3 control-label">Giá thành</label>
					            <div class="col-sm-9">
					                <div class="input-group">
						                <span class="input-group-addon">
						                	<i class="fa fa-dollar"></i>
						                </span>
						                <input class="form-control" id="exp_priceProduct">
					              	</div>
					            </div>
					        </div>
					        <div class="form-group">
					            <label for="exp_totalPrice" class="col-sm-3 control-label">Thành tiền</label>
					            <div class="col-sm-9">
					                <div class="input-group">
						                <span class="input-group-addon">
						                	<i class="fa fa-dollar"></i>
						                </span>
						                <input class="form-control bg-orange" id="exp_totalPrice" disabled>
					              	</div>
					            </div>
					        </div>
					        <div class="form-group">
					            <label for="exp_depotNote" class="col-sm-3 control-label">Ghi chú</label>
					            <div class="col-sm-9">
					                <textarea rows="3" class="form-control" id="exp_depotNote" placeholder="Nhập thông tin về đơn hàng"></textarea>
					            </div>
					        </div>
					    </div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-rotate-left"></i> Hủy bỏ</button>
					<button type="button" id="btn_save_exp_depot" class="btn btn-default btn-flat btn-success"><i class="fa fa-save"></i> Lưu</button>
				</div>
		    </div>
	  	</div>
	</div>
	<!-- /Modal Output Depot-->
@endsection

@section('lib_js_ext')
<!-- DataTables -->
<script src="{{ asset('plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<!-- iCheck -->
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
	    radioClass: 'iradio_flat-blue'
	});

	{{-- Date picker --}}
    $('#inputDate').datepicker({
      autoclose: true,
      language: 'vi'
    });
	{{-- End Date picker --}}
	
	$('#btn_imp_depot').on('click', function(){
		getProductName();

		var productName = $("#productName option:first").text();
		getStoragesProduct( productName);

		var storageProduct = $("#storageProduct option:first").text();
		getQualitiesProduct( productName, storageProduct);
				
		var qualityProduct = $("#qualityProduct option:first").text();
		getColorsProduct( productName, storageProduct, qualityProduct);
	});

	$('#btn_exp_depot').on('click', function(){
		getProductName();

		var exp_productName = $("#exp_productName option:first").text();
		getStoragesProduct( exp_productName);

		var exp_storageProduct = $("#exp_storageProduct option:first").text();
		getQualitiesProduct( exp_productName, exp_storageProduct);
				
		var exp_qualityProduct = $("#exp_qualityProduct option:first").text();
		getColorsProduct( exp_productName, exp_storageProduct, exp_qualityProduct);
	});

	$('#btn_save_imp_depot').on('click', function(){
		var saler 			= $('#saler').val();
		var productName 	= $('#productName').find(":selected").text();
		var storageProduct 	= $('#storageProduct').find(":selected").text();
		var qualityProduct 	= $('#qualityProduct').find(":selected").text();
		var colorProduct 	= $('#colorProduct').find(":selected").text();
		var quantityProduct = $('#quantityProduct').val();
		var versionProduct 	= $('#versionProduct').find(":selected").val();
		var thanhToan 		= $('#thanhToan').find(":selected").text();
		var exp_date 		= $('#exp_date').val();
		var priceProduct 	= $('#priceProduct').val();
		var totalPrice 		= $('#totalPrice').val();
		var depotNote 		= $('#depotNote').val();
		
		var data = {
			isInput: 1,
			saler: saler,
			productName: productName,
			storageProduct: storageProduct,
			qualityProduct: qualityProduct,
			colorProduct: colorProduct,
			quantityProduct: quantityProduct,
			is_quocte: versionProduct,
			thanhToan: thanhToan,
			inputDate: exp_date,
			priceProduct: priceProduct,
			totalPrice: totalPrice,
			depotNote: depotNote
		};
		
		$.ajax({
			url: '{{ route('depots.store') }}',
			type: 'POST',
			data: data,
			async: false
		})
		.done(function(data) {
			$('#input_depot').modal('toggle');
			$('#saler').val('');
			$('#productName').val(0);
			$('#storageProduct').val(0);
			$('#qualityProduct').val(0);
			$('#colorProduct').val(0);
			$('#quantityProduct').val(1);
			$('#inputDate').val("{{ \Carbon\Carbon::now()->format('d/m/Y') }}");
			$('#priceProduct').val('');
			$('#totalPrice').val('');
			$('#depotNote').val('');
		})
		.always(function(){
			$('#depots-table').DataTable().ajax.reload();
		});
	});

	$('#btn_save_exp_depot').on('click', function(){
		var buyer 				= $('#buyer').val();
		var exp_productName 	= $('#exp_productName').find(":selected").text();
		var exp_storageProduct 	= $('#exp_storageProduct').find(":selected").text();
		var exp_qualityProduct 	= $('#exp_qualityProduct').find(":selected").text();
		var exp_colorProduct 	= $('#exp_colorProduct').find(":selected").text();
		var exp_quantityProduct = $('#exp_quantityProduct').val();
		var exp_versionProduct 	= $('#exp_versionProduct').find(":selected").val();
		var exp_thanhToan 		= $('#exp_thanhToan').find(":selected").text();
		var exp_date 			= $('#exp_date').val();
		var exp_priceProduct 	= $('#exp_priceProduct').val();
		var exp_totalPrice 		= $('#exp_totalPrice').val();
		var exp_depotNote 		= $('#exp_depotNote').val();
		
		var data = {
			isInput: 0,
			buyer: buyer,
			productName: exp_productName,
			storageProduct: exp_storageProduct,
			qualityProduct: exp_qualityProduct,
			colorProduct: exp_colorProduct,
			quantityProduct: exp_quantityProduct,
			isQuocte: exp_versionProduct,
			thanhToan: exp_thanhToan,
			inputDate: exp_date,
			priceProduct: exp_priceProduct,
			totalPrice: exp_totalPrice,
			depotNote: exp_depotNote
		};

		$.ajax({
			url: '{{ route('depots.store') }}',
			type: 'POST',
			data: data,
			async: false
		})
		.done(function(data) {
			$('#buyer').val('');
			$('#exp_productName').val(0);
			$('#exp_storageProduct').val(0);
			$('#exp_qualityProduct').val(0);
			$('#exp_colorProduct').val(0);
			$('#exp_quantityProduct').val(1);
			$('#exp_date').val("{{ \Carbon\Carbon::now()->format('d/m/Y') }}");
			$('#exp_priceProduct').val('');
			$('#exp_totalPrice').val('');
			$('#exp_depotNote').val('');
		})
		.always(function(){
			$('#output_depot').modal('toggle');
			$('#depots-table').DataTable().ajax.reload();
		});
	});

	$('#priceProduct, #totalPrice, #exp_priceProduct, #exp_totalPrice').inputmask("numeric", {
		radixPoint: "",
	    groupSeparator: ".",
	    autoGroup: true,
	    rightAlign: false,
	    autoUnmask: true,
	});

	$('#totalPrice').val($('#quantityProduct').val()*$('#priceProduct').val());
	$('#exp_totalPrice').val($('#exp_quantityProduct').val()*$('#exp_priceProduct').val());
	
	$('#quantityProduct').on('input', function(){
		var quantityProduct = $('#quantityProduct').val();
		var priceProduct = $('#priceProduct').val();

		$('#totalPrice').val( quantityProduct * priceProduct);
	});

	$('#exp_quantityProduct').on('input', function(){
		var exp_quantityProduct = $('#exp_quantityProduct').val();
		var exp_priceProduct = $('#exp_priceProduct').val();

		$('#exp_totalPrice').val( exp_quantityProduct * exp_priceProduct);
	});

	$('#priceProduct').on('input',function(){
		var quantityProduct = $('#quantityProduct').val();
		var priceProduct = $('#priceProduct').val();

		$('#totalPrice').val( quantityProduct * priceProduct);
	});

	$('#exp_priceProduct').on('input',function(){
		var exp_quantityProduct = $('#exp_quantityProduct').val();
		var exp_priceProduct = $('#exp_priceProduct').val();

		$('#exp_totalPrice').val( exp_quantityProduct * exp_priceProduct);
	});

	$('#depots-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
			url: '{{ route('depots') }}',
			type: 'post'
        }, 
        language: {
		    "emptyTable":     "{{ trans('datatables.emptyTable') }}",
		    "info":           "{{ trans('datatables.info') }}",
		    "infoEmpty":      "{{ trans('datatables.infoEmpty') }}",
		    "infoFiltered":   "{{ trans('datatables.infoFiltered') }}",
		    "lengthMenu":     "{{ trans('datatables.lengthMenu') }}",
		    "loadingRecords": "{{ trans('datatables.loadingRecords') }}",
		    "processing":     "{{ trans('datatables.processing') }}",
		    "search":         "{{ trans('datatables.search') }}",
		    "zeroRecords":    "{{ trans('datatables.zeroRecords') }}",
		    "paginate": {
		        "first":      "{{ trans('datatables.paginate.first') }}",
		        "last":       "{{ trans('datatables.paginate.last') }}",
		        "next":       "{{ trans('datatables.paginate.next') }}",
		        "previous":   "{{ trans('datatables.paginate.previous') }}"
		    },
		    "aria": {
		        "sortAscending":  "{{ trans('datatables.aria.sortAscending') }}",
		        "sortDescending": "{{ trans('datatables.aria.sortDescending') }}"
		    }
		}
    });

    $('#productName').on('change', function(){
    	let productName = $("#productName option:selected").text();
		getStoragesProduct( productName);
    });

    $('#storageProduct').on('change', function(){
    	let productName = $("#productName option:selected").text();
		let storageProduct = $("#storageProduct option:selected").text();
		getQualitiesProduct( productName, storageProduct);
    });

    $('#qualityProduct').on('change', function(){
    	let productName = $("#productName option:selected").text();
		let storageProduct = $("#storageProduct option:selected").text();
		let qualityProduct = $("#qualityProduct option:selected").text();
		getColorsProduct( productName, storageProduct, qualityProduct);
    });

    function getProductName(){
		$.ajax({
			url: '{{ route('productsname') }}',
			type: 'GET',
			async: false
		})
		.done(function(data) {
			$('#productName')
			    .find('option')
			    .remove()
			    .end();
			$('#productName').prop('disabled', false);
			$.each( data, function( key, object ) {
				$('#productName').append($('<option>', { 
			        text : object.product_name 
			    }));
			});
			
			$('#exp_productName')
			    .find('option')
			    .remove()
			    .end();
			$('#exp_productName').prop('disabled', false);
			$.each( data, function( key, object ) {
				$('#exp_productName').append($('<option>', { 
			        text : object.product_name 
			    }));
			});
		});
    }

    function getStoragesProduct( product_name){
		$.ajax({
			url: '{{ route('storagesproduct') }}',
			type: 'GET',
			async: false,
			data: {
				product_name: product_name
			}
		})
		.done(function(data) {
			$('#storageProduct')
			    .find('option')
			    .remove()
			    .end();
			$('#storageProduct').prop('disabled', false);
			$.each( data, function( key, object ) {
				$('#storageProduct').append($('<option>', { 
			        text : object.storage_product
			    }));
			});
			
			$('#exp_storageProduct')
			    .find('option')
			    .remove()
			    .end();
			$('#exp_storageProduct').prop('disabled', false);
			$.each( data, function( key, object ) {
				$('#exp_storageProduct').append($('<option>', { 
			        text : object.storage_product
			    }));
			});
		});
    }

    function getQualitiesProduct( product_name, storage_product){
    	$.ajax({
			url: '{{ route('qualitiesproduct') }}',
			type: 'GET',
			async: false,
			data: {
				product_name: product_name,
				storage_product: storage_product
			}
		})
		.done(function(data) {
			$('#qualityProduct')
			    .find('option')
			    .remove()
			    .end();
			$('#qualityProduct').prop('disabled', false);
			$.each( data, function( key, object ) {
				$('#qualityProduct').append($('<option>', { 
			        text : object.quality_product
			    }));
			});
			
			$('#exp_qualityProduct')
			    .find('option')
			    .remove()
			    .end();
			$('#exp_qualityProduct').prop('disabled', false);
			$.each( data, function( key, object ) {
				$('#exp_qualityProduct').append($('<option>', { 
			        text : object.quality_product
			    }));
			});
		});
    }

    function getColorsProduct( product_name, storage_product, quality_product){
    	$.ajax({
			url: '{{ route('colorsproduct') }}',
			type: 'GET',
			async: false,
			data: {
				product_name: product_name,
				storage_product: storage_product,
				quality_product: quality_product
			}
		})
		.done(function(data) {
			$('#colorProduct')
			    .find('option')
			    .remove()
			    .end();
			$('#colorProduct').prop('disabled', false);
			$.each( data, function( key, object ) {
				$('#colorProduct').append($('<option>', { 
			        text : object.color_product
			    }));
			});
			
			$('#exp_colorProduct')
			    .find('option')
			    .remove()
			    .end();
			$('#exp_colorProduct').prop('disabled', false);
			$.each( data, function( key, object ) {
				$('#exp_colorProduct').append($('<option>', { 
			        text : object.color_product
			    }));
			});
		});
    }
@endsection