<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lancamento extends Model
{
	protected $fillable = [
		'tag'
	];

	public function tags(){
		return $this->belongsToMany('App\Tag');
	}

    public function saveLancamento(Lancamento $lancamento){
		if(!$lancamento->save()){
			throw new \Exception("Erro ao cadastrar lancamento.");
		}else{
			$lancamento->save();
		}
	}

	public function bindTags($tags, $idLancamento){
		$lancamento = $this->find($idLancamento);
		return $lancamento->tags()->attach($tags);
	}
}
