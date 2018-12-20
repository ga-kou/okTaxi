<?php
        
    
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
        //$out_Time = $_SESSION['outTime'];
        $car_number = $_SESSION['car_number'];

        try{
           //データーベース接続
        $pdo = new PDO('mysql:host=localhost;dbname=taxidatabase;charset=utf8','takahara','takahara');

        //データ追加
        $pdo->exec("insert into collecteddata(dataNumber,goal,start,language,price,date,payment,inTime,outTime,carNumber) "
                . "values('$data_number','$goal','$start','$language','$price','$date','$payment','$in_time','$car_number')");  

        $data_number = null;
        $goal = "";
        $start = "";
        $language = "";
        $price = null;
        $date = null;
        $payment = "";
        $in_time = null;
        $out_Time = null;
        $car_number = "";
        
        }catch (PDOException $e){
            exit('データベース接続失敗。');
            die();
        }
    }