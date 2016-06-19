<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\CustomAzure;
use App\Http\Requests;
use MicrosoftAzure\Storage\Table\Models\Entity;
use Session;

class ManageController extends Controller
{
    /**
     * @param $para
     * @return array
     */

    public function __construct()
    {
        if (!Session::has('Email') || !Session::has('Role'))
        {
            return redirect("https://msp-vietnam.azurewebsites.net")->send();
        }
    }

    public function queryTable($para)
    {
        switch ($para)
        {
            case "S1": $Query = "Status eq 'In Progress'"; break;
            case "S2": $Query = "Status eq 'Valid'"; break;
            case "S3": $Query = "Status eq 'Reject'"; break;
            case "S4": $Query = "Status ne 'In Progress'"; break;

            case "M1": $Query = "Mail eq 'Sent'"; break;
            case "M2": $Query = "Mail eq 'Error'"; break;

            case "F1": $Query = "Flag eq 'Downloaded'"; break;

            case "P1": $Query = "PartitionKey eq 'Students'"; break;
            case "P2": $Query = "PartitionKey eq 'Counts'"; break;
        }
        $Azure = new CustomAzure();
        $Result = $Azure->queryEntities(env('AZURE_MAIN_TABLE'), $Query);
        return $Result;
    }

    public function Home()
    {
        $Azure = new CustomAzure();
        $Data = $Azure->tableClient->getEntity(env('AZURE_MAIN_TABLE'), "Variables", "Count");
        //$Result = $Azure->ConvertEntities($Data);
        //return view('ADMIN.home')->with(['users' => $Result]);
    }

    public function listInProgress()
    {
        $Result = $this->queryTable("S1");
        return view('ADMIN.lists')->with(['users' => $Result]);
    }

    public function listConfirm(Request $request)
    {
        $Data = $request->except(['_method', '_token']);
        $Azure = new CustomAzure();

        $Processed['Data']['Data'] = '';
        $countValid = 0;
        foreach ($Data as $Key=>$Value)
        {
            if ($Value == 'Valid') $countValid = $countValid + 1;

            $user = $Azure->tableClient->getEntity(env('AZURE_MAIN_TABLE'), "Students", $Key);
            $entity = $user->getEntity();
            $entity->setPropertyValue("Status", $Value);
            $Azure->tableClient->updateEntity(env('AZURE_MAIN_TABLE'), $entity);
            $Processed['Data']['Data'] = $Processed['Data']['Data'].$Key."@@@";
        }

        $Processed['RowKey'] = date('Y_m_d__h_i_s_A');
        $Processed['PartitionKey'] = "Processed";
        $Azure->insertEntity(env('AZURE_MAIN_TABLE'), $Processed);

        $Count = $Azure->tableClient->getEntity(env('AZURE_MAIN_TABLE'), "Variables", "Count");
        $entity = $Count->getEntity();

        $Temp = $entity->getProperty("Valid")->getValue();
        $Temp = (int) $Temp + $countValid;
        $Temp = (string) $Temp;
        $entity->setPropertyValue("Valid", $Temp);
        $Temp = $entity->getProperty("Reject")->getValue();
        $Temp = (int) $Temp + count($Data) - $countValid;
        $Temp = (string) $Temp;
        $entity->setPropertyValue("Reject",$Temp);
        $Temp = $entity->getProperty("InProgress")->getValue();
        $Temp = (int) $Temp -    count($Data);
        $Temp = (string) $Temp;
        $entity->setPropertyValue("InProgress",$Temp);

        $Azure->tableClient->updateEntity(env('AZURE_MAIN_TABLE'), $entity);

        return redirect()->action('ManageController@listDownload', [$Processed['RowKey']]);
    }

    public function listProcessed()
    {
        $Azure = new CustomAzure();
        $Data = $Azure->queryEntities(env('AZURE_MAIN_TABLE'), "PartitionKey eq 'Processed'");
        rsort($Data);
        return view('ADMIN.listsExport')->with(['Dates'=>$Data, 'dateID' => 'NO DATE']);
    }

    public function listDownload($dateID)
    {
        $Azure = new CustomAzure();
        $Data = $Azure->tableClient->getEntity(env('AZURE_MAIN_TABLE'), "Processed", $dateID);
        $Result = $Data->getEntity()->getProperty('Data')->getValue();
        $Result = explode("@@@", $Result);

        $Lists = array();
        foreach ($Result as $Key)
        {
            if ($Key != "")
            {
                $Data = $Azure->tableClient->getEntity(env('AZURE_MAIN_TABLE'), "Students", $Key);
                $Entity = $Data->getEntity();
                $Entity = $Azure->ConvertEntity($Entity);
                array_push($Lists, $Entity);
            }
        }

        $Data = $Azure->queryEntities(env('AZURE_MAIN_TABLE'), "PartitionKey eq 'Processed'");
        rsort($Data);
        return view('ADMIN.listsExport')->with(['users' => $Lists, 'Dates' => $Data, 'dateID'=>$dateID]);
        //return $Lists;
    }

    public function listMailed()
    {

    }

    public function deleteAndCreate()
    {
        $tableName = env('AZURE_MAIN_TABLE');
        $Azure = new CustomAzure();
        //$Azure->tableClient->deleteTable($tableName);
        $Azure->tableClient->createTable($tableName);
    }

    public function initVariables()
    {
        $Azure = new CustomAzure();
        $Count['PartitionKey'] = "Variables";
        $Count['RowKey'] = "Count";
        $Count['Data']['InProgress'] = (string) 1;
        $Count['Data']['Valid'] = (string) 0;
        $Count['Data']['Reject'] = (string) 0;
        $Azure->insertEntity(env('AZURE_MAIN_TABLE'), $Count);
    }
}
