@extends('admin.components.template')

@section('lib_css_ext')
<link rel="stylesheet" href="{{ asset('plugins/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('title_header')
	<h1>Danh sách sản phẩm</h1>
@endsection

@section('content')
	<div class="form-group">
		<button class="btn btn-primary btn-flat" id="btn_add_product" data-toggle="modal" data-target="#create_product"><i class="fa fa-plus"></i> Thêm mới</button>
	</div>
	
	<div class="box">
		<div class="box-header">
			<h3 class="box-title">Sản phẩm</h3>
		</div>
		<div class="box-body">
			<table id="products-table" class="table table-bordered table-hover">
				<thead>
					<tr>
						<td>Mã</td>
						<td>Tên sản phẩm</td>
						<td>Nhà sản xuất</td>
						<td>Số lượng tại kho</td>
						<td>Ghi chú</td>
						<td>Ngày tạo</td>
					</tr>
				</thead>
			</table>
		</div>
	</div>

	<!-- Modal Create-->
	<div id="create_product" class="modal fade" role="dialog">
	  	<div class="modal-dialog">
	    <!-- Modal content-->
		    <div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title text-green">Thêm mới sản phẩm</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal">
					    <div class="box-body">
					        <div class="form-group">
					        	<label for="vendor" class="col-sm-3 control-label">Hãng sản xuất</label>
					        	<div class="col-sm-9">
						        	<select class="form-control" id="vendor">
				                  	</select>
			                  	</div>
					        </div>
					        <div class="form-group">
								<label for="product_name" class="col-sm-3 control-label">Tên sản phẩm</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="product_name" placeholder="Tên sản phẩm (Ex. iphone 5, galaxy s7, iphone 6+...)">
								</div>
					        </div>
					        <div class="form-group">
								<label for="quantity_in_stock" class="col-sm-3 control-label">Số lượng trong kho</label>
								<div class="col-sm-9">
									<input type="number" value="0" class="form-control" id="quantity_in_stock" placeholder="Nhập số lượng hiện có trong kho">
								</div>
					        </div>
					        <div class="form-group">
								<label for="product_info" class="col-sm-3 control-label">Thông tin (ghi chú) sản phẩm</label>
								<div class="col-sm-9">
									<textarea rows="4" type="text" class="form-control" id="product_info" placeholder="Thông tin ghi chú về sản phẩm"></textarea>
								</div>
					        </div>
					    </div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-rotate-left"></i> Hủy bỏ</button>
					<button type="button" id="btn_save_product" class="btn btn-default btn-flat btn-success"><i class="fa fa-save"></i> Lưu</button>
				</div>
		    </div>
	  	</div>
	</div>
	<!-- Modal Create-->

	<!-- Modal View, Edit, Delete-->
	<div id="info_product" class="modal fade" role="dialog">
	  	<div class="modal-dialog">
	    <!-- Modal content-->
		    <div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title text-green">Thông tin sản phẩm</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal">
					    <div class="box-body">
					        <div class="form-group">
					            <label for="info_productName" class="col-sm-3 control-label">Tên sản phẩm</label>
					            <div class="col-sm-9">
					                <input type="text" class="form-control" id="info_productName">
					            </div>
					        </div>
					        <div class="form-group">
					        	<label for="info_vendorName" class="col-sm-3 control-label">Hãng sản xuât</label>
					        	<div class="col-sm-9">
						        	<select class="form-control" id="info_vendorName">
				                  	</select>
			                  	</div>
					        </div>
					        <div class="form-group">
								<label for="info_quantity_in_stock" class="col-sm-3 control-label">Số lượng trong kho</label>
								<div class="col-sm-9">
									<input type="number" value="0" class="form-control" id="info_quantity_in_stock">
								</div>
					        </div>
					        <div class="form-group">
					            <label for="info_productNote" class="col-sm-3 control-label">Ghi chú</label>
					            <div class="col-sm-9">
					                <textarea rows="5" class="form-control" id="info_productNote" placeholder="Nhập thông tin về sản phẩm"></textarea>
					            </div>
					        </div>
					    </div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" id="btn_delete" class="btn btn-default btn-flat btn-danger pull-left"><i class="fa fa-trash"></i> Xóa</button>
					<button type="button" class="btn btn-default btn-flat"  data-dismiss="modal"><i class="fa fa-rotate-left"></i> Trở về</button>
					<button type="button" id="btn_update" class="btn btn-default btn-flat btn-success"><i class="fa fa-refresh"></i> Cập nhật</button>
				</div>
		    </div>
	  	</div>
	</div>
	<!-- Modal View, Edit, Delete-->
