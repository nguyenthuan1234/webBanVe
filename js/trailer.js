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