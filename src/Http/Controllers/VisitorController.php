<?php

namespace Dnwjn\NovaLaunch\Http\Controllers;

use Dnwjn\NovaLaunch\Http\Requests\SignUpStoreRequest;
use Dnwjn\NovaLaunch\NovaLaunch;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;

class VisitorController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|RedirectResponse
     */
    public function index()
    {
        if (! config('nova-launch.enabled', false)) {
            return redirect()->to(config('app.url'));
        }

        return view('nova-launch::site.visitors.index');
    }

    /**
     * @param SignUpStoreRequest $request
     * @return RedirectResponse
     */
    public function store(SignUpStoreRequest $request): RedirectResponse
    {
        if (! config('nova-launch.enabled', false)) {
            return redirect()->to(config('app.url'));
        }

        NovaLaunch::getSignUpModel()::firstOrCreate([
            'email' => $request->input('email'),
            'locale' => App::getLocale(),
        ]);

        return redirect()->back()->with('success', true);
    }
}
