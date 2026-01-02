

<?php
$requestLine=$_SERVER['REQUEST_METHOD']
.' ' . $_SERVER['REQUEST_URI'] .' '. $_SERVER['SERVER_PROTOCOL'];
$requestBody=file_get_contents('php://input');
$jsondata=json_decode($requestBody,true);

?>
<footer>
    <!-- <p>&copy; クイズ・アンケート集計ツール All rights reserved.</p> -->
    <!-- <p>
        <?='$_SERVER[\'REMOTE_HOST\']) : '?>
        <?=htmlspecialchars($_SERVER['REMOTE_HOST'])?><br>
    </p> -->
    <p>
        <?='$_SERVER[\'SERVER_NAME\']) : '?>
        <?=htmlspecialchars($_SERVER['SERVER_NAME'])?><br>
    </p>
    <p>
        <?='$_SERVER[\'REMOTE_ADDR\']) : '?>
        <?=htmlspecialchars($_SERVER['REMOTE_ADDR'])?><br>
    </p>
    <p>
        <?='request line : '?>
        <?=htmlspecialchars($requestLine)?><br>
    </p>
    <p>
        <?='request body : '?>
        <?=htmlspecialchars($requestBody!==''?$requestBody:'なし')?><br>
    </p>
    <p>
        <?='$_SERVER[\'DOCUMENT_ROOT\']: '?>
        <?=htmlspecialchars($_SERVER['DOCUMENT_ROOT'])?><br>
    </p>
    <!-- <p>
        <?='__FILE__ : '?>
        <?=htmlspecialchars(__FILE__)?><br>
    </p> -->
    <!-- <p>
        <?='__DIR__: '?>
        <?=htmlspecialchars(__DIR__)?><br>
    </p> -->
</footer>