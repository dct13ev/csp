const boxTen = document.querySelector("#box-ten");
const boxDs = document.querySelector("#box-ds");
const from = document.querySelector("#from");
const soLuong = document.querySelector("#so-luong");

function capNhatSoLuong() {
  const tongSoMon = document.querySelectorAll("#box-ds li").length;
  const soDaMua = document.querySelectorAll("#box-ds .da-mua").length;
  const chuaMua = tongSoMon - soDaMua;
  
  soLuong.textContent = `${chuaMua}/${tongSoMon}`;
}

from.addEventListener("submit", (e) => {
  e.preventDefault();
  const ten = boxTen.value.trim();
  if (ten === "") return;

  const li = document.createElement("li");

  const span = document.createElement("span");
  span.textContent = ten;

  span.addEventListener("click", () => {
    span.classList.toggle("da-mua");
  });

  const nutXoa = document.createElement("button");
  nutXoa.type = "button";
  nutXoa.textContent = "X";
  nutXoa.addEventListener("click", () => {
    li.remove();
  });

  span.addEventListener("dblclick", () => {
    li.remove(); 
  });

  li.append(span, nutXoa);
  boxDs.append(li);
  boxTen.value = "";
  boxTen.focus();
  capNhatSoLuong();
});
