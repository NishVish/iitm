<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IITM Sponsorship Prospectus</title>

    <style>
        @include('web.sponsorship.css')
    </style>
</head>

<body>
    <script>
        const HEADER_HTML = `{!! view('web.sponsorship.header')->render() !!}`;
        const FOOTER_HTML = `{!! view('web.sponsorship.footer')->render() !!}`;
    </script>
    <!-- TOOLBAR -->
    <div id="toolbar">
        <button class="btn" id="pdf-btn" onclick="window.print()" disabled>⬇ Generate PDF</button>
        <span id="toolbar-status">Loading data…</span>
    </div>

    <!-- PAGES CONTAINER -->
    <div id="pages-wrapper">
        <div id="status-box">⏳ Fetching sponsor data from server…</div>
        <div id="pages"></div>
    </div>

    <script>
        const pagesContainer = document.getElementById('pages');
        const statusBox = document.getElementById('status-box');
        const toolbarStatus = document.getElementById('toolbar-status');
        const pdfBtn = document.getElementById('pdf-btn');

        /* ── helpers ── */
        function setError(msg) {
            statusBox.textContent = '⚠ ' + msg;
            statusBox.classList.add('error');
            statusBox.style.display = 'block';
            toolbarStatus.textContent = 'Error loading data';
            console.error('[Prospectus]', msg);
        }

        function setStatus(msg) {
            toolbarStatus.textContent = msg;
        }

        /* ── build a single page element ── */
        function buildPage(page) {
            const isCover = page.category === 'Cover Page';
            const wrap = document.createElement('div');
            wrap.className = 'page' + (isCover ? ' cover-page' : '');

            if (isCover) {
                wrap.innerHTML = `

                    <div class="cover-box">
                        <h1>${escHtml(page.title || '')}</h1>
                        <p class="event-name">${escHtml(page.important_info?.event || '')}</p>
                        <p class="website">${escHtml(page.important_info?.website || '')}</p>
                    </div>
                    <div class="cover-logo-bar">
                        <span>IITM INDIA</span>
                        <span>${escHtml(page.important_info?.year || new Date().getFullYear())}</span>
                    </div>
                    ${FOOTER_HTML}

                `;
                return wrap;
            }

            /* ── content page ── */
            const inner = document.createElement('div');
            inner.className = 'page-inner';

            /* header */
            inner.innerHTML = `

                <div class="page-header">

                    
                    <h2 class="page-title">${escHtml(page.title || '')}</h2>
                                                                        ${HEADER_HTML}

                </div>
                                    <p class="page-category">${escHtml(page.category || '')}</p>

            `;

            /* key benefits */
            if (page.important_info?.benefits?.length) {
                const card = document.createElement('div');
                card.className = 'card';
                card.innerHTML = `
                    <h3>Key Benefits</h3>
                    <ul>${page.important_info.benefits.map(b => `<li>${escHtml(b)}</li>`).join('')}</ul>
                `;
                inner.appendChild(card);
            }

            /* packages */
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

            /* items */
            if (page.items?.length) {
                const grid = document.createElement('div');
                grid.className = 'grid-2';
                page.items.forEach(item => {
                    const c = document.createElement('div');
                    c.className = 'item-card';
                    c.innerHTML = `
                        <div class="item-info">
                            <strong>${escHtml(item.name || '')}</strong>
                            ${item.details ? `<small>${escHtml(item.details)}</small>` : ''}
                            ${item.benefits?.length ? `<ul>${item.benefits.map(b => `<li>${escHtml(b)}</li>`).join('')}</ul>` : ''}
                        </div>
                        <div class="item-price">${escHtml(item.price || '')}</div>
                    `;
                    grid.appendChild(c);
                });
                inner.appendChild(grid);
            }

            wrap.appendChild(inner);

            /* footer */
            const footer = document.createElement('div');
            footer.className = 'page-footer';
            footer.textContent = `IITM INDIA  |  PAGE ${page.page_no || ''}`;
            wrap.appendChild(footer);

            return wrap;
        }

        /* ── XSS-safe escaping ── */
        function escHtml(str) {
            return String(str)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;');
        }

        /* ── FETCH AND RENDER ── */
        async function loadProspectus() {
            try {

                const url = "{{ url('sponsor-data') }}";

                const res = await fetch(url, {
                    headers: {
                        'Accept': 'application/json'
                    }
                });
                if (!res.ok) {
                    throw new Error(`Server returned HTTP ${res.status} (${res.statusText}). Check that the route "${url}" exists and is accessible.`);
                }

                let result;
                try {
                    result = await res.json();
                } catch {
                    throw new Error(`Response from "${url}" is not valid JSON. Make sure the endpoint returns JSON, not HTML.`);
                }

                if (!result.success) {
                    throw new Error(`API returned success: false. Message: ${result.message || 'No message provided.'}`);
                }

                if (!Array.isArray(result.data) || result.data.length === 0) {
                    throw new Error('result.data is empty or not an array. Nothing to render.');
                }

                /* ── render pages ── */
                statusBox.style.display = 'none';
                const fragment = document.createDocumentFragment();

                result.data.forEach((page, i) => {
                    try {
                        fragment.appendChild(buildPage(page));
                    } catch (pageErr) {
                        console.error(`[Prospectus] Error building page ${i}:`, pageErr, page);
                    }
                });

                pagesContainer.appendChild(fragment);

                pdfBtn.disabled = false;
                setStatus(`${result.data.length} page(s) loaded — ready to print`);

            } catch (err) {
                setError(err.message);
            }
        }

        loadProspectus();
    </script>

</body>

</html>