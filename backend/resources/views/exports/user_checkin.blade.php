<table>
    <thead>
        <tr>
            <th colspan="{{ 3 + $daysInMonth }}" style="text-align: center;">Bảng chấm công</th>
        </tr>
        <tr>
            <th style="text-align: center;">Tháng</th>
            <th style="text-align: center;">{{ $month }}</th>
            <th style="text-align: center;">Năm</th>
            <th colspan="2" style="text-align: center;">{{ $year }}</th>
        </tr>
        <tr>
            <th width="20" style="text-align: center;">Tên Nhân viên</th>
            <th width="10" style="text-align: center;">Tổng ngày</th>
            <th width="10" style="text-align: center;">Tổng giờ</th>
            <th colspan="{{ $daysInMonth }}" style="text-align: center;">Ngày làm</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="text-align: center;">{{ $user->name }}</td>
            <td style="text-align: center;">{{ $totalDay ?? 0 }}</td>
            <td style="text-align: center;">{{ $totalHours ?? 0 }}</td>
            @for($i = 1; $i <= $daysInMonth; $i++)
                <td width="5" style="text-align: center;">{{ $i }}</td>
            @endfor
        </tr>
        <tr>
            <td colspan="3" style="text-align: center;">Giờ làm</td>
            @for($i = 1; $i <= $daysInMonth; $i++)
            @if(array_key_exists($i, $items))
                <td width="5"
                    style="text-align: center; background-color: {{ $items[$i]['color'] }}"
                >{{ $items[$i]['calc'] }}</td>
            @else
                <td width="5" style="text-align: center; background-color: gray;"></td>
            @endif
            @endfor
        </tr>
    </tbody>
</table>
