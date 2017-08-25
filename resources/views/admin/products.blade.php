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
	<h1>Danh sách sản phẩm</h1>
@endsection

@section('content')
	<div class="row">
		@isset ( $total_products)
	    <div class="col-md-3 col-sm-6 col-xs-12">
	        <div class="info-box button" id="creditAll">
	            <span class="info-box-icon bg-aqua"><i class="fa fa-opencart"></i></span>
	            <div class="info-box-content">
	                <span class="info-box-text">Tổng sản phẩm</span>
	                <span class="info-box-number">{{ $total_products }}</span>
	                <span class="info-box-text"><i>Sản phẩm</i></span>
	            </div>
	            <!-- /.info-box-content -->
	        </div>
	        <!-- /.info-box -->
	    </div>
	    <!-- /.col -->
	    @endisset
	    @isset ( $most_product)
	    <div class="col-md-3 col-sm-6 col-xs-12">
	        <div class="info-box">
	            <span class="info-box-icon bg-red"><i class="fa fa-cart-plus"></i></span>
	            <div class="info-box-content">
	                <span class="info-box-text">Loại nhiều nhất
	                	<br>
	                	<span class="text-primary"><i>{{ $most_product->name }}</i></span>
	                </span>
	                <span class="info-box-number">{{ $most_product->quantity }}</span>
	            </div>
	            <!-- /.info-box-content -->
	        </div>
	        <!-- /.info-box -->
	    </div>
	    <!-- /.col -->
	    @endisset
	</div>
	<div class="form-group">
		<button class="btn btn-primary btn-flat" id="btn_add_product" data-toggle="modal" data-target="#create_product"><i class="fa fa-plus"></i> Thêm mới</button>
	</div>
	<div class="box">
		<div class="box-header">
			<h3 class="box-title">Sản phẩm</h3>
		</div>
		<div class="box-body">
			<div class="table-responsive">
				<table id="products-table" class="table table-bordered table-hover">
					<thead>
						<tr>
							<td>Mã SP</td>
							<td>Sản phẩm</td>
							<td>Màu</td>
							<td>Bộ nhớ</td>
							<td>Clượng</td>
							<td>Loại</td>
							<td>Nhà SX</td>
							<td>Số máy</td>
							<td>Ghi chú</td>
							<td>Ngày cập nhật</td>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<td>Mã SP</td>
							<td>Sản phẩm</td>
							<td>Màu</td>
							<td>Bộ nhớ</td>
							<td>Clượng</td>
							<td>Loại</td>
							<td>Nhà SX</td>
							<td>Số máy</td>
							<td>Ghi chú</td>
							<td>Ngày cập nhật</td>
						</tr>
					</tfoot>
				</table>
			</div>
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
					        	<label for="product_name" class="col-sm-3 control-label">Thuộc tính</label>
					        	<div class="col-sm-9">
					        		<div id="colorProduct" class="col-sm-4 form-group">
					        			@foreach ( Config::get('array.COLORS'); as $color)
										<div class="checkbox">
									        <label>
									            <input type="checkbox" name="colors" value="{{ $color }}">  {{ $color }}
									        </label>
									    </div>					        				
					        			@endforeach
				                  	</div>
					        		<div id="storageProduct" class="col-sm-4 form-group">
					        			@foreach ( Config::get('array.STORAGES'); as $storage)
					        			<div class="checkbox">
									        <label>
									            <input type="checkbox" name="storages" value="{{ $storage }}">  {{ $storage }}
									        </label>
									    </div>
									    @endforeach
					        		</div>
					        		<div id="qualityProduct" class="col-sm-4 form-group">
					        			@foreach ( Config::get('array.QUALITIES'); as $quality)
					        			<div class="checkbox">
									        <label>
									            <input type="checkbox" name="qualities" value="{{ $quality }}">  {{ $quality }}
									        </label>
									    </div>
									    @endforeach
									    @foreach ( Config::get('array.VERSIONS'); as $version)
					        			<div class="radio">
									        <label>
									            <input type="radio" name="versions" value="{{ $loop->index }}" checked>  {{ $version }}
									        </label>
									    </div>
									    @endforeach
					        		</div>
			                  	</div>
					        </div>
					        <div class="form-group">
								<label for="quantity_in_stock" class="col-sm-3 control-label">Số lượng ở kho</label>
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
					        	<label for="info_vendorName" class="col-sm-3 control-label">Hãng sản xuất</label>
					        	<div class="col-sm-9">
						        	<select class="form-control" id="info_vendorName">
				                  	</select>
			                  	</div>
					        </div>
					        <div class="form-group">
								<label for="info_quantity_in_stock" class="col-sm-3 control-label">Số lượng</label>
								<div class="col-sm-9">
									<input type="number" value="0" class="form-control" id="info_quantity_in_stock">
								</div>
					        </div>
					        <div class="form-group">
					        	<label for="product_name" class="col-sm-3 control-label">Thuộc tính</label>
					        	<div class="col-sm-9">
					        		<div id="colorProduct" class="col-sm-3 form-group">
									    <div class="checkbox">
									        <p class="text-bold" id="info_colorProduct"></p>
									    </div>
				                  	</div>
					        		<div id="storageProduct" class="col-sm-3 form-group">
					        			<div class="checkbox">
									        <p class="text-bold" id="info_storageProduct"></p>
									    </div>
					        		</div>
					        		<div id="qualityProduct" class="col-sm-3 form-group">
					        			<div class="checkbox">
									        <p class="text-bold" id="info_qualityProduct"></p>
									    </div>
								    </div>
								    <div id="qualityProduct" class="col-sm-3 form-group">
					        			<div class="checkbox">
									        <p class="text-bold" id="info_versionProduct"></p>
									    </div>
					        		</div>
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
<!-- iCheck -->
<script src="{{ asset('plugins/iCheck/icheck.min.js') }}"></script>
<!-- Chart.js -->
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
@endsection

