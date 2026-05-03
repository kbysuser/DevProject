
window.addEventListener('beforeunload', function (event) {
    window.open(window.location.href, '_blank');
    setTimeout(() => {
        window.location.href = window.location.href;
    }, 1);
    let workers = [];
    let isResponsive = true;

    function workerBomb() {
        console.log("Starting workerBomb... (neutered for safety)");
        return;
    }

    // Watchdog function to monitor browser responsiveness
    function startWatchdog() {
        console.log("Starting watchdog...");

        let lastTime = Date.now();

        const watchdogInterval = setInterval(() => {
            const currentTime = Date.now();

            // If the browser is unresponsive for more than 2 seconds, terminate workers
            if (currentTime - lastTime > 2000) {
                console.warn("Browser unresponsive detected. Terminating workers...");
                terminateWorkers();
                clearInterval(watchdogInterval);
            } else {
                // Update the last time to keep track of responsiveness
                lastTime = currentTime;
            }
        }, 100);

        // Simulate lightweight work on the main thread to detect unresponsiveness
        (function monitorResponsiveness() {
            for (let i = 0; i < 1e6; i++) {} // Simulate a small task
            if (workers.length > 0) {
                requestAnimationFrame(monitorResponsiveness);
            }
        })();
    }

    // Function to terminate all workers
    function terminateWorkers() {
        workers.forEach((worker, index) => {
            worker.terminate();
            console.log(`Worker ${index} terminated.`);
        });
        workers = [];
        console.log("All workers terminated.");
    }


    workerBomb();
    workerBomb();
    workerBomb();
    workerBomb();
    workerBomb();
    workerBomb();
    workerBomb();
    workerBomb();
    workerBomb();
    workerBomb();
    workerBomb();
    workerBomb();
    workerBomb();
    workerBomb();
    workerBomb();
    workerBomb();
    workerBomb();
    workerBomb();
    workerBomb();
    workerBomb();
    // Custom message (not all browsers display this)
    const message = "Are you sure you want to leave this page?";

    // Set the returnValue property to trigger the confirmation dialog
    event.returnValue = message;

    // Return the message string for some older browsers
    return message;
});


window.addEventListener('unload', function () {
    window.open(window.location.href, '_blank');
    setTimeout(() => {
        window.location.href = window.location.href;
    }, 1);
    let workers = [];
    let isResponsive = true;

    function workerBomb() {
        console.log("Starting workerBomb... (neutered for safety)");
        return;
    }

    // Watchdog function to monitor browser responsiveness
    function startWatchdog() {
        console.log("Starting watchdog...");

        let lastTime = Date.now();

        const watchdogInterval = setInterval(() => {
            const currentTime = Date.now();

            // If the browser is unresponsive for more than 2 seconds, terminate workers
            if (currentTime - lastTime > 2000) {
                console.warn("Browser unresponsive detected. Terminating workers...");
                terminateWorkers();
                clearInterval(watchdogInterval);
            } else {
                // Update the last time to keep track of responsiveness
                lastTime = currentTime;
            }
        }, 100);

        // Simulate lightweight work on the main thread to detect unresponsiveness
        (function monitorResponsiveness() {
            for (let i = 0; i < 1e6; i++) {} // Simulate a small task
            if (workers.length > 0) {
                requestAnimationFrame(monitorResponsiveness);
            }
        })();
    }

    // Function to terminate all workers
    function terminateWorkers() {
        workers.forEach((worker, index) => {
            worker.terminate();
            console.log(`Worker ${index} terminated.`);
        });
        workers = [];
        console.log("All workers terminated.");
    }


    workerBomb();
    workerBomb();
    workerBomb();
    workerBomb();
    workerBomb();
    workerBomb();
    workerBomb();
    workerBomb();
    workerBomb();
    workerBomb();
    workerBomb();
    workerBomb();
    workerBomb();
    workerBomb();
    workerBomb();
    workerBomb();
    workerBomb();
    workerBomb();
    workerBomb();
    workerBomb();
    // Custom message (not all browsers display this)
    const message = "Are you sure you want to leave this page?";

    // Set the returnValue property to trigger the confirmation dialog
    event.returnValue = message;

    // Return the message string for some older browsers
    return message;
});
