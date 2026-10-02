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
    capNhatSoLuong();
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