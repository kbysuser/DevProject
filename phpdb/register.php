<?php 
session_start();
//データベース接続情報
$host='localhost';
$dbname='crud_app';
$user='root';
// $password='password';
$password='';

try{
    //PDOでデータベースに接続
    $pdo=new PDO("mysql:host={$host};dbname={$dbname};charset=utf8",$user,$password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    //フォームデータの取得
    $username=$_POST['username'];
    $questionId=$_POST['questionId'];
    $answer=$_POST['answer'];
    $comment=$_POST['comment'];
    //SQLの準備と実行
    $sql="insert into answers(username,questionId,answer,comment) "
        ."values(:username,:questionId,:answer,:comment)";
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(':username',$username);
    $stmt->bindParam(':questionId',$questionId);
    $stmt->bindParam(':answer',$answer);
    $stmt->bindParam(':comment',$comment);
    //SQLの実行
    $stmt->execute();
    echo "登録が完了しました";
}catch(PDOException $e){
    echo "<h1>エラー：".$e->getMessage()."</h1>";
}


?>
<script>
function redirect(){
    location.href="./result.php"
}    
</script>
<body onload="redirect();">
    
</body>
