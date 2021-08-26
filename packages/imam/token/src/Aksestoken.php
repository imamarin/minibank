<?php
namespace ImamAmirulloh\Token;

class Aksestoken{
    
    public static function get(){
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
          $token = $response->access_token;
          return $token;
    }
}