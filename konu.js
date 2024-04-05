const url=document.URL;
window.addEventListener("DOMContentLoaded", function() {
    var yorumYaz = document.getElementById('yorumAlani');
    var begeni = document.getElementById('begen');
    yorumYaz.addEventListener("input", function() {
        karakterSayisi = yorumYaz.value.length;
        if (karakterSayisi > 2048) {
            // Karakter sınırını aştıysa uyarı mesajını göster
            document.getElementById('uyari').innerHTML = "Maksimum karakter limitine ulaştınız.";
            document.getElementById('uyari').style.color = "red";
            yorumYaz.value = yorumYaz.value.substring(0, 2048);
        }
        else{
            document.getElementById('uyari').innerHTML = "";
        }
    });
    if(begeni){
        begeni.addEventListener("click", function(event) {
            event.preventDefault();
            const arama = new URLSearchParams(new URL(url).search);
            const id = arama.get('id');
            var xhr = new XMLHttpRequest();
            var data = new FormData();
            data.append("id", id);
            xhr.open("POST", "begeni_islem.php", true);
            xhr.send(data);
            document.location.reload();
            
        });
    }
});