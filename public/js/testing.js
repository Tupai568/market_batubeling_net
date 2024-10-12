"use strict";

// mobile menu variables
const mobileMenuOpenBtn = document.querySelectorAll(
    "[data-mobile-menu-open-btn]"
);
const mobileMenu = document.querySelectorAll("[data-mobile-menu]");
const mobileMenuCloseBtn = document.querySelectorAll(
    "[data-mobile-menu-close-btn]"
);
const overlay = document.querySelector("[data-overlay]");

for (let i = 0; i < mobileMenuOpenBtn.length; i++) {
    // mobile menu function
    const mobileMenuCloseFunc = function () {
        mobileMenu[i].classList.remove("active");
        overlay.classList.remove("active");
    };

    mobileMenuOpenBtn[i].addEventListener("click", function () {
        mobileMenu[i].classList.add("active");
        overlay.classList.add("active");
    });

    mobileMenuCloseBtn[i].addEventListener("click", mobileMenuCloseFunc);
    overlay.addEventListener("click", mobileMenuCloseFunc);
}

// accordion variables
const accordionBtn = document.querySelectorAll("[data-accordion-btn]");
const accordion = document.querySelectorAll("[data-accordion]");

for (let i = 0; i < accordionBtn.length; i++) {
    accordionBtn[i].addEventListener("click", function () {
        const clickedBtn = this.nextElementSibling.classList.contains("active");

        for (let i = 0; i < accordion.length; i++) {
            if (clickedBtn) break;

            if (accordion[i].classList.contains("active")) {
                accordion[i].classList.remove("active");
                accordionBtn[i].classList.remove("active");
            }
        }

        this.nextElementSibling.classList.toggle("active");
        this.classList.toggle("active");
    });
}

const descripsi = document.querySelector(".detail-box-descripsi div");
const readMoreBtn = document.getElementById("read-more");

if (descripsi && readMoreBtn) {
    if (descripsi.scrollHeight > descripsi.clientHeight) {
        readMoreBtn.style.display = "block"; // Tampilkan tombol jika ada overflow
    } else {
        readMoreBtn.style.display = "none"; // Sembunyikan tombol jika tidak ada overflow
    }

    readMoreBtn.addEventListener("click", () => {
        descripsi.classList.toggle("expanded");
        if (descripsi.classList.contains("expanded")) {
            readMoreBtn.textContent = "Sembunyikan";
        } else {
            readMoreBtn.textContent = "Lihat Selengkapnya";
        }
    });
}
