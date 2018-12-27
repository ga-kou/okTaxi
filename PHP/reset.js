

    function reset(){
        
    
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
        var startRoot = fdb.ref('/startData/carNumber/');
        var goalRoot = fdb.ref('/goalData/carNumber/');
        var startAddress = fdb.ref('/startAddress/carNumber/');
        var goalAddress = fdb.ref('/goalAddress/carNumber/');
        var dateroot = fdb.ref('/dateData/carNumber');
        var timeroot = fdb.ref('/timeData/carNumber');
        var payment_root = fdb.ref("/paymentData/carNumber");
        var language_root = fdb.ref("/languageData/carNumber");
        var priceroot = fdb.ref("/priceData/carNumber");
        var comment_root = fdb.ref('/commentData/carNumber/');
        startRoot.update({
            [car_number]:""
        });
        
        goalRoot.update({
            [car_number]:""
        });
        startAddress.update({
            [car_number]:""
        });
        goalAddress.update({
            [car_number]:""
        });
        dateroot.update({
            [car_number]:""
        });
        timeroot.update({
            [car_number]:""
        });
        payment_root.update({
            [car_number]:""
        });
        language_root.update({
            [car_number]:""
        });
        priceroot.update({
            [car_number]:""
        });
        comment_root.update({
            [car_number]:""
        });
        
        //window.location.href = 'driving.php';
    
    }
    
    function seni() {
        window.location.href = 'driving.php';
    }

