<?php

namespace Modules\Website\Livewire\Home;

use Livewire\Component;
use Modules\Website\Models\Post; // Import Model Post của bạn

class BlogHighlight extends Component
{
    public $posts;

    public function mount()
    {
        // Lấy 4 bài viết mới nhất đã xuất bản
        // Eager load categories để hiển thị tên danh mục

            $this->posts = Post::where('status', 'published')
            ->with('categories')
            ->latest('published_at')
            ->take(4)
            ->get();
    }

    // Skeleton Layout Magazine
    public function placeholder()
    {
        return <<<'blade'
        <div class="mb-20 container mx-auto px-4">
            <div class="flex justify-between items-end mb-8">
                <div class="h-8 bg-gray-200 rounded w-40"></div>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                {{-- Hero Post Placeholder --}}
                <div class="bg-gray-200 rounded-xl aspect-video animate-pulse"></div>
                {{-- List Post Placeholder --}}
                <div class="space-y-6">
                    @foreach(range(1,3) as $i)
                        <div class="flex gap-4">
                            <div class="w-32 h-24 bg-gray-200 rounded-lg"></div>
                            <div class="flex-1 space-y-2">
                                <div class="h-4 bg-gray-200 rounded w-full"></div>
                                <div class="h-4 bg-gray-200 rounded w-2/3"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        blade;
    }

    public function render()
    {
        return view('Website::livewire.home.blog-highlight');
    }
}
