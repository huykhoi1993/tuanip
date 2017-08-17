@extends('admin.components.template')

@section('lib_css_ext')
<link rel="stylesheet" href="{{ asset('plugins/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
<style type="text/css">
table#categories-table thead tr td {
	font-weight: bold;
}	
</style>
@endsection

@section('title_header')
	<h1>Danh mục sản phẩm</h1>
@endsection

@section('content')
	<div class="form-group">
		<button class="btn btn-primary btn-flat" id="btn_add_category" data-toggle="modal" data-target="#create_category"><i class="fa fa-plus"></i> Thêm mới</button>
	</div>

	<div class="box">
		<div class="box-header">
			<h3 class="box-title">Categories</h3>
		</div>
		<div class="box-body">
			<div class="table-responsive">
				<table id="categories-table" class="table table-bordered table-hover">
					<thead>
						<tr>
							<td>Mã</td>
							<td>Tên danh mục</td>
							<td>Danh mục cha</td>
							<td>Ghi chú</td>
							<td>Ngày tạo</td>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
	
	<!-- Modal Create-->
	<div id="create_category" class="modal fade" role="dialog">
	  	<div class="modal-dialog">
	    <!-- Modal content-->
		    <div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title text-green">Thêm mới danh mục sản phẩm</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal">
					    <div class="box-body">
					        <div class="form-group">
					        	<label for="categoryParent" class="col-sm-3 control-label">Danh mục cha</label>
					        	<div class="col-sm-9">
						        	<select class="form-control" id="create_category_parent">
										<option>-------------</option>
				                  	</select>
			                  	</div>
					        </div>
					        <div class="form-group">
					            <label for="categoryName" class="col-sm-3 control-label">Tên danh mục mới</label>
					            <div class="col-sm-9">
					                <input type="text" class="form-control" id="categoryName" placeholder="Tên danh mục (Ex. Điện thoại, máy tính bảng)">
					            </div>
					        </div>
					        <div class="form-group">
					            <label for="categoryNote" class="col-sm-3 control-label">Ghi chú</label>
					            <div class="col-sm-9">
					                <textarea rows="5" class="form-control" id="categoryNote" placeholder="Nhập thông tin về danh mục sản phẩm"></textarea>
					            </div>
					        </div>
					    </div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-rotate-left"></i> Hủy bỏ</button>
					<button type="button" id="btn_save_category" class="btn btn-default btn-flat btn-success"><i class="fa fa-save"></i> Lưu</button>
				</div>
		    </div>
	  	</div>
	</div>
	<!-- Modal Create-->

	<!-- Modal View, Edit, Delete-->
	<div id="info_category" class="modal fade" role="dialog">
	  	<div class="modal-dialog">
	    <!-- Modal content-->
		    <div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title text-green">Thêm mới danh mục sản phẩm</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal">
					    <div class="box-body">
					        <div class="form-group">
					        	<label for="categoryParent" class="col-sm-3 control-label">Danh mục cha</label>
					        	<div class="col-sm-9">
						        	<select class="form-control" id="info_category_parent">
										<option>-------------</option>
				                  	</select>
			                  	</div>
					        </div>
					        <div class="form-group">
					            <label for="categoryName" class="col-sm-3 control-label">Tên danh mục mới</label>
					            <div class="col-sm-9">
					                <input type="text" class="form-control" id="info_categoryName" placeholder="Tên danh mục (Ex. Điện thoại, máy tính bảng)">
					            </div>
					        </div>
					        <div class="form-group">
					            <label for="categoryNote" class="col-sm-3 control-label">Ghi chú</label>
					            <div class="col-sm-9">
					                <textarea rows="5" class="form-control" id="info_categoryNote" placeholder="Nhập thông tin về danh mục sản phẩm"></textarea>
					            </div>
					        </div>
					    </div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" id="btn_delete" class="btn btn-default btn-flat btn-danger pull-left"><i class="fa fa-trash"></i> Xóa</button>
					<button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-rotate-left"></i> Trở về</button>
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

	var id;

	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});

	$('#btn_add_category').on('click', function(){
		$.ajax({
			url: '{{ route('categoryname') }}',
			type: 'GET'
		})
		.done(function(data) {
			$('#create_category_parent')
			    .find('option')
			    .remove()
			    .end()
			    .append($('<option>', { 
			        text : '-------------'
			    })
		    );

			$.each( data, function( key, object ) {
				$('#create_category_parent').append($('<option>', { 
			        value: object.id,
			        text : object.category_name 
			    }));
			});
			
		});
	});

	$('#btn_save_category').on('click', function(){
		var category_name = $('#categoryName').val();
		var category_note = $('#categoryNote').val();
		var parent_id = $('#create_category_parent').val();
		$.ajax({
			url: '{{ route('categories.store') }}',
			type: 'POST',
			async: false,
			data: { 
				category_name: category_name,
				category_note: category_note,
				parent_id: parent_id
			},
		})
		.done(function(data) {
			$('#categoryName').val('');
			$('#categoryNote').val('');
			$('#create_category').modal('toggle');
		})
		.always(function(){
			$('#categories-table').DataTable().ajax.reload();
		});
    });

    $('#categories-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('categories') }}',
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

    $('#categories-table tbody').on('click', 'tr', function(e){
    	$('#info_category').modal('toggle');
		$('#info_categoryName').val($(this).find("td:eq(1)").html());
		$('#info_categoryNote').val($(this).find("td:eq(3)").html());

		var cat = $(this).find("td:eq(2)").html();
		id = $(this).find("td:eq(0)").html();

    	$.ajax({
			url: '{{ route('categoryname') }}',
			type: 'GET'
		})
		.done(function(data) {
			$('#info_category_parent')
			    .find('option')
			    .remove()
			    .end()
			    .append($('<option>', { 
			        text : '-------------'
			    })
		    );

			$.each( data, function( key, object ) {
				if( object.id != id) {
					$('#info_category_parent').append($('<option>', { 
				        value: object.id,
				        text : object.category_name 
				    }));
				}
			});
			
			$('#info_category_parent option').each(function() {
				if($(this).html() == cat ){ // EDITED THIS LINE
		            $(this).attr("selected","selected");    
		        }
			});	
		});				
    });

	$('#btn_delete').on('click', function(){		
		var url = "{!! route('categories.delete',['id'=>':id']) !!}";
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
			$('#info_category').modal('toggle');
		})
		.always(function(){
			$('#categories-table').DataTable().ajax.reload();
		});
	});
	
	$('#btn_update').on('click', function(){
		var url = "{!! route('categories.update',['id'=>':id']) !!}";
        url =  url.replace(':id', id);
		
		var parent_id = $('#info_category_parent').val();
		var category_name = $('#info_categoryName').val();
		var category_note = $('#info_categoryNote').val();

		$.ajax({
			url: url,
			type: 'POST',
			async: false,
			data: {
				method: 'PUT',
				parent_id: parent_id,
				category_name: category_name,
				category_note: category_note
			}
		})
		.done(function(data) {
			$('#info_category').modal('toggle');
		})
		.always(function(){
			$('#categories-table').DataTable().ajax.reload();
		});
	});

@endsection 