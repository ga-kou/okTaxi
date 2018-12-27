<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
       <?php
            session_start();
            $id = $_SESSION['id'];
            $car_number = $_SESSION['car_number'];
            
            //DBに接続
            $dbh = new PDO('mysql:host=localhost;dbname=taxidatabase','test', 'password');
            
            //データベースのデータ番号の一番大きいものを取得する
            $sql2 = "SELECT MAX(dataNumber) FROM collecteddata";
            //SQL文の実行
            $data_number = $dbh->query($sql2);
            
            //data_Numberの値を取得する
            foreach ($data_number as $data_number_row) {
                $data_number_now = $data_number_row['MAX(dataNumber)'];
            }
            
            $_SESSION['data_number'] = $data_number_now + 1;
            
            echo $_SESSION['data_number'];
            
                    
            if(isset($_POST['payment'])) {
                $_SESSION['start'] = $_POST['start'];
                $_SESSION['goal'] = $_POST['goal'];
                header('location:inputPayment.php');
                
            }
            
               ?>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="../CSS/driving.css" rel="stylesheet" type="text/css">
        <title></title>
        <script src="https://www.gstatic.com/firebasejs/5.6.0/firebase.js"></script>
        <script type="text/javascript" charset="utf-8" src="https://map.yahooapis.jp/js/V1/jsapi?appid=dj00aiZpPTdKbXhycjQzSGYzaCZzPWNvbnN1bWVyc2VjcmV0Jng9NzU-"></script>
    
    </head>
    <body>
        <!--<input type="text" id="valueInput" placeholder="Messagevalue=" />-->    
        <!--<input type="button" id="updateButton" value="更新"/>-->    
        <script src="https://www.gstatic.com/firebasejs/5.6.0/firebase.js"></script>
        <script type="text/javascript" charset="utf-8" src="https://map.yahooapis.jp/js/V1/jsapi?appid=dj00aiZpPTdKbXhycjQzSGYzaCZzPWNvbnN1bWVyc2VjcmV0Jng9NzU-"></script>
        <table>
            <tr>
                <td>
                    <div id="map" style="width:475px; height:450px">
                        <script>
                            var ymap = new Y.Map("map");
                            ymap.drawMap(new Y.LatLng(35,135), 15, Y.LayerSetId.NORMAL);
                        </script>
                    </div>
                </td>
                <td>
                    <div id="textarea">
                        <textarea disabled id="valueInput" placeholder="Messagevalue=" name="comment" rows="29" cols="60"></textarea>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="payment">
                        <input type="button" id="logout_btn" value="ログアウト" onclick="logout()">
                    </div>
                </td>
                <td>
                    <div>
                        <form action="" method="POST">
                            <input type="hidden" value="" name="start" id="start" />
                            <input type="hidden" value="" name="goal" id="goal" />
                            <input type="submit" value="決済画面へ" name="payment" id="payment_btn"/>
                        </form>
                    </div>
                </td>
            </tr>
        </table>

        <script>
        var carNumber = <?php echo json_encode($car_number);?>;
        var loginID = <?php echo json_encode($id);?>;
        var config = {
            apiKey: "AIzaSyBOPrqIzq-UUnRARZOHVYEh87m1FbzBRR0",
            authDomain: "oktaxi-18bf9.firebaseapp.com",
            databaseURL: "https://oktaxi-18bf9.firebaseio.com",
            projectId: "oktaxi-18bf9",
            storageBucket: "oktaxi-18bf9.appspot.com",
            messagingSenderId: "149334647256"
        };
        
        firebase.initializeApp(config);  
        var db = firebase.database(); 
        
        var rootNext = db.ref("/loginData/loginID/" + loginID);
        rootNext.update({
           carNumber:carNumber,
           loginFlg:"true"
        }); 
        
        var i = 0;
        var s = 0;
        var sn;
        var sAddress;
        var gAddress;
        var gll;
        var commentView = new Array("eol","eol","eol","eol","eol","eol");
        var root = db.ref("/commentData/carNumber/"); 
        var valueInput = document.getElementById('valueInput');
        root.on("value", function(snapshot) {
            sn = snapshot.val()[carNumber];
            if(commentView[0] ==="eol"){
                commentView[0] = sn;
                valueInput.value = commentView[0];
            }else if(sn !== commentView[0]){
                commentView.unshift(sn);
                valueInput.value = "";
                valueInput.value = commentView[i];
                while(i <= 5){
                    i = i + 1;
                    if(commentView[i] !== "eol"){
                        valueInput.value = valueInput.value + "\n" + commentView[i];
                    }
                }
                i = 0;
            };
        });
        var rootGoal = db.ref("/goalData/carNumber/"); 
        var map = document.getElementById('map');
        rootGoal.on("value", function(snapshot2) {
            gll = snapshot2.val()[carNumber];
            //緯度を取得
            var ido = gll.substring(1,gll.indexOf(",",1));
            parseInt(ido,10);
            //経度を取得
            var keido = gll.substring(gll.indexOf(",",1) + 1,gll.length-1);
            parseInt(keido,10);
            //マップの描画
            ymap.drawMap(new Y.LatLng(ido,keido), 18, Y.LayerSetId.NORMAL);
            //ピン立て
            var marker = new Y.Marker(new Y.LatLng(ido,keido));
            ymap.addFeature(marker);
            
        });
        
        
        var rootStartAddress = db.ref("/startAddress/carNumber/"); 
        var start = document.getElementById('start');
        rootStartAddress.on("value", function(snapshot3) {
            start.value = snapshot3.val()[carNumber];
        });
        
        var rootGoalAddress = db.ref("/goalAddress/carNumber/"); 
        var goal = document.getElementById('goal');
        rootGoalAddress.on("value", function(snapshot4) {
            goal.value = snapshot4.val()[carNumber];
        });
        
        function logout() {
            var root = db.ref("/loginData/loginID/" + [loginID]);
            
            root.update({ 
                loginFlg:"false"
            });
            
            window.location.href = 'dLogin.php';
        }
        
        </script>
            
       <!--<script src="driving.js"></script>-->
        
    </body>
</html>
