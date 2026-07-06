

<?php
$host = '21.157.66.148.host.secureserver.net';
$port = 3306;
$user = 'iitminda_nish';
$password = 'iitmindia@2025';

// Connect once to the server (no default DB)
$conn = mysqli_connect($host, $user, $password, '', $port);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$hello = False;
$search_result = null;
$auto_print = false;

$name = "Nishant Vishwakarma";
$c = "Sphere Travel Media Pvt. Ltd.";



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

echo "
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        var tempDiv = document.getElementById('temp');
        if (tempDiv) {
          tempDiv.style.display = 'none';
          setTimeout(() => {
            tempDiv.remove();
          }, 1000);
        }
      });
    </script>
    ";
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);


    // Query for first DB (iitminda_form_data) - union exhibitor and tradevisitor ordered by created_at
    $query1 = "
    (SELECT 
        id,
        person_key,
        name,
        designation,
        company_name,
        NULL AS category,  -- not present in exhibitor
        address,
        city,
        pin,
        state,
        mobile,
        email,
        created_at,
        'iitminda_form_data' AS db_name,
        'exhibitor' AS table_name
     FROM iitminda_form_data.exhibitor 
     WHERE mobile LIKE '%$mobile%')
     
    UNION ALL

    (SELECT 
        id,
        person_key,
        name,
        designation,
        company_name,
        category,
        address,
        city,
        pin,
        state,
        mobile,
        email,
        created_at,
        'iitminda_form_data' AS db_name,
        'tradevisitor' AS table_name
     FROM iitminda_form_data.tradevisitor 
     WHERE mobile LIKE '%$mobile%')

    ORDER BY created_at DESC
    LIMIT 1
";

    $result1 = mysqli_query($conn, $query1);
    $row1 = ($result1 && mysqli_num_rows($result1) > 0) ? mysqli_fetch_assoc($result1) : null;

    // Query for second DB (iitminda_iitmindia_2024) - union exhibitor2025 and tradev ordered by date_reg
$query2 = "
    (SELECT id, title, select2, name, designation, organisation AS company_name, email, phone, mobile, date_reg AS created_at, 
     'iitminda_iitmindia_2024' AS db_name, 'exhibitor2025' AS table_name 
     FROM iitminda_iitmindia_2024.exhibitor2025 
     WHERE phone LIKE '%$mobile%' OR mobile LIKE '%$mobile%')
    UNION ALL
    (SELECT id, title, select2, name, designation, organisation AS company_name, email, phone, mobile, date_reg AS created_at, 
     'iitminda_iitmindia_2024' AS db_name, 'tradev' AS table_name 
     FROM iitminda_iitmindia_2024.tradev 
     WHERE phone LIKE '%$mobile%' OR mobile LIKE '%$mobile%')
    ORDER BY created_at DESC
    LIMIT 1
";

    $result2 = mysqli_query($conn, $query2);
    $row2 = ($result2 && mysqli_num_rows($result2) > 0) ? mysqli_fetch_assoc($result2) : null;

    // Compare the results from both DBs and pick the latest
    if ($row1 && $row2) {
        $time1 = strtotime($row1['created_at']);
        $time2 = strtotime($row2['created_at']);
        $search_result = ($time1 >= $time2) ? [$row1] : [$row2];
        $auto_print = true;

    } elseif ($row1) {
        $search_result = [$row1];
        $auto_print = true;
    } elseif ($row2) {
        $search_result = [$row2];
        $auto_print = true;
    } else {
        echo "<p>No results found for mobile number: " . htmlspecialchars($mobile) . "</p>";
        $auto_print = false;
    }

    if (!empty($search_result)) {
    $final = $search_result[0];
    $final_db = mysqli_real_escape_string($conn, $final['db_name']);
    $final_table = mysqli_real_escape_string($conn, $final['table_name']);
    $final_id = (int)$final['id'];

    $insert_query = "
        INSERT INTO iitminda_visitor.visitor (database_name, table_name, id)
        VALUES ('$final_db', '$final_table', $final_id)
    ";


    if (mysqli_query($conn, $insert_query)) {
echo "<div style='margin-top: 15px; padding: 10px 15px; background-color: #e9f5ff; border-left: 4px solid #007bff; color: #333; font-family: sans-serif; border-radius: 4px;'>
        <strong>Last Searched Mobile Number:</strong> " . htmlspecialchars($mobile) . "
      </div>";
    } else {
        echo "<p>Error inserting into visitor table: " . mysqli_error($conn) . "</p>";
    }
    $hello = True;


}

}
?>



