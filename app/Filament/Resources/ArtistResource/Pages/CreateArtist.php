<?php
namespace App\Filament\Resources\ArtistResource\Pages;
use App\Filament\Resources\ArtistResource;
use Filament\Actions;
use App\Services\Newsletter;
use Filament\Resources\Pages\CreateRecord;

class CreateArtist extends CreateRecord
{
  protected static string $resource = ArtistResource::class;

  protected function mutateFormDataBeforeCreate(array $data): array
  {
    $data['artist_name'] = (isset($data['firstname']) ? $data['firstname'] . ' ' : '') . $data['lastname'];
    $data['user_id'] = auth()->user()->id;

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
          ], TRUE, 6);
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
