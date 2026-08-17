if (isLastPage) {
const footer = document.createElement('div');
footer.className = 'lastpage-footer-wrap';

footer.innerHTML = `
<style>
    .lastpage-footer-wrap {
        border-top: 10px solid #AA2D2C;
        text-align: center;
        box-shadow: 0 -10px 30px rgba(0, 0, 0, 0.05);
        overflow: hidden;

        /* THIS is what fixes “half image” */
        background-image: url('${page.bgimage}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;

        min-height: 100vh;
        /* or 600px if you don’t want full screen */
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;

        padding: 60px 20px;
    }

    .footer-card strong {
        display: block;
        font-size: 32px;
        color: #AA2D2C;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 10px;
        text-shadow: 1px 1px 0px #fff, 2px 2px 2px rgba(0, 0, 0, 0.15);
    }

    .footer-address {
        font-size: 16px;
        color: #333;
        max-width: 500px;
        margin: 0 auto 20px;
        line-height: 1.6;
    }

    .footer-contact {
        font-size: 18px;
        font-weight: 700;
        color: #333;
        margin-bottom: 30px;
    }

    .footer-links {
        display: flex;
        justify-content: center;
        gap: 15px;
        flex-wrap: wrap;
    }

    .footer-link-btn {
        background: #AA2D2C;
        color: #fff !important;
        padding: 10px 25px;
        border-radius: 4px;
        text-decoration: none;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 13px;
        letter-spacing: 1px;
        box-shadow: 0 4px 0 #8e2625;
    }
</style>

<div class="footer-card">
    ${page.logo ? `<img src="${page.logo}" style="height:120px;" />` : ''}
    ${page.logo2 ? `<img src="${page.logo2}" style="height:120px;" />` : ''}

    <strong>${escHtml(page.organizer || 'IITM India')}</strong>

    <div class="footer-address">
        ${escHtml(page.address || '')}
    </div>

    <div class="footer-contact">
        📞 ${escHtml(page.phone || '')}
    </div>

    <div class="footer-links">
        ${(page.websites || []).map(w => {
        const cleanUrl = w.replace('https://', '').replace('http://', '');
        return `<a href="https://${cleanUrl}" target="_blank" class="footer-link-btn">🌐 ${cleanUrl}</a>`;
        }).join('')}
    </div>
</div>
`;

wrap.appendChild(footer);
return wrap;
}