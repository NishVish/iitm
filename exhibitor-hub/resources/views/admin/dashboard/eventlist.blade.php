<div id="eventButtons"></div>

<script>
    fetch('{{ url('/api/event/list') }}')
        .then(response => response.json())
        .then(events => {

            let html = '';

            events.forEach(event => {
                const name = event.city;

                html += `
                <button class="event-btn" onclick="viewEvent(${event.event_id})">
                    ${name}
                </button>
            `;
            });

            document.getElementById('eventButtons').innerHTML = html;
        });

    function viewEvent(eventId) {
        alert('Selected Event ID: ' + eventId);
        // Or redirect:
        // window.location.href = '/event/' + eventId;
    }
</script>

<style>
    #eventButtons {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin: 20px 0;
    }

    .event-btn {
        padding: 10px 20px;
        background: #0d6efd;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: 0.2s;
    }

    .event-btn:hover {
        background: #0b5ed7;
    }
</style>