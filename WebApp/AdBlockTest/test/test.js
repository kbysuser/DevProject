



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

// 
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



