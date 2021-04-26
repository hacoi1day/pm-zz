<style>
    .store-user {
        border: 1px solid #e3e3e3;
        padding: 20px;
        margin: 20px;
        border-radius: 5px;
        text-align: center;
    }
    .store-user h1 {

    }
    .store-user a {
        text-decoration: none;
    }

</style>
<div class="store-user">
    <h1>Xác nhận tài khoản</h1>
    <a href="http://api.pm.local/api/active?token={{ $data['token'] ?? '' }}">Xác nhận</a>
</div>
