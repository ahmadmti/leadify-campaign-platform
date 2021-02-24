<?php

namespace App\Http\Requests\Admin\Role;

use App\Http\Requests\AdminCoreRequest;

class UpdateRequest extends AdminCoreRequest
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
            'name'    => 'required|max:255',
            'display_name'    => 'required|max:255',
            'description'     => 'required|max:255'
        ];

    }

}
