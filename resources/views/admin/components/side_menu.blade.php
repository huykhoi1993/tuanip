<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                @if ( !Auth::guest())
                <p>{{ Auth::user()->name }}</p>
                @endif
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <!-- Products -->
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-table"></i> <span>Quản lý sản phẩm</span>
                    <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('/admin/product') }}"><i class="fa fa-mobile-phone"></i> Danh sách sản phẩm</a></li>
                    <li><a href="{{ url('/admin/category') }}"><i class="fa fa-list"></i> Danh mục sản phẩm</a></li>
                </ul>
            </li>
            <!-- End Products -->
            <!-- Depot management -->
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-cubes"></i> <span>Quản lý kho hàng</span>
                    <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('depots.index') }}"><i class="fa fa-info"></i> Danh sách đơn hàng</a></li>
                    <li><a href="{{ url('/admin/product') }}"><i class="fa fa-arrow-down"></i> Nhập sản phẩm</a></li>
                    <li><a href="{{ url('/admin/category') }}"><i class="fa fa-arrow-up"></i> xuất sản phẩm</a></li>
                </ul>
            </li>
            <!-- End Depot management -->
            <!-- Users management -->
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-user"></i> <span>Khách hàng - Công Nợ</span>
                    <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('members.index') }}"><i class="fa fa-users"></i> Danh sách khách hàng</a></li>
                    <li><a href=""><i class="fa fa-bank"></i> Thống kê Công - Nợ</a></li>
                </ul>
            </li>
            <!-- End Users management -->
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>