<?php namespace App\Http\Requests;

use Carbon\Carbon;

class SearchCovoiturageRequest extends Request {

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
            'date_depart' => 'date|after:'.Carbon::yesterday()->toDateString(),
        ];
    }

}
