/* ───────── CONTENT PAGE ───────── */
const inner = document.createElement('div');
inner.className = 'page-inner';

inner.innerHTML = `
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 18px;
        /* Gradient for depth */
        background: linear-gradient(180deg, #c63433 0%, #AA2D2C 50%, #8e2625 100%);
        height: 160px;
        /* Emboss effect using borders and shadows */
        border-top: 2px solid rgba(255, 255, 255, 0.3);
        border-bottom: 4px solid rgba(0, 0, 0, 0.2);
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 4px 10px rgba(0, 0, 0, 0.3);
    }

    .page-title {
        font-size: 28px;
        font-weight: 700;
        color: #fff;
        margin: 0;
        text-transform: uppercase;
        letter-spacing: 1px;
        /* Text emboss */
        text-shadow: -1px -1px 0 rgba(0, 0, 0, 0.3), 1px 1px 1px rgba(255, 255, 255, 0.2);
    }

    .logo-overlay {
        height: 80px;
        width: auto;
        object-fit: contain;
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
    }
</style>

<div class="page-header">
    <h2 class="page-title">${escHtml(page.title || '')}</h2>

    <img class="logo-overlay" src="{{ asset('public/assets/iitm2.png') }}" alt="IITM Logo">
</div>