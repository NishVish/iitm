<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
    }

    .delegate {
        border: 1px solid #ccc;
        padding: 15px;
        margin-bottom: 10px;
        border-radius: 5px;
    }

    input,
    select {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        box-sizing: border-box;
    }

    button {
        margin-top: 10px;
        padding: 10px 15px;
    }
</style>
@php
    $segments = request()->segments();

    $lastSegment = end($segments);
    $secondLastSegment = $segments[count($segments) - 2] ?? null;
    $thirdLastSegment = $segments[count($segments) - 3] ?? null;

    $for = (
        $lastSegment === 'exhibitor' ||
        $secondLastSegment === 'exhibitor' ||
        $thirdLastSegment === 'exhibitor'
    ) ? 'exhibitor' : 'trade';
@endphp

<form action="{{ url('register/spot/' . $for) }}" method="post">
    @csrf

    <input type="text" name="registertype" value="{{ $for }}" readonly>

    <input type="text" id="company_name" name="company_name" placeholder="Company Name">

    @if ($for == 'exhibitor')
        <div>
            <label>
                <input type="checkbox" id="same_as_company">
                Same as Company Name
            </label>
        </div>

        <input type="text" id="certificate_name" name="certificate_name" placeholder="Certificate to be printed">

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const companyName = document.getElementById('company_name');
                const certificateName = document.getElementById('certificate_name');
                const checkbox = document.getElementById('same_as_company');

                if (checkbox && companyName && certificateName) {
                    checkbox.addEventListener('change', function () {
                        if (this.checked) {
                            certificateName.value = companyName.value;
                            certificateName.readOnly = true;
                        } else {
                            certificateName.readOnly = false;
                        }
                    });

                    companyName.addEventListener('input', function () {
                        if (checkbox.checked) {
                            certificateName.value = companyName.value;
                        }
                    });
                }
            });
        </script>
        <input type="text" name="clientof" placeholder="Client Of" value="{{ $lastSegment }}" readonly>
        <input type="text" name="location" placeholder="Location" value="{{ $secondLastSegment }}" readonly>
    @endif
    @include('registration.spot.address')

    <h3>Delegates</h3>

    <div id="delegatesContainer">
        <div class="delegate">
            <input type="text" name="delegates[0][name]" placeholder="Delegate Name">

            <input type="text" name="delegates[0][designation]" placeholder="Designation">

            <input type="text" name="delegates[0][mobile]" placeholder="Mobile">

            <input type="email" name="delegates[0][email]" placeholder="Email">
        </div>
    </div>

    <button type="button" id="addDelegate">+ Add Delegate</button>
    <button type="submit">Submit</button>
</form>

<script>
    let delegateIndex = 1;

    document.getElementById("addDelegate").addEventListener("click", function () {

        const div = document.createElement("div");
        div.className = "delegate";

        div.innerHTML = `
        <input type="text" name="delegates[${delegateIndex}][name]" placeholder="Delegate Name">

        <input type="text" name="delegates[${delegateIndex}][designation]" placeholder="Designation">

        <input type="text" name="delegates[${delegateIndex}][mobile]" placeholder="Mobile">

        <input type="email" name="delegates[${delegateIndex}][email]" placeholder="Email">

        <button type="button" class="removeDelegate">Remove</button>
    `;

        document.getElementById("delegatesContainer").appendChild(div);
        delegateIndex++;
    });

    document.addEventListener("click", function (e) {
        if (e.target.classList.contains("removeDelegate")) {
            e.target.parentElement.remove();
        }
    });
</script><!-- Add this button before Submit -->
<button type="button" id="fillDemo">Fill Demo Data</button>

<script>
    document.getElementById("fillDemo").addEventListener("click", function () {

        document.querySelector('input[name="company_name"]').value = "ABC Technologies Pvt Ltd";
        document.getElementById("pincode").value = "560001";
        document.getElementById("city").value = "Bengaluru";
        document.getElementById("state").value = "Karnataka";
        document.getElementById("country").value = "India";
        document.querySelector('textarea[name="address"]').value =
            "No. 123, MG Road, Bengaluru, Karnataka - 560001";

        // Remove extra delegates
        const container = document.getElementById("delegatesContainer");
        while (container.children.length > 1) {
            container.removeChild(container.lastElementChild);
        }
        delegateIndex = 1;

        // Fill first delegate
        container.querySelector('input[name="delegates[0][name]"]').value = "John Doe";
        container.querySelector('input[name="delegates[0][designation]"]').value = "Manager";
        container.querySelector('input[name="delegates[0][mobile]"]').value = "9876543210";
        container.querySelector('input[name="delegates[0][email]"]').value = "john@example.com";
    });
</script>