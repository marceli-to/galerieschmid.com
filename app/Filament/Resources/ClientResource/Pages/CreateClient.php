<?php
namespace App\Filament\Resources\ClientResource\Pages;
use App\Filament\Resources\ClientResource;
use Filament\Actions;
use App\Services\Newsletter;
use Filament\Resources\Pages\CreateRecord;

class CreateClient extends CreateRecord
{
  protected static string $resource = ClientResource::class;

  protected function mutateFormDataBeforeCreate(array $data): array
  {
    $data['user_id'] = auth()->user()->id;
    $data['alfa'] = (isset($data['firstname']) ? strtoupper($data['firstname']) . ' ' : '') . strtoupper($data['lastname']);

    // fix protocol for website
    if (isset($data['website']) && !empty($data['website']))
    {
      if (!preg_match("~^(?:f|ht)tps?://~i", $data['website']))
      {
        $data['website'] = "https://" . $data['website'];
      }
    }

    // subscribe to newsletter if checkbox is checked and email is valid
    if (isset($data['email']) && filter_var($data['email'], FILTER_VALIDATE_EMAIL))
    {
      if (isset($data['newsletter_subscriber']))
      {
        if ($data['newsletter_subscriber'])
        {
          $subscriber = (new Newsletter())->subscribe([
            'email' => $data['email'],
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
          ], TRUE, 3);
        }
        else
        {
          if ($subscriber = (new Newsletter())->findSubscriber($data['email']))
          {
            (new Newsletter())->unsubscribe($subscriber);
          }
        }
      }
    }
    return $data;
  }

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }
}
