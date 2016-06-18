<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;

use App\Classes\CustomAzure;

class TestAzure extends Controller
{
	public function AZQuery(Request $Request)
	{
		$Query = $Request->input('Query');	
		if (!empty($Query))
		{
			$DATA = new CustomAzure();
			$Result = $DATA->queryEntities("FPTStudents", $Query);
			return response()->json($Result);
		}
	}

	public function AZInsert(Request $Request)
	{
		$Input['PartitionKey'] = $Request->input('PartitionKey');
		$Input['RowKey'] = $Request->input('RowKey');
		$Input['Property'] = $Request->input('Property');
		$Input['Value'] = $Request->input('Value');
		if (!empty($Input))
		{
			$DATA = new CustomAzure();
			$Result = $DATA->insertEntity("FPTStudents", $Input);
			return response()->json($Result);			
		}
	}

	public function MSPCreateTable()
	{
		$Name = "MSPStudentInfo";
		$Data = new CustomAzure();
		$Result = $Data->createTable($Name);
		return response()->json($Result);
	}

	public function MSPQuery()
	{
		//$Email = 'laitrungminhduc@gmail.com';
		$Query = "Status eq 'In Progress'";
		$Data = new CustomAzure();
		$Result = $Data->queryEntities(env('AZURE_MAIN_TABLE'), $Query);
		return response()->json($Result);
	}

	public function MSPSeed()
	{
		$Data['PartitionKey'] = "FPT";
		$Data['RowKey'] = "laitrungminhduc@gmail.com";
		$Data['Data']['StudentID'] = "1401015084";
		$DATA = new CustomAzure();
		$Result = $DATA->insertEntity("MSPStudentInfo", $Data);
		return response()->json($Result);			
	}
}