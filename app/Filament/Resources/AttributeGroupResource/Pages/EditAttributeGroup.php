<?php
namespace App\Filament\Resources\AttributeGroupResource\Pages;
use App\Filament\Resources\AttributeGroupResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAttributeGroup extends EditRecord
{
  protected static string $resource = AttributeGroupResource::class;

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
