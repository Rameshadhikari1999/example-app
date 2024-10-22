<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\test;

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
        if(!$data){
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

    public function jquery(){
        $data = test::all();
        return view('jquery', compact('data'));
    }

    public function jquerystore(Request $request){

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $checkEmail = test::where('email', $request->email)->first();
        if ($checkEmail) {
            return response()->json(['message' => 'Email already exists']);
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
        return response()->json(['message' => 'Data inserted successfully', 'data' => $request->all()]);
    }

    public function jquerydelete($id){
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
}
