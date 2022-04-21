let darkmode = localStorage.getItem("darkmode");
var darmkode_toggle = document.getElementById("switch_to_dark");


const enableDarkmode = () => {
    document.body.classList.add("darkmode-change");
    localStorage.setItem('darkmode', 'enabled');
    document.getElementById("switch_to_dark").checked = true;
};

const disableDarkmode = () => {
    document.body.classList.remove("darkmode-change");
    localStorage.setItem('darkmode', null);
    document.getElementById("switch_to_dark").checked = false;
};

if (darkmode === "enabled") {
    enableDarkmode();
}

darmkode_toggle.addEventListener("click", () => {
    darkmode = localStorage.getItem("darkmode");
    if (darkmode !== "enabled"){
        enableDarkmode();
    } else {
        disableDarkmode();
    }
} );