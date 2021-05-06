<style>
    .store-user {
        border: 1px solid #e3e3e3;
        padding: 20px;
        margin: 20px;
        border-radius: 5px;
        text-align: left;
    }
    .store-user h1 {

    }
    .store-user a {
        text-decoration: none;
    }
</style>
<div class="store-user">
    <h1>Mật khẩu đã được đặt lại thành công</h1>
    <p>Email (tài khoản) là: <strong>{{ $data['email'] }}</strong></p>
    <p>Mật khẩu được khởi tạo là: <strong>{{ $data['password'] }}</strong></p>
    <a href="http://pm.local/auth/login">Đăng nhập</a>
</div>
