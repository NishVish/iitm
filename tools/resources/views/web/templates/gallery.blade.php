<div class="gallery-wrap">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap');

        .gallery-wrap {
            padding: 60px 40px 90px;
            background: #aa2324;
            color: #fff;
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
        }

        .gallery-wrap h2 {
            text-align: center;
            font-size: 42px;
            margin-bottom: 40px;
            font-weight: 700;
            letter-spacing: -1px;
            color: #fff;
        }

        /* Folder Buttons Layout */
        .folder-buttons {
            margin-bottom: 45px;
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .folder-btn {
            padding: 12px 28px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            cursor: pointer;
            border-radius: 50px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 15px;
            font-weight: 600;
            backdrop-filter: blur(10px);
        }

        .folder-btn:hover {
            background: #881c1cff;
            color: #fff;
            border-color: #881c1cff;
            transform: translateY(-2px);
        }

        .folder-btn.active {
            background: #881c1cff;
            color: #fff;
            border-color: #881c1cff;
            box-shadow: 0 10px 25px -5px rgba(136, 28, 28, 0.5);
        }

        /* Animated Grid Setup */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
            animation: fadeIn 0.6s ease-out forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Interactive Gallery Cards */
        .gallery-item {
            overflow: hidden;
            border-radius: 24px;
            position: relative;
            background: rgba(0, 0, 0, 0.15);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .gallery-item img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            cursor: pointer;
            transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
            display: block;
        }

        .gallery-item:hover {
            transform: translateY(-8px);
            border-color: rgba(136, 28, 28, 0.8);
            box-shadow: 0 20px 35px -10px rgba(0, 0, 0, 0.3), 0 0 15px rgba(136, 28, 28, 0.3);
        }

        .gallery-item:hover img {
            transform: scale(1.05);
        }

        /* Lightbox UI */
        .lightbox {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.9);
            backdrop-filter: blur(15px);
            justify-content: center;
            align-items: center;
            z-index: 9999;
            padding: 40px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .lightbox.show {
            opacity: 1;
        }

        .lightbox-content {
            width: 100%;
            max-width: 1100px;
            display: flex;
            justify-content: center;
            align-items: center;
            transform: scale(0.95);
            transition: transform 0.3s ease;
        }

        .lightbox.show .lightbox-content {
            transform: scale(1);
        }

        .lightbox img {
            max-width: 100%;
            max-height: 82vh;
            object-fit: contain;
            border-radius: 16px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7);
        }

        /* UI Control Buttons */
        .close-btn {
            position: absolute;
            top: 30px;
            right: 40px;
            color: rgba(255, 255, 255, 0.6);
            font-size: 38px;
            cursor: pointer;
            transition: color 0.2s;
            line-height: 1;
        }

        .close-btn:hover {
            color: #fff;
        }

        .nav-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 56px;
            height: 56px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
            font-size: 20px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(4px);
            transition: all 0.3s;
        }

        .nav-btn:hover {
            background: #881c1cff;
            border-color: #881c1cff;
            box-shadow: 0 0 20px rgba(136, 28, 28, 0.5);
        }

        .prev-btn {
            left: 40px;
        }

        .next-btn {
            right: 40px;
        }

        @media(max-width:768px) {
            .gallery-wrap {
                padding: 50px 20px;
            }

            .gallery-wrap h2 {
                font-size: 32px;
            }

            .gallery-item img {
                height: 260px;
            }

            .nav-btn {
                width: 48px;
                height: 48px;
                font-size: 16px;
            }

            .prev-btn {
                left: 15px;
            }

            .next-btn {
                right: 15px;
            }
        }
    </style>

    <h2>Image Gallery</h2>

    <div id="folder-buttons" class="folder-buttons"></div>
    <div id="gallery-container"></div>

    <div id="lightbox" class="lightbox">
        <span class="close-btn">&times;</span>

        <button class="nav-btn prev-btn" id="prev-btn">&#10094;</button>

        <div class="lightbox-content">
            <img id="lightbox-img" src="" alt="">
        </div>

        <button class="nav-btn next-btn" id="next-btn">&#10095;</button>
    </div>

