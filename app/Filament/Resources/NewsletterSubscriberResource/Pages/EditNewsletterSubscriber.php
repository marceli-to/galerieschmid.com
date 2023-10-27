<?php
namespace App\Filament\Resources\NewsletterSubscriberResource\Pages;
use App\Filament\Resources\NewsletterSubscriberResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNewsletterSubscriber extends EditRecord
{
  protected static string $resource = NewsletterSubscriberResource::class;

  protected function mutateFormDataBeforeSave(array $data): array
  {
    if (isset($data['confirmed_at']) && $data['confirmed_at'])
    {
      $data['confirmed_at'] = now();
    }
    else
    {
      $data['confirmed_at'] = null;
    }
    $data['user_id'] = auth()->user()->id;
    return $data;
  }

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }
}
