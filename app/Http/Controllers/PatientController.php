<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Display the Dashboard with statistics.
     */
    public function dashboard()
    {
        // Calculate statistics from the database
        $totalMembers = Patient::count();
        
        // Using 'M' and 'F' based on your database structure
        $maleCount = Patient::where('sex', 'M')->count();
        $femaleCount = Patient::where('sex', 'F')->count();
        
        // Based on standard primary vs dependent tracking
        $dependentCount = Patient::where('member_type', 'DEPENDENT')->count();
        $independentCount = Patient::where('member_type', 'MEMBER')->count();

        return view('dashboard', compact(
            'totalMembers', 
            'maleCount', 
            'femaleCount', 
            'dependentCount', 
            'independentCount'
        ));
    }

    /**
     * Display the scrollable YAKAP Member directory with refined structured search.
     */
    public function index(Request $request)
    {
        // Capture separate input values from the request
        $lastName = $request->input('last_name');
        $firstName = $request->input('first_name');
        $suffix = $request->input('suffix');

        $query = Patient::query();

        // Filter by Last Name if provided
        if (!empty($lastName)) {
            $query->where('last_name', 'LIKE', "%{$lastName}%");
        }

        // Filter by First Name if provided
        if (!empty($firstName)) {
            $query->where('first_name', 'LIKE', "%{$firstName}%");
        }

        // Filter by Suffix based on dropdown selection
        if (!empty($suffix)) {
            if ($suffix === 'none') {
                // Finds records where the suffix field is completely blank or null
                $query->where(function ($q) {
                    $q->whereNull('suffix')->orWhere('suffix', '');
                });
            } else {
                // Exact match lookup for items like Jr., Sr., etc.
                $query->where('suffix', $suffix);
            }
        }

        // Paginate results and preserve the individual search filters across links
        $patients = $query->paginate(15)->withQueryString(); 

        return view('yakap-member', compact('patients', 'lastName', 'firstName', 'suffix'));
    }
}