<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Position;

class EmployeesController extends Controller
{
    public function index()
    {
        return Employee::with('position')->get();
    }

    public function store(Request $request)
    {
        //backend validation. Name, email and phone is set to be required. If they're not filled, then the rest of the code won't 
        //execute
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required'
        ]);

        //set the employee variable
        $employee = new Employee;
        $employee->name = $request->input('name');
        $employee->email = $request->input('email');
        $employee->phone = $request->input('phone');
        
        //check what the position type is and find the id of that type
        $positionType = $request->input('position');
        $positionID = Position::where('position', $positionType)->first();
        
        //set the employee position_id (foreign key) to be the id of the given position type
        $employee->position_id = $positionID->id;


        $employee->save();
    }

}
