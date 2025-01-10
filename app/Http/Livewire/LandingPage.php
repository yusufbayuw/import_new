<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Setting;

class LandingPage extends Component
{

    public function render()
    {
        return view('livewire.landing-page', [ 'aktif' => Setting::find(1)->status ]);
    }
}
