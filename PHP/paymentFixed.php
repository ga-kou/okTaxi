<?php 
    session_start();
    
    $car_number = $_SESSION['car_number'];
    $_POST['payment'] = null;
    echo $_POST['payment'];

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
                
           <!--支払い完了ボタンと、セッションに入れるべきデータをhiddenで送信する-->
           <form action="dbConnect.php" method="POST">
                <input type="hidden" value="" name="payment" id="payment" />
                <input type="hidden" value="" name="language" id="language" />
                <input type="hidden" value="" name="inTime" id="inTime" />
                <input type="hidden" value="" name="date" id="date" />
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
            var payment_root = db.ref("paymentData/carNumber");
            var language_root = db.ref("languageData/carNumber");
            var time_root = db.ref("timeData/carNumber");
            var date_root = db.ref("dateData/carNumber");
            //号車番号の値の取得
            var carNumber = "<?php echo $car_number; ?>";
            var payment;
            //idの取得
            var select_pay = document.getElementById('select_pay');
            var payment_id = document.getElementById('payment');
            var language_id = document.getElementById('language');
            var inTime_id = document.getElementById('inTime');
            var date_id = document.getElementById('date');
            
            //支払い方法の取得
            payment_root.on("value", function(snapshot){
                payment = snapshot.val()[carNumber];
                //支払い方法をpタグに書き換える
                select_pay.innerHTML = "支払い方法 : " + payment;
                //hiddenの値に代入する
                payment_id.value = payment;
                
            });
            
            //選択された言語の取得
            language_root.on("value", function(snapshot) {
                language = snapshot.val()[carNumber];
                //hiddenの値に代入する
                language_id.value = language;
            });
            
             
            //乗車された時の時間をファイアベースから取得する
            time_root.on("value", function(snapshot) {
                inTime = snapshot.val()[carNumber];
                //hiddenの値に代入する
                inTime_id.value = inTime;
            });
            
            date_root.on("value", function(snapshot) {
                date = snapshot.val()[carNumber];
                //hiddenの値に代入する
                date_id.value = date;
            });
            
            //nextflagをtrueにする
            function nextflag() {
                var nextflag_root = db.ref("nextFlg/carNumber");

                //firebaseの料金の値を更新する
                nextflag_root.update({
                    [carNumber]:"true"
                });
                
                
            }
        </script>
        
        
        
        <?php        
 
             //支払い完了ボタンが押された場合の処理   
            if(!$price = $_POST['price_hidden']){
            
            //値が入っていた場合
            }else {
                //支払い金額の値をセッションに入れる
                $_SESSION['price'] = $price;    
                   
            }
        ?>
    </body>
</html>

