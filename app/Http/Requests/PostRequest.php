<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class PostRequest extends FormRequest
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
            'titulo' => 'required|string|max:190',
            'dt_inicio' => 'required|string|max:190',
            'dt_fim' => 'required|string|max:190',
            'video_url' => ['required','string','max:190',
                function ($attribute, $value, $fail) {
                    if (!Str::contains($value, '.mp4')) {
                        $fail('O Url do Vídeo deve ser em formato .mp4');
                    }
                },
            ],
            'tipo' => 'required|string|max:190',
            //'ativo' => 'required|string|max:190',
            //'user_id' => 'required|string|max:190',
            //'user_autorizacao' => 'nullable|numeric'
        ];
    }
}
