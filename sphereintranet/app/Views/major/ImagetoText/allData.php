<?php if (!empty($images) && is_array($images)) : ?>
<style>
body {
  margin: 0;
  padding: 0;
  display: flex;
  justify-content: center;  /* horizontal center */
  background-color: #f4f4f4;
}

  /* Container for two main sections side by side */
  #main-container {
    display: flex;
    gap: 20px;
    padding: 20px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f9f9f9;
  }

  /* Left side - Image container */
  #image-container {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgb(0 0 0 / 0.1);
    padding: 15px;
    flex: 1;
    min-width: 300px;
    max-width: 500px;
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  #image-container img {
    width: 100%;
    max-width: 450px;
    height: auto;
    object-fit: contain;
    border-radius: 6px;
    margin-top: 10px;
    border: 1px solid #ddd;
  }

  
  /* OCR Text container */
  #ocr-text-container {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgb(0 0 0 / 0.1);
    max-width:350px;
    padding: 15px;
    height: auto; /* or fixed height */
    overflow-y: auto;
  }

  #ocr-text-container h3 {
    margin-bottom: 10px;
  }

  #ocr-text-container pre {
    white-space: pre-wrap;
    word-wrap: break-word;
    background: #f1f1f1;
    padding: 10px;
    border-radius: 5px;
    height: 100%;
    overflow-y: auto;
    font-family: monospace;
    font-size: 14px;
  }

  /* Form container */
  #form-container {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgb(0 0 0 / 0.1);
    padding: 15px;
    height: auto;
    overflow-y: auto;
    width:300px;
  }

  #form-container form {
    width: 100%;
    display: flex;
    flex-direction: column;
  }

  #form-container label {
    margin-top: 10px;
    font-weight: 600;
  }

  #form-container input[type="text"],
  #form-container input[type="ocr_text"],
  #form-container input[type="url"],
  #form-container textarea {
    width: 100%;
    padding: 8px 10px;
    margin-top: 5px;
    border-radius: 5px;
    border: 1px solid #ccc;
    font-size: 14px;
    resize: vertical;
    box-sizing: border-box;
  }

#form-container textarea#ocr_text {
    height: 300px;
}


  #form-container button[type="submit"] {
    margin-top: 15px;
    padding: 10px 15px;
    background-color: #007bff;
    border: none;
    color: white;
    font-weight: 600;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    align-self: flex-start;
  }

  #form-container button[type="submit"]:hover {
    background-color: #0056b3;
  }

  /* Navigation buttons */
  #nav-buttons {
    margin-top: 20px;
    text-align: center;
  }

  #nav-buttons button {
    background-color: #6c757d;
    color: white;
    border: none;
    padding: 10px 18px;
    margin: 0 10px;
    border-radius: 5px;
    cursor: pointer;
    font-weight: 600;
    transition: background-color 0.3s ease;
  }

  #nav-buttons button:hover {
    background-color: #5a6268;
  }
</style>

<div id="main-container">

  <!-- Left side: Image container -->
  <div id="image-container">
    
    <?php foreach ($images as $index => $image): ?>
      <div class="image-item" data-index="<?= $index ?>" style="display: <?= $index === 0 ? 'block' : 'none' ?>;"
           data-id="<?= esc($image['id']) ?>"
           data-company="<?= esc($image['company_name'] ?? '') ?>"
           data-email="<?= esc($image['email'] ?? '') ?>"
           data-phone="<?= esc($image['phone'] ?? '') ?>"
           data-address="<?= esc($image['address'] ?? '') ?>"
           data-website="<?= esc($image['website'] ?? '') ?>"
           data-ocr_text="<?= esc($image['ocr_text'] ?? '') ?>"
      >
        <strong>ID:</strong> <?= esc($image['id'] ?? 'N/A') ?><br>
        <strong>Filename:</strong> <?= esc($image['filename'] ?? 'N/A') ?><br>
        <?php if (!empty($image['image_path'])): ?>
          <img src="<?= base_url('/' . esc($image['image_path'])) ?>" alt="<?= esc($image['filename'] ?? 'Uploaded Image') ?>">
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  </div>


    <!-- OCR Text display -->
    <div id="ocr-text-container">
        <div id="nav-buttons">
        <button id="prev-btn" onclick="showPrevious()" type="button">Previous</button>
        <button id="next-btn" onclick="showNext()" type="button">Next</button>
      </div>
      <h3>Extracted OCR Text</h3>
      <pre id="ocr-text-display">Loading...</pre>
    </div>

    <!-- Form -->
    <div id="form-container">
      <form id="fetch-data" method="post" action="">
  <input type="text" id="forWebScraping" name="webid" required>
   <input type="hidden" id="image-id2"  name="id2">
  <?= csrf_field() ?>
  <button id="RunScrapping" type="button">Next</button>
