<?php

namespace App\Http\Requests;

use App\Models\Project;
use Spark\Facades\Auth;
use Spark\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
            'status' => ['required', 'string', ['in' => array_keys(Project::STATUSES)]],
        ];
    }
}
