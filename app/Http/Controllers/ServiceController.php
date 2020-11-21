<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    //
	  public function execute() {
		
		
		if(view()->exists('admin.service')) {
			
			$services = \App\Models\Service::all();
			
			$data = [
					
					'title' => 'Сервисы',
					'services' => $services
					
					];
			
			return view('admin.service',$data);		
			
		}
		
		abort(404);
	}
}
