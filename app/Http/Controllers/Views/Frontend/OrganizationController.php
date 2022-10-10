<?php

namespace App\Http\Controllers\Views\Frontend;

use Auth;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\OrganizationRepository;
use App\Http\Resources\Organization as OrganizationResource;
use App\Http\Resources\OrganizationCollectiion as OrganizationCollectiionResource;

class OrganizationController extends Controller
{

    /**
     * @var OrganizationRepository $organizationRepository
     */
    protected $organizationRepository;

    /**
     * OrganizationController constructor.
     *
     * @param OrganizationRepository $organizationRepository
     */
    public function __construct(OrganizationRepository $organizationRepository)
    {
        $this->organizationRepository = $organizationRepository;
    }

    /**
     * Display the home page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $organization = session('organization');
        return view("frontend.organizations.index", compact('organization'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('frontend.organizations.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(OrganizationRepository $orgRepo, $code)
    {
        $user = Auth::user();
        $organization = $orgRepo->getByCode($code);
        if (!$organization) abort(404);

        return view('frontend.organizations.show', compact('organization', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view("frontend.organizations.update");
    }


    public function select ()
    {
        $user = Auth::user();
        $hasOrganisations = $user->organizations()->count();

        // If user has one org only, set it as default
        if ($hasOrganisations === 1) {
            session(['organization' => $user->organizations()->first()]);
            return redirect()->intended('dashboard');
        }

        return view('auth.select-organization', compact('user', 'hasOrganisations'));
    }

    /**
     * Set the current organization in the session
     *
     * @param OrganizationRepository $org
     * @param Uuid $code
     */
    public function set (OrganizationRepository $org, $code)
    {
        $organization = $org->getByCode($code);

        if ($organization) {
            session(['organization' => $organization]);
            return redirect()->route('dashboard');
        }

        return redirect()->back()->withErrors(['organization' => 'Organization not found']);
    }


    /**
     * Join an organization.
     *
     * @param  String  $code
     * @return \Illuminate\Http\Response
     */
    public function join($code)
    {
        $organization = $this->organizationRepository->getByCode($code);
        if(is_null($organization) ) {
            return abort(404);
        }
        $user = Auth::user();
        $is_invited =$organization->invitations()->where('email',$user->email)->first();
        $inOrganization=$organization->users()->where('user_id',$user->id)->first();
        //check if the user is not in the organization and has been invited by the organization
        if ((!$inOrganization)&&($is_invited)) {
            $organization->users()->attach($user->id);
            $user->status='active';
            $user->save();
        }
        session()->forget('join_organization');
        session(['organization' => $organization]);


        return redirect()->route('dashboard');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $key=$request->query('q');
        $organization = session('organization');
        $result = $this->organizationRepository->search($key,$organization);

        return view("frontend.search.index", compact('result'));
    }


}
