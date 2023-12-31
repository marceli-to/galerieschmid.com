<?php
namespace App\Filament\Resources\NewsletterQueueResource\Pages;
use App\Filament\Resources\NewsletterQueueResource;
use App\Services\Newsletter as NewsletterService;
use Filament\Notifications\Notification;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListNewsletterQueues extends ListRecords
{
  protected static string $resource = NewsletterQueueResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Action::make('clearQueue')
      ->label('Warteschlange leeren')
      ->icon('heroicon-o-trash')
      ->color('danger')
      ->requiresConfirmation()
      ->action(function(): void {
        (new NewsletterService())->clearQueue();
        Notification::make()->title('Warteschlange geleert!')->success()->send();
      }),
    ];
  }
}
