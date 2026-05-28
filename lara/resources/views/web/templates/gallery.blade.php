<style>
    .gallery-wrap {
        padding: 50px 40px 80px;
        background: #aa2324;
        color: #fff;
    }

    .gallery-wrap h2 {
        text-align: center;
        font-size: 48px;
        margin-bottom: 50px;
        font-weight: 700;
    }

    /* Buttons */
    .folder-buttons {
        margin-bottom: 35px;
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        justify-content: center;
    }

    .folder-btn {
        padding: 12px 22px;
        border: none;
        background: #ffffffff;
        color: #aa2324;
        cursor: pointer;
        border-radius: 40px;
        transition: .3s;
        font-size: 15px;
    }

    .folder-btn:hover {
        background: #cb5335ff;
    }

    /* Gallery */
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 22px;
    }

    .gallery-item {
        overflow: hidden;
        border-radius: 18px;
        position: relative;
    }

    .gallery-item img {
        width: 100%;
        height: 280px;
        object-fit: cover;
        cursor: pointer;
        transition: .5s ease;
        display: block;
    }

    .gallery-item:hover img {
        transform: scale(1.08);
        opacity: .9;
    }

    /* Lightbox */
    .lightbox {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, .96);
        justify-content: center;
        align-items: center;
        z-index: 9999;
        padding: 40px;
        box-sizing: border-box;
    }

    .lightbox-content {
        width: 100%;
        max-width: 1200px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .lightbox img {
        width: 100%;
        max-height: 90vh;
        object-fit: contain;
        border-radius: 12px;
    }

    .close-btn {
        position: absolute;
        top: 25px;
        right: 35px;
        color: #fff;
        font-size: 45px;
        cursor: pointer;
        z-index: 10000;
    }

    .nav-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 60px;
        height: 60px;
        border: none;
        border-radius: 50%;
        background: rgba(255, 255, 255, .1);
        color: #fff;
        font-size: 28px;
        cursor: pointer;
        transition: .3s;
        z-index: 10000;
    }

    .nav-btn:hover {
        background: #ff6600;
    }

    .prev-btn {
        left: 25px;
    }

    .next-btn {
        right: 25px;
    }

    @media(max-width:768px) {

        .gallery-wrap {
            padding: 90px 20px 60px;
        }

        .gallery-wrap h2 {
            font-size: 34px;
        }

        .gallery-grid {
            grid-template-columns: 1fr;
        }

        .gallery-item img {
            height: 240px;
        }

        .nav-btn {
            width: 45px;
            height: 45px;
            font-size: 22px;
        }
    }
</style>

<div class="gallery-wrap">

    <h2>Image Gallery</h2>

    <div id="folder-buttons" class="folder-buttons"></div>

    <div id="gallery-container"></div>

    <div id="lightbox" class="lightbox">

        <span class="close-btn">&times;</span>

        <button class="nav-btn prev-btn" id="prev-btn">
            &#10094;
        </button>

        <div class="lightbox-content">
            <img id="lightbox-img" src="" alt="">
        </div>

        <button class="nav-btn next-btn" id="next-btn">
            &#10095;
        </button>

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

        fetch("{{ url('gallerydata') }}")

            .then(response => response.json())

            .then(res => {

                if (!res.status || !res.data.length) {

                    container.innerHTML =
                        "<p>No images found.</p>";

                    return;
                }

                res.data.forEach((folder, index) => {

                    /* Folder Buttons */

                    const button =
                        document.createElement("button");

                    button.textContent = folder.title;
                    button.className = "folder-btn";

                    buttonContainer.appendChild(button);

                    /* Gallery Grid */

                    const grid =
                        document.createElement("div");

                    grid.className = "gallery-grid";

                    grid.style.display =
                        (index === 0) ? "grid" : "none";

                    if (index === 0)
                        currentFolderImages = folder.images;

                    folder.images.forEach((imgUrl, imgIdx) => {

                        const item =
                            document.createElement("div");

                        item.className = "gallery-item";

                        item.innerHTML = `
                    <img src="${imgUrl}" alt="">
                `;

                        item.querySelector("img").onclick = () => {

                            currentIndex = imgIdx;

                            openLightbox();
                        };

                        grid.appendChild(item);
                    });

                    container.appendChild(grid);

                    /* Folder Switch */

                    button.onclick = () => {

                        document
                            .querySelectorAll(".gallery-grid")
                            .forEach(g => g.style.display = "none");

                        grid.style.display = "grid";

                        currentFolderImages = folder.images;
                    };
                });

            })

            .catch(err =>
                console.error("Gallery Error:", err)
            );

        /* Lightbox */

        function openLightbox() {

            lightboxImg.src =
                currentFolderImages[currentIndex];

            lightbox.style.display = "flex";
        }

        function changeImage(step) {

            currentIndex += step;

            if (currentIndex >= currentFolderImages.length)
                currentIndex = 0;

            if (currentIndex < 0)
                currentIndex =
                    currentFolderImages.length - 1;

            lightboxImg.src =
                currentFolderImages[currentIndex];
        }

        document.getElementById("next-btn").onclick = e => {

            e.stopPropagation();

            changeImage(1);
        };

        document.getElementById("prev-btn").onclick = e => {

            e.stopPropagation();

            changeImage(-1);
        };

        document.querySelector(".close-btn").onclick = () => {

            lightbox.style.display = "none";
        };

        lightbox.onclick = e => {

            if (e.target === lightbox)
                lightbox.style.display = "none";
        };

        document.addEventListener("keydown", e => {

            if (lightbox.style.display === "flex") {

                if (e.key === "ArrowRight")
                    changeImage(1);

                if (e.key === "ArrowLeft")
                    changeImage(-1);

                if (e.key === "Escape")
                    lightbox.style.display = "none";
            }
        });

    });
</script>