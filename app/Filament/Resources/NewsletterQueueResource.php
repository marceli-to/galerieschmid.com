<?php
namespace App\Filament\Resources;
use App\Filament\Resources\NewsletterQueueResource\Pages;
use App\Filament\Resources\NewsletterQueueResource\RelationManagers;
use App\Models\NewsletterQueue;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NewsletterQueueResource extends Resource
{
  protected static ?string $model = NewsletterQueue::class;

  protected static ?string $navigationIcon = 'heroicon-o-queue-list';

  protected static ?string $navigationGroup = 'Newsletter';

  protected static ?string $navigationLabel = 'Warteschlange';

  protected static ?string $modelLabel = 'Warteschlange';

  protected static ?string $pluralModelLabel = 'Warteschlange';

  protected static ?int $navigationSort = 4;

  public static function getNavigationBadge(): ?string
  {
    return static::getModel()::unprocessed()->count();
  }

  public static function getNavigationBadgeColor(): ?string
  {
    return 'success';
  }

  public static function getEloquentQuery(): Builder
  {
    $res = parent::getEloquentQuery()->where('processed', 0);
    return $res;
  }

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('email')
        ->label('Empfänger')
        ->searchable()
        ->sortable(),
        TextColumn::make('newsletter.title')
        ->label('Newsletter')
        ->searchable()
        ->sortable(),
        TextColumn::make('list.description')
        ->label('Liste')
        ->searchable()
        ->sortable(),
        TextColumn::make('created_at')
        ->label('Erstellt am')
        ->date('d.m.Y H:i:s')
        ->searchable()
        ->sortable(),
      ])
      ->filters([
        SelectFilter::make('batch')
          ->label('Liste')
          ->options(function(){
            $res = NewsletterQueue::with('list')->orderBy('created_at')->get();
            $options = [];
            foreach ($res as $item)
            {
              $options[$item->batch] = $item->list->description . ' - ' . date('d.m.Y H:i:s', strtotime($item->created_at));
            }
            return $options;
          })
      ])
      ->actions([
        DeleteAction::make()
        ->label('Löschen')
        ->modalHeading('Eintrag aus Warteschlange entfernen')
        ->modalDescription('Sind Sie sicher, dass Sie dies tun möchten?'),
      ])
      ->bulkActions([
        Tables\Actions\BulkActionGroup::make([
          Tables\Actions\DeleteBulkAction::make(),
        ]),
      ]);
  }
    
  public static function getRelations(): array
  {
    return [
    ];
  }
  
  public static function getPages(): array
  {
    return [
      'index' => Pages\ListNewsletterQueues::route('/'),
      'create' => Pages\CreateNewsletterQueue::route('/create'),
      'edit' => Pages\EditNewsletterQueue::route('/{record}/edit'),
    ];
  }    
}
