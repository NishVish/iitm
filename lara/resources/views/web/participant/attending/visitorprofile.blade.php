<style>
    :root {
        --c: #AA2324
    }

    .sec {
        padding: 30px 15px;
        font-family: Inter, sans-serif
    }

    .wrap {
        max-width: 1000px;
        margin: auto
    }

    .title {
        text-align: center;
        margin-bottom: 15px
    }

    .title h2 {
        margin: 0;
        color: var(--c);
        font-size: 28px
    }

    .title p {
        margin: 5px 0 0;
        color: #666;
        font-size: 13px
    }

    .grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 10px;
    }

    .card {
        border: 1px solid rgba(170, 35, 36, .12);
        border-radius: 10px;
        padding: 10px 12px;
        background: #fafafa;
    }

    .card ul {
        margin: 0;
        padding-left: 14px;
    }

    .card li {
        font-size: 12.5px;
        line-height: 1.35;
        margin: 2px 0;
        color: #444;
    }
</style>

<section class="sec">
    <div class="wrap">

        <div class="title">
            <h2>
                Designed For
            </h2>
            <p>Key stakeholders in travel & hospitality ecosystem</p>
        </div>

        <div class="grid">

            <div class="card">
                <ul>
                    <li>Travel Agents & Tour Operators</li>
                </ul>
            </div>

            <div class="card">
                <ul>
                    <li>MICE Specialists</li>
                    <li>Wedding Planners</li>
                    <li>Event Managers</li>
                </ul>
            </div>

            <div class="card">
                <ul>
                    <li>Corporate Travel Decision Makers</li>
                    <li>Business Travel Heads</li>
                </ul>
            </div>

            <div class="card">
                <ul>
                    <li>Hotel Owners</li>
                    <li>Senior Hospitality Professionals</li>
                    <li>Hotel Managers</li>
                </ul>
            </div>

            <div class="card">
                <ul>
                    <li>Media</li>
                </ul>
            </div>

        </div>

    </div>
</section>