

//general
adSelectors = [
    'ins',
    'iframe',
    '#ad',
    '.ad',
    '[id*="ad-"]',
    '[class*="ad-"]',
    '[class*="sponsored"]',

].join(',');
document.querySelectorAll(adSelectors).forEach(ad => {
    ad.remove(); 
});

// for tohoho
adSelectors = [
    'ins',
    'iframe',
    'div[id^="div-gpt-ad-"]',
    '[class*="ad-banner"]',
    '[class*="sponsored"]',
    '[id*="taboola"]',
    '[id*="outbrain"]',
].join(',');
document.querySelectorAll(adSelectors).forEach(ad => {
    ad.remove(); 
});

// for ewords
adSelectors = [
    'ins',
    'iframe',
    'div.fc-message-root',
    '[id^=ad-]',
].join(',');
document.querySelectorAll(adSelectors).forEach(ad => {
    ad.remove(); 
});
document.body.style.overflow="auto";
document.querySelectorAll("[class*=overlay]").forEach(x=>x?.remove());

// to unlock text-selection in ewords
// 【1】CSSによる選択禁止（user-select: none）を破壊する
// disable-copy クラスが付けられた要素からクラスを剥奪します
document.querySelectorAll('.disable-copy').forEach(el => {
    el.classList.remove('disable-copy');
});
// 念のため、body全体とすべての要素に選択可能を強制するCSSを上書きします
 enableSelectStyle = document.createElement('style');
enableSelectStyle.innerHTML = `
    * {
        user-select: text !important;
        -webkit-user-select: text !important;
    }
`;
document.head.appendChild(enableSelectStyle);
// 【2】JavaScriptによる右クリック・コピー妨害イベントを無効化する
// キャプチャリングフェーズ（イベントが伝わる一番最初）で処理を強制終了(stopPropagation)させます
['contextmenu', 'selectstart', 'copy', 'mousedown'].forEach(eventName => {
    document.addEventListener(eventName, function(e) {
        e.stopPropagation(); // サイト側が設定したブロック用JSへイベントが届くのを遮断
    }, true);
});
console.log("テキストの選択・コピー制限を解除しました。");
