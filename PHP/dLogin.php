
<!--ログインセッションの作成
変数として全ての取得データの作成
自動生成のデータナンバーの作成
URLが消えるようにするから消えた時のことを考えてレイアウトを組む-->

<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="../CSS/Login.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="https://www.gstatic.com/firebasejs/5.6.0/firebase.js"></script>
        <!--<script type="text/javascript" src="../JS/dLogin.js"></script>-->
        <title>運転手用ログイン</title>
    </head>
    <body>
        
        <header>
            <h1>運転手用ログイン</h1>
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
                $dbh = new PDO('mysql:host=localhost;dbname=taxidatabase','test','password');
                //ログインデータを取得するSQL文
                $sql = "SELECT * FROM logindata";
                //SQL文の実行
                $login_data = $dbh->query($sql);
                
//                //データベースのデータ番号の一番大きいものを取得する
//                $sql2 = "SELECT MAX(dataNumber) FROM collecteddata";
//                //SQL文の実行
//                $data_number = $dbh->query($sql2);
//                
//                //data_Numberの値を取得する
//                foreach ($data_number as $data_number_row) {
//                    $data_number_now = $data_number_row['MAX(dataNumber)'];
//                }
                

                
                $flag = 0;
                //号車番号が入力されているかの確認と号車番号の値の取得
                if(!$car_number = filter_input(INPUT_POST, 'car_number')){
                    
                    $error['car_number'] = '号車番号を入力してください';
                }
                //号車番号の正規表現 tで始まる6桁まで
                if(preg_match('/^t[0-9]{1,5}+$/', $car_number)) {
                        $flag += 1;
                }else {
                        $error_msg = "tで始まる6桁の半角英数字を入力してください。";
                        $flag += 0;
                        echo '<p class="error_msg">', $error_msg, '</p>';
                }
            
                //IDが入力されているかの確認とidの値の取得(’
                if(!$id = filter_input(INPUT_POST, 'id')){
                    $error['id'] = 'idを入力してください';
                }
                
                //idの正規表現 dで始まって数字が５桁まで
                if(preg_match('/^d[0-9]{1,5}+$/', $id)) {
                        $flag += 1;
                }else {
                        $error_msg = "dで始まる６桁までの半角英数字を入力してください";
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
                                if ($login_data_row['loginPassword'] == $password){
                                    
                                    //idと号車番号とdata_numberの値をセッションに格納する
                                    session_start();
                                    $_SESSION['id'] = $id;
                                    $_SESSION['car_number'] = $car_number;
                                    //$_SESSION['data_number'] = $data_number_now + 1;

                                    //画面の遷移
                                    header('location: driving.php');
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
                                <input type="text" name="car_number" class="text_input" placeholder="tで始まり半角数字6桁以内" id="car_number" required/>
                            </td>
                        </tr>
                        <tr>
                            <td class="label">
                                <label>ID</label>
                            </td>
                            <td class="content">    
                                <input type="text" name="id" class="text_input" placeholder="dで始まり半角数字6桁以内" id="login_id" required/>
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