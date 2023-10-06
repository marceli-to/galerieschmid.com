<?php
namespace App\Filament\Resources\ClientAdditionalFieldResource\Pages;
use App\Filament\Resources\ClientAdditionalFieldResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClientAdditionalFields extends ListRecords
{
  protected static string $resource = ClientAdditionalFieldResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\CreateAction::make(),
    ];
  }
}
