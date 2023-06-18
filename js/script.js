function evitar_dados_reload(){

    if(window.history.replaceState) {
        window.history.replaceState( null, null, window.location.href );
    }

    function update(){
        window.location.reload();
    }
}

const header = document.querySelector("header");

window.addEventListener("scroll", function() {
    header.classList.toggle("sticky", window.scrollY > 80);
});