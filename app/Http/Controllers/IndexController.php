<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\Service;
use App\Models\Portfolio;
use App\Models\People;
use Mail;
use DB;
use App\Mail\TestMail;

class IndexController extends Controller
{
    //
    public function execute(Request $request) {
	
	    	if($request->isMethod('post')) {
			
			$messages = [
			
			'required' => "Поле :attribute обязательно к заполнению",
			'email' => "Поле :attribute должно соответствовать email адресу"
			
			];
			
			$request->validate([
			
			'name' => 'required|max:255',
			'email' => 'required|email',
			'text' => 'required'	
					
			], $messages);
						
			$data = $request->all();
			//dilshodkhudayarov@gmail.com
    	    Mail::to('dilshodkhudayarov@gmail.com')->send(new TestMail($data));
			return redirect()->route('home')->with('status', 'Email успешно отправлен!');	
		}
    	
    	$pages = Page::all();
    	$portfolios = Portfolio::get(array('name','filter','images'));
    	$services = Service::where('id','<',20)->get();
    	$people = People::take(3)->get();
		
		$tags = DB::table('portfolios')->distinct()->pluck('filter');

    	
    	$menu = array();
    	foreach($pages as $page) {
			$item = array('title' =>$page->name,'alias'=>$page->alias);
			array_push($menu,$item);
		}
		
		$item = array('title'=>'Services','alias'=>'service');
		array_push($menu,$item);
		
		$item = array('title'=>'Portfolio','alias'=>'Portfolio');
		array_push($menu,$item);
		
		$item = array('title'=>'Team','alias'=>'team');
		array_push($menu,$item);
		
		$item = array('title'=>'Contact','alias'=>'contact');
		array_push($menu,$item);
		
		return view('site.index',array(
									
									'menu'=> $menu,
									'pages' => $pages,
									'services' => $services,
									'portfolios' => $portfolios,
									'people' => $people,
									'tags'=>$tags
									));
	}
}
