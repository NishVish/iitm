/* ───────── COVER PAGE ───────── */
if (isCover) {
wrap.innerHTML = `



<div class="coverlogo">
    ${page.logo ? `<img src="${page.logo}" class="coverlogo" />` : ''}
</div>
<div class="cover-box">
    <h1>${escHtml(page.title || '')}</h1>
    <p class="event-name">${escHtml(page.important_info?.event || '')}</p>
    <p class="website">${escHtml(page.important_info?.website || '')}</p>
</div>

<div class="cover-logo-bar">
    <span>IITM INDIA</span>
    <span>${escHtml(page.important_info?.year || new Date().getFullYear())}</span>
</div>

<!-- ${FOOTER_HTML} -->
`;
return wrap;
}