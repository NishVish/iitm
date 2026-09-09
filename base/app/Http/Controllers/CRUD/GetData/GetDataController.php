<?php

namespace App\Http\Controllers\CRUD\GetData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\BookingDetail;
use App\Models\EventDetail;
use App\Models\CompanyDetail;
use App\Models\DelegateAttending;
use Illuminate\Support\Facades\DB;



class GetDataController extends Controller
{
    use CompanyData;
    use BookingData;
    use ContactData;
    use StallData;
    use PaymentData;









}


