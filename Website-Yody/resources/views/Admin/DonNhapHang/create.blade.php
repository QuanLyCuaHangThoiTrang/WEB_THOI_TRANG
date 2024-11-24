@extends('Admin.welcome')

@section('title', 'Tạo Đơn Nhập Hàng')

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="post" action="{{ route('donnhaphang.store') }}" class="forms-sample">
                @csrf
                @method('post')

                <div class="form-group row">
                    <label for="MaNCC">Nhà Cung Cấp</label>
                    <div class="col-sm-9">
                        <select class="form-control @error('MaNCC') is-invalid @enderror" name="MaNCC" id="MaNCC"
                            required>
                            <option value="">Chọn Nhà Cung Cấp</option>
                            @foreach ($nhacungcaps as $nhacungcap)
                                <option value="{{ $nhacungcap->MaNCC }}"
                                    {{ old('MaNCC') == $nhacungcap->MaNCC ? 'selected' : '' }}>
                                    {{ $nhacungcap->TenNCC }}
                                </option>
                            @endforeach
                        </select>
                        @error('MaNCC')
                            <span class="invalid-feedback" role="alert">
                                <p>{{ $message }}</p>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="NgayDatHang">Ngày Đặt Hàng</label>
                    <div class="col-sm-9">
                        <input type="date" class="form-control @error('NgayDatHang') is-invalid @enderror"
                            name="NgayDatHang" id="NgayDatHang" value="{{ old('NgayDatHang') }}">
                        @error('NgayDatHang')
                            <span class="invalid-feedback" role="alert">
                                <p>{{ $message }}</p>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="TongGiaTri">Tổng Giá Trị</label>
                    <div class="col-sm-9">
                        <input type="number" step="0.01" class="form-control @error('TongGiaTri') is-invalid @enderror"
                            name="TongGiaTri" id="TongGiaTri" placeholder="Tổng Giá Trị" value="{{ old('TongGiaTri') }}">
                        @error('TongGiaTri')
                            <span class="invalid-feedback" role="alert">
                                <p>{{ $message }}</p>
                            </span>
                        @enderror
                    </div>
                </div>

                <div>
                    <input type="submit" value="Lưu" class="btn btn-primary me-2" />
                </div>
            </form>
        </div>
    </div>
@endsection
