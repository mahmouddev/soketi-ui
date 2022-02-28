<?php

namespace App\Http\Controllers;

use App\Soketi\Facades\Manager;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AppsController extends Controller
{
    public function index()
    {
        $apps = Manager::all()->map(function ($app) {
            return [
                'id' => $app->get('appId'),
                'title' => $app->get('title'),
                'enabled' => $app->get('enabled'),
                'enable_client_messages' => $app->get('enableClientMessages'),
                'max_connections' => $app->get('maxConnections'),
                'webhook_count' => 2,
            ];
        })->toArray();

        return Inertia::render('Dashboard/Apps/Index', [
            'apps' => $apps,
        ]);
    }

    public function show($id)
    {
        $app = Manager::find($id);

        return Inertia::render('Dashboard/Apps/Show', [
            'app' => $app->toArray(),
        ]);
    }

    public function save($id)
    {
        $app = Manager::find($id);

        foreach (request()->json() as $key => $value) {
            $app->set($key, $value);
        }

        $app->save();

        return redirect("/apps/$id");
    }

    public function regenerateCredentials($id)
    {
        $app = Manager::find($id);

        $app->regenerateCredentials()->save();

        return redirect("/apps/$id");
    }
}