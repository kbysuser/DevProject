<?php 
session_start();


try{
    //PDOでデータベースに接続
    require_once $_SERVER['DOCUMENT_ROOT']."/AppUtil.php";
    $pdo = AppUtil::getPDO();
    //フォームデータの取得
    $username=$_POST['username']??$_SERVER['REMOTE_ADDR']??"てすと君!";
    //ここを複数に
    $answers=$_POST['answers'];
    $comment=$_POST['comment']??"デバッグコメント";
    //SQLの準備と実行
    $sql="insert into answers(username,questionId,answer,comment) "
        ."values(:username,:questionId,:answer,:comment)";
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(':username',$username);
    $stmt->bindParam(':comment',$comment);
    //SQLの実行
    foreach($answers as $k=>$v){
        // $questionId=  $questionIdList[$k];
        $stmt->bindParam(':questionId',$k);
        $stmt->bindParam(':answer',$v);
        $stmt->execute();
    };
    echo "登録が完了しました";
    echo var_dump($questionIdList)."\n";
    echo var_dump($answers)."\n";
}catch(PDOException $e){
    die ("<h1>エラー：".$e->getMessage()."</h1>");
}


?>
<script>
function redirect(){
    location.href="./result.php"
}    
</script>
<body onload="redirect();">
    
</body>
