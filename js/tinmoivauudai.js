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
