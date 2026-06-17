@extends('layout.main')

@section('title', 'Perubahan Kata Sandi')

@section('content')
<style>
    .card {
        border-radius: 15px;
        border: none;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    .custom-input-group {
        display: flex;
        align-items: center;
        width: 100%;
        background-color: #fff;
        border: 1px solid #ebedf2;
        border-radius: 10px;
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .custom-input-group .form-control {
        border: none !important;
        box-shadow: none !important;
        padding: 14px 18px;
        font-size: 14px;
        background-color: transparent;
    }

    .custom-input-group .input-group-text {
        background-color: transparent;
        border: none;
        padding-right: 20px;
        color: #adb5bd;
    }

    .custom-input-group:focus-within {
        border-color: #3e4df0 !important;
        box-shadow: 0 0 0 1px #3e4df0;
    }

    /* Gaya Label */
    .form-label {
        font-weight: 600;
        color: #2d3436;
        margin-bottom: 10px;
        display: block;
    }

    /* Gaya Tombol Biru */
    .btn-update {
        background-color: #0b41af !important;
        color: white;
        padding: 12px 30px;
        border-radius: 10px;
        border: none;
        transition: 0.3s;
    }

    .btn-update:hover {
        background-color: #08338a !important;
        transform: translateY(-2px);
    }

    .cursor-pointer {
        cursor: pointer;
    }
</style>

<div class="container-fluid">
    <div class="page-inner">
        <h2 class="fw-bold mb-4">Perubahan Kata Sandi</h2>
        
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body p-lg-5 p-4">
                        
                        {{-- Notifikasi Sukses --}}
                        @if (session('status') === 'password-updated')
                            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                                <strong>Berhasil!</strong> Kata sandi Anda telah diperbarui.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form method="post" action="{{ route('password.update') }}">
                            @csrf
                            @method('put')

                            <div class="mb-4">
                                <label for="current_password" class="form-label">Kata Sandi Lama</label>
                                <div class="custom-input-group @if($errors->updatePassword->has('current_password')) border-danger @endif">
                                    <input type="password" name="current_password" id="current_password" 
                                        class="form-control" 
                                        placeholder="**********">
                                    <span class="input-group-text cursor-pointer" onclick="togglePassword('current_password')">
                                        <i class="fas fa-eye" id="icon-current_password"></i>
                                    </span>
                                </div>
                                @if($errors->updatePassword->has('current_password'))
                                    <div class="text-danger small mt-2">{{ $errors->updatePassword->first('current_password') }}</div>
                                @endif
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label">Kata Sandi Baru</label>
                                <div class="custom-input-group @if($errors->updatePassword->has('password')) border-danger @endif">
                                    <input type="password" name="password" id="password" 
                                        class="form-control" 
                                        placeholder="**********">
                                    <span class="input-group-text cursor-pointer" onclick="togglePassword('password')">
                                        <i class="fas fa-eye" id="icon-password"></i>
                                    </span>
                                </div>
                                @if($errors->updatePassword->has('password'))
                                    <div class="text-danger small mt-2">{{ $errors->updatePassword->first('password') }}</div>
                                @endif
                            </div>

                            <div class="mb-5">
                                <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi Baru</label>
                                <div class="custom-input-group">
                                    <input type="password" name="password_confirmation" id="password_confirmation" 
                                        class="form-control" 
                                        placeholder="**********">
                                    <span class="input-group-text cursor-pointer" onclick="togglePassword('password_confirmation')">
                                        <i class="fas fa-eye" id="icon-password_confirmation"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="d-flex justify-content-start">
                                <button type="submit" class="btn btn-update fw-bold shadow-sm">
                                    Ubah Kata Sandi
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Script Show/Hide Password --}}
<script>
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById('icon-' + inputId);
        
        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            input.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    }
</script>
@endsection