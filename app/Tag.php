<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Tag extends Model
{
	protected $fillable = [
		'descricao', 'lancamento'
	];

	//esse método faz o vínculo de n:n e já é padrão do Laravel
	public function lancamento(){
		return $this->belongsToMany('App\Lancamento');
	}

	//esse método verifica se existe o registro com base no ID. Vai servir para verificações em outros métodos e tem o objetivo de fazer reaproveitamento de código
	public function verifyIfExists($id){
		if(!$this->find($id)){
			throw new \Exception('Tag não encontrada.');
		}else{
			return $this->find($id);
		}
	}    
	public function saveTag(Tag $tag){
		if(!$tag->save()){
			throw new \Exception("Erro ao cadastrar tag.");
		}else{
			$tag->save();
		}
	}
	public function updateTag($params, $id){
		$tag = $this->verifyIfExists($id);
		if(!$tag->update($params)){
			throw new \Exception('Erro ao alterar tag.');
		}else{
			$tag->update($params);
		}
	}
	public function deleteTag($id){
		$tag = $this->verifyIfExists($id);
		if(!$tag->delete()){
			throw new \Exception('Erro ao excluir tag.');
		}else{
			$tag->delete();
		}
	}
	public function list($id){
		$tag = $this->verifyIfExists($id);
		$tag->lancamento;
		return $tag;
	}

	//esse método tem como principal diferença, além de listar todos as tags e os lançamentos vinculados a cada uma, o retorno personalizado com a chave 'message-warning' no controller. Isso permite que o tratamento na view seja mais flexível visto que não retornar tags não é um erro necessariamente. 
	public function listAll(){
		if(!$this->all()){
			throw new \Exception('Erro ao listar tags.');
		}else if($this->all()->isEmpty()){
			throw new ModelNotFoundException('Nenhuma tag encontrada.');
		}else{
			$tags = $this->all();
			foreach ($tags as $tag) {
				$tag->lancamento = $tag->lancamento;
			}
			return $tags;
		}
	}

}
