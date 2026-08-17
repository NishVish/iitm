<div class="download-section">

    <style>
        .download-section {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
            font-family: Arial, sans-serif;
        }

        .section-title {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 24px;
            color: #A92324;
        }

        #download-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 18px;
        }

        .download-item {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 14px;
            gap: 10px;
            border-radius: 12px;
            background: #fff;
            border: 1px solid #eee;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            transition: 0.25s ease;
        }

        .download-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.10);
        }

        .download-top {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 10px;
            margin-bottom: 12px;
        }

        .download-icon {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid #eee;
        }

        .download-name {
            font-size: 14px;
            font-weight: 600;
            color: #333;
            line-height: 1.3;
            min-height: 40px;
        }

        .pdf-tag {
            font-size: 10px;
            background: #A92324;
            color: #fff;
            padding: 2px 6px;
            border-radius: 4px;
            display: inline-block;
            margin-top: 4px;
        }

        .download-btn {
            display: block;
            padding: 10px 16px;
            border: 2px solid #A92324;
            border-radius: 8px;
            color: #A92324;
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
            text-align: center;
            transition: 0.3s;
            white-space: nowrap;
        }

        .download-btn:hover {
            background: #A92324;
            color: #fff;
        }
    </style>

    <div class="section-title">Booking & Brochures</div>

    <div id="download-list"></div>

</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {

        const container = document.getElementById("download-list");
        const baseUrl = "{{ url('/public') }}";

        fetch("{{ url('resourceinventory') }}")
            .then(res => res.json())
            .then(data => {

                if (!data.length) {
                    container.innerHTML = "<p>No resources found.</p>";
                    return;
                }

                container.innerHTML = data.map(item => {

                    const link = item.link.toLowerCase();
                    const isPdf = link.includes('.pdf');

                    const finalUrl = item.link.startsWith('http')
                        ? item.link
                        : baseUrl + item.link;

                    return `
                    <div class="download-item">

                        <div class="download-top">
                            <img class="download-icon"
                                 src="${baseUrl + item.image}"
                                 onerror="this.src='https://via.placeholder.com/300x180'">

                            <div class="download-name">
                                ${item.title}
                                ${isPdf ? '<span class="pdf-tag">PDF</span>' : ''}
                            </div>
                        </div>

                        <a href="${finalUrl}"
                           target="_blank"
                           class="download-btn">
                            ${isPdf ? 'Download' : 'Open'}
                        </a>

                    </div>
                `;
                }).join('');

            })
            .catch(err => {
                console.error(err);
                container.innerHTML = "<p>Error loading data.</p>";
            });

    });
</script>