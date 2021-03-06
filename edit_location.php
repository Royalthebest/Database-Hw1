<?php
    session_start();
    $dbservername = 'Localhost';
    $dbname = 'hw2';
    $dbusername = 'root';
    $dbuserpassword = '';
    if(isset($_POST['latitude']) && isset($_POST['longitude'])){
        try{
            $floatlong = (float)$_POST['longitude'];
            $floatlat = (float)$_POST['latitude'];
            $account = $_SESSION['account'];
            if(!preg_match("/^-?(\d|[1-9]+\d*|\.\d+|0\.\d+|[1-9]+\d*\.\d+)$/",$_POST['latitude']) || $floatlat > 90.0 || $floatlat < -90.0){
                throw new Exception("緯度格式錯誤!");
            }
            if(!preg_match("/^-?(\d|[1-9]+\d*|\.\d+|0\.\d+|[1-9]+\d*\.\d+)$/",$_POST['longitude']) || $floatlong > 180.0 || $floatlong < -180.0){
                throw new Exception("經度格式錯誤!");
            }
            $conn = new PDO("mysql:host = $dbservername;dbname=$dbname", $dbusername, $dbuserpassword);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt=$conn->prepare("UPDATE user SET latitude = :latitude , longitude = :longitude WHERE account=:account");
            $stmt->execute(array('latitude' => $floatlat,'longitude' => $floatlong,'account' => $account));
            $_SESSION['latitude'] = $floatlat;
            $_SESSION['longitude'] = $floatlong;
            echo "更改成功!";
        }
        catch (Exception $e){
            echo $e->getMessage();
        }
    }
?>