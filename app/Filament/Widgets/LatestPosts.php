<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestPosts extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected function getTableQuery(): Builder
    {
        return Post::latest()->take(10);
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('id')->sortable(),
            TextColumn::make('title')->searchable(),
            TextColumn::make('slug'),
            IconColumn::make('is_published')->boolean(),
            TextColumn::make('created_at')->since(),
        ];
    }

    protected function isTablePaginationEnabled(): bool
    {
        return false;
    }
}
