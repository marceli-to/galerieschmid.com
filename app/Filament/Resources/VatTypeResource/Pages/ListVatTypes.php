<?php
namespace App\Filament\Resources\VatTypeResource\Pages;
use App\Filament\Resources\VatTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVatTypes extends ListRecords
{
  use ListRecords\Concerns\Translatable;

  protected static string $resource = VatTypeResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\CreateAction::make(),
    ];
  }
}