<!DOCTYPE html>
<html>
<head>
        <title>Print Manager</title>

    <style>
        html, body {
            height: 100%;
            margin: 0;

        }
        body {
            display: flex;
            justify-content: center; /* horizontal centering */
            align-items: center;    /* vertical centering */
            flex-direction: column;
            font-family: 'Times New Roman', serif;
            min-height: 100vh;
            text-align: center;

            box-sizing: border-box;
        }
        form {
            margin-bottom: 20px;
        }
        input[type="text"] {
            padding: 8px;
            font-size: 16px;
            width: 200px;
            box-sizing: border-box;
        }
        button {
            padding: 8px 12px;
            font-size: 16px;
            cursor: pointer;
        }
        #printSection {
            margin-top: 0px;
        }
        @media print {
        body * {
            visibility: hidden;
        }

        #printSection, #printSection * {
            visibility: visible;
        }

        #printSection {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            text-align: center;
        }

         /* Default image opacity */
            .image-container img {
                opacity: 0 !important;
            }

            /* Show image if override class is present */
            .image-container.opacity-enabled img {
                opacity: 1 !important;
            }
            .overlay-text {

                            color: blue !important;
                        }
             /* Adjust overlay position only if enabled */
            .image-container.opacity-enabled .overlay-text {
                color: blue !important;
            }

            
    }

.image-container {
  position: relative;
  display: inline-block;
  width: 9.2cm;
  /* height: 13.3cm;  */
  height: 13.67cm; 

  /* border: 2px solid black; */
}

.image-container img {
    width: 100%;
    height: 100%;
    display: block;

}

.overlay-text {
    position: absolute;
    color: black;
    text-align: left;
    width: calc(100% - 40px);
    line-height: 1.6;
}

#temp {
    position: absolute;
    text-align: left;

    margin-top: 155px;
    margin-left: 45px;
    line-height: 1.3;

    color: blue;
}




    </style>
</head>
<body>

    <div style="display: flex; gap: 20px; align-items: flex-start;">


  <div id="printSection" style="flex: 1; border: 1px solid #ccc; padding-top:0px;">
    <div class="image-container">
<div id="temp">
    <strong style="font-size: 24px; color: black;" contenteditable="true">
        NISHANT VISHWAKARMA
    </strong><br>

    <span style="font-size: 24px; color: black;">
        <span contenteditable="true">
            Sphere Travel Media Pvt. Ltd.
        </span><br>

        <span contenteditable="true">
7909075195        </span>
    </span>
</div>
  
    <img id="badgeImage" src="trade.jpg" alt="Background Image" class="background-image">
        <div class="overlay-text">
                      


            <?php if (!empty($search_result)): ?>

            <?php foreach ($search_result as $row): ?>
                <?php
                    
                    if (!empty($row['select2'])) {
    $name = strtoupper($row['select2']) . " " . strtoupper($row['name']);
} else {
    $name = strtoupper($row['name']);
}
                    $company_name = strtoupper($row['company_name']);
                    $designation = $row['designation'];

                    // Combine all text blocks to evaluate length
                    $max_line_length = max(strlen($name), strlen($company_name), strlen($designation));

                    // Start from a reasonable base
                    $base_font_size = 26;

                    // Adjust down based on length
                    if ($max_line_length > 32) {
                        $base_font_size = 22;
                    } elseif ($max_line_length > 26) {
                        $base_font_size = 25;
                    } elseif ($max_line_length > 20) {
                        $base_font_size = 26;
                    }

                    // Final font sizes
                if (strlen($name)<14){
                        $name_font_size = $base_font_size + 4; 

                }else{
                    $name_font_size = $base_font_size + 2;

                }
                            // Name usually needs emphasis
                    $company_font_size = $base_font_size;          // Company
                    $designation_font_size = $base_font_size - 1;  // Designation, usually smallest

                ?>
                <div>
                    <form  method="POST" action="submittv.php" id="editForm">
    <!-- Visible editable name -->
    <strong 
        id="nameEditable"
        contenteditable="true"
        style="font-size: <?= $name_font_size ?>px; color: black; text-transform: uppercase;">
        <?= htmlspecialchars($name) ?>
    </strong><br>

    <!-- Visible editable company name -->
    <span style="font-size: <?= $base_font_size ?>px; color: black; text-transform: uppercase;">
        <span 
            id="companyEditable"
            contenteditable="true">
            <?= htmlspecialchars_decode(htmlspecialchars($company_name)) ?>
        </span><br>
    </span>

    <!-- Hidden inputs to store original values for comparison -->
    <input type="hidden" id="originalName" value="<?= htmlspecialchars($name) ?>" />
    <input type="hidden" id="originalCompany" value="<?= htmlspecialchars_decode(htmlspecialchars($company_name)) ?>" />
    <input type="hidden" id="originalMobile" value="<?= htmlspecialchars($mobile) ?>" />

    <!-- Hidden inputs to carry edited data for submission -->
    <input type="hidden" name="name" id="nameInput" />
    <input type="hidden" name="company_name" id="companyInput" />
      <input type="hidden" name="full_page" id="full_page" />

    <input type="hidden" name="mobile" id="mobileInput" />
