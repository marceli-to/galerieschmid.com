<?php
namespace App\Filament\Resources\NewsletterListResource\Pages;
use App\Filament\Resources\NewsletterListResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateNewsletterList extends CreateRecord
{
  protected static string $resource = NewsletterListResource::class;

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
