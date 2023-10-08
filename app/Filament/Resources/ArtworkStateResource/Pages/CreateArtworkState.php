<?php
namespace App\Filament\Resources\ArtworkStateResource\Pages;
use App\Filament\Resources\ArtworkStateResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateArtworkState extends CreateRecord
{

  protected static string $resource = ArtworkStateResource::class;

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
