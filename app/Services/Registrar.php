<?php namespace App\Services;

use App\Model\Ville;
use App\Model\User;
use Illuminate\Support\Facades\Input;
use Validator;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;

class Registrar implements RegistrarContract
{

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data)
    {
        $validator = Validator::make($data, [
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
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
        ]);

        $validator->after(function($validator)
        {
            if (!$this->isValid_reCAPTCHA($_POST['g-recaptcha-response']))
            {
                $validator->errors()->add('recaptcha', 'Votre captcha n\'est pas valide');
            }
        });

        return $validator;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    public function create(array $data)
    {
        $geoloc = $data['geoloc'];
        $geoloc = str_replace(["(", ")"], "", $geoloc);
        $geoloc = explode(",", $geoloc);
        $geoloc[0] = (Double)($geoloc[0]);
        $geoloc[1] = (Double)($geoloc[1]);

        $ville = Ville::firstOrCreate([
            'nom' => $data['ville'],
            'wilaya' => $data['wilaya'],
            'longitude' => $geoloc[0],
            'latitude' => $geoloc[1],
        ]);
        $user = User::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'nom' => ucfirst($data['nom']),
            'prenom' => ucfirst($data['prenom']),
            'genre' => $data['genre'],
            'date_nais' => $data['date_nais'],
            'num_tel' => $data['num_tel'],
            'ville_id' => $ville->getAttribute('id'),
            'pref_musique' => $data['pref_musique'],
            'pref_animeaux' => $data['pref_animeaux'],
            'pref_discussion' => $data['pref_discussion'],
            'pref_fumeur' => $data['pref_fumeur'],
            'description' => $data['description'],
        ]);
        if (Input::file('photo')) {
            $destination = '../storage/app'; // path
            $fileName = $user->getAttribute('id') . '.jpg'; // renameing image
            Input::file('photo')->move($destination, $fileName);
            // redimensionner
            $largeur = 64;
            $hauteur = 64;
            $image = imagecreatefromjpeg($destination.'/'.$fileName);
            $taille = getimagesize($destination.'/'.$fileName);

            $sortie = imagecreatetruecolor($largeur,$hauteur);
            $coef = min($taille[0]/$largeur,$taille[1]/$hauteur);

            $deltax = $taille[0]-($coef * $largeur);
            $deltay = $taille[1]-($coef * $hauteur);

            imagecopyresampled($sortie,$image,0,0,$deltax/2,$deltay/2,$largeur,$hauteur,$taille[0]-$deltax,$taille[1]-$deltay);
            imagejpeg($sortie,$destination.'/mini_'.$fileName);
        }
        return $user;
    }

    function isValid_reCAPTCHA($code, $ip = null)
    {
        if (empty($code)) {
            return false; // Si aucun code n'est entré, on ne cherche pas plus loin
        }
        $params = [
            'secret'    => '6LdBCAYTAAAAACB_gvA4vqumNYNzqieMpHfiJFdM',
            'response'  => $code
        ];
        if( $ip ){
            $params['remoteip'] = $ip;
        }
        $url = "https://www.google.com/recaptcha/api/siteverify?" . http_build_query($params);
        if (function_exists('curl_version')) {
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_TIMEOUT, 5);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // Evite les problèmes, si le ser
            $response = curl_exec($curl);
        } else {
            // Si curl n'est pas dispo, un bon vieux file_get_contents
            $response = file_get_contents($url);
        }

        if (empty($response) || is_null($response)) {
            return false;
        }

        $json = json_decode($response);
        return $json->success;
    }
}
