<?php
namespace App\Filament\Resources\AttributeResource\Pages;
use App\Filament\Resources\AttributeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAttribute extends CreateRecord
{
  protected static string $resource = AttributeResource::class;

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
