<?php

namespace App\Filament\Resources\PostResource\Widgets;

use App\Models\Post;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class PostStatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        $published = Post::where('is_published', true)->count();
        $unPublished = Post::where('is_published', false)->count();
        return [
            Card::make('Total Posts', Post::all()->count()),
            Card::make('Published Posts', $published ? $published : 0),
            Card::make('Unpublished Posts', $unPublished ? $unPublished : 0)
        ];
    }
}
