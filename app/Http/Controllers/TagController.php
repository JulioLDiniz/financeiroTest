<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TagController extends Controller
{
	public function create(Request $request){
		try{
			$tag = new Tag();
			$tag->descricao = $request->input('descricao');
			$tag->saveTag($tag);

			//o trecho abaixo está preparado para caso queira que seja vinulado lancamento também por tags.
			//$tag->lancamento()->attach($request->input('lancamento_id'));			
			return response()->json(['message-success'=>'Tag cadastrada com sucesso.']);
		}catch(\Exception $e){
			return response()->json(['message-error'=>$e->getMessage()]);
		}
	}
	public function update(Request $request, $id){
		try{
			$tag = new Tag();
			$tag->updateTag($request->all(), $id);
			return response()->json(['message-success'=>'Tag alterada com sucesso.']);
		}catch(\Exception $e){
			return response()->json(['message-error'=>$e->getMessage()]);
		}
	}
	public function delete($id){
		try{
			$tag = new Tag();
			$tag->deleteTag($id);
			return response()->json(['message-success'=>'Tag excluída com sucesso.']);
		}catch(\Exception $e){
			return response()->json(['message-error'=>$e->getMessage()]);
		}
	}
	public function listOne($id){
		try{
			$tag = new Tag();
			$tag = $tag->list($id);
			return response()->json($tag);
		}catch(\Exception $e){
			return response()->json(['message-error'=>$e->getMessage()]);
		}
	}
	public function listAll(){
		try{
			$tags = new Tag();
			$tags = $tags->listAll();
			return response()->json($tags);
		}
		catch(ModelNotFoundException $me){
			return response()->json(['message-warning'=>$me->getMessage()]);
		}catch(\Exception $e){
			return response()->json(['message-error'=>$e->getMessage()]);
		}
	}
}
