<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Sticky Image Scroll Switch</title>

<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
  }

  body {
    background: #111;
    color: white;
  }

  .container {
    display: flex;
  }

  /* LEFT SIDE (sticky image) */
  .left {
    width: 50%;
    height: 100vh;
    position: sticky;
    top: 0;
    overflow: hidden;
    background: #000;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .left img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: opacity 0.4s ease;
  }

  /* RIGHT SIDE (scroll content) */
  .right {
    width: 50%;
  }

  section {
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    border-bottom: 1px solid #333;
    padding: 40px;
  }

  .s1 { background: #1a1a1a; }
  .s2 { background: #222; }
  .s3 { background: #2a2a2a; }
  .s4 { background: #333; }
</style>
</head>

<body>

<div class="container">

  <!-- Sticky image -->
  <div class="left">
    <img id="stickyImage" src="https://picsum.photos/id/1015/800/1200" />
  </div>

  <!-- Scroll sections -->
  <div class="right">

    <section class="s1" data-img="https://picsum.photos/id/1015/800/1200">
      Section 1
    </section>

    <section class="s2" data-img="https://picsum.photos/id/1016/800/1200">
      Section 2
    </section>

    <section class="s3" data-img="https://picsum.photos/id/1025/800/1200">
      Section 3
    </section>

    <section class="s4" data-img="https://picsum.photos/id/1035/800/1200">
      Section 4
    </section>

  </div>
</div>

<script>
const image = document.getElementById("stickyImage");
const sections = document.querySelectorAll("section");

let currentImg = image.src;

const observer = new IntersectionObserver(
  (entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        const newImg = entry.target.getAttribute("data-img");

        if (newImg !== currentImg) {
          image.style.opacity = 0;

          setTimeout(() => {
            image.src = newImg;
            image.style.opacity = 1;
            currentImg = newImg;
          }, 200);
        }
      }
    });
  },
  {
    threshold: 0.6
  }
);

sections.forEach((sec) => observer.observe(sec));
</script>

</body>
</html>