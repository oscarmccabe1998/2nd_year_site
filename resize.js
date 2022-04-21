window.onload= init;

function init(){
	

    let isMobile1 = window.matchMedia("only screen and (max-width: 760px)").matches; 
    if (isMobile1){
        document.getElementById("videoPlayer").classList.add("iframeMobile");
    } else {
        document.getElementById("videoPlayer").classList.add("iframeDesktop");
    }
}







