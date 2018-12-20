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
        <link rel="stylesheet" type="text/css" href="../CSS/qr.css">
        <script src="https://www.gstatic.com/firebasejs/5.6.0/firebase.js"></script>
        <title>QRコード選択画面</title>     
    </head>
    <body>
        <h1 align="center">QRコード決済を選択</h1>
        <p id="price"></p>
        
        <div class="qr_back">
        <form action="paymentFixed.php">
            <div class="qr_select">
                <div class="select">
                    <input type="button" value="We chat" name="we_chat" id="we_chat"  style="width:200px;height:200px">  
                </div>
             
                <div class="select">
                    <input type="button" value="Alipay" name="alipay" id="alipay"  style="width:200px;height:200px">
                </div>
             
                <div class="select">
                    
                    <input type="button" value="LINE pay" name="line_pay" id="line_pay"  style="width:200px;height:200px">                </div>
            </div>
        </form>
        </div>    
        <div class="back_btn">
            <a href="paySelect.php"><img src="../IMG/return.png" width="60" height="65" alt="return"/></a>
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
          
          var we_chat_btn = document.getElementById('we_chat');
          var alipay_btn = document.getElementById('alipay');
          var line_pay_btn = document.getElementById('line_pay');
          
          //firebase呼び出し
          var fdb = firebase.database();
          //firebaseの階層登録
          //ルート
          var qr_root = fdb.ref('/paymentData/carNumber');
          var price_root = fdb.ref('/priceData/carNumber/');
          var flg_root = fdb.ref('/nextFlg/carNumber/');
 
          //データ更新
          we_chat_btn.onclick = function(){
            qr_root.update({
                 [car_number]:we_chat_btn.value});
          }
          
          alipay_btn.onclick = function(){
            qr_root.update({
                 [car_number]:alipay_btn.value});
          }
          
          line_pay_btn.onclick = function(){
            qr_root.update({
                 [car_number]:line_pay_btn.value});
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