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
//**FireBaseの情報登録終了**//

//htmlイベントを取得
var comment_btn1 = document.getElementById('comment_btn1');
var comment_btn2 = document.getElementById('comment_btn2');
var comment_btn3 = document.getElementById('comment_btn3');
var comment_btn4 = document.getElementById('comment_btn4');
var comment_btn5 = document.getElementById('comment_btn5');
var comment_btn6 = document.getElementById('comment_btn6');
var comment_btn7 = document.getElementById('comment_btn7');
var comment_btn8 = document.getElementById('comment_btn8');
var comment_btn9 = document.getElementById('comment_btn9');

//firebase呼び出し
var fdb = firebase.database();

//Firebaseの階層登録
//コメントルート
var comment_root = fdb.ref('/commentData/carNumber/');
//ネクストフラグルート
var flg_root = fdb.ref('/nextFlg/carNumber/');

//遷移フラフ
var next_flg = "false";

//ネクストフラグがtrueで遷移
flg_root.on("value", function(snapshot) {
    next_flg = snapshot.val()[car_number];
    if(next_flg === "true"){
        window.location.href = "paySelect.php";
    }
});

//データ更新
comment_btn1.onclick = function() {
    var result = window.confirm('トイレに行きたい：を送信しますか？');
    if(result){
        comment_root.update({
            [car_number]:comment_btn1.value
        });
    }
}
comment_btn2.onclick = function() {
    var result = window.confirm('コンビニに行きたい：を送信しますか？');
    if(result){
        comment_root.update({
            [car_number]:comment_btn2.value
        });
    }
}
comment_btn3.onclick = function() {
    var result = window.confirm('スーパーに行きたい：を送信しますか？');
    if(result){
        comment_root.update({
            [car_number]:comment_btn3.value
        });
    }
}
comment_btn4.onclick = function() {
    var result = window.confirm('調子がわるい：を送信しますか？');
    if(result){
        comment_root.update({
            [car_number]:comment_btn4.value
        });
    }
}
comment_btn5.onclick = function() {
    var result = window.confirm('お腹が痛い：を送信しますか？');
    if(result){
        comment_root.update({
            [car_number]:comment_btn5.value
        });
    }
}
comment_btn6.onclick = function() {
    var result = window.confirm('頭が痛い：を送信しますか？');
    if(result){
        comment_root.update({
            [car_number]:comment_btn6.value
        });
    }
}
comment_btn7.onclick = function() {
    var result = window.confirm('停止して：を送信しますか？');
    if(result){
        comment_root.update({
            [car_number]:comment_btn7.value
        });
    }
}
comment_btn8.onclick = function() {
    var result = window.confirm('おろして：を送信しますか？');
    if(result){
        comment_root.update({
            [car_number]:comment_btn8.value
        });
    }
}
comment_btn9.onclick = function() {
    var result = window.confirm('発進して：を送信しますか？');
    if(result){
        comment_root.update({
            [car_number]:comment_btn9.value
        });
    }
}