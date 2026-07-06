
<?php

header("Location: https://iitmindia.com/form");
exit();


// <!DOCTYPE html>
// <html lang="en">

// <head>
//     <meta charset="UTF-8">
//     <title>Exhibitor Registration </title>
//     <meta name="viewport" content="width=device-width, initial-scale=1.0">
//     <style>
//         body {
//             font-family: Arial, sans-serif;
//             padding: 20px;
//             margin: 0;
//             background-color: #f9f9f9;
//         }

//         .container {
//             max-width: 500px;
//             margin: auto;
//             background-color: white;
//             padding: 25px 30px;
//             border-radius: 8px;
//             box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
//         }

//         img.logo {
//             display: block;
//             max-width: 150px;
//             margin: 0 auto 20px auto;
//         }

//         h2 {
//             text-align: center;
//             color: #333;
//         }

//         label {
//             display: block;
//             margin-top: 15px;
//             color: #555;
//         }

//         input[type="text"],
//         input[type="email"] {
//             width: 100%;
//             padding: 10px;
//             margin-top: 5px;
//             border: 1px solid #ccc;
//             border-radius: 4px;
//             box-sizing: border-box;
//         }

//         input[type="submit"] {
//             width: 100%;
//             margin-top: 20px;
//             padding: 12px;
//             background-color: #0073e6;
//             color: white;
//             border: none;
//             border-radius: 4px;
//             font-size: 16px;
//             cursor: pointer;
//         }

//         input[type="submit"]:hover {
//             background-color: #005bb5;
//         }
//     </style>
// </head>

// <body>

//     <div class="container">
//         <img src="https://iitmindia.com/wp-content/uploads/2024/03/image-1.png" alt="IITM Logo" class="logo">
//         <h2>Exhibitor Form</h2>
//         <?php

//         $lastsegment = basename($_SERVER['REQUEST_URI']);

//         if ($lastsegment != "formex.php") {
//             $url = "../submitex.php";
//         } else {
//             $url = "submitex.php";
//         }
//         ?>
//         <form method="post" action="<?php echo $url; ?>">
//             <label>Delegates:</label>

//             <button type="button" onclick="addDelegate()">+ Add Delegate</button>

//             <div id="delegateContainer"></div>
//             <!--<label>Designation:</label>-->
//             <!--<input type="text" name="designation">-->

//             <label>Company Name:</label>
//             <input type="text" name="company_name">

//             <!--<label>Address:</label>-->
//             <!--<input type="text" name="address">-->

//             <!--<label>City:</label>-->
//             <!--<input type="text" name="city">-->

//             <!--<label>PIN:</label>-->
//             <!--<input type="text" name="pin">-->

//             <!--<label>State:</label>-->
//             <!--<input type="text" name="state">-->

//             <label>Mobile:</label>
//             <input type="text" name="mobile">

//             <!--<label>Email:</label>-->
//             <input type="hidden" name="last_segment" value="<?php echo basename($_SERVER['REQUEST_URI']);

//             ?>">

//             <input type="submit" value="Submit">
//         </form>
//     </div>

//     <script>
//         function addDelegate() {
//             let container = document.getElementById("delegateContainer");

//             let input = document.createElement("input");
//             input.type = "text";
//             input.name = "delegates[]";   // 👈 THIS MAKES IT ARRAY
//             input.placeholder = "Enter delegate name";
//             input.style.display = "block";
//             input.style.marginTop = "10px";
//             input.style.padding = "8px";
//             input.style.width = "100%";

//             container.appendChild(input);
//         }
//     </script>

// </body>

// </html>

?>
