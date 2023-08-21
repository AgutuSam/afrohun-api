<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\DataTable;

class ImportController extends Controller
{
    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sheet_name' => 'required|string',
            'file_data' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid data.'], 400);
        }

        // $sheetName = $request->input('sheet_name');
        // $data = json_decode($request->input('file_data'), true);

        $sheetName = $request->input('sheet_name');
        $fileData = $request->input('file_data');

        $data = json_decode($fileData, true);

        if (!is_array($data)) {
            return response()->json(['error' => 'Invalid file data format.'], 400);
        }

        foreach ($data as $row) {
            $record = [
                'first_name' => $row['First Name'],
                'last_name' => $row['Last Name'],
                'email' => $row['Email'],
                'gender' => $row['Gender'],
                'institution' => $row['Institution/University'],
                'job_title' => $row['Position/ Job title'],
                'participant_type' => $row['Type of participant'],
                'age' => $row['Age'],
                'discipline' => $row['Discipline'],
                'role_in_activity' => $row['Role in this activity'],
                'country' => $row['Country of Residence'],
                'remarks' => $row['Remarks'],
                'sheet_name' => $sheetName,
            ];

            DataTable::create($record);
        }

        return response()->json(['message' => 'Data imported successfully.']);
    }
}
