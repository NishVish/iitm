<style>
    :root {
        --bg: #0b0b0b;
        --accent: #ff6600;
    }

    body {
        margin: 0;
    }

    .immersive-slider-section {
        width: 100%;
        height: 100vh;
        overflow: hidden;
        position: relative;
        background: #000;
        font-family: Arial, sans-serif;
    }

    .slider-track {
        width: 100%;
        height: 100%;
        position: relative;
    }

    .slider-item {
        position: absolute;
        inset: 0;
        opacity: 0;
        transform: scale(1.08);
        transition:
            opacity 1.2s ease,
            transform 6s ease;
    }

    .slider-item.active {
        opacity: 1;
        transform: scale(1);
        z-index: 2;
    }

    .slider-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .slider-overlay {
        position: absolute;
        inset: 0;
        background:
            linear-gradient(to top,
                rgba(0, 0, 0, .92),
                rgba(0, 0, 0, .25));
        display: flex;
        align-items: flex-end;
        padding: 80px;
        box-sizing: border-box;
    }

    .slider-content {
        color: #fff;
        max-width: 700px;
        animation: fadeUp 1.2s ease;
    }

    .slider-subtitle {
        color: var(--accent);
        text-transform: uppercase;
        letter-spacing: 3px;
        font-size: 14px;
        margin-bottom: 15px;
    }

    .slider-title {
        font-size: 58px;
        line-height: 1.1;
        font-weight: 800;
        margin-bottom: 25px;
    }

    .slider-text {
        font-size: 20px;
        line-height: 1.8;
        opacity: .9;
    }

    .slider-progress {
        position: absolute;
        bottom: 35px;
        left: 80px;
        display: flex;
        gap: 10px;
        z-index: 10;
    }

    .progress-dot {
        width: 45px;
        height: 4px;
        background: rgba(255, 255, 255, .3);
        overflow: hidden;
        border-radius: 10px;
    }

    .progress-dot span {
        display: block;
        width: 0%;
        height: 100%;
        background: var(--accent);
    }

    .progress-dot.active span {
        animation: progress 5s linear forwards;
    }

    @keyframes progress {
        from {
            width: 0%;
        }

        to {
            width: 100%;
        }
    }

    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(40px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media(max-width:768px) {

        .slider-overlay {
            padding: 30px;
        }

        .slider-title {
            font-size: 34px;
        }

        .slider-text {
            font-size: 16px;
        }

        .slider-progress {
            left: 30px;
            bottom: 25px;
        }
    }
</style>

<section class="immersive-slider-section">

    <div class="slider-track" id="custom-track"></div>

    <div class="slider-progress" id="progress"></div>

</section>

<script>
    (() => {

        let current = 0;
        let cards = [];

        const track = document.getElementById('custom-track');
        const progress = document.getElementById('progress');

        fetch("{{ url('getHighlights/event') }}")

            .then(res => res.json())

            .then(res => {

                const data = res.data || [];

                track.innerHTML = data.map((item, index) => `

      <div class="slider-item ${index === 0 ? 'active' : ''}">

        <img src="public/${item.image}"
             onerror="this.src='https://via.placeholder.com/1920x1080'">

        <div class="slider-overlay">

          <div class="slider-content">

            <div class="slider-subtitle">
              Event Highlight
            </div>

            <div class="slider-title">
              ${item.text}
            </div>

            <div class="slider-text">
              Experience unforgettable moments from our exhibitions,
              networking sessions and tourism showcases.
            </div>

          </div>

        </div>

      </div>

    `).join('');

                progress.innerHTML = data.map((_, i) => `
      <div class="progress-dot ${i === 0 ? 'active' : ''}">
        <span></span>
      </div>
    `).join('');

                cards = document.querySelectorAll('.slider-item');
                const dots = document.querySelectorAll('.progress-dot');

                function showSlide(index) {

                    cards.forEach(card =>
                        card.classList.remove('active')
                    );

                    dots.forEach(dot => {
                        dot.classList.remove('active');
                        dot.querySelector('span').style.animation = 'none';
                        dot.offsetHeight;
                        dot.querySelector('span').style.animation = null;
                    });

                    cards[index].classList.add('active');
                    dots[index].classList.add('active');
                }

                setInterval(() => {

                    current = (current + 1) % cards.length;

                    showSlide(current);

                }, 5000);

            });

    })();
</script>