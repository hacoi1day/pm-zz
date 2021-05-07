<table>
    <thead>
        <tr>
            <th>Ngày</th>
            <th>Giờ vào</th>
            <th>Giờ ra</th>
            <th>Thời gian</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($items as $item)
        <tr>
            <td>{{ $item['date'] }}</td>
            <td>{{ $item['time_in'] }}</td>
            <td>{{ $item['time_out'] }}</td>
            <td>{{ $item['count'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
