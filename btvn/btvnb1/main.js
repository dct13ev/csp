const textArea = document.getElementById('text');
const inputField = document.getElementById('input');
const textCount = document.getElementById('text-count');
const inputCount = document.getElementById('input-count');

textArea.addEventListener('input', () => {
  const textLength = textArea.value.length;
  textCount.textContent = `Số ký tự: ${textLength}`;
});