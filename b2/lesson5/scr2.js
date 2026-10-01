const oTen = document.querySelector('#o-ten');
const ods = document.querySelector('#ds');
const from = document.querySelector('#from');

from.addEventListener('submit', (e) => {
    e.preventDefault();
    const ten = oTen.value.trim();
    if (ten === "") return;

    const li = document.createElement('li');

    const span = document.createElement('span');
    span.textContent = ten;

    const nutXoa = document.createElement('button');
    nutXoa.tpye = 'button';
    nutXoa.textContent = 'X';
    nutXoa.addEventListener('click', () => {
        li.remove();
    });
    
    li.append(span, nutXoa);
    ods.append(li);
    oTen.value = '';
    oTen.focus();
});