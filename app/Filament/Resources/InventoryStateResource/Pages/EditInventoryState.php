<?php
namespace App\Filament\Resources\InventoryStateResource\Pages;
use App\Filament\Resources\InventoryStateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInventoryState extends EditRecord
{
  use EditRecord\Concerns\Translatable;

  protected static string $resource = InventoryStateResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\LocaleSwitcher::make(),
      // Actions\DeleteAction::make(),
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
