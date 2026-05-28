<div class="video-container">
    <video id="bg-video" autoplay muted loop playsinline>
        <!-- <source src="https://iitmindia.com/wp-content/uploads/2025/07/Untitled-design-6.mp4" type="video/mp4"> -->






        <source src="https://iitmindia.com/assets/video1.MP4" type="video/mp4">

    </video>
</div>

<style>
    .video-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        overflow: hidden;
        z-index: -1;
        background-color: grey;
    }

    .video-container video {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 100%;
        height: 100%;
        transform: translate(-50%, -50%);
        object-fit: cover;
        pointer-events: none;

        opacity: 0;
        transition: opacity 3s ease-in-out;
    }

    .video-container video.loaded {
        opacity: 1;
    }
</style>
<script>
    window.addEventListener('DOMContentLoaded', () => {
        const video = document.getElementById('bg-video');

        video.addEventListener('canplay', () => {
            setTimeout(() => {
                video.classList.add('loaded');
            }, 2000);
        });
    });
</script>