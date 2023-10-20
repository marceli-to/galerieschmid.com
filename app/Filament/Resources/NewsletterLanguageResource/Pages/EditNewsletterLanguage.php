<?php
namespace App\Filament\Resources\NewsletterLanguageResource\Pages;
use App\Filament\Resources\NewsletterLanguageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNewsletterLanguage extends EditRecord
{
  protected static string $resource = NewsletterLanguageResource::class;

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
