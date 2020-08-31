<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
class StoreUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    protected function prepareForValidation(){
      $this->merge([
        'email' => $this->input('ci').date("ymd").'@elmols.com',
        'password' => Hash::make('ci'),
        'user_id' => 1
      ]);
    }
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
          'ci' => 'required|unique:users,ci|min:6|max:30',
          'name' => 'required|min:10',
          'cell' => 'required',
          'email'   => 'required|string|email',
          'password'=> 'required|min:8'
        ];
    }
}
