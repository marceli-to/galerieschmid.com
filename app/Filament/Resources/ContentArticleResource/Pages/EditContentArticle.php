<?php
namespace App\Filament\Resources\ContentArticleResource\Pages;
use App\Filament\Resources\ContentArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContentArticle extends EditRecord
{
  protected static string $resource = ContentArticleResource::class;

  protected function getHeaderActions(): array
  {
    return [
      // Actions\DeleteAction::make(),
    ];
  }

  protected function mutateFormDataBeforeSave(array $data): array
  {
    $data['user_id'] = auth()->user()->id;
    return $data;
  }

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }
}
