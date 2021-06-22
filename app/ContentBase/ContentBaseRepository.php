<?php

namespace App\ContentBase;

use App\AwsSdk\S3Service;

class ContentBaseRepository{
    public function getContentBases($filters = []){
        $data   = ContentBase::with([]);
        $data   = $data->orderBy('id','desc');
        if(!empty($filters['page'])){
            $data   = $data->limit(25)->offset($filters['page'])
                ->get();

            return $data;
        }
        $data   = $data->paginate(25);

        return $data;
    }

    public function findContentBase($id = null){
        return ContentBase::with([])->find($id);
    }

    public function saveContentBase($id = null, $inputs = []){
        $data       = $this->findContentBase($id);
        if(!$data){
            $data                           = new Map();
        }
        $data->title                    = $inputs['title'];
        $data->short_description        = $inputs['short_description'];
        $data->description              = $inputs['description'];

        $data->save();

        return $data;
    }

    public function deleteContentBase($id = null){
        $data    = $this->findContentBase($id);
        if(!$data){
            return false;
        }

        $data->delete();
        return true;
    }
}