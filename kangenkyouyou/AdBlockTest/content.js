
// overflow: hiddenを無効化
try {
    sheet = new CSSStyleSheet();
    sheet.replaceSync('html, body { overflow: auto !important; height: auto !important; }');
    document.adoptedStyleSheets = [...document.adoptedStyleSheets, sheet];
} catch (e) {

}


// sheet.replaceSync('html, body { overflow: auto !important; height: auto !important; padding: 0 !important; }');
// -------------------------------------


// スクリプト、iframe、広告タグを削除
document.querySelectorAll('script, iframe, ins, ads,[class*=advertise],div.fc-message-root').forEach(el => el?.remove());

//weblio用
document.querySelectorAll('div[id*=yads]').forEach(el => el?.remove());
document.querySelectorAll('div[id*=yads]').forEach(el => el?.remove());
document.querySelectorAll("[id*=gn_interstitial_outer_area],[id*=google_ads_iframe],video").forEach(el => el?.remove());
document.getElementById("footer-overlay")?.remove();
document.getElementById("footFixAdBar")?.remove();
document.getElementById("videoWrapperDiv")?.remove();

// タイマー停止 
timerId = setTimeout(() => { }, 0);
while (timerId--) clearTimeout(timerId);

// 要素を再描画、イベントリスナーを全削除
// (※注意: サイトによってはレイアウトが崩れる可能性
document.body.innerHTML = document.body.innerHTML;

// console.log("Scroll forced & Cleanup complete!");