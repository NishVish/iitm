<?php

namespace App\Http\Controllers\Registration;

use App\Http\Controllers\Controller;

class CategoryVerification extends Controller
{
    public function verification(array $data): bool
    {
        $category = $data['company_category'] ?? null;

        switch ($category) {

            case 'Travel':
                return $this->verifyTravel($data);

            case 'Hospitality':
                return $this->verifyHospitality($data);

            case 'Related services':
                return $this->verifyRelatedServices($data);

            case 'Not related':
                return $this->verifyNotRelated($data);

            default:
                return false;
        }
    }

    private function verifyTravel(array $data): bool
    {
        return !empty($data['business_type'])
            && !empty($data['business_services'])
            && !empty($data['business_volume'])
            && !empty($data['business_description']);
    }

    private function verifyHospitality(array $data): bool
    {
        return !empty($data['business_type'])
            && !empty($data['business_services'])
            && !empty($data['business_capacity'])
            && !empty($data['business_volume'])
            && !empty($data['business_description']);
    }

    private function verifyRelatedServices(array $data): bool
    {
        return !empty($data['business_type'])
            && !empty($data['business_services'])
            && !empty($data['business_description'])
            && isset($data['related_current_business']);
    }

    private function verifyNotRelated(array $data): bool
    {
        return !empty($data['business_nature'])
            && !empty($data['business_nature_description']);
    }
}