<?php
namespace App\Filament\Resources\NewsletterArticleResource\Pages;
use App\Filament\Resources\NewsletterArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNewsletterArticle extends EditRecord
{
  protected static string $resource = NewsletterArticleResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\DeleteAction::make(),
    ];
  }
}
