<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Attendance extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'date',
        'check_in',
        'check_out',
        'status',
    ];
    
    protected $casts = [
        'date' => 'date',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function isLate()
    {
        if (!$this->check_in) return false;
        
        $checkInTime = Carbon::parse($this->check_in);
        $workStart = Carbon::parse('09:00:00');
        
        return $checkInTime->gt($workStart);
    }
}