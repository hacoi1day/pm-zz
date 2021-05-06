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
    <h1>Có yêu cầu mới được tạo !</h1>
    <p>Email là: <strong>{{ $data['email'] }}</strong></p>
    <p>Họ và tên: <strong>{{ $data['name'] }}</strong></p>
    <p>Dự án: <strong>{{ $data['project'] }}</strong></p>
    <p>Lý do: <strong>{{ $data['cause'] }}</strong></p>
    <a href="http://pm.local/auth/login">Đến PM</a>
</div>
