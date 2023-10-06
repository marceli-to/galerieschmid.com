<?php
namespace App\Filament\Resources\InventoryStateResource\Pages;
use App\Filament\Resources\InventoryStateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInventoryStates extends ListRecords
{
  use ListRecords\Concerns\Translatable;

  protected static string $resource = InventoryStateResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\CreateAction::make(),
    ];
  }
}
