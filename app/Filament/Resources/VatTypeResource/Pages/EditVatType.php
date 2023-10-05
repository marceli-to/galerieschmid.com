<?php
namespace App\Filament\Resources\VatTypeResource\Pages;
use App\Filament\Resources\VatTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVatType extends EditRecord
{
  use EditRecord\Concerns\Translatable;

  protected static string $resource = VatTypeResource::class;

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
