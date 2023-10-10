<?php
namespace App\Filament\Resources\AttributeGroupResource\Pages;

use App\Filament\Resources\AttributeGroupResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAttributeGroup extends CreateRecord
{
  protected static string $resource = AttributeGroupResource::class;

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
