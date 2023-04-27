<?php

namespace App\Http\Controllers\Debug;

use App\Models\User;
use App\Models\Person;
use Illuminate\Http\Request;
use App\Services\UtilService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;
use AshAllenDesign\ConfigValidator\Services\ConfigValidator;

class DebugController extends Controller
{
    /** Freie Wahl (wenn benötigt)
     * use Illuminate\Routing\Route;
     * use Illuminate\Support\Facades\Route;
     */

    protected $UtilService;
    public function __construct(UtilService $UtilService)
    {
        $this->UtilService = $UtilService;
    }

    /**
     * control debug calls
     * @return void
     */

    /**
     * Display a listing of the resource.
     * break not needed?
     *
     * @return \Illuminate\Http\Response
     */
    public function index($name = 'main',)
    {
        $url = Config::set('constants.info.url', 'http://example.de');
        switch ($name) {
            case 'user':
                $person = Person::find(1);
                return view('debug.user');
            case 'test':
                DebugController::test();
                break;
            case 'db':
                $connections[] = null;

                try {
                    \DB::connection()->getPDO();
                    $connections[] = 'main DB: ' . \DB::connection()->getDatabaseName();
                } catch (\Exception $e) {
                    $connections[] = $e;
                }
                try {
                    \DB::connection('sqlite')->getPDO();
                    $connections[] = 'sqlite: ' . \DB::connection()->getDatabaseName();
                } catch (\Exception $e) {
                    $connections[] = $e;
                }
                try {
                    \DB::connection('pgsql')->getPDO();
                    $connections[] = 'pgsql: ' . \DB::connection()->getDatabaseName();
                } catch (\Exception $e) {
                    $connections[] = $e;
                }
                try {
                    \DB::connection('sqlsrv')->getPDO();
                    $connections[] = 'sqlsrv: ' . \DB::connection()->getDatabaseName();
                } catch (\Exception $e) {
                    $connections[] = $e;
                }
                return view('debug.db', compact('connections'));
            case 'debug':
                return view('debug.debug');
            case 'php':
                return view('debug.info');
            case 'env':
                $array = file("../.env", FILE_SKIP_EMPTY_LINES);
                print_r($array);
                echo ('<br>');
                break;
            case 'template':
                return view('debug.template');
            case 'views':
                return view('debug.views');
            case 'controllers':
                $path = public_path('../app/Http/Controllers');
                $files = File::allFiles($path);
                dd($files);
            case 'models':
                $path = public_path('../app/Models');
                $files = File::allFiles($path);
                dd($files);
            case 'lang':
                return view('debug.lang');
            case 'path':
                // current directory
                echo (__DIR__);
                // Path to the project's root folder
                echo base_path() . "<br>";
                // Path to the 'app' folder
                echo app_path() . "<br>";
                // Path to the 'public' folder
                echo public_path() . "<br>";
                // Path to the 'storage' folder
                echo storage_path() . "<br>";
                // Path to the 'storage/app' folder
                echo storage_path('app') . "<br>";
                // Path to database folder and sqlite file
                echo database_path('database.sqlite');
                break;
            case 'scope':
                $scope = User::select('*')->get();
                dd($scope);
            case 'config':
                $configValidation = (new ConfigValidator())->run();
                return $configValidation;
            case 'session':
                $allSessions = session()->all();
                dd($allSessions);
                return view('debug.session');
            case 'sessions':
                return view('debug.sessions');
            case 'status':
                return redirect()->route('debug')->with('status', "state message");
            case 'error':
                // case 'request':
                // echo $request;
                return redirect()->route('debug')->withErrors(['msg' => 'message for errors']);
            case 'url':
                dd(url());
            case 'route':
                dd(Route::getRoutes());
            default:
                return view('debug.layout');
        }
        // abort(404);
    }

    public function test()
    {
        /** works */
        // $test = Person::username();
        // dd($test);

        /** works */
        // $columns = ['id', 'user_id', 'surname', 'last_name', 'username', 'created_at', 'updated_at'];
        // $coloumschecker = $this->UtilService->databaseHasColumns('people', $columns);
        // dd($coloumschecker);

        /** works */
        // $person = Person::first();
        // $columnName = 'surname';
        // dd($person->{$columnName});

        /** works */
        // $columns = ['surname', 'last_name', 'username'];
        // $coloumschecker = $this->UtilService->proofDatabaseFields(Person::class, $columns);
        // dd($coloumschecker);

        /** works */
        // $coloumschecker = $this->UtilService->getFillableKeys(Person::class);
        // dd($coloumschecker);

        /** works */
        // $anything = $some = $elsewhatsoever = "nothing";
        // dd($anything, $some, $elsewhatsoever);
    }
}
