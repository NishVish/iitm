

    <style>

        /* Main container for image-to-text tool */
        #imageToTextContainer {
            display: flex;
            flex-direction: row;
            gap: 24px;
            align-items: flex-start;
        }

        /* Left panel: image input and preview */
        .imageInputPanel {
            flex: 1;
        }

        .imageInputPanel input[type="file"] {
            margin-bottom: 10px;
        }

        .imagePreview {
            max-width: 100%;
            height: 300px;
            margin-top: 10px;
            border: 1px solid #aaa;
            display: none;
        }

        .convertButton {
            margin-top: 12px;
            padding: 10px 20px;
            background-color: #2a7ae2;
            color: white;
            border: none;
            cursor: pointer;
        }

        .convertButton:hover {
            background-color: #195cc3;
        }

        /* Right panel: converted text display */
        .textOutputPanel {
            flex: 1;
        }

        .convertedTextArea {
            width: 100%;
            height: 400px;
            resize: vertical;
            margin-top: 10px;
            font-family: monospace;
        }
    </style>
    
<section id="imageToTextContainer" aria-label="Image to Text Converter">
<button onclick="window.location.href='imagetotext/uploadform'">Image Form</button>
<button onclick="window.location.href='images/all'">View & Edit</button>
<button onclick="window.location.href='images/alltable'">Table</button>
    <!-- Image selection + preview panel -->
     <div>


     </div>
    <div class="imageInputPanel">
          <h3><strong>Image to Text Converter</strong></h3><br>
        <input type="file" id="imageFileInput" accept="image/*"><br>

        <button id="phoneimage">Phone Uploaded</button>
<button id="qrBtn">QR</button>
        <button id="convertToTextBtn" class="convertButton">Convert to Text</button>

<!-- Popup Overlay (hidden by default) -->
<div id="qrPopup" style="display:none; 
    position:fixed; top:0; left:0; width:100%; height:100%; 
    background:rgba(0,0,0,0.6); align-items:center; justify-content:center;">
    
  <div style="position:relative; background:#fff; padding:20px; border-radius:10px; text-align:center;">
    <!-- Close Button -->
    <button id="closePopup" style="position:absolute; top:5px; right:5px; border:none; background:none; font-size:20px; cursor:pointer;">✖</button>
    
    <!-- QR Code Image -->
    <img id="qrImage" style="width:250px; height:250px;">
  </div>
</div>
        <img id="imagePreviewElement" class="imagePreview" alt="Selected Image Preview" style="display:none; max-width: 300px;"><br>

    
    </div>

    <!-- Converted text output panel -->
    <div class="textOutputPanel">
        <textarea id="convertedTextOutput" class="convertedTextArea" placeholder="Converted text will appear here..."></textarea>
    </div>
</section>


<section>
    <h2>Text To Company Data Extracter</h2>
<div>
        <!-- Text area for user to input text -->
        <textarea id="inputText" rows="10" cols="50" placeholder="Paste text here to parse..." oninput="parseText()"></textarea>

       
        <!-- Table to display parsed data in horizontal format -->
<table id="companyTable" border="1">
            <tr>
                <th>Company Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Website</th>
            </tr>
            <tr>
               <td id="textCompanyName">Not Found</td>
        <td id="textEmail">Not Found</td>
        <td id="textPhone">Not Found</td>
        <td id="textAddress">Not Found</td>
        <td id="textWebsite">Not Found</td>
            </tr>
        </table>

        <!-- Button to copy parsed values to clipboard -->
        <button onclick="copyToClipboard()">Copy to Clipboard</button>
    </div>
</section>

