
<?php
    session_start();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="../CSS/Login.css">
        <title>お客様用ログイン</title>
    </head>
    <body>
        <header>
            <h1>お客様用ログイン</h1>
        </header>
        
        <div class="error_msg_back">
        <?php
        //エラーメッセージの初期化
        $error_msg = " ";
        
        //ログインボタンが押された場合の処理
        if(isset($_POST["login"])) {
            // データベースへのアクセス
            try {
                //DBに接続
                $dbh = new PDO('mysql:host=localhost;dbname=taxidatabase','test', 'test');
                //ログインデータを取得するSQL文
                $sql = "SELECT * FROM logindata";
                //SQL文の実行
                $login_data = $dbh->query($sql);
                
                $flag = 0;
                //号車番号が入力されているかの確認と号車番号の値の取得
                if(!$car_number = filter_input(INPUT_POST, 'car_number')){
                    
                    $error['car_number'] = '号車番号を入力してください';
                }
                //号車番号の正規表現 tで始まり６桁まで
                if(preg_match('/^t[0-9]{1,6}+$/', $car_number)) {
                        $flag += 1;
                    }else {
                        $error_msg = "tで始まる６桁の半角英数字を入力してください。";
                        $flag += 0;
                        echo '<p class="error_msg">', $error_msg, '</p>';
                    }
            
                //IDが入力されているかの確認とidの値の取得(’
                if(!$id = filter_input(INPUT_POST, 'id')){
                    $error['id'] = 'idを入力してください';
                }
                
                //idの正規表現 cで始まって数字が５桁まで
                if(preg_match('/^c[0-9]{1,5}+$/', $id)) {
                        $flag += 1;
                    }else {
                        $error_msg = "cで始まる６桁までの半角英数字を入力してください";
                        $flag += 0;
                        echo '<p class="error_msg">', $error_msg, '</p>';
                    }
            
                //パスワードが入力されているかの確認とパスワードの値の取得
                if(!$password = filter_input(INPUT_POST, 'password')){
                    $error['password'] = 'パスワードを入力してください';
                }
                
                //pwの正規表現 半角英数字10桁まで
                if(preg_match('/^[a-zA-Z0-9]{1,10}+$/', $password)) {
                        $flag += 1;
                    }else {
                        $error_msg = "半角英数字10文字以内で入力してください";
                        $flag += 0;
                        echo '<p class="error_msg">', $error_msg, '</p>';
                    }
            
                if($flag == 3) {
                    //DBからログインデータを取得して、入力された値と比較する。
                    foreach ($login_data as $login_data_row) {
                        //号車番号と比較する
                        if($login_data_row['carNumber'] == $car_number) {
                            //IDと比較する
                            if ($login_data_row['loginId'] == $id) {
                                //パスワードと比較する
                                if ($login_data_row['loginId'] == $password){
                                    print "ログインできます";
                                    
                                    //セッションの作成
                                    $_SESSION['id'] = $id;
                                    $_SESSION['car_number'] = $car_number;
                                    
                                    //ログインした後の画面遷移
                                    header('location: language.php');
                                    exit();
                                }else {
                                    $error_msg = "パスワードに誤りがあります。";
                                }

                            }else {
                                $error_msg = "idに誤りがあります。";
                            }
                        }else {
                            $error_msg = "号車番号に誤りがあります。";
                        }
                    }

                }
            
                            
                
            }catch (PDOException $e) {
                print "エラー!: " . $e->getMessage() . "<br/>";
                die();
            }
        
        

        }
        
        
        
        ?>
            </div>
        <div id="login_back">

            <form action="" method="POST">
                <div class="login_content">
                    <table class="login_table">
                        <tr>
                            <td class="label">
                                <label>号車番号</label>
                            </td>
                            <td class="content">
                                <input type="text" name="car_number" class="text_input" placeholder="tで始まり半角数字6桁以内" required/>
                            </td>
                        </tr>
                        <tr>
                            <td class="label">
                                <label>ID</label>
                            </td>
                            <td class="content">    
                                <input type="text" name="id" class="text_input" placeholder="cで始まり半角数字6桁以内" required/>
                            </td>
                        </tr>
                        <tr>
                            <td class="label">
                                <label>PW</label>
                            </td>
                            <td class="content">
                                <input type="password" name="password" class="text_input" placeholder="半角英数字10桁まで" required/>
                            </td>
                        <tr>
                    </table>
                    <div class="login_btn_back">
                        <input type="submit" value="ログイン" id="login_btn" name="login">
                    </div>
                </div>
            </form>
        </div>
 
    </body>
</html>