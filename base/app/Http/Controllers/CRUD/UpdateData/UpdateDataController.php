<?php

namespace App\Http\Controllers\CRUD\UpdateData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\BookingDetail;
use App\Models\EventDetail;
use App\Models\CompanyDetail;
use App\Models\DelegateAttending;

class UpdateDataController extends Controller
{
    use CompanyUpdate;
    use BookingUpdate;
    use ContactUpdate;
    use StallUpdate;
    use PaymentUpdate;

}