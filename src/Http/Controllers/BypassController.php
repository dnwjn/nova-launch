<?php

namespace Dnwjn\NovaLaunch\Http\Controllers;

use Dnwjn\NovaLaunch\Enums\LaunchKey;
use Illuminate\Http\Request;

class BypassController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index(Request $request)
    {
        if (! config('nova-launch.enabled', false)) {
            return redirect()->to(config('app.url'));
        }

        return redirect()->to(config('app.url'))
            ->withCookie(LaunchKey::Cookie, $request->route()->parameter('secret'));
    }
}
