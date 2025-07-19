const itemsPerPage = 4;
let activeIndex = 0;
let movies = [];
let userRole = "user"; // ✅ Biến lưu role toàn cục

function fetchMovies() {
  fetch("/Banve/php/movies.php", {
    credentials: 'include'
  })
    .then(response => response.json())
    .then(data => {
      console.log("ROLE trả về từ PHP:", data.role);
      movies = data.movies;
      userRole = data.role; // ✅ Gán giá trị role từ PHP
      renderMovies(userRole); // ✅ Truyền role khi render
      updateLoginButton(data.logged_in);
       if (data.logged_in && data.role === "admin") {
      document.getElementById("adminAddButton").style.display = "block";

    }
        if (data.logged_in && data.role === "user") {
      const title = document.querySelector(".tieude");
      if (title) {
        title.style.marginBottom = "-10%";
      }
    }

    });
}

function renderMovies(role = "user") {
  const movieList = document.getElementById("movieList");
  const visible = [...movies.slice(activeIndex, activeIndex + itemsPerPage)];

  if (visible.length < itemsPerPage) {
    visible.push(...movies.slice(0, itemsPerPage - visible.length));
  }

  movieList.innerHTML = visible.map(movie => {
    const isAdmin = role === "admin"; 
    return `
      <div class="movie-item">
        <div class="poster">
          <img src="${movie.poster}" alt="${movie.title}" />
          <div class="badge">
            <span class="format">${movie.format}</span>
            <span class="age">${movie.age}</span>
          </div>
        </div>
        <div class="movie-content">
          <h4>${movie.title}</h4>
        </div>
        <div class="buttons">
          <a href="${movie.trailerLink}" class="trailer-btn">
            <i class="fa fa-play-circle"></i> Xem Trailer
          </a>
          <button class="book-btn">Đặt Vé</button>
          ${isAdmin ? `
              <button class="trailer-btn" onclick="editMovie(${movie.id})">Sửa</button>
              <button class="book-btn" onclick="handleDelete(${movie.id})">Xóa</button>
          ` : ""}
        </div>
      </div>
    `;
  }).join("");

  renderDots();
}

function renderDots() {
  const dotsContainer = document.getElementById("dots");
  const totalDots = Math.ceil(movies.length / itemsPerPage);
  const currentDot = Math.floor(activeIndex / itemsPerPage);

  dotsContainer.innerHTML = "";

  for (let i = 0; i < totalDots; i++) {
    const dot = document.createElement("span");
    dot.className = "dot" + (i === currentDot ? " active" : "");
    dot.onclick = () => {
      activeIndex = i * itemsPerPage;
      renderMovies(userRole); // ✅ Truyền đúng role
    };
    dotsContainer.appendChild(dot);
  }
}

function handlePrev() {
  activeIndex = (activeIndex - itemsPerPage + movies.length) % movies.length;
  renderMovies(userRole); // ✅ Truyền lại role
}

function handleNext() {
  activeIndex = (activeIndex + itemsPerPage) % movies.length;
  renderMovies(userRole); // ✅ Truyền lại role
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

function handleDelete(id) {
  if (!confirm("Bạn có chắc muốn xóa phim này không?")) return;

  fetch(`/Banve/php/delete.php?this_id=${id}`, {
    method: 'GET',
    credentials: 'include'
  })
    .then(msg => {
      fetchMovies(); // Load lại danh sách sau khi xóa
    })
    .catch(err => {
      console.error("Lỗi khi xóa phim:", err);
    });
}

function editMovie(movieId) {
  // Chuyển trang sang edit.php và truyền movieId bằng URL
  window.location.href = "/Banve/php/edit.php?id=" + movieId;
}






fetchMovies(); // Khởi tạo

