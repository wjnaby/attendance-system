<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\AuditLog;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [
            'check_in_time' => Setting::get('check_in_time', '09:00'),
            'check_out_time' => Setting::get('check_out_time', '17:00'),
            'late_threshold_minutes' => Setting::get('late_threshold_minutes', 15),
        ];
        
        return view('admin.settings', compact('settings'));
    }
    
    public function update(Request $request)
    {
        $validated = $request->validate([
            'check_in_time' => 'required|date_format:H:i',
            'check_out_time' => 'required|date_format:H:i',
            'late_threshold_minutes' => 'required|integer|min:0|max:120',
        ]);
        
        $oldSettings = [
            'check_in_time' => Setting::get('check_in_time'),
            'check_out_time' => Setting::get('check_out_time'),
            'late_threshold_minutes' => Setting::get('late_threshold_minutes'),
        ];
        
        Setting::set('check_in_time', $validated['check_in_time'], 'time');
        Setting::set('check_out_time', $validated['check_out_time'], 'time');
        Setting::set('late_threshold_minutes', $validated['late_threshold_minutes'], 'integer');
        
        AuditLog::log(
            'settings_updated',
            'System settings updated',
            null,
            $oldSettings,
            $validated
        );
        
        return back()->with('success', 'Settings updated successfully');
    }
}