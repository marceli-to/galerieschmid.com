<?php
namespace App\Filament\Resources\ClientAddressResource\Pages;
use App\Filament\Resources\ClientAddressResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClientAddresses extends ListRecords
{
  protected static string $resource = ClientAddressResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\CreateAction::make(),
    ];
  }
}
