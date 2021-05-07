<table>
    <thead>
        <tr>
            <th colspan="6" style="text-align: center;">Danh sách nhân viên {{ $department->name ?? '' }}</th>
        </tr>
        <tr>
            <th colspan="2" style="text-align: right;">Quản lý</th>
            <th colspan="4">{{ $department->manager->name ?? '' }}</th>
        </tr>
        <tr>
            <th colspan="2" style="text-align: right;">Tổng Nhân viên</th>
            <th colspan="4" style="text-align: left;">{{ $total ?? 0 }}</th>
        </tr>
        <tr>
            <th width="10">ID</th>
            <th width="20">Họ và têm</th>
            <th width="20">Ngày sinh</th>
            <th width="20">Email</th>
            <th width="20">Số điện thoại</th>
            <th width="30">Địa chỉ</th>
        </tr>
    </thead>
    <tbody>
        @foreach($items as $item)
        <tr>
            <td>{{ $item['id'] ?? ''}}</td>
            <td>{{ $item['name'] ?? ''}}</td>
            <td>{{ $item['birthday'] ?? '' }}</td>
            <td>{{ $item['email'] ?? '' }}</td>
            <td>{{ $item['phone'] ?? '' }}</td>
            <td>{{ $item['address'] ?? '' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
