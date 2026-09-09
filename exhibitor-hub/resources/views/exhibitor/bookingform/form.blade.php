@include("exhibitor.header2")


<div id="step1">
    <h2>Welcome Page</h2>

    @include("exhibitor.bookingform.welcome")

</div>


<div id="step2" style="display:none;">
    <h2>Instruction Page</h2>
    @include("exhibitor.bookingform.instructions")

</div>


<div id="step3" style="display:none;">
    <h2>parameters</h2>
    @include("exhibitor.bookingform.parameters")

</div>


@include("exhibitor.bookingform.parameters")

<div style="text-align:right; margin:30px;">

    <button id="nextBtn" onclick="nextStep()" style="
            padding:12px 35px;
            background:#0066cc;
            color:white;
            border:none;
            border-radius:5px;
            cursor:pointer;
            font-size:16px;
        ">
        Next →
    </button>

</div>



<script>

    let step = 1;


    function nextStep() {

        document.getElementById("step" + step).style.display = "none";


        step++;


        if (step <= 3) {

            document.getElementById("step" + step).style.display = "block";

        }


        if (step == 3) {

            document.getElementById("nextBtn").innerHTML = "Submit";

        }


        if (step > 3) {

            document.getElementById("nextBtn").style.display = "none";

        }

    }

</script>