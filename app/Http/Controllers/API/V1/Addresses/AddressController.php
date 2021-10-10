<?php

namespace App\Http\Controllers\API\V1\Addresses;

use App\Exceptions\API\V1\AddressException;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\AddressShowRequest;
use App\Http\Requests\API\V1\AddressStoreRequest;
use App\Http\Requests\API\V1\AddressUpdateRequest;
use App\Models\Address;
use App\Models\Merchant;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use mysql_xdevapi\Exception;

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
            DB::beginTransaction();

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
            if (empty($modelInstance)) {
                throw new AddressException(__("messages.model_not_found"), 404);
            }

            //get address data from request
            $data = $request->only([
                "country",
                "state",
                "city",
                "address",
                "postal_code",
            ]);

            //create address
            $addressInstance = new Address($data);

            //check address is created or not
            if (!$addressInstance instanceof Address) {
                throw new AddressException(__("messages.something_went_wrong"), 400);
            }

            //assign address to model
            $modelInstance->addresses()->save($addressInstance);
            DB::commit();

            //return success response
            return $this->successResponse(__("messages.address_added_successfully"), [$modelInstance], 201);
        } catch (\Exception $exception) {
            DB::rollBack();
            throw($exception);
        }
    }

    public function show($id)
    {
        try {
            //find address instance
            $addressInstance = Address::query()
                ->where("id", $id)
                ->first();

            if (!$addressInstance instanceof Address) {
                throw new AddressException(__("messages.address_not_found"), 404);
            }

            //return response with address instance
            return $this->successResponse(__("messages.address_information"), [$addressInstance]);
        } catch (\Throwable $exception) {
            throw($exception);
        }
    }

    public function update(AddressUpdateRequest $request, $id)
    {
        try {
            //update address
            $rowEfect = Address::query()
                ->where("id", $id)
                ->update($request->all());

            //check update is happened
            if ($rowEfect == 0) {
                throw new AddressException(__("messages.something_went_wrong"), 400);
            }

            //return success response
            return $this->successResponse(__("messages.address_successfully_update"), [], 202);
        } catch (\Throwable $exception) {
            throw($exception);
        }
    }

    public function destroy($id)
    {
        //validate request input
        Validator::make(
            \request("id"),
            ["id" => "required|exists:addresses,id"]
        );

        //delete address instance
        Address::query()
            ->where("id", $id)
            ->delete();

        //return response with address instance
        return $this->successResponse(__("messages.address_deleted_successfully"), [], 204);
    }
}
