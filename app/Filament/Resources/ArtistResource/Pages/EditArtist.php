<?php
namespace App\Filament\Resources\ArtistResource\Pages;
use App\Filament\Resources\ArtistResource;
use Filament\Actions;
use App\Services\Newsletter;
use Filament\Resources\Pages\EditRecord;

class EditArtist extends EditRecord
{
  protected static string $resource = ArtistResource::class;

  protected function mutateFormDataBeforeSave(array $data): array
  {
    $data['user_id'] = auth()->user()->id;
    $data['artist_name'] = (isset($data['firstname']) ? $data['firstname'] . ' ' : '') . $data['lastname'];

    // fix protocol for website
    if (isset($data['website']) && !empty($data['website']))
    {
      if (!preg_match("~^(?:f|ht)tps?://~i", $data['website']))
      {
        $data['website'] = "http://" . $data['website'];
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
