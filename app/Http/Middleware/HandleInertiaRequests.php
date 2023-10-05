<?php

namespace App\Http\Middleware;

use App\Models\User;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

use App\Models\SectionUser;
use Illuminate\Http\Request;
use App\Models\Etablissement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
            'flashd' => [
                'messages' => fn () => $request->session()->get('messages')
            ],
            'flash' => [
                'message' => fn () => $request->session()->get('message')
            ],
            'auth' => [
                'user' => $request->user(),
            ],
            'roles' => fn () => auth()->user()
                ? auth()->user()->getRoleNames()
                : null,
            'permissions' => fn () => auth()->user()
                ? auth()->user()->getAllPermissions()->pluck('name')
                : null,
            auth()->user() ? $etablissement = User::where('id', auth()->user()->id)->with('etablissement')->first() : null,

            'sections' => fn () => isset(auth()->user()->etablissement_id)
            ? Etablissement::where('id', $etablissement->etablissement->id)->with('sections')->get()
            : null,
            'section_users' => fn () => isset(auth()->user()->etablissement_id) ? DB::select("
                SELECT s.libelle FROM sections s
                JOIN etablissement_section es ON s.id = es.section_id
                JOIN etablissements e ON e.id = es.etablissement_id
                JOIN section_users su ON es.id = su.etablissement_section_id
                JOIN users u ON u.id = su.user_id
                WHERE u.id = :user_id and e.id = :etablissement_id
            ",[
                'etablissement_id'=>Auth::user()->etablissement_id,
                'user_id'=>Auth::user()->id
            ]): null,
            'admin_etablissement' => fn () => isset(auth()->user()->etablissement_id) ? User::where('id', auth()->user()->id)->with('etablissement')->first() : null,
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
        ]);
        // dd($etablissement);
    }
}
