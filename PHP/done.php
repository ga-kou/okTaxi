<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="../CSS/done.css">
        <title>決済完了画面</title>
        <script>
            var flg_root = fdb.ref('/nextFlg/carNumber/');
            flg_root.update({
                [car_number]:"false"
            });
        </script>
            
        <script>
           //5秒後に言語選択画面に遷移する
           setTimeout(function(){
                window.location.href = 'language.php';
           }, 1*1000);
        </script>
        
    </head>
    <body>
        <div class="done_back">
            <p class="use">ご利用</p><br>
            <p class="thanks">ありがとうございました</p>
        </div>
        <?php
             
        ?>
    </body>
</html>

