<?php

return [
    "item_type" => [
        "it" => "IT Item",
        "admin" => "Non-It Item"
    ],
    "gender" => [
        "male" => "Male",
        "female" => "Female",
        "regardless" => "Regardless"
    ],
    "budget_info" => [
        "budgeted" => "Budgeted",
        "non-budgeted" => "Non-Budgeted",
    ],
    "procurement_type" => [
        "opex" => "Opex",
        "capex" => "Capex",
    ],
    "approval_stage" => [
        'bh_head' => 'BU-Head',
        'it_team' => 'It-Team',
        'admin_team' => 'Admin-Team',
    ],
    "approval_team" => [
        'it_team' => 'IT Team',
        'admin_team' => 'Admin Team',
        'procurement_team' => 'Procurement Team',
        'cs_approval_hod' => 'Head of Procurement (HoP)',
        'cs_approval_panel' => 'CS Approval Panel',
        'chief_business_officer' => 'Chief Business Officer(CBO)',
        'deputy_finance_director' => 'Deputy Director Of Finance',
        'chief_finance_officer' => 'Chief Finance Officer(CFO)',
        'chief_executive_officer' => 'Chief Executive Officer(CEO)',
    ],
    //User Type
    "user_type" => [
        "hq-admin" => "HQ Admin",
        "admin" => "Admin",
        "user" => "User",
    ],
    "vat_list" => [
        "0.00" => "0.00",
        "5.00" => "5.00",
        "7.50" => "7.50",
        "10.00" => "10.00",
        "15.00" => "15.00",
    ],

    'CDN' => env('CDN', '/assets'),

    "pr-status" => [
        "approved" => "Approved",
        "pending" => "Pending",
        "reverted" => "Reverted",
        "rejected" => "Rejected",
        "draft" => "Draft",
    ],
    "pr-stage" => [
        "it_team" => "It Team",
        "finance" => "Finance",
        "bu_head" => "BU Head",
        "procurement_team" => "Procurement Team",
    ],


];
