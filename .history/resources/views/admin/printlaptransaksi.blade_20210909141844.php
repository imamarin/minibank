
                            @if($norek=='semua')    
                                <table>
                                    <tr>
                                        <td>Total Setoran</td><td>:</td><td id="kredit"></td>
                                    </tr>
                                    <tr>
                                        <td>Total Penarikan</td><td>:</td><td id="debit"></td>
                                    </tr>
                                    <tr>
                                        <td>Total Transfer</td><td>:</td><td id="transfer"></td>
                                    </tr>
                                </table>
                                <table border="1" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr style="font-size:12px">
                                            <th>No</th>
                                            <th>Nama Nasabah</th>
                                            <th>Nomor Rekening</th>
                                            <th>Jenis Transaksi</th>
                                            <th>Nominal</th>
                                            <th>Keterangan</th>
                                            <th>Waktu</th>
                                            <th>Paraf</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no=1;
                                            $debit = 0;
                                            $kredit = 0;
                                            $transfer = 0;
                                        @endphp
                                        @foreach($transaksi as $data)
                                        <tr style="font-size:12px">
                                            <td>{{ $no++ }}</td>
                                            <td>{{ strtoupper($data->nama) }}</td>
                                            <td>{{ $data->norek }}</td>
                                            <td>{{ $data->jnstransaksi }}</td>
                                            <td align="right">{{ number_format($data->nominal,"0",",",".") }}</td>
                                            <td>
                                                <?php
                                                    if ($data->jnstransaksi == "setor") {
                                                        # code...
                                                        $kredit = $kredit + $data->nominal;
                                                    }elseif($data->jnstransaksi == "tarik") {
                                                        # code...
                                                        $debit = $debit + $data->nominal;

                                                    }elseif($data->jnstransaksi == "transfer") {
                                                        # code...
                                                        $transfer = $transfer + $data->nominal;

                                                    }
                                                    
                                                ?>
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
                                            <td>{{ $data->paraf }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <br>
                                <table width="100%">
                                    <tr>
                                        <td align="center" colspan="3">Mengetahui,</td>                                   
                                    </tr>
                                    <tr>
                                        <td align="center">
                                            <br><br>
                                            <b>Pegawai Pertama</b>
                                            <br><br><br><br>
                                            <u>DEWI WIDAWATI</u>
                                        </td>
                                        <td width="350px">

                                        </td>
                                        <td align="center">
                                            <br><br>
                                            <b>Pegawai Kedua</b>
                                            <br><br><br><br>
                                            <u>LAINA SUROYA S. KOM</u>
                                        </td>
                                    </tr>
                                </table>
                            @else
                                <table>
                                    <tr>
                                        <td>Nama Nasabah</td><td>:</td><td>{{ $rekening->nama }}</td>
                                    </tr>
                                    <tr>
                                        <td>Nomor Induk</td><td>:</td><td>{{ $rekening->nin }}</td>
                                    </tr>
                                    <tr>
                                        <td>Nomor Rekening</td><td>:</td><td>{{ $rekening->norek }}</td>
                                    </tr>
                                </table>
                                <table border="1" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr style="font-size:12px">
                                            <th>No</th>
                                            <th>Nama Nasabah</th>
                                            <th>Nomor Rekening</th>
                                            <th>Jenis Transaksi</th>
                                            <th>Nominal</th>
                                            <th>Keterangan</th>
                                            <th>Waktu</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no=1;
                                        @endphp
                                        @foreach($transaksi as $data)
                                        <tr style="font-size:12px">
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $data->nama }}</td>
                                            <td>{{ $data->norek }}</td>
                                            <td>{{ $data->jnstransaksi }}</td>
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
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif

			
<script>
    document.getElementById('kredit').innerHTML=' Rp. {{ number_format($kredit,0,",",".") }}';
    document.getElementById('debit').innerHTML=' Rp. {{ number_format($debit,0,",",".") }}';
    document.getElementById('transfer').innerHTML=' Rp. {{ number_format($transfer,0,",",".") }}';
    window.print();    
</script>