@endsection

@section('lib_js_ext')
<!-- DataTables -->
<script src="{{ asset('plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
@endsection

@section('js_ext')
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});

	// Get vendor name of product
	$('#btn_add_product').on('click', function(){
		$.ajax({
			url: '{{ route('categoryname') }}',
			type: 'GET'
		})
		.done(function(data) {
			$('#vendor')
			    .find('option')
			    .remove()
			    .end();

			$.each( data, function( key, object ) {
				$('#vendor').append($('<option>', { 
			        value: object.id,
			        text : object.category_name 
			    }));
			});
		})
		.fail(function() {
			console.log("error");
		});
	});
	
	// Add new product
	$('#btn_save_product').on('click', function(){
		var vendor_id	 = $('#vendor').val();
		var product_name = $('#product_name').val();
		var quantity_in_stock = $('#quantity_in_stock').val();
		var product_info = $('#product_info').val();

		$.ajax({
			url: '{{ route('products.store') }}',
			type: 'POST',
			data: { 
				vendor_id: vendor_id,
				product_name: product_name,
				quantity_in_stock: quantity_in_stock,
				product_info: product_info
			},
		})
		.done(function(data) {
			$('#product_name').val('');
			$('#quantity_in_stock').val('');
			$('#product_info').val('');
			$('#create_product').modal('toggle');
			$('#products-table').DataTable().ajax.reload();
		})
		.fail(function() {
			console.log("error");
		});
	});

	$('#products-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('products') }}',
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

    $('#products-table tbody').on('click', 'tr', function(e){
    	$('#info_product').modal('toggle');
		$('#info_productName').val($(this).find("td:eq(1)").html());
		$('#info_quantity_in_stock').val($(this).find("td:eq(3)").html());
		$('#info_categoryNote').val($(this).find("td:eq(4)").html());

		var vendor = $(this).find("td:eq(2)").html();
		var id = $(this).find("td:eq(0)").html();

    	$.ajax({
			url: '{{ route('categoryname') }}',
			type: 'GET'
		})
		.done(function(data) {
			$('#info_vendorName')
			    .find('option')
			    .remove()
			    .end();

			$.each( data, function( key, object ) {
				$('#info_vendorName').append($('<option>', { 
			        value: object.id,
			        text : object.category_name 
			    }));
			});
			
			$('#info_vendorName option').each(function() {
				if($(this).html() == vendor ){ 
		            $(this).attr("selected","selected");    
		        }
			});	
		})
		.fail(function() {
			console.log("error");
		});		
		
		$('#btn_delete').on('click', function(){		
			var url = "{!! route('products.delete',['id'=>':id']) !!}";
	        url =  url.replace(':id', id);

			$.ajax({
				url: url,
				type: 'POST',
				data: {
					method: 'DELETE'
				}
			})
			.done(function(data) {
				$('#info_product').modal('toggle');
				$('#products-table').DataTable().ajax.reload();
			})
			.fail(function() {
				console.log("error");
			})
		});
		
		$('#btn_update').on('click', function(){
			var url = "{!! route('products.update',['id'=>':id']) !!}";
	        url =  url.replace(':id', id);
			var vendor_id = $('#info_vendorName').val();
			var product_name = $('#info_productName').val();
			var quantity_in_stock = $('#info_quantity_in_stock').val();
			var product_info = $('#info_productNote').val();

			$.ajax({
				url: url,
				type: 'POST',
				data: {
					method: 'PUT',
					vendor_id: vendor_id,
					product_name: product_name,
					quantity_in_stock: quantity_in_stock,
					product_info: product_info
				}
			})
			.done(function(data) {
				$('#info_product').modal('toggle');
				$('#products-table').DataTable().ajax.reload();
			})
			.fail(function() {
				console.log("error");
			})
		});

    });

@endsection