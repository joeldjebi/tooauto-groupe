<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContactRequest extends FormRequest
{
    /**
     * The profiles a visitor can pick in the contact form.
     *
     * @var list<string>
     */
    public const PROFILES = ['driver', 'organisation', 'professional', 'partner'];

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * The "website" field is a honeypot: humans never see it, bots fill it.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:30', 'regex:/^[0-9+().\s-]{6,}$/'],
            'email' => ['required', 'email', 'max:160'],
            'profile' => ['required', Rule::in(self::PROFILES)],
            'message' => ['required', 'string', 'min:10', 'max:3000'],
            'website' => ['prohibited'],
        ];
    }

    /**
     * Get the redirect URL when validation fails.
     */
    protected function getRedirectUrl(): string
    {
        return url()->previous().'#contact';
    }
}
