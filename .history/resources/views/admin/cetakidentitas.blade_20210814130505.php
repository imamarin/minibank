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
            <td style="width: 150px;text-align:left;font-size:14px;"></td><td>{{ $val->norek }}</td>
        </tr>
        <tr style="height:30px;">
            <td style="width: 150px;text-align:left;font-size:14px;"></td><td>{{ $val->nama }}</td>
        </tr>
        <tr style="height:30px;">
            <td style="width: 150px;text-align:left;font-size:14px;"></td><td>{{ isset($val->nm_rotu)?$val->nm_rotu:"-" }}</td>
        </tr>
        <tr style="height:30px;">
            <td style="width: 150px;text-align:left;font-size:14px;"></td><td>{{ isset($val->alamat)?$val->alamat:"-" }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
