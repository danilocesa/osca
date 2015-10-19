<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Storage;

class Image extends Model
{
    protected $table = 'ES_IMAGES';
	
	protected $primaryKey = 'model_code';
	
	public $timestamps = false;
	
	protected $fillable = ['model_code', 'image_full_path', 'seq_no', 'filename', 'folder', 'extension', 'color_display_id'];


	public function createImageTag()
	{
		$blob = Storage::get($this->folder . '//' . $this->filename);
		return '<img src="data:image/' . $this->extension . ';base64,' . base64_encode($blob) . '" />';
	}


	
}

