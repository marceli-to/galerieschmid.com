<?php
namespace App\Filament\Resources\NewsletterLanguageResource\Pages;
use App\Filament\Resources\NewsletterLanguageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNewsletterLanguages extends ListRecords
{
  protected static string $resource = NewsletterLanguageResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\CreateAction::make(),
    ];
  }
}
