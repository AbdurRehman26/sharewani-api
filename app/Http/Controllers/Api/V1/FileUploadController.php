<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Validator;

class FileUploadController extends Controller
{
	private $uploaderConfig;

	public function __construct()
	{
		$this->uploaderConfig = config('uploader');
	}

	public function remove(Request $request)
	{

		$validator = Validator::make($request->all(), [ 'file_name' => 'required' ]);
		if ($validator->fails()) {
			return response()->json(['error'=>'Required file_name is missing.']);
		}else{

			$key = $request->key;
	
			$config = config("uploads.{$key}");
		
			if (!$key) {

				$config = config("uploads.default");
			
			}

			$orignalFileName = $config['public_relative'] .  '/' . $request->get('file_name');
			$thumbFileName = $config['public_relative'] .  '/' . $request->get('file_name');
			
			if(Storage::exists($orignalFileName)) {
				Storage::delete($orignalFileName);
			}
			if(Storage::exists($thumbFileName)) {
				Storage::delete($thumbFileName);
			}
			return response()->json(['status'=>true,'message'=>'Files has been removed successfully.']);
		}
	}

	public function upload(Request $request)
	{
		$key = $request->key;

		$folderId = request()->user() ? request()->user()->id : null;

		$config = config("uploads.{$key}");

		
		if (!$key) {

			$config = config("uploads.default");
		
		}


		if ($config) {

			$field = isset($config['field']) ? $config['field'] : 'file';

			$this->validate(
				$request, [
					$field => !empty($config['rules']) ? $config['rules'] : [],
				]
			);

			$response = [];

			$file = $request->file($field);

			if($file){
				$file->store($config['folder_name']);
			}
			if(!$file){
				$file = $request->file; 
				$file = str_replace('data:image/png;base64,', '', $file);
				$file = str_replace(' ', '+', $file);
				$imageName = str_random(50).'.'.'png';
				Storage::put($config['folder_name'] . '/' . $imageName, base64_decode($file));

			}

			if (!empty($config['thumb'])) {

				$conf = $this->mergeConfigWithDefault($config['thumb']);

				$manager = new ImageManager(
					[
						'driver' => $conf['driver'],
					]
				);

				$image = $manager->make($file);

				$response['width'] = $image->width();
				$response['height'] = $image->height();

				$method = $conf['method'];

				if ($method instanceof Closure) {
					$method($image, $conf);
				} else {
					switch($method) {
						default:
						$args = [$conf['width'], $conf['height'], null, $conf['anchor']];
						break;
						case 'fit':
						$args = [$conf['width'], $conf['height']];
						$args[] = function ($constraint) {
							$constraint->aspectRatio();
							$constraint->upsize();
						};
						break;
						case 'resize':
						$args = [$conf['width'], $conf['height']];
						$args[] = function ($constraint) {
							$constraint->aspectRatio();
							$constraint->upsize();
						};
						break;
						case 'heighten':
						$args = [$conf['height']];
						break;
						case 'widen':
						$args = [$conf['widen']];
						break;
						case 'resizeCanvas':
						$args = [$conf['width'], $conf['height']];

						if (isset($conf['anchor'])) {
							$args[] = $conf['anchor'];
						}
						break;
					};

					call_user_func_array([$image, $method], $args);
				}
				$thumbImageName = str_random(25);
				
				Storage::put($config['folder_name'] .   '/' .  $thumbImageName, $image->stream()->__toString());

				$response['thumb_name'] = $thumbImageName;
				$response['thumbnail_url'] = Storage::url('storage/'.$config['folder_name'] .  '/' . $thumbImageName);
			}

			$fileHashName = !empty($imageName) ? $imageName : $file->hashName(); 

			$response['name'] = $fileHashName;

			$response['upload_url'] = url('storage/'.$config['public_relative']) .  '/'. $fileHashName;

			return $this->prepareUploadSuccessfulResponse($response, $file);
		}
		abort(404);
	}

	private function mergeConfigWithDefault(array $config)
	{
		return array_merge(
			[
				'anchor' => 'center',
				'driver' => 'imagick',
				'method' => 'resize',
				'anchor' => 'top',
			], $config
		);
	}

	private function prepareUploadSuccessfulResponse(array $response, $file)
	{
		return array_merge(
			$response, [
				'type' => 'upload',
				'success' => true,
				'original_name' => !is_string($file) && !is_null($file) ? $file->getClientOriginalName() : null,
			]
		);
	}
}
