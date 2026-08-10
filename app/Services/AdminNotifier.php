<?php

namespace App\Services;

use App\Models\User;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;

class AdminNotifier
{
    public function send(string $title, string $body, string $url): void
    {
        $admins = User::query()->where('is_admin', true)->get();
        if ($admins->isEmpty()) {
            return;
        }

        Notification::make()
            ->title($title)
            ->body($body)
            ->icon('heroicon-o-bell-alert')
            ->info()
            ->actions([Action::make('view')->label('View')->url($url)->markAsRead()])
            ->sendToDatabase($admins);
    }
}
