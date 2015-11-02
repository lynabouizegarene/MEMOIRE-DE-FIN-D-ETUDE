<?php namespace App\Http\Requests;


class StoreCovoiturageRequest extends Request {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'autocomplete_d' => 'required|max:255',
            'ville_d' => 'required|max:255',
            'wilaya_d' => 'required|max:255',
            'geoloc_d' => 'required|max:255',
            'autocomplete_a' => 'required|max:255',
            'ville_a' => 'required|max:255',
            'wilaya_a' => 'required|max:255',
            'geoloc_a' => 'required|max:255',
            'date_depart' => 'required|after:'.date('y-m-d H:i'),
            'prix' => 'required|numeric|between:0,2000',
            'nombre_places' => 'required|numeric|between:1,10',
            'vehicule' => 'required',
            'bagage' => 'required|in:petit,moyen,grand',
            'flexibilite_horaire' => 'required|in:Pile à l\'heure,+/- 15 minutes,+/- 30 minutes',
        ];
    }


}
