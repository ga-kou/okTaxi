<!DOCTYPE html>
<?php
    //セッション生成
    session_start();
    $id = $_SESSION['id'];
    $car_number = $_SESSION['car_number'];   
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="../CSS/language.css">
        <script src="https://www.gstatic.com/firebasejs/5.6.0/firebase.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <title>言語選択画面</title>
        
        <script>
            /*$(window).on('touchmove.noScroll', function(e) {
                e.preventDefault();
            });*/
    
            $(function(){
                if($(".no-scroll").length) { 
                    $("body").css('overflow','hidden');
                } else {
                    $("body").css('overflow','auto');
                }
            });
        </script>  
        
    </head>
    <body>
        <h1 align="center">Select Language</h1>
        <div class="language_back">
            <table class="language" >
                <tr>
                    <td class="hata">
                        <a href="goal.php"><img src="../IMG/Japanese.jpg" id="japan" width="170" height="120" alt="Japanese"/></a>
                        <p>日本語</p>
                    </td>
            
                    <td class="hata">
                        <a href="goal.php"><img src="../IMG/Chanese.jpg" id="chana" width="170" height="120" alt="chanese"/></a>
                        <p>中国語</p>
                    </td>
                </tr>
            
                <tr>
                    <td class="hata">
                        <a href="goal.php"><img src="../IMG/American.jpg" id="america" width="170" height="120" alt="American"/></a>
                        <p>English</p>
                    </td>
                
                    <td class="hata">
                        <a href="golal.php"><img src="../IMG/Korean.jpg" id="korea" width="170" height="120" alt="Korean"/></a>
                        <p>한국</p>
                    </td>
                </tr>
            </table>
        </div>
        
        <script>
            //php変数をJS変数の格納
            var car_number = <?php echo json_encode($car_number); ?>;
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
          
            var fdb = firebase.database();

            var language_root = fdb.ref('/languageData/carNumber/');
            var rootNext = fdb.ref("/loginData/loginID/" + loginID);
            var flg_root = fdb.ref('/nextFlg/carNumber/');
            
            var japan = document.getElementById('japan');
            var chana = document.getElementById('chana');
            var america = document.getElementById('america');
            var korea = document.getElementById('korea');
            //loginflg
            var rootNext = fdb.ref("/loginData/loginID/" + loginID);
            rootNext.update({
                carNumber:car_number,
                loginFlg:"true"
            }); 
            
            flg_root.update({
                [car_number]:"false"
            });
            
            
            
            //データ更新
            japan.onclick = function(){
                language_root.update({
                    [car_number]:"日本語"});
            };
            
            chana.onclick = function(){
                language_root.update({
                    [car_number]:"中国語"});
            };
          
            america.onclick = function(){
                language_root.update({
                    [car_number]:"英語"});
            };
            
            korea.onclick = function(){
                language_root.update({
                    [car_number]:"韓国語"});
            };
            
        </script>

        <?php
            
        ?>
    </body>
</html>

