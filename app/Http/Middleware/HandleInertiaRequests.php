<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

use App\Models\User;
use App\Models\SectionEtablissement;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
            ],
            'roles' => fn () => auth()->user()
                ? auth()->user()->getRoleNames()
                : null,
            'permissions' => fn () => auth()->user()
                ? auth()->user()->getAllPermissions()->pluck('name')
                : null,
            $etablissement = User::where('id', auth()->user()->id)->with('etablissement')->first(),
            'sections' => fn () => auth()->user()
            ? SectionEtablissement::where('etablissement_id', $etablissement->etablissement->id)->with('section')->get()
            : null,

            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
        ]);
    }
}
