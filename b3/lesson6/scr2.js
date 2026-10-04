const oTen = document.querySelector("#o-ten");
const ods = document.querySelector("#ds");
const from = document.querySelector("#from");

from.addEventListener("submit", (e) => {
  e.preventDefault();
  const ten = oTen.value.trim();
  if (ten === "") return;

  const li = document.createElement("li");

  const span = document.createElement("span");
  span.textContent = ten;

  const nutXoa = document.createElement("button");
  nutXoa.tpye = "button";
  nutXoa.textContent = "X";
  nutXoa.addEventListener("click", () => {
    li.remove();
  });

  li.append(span, nutXoa);
  ods.append(li);
  oTen.value = "";
  oTen.focus();
});
$(document).ready(function() {
    $("#from").submit(function(e) {
        e.preventDefault();
        
        const ten = $("#o-ten").val().trim();
        if (ten === "") return;

        // 1. Tạo các phần tử bằng jQuery
        const $li = $("<li></li>");
        const $span = $("<span></span>").text(ten);
        const $nutXoa = $("<button type='button'>X</button>");

        // 2. Thêm sự kiện click để xóa thẻ li
        $nutXoa.click(function() {
            $li.remove();
        });

        // 3. Gộp span và nút xóa vào thẻ li, sau đó đẩy li vào danh sách
        $li.append($span, $nutXoa);
        $("#ds").append($li);

        // 4. Xóa rỗng ô nhập liệu và tự động trỏ chuột lại vào ô đó (chaining)
        $("#o-ten").val("").focus();
    });
});
