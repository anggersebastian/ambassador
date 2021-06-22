<?php

namespace App\Http\Controllers\Backend\Landing;

use App\AwsSdk\S3Service;
use App\Landing\LandingRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class LandingController extends Controller
{
    protected $landing;

    public function __construct(LandingRepository $landing)
    {
        $this->landing  = $landing;
    }

    public function indexLanding(Request $request)
    {
        $filters    = $request->all();
        $landings   = $this->landing->getLandingProducts($filters);

        return view('backend.landing.index', compact('landings'));
    }

    public function formLanding($id = null, Request $request){
        $landing    = $this->landing->findLandingProduct($id);

        return view('backend.landing.form-landing', compact('landing'));
    }

    public function formPreSave($id = null, Request $request){
        if(!\Sentinel::check()){
            alertNotify(false, "You dont have permission", $request);
            return redirect()->back();
        }
        $landing    = $this->landing->preSaveLanding($id,\Sentinel::check()->id, $request->all());
        alertNotify(true, "Landing Saved", $request);

        return redirect(url('backend/landing'));
    }

    public function builderLanding($id = null, Request $request){
        $landing    = $this->landing->findLandingProduct($id);

        $storage    = $request->get('storage', '');
        if($storage <> 'clear'){
            return view('backend.landing.clear-storage', compact('landing'));
        }

        return view('backend.landing.grape', compact('landing'));
    }

    public function previewLanding($id = null, Request $request){
        $landing    = $this->landing->findLandingProduct($id);

        return view('backend.landing.preview', compact('landing'));
    }

    public function uploadAsset(Request $request){
        if(!\Sentinel::check()){
            return response()->json([
                'status'    => false,
                'message'   => "you need to login to complete these upload"
            ]);
        }

        if($request->hasFile('files')){
            $s3             = new S3Service();
            $imagePacking   = $request->file('files')[0];

            $fileName       = $imagePacking->getClientOriginalName();

            if($imagePacking->getClientOriginalName() == 'blob' AND in_array($imagePacking->getMimeType(), ['image/png','image/jpg','image/jpeg', 'image/gif'])){
                switch ($imagePacking->getMimeType()){
                    case 'image/png':
                        $mime   = '.png';
                        break;
                    case 'image/jpg':
                        $mime   = '.jpg';
                        break;
                    case 'image/jpeg':
                        $mime   = '.jpeg';
                        break;
                    case 'image/gif':
                        $mime   = '.gif';
                        break;
                    default:
                        $mime   = '.jpeg';
                        break;
                }

                $fileName   = \Sentinel::check()->id . date('-Y_m_d-H_i_s'). $mime;
            }


            try{
                $uploadFile  = $s3->putObject($imagePacking, $fileName, $imagePacking->getMimeType(),'landing/' . \Sentinel::check()->id);
            }catch (\Exception $exception){
                $uploadFile  = $exception->getMessage();

                return response()->json([
                    'status'    => false,
                    'message'   => $uploadFile
                ]);
            }

            return response()->json([
                'status'        => true,
                'image'         => $uploadFile['full_link']
            ]);
        }

        return response()->json([
            'status'    => false,
            'image'     => '',
            'message'   => "No image"
        ]);
    }

    public function listObjectAssets(Request $request){
        if(!\Sentinel::check()){
            return response()->json([
                'status'    => false,
                'message'   => "you need to login to complete these upload"
            ]);
        }
        $aws    = new S3Service();
        $object = $aws->listObject('landing/' . \Sentinel::check()->id);

        if($object['status'] == false){
            return response()->json($object);
        }

        $results    = [];
        if(!empty($object['data'])){
            foreach ($object['data'] as $datum){
                $results[]  = env('CDN_URL') . $datum['Key'];
            }
        }

        return response()->json([
            'status'    => true,
            'files'     => $results
        ]);
    }

    public function save(Request $request){
        $id     = $request->get('id');
        $userId = $request->get('user_id');
        $html   = $request->get('html');
        $css    = $request->get('css');

        $landing    = $this->landing->saveLandingProduct($id, $userId, [], $html, $css);

        return response()->json($landing);
    }

    public function deleteLanding($id = null, Request $request){

    }
}