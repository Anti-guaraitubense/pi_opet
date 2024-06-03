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

let menu = document.querySelector('#menu-icon');
let navlist = document.querySelector('.navlist');

menu.onclick = () => {
    menu.classList.toggle('bx-x');
    navlist.classList.toggle('open');
};

window.onscroll = () => {
    menu.classList.remove('bx-x');
    navlist.classList.remove('open');
};

const sr = scrollReveal({
    origin: 'top',
    distance: '85px',
    duration: 2500,
    reset: true
})

sr.reveal ('.home-text', {delay:300});
sr.reveal ('.home-img', {delay:400});
sr.reveal ('.container', {delay:400});

sr.reveal ('.about-img', {});
sr.reveal ('.about-text', {delay:300});

sr.reveal ('.middle-text', {});
sr.reveal ('.row-btn', {delay:300});

sr.reveal ('.review-content,. contact', {delay:300});

function check_files(label1, file1, label2, file2, cor){
    var label1 = document.getElementById(label1);
    var file1 = document.getElementById(file1);
    var label2 = document.getElementById(label2);
    var file2 = document.getElementById(file2);

    if(file1.files.length > 0){
        label1.style.color = cor;
    }
    if(file2.files.length > 0){
        label2.style.color = cor;
    }
}
