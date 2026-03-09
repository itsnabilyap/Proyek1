// Script sederhana untuk efek klik tombol dan scroll halus
document.addEventListener('DOMContentLoaded', () => {
    const buttons = document.querySelectorAll('button');

    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            // Contoh aksi: Scroll ke section atau alert
            if(btn.innerText === "Pesan Sekarang") {
                window.open("https://wa.me/6287727531916", "_blank");
            } else {
                alert("Membuka halaman: " + btn.innerText);
            }
        });
    });
});