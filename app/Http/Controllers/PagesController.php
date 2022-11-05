<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\School;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index(){
        return view('pages.homepage');
    }
    public function createstudentaccount(Request $request)
    {
        $this->validate($request, [
            'student_full_name' => 'required|string|min:5',
            'phone_number' => 'required|digits:10|unique:users',
            'email' => 'required|email|unique:users',
            'address_address' => 'required',
            'school_name' => 'required',
            'address_latitude' => 'required',
            'address_longitude' => 'required',
            'password' => 'required|string|min:5|confirmed',
            'password_confirmation' => 'required'
        ]);
        $timenow = time();
        $checknum = "1234567898746351937463790";
        $checkstring = "QWERTYUIOPLKJHGFDSAZXCVBNMmanskqpwolesurte";
        $checktimelength = 6;
        $checksnumlength = 6;
        $checkstringlength = 20;
        $randnum = substr(str_shuffle($timenow), 0, $checktimelength);
        $randstring = substr(str_shuffle($checknum), 0, $checksnumlength);
        $randcheckstring = substr(str_shuffle($checkstring), 0, $checkstringlength);
        $totalstring = str_shuffle($randcheckstring . "" . $randnum . "" . $randstring);

        $new = new User;
        $new->name = $request->student_full_name;
        $new->phone_number = $request->phone_number;
        $new->email = $request->email;
        $new->password = bcrypt($request->password);
        $new->save();

        $add = new Student;
        $add->student_id = $new->id;
        $add->school_id = $request->school_name;
        $add->location_address = $request->address_address;
        $add->latitude = $request->address_latitude;
        $add->longitude = $request->address_longitude;
        $add->slug = $totalstring;
        $add->status = "verified";
        $add->save();

        $new->attachRole('student');

        return redirect()->route('login')->with('accountsuccess', 'Student account successfully created.');
    }
    public function createschoolaccount()
    {
        return view('auth.register-school');
    }

    public function storeschoolaccount(Request $request)
    {
        $this->validate($request, [
            'admin_full_name' => 'required|string|min:5',
            'phone_number' => 'required|digits:10|unique:users',
            'email' => 'required|email|unique:users',
            'school_name' => 'required|string|min:5',
            'address_address' => 'required',
            'address_latitude' => 'required',
            'address_longitude' => 'required',
        ]);
        $timenow = time();
        $checknum = "1234567898746351937463790";
        $checkstring = "QWERTYUIOPLKJHGFDSAZXCVBNMmanskqpwolesurte";
        $checktimelength = 6;
        $checksnumlength = 6;
        $checkstringlength = 20;
        $randnum = substr(str_shuffle($timenow), 0, $checktimelength);
        $randstring = substr(str_shuffle($checknum), 0, $checksnumlength);
        $randcheckstring = substr(str_shuffle($checkstring), 0, $checkstringlength);
        $totalstring = str_shuffle($randcheckstring . "" . $randnum . "" . $randstring);

        $new = new User;
        $new->name = $request->admin_full_name;
        $new->phone_number = $request->phone_number;
        $new->email = $request->email;
        $new->password = bcrypt($request->phone_number);
        $new->save();

        $add = new School;
        $add->manager_id = $new->id;
        $add->school_name = $request->school_name;
        $add->location_address = $request->address_address;
        $add->latitude = $request->address_latitude;
        $add->longitude = $request->address_longitude;
        $add->slug = $totalstring;
        $add->status = "verified";
        $add->save();

        $new->attachRole('schooladmin');
        $new->attachPermission('manage-students');

        return redirect()->route('login')->with('accountsuccess', 'School account successfully created.');
    }
    public function createbusinessaccount(){
        return view('auth.register-business');
    }
    public function storebusinessaccount(Request $request){
        $this->validate($request, [
            'full_name' => 'required|string|min:5',
            'phone_number' => 'required|digits:10|unique:users',
            'email' => 'required|email|unique:users',
            'shop_name' => 'required|string|min:5',
            'address_address' => 'required',
            'address_latitude' => 'required',
            'address_longitude' => 'required',
        ]);
        $timenow = time();
        $checknum = "1234567898746351937463790";
        $checkstring = "QWERTYUIOPLKJHGFDSAZXCVBNMmanskqpwolesurte";
        $checktimelength = 6;
        $checksnumlength = 6;
        $checkstringlength = 20;
        $randnum = substr(str_shuffle($timenow), 0, $checktimelength);
        $randstring = substr(str_shuffle($checknum), 0, $checksnumlength);
        $randcheckstring = substr(str_shuffle($checkstring), 0, $checkstringlength);
        $totalstring = str_shuffle($randcheckstring . "" . $randnum . "" . $randstring);

        $new = new User;
        $new->name = $request->full_name;
        $new->phone_number = $request->phone_number;
        $new->email = $request->email;
        $new->password = bcrypt($request->phone_number);
        $new->save();

        $add = new Business;
        $add->owner_id = $new->id;
        $add->business_name = $request->shop_name;
        $add->location_address = $request->address_address;
        $add->latitude = $request->address_latitude;
        $add->longitude = $request->address_longitude;
        $add->slug = $totalstring;
        $add->status = "verified";
        $add->save();

        $new->attachRole('businessowner');
        $new->attachPermission('manage-products');

        return redirect()->route('login')->with('accountsuccess', 'Business account successfully created.');
    }
}
