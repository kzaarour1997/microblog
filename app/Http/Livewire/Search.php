<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post;

class Search extends Component
{
    public $search = '';

    public function render()
    {
        return view('livewire.search', [
            'posts' => $this->search ? Post::whereFullText('title', $this->search)->orWhereFullText('content', $this->search)->get() : [],
        ]);
    }
}
