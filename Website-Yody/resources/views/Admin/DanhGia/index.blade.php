@extends('Admin.welcome')

@section('title', 'Danh sách đánh giá')

@section('content')
@if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
 <div class="card">
    <div class="container">
    <h3 style="margin-top:20px; margin-bottom:20px; font-weight: bold;">Danh sách đánh giá</h3>
    
    <form method="GET" action="{{ route('danhgia.index') }}" class="mb-4 text-start">
    <div class="input-group" style="max-width: 400px;">
        <input type="text" name="MaCTSP" class="form-control" placeholder="Nhập mã sản phẩm" value="{{ $maCTSP }}">
        <button type="submit" class="btn btn-primary">Lọc</button>
    </div>
    </form>

    @if($soSaoTrungBinh)
    <div class="mb-3">
    @if($soSaoTrungBinh)
<div class="mb-3">
    <strong>Số sao trung bình:</strong> 
    @php
        $soSaoTrungBinhFull = floor($soSaoTrungBinh); 
        $soSaoTrungBinhHalf = ($soSaoTrungBinh - $soSaoTrungBinhFull) >= 0.5; 
        $soSaoConLai = 5 - $soSaoTrungBinhFull - ($soSaoTrungBinhHalf ? 1 : 0); 
    @endphp

    @for ($i = 1; $i <= $soSaoTrungBinhFull; $i++)
        <span style="color: gold;font-size: 24px;">&#9733;</span> 
    @endfor


    @if ($soSaoTrungBinhHalf)
        <span style="color: gold;font-size: 24px;">&#9734;</span>
    @endif

    @for ($i = 1; $i <= $soSaoConLai; $i++)
        <span style="color: lightgray;font-size: 24px;">&#9733;</span> 
    @endfor
</div>
@endif
    </div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Mã đánh giá</th>
                <th>Mã CTSP</th>
                <th>Khách hàng</th>
                <th>Nội dung</th>
                <th>Điểm đánh giá</th>
                <th>Ngày đánh giá</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($danhGia as $dg)
            <tr>
                <td>{{ $dg->MaDG }}</td>
                <td>{{ $dg->MaCTSP }}</td>
                <td>{{ $dg->khachHang->HoTen ?? 'N/A' }}</td>
                <td>{{ $dg->NoiDung }}</td>
                <td>
                @for ($i = 1; $i <= $dg->DiemDanhGia; $i++)
                <span style="color: gold;font-size: 24px;">&#9733;</span>
                    @endfor
             
                    @for ($i = $dg->DiemDanhGia + 1; $i <= 5; $i++)
                        <span style="color: lightgray;font-size: 24px;">&#9733;</span>
            @endfor
                </td>
                <td>{{ $dg->NgayDanhGia }}</td>
                <td>
                <!-- Nút xóa -->
                <form action="{{ route('danhgia.destroy', $dg->MaDG) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa đánh giá này?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm btn-icon-text" 
                    onclick="return confirm('Bạn có chắc chắn muốn xóa đánh giá này không?');">
                    <i class="ti-alert btn-icon-prepend"></i>                                                    
                        Xóa
                    </button>
                </form>
            </td>
            </tr>
            @empty
            <tr>
                <td colspan="7">Không có đánh giá nào.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div style="margin-top:10px" class="pagination-container d-flex justify-content-center">
                {{ $danhGia->links('pagination::bootstrap-4') }}
            </div>
</div>
</div>
@endsection
