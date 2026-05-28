<style>
    :root {
        --bg: #0b0b0b;
        --accent: #AA2D2C;
    }

    body {
        margin: 0;
    }

    .testimonial-section {
        background: var(--bg);
        height: 100vh;
        overflow: hidden;
        position: relative;
        font-family: Arial, sans-serif;
    }

    .testimonial-track {
        width: 100%;
        height: 100%;
        position: relative;
    }

    .testimonial-card {
        position: absolute;
        inset: 0;
        opacity: 0;
        transform: scale(1.1);
        transition: all 1s ease;
    }

    .testimonial-card.active {
        opacity: 1;
        transform: scale(1);
        z-index: 2;
    }

    .testimonial-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .testimonial-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top,
                rgba(0, 0, 0, .9),
                rgba(0, 0, 0, .2));
        display: flex;
        align-items: flex-end;
        padding: 80px;
        box-sizing: border-box;
    }

    .testimonial-content {
        max-width: 700px;
        color: #fff;
        animation: fadeUp 1s ease;
    }

    .quote {
        font-size: 80px;
        color: var(--accent);
        line-height: 1;
    }

    .testimonial-text {
        font-size: 24px;
        line-height: 1.7;
        margin: 20px 0;
    }

    .testimonial-name {
        font-size: 30px;
        font-weight: bold;
    }

    .testimonial-role {
        margin-top: 10px;
        font-size: 16px;
        opacity: .8;
        letter-spacing: 1px;
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

        .testimonial-overlay {
            padding: 30px;
        }

        .testimonial-text {
            font-size: 17px;
        }

        .testimonial-name {
            font-size: 24px;
        }

        .quote {
            font-size: 50px;
        }
    }
</style>

<section class="testimonial-section">

    <div class="testimonial-track" id="track"></div>

</section>

<script>
    const track = document.getElementById('track');

    let current = 0;
    let cards = [];

    fetch("{{ url('getHighlights') }}/testimonials")
        .then(res => res.json())
        .then(res => {

            const data = res.data || [];

            track.innerHTML = data.map((item, index) => `

    <div class="testimonial-card ${index === 0 ? 'active' : ''}">

      <img src="public/${item.image}"
           onerror="this.src='https://via.placeholder.com/1920x1080'">

      <div class="testimonial-overlay">

        <div class="testimonial-content">

          <div class="quote">“</div>

          <div class="testimonial-text">
            ${item.text}
          </div>

          <div class="testimonial-name">
            ${item.name || 'Exhibitor'}
          </div>

          <div class="testimonial-role">
            ${item.role || 'Travel Industry Partner'}
          </div>

        </div>

      </div>

    </div>

  `).join('');

            cards = document.querySelectorAll('.testimonial-card');

            setInterval(() => {

                cards[current].classList.remove('active');

                current = (current + 1) % cards.length;

                cards[current].classList.add('active');

            }, 5000);

        });
</script>