<?php
namespace App\Filament\Resources\InventoryStateResource\Pages;
use App\Filament\Resources\InventoryStateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInventoryState extends EditRecord
{
  protected static string $resource = InventoryStateResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\DeleteAction::make(),
    ];
  }
}
