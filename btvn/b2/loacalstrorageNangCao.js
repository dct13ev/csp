function luuDuLieu() {
    const mangDuLieu = [];
    const dsLi = document.querySelectorAll("#box-ds li");
    
    dsLi.forEach(li => {
        const theSpan = li.querySelector("span");
        mangDuLieu.push({
            ten: theSpan.textContent,
            daMua: theSpan.classList.contains("da-mua") 
        });
    });
    localStorage.setItem("dsMonAn", JSON.stringify(mangDuLieu));
}

function taoMonAn(ten, trangThaiMua) {
    const li = document.createElement("li");
    
    const span = document.createElement("span");
    span.textContent = ten;
    
    if (trangThaiMua === true) {
        span.classList.add("da-mua");
    }
    span.addEventListener("click", () => {
        span.classList.toggle("da-mua");
        capNhatSoLuong(); // Đếm lại khi gạch ngang
    });

    span.addEventListener("dblclick", () => {
        li.remove();
    capNhatSoLuong();
    });

    li.appendChild(span);
    document.getElementById("box-ds").appendChild(li);
}

function layDuLieu() {
    const duLieu = localStorage.getItem("dsMonAn");
    if (duLieu) {
        const mangDuLieu = JSON.parse(duLieu);
        mangDuLieu.forEach(monAn => {
            taoMonAn(monAn.ten, monAn.daMua);
        });
    }
    capNhatSoLuong();
}

