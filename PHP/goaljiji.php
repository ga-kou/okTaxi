<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
    session_start();
    $carNum = $_SESSION['car_number'];
    //$carNum = "t101";
  
        ?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>test</title>
        <script src="https://www.gstatic.com/firebasejs/5.6.0/firebase.js"></script>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="https://map.yahooapis.jp/js/V1/jsapi?appid=OY1oDxsr" type="text/javascript"  charset="UTF-8" ></script>
        <style type="text/css">
            /*文字のフォントをメイリオにする*/
            body {
              font-family: メイリオ;
            }

            /*ヘッダーのところの高さの指定*/
            header {
              height: 90px;
            }

            /*ヘッダーに出る文字のレイアウトの設定*/
            h1 {
              position: relative;
              top: 20px;
              text-align: center;
              font-size: 50px;
            }

            /*本文のところの一番外側　最終的な微調整は各自にすることになりそうです*/
            .goal_back{
               position: relative;
               top: 0;
               right: 0;
               left: 0;
               bottom: 0;

               margin-top: 45px;
               margin-bottom: auto;
               margin-left: auto;
               margin-right: auto;
               /*サイズはコンテンツに応じて変更してください*/
               width: 600px;
               height: 250px;
            }

            /*ボタンのレイアウト下のactiveも一緒に使ってください*/
            #submit_btn {
              display: inline-block;
              padding: 0.5em 1em;
              text-decoration: none;
              background: #FBDBB3;/*ボタン色*/
              color: #000;/*文字色*/
              border: solid 2px #F5A53A;/*枠線*/
              border-radius: 30px; /*角を丸める強さ*/
              font-family: メイリオ;
              font-size: 20px; /*文字のサイズ*/
              box-shadow:2px 2px 2px #C4C2C0; /*影*/
              
            }
            /*ボタンを押した時の挙動*/
            #submit_btn:active {
                transform: translateY(4px);/*下に動く*/
                box-shadow: none; /*影をなくす*/
            }

            /*戻るボタンのレイアウト*/
            .back_btn {
                width: 70px;
                
            }
           
        </style>
    </head>
    <body>
        <h1>目的地選択</h1>
        <div class="goal_back">
        <div style="display:flex;">
            
            
            <div style="">
                <input type="text" id="name" value="" >
                <input type="button" id="search" value="検索">
                <p id="address" ></p>
            
            </div>
            <div id="map" style="width:600px; height:300px;"></div>
        </div>
            <p>目的地が出ない場合は、<br>運転手に行先が書かれているパンフレット等をお見せください。</p>
        
            
        <div style="float: left;">
            <input class="back_btn" type="image" src="../IMG/arrow.png" alt="戻る">
        </div>
        <div style="float: right;">
            <input type="button" id="submit_btn" value="確定">
        </div>
        
        </div>

        <script>
            
            window.onload = function(){
                var config = {
                    apiKey: "AIzaSyBOPrqIzq-UUnRARZOHVYEh87m1FbzBRR0",
                    authDomain: "oktaxi-18bf9.firebaseapp.com",
                    databaseURL: "https://oktaxi-18bf9.firebaseio.com",
                    projectId: "oktaxi-18bf9",
                    storageBucket: "oktaxi-18bf9.appspot.com",
                    messagingSenderId: "149334647256"
                };
                firebase.initializeApp(config);
                

                var map = new Y.Map("map");
                map.drawMap(new Y.LatLng(35.680840,139.767009), 16, "map");
                map.addControl(new Y.LayerSetControl());
                map.addControl(new Y.ZoomControl());
                map.addControl(new Y.CenterMarkControl());
                map.addControl(new Y.ScaleControl());
                
                
    
                // ローカルサーチオブジェクトを生成します
                var local = new Y.LocalSearch();
                var geocoder = new Y.GeoCoder();
                //現在地の緯度経度を取得
                var start;
                navigator.geolocation.getCurrentPosition( 
                        function(position){
                            start = position.coords.latitude + "," + position.coords.longitude;
                            //alert(start);
                        }
                );
                
                //目的地の緯度経度
                var ll;
                var markerClicked = function(){
                    ll = this.getLatLng();
                    var param = {"goal" : ll.toString(), "start" : start};
                    
                    
                    //住所の表示
                    geocoder.execute( { latlng : ll }, function( result ) {
                        if ( result.features.length > 0 ) {
                            //リバースジオコーディング結果を表示
                            document.getElementById('address').innerHTML = result.features[0].property.Address;
                        }
                    } );
                   
                    $.ajax({
                            type: 'POST',
                            url: 'goalSession.php',
                            data: param ,
                            async: false,
                            //ajax通信成功
                            success: function(data) {
                                
                                //alert(data);
                                
                            }
                        });
                    
                };
                    

                // 検索結果のマーカーを地図に立てる関数を定義します。
                var search = function(){
                    // 検索キーワード, 電話帳カセットIDを指定します。
                    var keyword = document.getElementById('name').value;
                    var cid  = "";
                    var options = {};
            
                    var bounds = new Y.LatLngBounds();

                    // 入力した値をパラメータとして検索します。
                    local.search(keyword, cid, options, function(result){
                        for (var i=0, len=result.features.length; i<len; i++) {
                            result.features[i].bind('click', markerClicked);
                            var feature = result.features[i];
                            bounds.extend(feature.latlng);
                        }

                        // 結果のYDFを地図に追加して、マーカーを立てます。
                        map.clearFeatures();
                        if(result.features && result.features[0]){
                            map.addFeatures(result.features);
                            map.drawBounds(bounds);
                            
                        }
                    });
                };
                
                var back = function(){
                    location.href='./language.php';
                };
                
                
                //FireBaseの情報登録
                

                var upBtn = document.getElementById('submit_btn');
                //var com = document.getElementById('com');
                var fdb = firebase.database();
                var startRoot = fdb.ref('/startData/carNumber/');
                var goalRoot = fdb.ref('/goalData/carNumber/');
                var carNum = "<?php echo $carNum;?>";

                //取得
                //root.on("value", function(snapshot) {
                //    com.value = snapshot.val().t105;
                //});

                // データ更新
                upBtn.onclick = function() {

                    //var goalJson = JSON.stringify(ll);
                    //現在地を送信
                    startRoot.update({
                        [carNum]: JSON.stringify(start)
                    });
                    //目的地を送信
                    goalRoot.update({
                        [carNum]: JSON.stringify(ll.toString())
                    });

                    location.href='./comment.php';

                };
            
                //検索
                document.getElementById('search').onclick = search;

                //戻る
                document.getElementsByClassName('back_btn').onclick = back;
            

                
                
                
                     
                
                
               

               
                
                
                
                               
                
            };
            
            
        </script>
        

        
        
    </body>
</html>
