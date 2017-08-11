@extends('admin.components.template')

@section('lib_css_ext')
<link rel="stylesheet" href="{{ asset('plugins/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('title_header')
	<h1 class="text-info">Quản lý danh sách người mua</h1>
@endsection

@section('content')
	<div class="form-group">
		<button class="btn btn-primary btn-flat" id="btn_add_product" data-toggle="modal" data-target="#create_user"><i class="fa fa-user-plus"></i> Thêm mới</button>
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
						<td>Ghi chú</td>
						<td>Ngày tạo</td>
					</tr>
				</thead>
			</table>
		</div>
	</div>

	<!-- Modal Create-->
	<div id="create_user" class="modal fade" role="dialog">
	  	<div class="modal-dialog">
	    <!-- Modal content-->
		    <div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title text-green">Thêm mới người mua</h4>
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

@endsection