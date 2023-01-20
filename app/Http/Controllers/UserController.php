<?php

namespace App\Http\Controllers;

use App\User;
use App\UserFirma;
use App\Rezervare;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(UserFirma $agentie = null)
    {
        return view('useri.create', compact('agentie'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'firma_id' => 'required',
            'username' => 'required|max:250|unique:users,username',
            'password' => 'required|max:100',
        ]);

        $user = new User;
        $user->user_firma_id = $request->firma_id;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect('/agentii')->with('status', 'Utilizatorul „' . ($user->username ?? '') . '” a fost adăugat cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserFirma  $userFirma
     * @return \Illuminate\Http\Response
     */
    public function show(UserFirma $agentii)
    {
        if (!auth()->user()->isDispecer()) {
            abort(403);
        }
        return view('agentii.show', compact('agentii'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserFirma  $userFirma
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $agentie = UserFirma::find($user->user_firma_id)->first();

        $textSuplimentarParola = "daca nu completati nimic la parola, parola ramane cea veche";

        return view('useri.edit', compact('agentie', 'user', 'textSuplimentarParola'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserFirma  $userFirma
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'firma_id' => 'required',
            'username' => 'required|max:250|unique:users,username,'.$user->id,
        ]);
// dd($request->password);
        $user->username = $request->username;
        if ($request->password !== null){
            $user->password = Hash::make($request->password);
        }
        $user->update();

        return redirect('/agentii')->with('status', 'Utilizatorul „' . ($user->username ?? '') . '” a fost modificat cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserFirma  $userFirma
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        // $this->authorize('update', $user);
        if ($user->rezervari->count() === 0){
            $user->delete();
            return redirect('/agentii')->with('status', 'Utilizatorul a fost șters cu succes');
        } else{
            return redirect('/agentii')->with('error', 'Utilizatorul nu poate fi șters pentru că are rezervari adăugate. Ștergeți întâi rezervările acestui utilizator. Đacă doriți doar ca utilizatorul sa nu mai aibă acces în sistem, este de ajuns să-i modificați datele de acces (utilizator sau parolă)');
        }

    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateRequest(Request $request)
    {
        return $request->validate(
            [
                'nume' => 'required|max:150',
                'punct_lucru' => 'nullable|max:150',
                'cif' => 'nullable|max:100',
                'nr_orc' => 'nullable|max:100',
                'persoana_contact' => 'nullable|max:150',
                'telefon' => 'nullable|max:100',
                'email' => 'nullable|max:150',
            ],
            [

            ]
        );
    }


    public function loginAs()
    {
        //get the id from the post
        $id = request('user_id');

        //if session exists remove it and return login to original user
        if (session()->get('hasClonedUser') == 355) {
            auth()->loginUsingId(session()->remove('hasClonedUser'));
            session()->remove('hasClonedUser');
            return redirect()->back();
        }

        //only run for developer, clone selected user and create a cloned session
        if (auth()->user()->id == 355) {
            session()->put('hasClonedUser', auth()->user()->id);
            auth()->loginUsingId($id);
            return redirect()->back();
        }
    }

    public function AuthRouteAPI(Request $request)
    {
        return $request->user();
    }
}
