<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\CustomAzure;

use App\Http\Requests;
use Session;

class MSPController extends Controller
{
    //
    public function Home()
    {
        $hasEmail = Session::has('email');
        if (!$hasEmail) return redirect('/');
    	return view('HTML.home');
    }

    public function Signout()
    {
    	Session::flush();
    	return redirect('/');
    }

    public function Admin()
    {
        
    }

    public function adminGetDatabase($Type)
    {
        // 1 - Get All Students
        // 2 - Get In Progress
        // 3 - Get Valid
        // 4 - Get Reject
        $Query = "";
        if ($Type == 1) $Query = "PartitionKey eq 'Students'";
        if ($Type == 2) $Query = "Status eq 'In Progress'";
        if ($Type == 3) $Query = "Status eq 'Valid'";
        if ($Type == 4) $Query = "Status eq 'Reject'";
        $Data = new CustomAzure();
        $Result = $Data->queryEntities(env('AZURE_MAIN_TABLE'), $Query);
        return $Result;
    }

    public function adminProcessForm(Request $request)
    {
        return $request->get('');
    }

    public function adminGUI()
    {
        $Data = $this->adminGetDatabase(2);
        return view('ADMIN.home')->with(['users' => $Data]);
        //return response()->json($Data);
    }
}
