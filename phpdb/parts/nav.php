<script>
    function onClickDebug(){
        answeredPass =prompt("パスワードを入力してください")
        if(answeredPass=="0000"){
            location.href="/debugroom/index.php"
        }else{
            alert("パスワードが違うようです🤮")
        }
    }

</script>
<nav>
    <ul>
        <!-- ↓href="/quiz/index.php" だが、バグるので遷移しないようにした -->
        <li><a  onclick="alert(`ごめんなさい😭未実装です`);">問題を解く</a></li>
        <li><a href="/survey/index.php">アンケート</a></li>
        <li><a onclick="onClickDebug()">デバッグ・集計</a></li>

    </ul>
</nav>