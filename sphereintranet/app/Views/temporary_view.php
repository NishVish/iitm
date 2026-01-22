<?php if (!empty($images) && is_array($images)) : ?>

<style>
  /* Container for the 3 side-by-side sections */
  #main-container {
    display: flex;
    gap: 20px;
    padding: 20px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f9f9f9;
  }

  /* Section styles */
  #image-container, #ocr-text-container, #form-container {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgb(0 0 0 / 0.1);
    padding: 15px;
    flex: 1;
    min-width: 300px;
    max-width: 350px;
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  /* Fixed size for images */
  #image-container img {
    width: 300px;
    height: 300px;
    object-fit: contain;
    border-radius: 6px;
    margin-top: 10px;
    border: 1px solid #ddd;
  }

  /* Text container for OCR text */
  #ocr-text-container {
    overflow-y: auto;
    height: 350px;
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

  /* Form styling */
  #form-container form {
    width: 100%;
  }

  #form-container label {
    display: block;
    margin-top: 10px;
    font-weight: 600;
  }

  #form-container input[type="text"],
  #form-container input[type="email"],
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

  <!-- 1) Image Section -->
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

  <!-- 2) OCR Text Section -->
  <div id="ocr-text-container">
    <h3>Extracted OCR Text</h3>
    <pre id="ocr-text-display">Loading...</pre>
  </div>

  <!-- 3) Form Section -->
  <div id="form-container">
    <form id="edit-form" method="post" action="">
      <?= csrf_field() ?>
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
      <input type="url" name="website" id="website">

      <label for="ocr_text">OCR Text:</label>
      <textarea name="ocr_text" id="ocr_text" rows="5"></textarea>

      <button type="submit">Update</button>
    </form>

    <div id="nav-buttons">
      <button id="prev-btn" onclick="showPrevious()" type="button">Previous</button>
      <button id="next-btn" onclick="showNext()" type="button">Next</button>
    </div>
  </div>

</div>

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
</script>

<?php else : ?>
  <p>No images found.</p>
<?php endif; ?>
