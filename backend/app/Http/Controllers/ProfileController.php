<?php

namespace App\Http\Controllers;

use App\Enums\AddressType;
use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Requests\ProfileRequest;
use App\Models\Country;
use App\Models\CustomerAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function view(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();
        /** @var \App\Models\Customer $customer */
        $customer = $user->customer;

        $shippingAddress = $customer->shippingAddress ?: new CustomerAddress(['type' => AddressType::Shipping]);
        $billingAddress = $customer->billingAddress ?: new CustomerAddress(['type' => AddressType::Billing]);
        $countries = Country::query()->orderBy('name')->get();
        return view('profile.view', compact('customer', 'user', 'shippingAddress', 'billingAddress', 'countries'));
    }


    public function store(ProfileRequest $request)
    {
        // $user = $request->user();
        // $customer = $user->customer;

        // $customer->update($request->validated());

        // $customer->shippingAddress->updateOrCreate(['customer_id' => $user->id, 'type' => AddressType::Shipping], $request->input('shipping'));
        // $customer->billingAddress->updateOrCreate(['customer_id' => $user->id, 'type' => AddressType::Billing], $request->input('billing'));

        // $request->session()->flash('flash_message', 'Profile was successfully updated.');

        // return redirect()->route('profile');

        $customerData = $request->validated();
        $shippingData = $customerData['shipping'];
        $billingData = $customerData['billing'];
        /** @var \App\Models\User $user */
        $user = $request->user();
        /** @var \App\Models\Customer $customer */
        $customer = $user->customer;

        DB::beginTransaction();
        try {
            $customer->update($customerData);

            if ($customer->shippingAddress) {
                $customer->shippingAddress->update($shippingData);
            } else {
                $shippingData['customer_id'] = $customer->user_id;
                $shippingData['type'] = AddressType::Shipping->value;
                CustomerAddress::create($shippingData);
            }

            if ($customer->billingAddress) {
                $customer->billingAddress->update($billingData);
            } else {
                $billingData['customer_id'] = $customer->user_id;
                $billingData['type'] = AddressType::Billing->value;
                CustomerAddress::create($billingData);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::critical(__METHOD__ . ' method does not work. ' . $e->getMessage());
            throw $e;
        }

        DB::commit();

        $request->session()->flash('flash_message', 'Profile was successfully updated.');

        return redirect()->route('profile');
    }

    public function passwordUpdate(PasswordUpdateRequest $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        $passwordData = $request->validated();

        $user->password = Hash::make($passwordData['new_password']);
        $user->save();

        $request->session()->flash('flash_message', 'Your password was successfully updated.');

        return redirect()->route('profile');
    }
}