<script>




 function copyToClipboard() {
        // Get the table and its data
        const table = document.getElementById('companyTable');
        let tableData = '';

        // Loop through the rows and columns of the table and construct a string
        for (let row of table.rows) {
            for (let cell of row.cells) {
                tableData += cell.innerText + '\t';
            }
            tableData += '\n';  // Add a new line after each row
        }

        // Create a temporary text area to copy data to clipboard
        const textArea = document.createElement('textarea');
        textArea.value = tableData;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);


    }


























    function parseText() {
  const inputText = document.getElementById("inputText").value;

  const phoneRegex =
    /(\+?\d{1,3}[-\s]?)?\(?\d{2,4}\)?[-\s]?\d{3,5}[-\s]?\d{3,5}/g;
  const emailRegex =
    /\b[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,6}\b/gi;
  const websiteRegex =
    /\b(?:https?:\/\/)?(?:www\.)?[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}\b/g;

  let email = "Not Found";
  let phone = "Not Found";
  let website = "Not Found";
  let address = "Not Found";
  let companyName = "Not Found";

  // Match email
  const emailMatch = inputText.match(emailRegex);
  if (emailMatch && emailMatch.length > 0) {
    email = emailMatch[0].trim();
  }

  // Match phone
  const phoneMatch = inputText.match(phoneRegex);
  if (phoneMatch && phoneMatch.length > 0) {
    phone = phoneMatch[0].trim();
  }

  // Match website
  const websiteMatch = inputText.match(websiteRegex);
  if (websiteMatch && websiteMatch.length > 0) {
    website = websiteMatch[0].replace(/^https?:\/\/(www\.)?/i, "").trim();
  }

  // Infer company name from email or website
  let domain = null;
  if (email !== "Not Found") {
    domain = email.split("@")[1].split(".")[0];
  } else if (website !== "Not Found") {
    domain = website.split(".")[0];
  }

  if (domain) {
    companyName = domain.charAt(0).toUpperCase() + domain.slice(1);
  }

  // Update table with new IDs
  document.getElementById("textCompanyName").textContent = companyName;
  document.getElementById("textEmail").textContent = email;
  document.getElementById("textPhone").textContent = phone;
  document.getElementById("textAddress").textContent = address;
  document.getElementById("textWebsite").textContent = website;
}




</script>




<script>

const qrBtn = document.getElementById("qrBtn");
const qrPopup = document.getElementById("qrPopup");
const qrImage = document.getElementById("qrImage");
const closePopup = document.getElementById("closePopup");

qrBtn.addEventListener("click", function () {
const baseURL = "<?= base_url() ?>";
    const link = `${baseURL}/tools/upload`;
    // const link = "http://192.168.1.157/sphereintranet/tools/upload";
// const link = `${baseURL}/tools/upload`;

    qrImage.src = "https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=" + encodeURIComponent(link);
    qrPopup.style.display = "flex"; // show popup
});

closePopup.addEventListener("click", function () {
    qrPopup.style.display = "none"; // hide popup
});



    const imageInput = document.getElementById('imageFileInput');
    const previewImage = document.getElementById('imagePreviewElement');
    const convertButton = document.getElementById('convertToTextBtn');
    const outputText = document.getElementById('convertedTextOutput');
    const phoneBtn = document.getElementById('phoneimage');

    // Preview selected image from file input
    imageInput.addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                console.log()
                previewImage.src = e.target.result;
                previewImage.style.display = 'block';
                                console.log(previewImage.src)


            }
            reader.readAsDataURL(file);
        }
    });

    // On clicking "Phone Uploaded" button → load fixed image
phoneBtn.addEventListener('click', function () {

const filePath = "uploads/1.jpg";
    const cacheBuster = "?v=" + new Date().getTime(); // unique each click

    previewImage.src = filePath + cacheBuster;   // force reload
    previewImage.dataset.filepath = filePath;    // keep clean path for backend
    previewImage.style.display = 'block';
    console.log(previewImage.src);

    if (!previewImage.src || previewImage.src === "#") {
        alert("Please select or load an image first.");
        return;
    }

    // Use relative path if available
    let imageData = previewImage.dataset.filepath || previewImage.src;

    fetch('imagetotext', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({ imageData: imageData })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            outputText.value = data.ocr_text;
        } else {
            outputText.value = '❌ Error: ' + data.message;
            console.error(data.details || data.message);
        }
    })
    .catch(err => {
        outputText.value = '❌ Request failed.';
        console.error(err);
    });
});



    // Convert button click
    convertButton.addEventListener('click', function () {
        if (!previewImage.src || previewImage.src === "#") {
            alert("Please select or load an image first.");
            return;
        }
        convertImageToText();
                                                        console.log(previewImage.src)

    });

function convertImageToText() {
    let imageData = previewImage.src;

    // If Phone Uploaded was used, send relative path instead of full URL
    if (previewImage.dataset.filepath) {
        imageData = previewImage.dataset.filepath;
    }
        fetch('imagetotext', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                imageData: previewImage.src
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                outputText.value = data.ocr_text;
            } else {
                outputText.value = '❌ Error: ' + data.message;
                console.error(data.details || data.message);
            }
        })
        .catch(err => {
            outputText.value = '❌ Request failed.';
            console.error(err);
        });
    }
