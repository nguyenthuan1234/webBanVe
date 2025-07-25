const urlParams = new URLSearchParams(window.location.search);
    const trailerLink = urlParams.get("link");

    if (trailerLink) {
      // Nếu là YouTube link, chuyển đổi sang dạng embeddable
      let embedLink = trailerLink;
      if (trailerLink.includes("youtube.com/watch?v=")) {
        const videoId = trailerLink.split("v=")[1].split("&")[0];
        embedLink = `https://www.youtube.com/embed/${videoId}`;
      }

      document.getElementById("trailerFrame").src = embedLink;
    } else {
      document.body.innerHTML = "<p style='color: white;'>Không tìm thấy trailer.</p>";
  }

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
