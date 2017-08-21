@extends('admin.components.template')

@section('lib_css_ext')
<link rel="stylesheet" href="{{ asset('plugins/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
<!-- iCheck -->
<link rel="stylesheet" href="{{ asset('plugins/iCheck/all.css') }}">
<style type="text/css">
table#members-table thead tr td,
.text-bold {
	font-weight: bold;
}

.text-bold {
	text-align: center;
}

div.radio div.col-sm-4,
div.radio label {
	padding-left: 0;
}
</style>
@endsection

@section('title_header')
	<h1 class="text-info">Quản lý khách hàng</h1>
@endsection

@section('content')
	<div class="form-group">
		<button class="btn btn-primary btn-flat" id="btn_add_product" data-toggle="modal" data-target="#create_guest"><i class="fa fa-user-plus"></i> Thêm mới</button>
	</div>
	
	<div class="box">
		<div class="box-header">
			<h3 class="box-title">Danh sách khách hàng</h3>
		</div>
		<div class="box-body">
			<table id="members-table" class="table table-bordered table-hover">
				<thead>
					<tr>
						<td>STT</td>
						<td>Tên</td>
						<td>SĐT</td>
						<td>Giới tính</td>
						<td>Địa chỉ</td>
						<td>Ghi chú</td>
						<td>Công - Nợ</td>
					</tr>
				</thead>
			</table>
		</div>
	</div>

	<!-- Modal Create-->
	<div id="create_guest" class="modal fade" role="dialog">
	  	<div class="modal-dialog">
	    <!-- Modal content-->
		    <div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title text-green">Thêm mới khách hàng</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal">
					    <div class="box-body">
					        <div class="form-group">
								<label for="guestName" class="col-sm-3 control-label">Tên khách hàng</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="guestName" placeholder="VD: Cho Tao Tim">
								</div>
					        </div>
					        <div class="form-group">
								<label for="guestPhone" class="col-sm-3 control-label">Số điện thoại</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="guestPhone" placeholder="VD: 0912345678">
								</div>
					        </div>
					        <div class="form-group">
								<label for="gender" class="col-sm-3 control-label">Giới tính</label>
								<div class="radio col-sm-9">
									<div class="col-sm-4">
							        	<label>
							            	<input type="radio" value="0" name="gender" checked> Nam
							        	</label>
						        	</div>
						        	<div class="col-sm-4">
							        	<label>
								            <input type="radio" value="1" name="gender"> Nữ
							        	</label>
						        	</div>
							    </div>
					        </div>
					        <div class="form-group">
								<label for="guestAddress" class="col-sm-3 control-label">Địa chỉ</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="guestAddress" placeholder="Nhập địa chỉ">
								</div>
					        </div>
					        <div class="form-group">
								<label for="guestNote" class="col-sm-3 control-label">Ghi chú</label>
								<div class="col-sm-9">
									<textarea rows="4" type="text" class="form-control" id="guestNote" placeholder="Ghi chú về khách hàng"></textarea>
								</div>
					        </div>
					    </div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-rotate-left"></i> Hủy bỏ</button>
					<button type="button" id="btnSaveGuest" class="btn btn-default btn-flat btn-success"><i class="fa fa-save"></i> Lưu</button>
				</div>
		    </div>
	  	</div>
	</div>
	<!-- Modal Create-->

	<!-- Modal View, Edit, Delete-->
	<div id="info_guest" class="modal fade" role="dialog">
	  	<div class="modal-dialog">
	    <!-- Modal content-->
		    <div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title text-green">Thông tin khách hàng</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal">
					    <div class="box-body">
					        <div class="form-group">
								<label for="info_guestName" class="col-sm-3 control-label">Tên khách hàng</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="info_guestName">
								</div>
					        </div>
					        <div class="form-group">
								<label for="info_guestPhone" class="col-sm-3 control-label">Số điện thoại</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="info_guestPhone">
								</div>
					        </div>
					        <div class="form-group">
								<label for="info_gender" class="col-sm-3 control-label">Giới tính</label>
								<div class="radio col-sm-9">
									<div class="col-sm-4">
							        	<label>
							            	<input type="radio" value="0" name="info_gender"> Nam
							        	</label>
						        	</div>
						        	<div class="col-sm-4">
							        	<label>
								            <input type="radio" value="1" name="info_gender"> Nữ
							        	</label>
						        	</div>
							    </div>
					        </div>
					        <div class="form-group">
								<label for="info_guestAddress" class="col-sm-3 control-label">Địa chỉ</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="info_guestAddress">
								</div>
					        </div>
					        <div class="form-group">
								<label for="info_debt" class="col-sm-3 control-label">Công Nợ</label>
								<div class="col-sm-9">
									<input type="number" class="form-control" id="info_debt" disabled="true">
								</div>
					        </div>
					        <div class="form-group">
								<label for="info_guestNote" class="col-sm-3 control-label">Ghi chú</label>
								<div class="col-sm-9">
									<textarea rows="2" type="text" class="form-control" id="info_guestNote"></textarea>
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
@endsection

@section('js_ext')
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
@endsection