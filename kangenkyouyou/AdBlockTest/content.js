
// overflow: hiddenを無効化
const sheet = new CSSStyleSheet();
sheet.replaceSync('html, body { overflow: auto !important; height: auto !important; }');
document.adoptedStyleSheets = [...document.adoptedStyleSheets, sheet];


// sheet.replaceSync('html, body { overflow: auto !important; height: auto !important; padding: 0 !important; }');
// -------------------------------------


// スクリプト、iframe、広告タグを削除
document.querySelectorAll('script, iframe, ins, ads,[class*=advertise],div.fc-message-root').forEach(el => el.remove());

// タイマー停止 
let id = setTimeout(() => {}, 0);
while (id--) clearTimeout(id);

// 要素を再描画、イベントリスナーを全削除
// (※注意: サイトによってはレイアウトが崩れる可能性
document.body.innerHTML = document.body.innerHTML;

// console.log("Scroll forced & Cleanup complete!");