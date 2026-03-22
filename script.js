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


// Ambil data cart dari localStorage
let cart = JSON.parse(localStorage.getItem("cart")) || [];

// Fungsi tambah ke keranjang
function addToCart(nama, harga, gambar) {
    let item = cart.find(i => i.nama === nama);

    if (item) {
        item.qty += 1;
    } else {
        cart.push({
            nama: nama,
            harga: harga,
            gambar: gambar,
            qty: 1
        });
    }

    localStorage.setItem("cart", JSON.stringify(cart));
    alert("Produk ditambahkan ke keranjang!");
}

// Tampilkan cart
function loadCart() {
    let container = document.getElementById("cart-items");
    let total = 0;
    container.innerHTML = "";

    cart.forEach((item, index) => {
        total += item.harga * item.qty;

        container.innerHTML += `
        <div class="cart-item">
            <img src="${item.gambar}" width="80">
            <p>${item.nama}</p>
            <p>Rp. ${item.harga.toLocaleString()}</p>

            <select onchange="updateQty(${index}, this.value)">
                ${[1,2,3,4,5].map(n => `
                    <option ${item.qty == n ? "selected" : ""}>${n}</option>
                `).join("")}
            </select>

            <p>Rp. ${(item.harga * item.qty).toLocaleString()}</p>

            <button onclick="removeItem(${index})">X</button>
        </div>
        `;
    });

    document.getElementById("total").innerText =
        "Rp. " + total.toLocaleString();
}

// Update jumlah
function updateQty(index, qty) {
    cart[index].qty = parseInt(qty);
    localStorage.setItem("cart", JSON.stringify(cart));
    loadCart();
}

// Hapus item
function removeItem(index) {
    cart.splice(index, 1);
    localStorage.setItem("cart", JSON.stringify(cart));
    loadCart();
}