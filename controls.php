<?php
require "dbConnectPhp.php";
date_default_timezone_set('Europe/Istanbul');
if(isset($_POST["rotate"])){

    $sorguAnaTablo = $conn -> query(" SELECT * FROM anaTablo");
    $tabloListele = $sorguAnaTablo -> fetch();

    if($tabloListele["kalanHak"] > 0){

        $sayi1 = rand(0,9);
        $sayi2 = rand(0,9);
        $sayi3 = rand(0,9);

        $sorguAnaTablo2 = $conn -> prepare(" UPDATE anaTablo SET number1 =?,number2=?,number3=?");
        $sorguAnaTablo2 -> execute([$sayi1,$sayi2,$sayi3]);

        $sorguAnaTablo3 = $conn -> query(" SELECT * FROM anaTablo");
        $tabloListele3 = $sorguAnaTablo3 -> fetch();

        if($tabloListele3["number1"] == $tabloListele3["number2"] || $tabloListele3["number1"] == $tabloListele3["number3"]|| $tabloListele3["number2"] == $tabloListele3["number3"]){
            $yeniKalanHak = 5;
            $sorguAnaTablo4 = $conn -> prepare(" UPDATE anaTablo SET kalanHak=?");
            $sorguAnaTablo4 -> execute([$yeniKalanHak]);
        }else{
            $yeniKalanHak = $tabloListele3["kalanHak"] - 1;
            $sorguAnaTablo4 = $conn -> prepare(" UPDATE anaTablo SET kalanHak=?");
            $sorguAnaTablo4 -> execute([$yeniKalanHak]);
        }
        header("Location:http://localhost/odev/");
    }else{

        header("Location:http://localhost/odev/?error=yes");
    }


}


