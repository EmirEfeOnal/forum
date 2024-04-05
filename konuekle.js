var inputEvent = new Event('customInputEvent');

function ekle(etiket) {
    var textArea = document.getElementById("yaziAlani"); //Kullanıcının içeriğini yazdığı yer
    var secilenBaslangic = textArea.selectionStart; //Kullanıcının seçiminin başı
    var secilenBitis = textArea.selectionEnd; //Kullanıcının seçiminin sonu
    textArea.value = textArea.value.substring(0, secilenBaslangic) + "<" + etiket + ">" + textArea.value.substring(secilenBaslangic, secilenBitis) + "</" + etiket + ">" + textArea.value.substring(secilenBitis);
    textArea.focus(); //Seçim yapmadan önce focus
    textArea.setSelectionRange(secilenBaslangic + etiket.length + 2, secilenBitis + etiket.length + 2); //Ekleme yaptıktan sonra seçime devam etme
    textArea.dispatchEvent(inputEvent); //Custom Event çağrımı
}

function boyut() {
    var textArea = document.getElementById("yaziAlani");
    var secilenBaslangic = textArea.selectionStart;
    var secilenBitis = textArea.selectionEnd;
    textArea.value = textArea.value.substring(0, secilenBaslangic) + '<boyut "25">' + textArea.value.substring(secilenBaslangic, secilenBitis) + "</boyut>" + textArea.value.substring(secilenBitis);
    //Üst kısım için: 0. index ile secilen baslangic indexine kadar alıp <boyut "25"> yazmakta ardından secilenbaslangic ile secilenbitis aralığını yazmakta sonrasına </boyut> koyup boyuttan sonrasını yazmakta.
    textArea.focus();
    textArea.setSelectionRange(secilenBaslangic + 12, secilenBitis + 12);
    textArea.dispatchEvent(inputEvent);
}

function renk() {
    var textArea = document.getElementById("yaziAlani");
    var secilenBaslangic = textArea.selectionStart;
    var secilenBitis = textArea.selectionEnd;
    textArea.value = textArea.value.substring(0, secilenBaslangic) + '<renk "red">' + textArea.value.substring(secilenBaslangic, secilenBitis) + "</renk>" + textArea.value.substring(secilenBitis);
    textArea.focus();
    textArea.setSelectionRange(secilenBaslangic + 12, secilenBitis + 12);
    textArea.dispatchEvent(inputEvent);
}

