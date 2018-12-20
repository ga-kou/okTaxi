<!DOCTYPE html>
<?php
    //セッション生成
    session_start();
    //セッションから号車を取消
    $SESSION['car_number'] = "t101";
    $car_number = $SESSION['car_number'];
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="../CSS/eMoney.css">
        <script src="https://www.gstatic.com/firebasejs/5.6.0/firebase.js"></script>
        <title>電子マネー選択画面</title>
    </head>
    <body>
        <h1 align="center">電子マネーを選択</h1>
        <p id="price"></p>
        
        <div class="eMoney_back">
            <form action="paymentFixed.php">
            
                <div class="emoney_select">
                    <div class="select">
                        <input type="button" value="SUICA" name="suica" id="suica"  style="width:200px;height:200px"> 
                    </div>
             
                    <div class="select">
                        <input type="button" value="ICOCA" name="icoca" id="icoca"  style="width:200px;height:200px">
                    </div>
             
                    <div class="select">
                        <input type="button" value="Edy" name="edy" id="edy"  style="width:200px;height:200px">
                    </div>
            </div>
            
            </form>
        </div>
            
        <div class="back_btn">
            <a href="paySelect.php"><img src="../IMG//return.png" width="60" height="65" alt="return"/></a>
        </div>
        
        <script>
            //php変数をJS変数の格納
            var car_number = <?php echo json_encode($car_number); ?>;
            
            var config = {
            apiKey: "AIzaSyBOPrqIzq-UUnRARZOHVYEh87m1FbzBRR0",
            authDomain: "oktaxi-18bf9.firebaseapp.com",
            databaseURL: "https://oktaxi-18bf9.firebaseio.com",
            projectId: "oktaxi-18bf9",
            storageBucket: "oktaxi-18bf9.appspot.com",
            messagingSenderId: "149334647256"
          };
          firebase.initializeApp(config);
          
          var suica_btn = document.getElementById('suica');
          var icoca_btn = document.getElementById('icoca');
          var edy_btn = document.getElementById('edy');
          
          
          //firebase呼び出し
          var fdb = firebase.database();
          //firebaseの階層登録
          //ルート
          var emoney_root = fdb.ref('/paymentData/carNumber');
          var price_root = fdb.ref('/priceData/carNumber/');
          var flg_root = fdb.ref('/nextFlg/carNumber/');
          
          //データ更新
          suica_btn.onclick = function(){
              
            emoney_root.update({
                 [car_number]:suica_btn.value});
         }
         
         icoca_btn.onclick = function(){
              
            emoney_root.update({
                 [car_number]:icoca_btn.value});
         }
         
         edy_btn.onclick = function(){
              
            emoney_root.update({
                 [car_number]:edy_btn.value});
         }
        
        var price; 

         //値段を表示
        price_root.on("value",function(snapshot){
            price = snapshot.val()[car_number];
    
            document.getElementById('price').innerHTML = price + "円";
            console.log(price);
        });
         
         //ネクストフラグがtrueで遷移
         flg_root.on("value",function(snapshot){
            next_flg = snapshot.val()[car_number];
            if(next_flg == "true"){
            window.location.href = "done.php";
            }
        });     
          
        </script>
        
        <?php
             
        ?>
    </body>
</html>
