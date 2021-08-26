<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ Session::token() }}">
  <title>AdminLTE 3 | Dashboard</title>

</head>
<body>
  <?php
    $data = array(
      "client_id"=>"BSIDEV",
      "grant_type"=>"password",
      "username"=>"9535",
      "password"=>"9535",
      "client_secret"=>"a2566731-c314-46e3-96d8-762d86d60330"
    );

    $header = array(
      'Content-Type:application/x-www-form-urlencoded'
    );
    //header("Access-Control-Allow-Origin: *"); # enable Cross Origin [CORS]
    $url = 'https://account.makaramas.com/auth/realms/bpi-dev/protocol/openid-connect/token'; # API Link

    $curl = curl_init(); # initialize curl object
    curl_setopt($curl, CURLOPT_URL, $url); # set url
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    

    $response = json_decode(curl_exec($curl));
  ?>
  <script src="{{ asset('assets/adminlte/plugins/jquery/jquery.min.js') }}"></script>
<script>
 
    // $( document ).ready(function() {
 

    //     // $.ajax({ 
    //     //     type: "POST",
    //     //     url: "https://prepaid.iak.id/api/check-balance",
    //     //     data: JSON.stringify({
    //     //       '_token': $('meta[name=csrf-token]').attr('content'),
    //     //       "username": "08239335567",
    //     //       "sign": "f33d3c56c580732f6711e3ae6f62c714"
    //     //     }),
    //     //     dataType: "json"
    //     // }); 

        let akses="";
        $.ajax(
          {
            method: "POST",
            url: "https://account.makaramas.com/auth/realms/bpi-dev/protocol/openid-connect/token",
            data: {
              client_id: "BSIDEV",
              grant_type: "password",
              username: "9535",
              password: "9535",
              client_secret: "a2566731-c314-46e3-96d8-762d86d60330"
            },
            header: 'Content-Type:application/json',
            success: function(result){
                  akses = result;
                  console.log(akses);
              }
          });

    //     $.ajax(
    //       {
    //         type: "POST",
    //         url: "https://billing-bpi-dev.maja.id/api/v2/register",
    //         data: [{
    //             "date": "2021-02-28",
    //               "amount": 25000,
    //               "name": "Andari",
    //               "email": "andari@sebuahdomain.com",
    //               "address": "Depok",
    //               "va": "880812345001",
    //               "attribute1": "Fasilkom",
    //               "attribute2": "Manajemen Sistem Informasi",
    //               "items": 
    //                   [{
    //                       "description": "UI Works Common Area 2hours",
    //                       "unitPrice": 25000,
    //                       "qty": 1,
    //                       "amount": 25000
    //                   }],

    //               "attributes": []
    //           }],
    //         headers:{ 
    //           'Authorization': 'Bearer <'+akses+'>'
    //         },
    //         contentType:'application/json',
    //         success: function(result){
    //               console.log(result);
    //           },
    //           error: function(error){
    //             alert(error)
    //           }
    //       }).done(function(data){
    //         alert(data)
    //       });
    // });

    // function cek(){

    // }
  
</script>
<button type="button" onclick="cek();">cek</button>

  </body>
  </html>
