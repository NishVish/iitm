<?php

namespace App\Models;

use CodeIgniter\Model;

class ImageDataModel extends Model
{
    protected $table = 'card_data';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'image_path', 'ocr_text', 'company_name', 'email', 'phone', 'address', 'website'
    ];
}
