<aside class="left-sidebar" data-sidebarbg="skin6">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <!-- User Profile-->
                <li class="sidebar-item pt-2">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('home')}}"
                        aria-expanded="false">
                        <i class="far fa-clock" aria-hidden="true"></i>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('profile')}}"
                        aria-expanded="false">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <span class="hide-menu">Profile</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('categories.list')}}"
                        aria-expanded="false">
                        <i class="fa fa-columns" aria-hidden="true"></i>
                        <span class="hide-menu">Thể loại</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('books.list')}}"
                        aria-expanded="false">
                        <i class="fas fa-book"></i>
                        <span class="hide-menu">Sách</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('users.list')}}"
                        aria-expanded="false">
                        <i class="fas fa-user-circle"></i>
                        <span class="hide-menu">Tài khoản</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('advertisements.index')}}"
                        aria-expanded="false">
                        <i class="fab fa-adversal"></i>
                        <span class="hide-menu">Quảng cáo</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('basic-table')}}"
                        aria-expanded="false">
                        <i class="fa fa-table" aria-hidden="true"></i>
                        <span class="hide-menu">Basic Table</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('fontawesome')}}"
                        aria-expanded="false">
                        <i class="fa fa-font" aria-hidden="true"></i>
                        <span class="hide-menu">Icon</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="404.html"
                        aria-expanded="false">
                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                        <span class="hide-menu">Error 404</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('coupon.index') }}"
                        aria-expanded="false">
                        <i class="fa fa-gift" aria-hidden="true"></i>
                        <span class="hide-menu">Coupon</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('order.index') }}"
                        aria-expanded="false">
                        <i class="fa fa-cube" aria-hidden="true"></i>
                        <span class="hide-menu">Đơn hàng</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
