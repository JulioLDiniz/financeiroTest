<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lancamento extends Model
{
    public function saveLancamento(Lancamento $lancamento){
		if(!$lancamento->save()){
			throw new \Exception("Erro ao cadastrar lancamento.");
		}else{
			$lancamento->save();
		}
	}
}
