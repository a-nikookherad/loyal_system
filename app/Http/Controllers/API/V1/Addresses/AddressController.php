<?php

namespace App\Http\Controllers\API\V1\Addresses;

use App\Exceptions\API\V1\AddressException;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\AddressStoreRequest;
use App\Models\Address;
use App\Models\Merchant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    public function index()
    {
        $addressCollection = Address::query()
            ->paginate(\request("per_page") ?? 10);
        return $this->successResponse("all_addresses", [$addressCollection]);
    }

    public function store(AddressStoreRequest $request)
    {
        try {
            //get address data from request
            $data = $request->only([
                "country",
                "state",
                "city",
                "address",
                "postal_code",
            ]);

            DB::beginTransaction();
            //insert address
            $addressInstance = Address::query()
                ->create($data);

            if (!$addressInstance instanceof Address) {
                throw new AddressException(__("messages.something_went_wrong"), 400);
            }

            //get model instance
            if (empty($request->type)) {
                $modelInstance = Auth::user();
            } elseif ($request->type == "user") {
                $modelInstance = User::query()
                    ->with("addresses")
                    ->find($request->model_id);
            } elseif ($request->type == "merchant") {
                $modelInstance = Merchant::query()
                    ->with("addresses")
                    ->find($request->model_id);
            }

            //check model is exist
            if ($modelInstance->isEmpty()) {
                throw new AddressException(__("messages.model_not_found"), 404);
            }

            //assign address to model
            $modelInstance->addresses()->attach($addressInstance->id);
            DB::commit();

            return $this->successResponse("address_added_successfully", [$modelInstance], 201);
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->errorResponse($exception->getMessage());
        }
    }

    public function show($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
