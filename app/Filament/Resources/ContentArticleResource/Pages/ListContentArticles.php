<?php
namespace App\Filament\Resources\ContentArticleResource\Pages;
use App\Filament\Resources\ContentArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContentArticles extends ListRecords
{
  protected static string $resource = ContentArticleResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\CreateAction::make(),
    ];
  }
}
