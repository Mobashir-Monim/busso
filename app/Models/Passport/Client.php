<?php

namespace App\Models\Passport;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Passport\Client as PassportClient;

class Client extends PassportClient
{
    use \App\Models\Concerns\UsesUuid;
}