</script>



<div id="toolbox">
  



  <section id="calculator" aria-label="Basic Calculator">
    <h2>Basic Calculator</h2>
    <input type="text" id="calc-display" readonly aria-live="polite" />
    <div class="calc-buttons" role="group" aria-label="Calculator Buttons">
      <?php
      $buttons = ['7','8','9','/','4','5','6','*','1','2','3','-','0','.','=','+','C'];
      foreach ($buttons as $btn) {
          echo "<button class='calc-btn' type='button'>$btn</button>";
      }
      ?>
    </div>
  </section>

  <section id="notepad" aria-label="Temporary Notepad">
    <h2>Temporary Notepad</h2>
    <textarea id="notepad-area" placeholder="Type your notes here..." rows="6" aria-multiline="true"></textarea>
    <div style="display: flex; gap: 10px; margin-top: 10px;">
      <button type="button" onclick="saveNotepad()">Save Notes</button>
      <button type="button" onclick="clearNotepad()">Clear Notes</button>
    </div>
    <p id="notepad-msg" role="status" style="color:green; margin-top: 10px;"></p>
  </section>

  <section id="todo" aria-label="To-Do List">
    <h2>To-Do List</h2>
    <div style="display: flex; gap: 10px; margin-bottom: 10px;">
      <input type="text" id="todo-input" placeholder="Add new task" aria-label="Add new task" />
      <button type="button" onclick="addTodo()">Add</button>
    </div>
    <ul id="todo-list" aria-live="polite" aria-label="Tasks list"></ul>
    <small>Click task to remove it</small>
  </section>

  <section id="unitconverter" aria-label="Unit Converter">
    <h2>Unit Converter (Length)</h2>
    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap; margin-bottom: 10px;">
      <input type="number" id="unit-input" placeholder="Enter value" aria-label="Unit value" />
      <select id="unit-from" aria-label="Convert from unit">
        <option value="m">Meter</option>
        <option value="km">Kilometer</option>
        <option value="cm">Centimeter</option>
        <option value="inch">Inch</option>
        <option value="ft">Feet</option>
      </select>
      <span>to</span>
      <select id="unit-to" aria-label="Convert to unit">
        <option value="m">Meter</option>
        <option value="km">Kilometer</option>
        <option value="cm">Centimeter</option>
        <option value="inch">Inch</option>
        <option value="ft">Feet</option>
      </select>
    </div>
    <button type="button" onclick="convertUnits()">Convert</button>
    <p class="result" id="unit-result" aria-live="polite"></p>
  </section>

  <section id="stopwatch" aria-label="Stopwatch / Timer">
    <h2>Stopwatch / Timer</h2>
    <div id="timer-display" aria-live="polite" role="timer">00:00:00</div>
    <div style="display: flex; gap: 10px; margin-top: 10px;">
      <button type="button" onclick="startTimer()">Start</button>
      <button type="button" onclick="pauseTimer()">Pause</button>
      <button type="button" onclick="resetTimer()">Reset</button>
    </div>
  </section>

  <section id="currencyconverter" aria-label="Currency Converter">
    <h2>Currency Converter</h2>
    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap; margin-bottom: 10px;">
      <input type="number" id="currency-amount" placeholder="Amount" aria-label="Currency amount" />
      <select id="currency-from" aria-label="Convert from currency">
        <option value="USD">USD</option>
        <option value="EUR">EUR</option>
        <option value="INR">INR</option>
        <option value="GBP">GBP</option>
      </select>
      <span>to</span>
      <select id="currency-to" aria-label="Convert to currency">
        <option value="USD">USD</option>
        <option value="EUR">EUR</option>
        <option value="INR">INR</option>
        <option value="GBP">GBP</option>
      </select>
    </div>
    <button type="button" onclick="convertCurrency()">Convert</button>
    <p class="result" id="currency-result" aria-live="polite"></p>
  </section>

  <section id="textcase" aria-label="Text Case Converter">
    <h2>Text Case Converter</h2>
    <textarea id="textcase-input" placeholder="Type text here..." rows="5" style="resize:none;"></textarea>
    <div style="display: flex; gap: 10px; margin-top: 12px; flex-wrap: wrap;">
      <button type="button" onclick="convertText('upper')">UPPERCASE</button>
      <button type="button" onclick="convertText('lower')">lowercase</button>
      <button type="button" onclick="convertText('capitalize')">Capitalize</button>
    </div>
    <p class="result" id="textcase-output" aria-live="polite" style="margin-top: 10px;"></p>
  </section>

