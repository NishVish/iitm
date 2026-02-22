<?php

namespace App\Models;

use CodeIgniter\Model;

class SourceModel extends Model
{
    protected $table = 'company_sources';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'company_id',
        'source_id',
        'event_date',
        'notes'
    ];

    public function addSource(array $values)
    {
        if (empty($values['company_id'])) {
            dd('company_id missing', $values);
        }

        // Sanitize source_id: ensure it's a positive integer
        $sourceId = isset($values['source_id']) && is_numeric($values['source_id'])
            ? abs((int)$values['source_id'])
            : 0;

        $result = $this->insert([
            'company_id' => trim($values['company_id']),
            'source_id'  => $sourceId,
            'event_date' => $values['event_date'],
            'notes'      => $values['notes'],
        ]);

        if ($result === false) {
            dd($this->errors());
        }

        return $result;
    }
}