<?php
namespace App\Filament\Resources\InventoryStateResource\Pages;
use App\Filament\Resources\InventoryStateResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateInventoryState extends CreateRecord
{
  use CreateRecord\Concerns\Translatable;

  protected static string $resource = InventoryStateResource::class;

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
