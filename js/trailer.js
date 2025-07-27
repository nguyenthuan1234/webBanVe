const urlParams = new URLSearchParams(window.location.search);
const trailerLink = urlParams.get("link");
const movieId = urlParams.get("id");

// Hiển thị trailer YouTube
if (trailerLink) {
  let embedLink = trailerLink;
  if (trailerLink.includes("youtube.com/watch?v=")) {
    const videoId = trailerLink.split("v=")[1].split("&")[0];
    embedLink = `https://www.youtube.com/embed/${videoId}`;
  }
  document.getElementById("trailerFrame").src = embedLink;
} else {
  document.body.innerHTML = "<p style='color: white;'>Không tìm thấy trailer.</p>";
}

// Gọi API lấy thông tin phim theo ID
if (movieId) {
  fetch(`/Banve/php/get_movie_by_id.php?id=${movieId}`)
    .then(res => res.json())
    .then(movie => {
      if (movie && !movie.error) {
        document.getElementById("movieTitle").textContent = movie.title;
        document.getElementById("trailerDescription").innerHTML = `
          <div class="info-line"><strong>Thời lượng:</strong> ${movie.time} phút</div>
          <div class="info-line"><strong>Định dạng:</strong> ${movie.format}</div>
          <div class="info-line"><strong>Giới hạn tuổi:</strong> ${movie.age}+</div>
          <div class="info-line"><strong>Khởi chiếu:</strong> ${movie.release_date}</div>
          <div class="info-line"><strong>Thể loại:</strong> ${movie.phim_type}</div>
          <h2>Mô tả</h2>
          <div class="info-line"><strong>Đạo diễn:</strong> ${movie.director}</div>
          <div class="info-line"><strong>Diễn viên:</strong> ${movie.actors}</div>
          <h2>Nội dung phim</h2>
          <div class="info-line"><strong>Nội dung:</strong> ${movie.description}</div>
        `;
      } else {
        document.getElementById("trailerDescription").textContent = "Không tìm thấy thông tin phim.";
      }
    })
    .catch(err => {
      console.error("Lỗi khi lấy phim:", err);
    });
}
