<?php
namespace App\Filament\Resources\ExhibitionResource\Pages;
use App\Filament\Resources\ExhibitionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExhibition extends EditRecord
{
  protected static string $resource = ExhibitionResource::class;

  protected function mutateFormDataBeforeSave(array $data): array
  {
    $data['user_id'] = auth()->user()->id;
    return $data;
  }

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }
}
