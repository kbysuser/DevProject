// 2. メインスレッドからデータを受け取る
self.onmessage = (event) => {
  const num = event.data;
  
  // 意図的に重い処理をシミュレート（例：無駄なループ計算）
  let result = 1;
  for (let i = 1; i <= num; i++) {
    result *= i;
  }

  // 3. 計算結果をメインスレッドに送り返す
  self.postMessage(`計算完了！！！結果は ${result} です`);
};