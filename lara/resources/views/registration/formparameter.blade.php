@php

    if ($data) {

        $url = url('delegatesstore/' . $lastsegment);

        $lastsegment = basename($_SERVER['REQUEST_URI']);
        $secondlastSegment = basename(dirname($_SERVER['REQUEST_URI']));
        if ($secondlastSegment == 'delegatesInfobymobile') {
            $url = url('delegatesstore/' . $data->first()->identifierkey);
        }
    } else {
        $url = url('store/' . $secondlastSegment . '/' . $lastsegment);

    }

    // echo $url;
@endphp

<form method="POST" action="{{ $url }}" onsubmit="prepareJson()">


    @php

        if ($data) {

            $url = url('delegatesstore/' . $lastsegment);

            $hiddenfields = "<input type='hidden' name='person_key' value='" . $data->first()->person_key . "'>"
                . "<input type='hidden' name='identifierkey' value='" . $data->first()->identifierkey . "'>"
                . "<input type='hidden' name='city' value='" . $data->first()->city . "'>"
                . "<input type='hidden' name='state' value='" . $data->first()->state . "'>";

            // echo $identifierkey;
            echo $hiddenfields;
            // print_r($data->first());
        } else {
            $url = url('store/' . $secondlastSegment . '/' . $lastsegment);

        }
    @endphp

    @csrf

    @if($data)
        <input type="hidden" name="company_name" id="company_name" value="{{$data->first()->company_name}}">
    @else
        <label>Company Name</label>
        <input type="text" name="company_name" id="company_name" placeholder="Enter company name">
    @endif

    <br><br>

    <button type="button" onclick="addDelegate()"
        class="btn btn-success btn-sm px-3 py-2 rounded-pill shadow-sm d-inline-flex align-items-center gap-1">
        <span style="font-weight:600;">+</span> Add Delegate
    </button>


    <div id="delegateContainer"></div>

    <!-- Hidden field to store JSON -->
    <input type="hidden" name="delegates" id="delegates">

    <input type="hidden" name="stallno">
    <button type="submit" class="submit-btn">

        <i class="bi bi-check-circle-fill"></i>

        <span>Submit Registration</span>







        <style>
            .submit-btn {

                background: linear-gradient(135deg, #2563eb, #1d4ed8);

                color: #fff;

                border: none;

                padding: 12px 28px;

                font-size: 15px;

                font-weight: 600;

                border-radius: 999px;

                cursor: pointer;

                display: inline-flex;

                align-items: center;

                gap: 10px;

                box-shadow: 0 8px 20px rgba(37, 99, 235, 0.25);

                transition: all 0.25s ease;

                position: relative;

                overflow: hidden;

            }



            .submit-btn i {

                font-size: 16px;

            }



            .submit-btn:hover {

                transform: translateY(-2px);

                box-shadow: 0 12px 26px rgba(37, 99, 235, 0.35);

            }



            .submit-btn:active {

                transform: scale(0.96);

            }



            /* subtle shine effect */

            .submit-btn::after {

                content: "";

                position: absolute;

                top: -50%;

                left: -60%;

                width: 40px;

                height: 200%;

                background: rgba(255, 255, 255, 0.25);

                transform: rotate(25deg);

                transition: left 0.5s ease;

            }



            .submit-btn:hover::after {

                left: 120%;

            }
        </style>

    </button>
</form>

<script>
    function addDelegate() {
        let container = document.getElementById("delegateContainer");

        let div = document.createElement("div");
        div.className = "delegate-box";
        div.innerHTML = `
        <hr>

        <label>Name</label>
        <input type="text" class="delegate_name">

        <label>Mobile</label>
        <input type="text" class="mobile">

        <label>Email</label>
        <input type="email" class="email">

        <label>Designation</label>
        <input type="text" class="designation">

        <style>
        .btn-remove {
    background: linear-gradient(135deg, #ff4d4d, #e60000);
    color: #fff;
    border: none;
    padding: 6px 14px;
    font-size: 13px;
    font-weight: 600;
    border-radius: 999px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    box-shadow: 0 4px 10px rgba(230, 0, 0, 0.25);
    transition: all 0.25s ease;
}

.btn-remove:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 14px rgba(230, 0, 0, 0.35);
}

.btn-remove:active {
    transform: scale(0.96);
}

.btn-remove::before {
    content: "🗑";
    font-size: 14px;
}

</style>
<button type="button" class="btn-remove" onclick="this.closest('.delegate-item').remove()">
    Remove
</button>


`;

        container.appendChild(div);
    }

    function prepareJson() {

        let delegates = [];

        document.querySelectorAll(".delegate-box").forEach(function (item) {

            delegates.push({
                name: item.querySelector(".delegate_name").value,
                mobile: item.querySelector(".mobile").value,
                email: item.querySelector(".email").value,
                designation: item.querySelector(".designation").value
            });

        });

        document.getElementById("delegates").value = JSON.stringify(delegates);
    }

    window.onload = function () {
        addDelegate();

        const mobile = "{{ session('mobile', '') }}";

        console.log(mobile);

        if (mobile) {
            document.querySelector(".mobile").value = mobile;
        }
    };
</script>