const nut = document.querySelector("#btn-otp");
nut.addEventListener("click", () => {
  let conLai = 10;
  nut.disabled = true;
  nut.textContent = `Gửi lại OTP sau ${conLai} giây`;

  const dem = setInterval(() => {
    conLai--;
    nut.textContent = `Gửi lại OTP sau ${conLai} giây`;
    if (conLai <= 0) {
      clearInterval(dem);
      nut.disabled = false;
      nut.textContent = "Gửi lại OTP";
    }
  }, 1000);
});