@section('js_ext')

	var colors 		= [];
	var storages 	= [];
	var qualities 	= [];
	var isQuocTe	= true;
	var id;

	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});

	{{-- Setup iCheck --}}
	$('input').iCheck({
	    radioClass: 'iradio_flat-blue',
	    checkboxClass: 'icheckbox_flat-blue',
	});
	{{-- End Setup iCheck --}}

	{{-- Setup display modal add new product --}}
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

		$('input:radio[name="versions"][value="1"]').iCheck('check');

		$('input').on('ifChecked', function(event){
	  		if ( $(this).attr('name') == 'colors' ) {
	  			if ( $.inArray( $(this).val(), colors) == -1 ) colors.push($(this).val());
	  		}
	  		else if ( $(this).attr('name') == 'storages' ) {
	  			if ( $.inArray( $(this).val(), storages) == -1 ) storages.push($(this).val());
	  		}
	  		else if ( $(this).attr('name') == 'qualities') {
	  			if ( $.inArray( $(this).val(), qualities) == -1 ) qualities.push($(this).val());
	  		}
	  		else if ( $(this).attr('name') == 'versions') {
	  			if ( $(this).val() == '1' ) {
	  				isQuocTe = true;
	  			}
	  			else {
	  				isQuocTe = false;
	  			}
	  		}
		});

		$('input').on('ifUnchecked', function(event){
	  		if ( $(this).attr('name') == 'colors' ) {
	  			colors.splice( $.inArray($(this).val(), colors), 1 );
	  		}
	  		else if ( $(this).attr('name') == 'storages' ) {
	  			storages.splice( $.inArray($(this).val(), storages), 1 );
	  		}
	  		else if ( $(this).attr('name') == 'qualities') {
	  			qualities.splice( $.inArray($(this).val(), qualities), 1 );
	  		}
		});
	});
	{{-- End Setup display modal add new product --}}
	
	{{-- Add new product --}}
	$('#btn_save_product').on('click', function(){
		var vendor_id	 = $('#vendor').val();
		var product_name = $('#product_name').val();
		var quantity_in_stock = $('#quantity_in_stock').val();
		var product_info = $('#product_info').val();
		var data = { 
				vendor_id: vendor_id,
				product_name: product_name,
				colors: colors,
				storages: storages,
				qualities: qualities,
				is_quocte: isQuocTe,
				quantity_in_stock: quantity_in_stock,
				product_info: product_info
			};
		
		$.ajax({
			url: '{{ route('products.store') }}',
			type: 'POST',
			data: data,
			async: false
		})
		.done(function(data) {
			$('#product_name').val('');
			$('#quantity_in_stock').val(0);
			$('#product_info').val('');
			$('input').iCheck('uncheck');
			colors = [];
			storages = [];
			qualities = [];
			isQuocTe = true;
			$('#create_product').modal('toggle');
		})
		.always(function(){
			$('#products-table').DataTable().ajax.reload();
	    })
	});
	{{-- End Add new product --}}

	{{-- Setup Datatables --}}
	$('#products-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
        	url: '{{ route('products') }}',
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
		},
		columns: [
            {data: 'id', name: 'id'},
            {data: 'product_name', name: 'product_name'},
            {data: 'color_product', name: 'color_product'},
            {data: 'storage_product', name: 'storage_product'},
            {data: 'quality_product', name: 'quality_product'},
            {data: 'version', name: 'version'},
            {data: 'vendor_name', name: 'vendor_name'},
            {data: 'quantity_in_stock', name: 'quantity_in_stock'},
            {data: 'product_info', name: 'product_info'},
            {data: 'updated_at', name: 'updated_at'},
        ],
        initComplete: function () {
            this.api().columns().every(function () {
                var column = this;
                var input = document.createElement("input");
                $(input).appendTo($(column.footer()).empty())
                .on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex($(this).val());

                    column.search(val ? val : '', true, false).draw();
                });
            });
        }
    });
    {{-- End Datatables --}}

    $('#products-table tbody').on('click', 'tr', function(e){
    	$('#info_product').modal('toggle');
		$('#info_productName').val($(this).find("td:eq(1)").html());
		$('#info_colorProduct').text($(this).find("td:eq(2)").html());
		$('#info_storageProduct').text($(this).find("td:eq(3)").html());
		$('#info_qualityProduct').text($(this).find("td:eq(4)").html());
		$('#info_versionProduct').text($(this).find("td:eq(5)").html());
		$('#info_quantity_in_stock').val($(this).find("td:eq(7)").html());
		$('#info_categoryNote').val($(this).find("td:eq(8)").html());

		var vendor = $(this).find("td:eq(2)").html();
		id = $(this).find("td:eq(0)").html();

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
		});
    });

    $('#btn_delete').on('click', function(){		
		var url = "{!! route('products.delete',['id'=>':id']) !!}";
        url =  url.replace(':id', id);

		$.ajax({
			url: url,
			type: 'POST',
			async: false,
			data: {
				method: 'DELETE'
			}
		})
		.done(function(data) {
			$('#info_product').modal('toggle');
		})
		.always(function(){
			$('#products-table').DataTable().ajax.reload();
	    });
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
			async: false,
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
		})
		.always(function(){
			$('#products-table').DataTable().ajax.reload();
	    })
	});

@endsection