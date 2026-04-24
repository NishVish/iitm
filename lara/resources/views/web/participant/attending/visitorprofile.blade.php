<style>
    :root {
        --iitm-text: #AA2324;
        --iitm-background: #ffffff;
    }

    .expo {
        padding: 50px 20px;
        font-family: Inter, sans-serif;
        background: var(--iitm-background);
        color: var(--iitm-text);
    }

    .wrap {
        max-width: 1000px;
        margin: auto;
        text-align: center;
    }

    h2 {
        margin: 0;
        font-size: 28px;
        font-weight: 800;
    }

    p {
        margin: 6px 0 25px;
        font-size: 13px;
        opacity: .8;
    }

    .grid {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        justify-content: center;
    }

    .chip {
        padding: 7px 12px;
        border-radius: 999px;
        font-size: 12px;
        border: 1px solid var(--iitm-text);
        color: var(--iitm-text);
    }
</style>

<div class="expo">

    <div class="wrap">

        <h2>Visitors Profile</h2>
        <p>Global travel ecosystem overview</p>

        <div class="grid">

            <div class="chip"><strong>Air</strong> & Transport</div>
            <div class="chip"><strong>Travel</strong> Operators</div>
            <div class="chip"><strong>Hotel</strong> Tech</div>
            <div class="chip"><strong>Eco</strong> Tourism</div>
            <div class="chip"><strong>Adventure</strong> Sports</div>
            <div class="chip"><strong>Forex</strong></div>
            <div class="chip"><strong>MICE</strong></div>
            <div class="chip"><strong>Travel</strong> Tech</div>
            <div class="chip">Other Travel & Hospitality</div>

        </div>

    </div>

</div>