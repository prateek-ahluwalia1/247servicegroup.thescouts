<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditForm extends Model
{
    use HasFactory;
    protected $table = 'audit_form';
    protected $fillable = [
        'customer_id', 'site_id', 'guard_id', 'guard_name', 'guard_email', 'guard_phone',
        'guard_security_license', 'guard_license_expiry', 'admin_id', 'have_uniform', 'uniform_text',
        'have_shoes', 'shoes_text', 'have_license', 'license_text', 'have_induction_card',
        'induction_card_text', 'have_notebook_pen', 'notebook_pen_text', 'log_book', 'book_text',
        'on_time', 'on_time_text', 'job_understanding', 'job_understanding_text', 'have_firstaid',
        'firstaid_text', 'have_site_knowledge', 'site_knowledge_text', 'have_assigned_petrol',
        'assigned_petrol_text', 'have_rsa_certificate', 'rsa_certificate_text', 'have_white_card',
        'white_card_text', 'have_children_check', 'children_check_text', 'have_site_eqipment',
        'site_eqipment_text', 'have_well_groomed', 'well_groomed_text', 'have_on_site', 'on_site_text',
        'signature', 'notes'
    ];
}
