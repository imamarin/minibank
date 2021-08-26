
<table border="1" cellspacing="0" width="100%">
    <tbody>
        @for($i=1;$i<=$baris;$++)
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
                }else{
                    $kredit = "-";
                }

                if($data->jnstransaksi == "tarik"){
                    $saldo = $saldo - $data->nominal;
                }else{
                    $debit = "-";
                }
            @endphp
        <tr>
            <td>{{ date('d/m/Y', strtotime($data->waktu)) }}</td>
            <td>{{ $data->sandi }}</td>
            <td>{{ $debit }}</td>
            <td>{{ $kredit  }}</td>
            <td>{{ $saldo }}</td>
            <td>
                "-"
            </td>
            <td>{{ $data->waktu }}</td>
        </tr>
        @endforeach;
    </tbody>
</table>

<script>
window.print();    
</script>