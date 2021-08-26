
<table border="0" cellspacing="0">
    <tbody>
        @for($i=1;$i<=$baris;$i++)
            <tr style="height:30px;font-size: 12px;">
                <td style="width: 75px;text-align:right;"></td>
                <td style="width: 56px;text-align:center;"></td>
                <td style="width: 94px;text-align:right;"></td>
                <td style="width: 94px;text-align:right;"></td>
                <td style="width: 94px;text-align:right;"></td>
                <td style="width: 56px;text-align:center;"></td>
            </tr>
        @endfor
        @php
            $no=1;
            $saldo=0;
        @endphp
        @foreach($transaksi as $data)
            @php
                if($data->jnstransaksi == "setor" || ($data->jnstransaksi == "transfer" AND $data->norektujuan == $norek)){
                    $saldo = $saldo + $data->nominal;
                    $kredit = $data->nominal;
                }else{
                    $kredit = "-";
                }

                if($data->jnstransaksi == "tarik" || ($data->jnstransaksi == "transfer" AND $data->norektujuan != $norek)){
                    $saldo = $saldo - $data->nominal;
                    $debit = $data->nominal;
                }else{
                    $debit = "-";
                }
            @endphp
            @if($no >= $rec1)
            <tr style="height:30px;font-size: 12px;">
                <td style="width: 75px">{{ date('d/m/Y', strtotime($data->waktu)) }}</td>
                <td style="width: 56px">{{ $data->sandi }}</td>
                <td style="width: 94px">{{ $debit }}</td>
                <td style="width: 94px">{{ $kredit  }}</td>
                <td style="width: 94px">{{ $saldo }}</td>
                <td style="width: 56px">
                    {{ $data->paraf }}
                </td>
            </tr>
            @endif
            @php
                $no++;
            @endphp
        @endforeach
    </tbody>
</table>

<script>
window.print();    
</script>