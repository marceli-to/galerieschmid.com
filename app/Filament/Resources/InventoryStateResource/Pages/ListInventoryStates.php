<?php
namespace App\Filament\Resources\InventoryStateResource\Pages;
use App\Filament\Resources\InventoryStateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInventoryStates extends ListRecords
{
  protected static string $resource = InventoryStateResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\CreateAction::make(),
    ];
  }
}
