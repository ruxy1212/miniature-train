<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\Person;


class PersonController extends Controller
{
    /**
     * Store a newly created resource in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $payload = $request->only('name');

        // validate the request
        $validate = Validator::make($payload, [
            'name' => 'required|string',
        ]);

        if ($validate->fails()) {
            return response()->json(['error'=> true, 'message' => $validate->messages()], 400, [], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
        }

        // check if name exists
        if(!Person::where('name', $request->name)->get()->isEmpty())
            return response()->json(['error'=> true, 'message' => "User with name '$request->name' already exists"], 400, [], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);

        $person = Person::create([
            'name' => $request->name,
        ]);
        return response()->json([
            'error'=> false, 
            'message' => 'New person added successfully',
            'data' => $person
        ], 201, [], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function find($id){
        $person = Person::where('id', $id)->get();

        if($person->isEmpty())
            return response()->json(['error'=> true, 'message' => "No such record found"], 404, [], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);

        return response()->json([
            'error'=> false, 
            'message' => 'Person fetched successfully',
            'data' => $person
        ], 200, [], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
    }

    /**
     * editing the specified resource.
     *
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request){
        $person = Person::where('id', $id)->first();
        if(!$person)
            return response()->json(['error'=> true, 'message' => "Record not found"], 404, [], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
        $data = $request->only(['name']);
        $validate = Validator::make($data, [
            'name' => 'required|string',
        ]);

        if ($validate->fails()) {
            return response()->json(['error'=> true, 'message' => $validate->messages()], 404, [], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
        }
        $updateData = $person->update($data);
        if(!$updateData){
            return response()->json([
                'error'=> true, 
                'message' => "An error occurred, try again",
            ], 400, [], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
        }

        return response()->json([
            'error'=> false, 
            'message' => "Record updated successfully",
            'data' => $person
        ], 200, [], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
    }
    
    /**
     * Remove the specified resource from database.
     *
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $person = Person::where('id', $id)->first();
        if(!$person)
            return response()->json(['error'=> true, 'message' => "Person does not exist"], 404, [], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);

        $deleteData = $person->delete();
        if (!$deleteData) {
            return response()->json([
                'error'=> true, 
                'message' => "An error occurred, please try again",
            ], 400, [], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
        }

        return response()->json([
            'error'=> false, 
            'message' => "Record deleted successfully",
        ], 202, [], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function index() {
        $person = Person::all();
        if($person->isEmpty())
            return response()->json(['error'=> true, 'message' => "No records available yet"], 404, [], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);

        return response()->json([
            'error'=> false, 
            'message' => "All records fetched successfully",
            'data' => $person
        ], 200, [], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
    }
}