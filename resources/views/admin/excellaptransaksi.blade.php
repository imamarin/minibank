
                            @if($_GET['norek']=='semua')    
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
                                        @endforeach;
                                    </tbody>
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
                                        @endforeach;
                                    </tbody>
                                </table>
                            @endif


					
<script>
    window.print();    
</script>