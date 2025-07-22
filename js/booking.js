const seatContainer = document.getElementById("seatContainer");
const selectedSeatsInput = document.getElementById("selectedSeats");
let selectedSeats = [];

const rows = 5;
const cols = 8;

function renderSeats() {
    seatContainer.innerHTML = "";
    for (let i = 0; i < rows; i++) {
        const row = document.createElement("div");
        row.className = "seat-row";
        for (let j = 0; j < cols; j++) {
            const seatNumber = `R${i + 1}S${j + 1}`;
            const seat = document.createElement("div");
            seat.className = "seat";
            seat.textContent = seatNumber;
            seat.onclick = () => toggleSeat(seat, seatNumber);
            row.appendChild(seat);
        }
        seatContainer.appendChild(row);
    }
}

function toggleSeat(element, seatNumber) {
    element.classList.toggle("selected");
    if (selectedSeats.includes(seatNumber)) {
        selectedSeats = selectedSeats.filter(s => s !== seatNumber);
    } else {
        selectedSeats.push(seatNumber);
    }
    selectedSeatsInput.value = selectedSeats.join(",");
}

const seatPrice = 50000; // Giá mỗi ghế
const total = selectedSeats.length * seatPrice;

document.getElementById("totalAmount").value = total;
document.getElementById("totalAmountDisplay").textContent = total.toLocaleString() + " VNĐ";

function checkLoginStatus() {
  fetch("/Banve/php/movies.php", {
    credentials: 'include'
  })
    .then(response => response.json())
    .then(data => {
      updateLoginButton(data.logged_in);
    })
    .catch(error => {
      console.error("Lỗi kiểm tra đăng nhập:", error);
    });
}

function updateLoginButton(isLoggedIn) {
  const loginContainer = document.querySelector(".header-right .login .menu-item");
  if (!loginContainer) return;

  if (isLoggedIn) {
    loginContainer.innerHTML = `
      <a href="/Banve/php/logout.php">
        <i class="fas fa-sign-out-alt"></i> Đăng xuất
      </a>
    `;
  } else {
    loginContainer.innerHTML = `
      <a href="/Banve/web/dangnhap.html">
        <i class="fas fa-user"></i> Đăng nhập
      </a>
    `;
  }
}

// ✅ Gọi kiểm tra khi trang vừa tải
checkLoginStatus();


renderSeats();
