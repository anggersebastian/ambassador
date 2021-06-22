<?php

namespace App\Landing;

class LandingRepository{
    public function findLandingProduct($id = null){
        return LandingProduct::with([])->find($id);
    }

    public function getLandingProducts($filters = []){
        $data = LandingProduct::with([]);
        return $data->orderBy('id','desc')->paginate(25);
    }

    public function preSaveLanding($id, $userId, $inputs = []){
        $data = $this->findLandingProduct($id);
        if(!$data){
            $data   = new LandingProduct();
        }else{
            if($data->user_id <> $userId){
                return [
                    'status'    => false,
                    'message'   => "Landing page tidak dapat disimpan"
                ];
            }
        }

        $data->title    = $inputs['title'];
        $data->slug     = str_slug($inputs['title']) . '-' . date("H-i-s");

        $data->user_id  = $userId;
        $data->save();

        return [
            'status'    => true,
            'data'      => $data
        ];

    }

    public function saveLandingProduct($id, $userId, $inputs = [],  $html = '', $css = ''){
        $data = $this->findLandingProduct($id);
        if(!$data){
            return [
                'status'    => false,
                'message'   => "Anda harus membuat Landing page dahulu"
            ];
        }

        if($data->user_id <> $userId){
            return [
                'status'    => false,
                'message'   => "Landing page tidak dapat disimpan"
            ];
        }

        $data->product_id = !empty($inputs['product_id']) ? $inputs['product_id'] : null;
        if(!$data->slug){
            $data->slug = !empty($inputs['title']) ? str_slug($inputs['title']) : date('Y-m-d-H-i-s');
        }

        if(!empty($inputs['title'])){
            $data->title            = $inputs['title'];
        }
        $data->form_generator   = !empty($inputs['form_generator']) ? $inputs['form_generator'] : '';

        $data->html_content = $html;
        $data->css_content  = $css;
        $data->save();

        return [
            'status'    => true,
            'message'   => "Landing page berhasil disimpan"
        ];
    }
}