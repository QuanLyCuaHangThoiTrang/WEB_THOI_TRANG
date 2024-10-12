@extends('Admin.welcome')

@section('title', 'Tạo nhân viên')

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="post" action="{{ route('nhanvien.store') }}" class="forms-sample" enctype="multipart/form-data">
                @csrf 
                @method('post')
                
            
                <div class="form-group row">
                    <label for="HoTen">Họ Tên</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control @error('HoTen') is-invalid @enderror" name="HoTen" id="HoTen" placeholder="Họ Tên">
                        @error('HoTen')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror   
                    </div>
                </div>

                <div class="form-group row">
                    <label for="Email">Email</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control @error('Email') is-invalid @enderror" name="Email" id="Email" placeholder="Email">
                        @error('Email')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror   
                    </div>
                </div>

                <div class="form-group row">
                    <label for="SDT">Số Điện Thoại</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control @error('SDT') is-invalid @enderror" name="SDT" id="SDT" placeholder="Số Điện Thoại">
                        @error('SDT')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror   
                    </div>
                </div>

                <div class="form-group row">
                    <label for="Username">Tên Đăng Nhập</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control @error('Username') is-invalid @enderror" name="Username" id="Username" placeholder="Tên Đăng Nhập" >
                        @error('Username')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror   
                    </div>
                </div>

                <div class="form-group row">
                    <label for="Password">Mật Khẩu</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control @error('Password') is-invalid @enderror" name="Password" id="Password" placeholder="Mật Khẩu">
                        @error('Password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror   
                    </div>
                </div>

                <div class="form-group row">
                    <label for="VaiTro">Vai Trò</label>
                    <div class="col-sm-9">
                        <select class="form-control @error('VaiTro') is-invalid @enderror" name="VaiTro" id="VaiTro">
                            <option value="">Chọn Vai Trò</option>
                            <option value="Admin">Admin</option>
                            <option value="Nhân viên">Nhân viên</option>
                        </select>
                        @error('VaiTro')
                            <span class="invalid-feedback">{{ $message }}</span>
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
