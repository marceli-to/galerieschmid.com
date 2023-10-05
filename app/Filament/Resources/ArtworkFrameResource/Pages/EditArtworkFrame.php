<?php
namespace App\Filament\Resources\ArtworkFrameResource\Pages;
use App\Filament\Resources\ArtworkFrameResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditArtworkFrame extends EditRecord
{
  use EditRecord\Concerns\Translatable;

  protected static string $resource = ArtworkFrameResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\LocaleSwitcher::make(),
    ];
  }

  protected function mutateFormDataBeforeSave(array $data): array
  {
    if ($this->activeLocale == 'de')
    {
      $data['display_name'] = $data['description'];
    }
    $data['user_id'] = auth()->user()->id;
    return $data;
  }

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }
}
