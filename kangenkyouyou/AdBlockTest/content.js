// --- 新規追加: スクロール強制解除処理 ---
// ページ全体に強力なCSSを注入して、overflow: hiddenを無効化する
const sheet = new CSSStyleSheet();
sheet.replaceSync('html, body { overflow: auto !important; height: auto !important; }');
document.adoptedStyleSheets = [...document.adoptedStyleSheets, sheet];

// (オプション) paddingもリセットしたい場合は、上記を以下に差し替えてください
// sheet.replaceSync('html, body { overflow: auto !important; height: auto !important; padding: 0 !important; }');
// -------------------------------------


// --- 以下は以前の「黙らせ」コード (必要に応じて残す) ---

// 1. スクリプト、iframe、広告タグを削除
document.querySelectorAll('script, iframe, ins, ads,[class*=advertise],div.fc-message-root').forEach(el => el.remove());

// 2. タイマーを全停止 (スクロールを邪魔するタイマーも止まる可能性があります)
let id = setTimeout(() => {}, 0);
while (id--) clearTimeout(id);

// 3. 要素を再描画してイベントリスナーを全削除
// (※注意: サイトによってはレイアウトが崩れる可能性があります。
//  スクロール解除だけが目的なら、この3の工程はコメントアウトしても良いかもしれません)
document.body.innerHTML = document.body.innerHTML;

console.log("Scroll forced & Cleanup complete!");