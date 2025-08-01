<?php

namespace App\Http\Controllers;

use App\Models\AutoApplyPreference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AutoApplyController extends Controller
{
    /**
     * Display the auto-apply settings page.
     */
    public function index(Request $request)
    {
        $preferences = $request->user()->autoApplyPreference ?? new AutoApplyPreference([
            'user_id' => $request->user()->id,
            'auto_apply_enabled' => false,
            'job_titles' => [],
            'locations' => [],
            'salary_min' => null,
            'salary_max' => null,
            'cover_letter_template' => null,
        ]);
        Log::info('AutoApply preferences debug info', [
            'job_titles_raw' => $preferences->getRawOriginal('job_titles'),
            'job_titles_casted' => $preferences->job_titles,
            'locations_raw' => $preferences->getRawOriginal('locations'),
            'locations_casted' => $preferences->locations,
        ]);

        return view('auto-apply', compact('preferences'));
    }

    /**
     * Display the auto-apply preferences.
     */
    public function preferences(Request $request)
    {
        $preferences = $request->user()->autoApplyPreference ?? new AutoApplyPreference([
            'user_id' => $request->user()->id,
            'auto_apply_enabled' => false,
            'job_titles' => [],
            'locations' => [],
            'salary_min' => null,
            'salary_max' => null,
            'cover_letter_template' => null,
        ]);
        Log::info('AutoApply preferences debug info', [
            'job_titles_raw' => $preferences->getRawOriginal('job_titles'),
            'job_titles_casted' => $preferences->job_titles,
            'locations_raw' => $preferences->getRawOriginal('locations'),
            'locations_casted' => $preferences->locations,
        ]);

        return view('auto-apply-preferences', compact('preferences'));
    }

    /**
     * Update the user's auto-apply preferences.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'job_titles' => 'nullable|string',
            'locations' => 'nullable|string',
            'salary_min' => 'nullable|integer',
            'salary_max' => 'nullable|integer',
            'cover_letter_template' => 'nullable|string',
        ]);

        $preferences = $user->autoApplyPreference ?? new AutoApplyPreference(['user_id' => $user->id]);

        $preferences->fill([
            'job_titles' => $request->job_titles ? json_decode($request->job_titles, true) : [],
            'locations' => $request->locations ? json_decode($request->locations, true) : [],
            'salary_min' => $request->salary_min,
            'salary_max' => $request->salary_max,
            'cover_letter_template' => $request->cover_letter_template,
        ]);
        Log::info('AutoApply preferences debug info', [
            'job_titles_raw' => $preferences->getRawOriginal('job_titles'),
            'job_titles_casted' => $preferences->job_titles,
            'locations_raw' => $preferences->getRawOriginal('locations'),
            'locations_casted' => $preferences->locations,
        ]);
        $preferences->save();

        return back()->with('success', 'Preferences updated successfully.');
    }

    /**
     * Toggle auto-apply on or off.
     */
    public function toggle(Request $request)
    {
        $user = $request->user();
        $preferences = $user->autoApplyPreference;

        if (! $preferences) {
            // Create new preferences with auto-apply enabled
            $preferences = new AutoApplyPreference([
                'user_id' => $user->id,
                'auto_apply_enabled' => true,
                'job_titles' => [],
                'locations' => [],
            ]);
            $preferences->save();
        } else {
            $preferences->auto_apply_enabled = ! $preferences->auto_apply_enabled;
            $preferences->save();
        }

        return back()->with('success', 'Auto-Apply status updated.');
    }
}