</form>

<!-- Hidden Form -->
<!-- <form method="POST" action="submittv.php" id="editForm">
  <input type="hidden" name="name" id="nameInput" />
  <input type="hidden" name="company_name" id="companyInput" />
  <input type="hidden" name="full_page" id="full_page" />
  <input type="hidden" name="mobile" id="mobileInput" />
</form> -->


                </div>
            <?php endforeach; ?>
            <?php endif; ?>

        </div>
    </div>
    
</div>
 <!-- Form Section (Right Side) -->
  <div style="width: 350px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 14px; border: 1px solid #ddd; padding: 20px; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); background-color: #f9f9f9;">

    <!-- Position Controls -->
           <h3 style="margin-bottom: 10px; margin-top:5px;font-size: 16px; color: #333;">Position Settings</h3>

    <div style="margin-bottom: 10px; margin-left:45px;">
      <div style="display: flex; gap: 20px;">
        <!-- <div>
          <label for="topInput">Top</label><br>
          <input type="number" id="topInput" style="width: 60px; padding: 5px; border: 1px solid #ccc; border-radius: 4px;">
        </div>
        <div>
          <label for="leftInput">Left</label><br>
          <input type="number" id="leftInput" style="width: 60px; padding: 5px; border: 1px solid #ccc; border-radius: 4px;">
        </div> -->


        <div style="display: flex; flex-direction: column; align-items: center; gap: 10px; font-family: sans-serif;">

  <!-- Up Button -->
  <button onclick="adjustPosition('up')" style="padding: 10px 20px; font-size: 16px; background-color: #007bff; color: white; border: none; border-radius: 6px; cursor: pointer;">
    ↑
  </button>

  <!-- Input Controls and Left/Right Buttons -->
  <div style="display: flex; align-items: center; gap: 20px;">

    <!-- Left Button -->
    <button onclick="adjustPosition('left')" style="padding: 10px 20px; font-size: 16px; background-color: #007bff; color: white; border: none; border-radius: 6px; cursor: pointer;">
      ← 
    </button>

    <!-- Inputs -->
    <div style="display: flex; flex-direction: column; gap: 10px;">
      <div>
        <input type="number" id="topInput" style="width: 80px; padding: 6px; border: 1px solid #ccc; border-radius: 4px;">
      </div>
      <div>
        <input type="number" id="leftInput" style="width: 80px; padding: 6px; border: 1px solid #ccc; border-radius: 4px;">
      </div>
    </div>

    <!-- Right Button -->
    <button onclick="adjustPosition('right')" style="padding: 10px 20px; font-size: 16px; background-color: #007bff; color: white; border: none; border-radius: 6px; cursor: pointer;">
      →
    </button>
  </div>

  <!-- Down Button -->
  <button onclick="adjustPosition('down')" style="padding: 10px 20px; font-size: 16px; background-color: #007bff; color: white; border: none; border-radius: 6px; cursor: pointer;">
    ↓
  </button>
  <button onclick="reset_position()" style="padding: 8px 12px; background-color:rgb(100, 143, 223); color: #fff; border: none; border-radius: 4px; cursor: pointer;">
      ↻
     </button>

