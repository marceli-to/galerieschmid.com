<?php
namespace App\Filament\Resources\ArtworkTechniqueResource\Pages;
use App\Filament\Resources\ArtworkTechniqueResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateArtworkTechnique extends CreateRecord
{
  use CreateRecord\Concerns\Translatable;

  protected static string $resource = ArtworkTechniqueResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\LocaleSwitcher::make(),
    ];
  }

  protected function mutateFormDataBeforeCreate(array $data): array
  {
    $data['display_name'] = $data['description'];
    $data['user_id'] = auth()->user()->id;
    return $data;
  }

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }
}
