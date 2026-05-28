@include('web.sponsorship.pagecomponents.header')
<p class="page-category">${escHtml(page.category || '')}</p>

<div class="content-row">
    <style>
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 30px;
            /* Gradient Emboss Effect */
            background: linear-gradient(180deg, #c63433 0%, #AA2D2C 50%, #8e2625 100%);
            height: 160px;
            border-top: 2px solid rgba(255, 255, 255, 0.3);
            border-bottom: 5px solid rgba(0, 0, 0, 0.24);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .page-title {
            font-size: 32px;
            font-weight: 800;
            color: #fff;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            text-shadow: -1px -1px 0 rgba(0, 0, 0, 0.4), 1px 1px 2px rgba(255, 255, 255, 0.2);
        }

        .logo-overlay {
            height: 90px;
            width: auto;
            filter: drop-shadow(0 3px 6px rgba(0, 0, 0, 0.3));
        }

        .page-category {
            padding: 15px 30px;
            font-size: 18px;
            font-weight: 700;
            color: #AA2D2C;
            text-transform: uppercase;
            border-bottom: 1px solid #eee;
        }




        .text-box {
            flex: 1;
            font-size: 16px;
            line-height: 1.7;
            color: #333;
        }

        .content-footer {
            margin: 20px 30px;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 8px;
            text-align: right;
            border-left: 5px solid #AA2D2C;
        }

        .content-price {
            font-size: 24px;
            font-weight: 800;
            color: #AA2D2C;

            margin: 0;
        }
    </style>
    <div class="image-box">
        ${page.image ? `<img class="page-image" src="${page.image}" />` : ''}
    </div>

    <div class="text-box">
        ${page.side_description ? `
        <p class="side-description">
            ${escHtml(page.side_description)}
        </p>
        ` : ''}
    </div>

</div>
${page.price ? `
<div class="content-footer">
    <p class="content-price">Price: ${escHtml(page.price)}</p> Per Location
</div>
` : ''}

`;


/* ───────── BENEFITS ───────── */
if (page.important_info?.benefits?.length) {
const card = document.createElement('div');
card.className = 'card';

card.innerHTML = `
<h3>Key Benefits</h3>

<div class="benefits-list">
    ${page.important_info.benefits.map(b => `
    <div class="benefit-item">
        <strong>${escHtml(b.title || '')}</strong>
        <p>${escHtml(b.description || '')}</p>
    </div>
    `).join('')}
</div>
`;

inner.appendChild(card);
}

/* ───────── NOTE ───────── */
if (page.important_info?.note) {
const noteDiv = document.createElement('div');
noteDiv.className = 'note';
noteDiv.innerHTML = escHtml(page.important_info.note);
inner.appendChild(noteDiv);
}

/* ───────── PACKAGES ───────── */
if (page.packages?.length) {
const grid = document.createElement('div');
grid.className = 'grid-3';

page.packages.forEach(p => {
const c = document.createElement('div');
c.className = 'package-card';

c.innerHTML = `
<h4>${escHtml(p.name || '')}</h4>
<div class="price">${escHtml(p.price || '')}</div>
<p class="stall"><b>Stall:</b> ${escHtml(p.stall_size || 'N/A')}</p>
<ul>${(p.benefits || []).map(b => `<li>${escHtml(b)}</li>`).join('')}</ul>
`;

grid.appendChild(c);
});

inner.appendChild(grid);
}
<!-- ───────── ITEMS ───────── -->

<!-- ───────── ITEMS ───────── -->
if (page.items?.length) {
const grid = document.createElement('div');
grid.className = 'grid-2';

page.items.forEach(item => {
const c = document.createElement('div');
c.className = 'item-card';

c.innerHTML = `
<div class="item-info">
    <style>
        .grid-2 {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .item-card {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border: 1px solid #d9d9d9;
            border-radius: 14px;
            padding: 24px;
            background: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            height: 100%;
        }

        .item-info strong {
            display: block;
            font-size: 20px;
            color: #111;
            margin-bottom: 10px;
        }

        .item-info p {
            font-size: 14px;
            line-height: 1.6;
            color: #555;
            margin-bottom: 16px;
        }

        .item-info ul {
            padding-left: 18px;
            margin: 0;
        }

        .item-info li {
            margin-bottom: 10px;
            font-size: 14px;
            line-height: 1.5;
            color: #333;
        }

        .item-price {
            margin-top: 20px;
            font-size: 28px;
            font-weight: 700;
            color: #c58b2a;
        }

        .item-slots {
            margin-top: 8px;
            font-size: 13px;
            color: #777;
            font-weight: 600;
        }

        @media(max-width:768px) {
            .grid-2 {
                grid-template-columns: 1fr;
            }
        }
    </style>
    <strong>${escHtml(item.name || '')}</strong>

    ${item.description ? `
    <p>${escHtml(item.description)}</p>
    ` : ''}

    ${item.benefits?.length ? `
    <ul>
        ${item.benefits.map(b => `<li>${escHtml(b)}</li>`).join('')}
    </ul>
    ` : ''}
</div>

<div>
    <div class="item-price">${escHtml(item.price || '')}</div>

    ${item.slots_per_city ? `
    <div class="item-slots">
        Slots per City: ${escHtml(String(item.slots_per_city))}
    </div>
    ` : ''}
</div>
`;

grid.appendChild(c);
});

inner.appendChild(grid);
}

wrap.appendChild(inner);
const footer = document.createElement('div');

footer.className = 'footer';

footer.innerHTML = `
<div class="left">iitmindia.com</div>
<style>
    .footer {
        position: absolute;
        bottom: 20px;
        left: 0;
        right: 0;

        display: flex;
        justify-content: space-between;
        padding: 0 25px;

        font-size: 12px;
        color: #666;
        letter-spacing: 1px;
    }

    .footer .left {
        color: #AA2D2C;
        font-weight: 600;
    }

    .footer .right {
        font-weight: 700;
        color: #333;
    }
</style>
<div class="right">Page ${page.page_no}</div>
`;

wrap.appendChild(footer);