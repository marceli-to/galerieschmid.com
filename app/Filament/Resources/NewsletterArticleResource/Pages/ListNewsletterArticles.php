<?php
namespace App\Filament\Resources\NewsletterArticleResource\Pages;
use App\Filament\Resources\NewsletterArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNewsletterArticles extends ListRecords
{
  protected static string $resource = NewsletterArticleResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\CreateAction::make(),
    ];
  }
}
