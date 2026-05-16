function getCart() {
    return JSON.parse(localStorage.getItem("cart")) || [];
}

function saveCart(cart) {
    localStorage.setItem("cart", JSON.stringify(cart));
}

function tambahDariDetail(nama, harga, gambar) {

    let selectElemen =
        document.getElementById("pilihan-jumlah");

    let qty = 1;

    if (selectElemen) {

        qty = parseInt(selectElemen.value);

        if (isNaN(qty) || qty <= 0) {

            alert("Silakan pilih jumlah terlebih dahulu!");

            return;
        }
    }

    let tipe = qty >= 20 ? "Pack" : "Paket";

    let cart = getCart();

    let existing =
        cart.find(item => item.nama === nama);

    if (existing) {

        existing.qty += qty;

    } else {

        cart.push({
            nama: nama,
            harga: harga,
            gambar: gambar,
            qty: qty,
            tipe: tipe
        });

    }

    saveCart(cart);

    updateCartCount();

    window.location.href = "keranjang.php";
}

function loadCart() {

    let cart =
        JSON.parse(localStorage.getItem("cart")) || [];

    let container =
        document.getElementById("cart-items");

    let totalElement =
        document.getElementById("total");

    let total = 0;

    if (!container) return;

    container.innerHTML = "";

    if (cart.length === 0) {

        container.innerHTML = `
        
        <div class="empty-cart">
            Keranjang kosong
        </div>

        `;

        if (totalElement) {
            totalElement.innerText = "Rp. 0";
        }

        return;
    }

    cart.forEach((item, index) => {

        let subtotal =
            item.harga * item.qty;

        total += subtotal;

        container.innerHTML += `

        <div class="table-row">

            <div class="product">

                <img src="${item.gambar}">

                <div>${item.nama}</div>

            </div>

            <div>
                Rp. ${item.harga.toLocaleString('id-ID')}
            </div>

            <div class="qty-box">

                <button
                    class="qty-btn"
                    onclick="kurangQty(${index})">

                    <i class="fa fa-minus"></i>

                </button>

                <span class="qty-number">

                    ${item.qty}

                </span>

                <button
                    class="qty-btn"
                    onclick="tambahQty(${index})">

                    <i class="fa fa-plus"></i>

                </button>

            </div>

            <div>

                <b>

                    Rp. ${subtotal.toLocaleString('id-ID')}

                </b>

            </div>

            <div class="action-box">

                <button
                    class="cancel-btn"
                    onclick="removeItem(${index})">

                    <i class="fa fa-xmark"></i>

                </button>

            </div>

        </div>

        `;
    });


    if (totalElement) {

        totalElement.innerText =
            "Rp. " + total.toLocaleString('id-ID');

    }
}

function removeItem(index) {

    if (confirm("Yakin hapus item ini?")) {

        let cart =
            JSON.parse(localStorage.getItem("cart")) || [];

        cart.splice(index, 1);

        localStorage.setItem(
            "cart",
            JSON.stringify(cart)
        );

        loadCart();

        updateCartCount();
    }
}

function updateCartCount() {

    let cart =
        JSON.parse(localStorage.getItem("cart")) || [];

    let totalQty = 0;

    cart.forEach(item => {
        totalQty += item.qty;
    });

    let badge =
        document.getElementById("cart-count");

    if (badge) {
        badge.innerText = totalQty;
    }
}

function tambahQty(index) {

    let cart =
        JSON.parse(localStorage.getItem("cart")) || [];

    cart[index].qty++;

    localStorage.setItem(
        "cart",
        JSON.stringify(cart)
    );

    loadCart();

    updateCartCount();
}

function kurangQty(index) {

    let cart =
        JSON.parse(localStorage.getItem("cart")) || [];

    if (cart[index].qty > 1) {
        cart[index].qty--;
    }

    localStorage.setItem(
        "cart",
        JSON.stringify(cart)
    );

    loadCart();

    updateCartCount();
}

function checkoutWA() {

    let cart =
        JSON.parse(localStorage.getItem("cart")) || [];

    let nama =
        document.getElementById("nama").value;

    let hp =
        document.getElementById("hp").value;

    let alamat =
        document.getElementById("alamat").value;

    if (
        nama === "" ||
        hp === "" ||
        alamat === ""
    ) {

        alert("Isi semua data terlebih dahulu!");

        return false;
    }

    if (cart.length === 0) {

        alert("Keranjang pesanan masih kosong!");

        return false;
    }

    document.getElementById("cart_data").value =
        JSON.stringify(cart);

    return true;
}

window.onload = function () {

    loadCart();

    updateCartCount();

};