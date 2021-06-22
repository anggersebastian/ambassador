<?php
namespace App\AwsSdk;

use Aws;
class S3Service{
    protected $s3, $bucket;
    public function __construct() {
        $this->s3 = new Aws\S3\S3Client([
            'version' => 'latest',
            'region'  => 'ap-southeast-1',
            'debug'   => false,
            'credentials' => [
                'key'    => env('AWS_KEY_ID', false),
                'secret' => env('AWS_ACCESS_KEY', false)
            ]
        ]);

        $this->bucket   = env('AWS_BUCKET','');
    }

    public function getObject($name = 'no-images.png', $source = 'images-grebe'){
        $fullDir    = $source . '/' . $name;
        $props  = [
            'Key'       => $fullDir,
            'Bucket'    => $this->bucket
        ];

        try{
            $objects    = $this->s3->getObject($props);
            $result     = $objects['Body'];

            header("Content-Type: {$objects['ContentType']}");
        }catch (Aws\S3\Exception\S3Exception $exception){
            $result = false;
        }

        return $result;
    }

    public function putObject($fileObject, $name = 'no-name.jpg', $getMime = "image/jpeg", $source = '', $multiple = false){
        $arr    = explode(".", $name);
        if(count($arr) < 2){
            return false;
        }

        if(!$multiple){
            $name   = str_slug($arr[0]) . '-' . date("Y_m_d_H_i_s") . '.' . $arr[1];
        }

        if(!$source){
            $source = 'images-grebe' . '/' . date("Y_m_d");
        }

        $props  = [
            'Bucket'        => $this->bucket,
            'Key'           => $source . '/' . $name,
            'SourceFile'    => $fileObject,
            'ContentType'   => $getMime,
            'ACL'           => 'public-read'
        ];

        $config = '';
        try{
            $config = $this->s3->putObject($props);
            $result = [
                'name'      => $name,
                'source'    => $source,
                'full_link' => env('CDN_URL') . $source . '/' . $name
            ];
        }catch(Aws\S3\Exception\S3Exception $exception){
            $result = false;
        }

        return $result;
    }

    public function listObject($prefix = '')
    {
        try {
            $objects = $this->s3->listObjects(array(
                "Bucket" => $this->bucket,
                "Prefix" => $prefix,
            ));
            $files      = $objects->getPath('Contents');
            return[
                'status' => true,
                'data'   => $files
            ];
        } catch (\Exception $th) {
            return [
                'status' => false,
                'data' => $th->getMessage()
            ];
        }
    }
}