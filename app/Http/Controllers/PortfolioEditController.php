<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Portfolio;
use Validator;

class PortfolioEditController extends Controller
{
    //
	public function execute(Portfolio $portfolio, Request $request) {
	
			/*$portfolio = portfolio::find($id);*/
		
		if($request->isMethod('delete')) {
			$portfolio->delete();
			return redirect('boss')->with('status','Портфолио удалена');
		}
		
		
		if($request->isMethod('post')) {
			
			
			$input = $request->except('_token');
			
			$messages = [
			
				'required'=>'Поле :attribute обязательно к заполнению',
				'unique'=>'Поле :attribute должно быть уникальным'
			
			];
			
			$validator = Validator::make($input,[
			
				'name' => 'required|max:255',
				'filter' => 'required|unique:portfolios|max:255',
			
			], $messages);
			
			if($validator->fails()) {
				return redirect()
						->route('portfolioEdit',['portfolio'=>$input['id']])
						->withErrors($validator);
			}
			
			if($request->hasFile('images')) {
				$file = $request->file('images');
				$file->move(public_path().'/assets/img',$file->getClientOriginalName());
				$input['images'] = $file->getClientOriginalName();
			}
			else {
				$input['images'] = $input['old_images'];
			}
			
			unset($input['old_images']);
			
			$portfolio->fill($input);
			
			if($portfolio->update()) {
				return redirect('boss')->with('status','Портфолио обновлено');
			}
			
		}

		
		$old = $portfolio->toArray();
		if(view()->exists('admin.portfolios_edit')) {
			
			$data = [
					'title' => 'Редактирование портфоилио - '.$old['name'],
					'data' => $old
					];
			return view('admin.portfolios_edit',$data);		
			
		}
	}
}
