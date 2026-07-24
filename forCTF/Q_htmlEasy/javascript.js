
        document.addEventListener("DOMContentLoaded", () => {
            document.querySelector("#btn").addEventListener("click", () => {
                alert("ボタンがクリックされました！");
                document.querySelector("#item-1").textContent = "_";
                document.querySelector("#item-2").textContent = document.querySelector("#hiddenInput").value;
                // document.querySelector("#item-3").textContent = "_is";
                document.querySelector("#item-3").textContent = "\x5f\x69\x73";
                document.querySelector("#item-4").textContent = document.querySelector("#hiddenInput").value.replace(/script/i, "");
                // document.querySelector("#item-5").textContent = "_not";
                document.querySelector("#item-5").textContent = "\u{5f}\u006e\u006f\u0074";
                // document.querySelector("#item-5").textContent = document.querySelector("#item-5").textContent.replace(/[0-9]/ig,"");
                // document.querySelector("#item-6").textContent = "ag{";
                document.querySelector("#item-6").textContent = (![] + "")[1] + "\x67" + "\x7b";
                // document.querySelector("#item-7").textContent = "}";
                document.querySelector("#item-7").textContent = "\x7d";
                // document.querySelector("#item-8").textContent = "fl";
                document.querySelector("#item-8").textContent = "\u{66}\u006c";
                //
                setTimeout(() => {
                    document.querySelector("section#features").remove();
                    // document.body.style.backgroundColor = "lime";
                    document.querySelector("main.container").style.animation = "none";
                    document.querySelector("main.container").style.backgroundColor = "lime";


                }, 1000)
            });
        });
    