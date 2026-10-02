function luuDuLieu() {
    const mangDuLieu = [];
    const dsLi = document.querySelectorAll("#box-ds li");
    
    danhSachLi.forEach(li => {
        const theSpan = li.querySelector("span");
        mangDuLieu.push({
            ten: theSpan.textContent,
            daMua: theSpan.classList.contains("da-mua") 
        });
    });
    capNhatSoLuong();
}