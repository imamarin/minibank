
<table border="1" cellspacing="0">
    <tbody>
        @for($i=1;$i<=$baris;$i++)
            <tr style="height:30px;">
                <td style="width: 108px;text-align:right;"></td>
                <td style="width: 56px;text-align:center;"></td>
                <td style="width: 108px;text-align:right;"></td>
                <td style="width: 108px;text-align:right;"></td>
                <td style="width: 108px;text-align:right;"></td>
                <td style="width: 60px;text-align:center;"></td>
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
            <tr style="height:30px;">
                <td style="width: 108px;text-align:right;">{{ date('d/m/Y', strtotime($data->waktu)) }}</td>
                <td style="width: 60px;text-align:center;">{{ $data->sandi }}</td>
                <td style="width: 108px;text-align:right;">{{ $debit }}</td>
                <td style="width: 108px;text-align:right;">{{ $kredit  }}</td>
                <td style="width: 108px;text-align:right;">{{ $saldo }}</td>
                <td style="width: 60px;text-align:center;">
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