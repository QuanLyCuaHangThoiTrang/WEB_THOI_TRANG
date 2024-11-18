<!-- resources/views/SanPham/index.blade.php -->
@extends('Admin.welcome')

@section('title', 'Danh sách voucher')

@section('content')
<div >
    @if(session()->has('success'))
        <div class="alert alert-danger">{{session('success')}}</div>
    @endif
</div>
<div>
    @if(session()->has('error'))
        <div class="alert alert-danger">{{session('error')}}</div>
    @endif
</div>
    <div>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Danh Sách Voucher</h4>
            <div class="table-responsive">
            <table class="table table-hover">
            <thead>
                <tr>
                    <th>Mã Voucher</th>
                    <th>Tên Voucher</th>
                    <th>Phần trăm giảm giá</th>
                    <th>Ngày Bắt Đầu</th>
                    <th>Ngày Kết Thúc</th>
                    <th>Active</th>
                    <th>Hành động</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($vouchers as $voucher)
                    <tr>
                        <td>{{ $voucher->MaVoucher }}</td>
                        <td>{{ $voucher->TenVoucher }}</td>
                        <td>{{ $voucher->PhanTramGiamGia }}</td>
                        <td>{{ $voucher->NgayBD }}</td>
                        <td>{{ $voucher->NgayKT }}</td>
                        <td>{{ $voucher->Active }}</td>
                        <td>
                            <!-- Xóa khách hàng -->
                            <form action="#" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm btn-icon-text" 
                                onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?');">
                                <i class="ti-alert btn-icon-prepend"></i>                                                    
                                    Xóa
                                 </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            </table>
        
            </div>


            
         
            
            
        </div>
        
    </div>
        
    </div>
  
@endsection
