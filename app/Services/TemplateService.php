<?php

namespace App\Services;

use App\Models\Template;
use Illuminate\Database\Eloquent\Collection;

class TemplateService
{
    public function createTemplate(array $data): Template
    {
        return Template::create([
            'channel' => $data['channel'],
            'name' => $data['name'],
            'message' => $data['message'],
        ]);
    }

    public function allTemplate(): Collection
    {
        return Template::all();
    }
}
