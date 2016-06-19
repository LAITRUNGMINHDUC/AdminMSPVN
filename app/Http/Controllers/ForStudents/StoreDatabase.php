<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Session;
use App\Http\Requests;
use App\Classes\CustomAzure;

class StoreDatabase extends Controller
{
    //
    public function Store(Request $request)
    {
    	$validator = Validator::make ($request->all(), [
		    'Fullname' => 'required|max:60',
		    'StudentID' => 'required|max:20|alpha_dash',
		    'University' => 'required|max:255',
		    'Shortname' => 'required|max:10|different:University|alpha_num',
		    'Class' => 'required|max:15|alpha_dash',
			'LinkStudentID' => 'required|max:1000|active_url',		    
		]);

        if ($validator->fails()) {
            return redirect('Form')
                        ->withErrors($validator)
                        ->withInput();
        }

        $Data['PartitionKey'] = "Students";
        $Data['RowKey'] = $request->get('Email');
        $Data['Data']['Token'] = $request->get('_token');
        $Data['Data']['Fullname'] = $request->get('Fullname');
        $Data['Data']['Shortname'] = trim(strtoupper($request->get('Shortname')));
        $Data['Data']['StudentID'] = $request->get('StudentID');
        $Data['Data']['University'] = trim($request->get('University'));
        $Data['Data']['Class'] = trim($request->get('Class'));
        $Data['Data']['LinkStudentID'] = trim($request->get('LinkStudentID'));
        $Data['Data']['Status'] = "In Progress";

        
        $user = new CustomAzure();
        $result = $user->insertEntity(env('AZURE_MAIN_TABLE'), $Data);
         
        return redirect()->action('MSPController@Home');
    }

    public function Form()
    {
        $hasEmail = Session::has('email');
        if (!$hasEmail) return redirect('/');

        $email = Session::get('email');
        $name = Session::get('name');
    	$Query = "RowKey eq '$email'";
    	$user = new CustomAzure();
        $result = $user->queryEntities(env('AZURE_MAIN_TABLE'), $Query);
        if (empty($result))
        {
            return view('HTML.Form', ['email' => $email, 'name' => $name]);    
        }

        //if ($result['Status'] == 'Admin') return redirect()->action('MSPController@Admin');
        return redirect()->action('MSPController@Home');	
    }
}
