<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\test;
use App\Models\State;
use App\Models\District;
use App\Models\Municipality;

class UserController extends Controller
{
    public function index()
    {
        $data = test::all();
        return view('welcome', compact('data'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = new test();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('uploads/test/', $filename);
            $data->image = $filename;
        }

        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
        $data->save();
        return redirect()->back()->with('success', 'Data inserted successfully.');
    }

    public function delete($id)
    {
        $data = test::find($id);
        $data->delete();
        return redirect()->back()->with('success', 'Data deleted successfully.');
    }

    public function edit($id)
    {
        $data = test::find($id);
        return view('modal.EditModal', compact('data'));
    }

    public function update(Request $request)
    {


        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            // 'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = test::find($request->id);
        if (!$data) {
            return redirect()->back()->with('error', 'Data not found.');
        }
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('uploads/test/', $filename);
            $data->image = $filename;
        }
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
        $data->save();
        return redirect('/')->with('success', 'Data updated successfully.');
    }

    public function search(Request $request)
    {
        $search = $request->search;
        $data = test::where('name', 'like', '%' . $search . '%')
            ->orWhere('email', 'like', '%' . $search . '%')
            ->orWhere('phone', 'like', '%' . $search . '%')
            ->get();

        return view('welcome', compact('data'));
    }

    public function jquery()
    {
        $data = test::all();
        return view('jquery', compact('data'));
    }

    public function jquerystore(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => ['required', 'regex:/^\d{10}$|^\d{13}$/'],
            'address' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ], [
            'phone.regex' => 'The phone number must be either 10 or 13 digits with country code.'
        ]);

        $checkEmail = test::where('email', $request->email)->first();
        if ($checkEmail) {
            return response()->json(['errors' => 'Email already exists']);
        }

        $data = new test();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('uploads/test/', $filename);
            $data->image = $filename;
        }
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
        $data->save();
        $allData = test::all();
        return response()->json(['message' => 'Data inserted successfully', 'data' => $allData]);
    }

    public function jquerydelete($id)
    {
        $data = test::findOrFail($id);

        // Delete the user's image from storage
        if ($data->image) {
            $imagePath = public_path('uploads/test/' . $data->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // Delete the data from the database
        $data->delete();

        return response()->json(['message' => 'Data deleted successfully']);
    }


    public function jqueryedit($id)
    {
        $data = test::findOrFail($id);
        return response()->json($data);
    }


    public function jqueryupdate(Request $request)
    {
        $data = test::findOrFail($request->id);

        if ($request->hasFile('image')) {

            if ($data->image) {
                $imagePath = public_path('uploads/test/' . $data->image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('uploads/test/', $filename);
            $data->image = $filename;
        }

        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
        $data->save();
        return response()->json(['message' => 'Data updated successfully']);
    }

    public function getDistricts($stateId){
        $districts = District::where('state_id', $stateId)->get();
        return response()->json($districts);
    }


    public function getMunicipalities($districtId){
        $municipalities = Municipality::where('district_id', $districtId)->get();
        return response()->json($municipalities);
    }
}
