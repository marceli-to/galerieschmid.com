<?php
namespace App\Filament\Resources\NewsletterSubscriberResource\Pages;
use App\Filament\Resources\NewsletterSubscriberResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateNewsletterSubscriber extends CreateRecord
{
  protected static string $resource = NewsletterSubscriberResource::class;

  protected function mutateFormDataBeforeCreate(array $data): array
  {
    if (isset($data['confirmed_at']) && $data['confirmed_at'])
    {
      $data['confirmed_at'] = now();
    }
    $data['user_id'] = auth()->user()->id;
    return $data;
  }

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }
}
