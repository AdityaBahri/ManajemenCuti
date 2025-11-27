<?php

namespace App\Http\Controllers;

// --- Imports yang diperlukan ---
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // WAJIB ADA untuk $this->authorize()
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    // --- Trait yang harus digunakan ---
    use AuthorizesRequests, ValidatesRequests;
}