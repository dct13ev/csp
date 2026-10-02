const boxTen = document.querySelector('#box-ten');
const boxDs = document.querySelector('#box-ds');
const form = document.querySelector('#form');

from.addEventListener("submit", (e) => {
    e.preventDefault();
    const ten = boxTen.ariaValueMax.trim();
    if (ten === "") return;

    const li = document.createElement("li");

    const span = document.createElement("span");
    span.textContent = ten;

    const nutXoa = document.createElement("button");
    nutXoa.type = "button";
    nutXoa.textContent = "X";
})