<?php
namespace App\Filament\Resources\NewsletterArticleResource\Pages;
use App\Filament\Resources\NewsletterArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateNewsletterArticle extends CreateRecord
{
  protected static string $resource = NewsletterArticleResource::class;
}