</div>

      </div>
    </div>

    <!-- Mobile Search Form -->
    <div style="margin-bottom: 20px;">
      <h3 style="margin-bottom: 10px; font-size: 16px; color: #333;">Search by Mobile</h3>
      <form method="POST" action="" style="display: flex; gap: 10px; flex-wrap: wrap;">
        <input type="text" name="mobile" placeholder="Enter mobile number" required style="flex: 1; min-width: 150px; padding: 6px 10px; border: 1px solid #ccc; border-radius: 4px;">
        <button type="submit" style="padding: 6px 12px; background-color: #007bff; color: #fff; border: none; border-radius: 4px; cursor: pointer;">Search</button>
      </form>
    </div>

 <div style="display: flex; gap: 40px; margin-bottom: 20px;">

  <!-- Opacity Options -->
  <div>
    <h3 style="margin-bottom: 10px; font-size: 16px; color: #333;">Image Visibility</h3>
    <label style="display: block; margin-bottom: 5px;">
      <input type="radio" name="opacityToggle" id="enableOpacity" onchange="toggleOpacity(true)">
      Show Image in Print
    </label>
    <label style="display: block;">
      <input type="radio" name="opacityToggle" id="disableOpacity" onchange="toggleOpacity(false)" checked>
      Hide Image in Print
    </label>
  </div>

  <!-- Badge Type -->
  <div>
    <h3 style="margin-bottom: 10px; font-size: 16px; color: #333;">Badge Type</h3>
    <label style="display: block; margin-bottom: 5px;">
      <input type="radio" name="badgeType" value="tradevisitor" checked onchange="updateImage()">
      Trade Visitor
    </label>
    <label style="display: block;">
      <input type="radio" name="badgeType" value="exhibitor" onchange="updateImage()">
      Exhibitor
    </label>
  </div>

</div>

    <!-- Print Button -->
    <div style="display: flex; gap: 10px; width: 100%; margin-top: 20px;">

  <!-- Print Button (Fixed width 70px) -->
  <button type="button" onclick="compareAndSubmitEdit()" 
          style="width: 200px; padding: 8px; background-color: #28a745; color: #fff; border: none; border-radius: 4px; cursor: pointer;">
    Print
  </button>

  <!-- Refresh/Back Button (fills remaining space) -->
  <button onclick="window.location.href='https://iitmindia.com/reg/spot/search_form5.php'" 
          style="flex: 1; padding: 8px; background-color: #007bff; color: #fff; border: none; border-radius: 4px; cursor: pointer;">
    Refresh
  </button>

</div>


  </div>
