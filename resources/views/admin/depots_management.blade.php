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
	#div_quantityProduct {
		margin: 0;
		padding-left: 0;
	}

	#label_quantityProduct {
		text-align: right;
	}

	#div_qualityProduct,
	#div_quantityProduct {
		padding-right: 0;
	}
}	
</style>
@endsection

@section('content')
	<div class="form-group">
		<button class="btn btn-primary btn-flat" id="btn_input_depot" data-toggle="modal" data-target="#input_depot">
			<i class="fa fa-arrow-down"></i> Nhập hàng
		</button>
		<button class="btn btn-success btn-flat" id="btn_output_depot" data-toggle="modal" data-target="#output_depot">
			<i class="fa fa-arrow-up"></i> Xuất hàng
		</button>
	</div>
	<div class="box">
		<div class="box-header">
			<h3 class="box-title text-info">Danh sách các đơn hàng</h3>
		</div>
		<div class="box-body">
			<table id="depots-table" class="table table-bordered table-striped dataTable">
				<thead>
					<tr>
						<td>Mã đơn</td>
						<td>Người bán (mua)</td>
						<td>Sản phẩm</td>
						<td>Bộ nhớ</td>
						<td>Màu</td>
						<td>Loại hàng</td>
						<td>Giá</td>
						<td>Số lượng</td>
						<td>Thành tiền</td>
						<td>Ghi chú</td>
						<td>Ngày tạo đơn</td>
						<td>Đơn nhập</td>
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
{{-- 					        <div class="form-group">
					            
					            <div class="col-sm-9">
					            </div>
					        </div> --}}
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
						        	<input type="text" class="form-control" id="buyer" placeholder="Nhập người mua">
			                  	</div>
					        </div>
					        <div class="form-group">
					        	<label for="productName" class="col-sm-3 control-label">Sản phẩm</label>
					        	<div class="col-sm-9">
					        		<div id="div_productName" class="col-sm-4 form-group">
							        	<select class="form-control" id="output_productName">
					                  	</select>
				                  	</div>
					        		<div id="div_storageProduct" class="col-sm-4 form-group">
					        			<select class="form-control" id="output_storageProduct">
					        				<option value="0">Bộ nhớ</option>
					        				<option value="1">16 GB</option>
					        				<option value="2">32 GB</option>
					        				<option value="3">64 GB</option>
					        				<option value="4">128 GB</option>
					        				<option value="5">256 GB</option>
					                  	</select>
					        		</div>
					        		<div id="div_qualityProduct" class="col-sm-4 form-group">
					        			<select class="form-control" id="output_qualityProduct">
					        				<option value="0">Chất lượng</option>
					        				<option value="1">95 %</option>
					        				<option value="2">99 %</option>
					        				<option value="3">New</option>
					                  	</select>
					        		</div>
			                  	</div>
					        </div>
					        
					        <div class="form-group">
					            <label for="" class="col-sm-3 control-label">Ghi chú</label>
					            <div class="col-sm-9">
					                <textarea rows="3" class="form-control" id="" placeholder="Nhập thông tin về đơn hàng"></textarea>
					            </div>
					        </div>
					    </div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-rotate-left"></i> Hủy bỏ</button>
					<button type="button" id="" class="btn btn-default btn-flat btn-success"><i class="fa fa-save"></i> Lưu</button>
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
	
	$('#btn_input_depot').on('click', function(){
		getProductName();
		setTimeout(function(){
			var productName = $("#productName option:first").text();
			getStoragesProduct( productName);
			setTimeout(function(){
				var storageProduct = $("#storageProduct option:first").text();
				getQualitiesProduct( productName, storageProduct);
				setTimeout(function(){
					var qualityProduct = $("#qualityProduct option:first").text();
					getColorsProduct( productName, storageProduct, qualityProduct);
				}, 800);
			}, 600);
		}, 300);
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
		if ( $('#storageProduct').val() != 0 && $('#qualityProduct').val() != 0){
			var saler = $('#saler').val();
			var productId = $('#productName').val();
			var storageProduct = $('#storageProduct').find(":selected").text();
			var qualityProduct = $('#qualityProduct').find(":selected").text();
			var colorProduct = $('#colorProduct').find(":selected").text();
			var quantityProduct = $('#quantityProduct').val();
			var inputDate = $('#inputDate').val();
			var priceProduct = $('#priceProduct').val();
			var totalPrice = $('#totalPrice').val();
			var depotNote = $('#depotNote').val();
			
			var data = {
				isInput: 1,
				saler: saler,
				productId: productId,
				storageProduct: storageProduct,
				qualityProduct: qualityProduct,
				colorProduct: colorProduct,
				quantityProduct: quantityProduct,
				inputDate: inputDate,
				priceProduct: priceProduct,
				totalPrice: totalPrice,
				depotNote: depotNote
			};
	
			$.ajax({
				url: '{{ route('depots.store') }}',
				type: 'POST',
				data: data,
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
				$('#depots-table').DataTable().ajax.reload();
			});
		}
		else {
			if ( $('#storageProduct').val() == 0 ) {
				$('#storageProduct').focus();
			}
			else {
				$('#qualityProduct').focus();
			}
		}
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

    function getProductName(){
		$.ajax({
			url: '{{ route('productsname') }}',
			type: 'GET'
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
			
		});
    }

    function getStoragesProduct( product_name){
		$.ajax({
			url: '{{ route('storagesproduct') }}',
			type: 'GET',
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
			
		});
    }

    function getQualitiesProduct( product_name, storage_product){
    	$.ajax({
			url: '{{ route('qualitiesproduct') }}',
			type: 'GET',
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
			
		});
    }

    function getColorsProduct( product_name, storage_product, quality_product){
    	$.ajax({
			url: '{{ route('colorsproduct') }}',
			type: 'GET',
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
			
		});
    }
@endsection