<?php
namespace App\Filament\Resources\AttributeResource\Pages;
use App\Filament\Resources\AttributeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAttribute extends EditRecord
{
  protected static string $resource = AttributeResource::class;

  protected function getHeaderActions(): array
  {
    return [
    ];
  }

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
