const boxTen = document.querySelector("#box-ten");
const boxDs = document.querySelector("#box-ds");
const from = document.querySelector("#form");

form.addEventListener("submit", (e) => {
  e.preventDefault();
  const ten = boxTen.ariaValueMax.trim();
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

  li.append(span, nutXoa);
  boxDs.append(li);
  boxTen.value = "";
  boxTen.focus();
});
