<?php
namespace App\Filament\Resources\NewsletterLanguageResource\Pages;
use App\Filament\Resources\NewsletterLanguageResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateNewsletterLanguage extends CreateRecord
{
  protected static string $resource = NewsletterLanguageResource::class;

  protected function getHeaderActions(): array
  {
    return [
    ];
  }

  protected function mutateFormDataBeforeCreate(array $data): array
  {
    $data['user_id'] = auth()->user()->id;
    return $data;
  }

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }
}
