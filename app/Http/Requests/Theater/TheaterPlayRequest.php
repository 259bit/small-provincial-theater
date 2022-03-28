<?php

namespace App\Http\Requests\Theater;

use Illuminate\Foundation\Http\FormRequest;

class TheaterPlayRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'theater_play_name' => 'required|max:255',
            'theater_play_day_start' => 'required|date_format:d-m-Y',
            'theater_play_day_end' => 'required|date_format:d-m-Y|after_or_equal:theater_play_day_start',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
