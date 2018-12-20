
<script src="reset.js"></script>





<?php

    session_start();
        //セッションに支払い方法を入れる
        $_SESSION['payment'] = $_POST['payment'];
        $_SESSION['language'] = $_POST['language'];
        $_SESSION['inTime'] = $_POST['inTime'];
        $_SESSION['date'] = $_POST['date'];
        
        $db_access = new dbConnect();
        $db_access->db_access();
        
        echo '<script>reset();</script>';
        
        header('location: driving.php');
        exit();

class dbConnect{    
    function db_access() {

        //セッションスタート

        //収集情報取得・格納
        $data_number = $_SESSION['data_number'];
        $goal = $_SESSION['goal'];
        $start = $_SESSION['start'];
        $language = $_SESSION['language'];
        $price = $_SESSION['price'];
        $date =$_SESSION['date'];
        $payment = $_SESSION['payment'];
        $in_time = $_SESSION['inTime'];
        $car_number = $_SESSION['car_number'];

        try{
           //データーベース接続
        $pdo = new PDO('mysql:host=localhost;dbname=taxidatabase;charset=utf8','takahara','takahara');

        //データ追加
        $pdo->exec("insert into collecteddata(dataNumber,goal,start,language,price,date,payment,inTime,carNumber) "
                . "values('$data_number','$goal','$start','$language','$price','$date','$payment','$in_time','$car_number')");  

        $data_number = null;
        $goal = "";
        $start = "";
        $language = "";
        $price = null;
        $date = null;
        $payment = "";
        $in_time = null;
        $car_number = "";
        
        }catch (PDOException $e){
            exit('データベース接続失敗。');
            die();
        }
    }
}
?>
