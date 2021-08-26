<style>
@page {
            margin-left : 1in;
            margin-top : 0.8in;
        }
</style>
<table border="0" cellspacing="0">
    <tbody>
        @foreach($rekening as $val)
        <tr style="height:50px;">
            <td style="width: 150px;text-align:left;font-size:14px;"></td><td>{{ $val->norek }}</td>
        </tr>
        <tr style="height:50px;">
            <td style="width: 150px;text-align:left;font-size:14px;"></td><td>{{ $val->nama }}</td>
        </tr>
        <tr style="height:50px;">
            <td style="width: 150px;text-align:left;font-size:14px;"></td><td>{{ isset($val->nm_rotu)?$val->nm_rotu:"-" }}</td>
        </tr>
        <tr style="height:50px;">
            <td style="width: 150px;text-align:left;font-size:14px;"></td><td>{{ isset($val->alamat)?$val->alamat:"-" }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
