<?php
    function apiwise($url_quote,$postData=NULL,$token){
        $ch     = curl_init($url_quote);
        $headers    = array(
            'Authorization: Bearer '.$token,
            'Content-Type: application/json'
        );
        
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData); 
        $result = json_decode(curl_exec($ch));
        curl_close($ch);
        return $result;        
    }
    
    function sandbox($quoteid=NULL,$transferID=NULL){
        $profile="16324768";
        $data=array(
                "profile"       => $profile,
                "token"         => "f264a520-16d9-4c1c-b91e-bded67438f57",
                "quote"         => "https://api.sandbox.transferwise.tech/v2/quotes",
                "balancemove"   => "https://api.sandbox.transferwise.tech/v2/profiles/".$profile."/balance-movements",
                "readquote"     => "https://api.sandbox.transferwise.tech/v3/profiles/".$profile."/quotes/".$quoteid,
                "recipient"     => "https://api.sandbox.transferwise.tech/v1/accounts",
                "transfer"      => "https://api.sandbox.transferwise.tech/v1/transfers",
                "payment"       => "https://api.sandbox.transferwise.tech/v3/profiles/".$profile."/transfers/".$transferID."/payments"
            );
        return (object) $data;
    }
    
    function liveapi($quoteid=NULL,$transferID=NULL){
        $profile="24407990";
        $data=array(
                "profile"       => $profile,
                "token"         => "85f29878-629f-4b46-83cc-03f395281ed5",
                "quote"         => "https://api.transferwise.com/v2/quotes",
                "balancemove"   => "https://api.transferwise.com/v2/profiles/".$profile."/balance-movements",
                "readquote"     => "https://api.transferwise.com/v3/profiles/".$profile."/quotes/".$quoteid,
                "recipient"     => "https://api.transferwise.com/v1/accounts",
                "transfer"      => "https://api.transferwise.com/v1/transfers",
                "payment"       => "https://api.transferwise.com/v3/profiles/".$profile."/transfers/".$transferID."/payments"
  );
        return (object) $data;
    }