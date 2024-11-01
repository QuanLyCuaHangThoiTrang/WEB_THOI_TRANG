@extends('Admin.welcome')

@section('title', 'Chỉnh Sửa Nhân Viên')

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="post" action="{{ route('nhanvien.update', $nhanvien->MaNV) }}" class="forms-sample" enctype="multipart/form-data">
                @csrf 
                @method('put')
                
                <div class="form-group row">
                    <label for="HoTen">Họ Tên</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control @error('HoTen') is-invalid @enderror" name="HoTen" id="HoTen" value="{{ $nhanvien->HoTen }}" placeholder="Họ Tên" >
                        @error('HoTen')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror   
                    </div>
                </div>

                <div class="form-group row">
                    <label for="Email">Email</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control @error('Email') is-invalid @enderror" name="Email" id="Email" value="{{ $nhanvien->Email }}" placeholder="Email">
                        @error('Email')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror   
                    </div>
                </div>

                <div class="form-group row">
                    <label for="SDT">Số Điện Thoại</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control @error('SDT') is-invalid @enderror" name="SDT" id="SDT" value="{{ $nhanvien->SDT }}" placeholder="Số Điện Thoại">
                        @error('SDT')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror   
                    </div>
                </div>

                <div class="form-group row">
                    <label for="Username">Tên Đăng Nhập</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control @error('Username') is-invalid @enderror" name="Username" id="Username" value="{{ $nhanvien->Username }}" placeholder="Tên Đăng Nhập" >
                        @error('Username')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror   
                    </div>
                </div>

                <div class="form-group row">
                <label for="Password">Mật Khẩu</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <input type="password" class="form-control @error('Password') is-invalid @enderror" name="Password" id="Password" placeholder="Mật Khẩu">
                        <div class="input-group-append">
                            <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                                <i class="mdi mdi-eye" id="eyeIcon"></i>
                            </span>
                        </div>
                    </div>
                    <small class="form-text text-muted">Nếu không thay đổi mật khẩu, hãy để trống.</small>
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
                            <option value="Admin" {{ $nhanvien->VaiTro == 'Admin' ? 'selected' : '' }}>Admin</option>
                            <option value="Nhân viên" {{ $nhanvien->VaiTro == 'Nhân viên' ? 'selected' : '' }}>Nhân viên</option>
                        </select>
                        @error('VaiTro')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror   
                    </div>
                </div>
                
                <div>
                    <input type="submit" value="Update" class="btn btn-primary me-2" />
                </div>
            </form>
        </div> 
    </div> 
    <script>
        // JavaScript để chuyển đổi mật khẩu
        document.getElementById('togglePassword').addEventListener('click', function () {
        const passwordField = document.getElementById('Password');
        const eyeIcon = document.getElementById('eyeIcon');
        
        // Hiển thị mật khẩu thực tế
        if (passwordField.type === 'password') {
            passwordField.type = 'text'; // Chuyển đổi thành text để hiển thị mật khẩu
            eyeIcon.classList.remove('mdi-eye');
            eyeIcon.classList.add('mdi-eye-off');

            // Đặt lại kiểu mật khẩu sau 5 giây
            setTimeout(function () {
                passwordField.type = 'password'; // Đặt lại thành password
                eyeIcon.classList.remove('mdi-eye-off');
                eyeIcon.classList.add('mdi-eye');
            }, 5000); // 5000 milliseconds = 5 seconds
        } else {
            passwordField.type = 'password'; // Nếu đang hiển thị thì đặt lại thành password
            eyeIcon.classList.remove('mdi-eye-off');
            eyeIcon.classList.add('mdi-eye');
        }
    });
    </script>

@endsection
