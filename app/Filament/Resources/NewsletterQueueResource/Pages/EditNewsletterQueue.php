<?php
namespace App\Filament\Resources\NewsletterQueueResource\Pages;
use App\Filament\Resources\NewsletterQueueResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNewsletterQueue extends EditRecord
{
  protected static string $resource = NewsletterQueueResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\DeleteAction::make(),
    ];
  }
}
