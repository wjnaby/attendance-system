<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'start_date',
        'end_date',
        'leave_type',
        'reason',
        'mc_document',
        'status',
        'approved_by',
        'admin_notes',
    ];
    
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
    
    // ✅ FIXED: safer date difference calculation
    public function getDaysCount()
    {
        return $this->end_date->diffInDays($this->start_date) + 1;
    }
}