<div>  
<div id="visitorDisplayBox" style="
  max-width: 400px;
  padding: 5px;
  background: linear-gradient(135deg, #6b7280, #374151);
  color: #f3f4f6;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  font-size: 1.1rem;
  border-radius: 12px;
  box-shadow: 0 8px 20px rgba(0,0,0,0.3);
  text-align: center;
  ">
  Loading visitor data...
</div>
</div>

</div>

</div>


    <?php if ($auto_print): ?>
        <script>

function loadVisitorData() {
  fetch('live_visitor.php')
    .then(response => response.text())
    .then(data => {
      document.getElementById('visitorDisplayBox').innerHTML = data;
    })
    .catch(error => {
      document.getElementById('visitorDisplayBox').innerText = "Error loading visitor data.";
      console.error("Fetch error:", error);
    });
}

// // Load immediately and then every 5 seconds
loadVisitorData();
// setInterval(loadVisitorData, 15000);

function replace_data(){


  
}



function compareAndSubmitEdit() {
  const currentName = document.getElementById('nameEditable').innerText.trim().toUpperCase();
  const originalName = document.getElementById('originalName').value.trim().toUpperCase();
  const originalMobile = document.getElementById('originalMobile').value.trim().toUpperCase();
  const currentCompany = document.getElementById('companyEditable').innerText.trim().toUpperCase();
  const originalCompany = document.getElementById('originalCompany').value.trim().toUpperCase();


  if (currentName == originalName && currentCompany == originalCompany) {

window.print();

      }    if (currentName !== originalName && currentCompany === originalCompany) {
    console.log("Name is Changed");
    document.getElementById('nameInput').value = currentName;
    document.getElementById('companyInput').value = originalCompany;
    document.getElementById('mobileInput').value = originalMobile;
    document.getElementById('full_page').value = 'no';
    document.getElementById('editForm').submit();
  }

  if (currentCompany !== originalCompany) {
    console.log("Name and Company Both Changed Number is Required");
    let mobile = prompt("Please enter your mobile number:");
    if (mobile === null || mobile.trim() === "") {
      alert("Mobile number is required to submit changes.");
      return;
    }
    document.getElementById('nameInput').value = currentName;
    document.getElementById('companyInput').value = currentCompany;
    document.getElementById('mobileInput').value = mobile.trim();
    document.getElementById('full_page').value = 'no';
    document.getElementById('editForm').submit();
  }
}

            function updateImage() {
            const selected = document.querySelector('input[name="badgeType"]:checked').value;
            const img = document.getElementById('badgeImage');

            if (selected === 'exhibitor') {
                img.src = 'exhibitor.jpg';
                img.alt = 'Exhibitor Badge';
            } else {
                img.src = 'trade.jpg';
                img.alt = 'Trade Visitor Badge';
            }
        }

           const overlayText = document.querySelector('.overlay-text');
let originalTop = null;

window.addEventListener('beforeprint', function () {
    const isChecked = document.getElementById('enableOpacity').checked;
    console.log("Is opacity enabled?", isChecked); // true if selected, false if not

    if (overlayText) {
        // Save the original top value
        originalTop = parseInt(getComputedStyle(overlayText).top, 10);

        // If unchecked, move it up by 25px; otherwise leave it as is
        const offset = isChecked ? 0 : 25;
        overlayText.style.top = `${originalTop - offset}px`;
    }

});

window.addEventListener('afterprint', function () {
    if (overlayText && originalTop !== null) {
        overlayText.style.top = `${originalTop}px`;
    }
});


window.addEventListener('load', function () {
    restorePosition();
    <?php if ($auto_print): ?> window.print(); <?php endif; ?>
});


    function toggleOpacity(enable) {
        const container = document.querySelector('.image-container');
        if (enable) {
            container.classList.add('opacity-enabled');
        } else {
            container.classList.remove('opacity-enabled');
        }
    }

     function restorePosition() {
    const top = localStorage.getItem('overlayTop') || '155';
    const left = localStorage.getItem('overlayLeft') || '45';

    document.getElementById('topInput').value = top;
    document.getElementById('leftInput').value = left;

    applyPosition(top, left);
  }

function reset_position() {
    document.getElementById('topInput').value = 155;
    document.getElementById('leftInput').value = 45;

    applyPosition(155, 45); // Make sure it updates the overlay visually
    localStorage.setItem('overlayTop', 155);
    localStorage.setItem('overlayLeft', 45);
}


  function applyPosition(top, left) {
    const overlay = document.querySelector('.overlay-text');
    overlay.style.top = top + 'px';
    overlay.style.left = left + 'px';
  }

  function adjustPosition(direction) {
    let top = parseInt(document.getElementById('topInput').value, 10);
    let left = parseInt(document.getElementById('leftInput').value, 10);
    const step = 5; // pixels to move per click

    switch (direction) {
      case 'up':
        top -= step;
        break;
      case 'down':
        top += step;
        break;
      case 'left':
        left -= step;
        break;
      case 'right':
        left += step;
        break;
    }

    document.getElementById('topInput').value = top;
    document.getElementById('leftInput').value = left;

    applyPosition(top, left);

    localStorage.setItem('overlayTop', top);
    localStorage.setItem('overlayLeft', left);
  }

    // Auto-save when user changes input
    document.addEventListener('DOMContentLoaded', () => {
        const topInput = document.getElementById('topInput');
        const leftInput = document.getElementById('leftInput');

        topInput.addEventListener('input', () => {
            localStorage.setItem('overlayTop', topInput.value);
            applyPosition(topInput.value, leftInput.value);
        });

        leftInput.addEventListener('input', () => {
            localStorage.setItem('overlayLeft', leftInput.value);
            applyPosition(topInput.value, leftInput.value);
        });
    });
</script>

    <?php endif; ?>
</body>
</html>
