<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/test', function () {
	// $books = App\User::find(1)->permissions;
	// dd($books );
	// $books = App\Country::with('users.posts')->get();
	// foreach($books as $value){
	// 	$a = $value->users;

	// 	foreach($a as $item){
	// 		dd($item->posts);
	// 	}

	// }

	$books = App\User::with('roles.permissions')->where('id',1)->get();
	foreach($books as $values){
		
		foreach($values->roles as $item){
			dd($item->permissions->pluck('name'));
		}
	}
	
	
	// foreach ($books as $book) {
	// 	dd($book->roles->pluck('name'));
	// }
	// $books = App\User::load('roles')->get();
	// dd($books->load('roles'));	

	$a = App\Country::find(2);
	
	// foreach($a->posts as $post){
	// 	echo $post->title;
	// }

	$a = App\Country::find(2);
	$b = App\Country::has('users')->get();

	$c = App\Country::whereHas('users',function($query){
		$query->whereHas('posts',function($query){
			$query->where('title','post3');
		});
	});

	// $d = App\User::whereHas('roles',function($query){
	// 	$query->whereHas('permissions',function($query){
	// 		$query->where('title','post3');
	// 	});
	// });
	$e = App\User::whereHas('roles',function($query){
		$query->where('name','role1');
	})->get();
	$f = App\User::withCount('roles')->get();
	foreach ($f as $post) {
		echo $post->comments_count;
	}
	// $posts = App\User::doesntHave('roles')->get();
	// dd($posts);

	$posts = App\Role::withCount(['users', 'permissions' => function ($query) {
		$query->where('name', 'role1');
	}])->get();
	dd($posts);

});




Route::get('/product', function () {
	$product = new App\Models\Product;
	$product->name = 'Laravel Book';
	$product->description = 'Clear Explanation about laravel routing';
	$product->save();

// Store Notes for Product
	$note = new App\Models\Note(['notes' => 'I love this product']);
	$product->notes()->save($note);

// Store Photo
	$photo = new App\Models\Photo;
	$photo->path = '/image.png';
	$photo->save();

// Store Notes for Photo
	$note = new App\Models\Note(['notes' => 'Perfect Click']);
	$photo->notes()->save($note);
});


Route::get('/list', function () {
	$product = App\Models\Product::find(2);
	echo $product->notes;	
	$photo = App\Models\Photo::find(1);
	echo $photo->notes;
});





Route::get('/', function () {
	return view('welcome');
});

// Route::get('save/{princess}', function ($princess) {
// 	return "Sorry, {$princess} is in another castle. :(";
// });

Route::get('save/{princess}', function ($princess) {
	return "Sorry, {$princess} is in another castle. :(";
})->where('princess', '[A-Za-z]+');

Route::get('save/{princess}/{unicorn}', function ($princess, $unicorn) {
	return "{$princess} loves {$unicorn}";
})->where('princess', '[A-Za-z]+')
->where('unicorn', '[0-9]+');


Route::group(['prefix' => 'books'], function () {
// First Route =>/books/first
	Route::get('/first', function () {
		return 'The Colour of Magic';
	});
 // Second Route
	Route::get('/second', function () {
		return 'Reaper Man';
	});
 // Third Route
	Route::get('/third', function () {
		return 'Lords and Ladies';
	});
});

// ko được
Route::group(['domain' => 'myapp.dev'], function () {
	Route::get('my/route', function () {
		return 'Hello from myapp.dev!';
	});
});

Route::group(['domain' => 'another.myapp.dev'], function () {
	Route::get('my/route', function () {
		return 'Hello from another.myapp.dev!';
	});
});

Route::group(['domain' => 'third.myapp.dev'], function () {
	Route::get('my/route', function () {
		return 'Hello from third.myapp.dev!';
	});
});


// 20.Eloquent ORM_216
Route::get('/', function() {
	$game = new \App\Game;
	$game->name = 'Assassins Creed';
	$game->description = 'Assassins VS templars.';
	$game->save();
});


Route::get('/a', function() {
	$game = \App\Game::find(1);
	return $game->name;
});
Route::get('/create', function() {
	// $game = new \App\Game;
	// $game->name = 'Assassins Creed';
	// $game->description = 'Show them what for, Altair.';
	// $game->save();

	// $game = new \App\Game;
	// $game->name = 'Assassins Creed 2';
	// $game->description = 'Requiescat in pace, Ezio.';
	// $game->save();

	// $game = new \App\Game;
	// $game->name = 'Assassins Creed 3';
	// $game->description = 'Break some faces, Connor.';
	// $game->save();

	$array = [
	[
	'name'=>'name1',
	'description' =>'description1'
	],
	[
	'name'=>'name2',
	'description' =>'description1'
	],
	[
	'name'=>'name3',
	'description' =>'description1'
	]
	];
	$array1 = [
	'name'=>'name3',
	'description' =>'description1'
	];

	foreach ($array as $key => $value) {
		$value['created_at'] =new \DateTime();
		$value['updated_at'] =new \DateTime();
		$user = \App\Game::insert($value);
	}
	// $game = new \App\Game;
	// $game->create($array);
	// $user = \App\Game::create($array);
	// $user = \App\Game::insert($array);

});
Route::get('/del', function() {
	$game = \App\Game::find(9);
	$game->delete();
});


Route::get('/seed', function() {
	$album = new \App\Album;
	$album->title = 'Some Mad Hope';
	$album->artist = 'Matt Nathanson';
	$album->genre = 'Acoustic Rock';
	$album->year = 2007;
	$album->save();

	$album = new \App\Album;
	$album->title = 'Please';
	$album->artist = 'Matt Nathanson';
	$album->genre = 'Acoustic Rock';
	$album->year = 1993;
	$album->save();

	$album = new \App\Album;
	$album->title = 'Leaving Through The Window';
	$album->artist = 'Something Corporate';
	$album->genre = 'Piano Rock';
	$album->year = 2002;
	$album->save();

	$album = new \App\Album;
	$album->title = 'North';
	$album->artist = 'Something Corporate';
	$album->genre = 'Piano Rock';
	$album->year = 2002;
	$album->save();

	$album = new \App\Album;
	$album->title = '...Anywhere But Here';
	$album->artist = 'The Ataris';
	$album->genre = 'Punk Rock';
	$album->year = 1997;
	$album->save();

	$album = new \App\Album;
	$album->title = '...Is A Real Boy';
	$album->artist = 'Say Anything';
	$album->genre = 'Indie Rock';
	$album->year = 2006;
	$album->save();
});


Route::get('/album/list', function() {
	$album = \App\Album::find(1);
	return $album->title;
});
Route::get('/album/all', function() {
	$albums = \App\Album::all();
	foreach ($albums as $album) {
		echo $album->title;
	}
});

Route::get('/album/all1', function() {
	return \App\Album::whereNested(function($query)
	{
		$query->where('year', '>', 2000);
		$query->where('year', '<', 2007);
	})
	->get();


	// $a =  \App\Album::where('title', 'LIKE', '...%')
	// ->orWhere('artist', '=', 'Something Corporate')
	// ->get();
	// dd($a);

});

Route::get('/album/collections', function() {
	$album = \App\Album::all();
	// $c = collect($album)->avg();
	// $collection = collect([
	// 	['name' => 'JavaScript: The Good Parts', 'pages' => 2],
	// 	['name' => 'JavaScript: The Definitive Guide', 'pages' => 4],
	// 	]);
	$arr =['a', 'b', 'c', 'd', 'e', 'f'];
	$collection = collect($arr);

	// $collection->every(4);
	dd($arr);


});







