<style>
@page {
            margin-left : 0.2in;
            margin-top : 0.9in;
        }
</style>
<table border="0" cellspacing="0">
    <tbody>
        @foreach($rekening as $val)
        <tr style="height:30px;">
            <td style="width: 150px;text-align:left;"></td><td>{{ $val->norek }}</td>
            <td style="width: 150px;text-align:left;"></td><td>{{ $val->nama }}</td>
            <td style="width: 150px;text-align:left;"></td><td>{{ $val->nm_rotu }}</td>
            <td style="width: 150px;text-align:left;"></td><td>{{ $val->alamat }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
