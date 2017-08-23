@extends('admin.components.template')

@section('lib_css_ext')
<link rel="stylesheet" href="{{ asset('plugins/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="{{ asset('plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<!-- iCheck -->
<link rel="stylesheet" href="{{ asset('plugins/iCheck/all.css') }}">
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.min.css') }}">
<style type="text/css">
thead tr td,
.text-bold {
	font-weight: bold;
}

.text-bold {
	text-align: center;
}

tbody tr td:nth-child(3),
tbody tr td:nth-child(4),
tbody tr td:nth-child(5) {
	text-align: right;
}

div.radio div.col-sm-4,
div.radio label {
	padding-left: 0;
}
</style>
@endsection

@section('title_header')
	<h1 class="text-info">Quản lý Công - Nợ</h1>
@endsection

@section('content')

	<div class="row">
	    <div class="col-md-3 col-sm-6 col-xs-12">
	        <div class="info-box button" id="creditAll">
	            <span class="info-box-icon bg-aqua"><i class="fa fa-plus"></i></span>
	            <div class="info-box-content">
	                <span class="info-box-text">Tổng công toàn phần</span>
	                <span class="info-box-number">57.650.000</span>
	            </div>
	            <!-- /.info-box-content -->
	        </div>
	        <!-- /.info-box -->
	    </div>
	    <!-- /.col -->
	    <div class="col-md-3 col-sm-6 col-xs-12">
	        <div class="info-box">
	            <span class="info-box-icon bg-green"><i class="fa fa-minus"></i></span>
	            <div class="info-box-content">
	                <span class="info-box-text">Tổng nợ toàn phần</span>
	                <span class="info-box-number">12.350.000</span>
	            </div>
	            <!-- /.info-box-content -->
	        </div>
	        <!-- /.info-box -->
	    </div>
	    <!-- /.col -->
	    <div class="col-md-3 col-sm-6 col-xs-12">
	        <div class="info-box">
	            <span class="info-box-icon bg-yellow"><i class="fa fa-calendar-plus-o"></i></span>
	            <div class="info-box-content">
	                <span class="info-box-text">Tổng công tháng này</span>
	                <span class="info-box-number">7.650.000</span>
	            </div>
	            <!-- /.info-box-content -->
	        </div>
	        <!-- /.info-box -->
	    </div>
	    <!-- /.col -->
	    <div class="col-md-3 col-sm-6 col-xs-12">
	        <div class="info-box">
	            <span class="info-box-icon bg-red"><i class="fa fa-calendar-minus-o"></i></span>
	            <div class="info-box-content">
	                <span class="info-box-text">Tổng nợ tháng này</span>
	                <span class="info-box-number">4.500.000</span>
	            </div>
	            <!-- /.info-box-content -->
	        </div>
	        <!-- /.info-box -->
	    </div>
	    <!-- /.col -->
	</div>

	<div class="form-group">
		<button class="btn btn-primary btn-flat" id="btn_add_debit" data-toggle="modal" data-target="#create_debit"><i class="fa fa-calendar-plus-o"></i> Thêm mới</button>
	</div>

	<div class="box">
		<div class="box-header">
			<h3 class="box-title">Danh sách các công nợ</h3>
		</div>
		<div class="box-body">
			<div class="table-responsive">
				<table id="debits-table" class="table table-bordered table-striped table-hover">
					<thead>
						<tr>
							<td>STT</td>
							<td>Khách hàng (SĐT)</td>
							<td>Số tiền</td>
							<td>Công (Nợ)</td>
							<td>Thanh toán</td>
							<td>Ghi chú</td>
							<td>Ngày giao dịch</td>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<td>STT</td>
							<td>Khách hàng (SĐT)</td>
							<td>Số tiền</td>
							<td>Công (Nợ)</td>
							<td>Thanh toán</td>
							<td>Ghi chú</td>
							<td>Ngày giao dịch</td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>

	<!-- Modal Create-->
	<div id="create_debit" class="modal fade" role="dialog">
	  	<div class="modal-dialog">
	    <!-- Modal content-->
		    <div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title text-green">Thêm mới Công - Nợ</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal">
					    <div class="box-body">
					        <div class="form-group">
								<label for="guestName" class="col-sm-3 control-label">Tên khách hàng</label>
								<div class="col-sm-9">
									<select id="guestName" class="form-control select2" style="width: 100%;">
									</select>
								</div>
					        </div>
					        <div class="form-group">
								<label for="payMoney" class="col-sm-3 control-label">Số tiền</label>
								<div class="col-sm-9">
									<input value="0" class="form-control" id="payMoney">
								</div>
					        </div>
					        <div class="form-group">
								<label for="isDebit" class="col-sm-3 control-label">Hình thức</label>
								<div class="radio col-sm-9">
									<div class="col-sm-4">
							        	<label>
							            	<input type="radio" value="0" name="isDebit" checked> Công
							        	</label>
						        	</div>
						        	<div class="col-sm-4">
							        	<label>
								            <input type="radio" value="1" name="isDebit"> Nợ
							        	</label>
						        	</div>
							    </div>
					        </div>
					        <div class="form-group">
								<label for="done" class="col-sm-3 control-label">Đã quyết toán</label>
								<div class="radio col-sm-9">
									<div class="col-sm-4">
							        	<label>
								            <input type="radio" value="0" name="done" checked> Chưa
							        	</label>
						        	</div>
						        	<div class="col-sm-4">
							        	<label>
							            	<input type="radio" value="1" name="done"> Hoàn thành
							        	</label>
						        	</div>
							    </div>
					        </div>
					        <div class="form-group">
								<label for="date_done" class="col-sm-3 control-label">Ngày quyết toán</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="dateDone" value="{{ \Carbon\Carbon::now()->format('d/m/Y') }}" data-date-format="dd/mm/yyyy">
								</div>
					        </div>
					        <div class="form-group">
								<label for="note" class="col-sm-3 control-label">Ghi chú</label>
								<div class="col-sm-9">
									<textarea rows="4" type="text" class="form-control" id="note" placeholder="Ghi chú về khoản công nợ này (nếu có)"></textarea>
								</div>
					        </div>
					    </div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-rotate-left"></i> Hủy bỏ</button>
					<button type="button" id="btn_save_debit" class="btn btn-default btn-flat btn-success"><i class="fa fa-save"></i> Lưu</button>
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
<!-- bootstrap datepicker -->
<script src="{{ asset('plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap-datepicker/dist/locales/bootstrap-datepicker.vi.min.js') }}" charset="UTF-8"></script>
<!-- InputMask -->
<script src="{{ asset('plugins/inputmask/dist/jquery.inputmask.bundle.js') }}"></script>
<!-- iCheck -->
<script src="{{ asset('plugins/iCheck/icheck.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('plugins/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('plugins/select2/dist/js/i18n/vi.js') }}"></script>
@endsection

@section('js_ext')
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});

	{{-- Date picker --}}
    $('#dateDone').datepicker({
      autoclose: true,
      language: 'vi'
    });
	{{-- End Date picker --}}

	{{-- Setup iCheck --}}
	$('input').iCheck({
	    radioClass: 'iradio_flat-blue',
	    checkboxClass: 'icheckbox_flat-blue',
	});
	{{-- End Setup iCheck --}}

	{{-- Setup Select2 --}}
	$('#guestName').select2({
		language: 'vi',
		placeholder: 'Nhập tên khách hàng',
		ajax: {
			url: '{{ route('membersname') }}',
			cache: true,
			dataType: 'json',
			delay: 300,
			processResults: function(data) {
				return {
					results: $.map(data, function(item) {
						return {
	                        text: item.member_name +  ' - ' + item.member_phone,
	                        id: item.id
	                    }
					})
				}
			}
		}
	});
	{{-- End Setup Select2 --}}

	{{-- Setup InputMask --}}
	$('#payMoney').inputmask("numeric", {
		radixPoint: "",
	    groupSeparator: ".",
	    autoGroup: true,
	    rightAlign: false,
	    autoUnmask: true,
        allowMinus: false
	});
	{{-- End Setup InputMask --}}

	{{-- Setup Datatables --}}
	$('#debits-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
        	url: '{{ route('debits') }}',
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
            {data: 'member_name', name: 'member_name'},
            {data: 'total_amount', name: 'total_amount'},
            {data: 'is_dedit', name: 'is_dedit'},
            {data: 'pay_done', name: 'pay_done'},
            {data: 'debit_note', name: 'debit_note'},
            {data: 'created_at', name: 'created_at'}
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


	$('#btn_save_debit').on('click', function(){
		let id 		  = $('#guestName').val();
		let payMoney  = $('#payMoney').val() || 0;
		let isDebit	  = $("input[name='isDebit']:checked").val();
		let done	  = $("input[name='done']:checked").val();
		let dateDone = $('#dateDone').val();
		let note	  = $('#note').val();

		data = {
			id 			: id,
			payMoney 	: payMoney,
			isDebit 	: isDebit,
			done 		: done,
			dateDone 	: dateDone,
			note 		: note
		}

		$.ajax({
			url: '{{ route('debits.store') }}',
			type: 'POST',
			data: data,
			async: false
		})
		.done(function(data) {
			$('#payMoney').val(0);
			$('input:radio[name="isDebit"][value="0"]').iCheck('check');
			$('input:radio[name="done"][value="0"]').iCheck('check');
			$('#dateDone').val('{{ \Carbon\Carbon::now()->format('d/m/Y') }}');
			$('#note').val('');
			$('#create_debit').modal('toggle');
		})
		.always(function() {
			$('#debits-table').DataTable().ajax.reload();
		});
	});

	$('#creditAll').on('click', function(){
	});
@endsection