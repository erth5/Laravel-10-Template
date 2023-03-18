<?php

namespace App\Http\Controllers\Debug;

use Exception;
use App\Models\Image;
use Illuminate\Http\Request;
use App\Services\ImageService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreImageRequest;

/**
 * @deprecated
 */
class ImageController extends Controller
{

    protected $imageService;
    public function __construct(
        ImageService $imageService
    ) {
        $this->imageService = $imageService;
    }

    /* variant1 */
    /**
     * Display a listing of the resource.
     * performance: 1 querie->good
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $images = Image::withTrashed()->get();
        if ($images->isEmpty())
            return view('image.index');
        else
            return view('image.index', compact('images'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param image array all saved images
     * @param name string name of image
     * @param path string path of image
     * @param requestData meta data from image
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreImageRequest $request)
    {
        /* Validation
         +Recommendet RequestFile
         app/Rules to add own validator rules
         non static in module
         static in Service (this case service use other Request Facade)
         +or in controller*/

        /* has own return back -> no proof required */
        $request->validate(
            ['image' => 'required',]
        );
        $request->validate([
            'image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        if ($request != true) {
            return redirect()->route('images')->with('statusError', __('image.validateError'));
        }

        /** storeAs: $path, $name, $options = []     */
        if ($request->hasFile('image')) {
            /* Pfad mit Namen und speichern*/
            // $path = $request->file('image')->storeAs('images', $name, 'public');
            /* Pfad ohne Namen */
            $name = time() . $request->file('image')->has('name');
            $request->file('image')->storeAs('images', $name, 'public');
            $metadata = Image::create();
            $metadata->name = $name;
            $metadata->path = 'images/';
            $metadata->extension = $request->file('image')->extension();
            $metadata->saveOrFail();
            session()->put('success', 'image ' . $metadata->name . ' saved (session)');
            session()->put('image', $metadata->name);
            return redirect()->route('image')
                ->with('statusSuccess', __('image.uploadSuccess') . $metadata->name . 'with()lang()')
                ->with('image', storage_path($metadata->path . $metadata->name));
        }
        return redirect()->route('image')->withErrors('Request has no image');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('/image.upload');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $image = Image::first();
        return view('image.show', compact('image'));
    }

    /**
     * Update the specified resource in storage.
     * set only new name to image
     *
     * @param  \Illuminate\Http\Request  $request beinhaltet noch kein neues Image
     * @param  \App\Models\Image  $image altes Image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $image)
    {
        // do not change image data bevor use old path
        try {
            if (Storage::exists('public/' . $image->path . $image->name)) {
                Storage::delete('public/' . $image->path . $image->name);
            }
            // store for not relevant names
            $storePath = $request->file('image')->store('public/' . str_replace('/', '', $image->path));
            $image->name = str_replace('public/' . $image->path, '', $storePath);
            $image->extension = $request->file('image')->extension();
        } catch (Exception $e) {
            dd($e);
        }
        $image->extension = $request->file('image')->extension();
        $image->saveOrFail();
        return redirect()->route('image')->with('status', 'Image ' . $image->name . ' has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        /** Soft-delete */
        $image->delete();
        return redirect()->route('image')->with('status', 'Image ' . $image->name . ' has been soft deleted');
    }

    public function restore($image)
    {
        $image = Image::withTrashed()->findOrFail($image);
        $image->remove_time = null;
        $image->saveOrFail();
        return redirect()->route('image')->with('status', 'Image ' . $image->name . ' has been restored');
    }

    public function clear()
    {
        $images = Image::onlyTrashed()->get();
        /** Hard-delete */
        foreach ($images as $image) {
            if (Storage::exists('public/' . $image->path . $image->name)) {
                Storage::delete('public/' . $image->path . $image->name);
            }
            $image->forceDelete();
        }
        $images = Image::all();
        return view('image.index', compact('images'));
    }

    /**
     * rename a image to new name and path
     */
    public function rename(Request $request, Image $image)
    {
        $old_name = $image->name;
        $relative_source_path = 'public/' . $image->path . $image->name;
        $relative_target_path =  'public/' . $image->path . time() . $request->rename . '.' . $image->extension;
        try {
            Storage::move($relative_source_path, $relative_target_path);
            // rename(public_path('storage/' . $image->path . $image->name), public_path('storage/' . $image->path . $request->rename . '.' . $image->extension));
            $image->name = time() . $request->rename . '.' . $image->extension;
            $image->saveOrFail();
        } catch (Exception $e) {
            return redirect()->route('image')->with('status', 'Error,' . $image->name . ' not found');
        }
        return redirect()->route('image')->with('status', 'Image ' . $image->name . ' has been renamed to ' . $old_name);
    }

    /** alternative
     * store function
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function image(Request $request)
    {
        $this->imageService->imageExist($request);
        $this->imageService->imageValid($request);
        $name = $request->file('image')->has('name');
        $path = $request->file('image')->store('image');

        // SaveOrFail costumized
        DB::beginTransaction();
        try {
            $dbItem = new Image();
            $dbItem->name = $name;
            // path descripes the name in Path "storage/app/images
            $dbItem->path = $path;
            if ($dbItem->save()) {
                DB::commit();
            } else {
                DB::rollback();
                // possible back()->withInput()
                // possible withInput(Input::all())
                // need value="{{ old('age') }}"
            }
        } catch (Exception $e) {
            DB::rollback();
        }

        // Ohne Route Redirect
        $images = Image::all();
        // dd($request, $validation, $dbItem, $name, $path);
        return redirect('image')->with('status', 'Image Has been uploaded:')->with('imageName', $name)->with('images', $images);
    }


    /** Debug Image Data*/
    public function debug(Request $req)
    {
        //Display File Name
        echo 'File Name: ' . $req->hasName();
        echo '<br>';

        //Display File Extension
        echo 'File Extension: ' . $req->extension();
        echo '<br>';

        //Display File Real Path
        echo 'File Real Path: ' . $req->getRealPath();
        echo '<br>';

        //Display File Size
        echo 'File Size: ' . $req->getSize();
        echo '<br>';

        //Display File Mime Type
        echo 'File Mime Type: ' . $req->getMimeType('JJJJ:MM:DD');

        //copy Uploaded File
        $destinationPath = 'debugPath';
        $req->copy(
            $destinationPath,
            $req->has('name')
        );

        /* display self metadata */
        $path = 'debug';
        $requestData["image"] = '/storage/' . $path;
        echo $requestData;
        return $req;
    }
}