window.addEventListener("DOMContentLoaded", function() { //HTML içeriği yüklendikten sonra çalışacaklar
    var gosterDiv = document.getElementById("goster");  //HTML içerisindeki göster divi kullanıcı yaptıklarının çıktısını buradan görecek
    var yaziAlani = document.getElementById("yaziAlani"); //HTML içerisinde kullanıcının tüm işleri yapacağı textarea
    var kategori = document.getElementById("category");  //""
    var uyariDiv = document.getElementById("uyari"); //""
    var gonderButton = document.getElementById("gonder"); //""
    yaziAlani.addEventListener("input", function() {  //Textarea üzerinde input eventinin dinlenmesi
        yaziAlani.dispatchEvent(inputEvent); //input eventi gerçekleştiğinde custom eventin çağrılması
    });
    gonderButton.addEventListener("click", function() {
        var params = 
        {
            icerik: document.getElementById("goster").innerHTML,
            baslik: document.getElementById("baslik").value,
            kategori: document.getElementById("category").value,
            alt_kategori: document.getElementById("sub_category").value
        };
        var jsonParams = JSON.stringify(params);
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "sunucu_tarafi_islem.php", true);
        xhr.setRequestHeader("Content-type", "application/json");
        xhr.send(jsonParams);
        
    });
    yaziAlani.addEventListener("customInputEvent", function() { //hem input hem custom eventlerinin kullanım sebebi, 
        //kullanıcı butona basıp etiket eklediğinde bu durum input olarak algılanmamakta, 
        //manuel olarak input eventi çağıramadığım için custom event ile ayrı bir çağırım yapmaktayım.
        var yaziAlaniDegeri = this.value;

        // Önceki içeriği temizle
        gosterDiv.innerHTML = "";

        // Geri kalan içeriği div içine al
        var geriKalanIcerik = yaziAlaniDegeri //Asıl olayların gerçekleştiği kısım
            .replace(/<sol>(.*?)<\/sol>/g, function(match, p1) { //(.*?) kısmı kullanıcının input yaptığı kısım (parametre gibi düşünülebilir)
                return '<div style="text-align: left;">' + p1 + '</div>'; //yukarıdaki olay bulunduğunda örneğin <sol> </sol> ne olacağı, buradaki p1 (.*?) e denk gelmekte.
            })
            .replace(/<sağ>(.*?)<\/sağ>/g, function(match, p1) {
                return '<div style="text-align: right;">' + p1 + '</div>';
            })
            .replace(/<orta>(.*?)<\/orta>/g, function(match, p1) {
                return '<div style="text-align: center;">' + p1 + '</div>';
            })
            .replace(/<renk "(.*?)">(.*?)<\/renk>/g, function(match, p1, p2) {//çoklu parametreli versiyonu, renk seçimi ve boyut için eklendi.
                return '<span style="color: ' + p1 + ';">' + p2 + '</span>'; //hem boyut hem renk eklemek için span kullanıldı, <a> etiketi kullanıldığında aynı anda iki özellik eklenemiyor
            })
            .replace(/<boyut "(.*?)">(.*?)<\/boyut>/g, function(match, p1, p2) {
                if (Number(p1)>75){
                    return '<span style="font-size: 75px;">' + p2 + '</span>';
                }
                else{
                return '<span style="font-size: ' + p1 + 'px;">' + p2 + '</span>';}
            });
        var satirlar = geriKalanIcerik.split('\n'); //Kullanıcının enterlarını algılamak için kullanıyoruz
        var sonuc = satirlar.map(function(satir) { //Kullanıcının enterlarını algılamak için kullanıyoruz
            return satir + '<br>'; // <br> etiketi ile kullanıcının enter bastığı yerleri önizleme kısmında da aktif hale getiriyoruz, eğer bu kısım olmazsa kullanıcının enterları bir işe yaramamakta.
        }).join(''); //<br> etiketinin eklenmesi

        gosterDiv.innerHTML = sonuc;// Oluşturulan içerikleri göster
        karakterSayisi = yaziAlani.value.length;
        if (karakterSayisi > 24576) {
            // Karakter sınırını aştıysa uyarı mesajını göster
            uyariDiv.innerHTML = "Maksimum karakter limitine ulaştınız.";
            uyariDiv.style.color = "red";
            yaziAlani.value = yaziAlani.value.substring(0, 24576); // Fazla karakterleri sil
        }
        else{
            uyariDiv.innerHTML = "";
        }
    });
       
    document.getElementById('sub_category').disabled = true; //Alt kategori, ana kategori seçilene kadar deaktif olarak duruyor.
    kategori.addEventListener('change', function() { //kategori içerisinde değişim olduğunda
        var kategoriId = kategori.value;
        var altKategoriSelect = document.getElementById('sub_category'); 
        if (kategoriId !== '') { //eğer kategoriId değeri boş değilse
            altKategoriSelect.disabled = false; //alt kategoriyi aktif et
            
            // AJAX ile alt kategorileri doldur
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    altKategoriSelect.innerHTML = xhr.responseText;
                }
            };
            xhr.open('GET', 'get_alt_kategoriler.php?kategori_id=' + encodeURIComponent(kategoriId), true);
            xhr.send();
        } else {
            altKategoriSelect.disabled = true;
            altKategoriSelect.innerHTML = '<option value="">Alt kategori seçin</option>';
        }
    });
});
