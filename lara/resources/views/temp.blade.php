<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Test OTP POST</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }

        input {
            padding: 8px;
            margin: 5px 0;
            width: 250px;
        }

        button {
            padding: 8px 16px;
            margin-top: 10px;
        }

        pre {
            background: #f4f4f4;
            padding: 10px;
            border: 1px solid #ccc;
        }
    </style>
</head>

<body>

    <h2>Test Request OTP POST</h2>

    <label>Mobile Number:</label><br>
    <input type="text" id="mobile_number" placeholder="Enter mobile number"><br>

    <label>Event ID:</label><br>
    <input type="text" id="event_id" placeholder="Enter event ID"><br>

    <button id="btn-send-otp">Send OTP</button>

    <h3>Response:</h3>
    <pre id="response_area">Waiting for response...</pre>

    <script>
        document.getElementById('btn-send-otp').addEventListener('click', function () {
            const mobile = document.getElementById('mobile_number').value;
            const eventId = document.getElementById('event_id').value;

            fetch("{{ route('login.otp') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    mobile_number: mobile,
                    event_id: eventId
                })
            })
                .then(res => res.json())
                .then(data => {
                    document.getElementById('response_area').textContent = JSON.stringify(data, null, 2);
                    console.log(data);
                })
                .catch(err => {
                    document.getElementById('response_area').textContent = "Server error. Check console.";
                    console.error(err);
                });
        });
    </script>

</body>

</html>