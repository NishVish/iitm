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
    return redirect()->to(site_url('company'));
}


    /**
     * Clear company-related tables
     * ⚠️ High risk
     */
    public function clearCompanyTables()
    {
        $tables = [
            'company_sources',
            'company_data',
            'company_data_backup'
        ];

        foreach ($tables as $table) {
            $this->db->table($table)->truncate();
        }

return redirect()->to(site_url('company'));
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

return redirect()->to(site_url('company'));
    }
}
