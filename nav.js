function menuOpen(){
    if (document.getElementById("menu").style.display != "flex"){
        document.getElementById("menu").style.display = "flex";
    }
    else{
        document.getElementById("menu").style.display = "none";
    }
}
window.addEventListener("DOMContentLoaded", function() {
    var login = document.getElementById('login');
    var register = document.getElementById('register');
    var giris = document.getElementById("giris");
    var kayitOl = document.getElementById("kayit");
    var hata = document.getElementById("hata");
    var hataNerede = document.getElementById("hataNerede"); 
    var cikis = document.getElementById("cikis"); 
    if (hataNerede !=null){
        hataNerede=document.getElementById("hataNerede").innerHTML;
    }
    if (login !== null){
        login.addEventListener('click', function(){
            giris.style.display = "block";
        }),
        register.addEventListener('click', function(){
            kayitOl.style.display = "block";
        }),
        giris.addEventListener('click', function(event){
            if (event.target.closest(".blur")){
                giris.style.display = "none";
            }
        }),
        kayitOl.addEventListener('click', function(event){
            if (event.target.closest(".blur")){
                kayitOl.style.display = "none";
            }
        });
        if(hata){
            if(hataNerede == "giris"){
                giris.style.display = "block";
            }
            else{
                kayitOl.style.display = "block";
                console.log(hataNerede);
            }
        }
    }
    cikis.addEventListener('click', function(event){
        event.preventDefault();
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "cikis.php", true);
        xhr.send();
        document.location.href = "/forum/anasayfa.php";
    });
});


    