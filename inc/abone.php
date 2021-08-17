<?php
require_once '../sistem/fonksiyon.php';
if($_POST){

    $eposta = post('eposta');

    if(!$eposta){
        echo "bos";

    }else{
        if(!filter_var($eposta,FILTER_VALIDATE_EMAIL)){
            echo "format";
        }else{
            
            $varmi = $db->prepare('SELECT abone_mail FROM aboneler where abone_mail=:mail');
            $varmi->execute([':mail'=>$eposta]);
                if($varmi->rowCount()){

                    echo 'kayitli';

                } else {

                $kaydet = $db->prepare('INSERT INTO aboneler SET abone_mail=:mail, abone_ip=:i');
                $kaydet->execute([':mail' => $eposta,':i' => IP()]);
                if($kaydet){
                    echo "basarili";
                }else{ 
                    echo "hata";
                }
            }
        }
    }
}