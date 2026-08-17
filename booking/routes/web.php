<?php

use Illuminate\Support\Facades\Route;
// if (session('type') == null) {
//     Route::get('/admin', function () {
//         return redirect('/admin/login');
//     });
// }

// if (!str_contains(request()->path(), 'api')) {
//     echo '
//     <div style="text-align: center; margin-bottom: 20px;">
//         <a href="' . url('/admin') . '" style="margin-right: 15px;">Admin Home</a>
//         <a href="' . url('/exhibitor/form') . '" style="margin-right: 15px;">Customer Form</a>
//         <a href="' . url('/exhibitor/dashboard') . '">Customer Dashboard</a>
//     </div>
//       <a href="' . url('/admin/logout') . '" style="
//                 background:#dc3545;
//                 color:white;
//                 text-decoration:none;
//                 padding:8px 15px;
//                 border-radius:5px;
//                 font-weight:bold;
//             ">
//                 Logout
//             </a>
//     ';
// }
// echo session('type');


require __DIR__ . '/admin/admin.php';
require __DIR__ . '/home/home.php';
require __DIR__ . '/exhibitor/exhibitor.php';