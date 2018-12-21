<!DOCTYPE html>
<?php
    //セッション生成
    session_start();
    //セッションから号車を取得
    //$_SESSION['car_number'];
    $car_number = $_SESSION['car_number'];
?>    
<html>
    <head>
        <meta charset="utf-8">
        <title>コメント</title>
        <link rel="stylesheet" type="text/css" href="../CSS/commentStyle.css">
        <link rel="manifest" href="manifest.json">
        <script src="https://www.gstatic.com/firebasejs/5.6.0/firebase.js"></script> 
    </head>
    <body>
        <h1>コメントを選択</h1>
        <div class="comment_back">  
            <div class="comment_content">
                <div class="bl1">
                    <input type="button" id="comment_btn1" value="トイレに行きたい"/>
                    <input type="button" id="comment_btn2" value="コンビニに行きたい"/>
                    <input type="button" id="comment_btn3" value="スーパーに行きたい"/>
                </div>
                <div class="bl2">
                    <input type="button" id="comment_btn4" value="調子がわるい"/>
                    <input type="button" id="comment_btn5" value="お腹が痛い"/>
                    <input type="button" id="comment_btn6" value="頭が痛い"/>
                </div>
                <div class="bl3">
                    <input type="button" id="comment_btn7" value="停止して"/>
                    <input type="button" id="comment_btn8" value="おろして"/>
                    <input type="button" id="comment_btn9" value="発進して"/>
                </div>
            </div>
        </div>         
    </body>
    <script>
        //php変数をJS変数に変換
        var car_number = <?php echo json_encode($car_number); ?>;
    </script>
    <script src="fbConnect.js"></script>
</html>