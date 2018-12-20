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
        <link rel="stylesheet" type="text/css" href="../CSS/paySelect.css">
        <script src="https://www.gstatic.com/firebasejs/5.6.0/firebase.js"></script>
        <title>決済方法選択画面</title>
        
            
    </head>
    <body>
        <h1 align="center">決済方法を選択</h1>
        <p id="price"></p>
        
        <form id='form' name='form' action="paySelect.php">
        <div class="pay">
            <div class="select" id="cash">
                <input type="submit" value="現金" name="cash" id="cash" onclick="actionCash();" style="width:170px;height:170px"/>  
            </div>
          
            <div class="select" id="credit">
                <button type="submit" value="" name="credit" class="credit" onclick="actionCredit();" style="width:170px;height:170px">クレジット</br>カード</button>
            </div>
            
            <div class="select" id="emoney">
                <input type="submit" value="電子マネー" name="emoney" id="emoney" onclick="actionEmoney();" style="width:170px;height:170px" />
            </div>
                     
            <div class="select" id="qr">
                <input type="submit" value="ORコード" name="qr" id="qr" onclick="actionQr();" style="width:170px;height:170px"/>
            </div>
            
        </div> 
        
        </form>
        
        <div class="back_btn">
            <a href="inputPayment.php"><img src="../IMG/return.png" width="60" height="65" alt="return"/></a>
        </div>

        
        
    </body>
    <script>var car_number = <?php echo json_encode($car_number); ?>;</script>
            <script src="paySelect.js"></script>
</html>
