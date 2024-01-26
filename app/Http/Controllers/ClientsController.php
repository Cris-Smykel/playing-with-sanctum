<?php

namespace App\Http\Controllers;

use App\Models\V1\Clients;
use App\Http\Requests\V1\StoreClientsRequest;
use App\Http\Requests\V1\UpdateClientsRequest;
use Illuminate\Http\Request;
use \Exception;
use App\Http\Resources\V1\ClientsResource;
use App\Http\Resources\V1\ClientsCollection;
use Illuminate\Support\Facades\Hash;

class ClientsController extends Controller
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

            $clients = Clients::paginate($this->maxDataPerPage);

            if ($clients->isEmpty()) {
                throw new Exception("No data found.");
            }

            if ($request->query("includeBusiness") === "true") {
                $clients = Clients::with("business")->paginate($this->maxDataPerPage);
            }

            $data = new ClientsCollection($clients);

            return response()->json(["success" => true, "data" => $data], $this->success);
        } catch (Exception $e) {

            return response()->json(["success" => false, "msg" => "No data found."], $this->notFound);
        }
    }

    public function store(StoreClientsRequest $request)
    {
        try {
            $data = $request->all();
            $data["password"] = Hash::make($request->input("password"));

            $client = new ClientsResource(Clients::create($data));
            return response()->json(["success" => true, "data" => $client], $this->success);
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
            $clients = Clients::findOrFail($id);

            if ($request->query("includeBusiness") === "true") {
                $clients = Clients::with("business")->findOrFail($id);
            }

            $data = new ClientsResource($clients);
            return response()->json(["success" => true, "data" => $data], $this->success);
        } catch (Exception $e) {
            return response()->json(["success" => false, "msg" => "Data not found."], $this->notFound);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientsRequest $request, Clients $client)
    {
        try {
            $data = $request->all();
            if ($request->has("password")) {
                $data["password"] = Hash::make($request->input("password"));
            }
            $client->update($data);

            $client = new ClientsResource($client);

            return response()->json(["success" => true, "data" => $client], $this->success);
        } catch (Exception) {
            return response()->json(["success" => false, "msg" => "There wan an error when inserting the data."], $this->notFound);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Clients $clients)
    {
        //
    }
}
