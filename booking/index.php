<style>
  /* Add room for descenders (g, p, q, y) */
  .form-line label,
  .account-info,
  h3,
  .responsive-subtitle,
  .form-line input {
    line-height: 1.4 !important;
    /* Increase vertical space */
    padding-bottom: 3px !important;
    /* Add tiny buffer at the bottom */
  }

  /* Ensure textareas don't clip */
  textarea {
    line-height: 1.4;
    padding-bottom: 5px;
  }

  /* Force specific containers to not hide overflow during capture */
  .main,
  .container,
  .column {
    overflow: visible !important;
  }
</style>
<?php
// include('agreement.php');

include('header.php');
include('section1.php');
include('parameter.php');

?>


<!-- 
      <img src="https://drive.google.com/u/0/drive-viewer/AKGpihaerNETZWNWLFrsIoKPJDcJuuXwsyd79itGiVaTzHjKUMLsdHLa1YRuhIozmKVoPT_0FlANLbNTwLp54ELWwYCaCatKY0dFWoY=s2560"  style="width: 100%;" crossorigin="anonymous">
       <img src="https://drive.google.com/u/0/drive-viewer/AKGpihaerNETZWNWLFrsIoKPJDcJuuXwsyd79itGiVaTzHjKUMLsdHLa1YRuhIozmKVoPT_0FlANLbNTwLp54ELWwYCaCatKY0dFWoY=s2560"  style="width: 100%;" > 
 -->




<script>

  function displayImage(previewId, inputElement) {
    const file = inputElement.files[0];
    const reader = new FileReader();

    reader.onload = function (e) {
      const imageElement = document.getElementById(previewId);
      imageElement.src = e.target.result;
      imageElement.style.display = 'block';  // Show the image
      inputElement.style.display = 'none';  // Hide the upload button
    };

    if (file) {
      reader.readAsDataURL(file); // Convert the image to a base64 string and display
    }
  }


  document.getElementById('amount').addEventListener('input', function () {

    let amount = parseFloat(document.getElementById('amount').value) || 0;
    let gst = Math.ceil(amount * 0.18); // Round GST up
    let total = Math.ceil(amount + gst); // Round total up

    document.getElementById('gst-amount').value = gst;

    document.getElementById('gst').value = gst;
    document.getElementById('total').value = total;
  });
</script>


<script>
  function captureForm(event) {
    event.preventDefault(); // Stop the default button click

    const submitBtn = document.getElementById("submit-btn");
    const formElement = document.querySelector(".main");

    // 1. Provide UI Feedback


    // 2. Start the capture
    html2canvas(formElement, {
      scale: 2,
      useCORS: true,
      allowTaint: true,
      backgroundColor: "#ffffff",
      windowWidth: 1200,
      height: Math.min(formElement.scrollHeight, 1500), onclone: (clonedDoc) => {
        // Hide buttons in the captured image
        const clonedMain = clonedDoc.querySelector(".main");
        if (clonedMain.querySelector("#submit-btn")) clonedMain.querySelector("#submit-btn").style.display = "none";
        if (clonedMain.querySelector("#autofill-btn")) clonedMain.querySelector("#autofill-btn").style.display = "none";
      }
    }).then(function (canvas) {
      // 3. Convert canvas to Base64
      const imgData = canvas.toDataURL("image/jpeg", 0.8);

      // 4. Create a dynamic form to POST the data
      const virtualForm = document.createElement('form');
      virtualForm.method = 'POST';
      virtualForm.action = 'submit.php';

      // 5. Helper function to add fields to our virtual form
      const addField = (name, value) => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = name;
        input.value = value;
        virtualForm.appendChild(input);
      };

      // 6. Loop through all existing inputs in your visible form and copy them
      const originalForm = document.querySelector("form");
      const inputs = originalForm.querySelectorAll("input, textarea, select");

      inputs.forEach(input => {
        if (input.type === "checkbox") {
          if (input.checked) addField(input.name, input.value);
        } else if (input.type !== "file") { // Skip file inputs, we have the canvas
          addField(input.name, input.value);
        }
      });

      // 7. Append the big image data
      addField('form_image', imgData);

      // 8. Add to body and submit
      document.body.appendChild(virtualForm);
      virtualForm.submit();

    }).catch(function (error) {
      console.error("Capture failed:", error);
      alert("Capture failed. Please try again.");
      if (submitBtn) {
        submitBtn.disabled = false;
        submitBtn.innerText = "Submit";
      }
    });
  }
