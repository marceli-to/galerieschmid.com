<?php
namespace App\Filament\Resources\ExhibitionResource\Pages;
use App\Filament\Resources\ExhibitionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateExhibition extends CreateRecord
{
  protected static string $resource = ExhibitionResource::class;
  
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