</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {

        const container = document.getElementById("gallery-container");
        const buttonContainer = document.getElementById("folder-buttons");
        const lightbox = document.getElementById("lightbox");
        const lightboxImg = document.getElementById("lightbox-img");

        let currentFolderImages = [];
        let currentIndex = 0;
        let grids = [];
        let buttons = [];

        container.innerHTML = "<p style='text-align:center;color:#fff'>Loading gallery...</p>";

        fetch("{{ url('gallerydata') }}")
            .then(res => res.json())
            .then(res => {

                if (!res.status || !res.data.length) {
                    container.innerHTML = "<p style='text-align:center;color:#fff;'>No images found.</p>";
                    return;
                }

                container.innerHTML = "";
                buttonContainer.innerHTML = "";

                res.data.forEach((folder, index) => {

                    const button = document.createElement("button");
                    button.textContent = folder.title;
                    button.className = "folder-btn";
                    if (index === 0) button.classList.add("active");

                    buttonContainer.appendChild(button);
                    buttons.push(button);

                    const grid = document.createElement("div");
                    grid.className = "gallery-grid";
                    grid.style.display = index === 0 ? "grid" : "none";

                    if (index === 0) currentFolderImages = folder.images;

                    folder.images.forEach((imgUrl, imgIdx) => {

                        const item = document.createElement("div");
                        item.className = "gallery-item";

                        const img = document.createElement("img");
                        img.src = imgUrl;
                        img.loading = "lazy";

                        img.onclick = () => {
                            currentFolderImages = folder.images;
                            currentIndex = imgIdx;
                            openLightbox();
                        };

                        item.appendChild(img);
                        grid.appendChild(item);
                    });

                    container.appendChild(grid);
                    grids.push(grid);

                    button.onclick = () => {
                        grids.forEach(g => {
                            g.style.display = "none";
                            g.style.animation = "none";
                        });
                        buttons.forEach(b => b.classList.remove("active"));

                        grid.style.display = "grid";
                        void grid.offsetWidth;
                        grid.style.animation = "fadeIn 0.6s ease-out forwards";

                        button.classList.add("active");

                        currentFolderImages = folder.images;
                        currentIndex = 0;
                    };
                });

            })
            .catch(err => {
                console.error(err);
                container.innerHTML = "<p style='text-align:center;color:#fff;'>Error loading gallery.</p>";
            });

        function openLightbox() {
            lightbox.style.display = "flex";
            setTimeout(() => lightbox.classList.add("show"), 10);
            updateLightbox();
        }

        function closeLightbox() {
            lightbox.classList.remove("show");
            setTimeout(() => {
                lightbox.style.display = "none";
            }, 300);
        }

        function updateLightbox() {
            lightboxImg.src = currentFolderImages[currentIndex];
        }

        function changeImage(step) {
            currentIndex += step;

            if (currentIndex >= currentFolderImages.length)
                currentIndex = 0;

            if (currentIndex < 0)
                currentIndex = currentFolderImages.length - 1;

            updateLightbox();
        }

        document.getElementById("next-btn").onclick = e => {
            e.stopPropagation();
            changeImage(1);
        };

        document.getElementById("prev-btn").onclick = e => {
            e.stopPropagation();
            changeImage(-1);
        };

        document.querySelector(".close-btn").onclick = closeLightbox;

        lightbox.onclick = e => {
            if (e.target === lightbox) closeLightbox();
        };

        document.addEventListener("keydown", e => {
            if (lightbox.classList.contains("show")) {
                if (e.key === "ArrowRight") changeImage(1);
                if (e.key === "ArrowLeft") changeImage(-1);
                if (e.key === "Escape") closeLightbox();
            }
        });

    });
</script>