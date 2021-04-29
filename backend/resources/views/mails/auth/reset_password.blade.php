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
    <h1>Lấy lại mật khẩu</h1>
    <p>Email (tài khoản) là: <strong>{{ $data['email'] }}</strong></p>
    <p>Nhấn vào liên kết dưới đây để đổi lại mật khẩu.</p>
    <a href="http://pm.local/auth/change-password?token={{ $data['token'] }}">Đổi mật khẩu</a>
</div>
