<nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
              <i class="mdi mdi-grid-large menu-icon"></i>
              <span class="menu-title">Trang Chủ</span>
            </a>
          </li>
          <li class="nav-item nav-category">Category</li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
              <i class="menu-icon mdi mdi-floor-plan"></i>
              <span class="menu-title">Quản Lý Danh Mục</span>
              <i class="menu-arrow"></i> 
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="{{ route('product.index') }}">Sản Phẩm</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ route('danhmuc.index') }}">Danh Mục</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ route('khuyenmai.index') }}">Khuyến Mãi</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ route('voucher.index') }}">Voucher</a></li>
                
              </ul>
            </div>
          </li>
          <li class="nav-item nav-category">Order</li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
              <i class="menu-icon mdi mdi-card-text-outline"></i>
              <span class="menu-title">Quản Lý Đơn Hàng</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="form-elements">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="{{ route('donnhaphang.index') }}">Đơn Nhập Hàng</a></li>
                <!-- <li class="nav-item"> <a class="nav-link" href="{{ route('donhang.dashboard') }}">Thống Kê</a></li>              -->
                <li class="nav-item"> <a class="nav-link" href="{{ route('donhang.index') }}">Đơn Hàng</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item nav-category">User</li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
              <i class="menu-icon mdi mdi-account-circle-outline"></i>
              <span class="menu-title">Người Dùng</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="auth">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="{{ route('khachhang.index') }}"> Khách Hàng </a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ route('nhanvien.index') }}"> Nhân Viên </a></li>

              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.logout') }}">
              <i class="mdi mdi-grid-large menu-icon"></i>
              <span class="menu-title">Đăng xuất</span>
            </a>
          </li>
        </ul>
      </nav>