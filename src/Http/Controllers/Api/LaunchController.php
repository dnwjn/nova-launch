<?php

namespace Dnwjn\NovaLaunch\Http\Controllers\Api;

use Dnwjn\NovaLaunch\Enums\LaunchKey;
use Dnwjn\NovaLaunch\Http\Controllers\Controller;
use Dnwjn\NovaLaunch\NovaLaunch;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\ConditionallyLoadsAttributes;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Laravel\Nova\Contracts\Resolvable;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\FieldCollection;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\ResolvesFields;

class LaunchController extends Controller
{
    use ResolvesFields, ConditionallyLoadsAttributes;

    /**
     * Display the launch page.
     *
     * @param NovaRequest $request
     * @return JsonResponse
     */
    public function edit(NovaRequest $request): JsonResponse
    {
        $panels = [];
        $fields = [];

        if ($this->availableFields($request)->count() > 0) {
            $panels = $this->panelsWithDefaultLabel(__('General settings'), $request);
            $fields = $this->assignToPanels(__('General settings'), $this->availableFields($request));

            $fields->each(function (Field $field) {
                if (! empty($field->attribute)) {
                    $setting = NovaLaunch::getSettingModel()::findOrFail($field->attribute);
                    $field->resolve([$field->attribute => $setting->value]);
                }
            });
        }

        // Return extra data for display purposes.
        $signups = NovaLaunch::getSignUpModel()::count();

        return response()->json(compact('panels', 'fields', 'signups'));
    }

    /**
     * Handle the submission of the settings form.
     *
     * @param NovaRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(NovaRequest $request)
    {
        $fields = $this->availableFields($request);
        $rules = $fields->map(fn (Field $field) => $field->getRules($request))->collapse()->toArray();

        Validator::make($request->all(), $rules)->validate();

        $fields->whereInstanceOf(Resolvable::class)->each(function (Field $field) use ($request) {
            if (empty($field->attribute) || $field->isReadonly($request)) {
                return;
            }

            $setting = NovaLaunch::getSettingModel()::findOrFail($field->attribute);

            $resource = new \stdClass();
            $field->fill($request, $resource);

            if (! property_exists($resource, $field->attribute)) {
                return;
            }

            $setting->update(['value' => $resource->{$field->attribute}]);
        });

        return response('', 204);
    }

    /**
     * Get the fields that are available for the given request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return \Laravel\Nova\Fields\FieldCollection
     */
    protected function availableFields(NovaRequest $request)
    {
        return new FieldCollection($this->filter($this->fields($request)));
    }

    /**
     * Get the fields for the given request.
     *
     * @param NovaRequest $request
     * @return \Laravel\Nova\Panel[]
     */
    protected function fields(NovaRequest $request)
    {
        return NovaLaunch::getFields();
    }

    /**
     * Handle the submission of the launch form.
     *
     * @param NovaRequest $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function launch(NovaRequest $request)
    {
        if (! Hash::check($request->input('password'), $request->user()->password)) {
            throw ValidationException::withMessages([
                'password' => 'Invalid password',
            ]);
        }

        NovaLaunch::getEventModel()::dispatch();

        NovaLaunch::getSettingModel()::findOrFail(LaunchKey::Launched)->update(['value' => true]);

        return response()->json(['target' => config('app.url')]);
    }
}
