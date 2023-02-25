<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**  muss vor der Klasse liegen */
/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Integration Swagger in Laravel",
 *      description="Implementation of Swagger with in Laravel",
 *      @OA\Contact(
 *          email="admin@admin.com"
 *      ),
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 * )
 * @OA\Get(
 *    path="/api/users",
 *    @OA\Response(response="200", description="An example endpoint")
 *  )
 *
 *
 *  @OA\Server(
 *      url="http://development.com/api/1",
 *      description="Dev server"
 *  )
 *
 *  @OA\Server(
 *      url="http://staging.com/api/1",
 *      description="Staging server"
 *  )
 *
 *  @OA\Server(
 *      url="https://production.com/api/1",
 *      description="LIVE server"
 *  )
 *
 *  @OA\Tag(
 *     name="Tag",
 *     description="Demo Tag"
 * )
 */

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
