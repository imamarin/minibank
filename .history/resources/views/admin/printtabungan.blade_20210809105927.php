
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
        @endphp
        @foreach($transaksi as $data)
        <tr>
            <td>{{ date('d/m/Y', strtotime($data->waktu)) }}</td>
            <td>{{ $data->sandi }}</td>
            <td>{{ $debet }}</td>
            <td>{{ $kredit }}</td>
            <td>{{ $data->nominal }}</td>
            <td>
                @if($data->jnstransaksi=='transfer')
                    Tujuan Rekening: {{ $data->norektujuan }} ({{ $data->penerima }})<br>
                

                    @if($data->idsubrekening!='-')
                        Sub Rekening: {{ $data->subrekening }}<br>
                        Ket: {{ $data->keterangan }}
                    @endif
                @else
                    -
                @endif
            </td>
            <td>{{ $data->waktu }}</td>
        </tr>
        @endforeach;
    </tbody>
</table>

<script>
window.print();    
</script>