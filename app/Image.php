<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Storage;
use File;
use Request;
use Route;

class Image extends Model
{
    protected $table = 'ES_IMAGES';
	
	protected $primaryKey = 'model_code';
	
	public $timestamps = false;
	
	protected $fillable = ['model_code', 'image_full_path', 'seq_no', 'filename', 'folder', 'extension', 'color_display_id'];



	public function createImageTag()
	{
		
		$dbPath = substr($this->image_full_path, 0,24);
		$rootPath = substr(base_path(),0,24);
		$contents = File::exists($this->image_full_path);
		$editPath = str_contains(Route::current()->uri(),'edit');
		// dump(substr($this->image_full_path, 18,-4));
		// dump($this->folder . '//' . $this->filename);

		//If file exists in the storage path
		if($contents === true){
		//For changing env path
			if($dbPath === $rootPath){
				$blob = Storage::get($this->folder . '//' . $this->filename);
				return '<img src="data:image/' . $this->extension . ';base64,' . base64_encode($blob) . '" />';	
			}
			else{
				// If product listing
				if($editPath === false){
					return 'No image';
				}
				else{

					//Just for display images in the dev env
					return '<img src="'. substr($this->image_full_path, 17) . '" />';		
				}
			}	
		}else{
			return 'No image';	
		}
		
		
		
	}


	
}

