<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ Session::token() }}">
        <title>Coba</title>
    </head>
    <body>
      <form method="post" action="{{ url('simulasi/proses') }}">
      {{ csrf_field() }}
        <input type="hidden" name="action" value="inquiry" />
        Nomor Pembayaran:
        <input type="text" name="nomorPembayaran" />
      <input type="submit" />
      </form>

    </body>
</html>