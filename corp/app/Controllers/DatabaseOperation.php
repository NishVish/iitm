<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Config\Database;

class DatabaseOperation extends Controller
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    // autmatical Detect if Hotel or TA 
    // atumatcailly set inactive if comments are inactive
// 


    /**
     * Clear ONLY matching / validation tables
     * (safe to run often)
     */
    public function clearMatchingTables()
    {
        $tables = [
            'matching_session',
            'matching_contact_session'
        ];

        foreach ($tables as $table) {
            $this->db->table($table)->truncate();
        }

return redirect()->to(site_url('company'));
    }

    /**
     * Clear contact-related tables
     * ⚠️ Be careful
     */
public function clearContactTables()
{
    // Start a transaction
    $this->db->transStart();

    // Disable foreign key checks
    $this->db->query('SET FOREIGN_KEY_CHECKS = 0');

    // 1. Tables that reference contact
    $this->db->table('matching_contact_session')->truncate();

    // 2. Child tables
    $this->db->table('contact_email')->truncate();
    $this->db->table('contact_mobile')->truncate();

    // 3. Parent table
    $this->db->table('contact')->truncate();

    // Re-enable foreign key checks
    $this->db->query('SET FOREIGN_KEY_CHECKS = 1');

    // Complete the transaction
    $this->db->transComplete();

    // Redirect to company page
    // return redirect()->to(site_url('company'));
}


    /**
     * Clear company-related tables
     * ⚠️ High risk
     */
public function clearCompanyTables($database = null)
{

    $db = $this->db;
    $db->transStart();

    if ($database === "yes") {
        $db->table('contact_email')->truncate();
        $db->table('contact_mobile')->truncate();
        $db->table('contact')->truncate();
        $db->table('company_sources')->truncate();
        $db->table('company_data')->truncate();
    } else {
        $companyIds = $db->table('company_data')
            ->select('company_id')
            ->where('database_name', $database)
            ->get()
            ->getResultArray();

        if (!empty($companyIds)) {
            $companyIds = array_column($companyIds, 'company_id');

            $contactIds = $db->table('contact')
                ->select('contact_id')
                ->whereIn('company_id', $companyIds)
                ->get()
                ->getResultArray();

            $contactIds = array_column($contactIds, 'contact_id');

            if (!empty($contactIds)) {
                $db->table('contact_email')->whereIn('contact_id', $contactIds)->delete();
                $db->table('contact_mobile')->whereIn('contact_id', $contactIds)->delete();
            }

            $db->table('contact')->whereIn('company_id', $companyIds)->delete();
            $db->table('company_sources')->whereIn('company_id', $companyIds)->delete();
            $db->table('company_data')->whereIn('company_id', $companyIds)->delete();
        }
    }

    $db->transComplete();

    return redirect()->to(site_url('company/general'));
}
    /**
     * Clear everything NON-FINANCIAL
     * ⚠️ Very high risk – admin only
     */
    public function clearAllNonFinancial()
    {
        $tables = [
            'matching_session',
            'matching_contact_session',
            'company_sources',
            'contact_email',
            'contact_mobile',
            'contact',
            'company_data',
            'company_data_backup',
            'leads',
            'discussion',
            'updation'
        ];

        foreach ($tables as $table) {
            $this->db->table($table)->truncate();
        }

return redirect()->to(site_url('company'));
    }

    /**
     * Clear EVERYTHING (DO NOT expose publicly)
     */
    public function clearEverything()
    {
        $tables = [
            'matching_session',
            'matching_contact_session',
            'company_sources',
            'contact_email',
            'contact_mobile',
            'contact',
            'company_data',
            'company_data_backup',
            'leads',
            'discussion',
            'updation',
            'payments',
            'invoices',
            'events',
            'layout_info',
            'marketing_templates',
            'sources',
            'users'
        ];

        foreach ($tables as $table) {
            $this->db->table($table)->truncate();
        }

// return redirect()->to(site_url('company'));
    }
}
