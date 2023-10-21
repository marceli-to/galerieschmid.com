<?php
namespace App\Filament\Resources\NewsletterListResource\Pages;
use App\Filament\Resources\NewsletterListResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNewsletterLists extends ListRecords
{
  protected static string $resource = NewsletterListResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\CreateAction::make(),
    ];
  }
}
