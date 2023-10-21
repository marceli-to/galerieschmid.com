<?php
namespace App\Filament\Resources\NewsletterListResource\Pages;
use App\Filament\Resources\NewsletterListResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNewsletterList extends EditRecord
{
  protected static string $resource = NewsletterListResource::class;

  protected function getHeaderActions(): array
  {
    return [
    ];
  }

  protected function mutateFormDataBeforeSave(array $data): array
  {
    $data['user_id'] = auth()->user()->id;
    return $data;
  }

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }
}
