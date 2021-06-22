<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Address\AddressRepopsitory;

class AddressController extends Controller
{
    private $address;

    public function __construct(AddressRepopsitory $address)
    {
        $this->address = $address;
    }

    public function index(Request $request)
    {
        $key = $request->get('key');
        $address = $this->address->findAddress($key);
        return response()->json([
            'status' => true,
            'data' => $address
        ]);
    }

    public function ongkir(Request $request)
    {
        $destination = $request->get('destination');
        $weight = $request->get('weight');
        $ongkir = \App\RajaOngkir\RajaOngkir::getOngkir($weight, $destination);
        return response()->json($ongkir);
    }

    public function province()
    {
        $province = $this->address->allProvince();

        return response()->json([
            'status' => true,
            'data' => $province
        ]);
    }

    public function city($province)
    {
        $city = $this->address->getCityByProvince($province);
        return response()->json([
            'status' => true,
            'data' => $city
        ]);
    }

    public function district($city)
    {
        $district = $this->address->getDistrictByCity($city);
        return response()->json([
            'status' => true,
            'data' => $district
        ]);
    }


}