</form>

      <form id="edit-form" method="post" action="">
        <?= csrf_field() ?>
                <button type="submit">Update</button>

        <input type="hidden" name="id" id="image-id">

        <label for="company_name">Company Name:</label>
        <input type="text" name="company_name" id="company_name" required>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email">

        <label for="phone">Phone:</label>
        <input type="text" name="phone" id="phone">

        <label for="address">Address:</label>
        <textarea name="address" id="address" rows="3"></textarea>

        <label for="website">Website:</label>
<input type="text" name="website" id="website" placeholder="https://example.com">
<a id="websitehref" href="#" target="_blank" style="text-decoration: none; margin-left: 8px;">
    🌐
</a>

        <label for="ocr_text">OCR Text:</label>
        <textarea name="ocr_text" id="ocr_text" rows="5"></textarea>
                <button type="submit">Update</button> 
                <div id="nav-buttons">
        <button id="prev-btn" onclick="showPrevious()" type="button">Previous</button>
        <button id="next-btn" onclick="showNext()" type="button">Next</button>
      </div>

      </form>



      
    </div>

</div>




<script>
    const input = document.getElementById('website');
    const link = document.getElementById('web-link');

    // Update the link every time the input changes
    input.addEventListener('input', function () {
        let url = input.value.trim();
        
        // Basic validation: if it doesn't start with http, add it
        if (url && !url.startsWith('http://') && !url.startsWith('https://')) {
            url = 'https://' + url;
        }

        link.href = url;
    });
</script>

<script>
document.getElementById('RunScrapping').addEventListener('click', async function () {
  const webInput = document.getElementById('forWebScraping');
  const webid = webInput.value.trim();

  if (!webid) {
    alert('Please enter a value');
    return;
  }

  const form = document.getElementById('fetch-data');
  const formData = new FormData(form);

  // Disable button to prevent double clicks
  const button = document.getElementById('RunScrapping');
  button.disabled = true;
  button.textContent = "Processing...";

  // Optional: show a loader/spinner here

  try {
const baseUrl = "<?= base_url() ?>";

const response = await fetch(baseUrl + 'websearch', {
      method: 'POST',
      body: formData,
      credentials: 'same-origin'
    });

    const data = await response.json();

    if (data.success && data.highlight_id) {
      window.location.href = `http://192.168.1.157/sphereintranet/images/all?highlight_id=${data.highlight_id}`;
    } else {
      alert('Error: ' + (data.message || 'Unknown error from server.'));
    }

  } catch (error) {
    console.error(error);
    alert('An error occurred while connecting to the server.');
  } finally {
    button.disabled = false;
    button.textContent = "Next";
    // Optional: hide loader/spinner
  }
});
</script>





