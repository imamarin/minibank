
<table border="0" cellspacing="0" width="100%">
    <tbody>
        @for($i=1;$i<=$baris;$i++)
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        @endfor
        @php
            $no=1;
            $saldo=0;
        @endphp
        @foreach($transaksi as $data)
            @php
                if($data->jnstransaksi == "setor"){
                    $saldo = $saldo + $data->nominal;
                    $kredit = $data->nominal;
                }else{
                    $kredit = "-";
                }

                if($data->jnstransaksi == "tarik"){
                    $saldo = $saldo - $data->nominal;
                    $debit = $data->nominal;
                }else{
                    $debit = "-";
                }
            @endphp
            @if($no >= $rec1)
            <tr>
                <td>{{ date('d/m/Y', strtotime($data->waktu)) }}</td>
                <td>{{ $data->sandi }}</td>
                <td>{{ $debit }}</td>
                <td>{{ $kredit  }}</td>
                <td>{{ $saldo }}</td>
                <td>
                    -
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