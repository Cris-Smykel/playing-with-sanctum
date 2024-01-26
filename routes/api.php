<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusinessesController;
use App\Http\Controllers\ClientsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\V1\Businesses;
use App\Models\V1\Clients;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(["prefix" => "v1"], function () {

    Route::apiResource("businesses", BusinessesController::class)->middleware("auth:sanctum");

    Route::post("/businesses/login", function () {

        $credentials = [
            "email" => "my243542433dfgdfge0@gmail.com",
            "password" => "testing0000",
        ];

        // Check if the user already exists
        $business = Businesses::where('email', $credentials['email'])->first();

        if (!$business) {
            // If the user does not exist, create a new user
            $business = new Businesses();
            $business->name = "my business";
            $business->email = $credentials["email"];
            $business->password = Hash::make($credentials["password"]);
            $business->save();
        }

        // Create a personal access token for the user
        $businessAdminToken = $business->createToken("business_admin", ["create", "update", "delete"])->plainTextToken;
        $businessUpdateToken = $business->createToken("business_update", ["create", "update"])->plainTextToken;
        $businessBasicToken = $business->createToken("business_basic", ["none"])->plainTextToken;

        return [
            "success" => true,
            "token" => [
                "businessAdminToken" => $businessAdminToken,
                "businessUpdateToken" => $businessUpdateToken,
                "businessBasicToken" => $businessBasicToken,
            ],
            "user" => $business,
        ];

        // $credentials = [
        //     "email" => "my22433dfgdfge0@gmail.com",
        //     "password" => "testing0000",
        // ];

        // // Check if the user already exists
        // $business = Businesses::where('email', $credentials['email'])->first();

        // if (!$business) {
        //     // If the user does not exist, create a new user
        //     $business = new Businesses();
        //     $business->name = "my business";
        //     $business->email = $credentials["email"];
        //     $business->password = Hash::make($credentials["password"]);
        //     $business->save();
        // }

        // // Attempt to log in the user
        // if (Auth::guard("business")->attempt($credentials)) {
        //     Auth::guard("business")->login($business);

        //     $businessUser = Auth::guard("business")->user();

        //     $businessAdminToken = $business->createToken("business_admin", ["create", "update", "delete"])->plainTextToken;
        //     $businessUpdateToken = $business->createToken("business_update", ["create", "update"])->plainTextToken;
        //     $businessBasicToken = $business->createToken("business_basic", ["none"])->plainTextToken;

        //     return [
        //         "success" => true,
        //         "token" => [
        //             "businessAdminToken" => $businessAdminToken,
        //             "businessUpdateToken" => $businessUpdateToken,
        //             "businessBasicToken" => $businessBasicToken,
        //         ],
        //         "user" => $businessUser,
        //     ];
        // }

        // // If login attempt fails, return an error response
        // return [
        //     "success" => false,
        //     "message" => "Invalid credentials",
        // ];

        // $credentials = [
        //     "email" => "my22e3343343443m431gfgail10@gmail.com",
        //     "password" => "testing0000",
        // ];

        // if (!Auth::guard("business")->attempt($credentials)) {
        //     $business = new Businesses();
        //     $business->name = "my business";
        //     $business->email = $credentials["email"];
        //     $business->password = Hash::make($credentials["password"]);
        //     $business->save();


        //     if (Auth::guard("business")->attempt($credentials)) {
        //         Auth::guard("business")->login($business);

        //         $businessUser = Auth::guard("business")->user();

        //         $businessAdminToken = $business->createToken("business_admin", ["create", "update", "delete"])->plainTextToken;
        //         $businessUpdateToken = $business->createToken("business_update", ["create", "update"])->plainTextToken;
        //         $businessBasicToken = $business->createToken("business_basic", ["none"])->plainTextToken;

        //         return [
        //             "success" => true,
        //             "token" => [
        //                 "businessAdminToken" => $businessAdminToken,
        //                 "businessUpdateToken" => $businessUpdateToken,
        //                 "businessBasicToken" => $businessBasicToken,
        //             ],

        //             "user" => $businessUser,
        //         ];
        //     }
        // }

        // $credentials = [
        //     "email" => "testing50@gmail.com",
        //     "password" => "testing0000",
        // ];

        // if (!Auth::attempt($credentials)) {
        //     $user = new User();

        //     $user->name = "Admin";
        //     $user->email = $credentials["email"];
        //     $user->password = Hash::make($credentials["password"]);
        //     $user->save();

        //     $adminToken = $user->createToken("admin", ["create", "update", "delete"])->plainTextToken;
        //     $updateToken = $user->createToken("update", ["create", "update"])->plainTextToken;
        //     $basicToken = $user->createToken("basic", ["none"])->plainTextToken;

        //     if (Auth::attempt($credentials)) {
        //         $user = Auth::user();
        //         return [
        //             "success" => true,
        //             "tokens" => [
        //                 "admin" => $adminToken,
        //                 "updateToken" => $updateToken,
        //                 "basicToken" => $basicToken,
        //             ]
        //         ];
        //     }
        // }
    });

    Route::apiResource("clients", ClientsController::class)->middleware("auth:sanctum");

    Route::post("/clients/login", function () {

        $credentials = [
            "email" => "my22433dfgdfge0@gmail.com",
            "password" => "testing0000",
        ];

        // Check if the user already exists
        $client = Clients::where('email', $credentials['email'])->first();

        if (!$client) {
            // If the user does not exist, create a new user
            $client = new Clients();
            $client->name = "my client";
            $client->email = $credentials["email"];
            $client->password = Hash::make($credentials["password"]);
            $client->save();
        }

        // Create a personal access token for the user
        $clientAdminToken = $client->createToken("client_admin", ["create", "update", "delete"])->plainTextToken;
        $clientUpdateToken = $client->createToken("client_update", ["create", "update"])->plainTextToken;
        $clientBasicToken = $client->createToken("client_basic", ["none"])->plainTextToken;

        return [
            "success" => true,
            "token" => [
                "clientAdminToken" => $clientAdminToken,
                "clientUpdateToken" => $clientUpdateToken,
                "clientBasicToken" => $clientBasicToken,
            ],
            "user" => $client,
        ];


        //     $credentials = [
        //         "email" => "my22433dfgdfge0@gmail.com",
        //         "password" => "testing0000",
        //     ];

        //     // Check if the user already exists
        //     $client = Clients::where('email', $credentials['email'])->first();

        //     if (!$client) {
        //         // If the user does not exist, create a new user
        //         $client = new Clients();
        //         $client->name = "my client";
        //         $client->email = $credentials["email"];
        //         $client->password = Hash::make($credentials["password"]);
        //         $client->business_id = 1;
        //         $client->save();
        //     }

        //     // Attempt to log in the user
        //     if (Auth::guard("client")->attempt($credentials)) {
        //         Auth::guard("client")->login($client);

        //         $clientUser = Auth::guard("client")->user();

        //         $clientAdminToken = $client->createToken("client_admin", ["create", "update", "delete"])->plainTextToken;
        //         $clientUpdateToken = $client->createToken("client_update", ["create", "update"])->plainTextToken;
        //         $clientBasicToken = $client->createToken("client_basic", ["none"])->plainTextToken;

        //         return [
        //             "success" => true,
        //             "token" => [
        //                 "clientAdminToken" => $clientAdminToken,
        //                 "clientUpdateToken" => $clientUpdateToken,
        //                 "clientBasicToken" => $clientBasicToken,
        //             ],
        //             "user" => $clientUser,
        //         ];
        //     }
        //     return [
        //         "success" => false,
        //         "message" => "Invalid credentials",
        //     ];
    });
});
