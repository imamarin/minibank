<style>
@page {
            margin-left : 0.1in;
            margin-top : 0.8in;
        }
</style>
<table border="0" cellspacing="0">
    <tbody>
        @for($i=1;$i<=$baris;$i++)
            <tr style="height:30px;">
                <td style="width: 108px;text-align:left;"></td>
                <td style="width: 60px;text-align:center;"></td>
                <td style="width: 135px;text-align:right;"></td>
                <td style="width: 140px;text-align:right;"></td>
                <td style="width: 150px;text-align:right;"></td>
                <td style="width: 80px;text-align:center;"></td>
            </tr>
        @endfor
        @php
            $no=1;
            $urut=1;
            $saldo=0;
        @endphp
        @foreach($transaksi as $data)
            @php
                if($data->jnstransaksi == "setor" || ($data->jnstransaksi == "transfer" AND $data->norektujuan == $norek)){
                    $saldo = $saldo + $data->nominal;
                    $kredit = number_format($data->nominal,0,".",",");
                }else{
                    $kredit = "-";
                }

                if($data->jnstransaksi == "tarik" || ($data->jnstransaksi == "transfer" AND $data->norektujuan != $norek)){
                    $saldo = $saldo - $data->nominal;
                    $debit = number_format($data->nominal,0,".",",");
                }else{
                    $debit = "-";
                }
            @endphp
            @if($no >= $rec1)
            <tr style="height:30px;">
                <td style="width: 108px;text-align:left;">{{ "[".$urut."]  ".date('d/m/Y', strtotime($data->waktu)) }}</td>
                <td style="width: 60px;text-align:center;">{{ $data->sandi }}</td>
                <td style="width: 135px;text-align:right;">{{ $debit }}</td>
                <td style="width: 140px;text-align:right;">{{ $kredit  }}</td>
                <td style="width: 150px;text-align:right;">{{ number_format($saldo,0,",",".") }}</td>
                <td style="width: 80px;text-align:center;">
                    {{ $data->paraf }}
                </td>
            </tr>
            @endif
            @php
                $no++;
                $urut++;
            @endphp
        @endforeach
    </tbody>
</table>

<script>
window.print();    
</script>