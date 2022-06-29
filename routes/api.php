<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Rats\Zkteco\Lib\ZKTeco;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get("/get/{ip}/{type}", function ($ip, $type) {
    try {
        $zk = new ZKTeco($ip);
        $ret = $zk->connect();
        if ($ret) {
            $zk->disableDevice();
            try {
                $type == "attendance"
                    ? $result = $zk->getAttendance()
                    : $result = $zk->getUser();

                $time = $zk->getTime();
            } catch (Exception $exception) {
                dd($exception->getMessage());
            }
            sleep(1);
            $zk->getTime();
            $zk->enableDevice();
            $zk->disconnect();
            return $result;
        }
    } catch (Exception $exception) {
        dd($exception->getMessage());
    }
});
