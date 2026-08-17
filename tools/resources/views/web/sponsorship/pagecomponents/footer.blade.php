/* ───────── LAST PAGE ───────── */
if (isLastPage) {
const footer = document.createElement('div');
footer.className = 'lastpage-footer';

footer.innerHTML = `
<div class="lastpage-footer">
    <strong>${escHtml(page.organizer || '')}</strong><br />
    ${escHtml(page.address || '')}<br />
    📞 ${escHtml(page.phone || '')}<br />
    🌐 ${(page.websites || [])
    .map(w => `<a href="https://${w}" target="_blank">${w}</a>`)
    .join(' | ')}
</div>
`;

wrap.appendChild(footer);
return wrap;
}