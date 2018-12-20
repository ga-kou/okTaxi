<?php 
    session_start();
    
    $car_number = $_SESSION['car_number'];

?>

<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="../CSS/paymentFixed.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="https://www.gstatic.com/firebasejs/5.6.0/firebase.js"></script>
        <title>運転手用ログイン</title>
    </head>
    <body>
        
        

        <div class="pament_fixed_back">
            <p class="fixed_content">支払いが完了したら押してください</p>
            <p id="select_pay"></p>
                

            <form action="" method="POST">
                <input type="submit" value="支払い完了" name="fixed" id="fixed" onclick="nextflag()"/>
            </form>
        </div>
        <script>
             //FireBaseの情報登録
            var config = {
                apiKey: "AIzaSyBOPrqIzq-UUnRARZOHVYEh87m1FbzBRR0",
                authDomain: "oktaxi-18bf9.firebaseapp.com",
                databaseURL: "https://oktaxi-18bf9.firebaseio.com",
                projectId: "oktaxi-18bf9",
                storageBucket: "oktaxi-18bf9.appspot.com",
                messagingSenderId: "149334647256"
            };

            firebase.initializeApp(config);

            //firebaseへの接続
            var db = firebase.database();
            //アクセスする階層の指定
            var root1 = db.ref("paymentData/carNumber");
            //号車番号の値の取得
            var carNumber = "<?php echo $car_number; ?>";
            var test;
            //pタグのidの取得
            var select_pay = document.getElementById('select_pay');
            
            root1.on("value", function(snapshot){
                test = snapshot.val()[carNumber];
                alert(test);
                //支払い方法をpタグに書き換える
                select_pay.innerHTML = "支払い方法 : " + test;
            });
            
            
            function nextflag() {
                
            
                var root2 = db.ref("nextFlg/carNumber");

                //firebaseの料金の値を更新する
                root2.update({
                    [carNumber]:"true"
                });
                
                
            }
        </script>
        
        
        
        <?php            
                
            if(isset($_POST['fixed'])) {

                require_once "dbConnect.php";
                
                //データベースに値を格納する関数の呼び出し
                $db_access = new dbConnect();
                $db_access->db_access();
                
                header('location: driving.php');
                exit();
                
            }else if(!$price = $_POST['price_hidden']){
                    
            }else {
                //支払い金額の値をセッションに入れる
                $_SESSION['price'] = $price;    
                   
            }
        ?>
    </body>
</html>

