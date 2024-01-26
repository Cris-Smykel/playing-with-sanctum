<?php

namespace App\Http\Controllers;

use App\Models\V1\Clients;
use App\Http\Requests\StoreClientsRequest;
use App\Http\Requests\UpdateClientsRequest;
use Illuminate\Http\Request;
use \Exception;
use App\Http\Resources\V1\ClientsResource;
use App\Http\Resources\V1\ClientsCollection;

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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClientsRequest $request)
    {
        //
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
     * Show the form for editing the specified resource.
     */
    public function edit(Clients $clients)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientsRequest $request, Clients $clients)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Clients $clients)
    {
        //
    }
}
