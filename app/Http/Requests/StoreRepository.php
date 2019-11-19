<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRepository extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'repo_id' => 'required',
            'name' => 'required|max:255',            
            'html_url' => 'required|max:255',
            'owner_login' => 'required|max:255',
            'stargazers_count' => 'required|max:255',
        ];
    }
}
