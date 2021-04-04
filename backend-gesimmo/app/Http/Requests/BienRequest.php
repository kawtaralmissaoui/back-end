<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Contracts\Service\Attribute\Required;

class BienRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'identifiant'=>'required',
            'adresse' => 'required',
            //'surface' => 'required',
           // 'statut' => 'required',
            'type' => 'required',
            'loyer_mensuel' => 'required',
            'syndic' => 'required',
            //'taxe_habitation' => 'required',
            //'archive' => 'required|string',
            //'nbr_piece' => 'required|integer',
            'equipement' => 'required|boolean',
            'ascenseur' => 'required|boolean',
            'etage' => 'required|integer',
            'user_id'=>'required|integer',
        ];
    }
}
