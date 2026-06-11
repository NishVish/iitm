<div id="output"></div>
dsdsd
<script>
    fetch('{{ url('documentlist') }}')
        .then(res => res.json())
        .then(data => {
            const container = document.getElementById('output');

            let html = '';

            Object.keys(data).forEach(key => {
                const item = data[key];

                html += `
        <div style="margin-bottom:20px;">
          <h3>${item.title}</h3>
          <p>${item.description}</p>
          <ul>
            ${item.methods.map(m => `<li>${m}</li>`).join('')}
          </ul>
        </div>
      `;
            });

            container.innerHTML = html;
        })
        .catch(err => {
            console.error(err);
        });
</script>