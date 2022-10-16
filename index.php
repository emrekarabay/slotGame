<?php require "dbConnectPhp.php" ?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bet Emre</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/b702e9b638.js" crossorigin="anonymous"></script>
    <script>
        var backgroundButton = document.querySelector("#backgroundColor");

        backgroundButton.addEventListener("click",degistir());

        function degistir(){
            document.body.style.background = black;
        }
    </script>
</head>
<body>

<div class="enDisDiv">
    <?php
    date_default_timezone_set('Europe/Istanbul');
    $sorguAnaTablo = $conn -> query(" SELECT * FROM anaTablo");
    $numberOfRow = $sorguAnaTablo ->rowCount();
    $tabloListele = $sorguAnaTablo -> fetch();
    if($tabloListele["kalanHak"] > 0){
        $sorguAnaTablo2 = $conn -> prepare(" UPDATE anaTablo SET sonGiris=?,yenilenme=?");
        $sorguAnaTablo2 -> execute([date("d-m-Y H:i:s"),date("d-m-Y H:00:00")]);


    ?>
    <div class="canSayisi">Kalan Can : <?php echo $tabloListele["kalanHak"]  ?> adet</div>
        <div class="content">
            <div class="kutular">
                <div class="kutu"><input class="inputlar" type="text" value="<?php  echo $tabloListele["number1"]; ?>" readonly></div>
                <div class="kutu"><input class="inputlar" type="text" value="<?php  echo $tabloListele["number2"];  ?>" readonly></div>
                <div class="kutu"><input class="inputlar" type="text" value="<?php  echo $tabloListele["number3"];  ?>" readonly></div>
            </div>
            <div class="butonlar">
                <form method="POST" action="controls.php">
                    <button class="buton" type="submit" name="rotate"><i class="fa-sharp fa-solid fa-rotate"></i>Rotate</button>
                </form>
            </div>
        </div>
    <?php }else{
        header("Refresh:1");
        $sorguAnaTablo = $conn -> query(" SELECT * FROM anaTablo");
        $numberOfRow = $sorguAnaTablo ->rowCount();
        $tabloListele = $sorguAnaTablo -> fetch();
        ?>
        <div class="uyariKutusu" style="position: fixed;top: 50%;left: 50%;transform: translate(-50%, -50%);text-align: center ">
                <h1 style="color: white;margin-bottom: 10px">Kalan can adetiniz : <?php echo  $tabloListele["kalanHak"]  ?></h1>
        <h2 class="uyari" style="color: white">Tekrar oynamak için <?php echo (strtotime($tabloListele["yenilenme"])+3600)-time() ?> saniye sonra sayfayı yenileyiniz</h2>
            </div>
    <?php  if(strtotime($tabloListele["yenilenme"])+3600 <= strtotime("now")) {
            $sorguAnaTablo = $conn -> query(" SELECT * FROM anaTablo");
            $tabloListele = $sorguAnaTablo -> fetch();

            $sorguAnaTablo4 = $conn->prepare(" UPDATE anaTablo SET yenilenme=?,kalanHak=?");
            $yeniTarih = date("d-m-Y H:i:s",strtotime($tabloListele["yenilenme"])+3600);
            $sorguAnaTablo4->execute([$yeniTarih,5]);
            header("Refresh:0.5");
        }
    } ?>
</div>
</body>
</html>
