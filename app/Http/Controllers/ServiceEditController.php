<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Validator;

class ServiceEditController extends Controller
{
    //
	public function execute(Service $service, Request $request) {
	
			/*$service = service::find($id);*/
		
		if($request->isMethod('delete')) {
			$service->delete();
			return redirect('admin')->with('status','Сервис удален');
		}
		
		
		if($request->isMethod('post')) {
			
			
			$input = $request->except('_token');
			
			$messages = [
			
				'required'=>'Поле :attribute обязательно к заполнению',
				'unique'=>'Поле :attribute должно быть уникальным'
			
			];
			
			$validator = Validator::make($input,[
			
				'name' => 'required|max:255',
				'text' => 'required|max:255',
			
			], $messages);
			
			if($validator->fails()) {
				return redirect()
						->route('serviceEdit',['service'=>$input['id']])
						->withErrors($validator);
			}
			
			$service->fill($input);
			
			if($service->update()) {
				return redirect('admin')->with('status',' Сервис обновлен');
			}
			
		}

		
		$old = $service->toArray();
		if(view()->exists('admin.services_edit')) {
			
			$data = [
					'title' => 'Редактирование сервиса - '.$old['name'],
					'data' => $old
					];
			return view('admin.services_edit',$data);		
			
		}
	}
}
