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
      Actions\DeleteAction::make(),
    ];
  }
}
