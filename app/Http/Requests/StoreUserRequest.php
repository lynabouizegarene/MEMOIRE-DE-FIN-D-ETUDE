<?php namespace App\Http\Requests;


class StoreUserRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
           return [
               'nom' => 'required|max:255|alpha',
               'prenom' => 'required|max:255|alpha',
               'genre' => 'required|in:Homme,Femme',
               'date_nais' => 'required|date',
               'num_tel' => 'required|regex:/^0[0-9]{8,9}$/',
               'ville' => 'required|max:255',
               'wilaya' => 'required|max:255',
               'geoloc' => 'required|max:255',
               'pref_musique' => 'required|boolean',
               'pref_animeaux' => 'required|boolean',
               'pref_discussion' => 'required|boolean',
               'pref_fumeur' => 'required|boolean',
               'photo' => 'mimes:jpeg', //format:jpeg et taille max:5Mo.
           ];
    }
}