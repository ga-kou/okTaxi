          // Initialize Firebase
          
//          window.onload= function() {
//              
//          }
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
            ll = snapshot2.val()[carNumber];
            //緯度を取得
            var ido = ll.substring(1,ll.indexOf(",",1));
            parseInt(ido,10);
            //経度を取得
            var keido = ll.substring(ll.indexOf(",",1) + 1,ll.length-1);
            parseInt(keido,10);
            //マップの描画
            ymap.drawMap(new Y.LatLng(ido,keido), 18, Y.LayerSetId.NORMAL);
            //ピン立て
            var marker = new Y.Marker(new Y.LatLng(ido,keido));
            ymap.addFeature(marker);
        });
        
        function logout() {
            var root = db.ref("/loginData/loginID/" + [loginID]);
            
            root.update({ 
                loginFlg:"false"
            });
            
            window.location.href = 'dLogin.php';
        }




