<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Storage;
use File;

class Image extends Model
{
    protected $table = 'ES_IMAGES';
	
	protected $primaryKey = 'model_code';
	
	public $timestamps = false;
	
	protected $fillable = ['model_code', 'image_full_path', 'seq_no', 'filename', 'folder', 'extension', 'color_display_id'];


	public function createImageTag()
	{
		
		$envFolder = substr($this->image_full_path, 0,24);
		$rootPath = substr(base_path(),0,24);
		$contents = File::exists($this->image_full_path);
		//If file exists in the storage path
		if($contents === true){
			//For changing env path
			if($envFolder == $rootPath){
			$blob = Storage::get($this->folder . '//' . $this->filename);
			return '<img src="data:image/' . $this->extension . ';base64,' . base64_encode($blob) . '" />';	
			}
			else{
				return 'No image';	
			}	
		} else{
			return 'No image';
		}
		
		
	}


	
}