<script>
  let currentIndex = 0;
  const images = document.querySelectorAll('.image-item');

  const highlightId = <?= json_encode($highlightId ?? null) ?>;

  // Form elements
  const form = document.getElementById('edit-form');
    const idField2 = document.getElementById('image-id2');

  const idField = document.getElementById('image-id');
  const companyField = document.getElementById('company_name');
  const emailField = document.getElementById('email');
  const phoneField = document.getElementById('phone');
  const addressField = document.getElementById('address');
  const websiteField = document.getElementById('website');
    const websitehref = document.getElementById('websitehref');

  const ocrTextField = document.getElementById('ocr_text');
  const ocrTextDisplay = document.getElementById('ocr-text-display');

  function showImage(index) {
    images.forEach((img, i) => {
      img.style.display = i === index ? 'block' : 'none';
    });
    currentIndex = index;
    populateForm(images[currentIndex]);
  }

  function populateForm(imageDiv) {
    // Get the raw URL
    const rawUrl = imageDiv.dataset.website;

    // Extract domain from the end of the raw URL (everything after last '/')
    const parts = rawUrl.split('/');
    const domain = parts[parts.length - 1];

    // Create the final URL
    const finalUrl = `https://${domain}`;

    // Update the href
    websitehref.href = finalUrl;

    idField.value = imageDiv.dataset.id || '';
    idField2.value = imageDiv.dataset.id || '';
    companyField.value = imageDiv.dataset.company || '';
    emailField.value = imageDiv.dataset.email || '';
    phoneField.value = imageDiv.dataset.phone || '';
    addressField.value = imageDiv.dataset.address || '';
        forWebScraping.value = imageDiv.dataset.website || '';
//  websitehref.href  =  imageDiv.dataset.website
    websiteField.value = imageDiv.dataset.website || '';
    ocrTextField.value = imageDiv.dataset.ocr_text || '';
    ocrTextDisplay.textContent = imageDiv.dataset.ocr_text || 'No OCR text found.';

    form.action = "<?= base_url('imagetotext/updatedata') ?>/" + idField.value;
  }

  function showPrevious() {
    if (currentIndex > 0) {
      showImage(currentIndex - 1);
    }
  }

  function showNext() {
  if (currentIndex < images.length - 1) {

      showImage(currentIndex + 1); // Show next image after submission
  }
}



//   function showNext() {
//     if (currentIndex < images.length - 1) {
//       showImage(currentIndex + 1);
//     }
//   }

  // ✅ Initialize with highlighted ID if provided
  window.addEventListener('DOMContentLoaded', () => {
    let startIndex = 0;

    if (highlightId) {
      images.forEach((img, i) => {
        if (img.dataset.id === highlightId.toString()) {
          startIndex = i;
        }
      });
    }

    showImage(startIndex);
  });
</script>

<!-- 
<script>
  let currentIndex = 0;
  const images = document.querySelectorAll('.image-item');

  // Form elements
  const form = document.getElementById('edit-form');
  const idField = document.getElementById('image-id');
  const companyField = document.getElementById('company_name');
  const emailField = document.getElementById('email');
  const phoneField = document.getElementById('phone');
  const addressField = document.getElementById('address');
  const websiteField = document.getElementById('website');
  const ocrTextField = document.getElementById('ocr_text');
  const ocrTextDisplay = document.getElementById('ocr-text-display');

  function showImage(index) {
    images.forEach((img, i) => {
      img.style.display = i === index ? 'block' : 'none';
    });
    currentIndex = index;
    populateForm(images[currentIndex]);
  }

  function populateForm(imageDiv) {
    idField.value = imageDiv.dataset.id || '';
    companyField.value = imageDiv.dataset.company || '';
    emailField.value = imageDiv.dataset.email || '';
    phoneField.value = imageDiv.dataset.phone || '';
    addressField.value = imageDiv.dataset.address || '';
    websiteField.value = imageDiv.dataset.website || '';
    ocrTextField.value = imageDiv.dataset.ocr_text || '';

    // Update OCR Text display in readonly section
    ocrTextDisplay.textContent = imageDiv.dataset.ocr_text || 'No OCR text found.';

    // Update form action dynamically to post to the update route with the current image id
    form.action = "<?= base_url('imagetotext/updatedata') ?>/" + idField.value;
  }

  function showPrevious() {
    if (currentIndex > 0) {
      showImage(currentIndex - 1);
    }
  }

  function showNext() {
    if (currentIndex < images.length - 1) {
      showImage(currentIndex + 1);
    }
  }

  // Initialize form and OCR text display with first image data
  
  populateForm(images[currentIndex]);
</script> -->

<?php else : ?>
  <p>No images found.</p>
<?php endif; ?>
