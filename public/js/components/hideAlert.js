const closeAlert = function () {
    const alert = document.querySelector(".alert");
    if (!alert) return;

    alert.classList.add("hide");
    setTimeout(() => {
        alert.remove();
    }, 500);
};
setTimeout(closeAlert, 3000);
