<?php
namespace App\Filament\Resources\VatTypeResource\Pages;
use App\Filament\Resources\VatTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVatType extends EditRecord
{
  protected static string $resource = VatTypeResource::class;

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