</script>
<!-- <script>function captureForm(event) {
    event.preventDefault(); // Stop the initial click from submitting immediately

    const form = document.getElementById("bookingForm");
    const submitBtn = document.getElementById("submit-btn");
    const hiddenInput = document.getElementById("hidden_form_image");
    const formElement = document.querySelector(".main");

    // UI Feedback
    if (submitBtn) {
      submitBtn.disabled = true;
      submitBtn.innerText = "Generating Image...";
    }

    html2canvas(formElement, {
      scale: 2,
      useCORS: true,
      allowTaint: true,
      backgroundColor: "#ffffff",
      windowWidth: 1200,
      height: formElement.scrollHeight,
      onclone: (clonedDoc) => {
        // Hide elements inside the captured image
        const clonedMain = clonedDoc.querySelector(".main");
        clonedMain.querySelector("#submit-btn").style.display = "none";
        if (clonedMain.querySelector("#autofill-btn")) {
          clonedMain.querySelector("#autofill-btn").style.display = "none";
        }
        clonedMain.style.width = "1100px";
        clonedMain.style.margin = "0";
      }
    }).then(function (canvas) {
      // 1. Convert canvas to Base64
      const imgData = canvas.toDataURL("image/jpeg", 0.9);

      // 2. Put the image data into the hidden input
      hiddenInput.value = imgData;

      // 3. Manually trigger the traditional form submission
      // This will send all fields + the image to submit.php and refresh the page
      form.submit();

    }).catch(function (error) {
      console.error("Capture failed:", error);
      alert("An error occurred during capture.");
      if (submitBtn) {
        submitBtn.disabled = false;
        submitBtn.innerText = "Submit";
      }
    });
  } -->

</script>
<!-- <script>


  console.log(html2canvas); // This should log the function, not 'undefined'

  function captureForm(event) {
    event.preventDefault();

    // 1. Target the main element
    const formElement = document.querySelector(".main");

    // 2. Hide buttons immediately
    const submitBtn = document.getElementById("submit-btn");
    const autofillBtn = document.getElementById("autofill-btn");
    if (submitBtn) submitBtn.style.display = "none";
    if (autofillBtn) autofillBtn.style.display = "none";

    // 3. Render the image
    html2canvas(formElement, {
      scale: 2,               // 📌 Increases resolution for clear text
      useCORS: true,          // 📌 Required for images/logos
      allowTaint: true,
      backgroundColor: "#ffffff",
      windowWidth: 1200,      // 📌 Forces desktop width so nothing stacks
      height: formElement.scrollHeight, // 📌 IMPORTANT: Captures the FULL height
      onclone: (clonedDoc) => {
        // Ensure the cloned version is visible for the renderer
        const clonedMain = clonedDoc.querySelector(".main");
        clonedMain.style.transform = "none";
        clonedMain.style.width = "1100px";
        clonedMain.style.margin = "0";
      }
    }).then(function (canvas) {
      const imgData = canvas.toDataURL("image/jpeg", 0.9);

      const link = document.createElement('a');
      link.download = 'iitm-booking-form.jpg';
      link.href = imgData;
      link.click();

      // 4. Restore buttons after download
      if (submitBtn) submitBtn.style.display = "inline-block";
      if (autofillBtn) autofillBtn.style.display = "inline-block";
    }).catch(function (error) {
      console.error("Capture failed:", error);
      if (submitBtn) submitBtn.style.display = "inline-block";
      if (autofillBtn) autofillBtn.style.display = "inline-block";
    });
  }


</script> -->


<script>

  function fillSampleData() {
    // 1. Calculations Section
    const area = 18;
    const ratePerSqMt = 34000;
    const amount = area * ratePerSqMt;
    const gst = Math.ceil(amount * 0.18);
    const total = amount + gst;

    document.getElementById('area').value = area;
    document.getElementById('amount').value = amount;
    document.getElementById('gst-amount').value = gst;
    document.getElementById('total').value = total;
    document.getElementById('a-rs').value = total;
    document.getElementById('b-rs').value = 0;
    document.getElementById('grand-total').value = total;

    // 2. Payment Particulars
    document.getElementById('cheque-no').value = "CHQ123456";
    document.getElementById('cheque-date').value = new Date().toISOString().split('T')[0]; // Today's date
    document.getElementById('payment-amount').value = total;
    document.getElementById('drawn-on').value = "State Bank of India";

    // 3. Organisation Details
    document.getElementById('org-name').value = "Global Travel Solutions Pvt Ltd";
    document.getElementById('contact-person').value = "John Doe (Director)";
    document.getElementById('address').value = "123, Skyline Business Park, MG Road, Bangalore - 560001";
    document.getElementById('telephone').value = "080-12345678";
    document.getElementById('fax').value = "080-87654321";
    document.getElementById('email').value = "john.doe@globaltravel.com";
    document.getElementById('gst').value = "29AAAAA0000A1Z5";
    document.getElementById('website').value = "www.globaltravel.com";
    document.getElementById('product-category').value = "Destination Management";
    document.getElementById('fascia').value = "GLOBAL TRAVEL SOLUTIONS";

    // alert("Form has been autofilled with sample data!");
  }
</script>

<style>
  .responsive-subtitle {
    text-align: center;
    color: var(--primary);
    font-size: clamp(1rem, 4vw, 2rem);
    padding: 0;
    /* Change padding-top to margin-top */
    margin-top: 50px;
  }
</style>
</body>

</html>