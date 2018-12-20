<?php
session_start();

$car_number = $_SESSION['car_number'];


?>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="../CSS/inputPayment.css">
        <title>決算入力</title>
        
    </head>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://www.gstatic.com/firebasejs/5.6.0/firebase.js"></script>
    
    <body>
        
        
         <header>
            <h1>決算入力</h1>
        </header>
        
        <!--金額を入力するフォームの作成-->
        <div class="input_payment_back">
            <p id="error_msg"></p>
            <form name="inputPayment" action="" method="POST" id="input_form">
                <input type="text" name="payment" id="price" placeholder="請求金額を入力してください" required/><span> 円</span>
                <input type="button" id="open-sample-dialog" value="確定" />
            </form>
        </div>
        
            <!--表示されるダイアログの設定-->
            <div class="dialog" id="confirm-dialog">
                
                <div class="dialog-content">
                    <p class="confirm_text">請求金額に間違いはないですか？</p>
                    <p id="output"></p>
                  
                    <div>
                        <form action="paymentFixed.php" method="POST">
                            <input type="hidden" name="price_hidden" id="price_hidden"/>
                            <button type="button" class="dialog-close" name="no">いいえ</button>
                            <button type="submit" class="dialog-send" name="yes">はい</button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!--戻るボタン-->
            <a href=""><img src="../IMG/arrow.png" class="back_arrow"></a>
            
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
                        var root = db.ref("priceData/carNumber");
                        
                        //nextflagをtrueにする
                        function nextflag() {
                            var root2 = db.ref("nextFlg/carNumber");
                            var carNumber = "<?php echo $car_number; ?>";

                            //firebaseの料金の値を更新する
                            root2.update({
                                [carNumber]:"true"
                            });


                        }
 
                        //確定ボタンを押したらダイアログを表示する
                        $("#open-sample-dialog").on("click", function(){
                    
                            //テキストボックスの値を取得して表示する
                            var inputText = $("#price").val();
                            $("#output").text(inputText + "円");
                            
                            //数字のみを通す正規表現
                            var result = inputText.match(/^\d{1,6}$/);
                            
                            
                            if(result !== null) {
                                //leftの値 = (ウィンドウ幅 -コンテンツ幅) ÷ 2
                                var leftPosition = (($(window).width() - $("#confirm-dialog").outerWidth(true)) / 2);
                                //CSSを変更
                                $("#confirm-dialog").css({"left": leftPosition + "px"});
                                //ダイアログを表示する
                                $("#confirm-dialog").show();
                            }else {
                                //テキストボックスに入力されていた値の削除                                
                                $("#price").val("");
                                $("#error_msg").text("6桁以内の数値を入力してください");
                            }

                            
                        });
                    
                        //いいえボタンで非表示
                        $(".dialog-close").on("click", function(){
                            //テキストボックスに入力されていた値の削除
                            $("#price").val("");
                            //ダイアログ表示を削除する
                            $(this).parents(".dialog").hide();
                        });
                        
                        //はいボタンでフォームを送信する
                        $(".dialog-send").on("click", function() {
                            //テキストボックスの値をhiddenのvalueに格納する
                            var inputText = $("#price").val();
                            $('#price_hidden').val(inputText);
                            //セッションで撮ってきた号車番号の値をt_numに格納する
                            var t_num = "<?php echo $car_number; ?>";
                            
                            //firebaseの料金の値を更新する
                            root.update({
                                [t_num]:inputText
                            });
                            nextflag();
       
                        });
                        
                        
                </script>
        

        
    </body>
</html>
