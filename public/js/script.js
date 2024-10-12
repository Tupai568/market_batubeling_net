// script.js
const cancel = document.querySelectorAll("#cancel");
const promoID = document.querySelectorAll("#promo");
const formPromo = document.querySelector(".cild_promo");
const promo = document.querySelectorAll("#promo");
const revisi = document.querySelectorAll(".revisi");
const notifCancel = document.getElementById("notifCancel");
const textRevisi = document.getElementById("textRevisi");
const notifMessage = document.querySelector(".notifMessage");
const addBanner = document.getElementById("addBaner");
const confirmBanner = document.getElementById("confirmBanner");
const fomrBanner = document.querySelector(".confirmBanner");
//detail product

// if (descripsi.scrollHeight > descripsi.clientHeight) {
//     readMoreBtn.style.display = "block"; // Tampilkan tombol jika ada overflow
// } else {
//     readMoreBtn.style.display = "none"; // Sembunyikan tombol jika tidak ada overflow
// }

if (promo) {
    promo.forEach((button) => {
        button.addEventListener("click", () => {
            const idProduct = document.getElementById("ProductId");
            const product = document.getElementById("product");

            //mengambil id product
            const tdElement = event.target.closest(".productId");
            const productId = tdElement.getAttribute("data-product-id");
            const productName = tdElement.getAttribute("data-item-id");

            //menambah value
            idProduct.value = productId;
            product.value = productName;
            event.preventDefault();
        });
    });
}

if (revisi) {
    revisi.forEach((element) => {
        element.addEventListener("click", () => {
            notifMessage.classList.toggle("active");
            const tdElement = event.target.closest(".revisi_id");
            const productId = tdElement.getAttribute("data-product-id");
            const productName = tdElement.getAttribute("data-item-id");
            const productUser = tdElement.getAttribute("data-user-id");

            const revisi = document.getElementById("product_revisi");
            const revisiId = document.getElementById("product_id");
            const userId = document.getElementById("product_user");

            revisi.value = productName;
            revisiId.value = productId;
            userId.value = productUser;
            event.preventDefault();
        });
    });
}

//untuk tombol cancel milik form promo
if (cancel) {
    cancel.forEach((value) => {
        value.addEventListener("click", () => {
            if (formPromo) {
                formPromo.classList.remove("active");
            }

            if (notifMessage) {
                notifMessage.classList.remove("active");
            }

            if (fomrBanner) {
                fomrBanner.classList.remove("active");
            }
        });
    });
}

if (notifCancel) {
    notifCancel.addEventListener("click", () => {
        notifMessage.classList.toggle("active");
    });
}

if (confirmBanner) {
    confirmBanner.addEventListener("click", () => {
        fomrBanner.classList.toggle("active");
    });
}

$(document).ready(function () {
    $.ajax({
        type: "GET",
        url: "/totalNotif",
        success: function (response) {
            if (response.success) {
                if (response.message > 0) {
                    $("#totalNotif").append(response.message);
                }
            }
        },
    });
});

if (addBanner) {
    addBanner.addEventListener("click", () => {
        formPromo.classList.add("active");
    });
}

//untuk tombol menampilkan form promo
promoID.forEach((promo) => {
    promo.addEventListener("click", () => {
        formPromo.classList.add("active");
    });
});

//Start onload
window.onload = function () {
    let notification = document.querySelector(".container-notif");
    let btn = document.getElementById("read-more-btn");
    let textContent = document.querySelector(".descripsi_show div");

    if (notification) {
        setTimeout(function () {
            // Menghapus elemen span dari DOM
            notification.parentNode.removeChild(notification);
        }, 5000);
    }

    if (btn) {
        btn.addEventListener("click", function () {
            textContent.classList.toggle("expanded");
            if (textContent.classList.contains("expanded")) {
                btn.textContent = "Sembunyikan";
            } else {
                btn.textContent = "Lihat Selengkapnya";
            }
        });
    }
};

document.addEventListener("trix-file-accept", function (e) {
    e.preventDefault();
});

const baner = new Swiper(".container_baner", {
    loop: true,
    grabCursor: true,
    autoplay: {
        delay: 3000,
        disableOnInteraction: false,
    },

    // If we need pagination
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
        dynamicBullets: true,
    },
});

const unggulan = new Swiper(".container_unggulan", {
    // Optional parameters

    loop: true,
    grabCursor: true,
    slidesPerGroup: 1,
    autoplay: {
        delay: 3000,
        disableOnInteraction: false,
    },

    // If we need pagination
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
        dynamicBullets: true,
    },

    // Navigation arrows
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },

    //responsive breakpoints
    breakpoints: {
        0: {
            slidesPerView: 1,
        },
        305: {
            slidesPerView: 2,
        },
        441: {
            slidesPerView: 3,
        },
        807: {
            slidesPerView: 4,
        },
        1200: {
            slidesPerView: 5,
        },
    },
});

const swiper = new Swiper(".slider_kategori", {
    // Optional parameters

    loop: true,
    grabCursor: true,
    slidesPerGroup: 1,
    autoplay: {
        delay: 3000,
        disableOnInteraction: false,
    },

    // If we need pagination
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
        dynamicBullets: true,
    },

    // Navigation arrows
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },

    //responsive breakpoints
    breakpoints: {
        0: {
            slidesPerView: 2,
        },
        375: {
            slidesPerView: 3,
        },
        709: {
            slidesPerView: 4,
        },
        1200: {
            slidesPerView: 5,
        },
    },
});
