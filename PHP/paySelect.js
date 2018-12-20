console.log(car_number);
// Initialize Firebase
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

//ネクストフラグ
var flg_root = fdb.ref('/nextFlg/carNumber/');
var price_root = fdb.ref('/priceData/carNumber/');

function actionCash(){
    document.getElementById('form').action = 'cash.php';
}

function actionCredit(){
    document.getElementById('form').action = 'credit.php';
}

function actionEmoney(){
    document.getElementById('form').action = 'eMoney.php';
}

function actionQr(){
    document.getElementById('form').action = 'qr.php';
}


flg_root.update({
    [car_number]:"false"
});
var price; 

price_root.on("value",function(snapshot){
    price = snapshot.val()[car_number];
    
    document.getElementById('price').innerHTML = price + "円";
});


 