</div>

<script>
    // Calculator logic
    const calcDisplay = document.getElementById('calc-display');
    document.querySelectorAll('.calc-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const val = btn.textContent;
            if(val === 'C') {
                calcDisplay.value = '';
            } else if(val === '=') {
                try {
                    calcDisplay.value = eval(calcDisplay.value) || '';
                } catch {
                    calcDisplay.value = 'Error';
                }
            } else {
                calcDisplay.value += val;
            }
        });
    });

    // Notepad with localStorage
    function saveNotepad() {
        const content = document.getElementById('notepad-area').value;
        localStorage.setItem('notepadContent', content);
        document.getElementById('notepad-msg').textContent = "Notes saved locally!";
    }
    function clearNotepad() {
        document.getElementById('notepad-area').value = '';
        localStorage.removeItem('notepadContent');
        document.getElementById('notepad-msg').textContent = "";
    }
    window.onload = () => {
        if(localStorage.getItem('notepadContent')){
            document.getElementById('notepad-area').value = localStorage.getItem('notepadContent');
        }
    };

    // To-Do List logic
    function addTodo() {
        const input = document.getElementById('todo-input');
        const val = input.value.trim();
        if(val === '') return;
        const li = document.createElement('li');
        li.textContent = val;
        li.onclick = () => li.remove();
        document.getElementById('todo-list').appendChild(li);
        input.value = '';
    }

    // Unit Converter
    function convertUnits() {
        const val = parseFloat(document.getElementById('unit-input').value);
        const from = document.getElementById('unit-from').value;
        const to = document.getElementById('unit-to').value;
        if(isNaN(val)) {
            alert('Please enter a valid number');
            return;
        }
        const rates = {
            m: 1,
            km: 1000,
            cm: 0.01,
            inch: 0.0254,
            ft: 0.3048
        };
        let meters = val * rates[from];
        let result = meters / rates[to];
        document.getElementById('unit-result').textContent = `${val} ${from} = ${result.toFixed(4)} ${to}`;
    }

    // Stopwatch/Timer
    let timerInterval, totalSeconds = 0;
    const timerDisplay = document.getElementById('timer-display');

    function formatTime(seconds) {
        let h = Math.floor(seconds / 3600);
        let m = Math.floor((seconds % 3600) / 60);
        let s = seconds % 60;
        return `${String(h).padStart(2,'0')}:${String(m).padStart(2,'0')}:${String(s).padStart(2,'0')}`;
    }
    function startTimer() {
        if(timerInterval) return;
        timerInterval = setInterval(() => {
            totalSeconds++;
            timerDisplay.textContent = formatTime(totalSeconds);
        }, 1000);
    }
    function pauseTimer() {
        clearInterval(timerInterval);
        timerInterval = null;
    }
    function resetTimer() {
        pauseTimer();
        totalSeconds = 0;
        timerDisplay.textContent = "00:00:00";
    }

    // Currency Converter (demo fixed rates)
    function convertCurrency() {
        const amount = parseFloat(document.getElementById('currency-amount').value);
        const from = document.getElementById('currency-from').value;
        const to = document.getElementById('currency-to').value;
        if(isNaN(amount)) {
            alert('Please enter a valid amount');
            return;
        }
        const rates = {
            USD: 1,
            EUR: 0.9,
            INR: 83,
            GBP: 0.8
        };
        let usd = amount / rates[from];
        let result = usd * rates[to];
        document.getElementById('currency-result').textContent = `${amount} ${from} = ${result.toFixed(2)} ${to}`;
    }

    // Text Case Converter
    function convertText(type) {
        const text = document.getElementById('textcase-input').value;
        let result = '';
        switch(type){
            case 'upper':
                result = text.toUpperCase();
                break;
            case 'lower':
                result = text.toLowerCase();
                break;
            case 'capitalize':
                result = text.replace(/\b\w/g, c => c.toUpperCase());
                break;
        }
        document.getElementById('textcase-output').textContent = result;
    }
</script>
