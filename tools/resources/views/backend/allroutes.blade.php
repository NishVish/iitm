<style>
    #routes {
        display: flex;
        flex-direction: column;
        gap: 20px;
        font-family: Arial;
    }

    .route-group {
        background: #f8f9fa;
        border: 1px solid #e5e5e5;
        border-radius: 12px;
        padding: 12px;
    }

    .group-title {
        font-size: 14px;
        font-weight: 700;
        text-transform: uppercase;
        background: #0076bd;
        color: #fff;
        padding: 6px 10px;
        border-radius: 8px;
        margin-bottom: 10px;
        display: inline-block;
    }

    .route-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 10px;
    }

    .route-card {
        display: block;
        padding: 10px;
        background: #fff;
        border-radius: 10px;
        border: 1px solid #eee;
        text-decoration: none;
        transition: 0.2s;
        color: #333;
    }

    .route-card:hover {
        transform: translateY(-2px);
        border-color: #0076bd;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    }

    .route-card b {
        font-size: 13px;
        display: block;
        margin-bottom: 4px;
    }

    .route-card small {
        font-size: 11px;
        color: #777;
    }
</style>

<div id="routes"></div>

<script>
    fetch('{{ url('categorized-routes') }}')
        .then(res => res.json())
        .then(data => {

            let html = '';

            Object.keys(data).forEach(group => {

                html += `
            <div class="route-group">
                <div class="group-title">${group}</div>
                <div class="route-grid">
            `;

                data[group].forEach(r => {
                    html += `
                    <a class="route-card" href="${r.url}">
                        <b>${r.name}</b>
                        <small>${r.uri}</small>
                    </a>
                `;
                });

                html += `
                </div>
            </div>
            `;
            });

            document.getElementById('routes').innerHTML = html;
        });
</script>