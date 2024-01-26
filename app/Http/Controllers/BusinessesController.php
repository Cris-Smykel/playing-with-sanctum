<?php

namespace App\Http\Controllers;

use App\Models\V1\Businesses;
use App\Http\Requests\V1\StoreBusinessesRequest;
use App\Http\Requests\V1\UpdateBusinessesRequest;
use App\Http\Resources\V1\BusinessesResource;
use App\Http\Resources\V1\BusinessesCollection;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class BusinessesController extends Controller
{

    protected $maxDataPerPage = 10;
    protected $success = 200;
    protected $notFound = 404;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {

            $businesses = Businesses::paginate($this->maxDataPerPage);

            if ($businesses->isEmpty()) {
                throw new Exception("No data found.");
            }

            if ($request->query("includeClients") === "true") {
                $businesses = Businesses::with("clients")->paginate($this->maxDataPerPage);
            }

            $data = new BusinessesCollection($businesses);


            return response()->json(["success" => true, "data" => $data], $this->success);
        } catch (Exception $e) {

            return response()->json(["success" => false, "msg" => "No data found."], $this->notFound);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBusinessesRequest $request)
    {
        return  Auth::guard("business")->user();
        try {
            $data = $request->all();
            $data["password"] = Hash::make($request->input("password"));
            $business = new BusinessesResource(Businesses::create($data));
            return response()->json(["success" => true, "data" => $business], $this->success);
        } catch (Exception) {
            return response()->json(["success" => false, "msg" => "There wan an error when inserting the data."], $this->notFound);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id, Request $request)
    {
        try {
            $business = Businesses::findOrFail($id);

            if ($request->query("includeClients") === "true") {
                $business = Businesses::with("clients")->findOrFail($id);
            }

            $data = new BusinessesResource($business);
            return response()->json(["success" => true, "data" => $data], $this->success);
        } catch (Exception $e) {
            return response()->json(["success" => false, "msg" => "Data not found."], $this->notFound);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBusinessesRequest $request, Businesses $business)
    {
        try {
            $data = $request->all();
            if ($request->has("password")) {
                $data["password"] = Hash::make($request->input("password"));
            }
            $business->update($data);

            $business = new BusinessesResource($business);

            return response()->json(["success" => true, "data" => $business], $this->success);
        } catch (Exception) {
            return response()->json(["success" => false, "msg" => "There wan an error when inserting the data."], $this->notFound);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Businesses $businesses)
    {
        //
    }
}
