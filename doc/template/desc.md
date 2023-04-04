# Description

## Relationship

```php
$user->load('projects');
```

## Resource

```php
public function index(){}
public function store(Request $request){}
public function create(){}
public function show(){}
public function update(Request $request){}
public function destroy(Request $request){}
public function edit(Request $request){}

Route::resource('items', ItemController::class);
Route::controller(ItemController::class)->group(function () {
    Route::get('items', 'index')->name('items.index');
    Route::post('items', 'store')->name('items.store');
    Route::get('items/create', 'create')->name('items.create');
    Route::get('items/{item}', 'show')->name('items.show');
    Route::put('items/{item}', 'update')->name('items.update');
    Route::delete('items/{item}', 'destroy')->name('items.destroy');
    Route::get('items/{item}/edit', 'edit')->name('items.edit');
});
```

## Auth

```php

$token = request()->bearerToken();

/* Current Login User Details */
$user = auth()->user();
var_dump($user);

/* Current Login User ID */
$userID = auth()->user()->id; 
var_dump($userID);

/* Current Login User Name */
$userName = auth()->user()->name; 
var_dump($userName);
 
/* Current Login User Email */
$userEmail = auth()->user()->email; 
var_dump($userEmail);
```

## relationship key-name

Denken Sie daran, dass Eloquent automatisch die richtige Fremdschlüsselspalte für das Modell Comment bestimmt. Konventionell nimmt Eloquent den "snake case"-Namen des übergeordneten Modells und hängt ihn an _id an. In diesem Beispiel nimmt Eloquent also an, dass die Fremdschlüsselspalte des Comment-Modells post_id ist.

## how to logging?

```php

use IlluminateSupportFacadesLog;

//.. and then somewhere in your php file
Log::emergency($message);
Log::alert($message);
Log::critical($message);
Log::error($message);
Log::warning($message);
Log::notice($message);
Log::info($message);
Log::debug($message);
```

## what does enctype?

use multipart/form-data when your form includes any <input type="file"> elements

otherwise you can use multipart/form-data or application/x-www-form-urlencoded but application/x-www-form-urlencoded will be more efficient

When you are writing server-side code, use a prewritten form handling library

## How composer works?

laravel/excel requires the gd extension, since you didn't have it, composer is smart enough to "go backwards" and find suitable versions, but once it found that, other things were conflicting, and it does this endlessly until it can't resolve the issue.

Then it granted you the option to "ignore" what Composer is trying to do, which is the right thing - but by ignoring, you're also just asking for stuff to not work.

The .lock file contains package specific version based on SEMVER, so your composer.json might have version ^8.0 which means you can get versions from 8.0 -> 8.9, but not 9.0.
Your lock file might say that you have version 8.6.2 installed, because that's the ACTUAL version you're installing, the json file just gives a "range".

So usually when lock file errors occur, it's just because your package is locked to a version that conflicts with others, but by letting Composer be smart to resolve it and generate the proper lock file, we just deleted it and had it "be 600 IQ lifehacking".

### Check Relationships

#### 1 In the query itself, you can filter models that do not have any related items

```code
Model::has('posts')->get()
```

#### 2 Once you have a model, if you already have loaded the collection (which below #4 checks), you can call the count() method of the collection

``` code
$model->posts->count();
```

#### 3 If you want to check without loading the relation, you can run a query on the relation

```code
$model->posts()->exists()
```

#### 4 If you want to check if the collection was eager loaded or not

```php
if ($model->relationLoaded('posts')) {
    // Use the collection, like #2 does...
}
```

#### 5 If model already have loaded relationship, you can determine the variable is null or call isEmpty() to check related items

### relationship without convention

```php
return $this->belongsTo(User::class, 'foreign_key', 'owner_key');
return $this->hasOne(Phone::class, 'foreign_key', 'local_key');
```

### example for CRUD

```php
<form action="{{ route('destroy image', [$image]) }}"enctype='multipart/form-data' @csrf 
 <a href="delete/{{ $image->id }}">remove</a>
    <button type="submit" value="submit">remove</button>
</form>
<form action="{{ route('edit image', [$image]) }}">
    <input type="text" name="edit">
    <button type="submit" value="submit">rename(edit)</button>
</form>
{{-- /image/2?_method=PATCH_token=07X4FTo6tOjNwltynnx8e82FGA52fCYOoXwU79v1&image= 
 https://laravel.com/docs/9.x/routing#form-method-spoofing
    Nutzte route anstatt url - besonders bei ressources ctr
    method="ist immer get oder post"
    PUT, PATCH, or DELETE gibt es in actions nicht --}}
<form action="{{ route('update image', [$image]) }}"enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="_method" value="PATCH">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="file" name="image" @error('image') is-invalid @enderror>
    @error('image')
        <span style="color:red;">{{ $message }}</span>
    @enderror
    <button type="submit" value="image">update</button>
</form>

# Image Upload Route

<form action="{{ route('image/' . image->id) }}"method="PUT" enctype="multipart/form-data">
@csrf
<label for="inputImage">Image:</label>
<input type="file" name="image" id="inputImage" @erro('image') is-invalid @enderror>
@error('image')
    <span style="color:red;">{{ $message }}</span>
@enderror

    </form>
```
