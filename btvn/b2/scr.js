const boxTen = document.querySelector("#box-ten");
const boxDs = document.querySelector("#box-ds");
const from = document.querySelector("#from");
const soDem = document.querySelector("#so-dem");

function capNhatSoDem() {
  const tongSoMon = document.querySelectorAll("#box-ds li").length;
  const soDaMua = document.querySelectorAll("#box-ds .da-mua").length;
  const chuaMua = tongSoMon - soDaMua;
  soDem.textContent = `${chuaMua}/${tongSoMon}`;
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
    li.remove(); // Xóa thẻ li chứa món ăn đó khỏi danh sách
  });

  li.append(span, nutXoa);
  boxDs.append(li);
  boxTen.value = "";
  boxTen.focus();
});
