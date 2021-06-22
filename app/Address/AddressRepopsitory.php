<?php
namespace App\Address;

class AddressRepopsitory{

    public function findAddress($key)
    {

        $address = District::with(['city', 'city.province'])
                ->where('name', 'like', '%' . $key . '%')
                ->orWhereHas('city', function($q)use($key){
                    $q->where('name', 'like' , '%'. $key .'%');
                })
                ->get();
        $result = [];
        foreach($address as $key=>$value){
            $label = $value->city->province->name. ','. $value->city->name. ','.$value->name;
            array_push($result, [
                'name' => $label,
                'id'=> $value->id,
                'postal' => $value->city->postal_code
            ]);
        }
        
        return $result;
    }

    public function allProvince()
    {
        $province = Province::get();
        return $province;
    }

    public function getCityByProvince($province)
    {
        $city = City::where('province_id', $province)->get();
        return $city;
    }

    public function getDistrictByCity($city)
    {
        $district = District::where('city_id', $city)->get();
        return $district;
    }

}