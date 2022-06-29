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


Route::get("/getAttendance/{ip}", function ($ip) {
    try {
        $zk = new ZKTeco($ip);
        $ret = $zk->connect();
        if ($ret) {
            $zk->disableDevice();
            try {
                $attendance = $zk->getAttendance();
                $time = $zk->getTime();
            } catch (Exception $exception) {
                dd($exception->getMessage());
            }
            sleep(1);
            $zk->getTime();
            $zk->enableDevice();
            $zk->disconnect();
            return $attendance;
        }
    } catch (Exception $exception) {
        dd($exception->getMessage());
    }
});

Route::get("/getUsers/{ip}", function ($ip) {
    try {
        $zk = new ZKTeco($ip);
        $ret = $zk->connect();
        if ($ret) {
            $zk->disableDevice();
            try {
                $users = $zk->getUser();
                $time = $zk->getTime();
            } catch (Exception $exception) {
                dd($exception->getMessage());
            }
            sleep(1);
            $zk->getTime();
            $zk->enableDevice();
            $zk->disconnect();
            return $users;
        }
    } catch (Exception $exception) {
        dd($exception->getMessage());
    }
});
