<?php
namespace App\Filament\Resources;
use App\Filament\Resources\ClientResource\Pages;
use App\Filament\Resources\ClientResource\RelationManagers;
use App\Models\Client;
use App\Enums\Gallery;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TextArea;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClientResource extends Resource
{
  protected static ?string $model = Client::class;

  protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

  protected static ?string $navigationLabel = 'Kunden';

  protected static ?string $modelLabel = 'Kunde';

  protected static ?string $pluralModelLabel = 'Kunden';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Grid::make()->schema([

          Section::make('Data')
          ->schema([

            TextInput::make('salutation')
            ->label('Anrede')
            ->columnSpan('full')
            ->maxLength(100),

            TextInput::make('firstname')
            ->label('Vorname')
            ->columnSpan('full')
            ->maxLength(255),

            TextInput::make('lastname')
            ->label('Name')
            ->columnSpan('full')
            ->required()
            ->maxLength(255),

            TextInput::make('alfa')
            ->label('ALFA')
            ->columnSpan('full')
            ->required()
            ->maxLength(255),
                      
            TextInput::make('email')
            ->label('E-Mail')
            ->columnSpan('full')
            ->email()
            ->prefixIcon('heroicon-m-at-symbol'),

            TextInput::make('mobile')
            ->label('Mobile')
            ->columnSpan('full')
            ->tel()
            ->prefixIcon('heroicon-m-device-phone-mobile'),

            TextInput::make('website')
            ->label('Webseite')
            ->columnSpan('full')
            ->url()
            ->prefixIcon('heroicon-m-globe-alt'),

          ])->columnSpan(7),

          Grid::make()->schema([

            Section::make('Einstellungen')
              ->schema([
                
                Toggle::make('active')
                ->columnSpan(6)
                ->label('Aktiv'),
                
                Toggle::make('newsletter_subscriber')
                ->columnSpan(6)
                ->label('Newsletter?'),

                Select::make('gallery')
                ->label('Galerie')
                ->options(Gallery::class)
                ->columnSpan('full')
                ->selectablePlaceholder(false),

                TextInput::make('language')
                ->label('Sprache')
                ->columnSpan('full')
                ->maxLength(255),

                TextArea::make('letter_salutation')
                ->label('Briefanrede')
                ->columnSpan('full')
                ->rows(3),

                TextInput::make('invitations')
                ->label('Einladungen')
                ->columnSpan('full')
                ->maxLength(255),

                TextArea::make('remarks')
                ->label('Bemerkungen')
                ->columnSpan('full')
                ->rows(3)

              ])->columns(12),

            ])->columnSpan(5)->columns(12),

            Section::make('Künstler')
            ->collapsible()
            ->collapsed()
            ->schema([
              TextArea::make('artists')
              ->label('Liste der Künstler')
              ->columnSpan('full')
              ->rows(3),
            ])->columnSpan(7),

          ])->columns(12)
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->striped()
      ->columns([
        TextColumn::make('firstname')
        ->label('Vorname')
        ->searchable()
        ->sortable(),
        TextColumn::make('lastname')
        ->label('Name')
        ->searchable()
        ->sortable(),
        TextColumn::make('email')
        ->label('E-Mail')
        ->searchable()
        ->sortable(),
        TextColumn::make('primaryAddress.city')
        ->label('Ort')
        ->searchable(),
        TextColumn::make('gallery')
        ->label('Galerie')
        ->badge(),
        IconColumn::make('active')
        ->label('Aktiv')
        ->sortable()
        ->boolean(),
      ])
      ->filters([
        Filter::make('active')
          ->label('Aktiv')
          ->toggle()
          ->query(fn (Builder $query): Builder => $query->where('active', true)),

        SelectFilter::make('gallery')
          ->options([
            'gap' => 'GAP',
            'eule' => 'Eule',
          ]),
      ])
      ->actions([
        ActionGroup::make([
          EditAction::make(),
          DeleteAction::make(),
        ]),
      ])
      ->bulkActions([
        Tables\Actions\BulkActionGroup::make([
          Tables\Actions\DeleteBulkAction::make(),
          // BulkAction::make('exportClientsToCsv')
          // ->action(function ($records, array $data) {
          //   return response()->streamDownload(function () use ($records) {
          //     echo \Pdf::loadHtml(
          //       \Blade::render('pdf.artwork-label', ['records' => $records])
          //     )->stream();
          //   }, 'galerieschmid-kuenstler.pdf');
          // })
          // ->label('Kunden exportieren')
          // ->icon('heroicon-o-document-arrow-down')
          // ->deselectRecordsAfterCompletion(),
        ]),
      ]);
  }
    
  public static function getRelations(): array
  {
    return [
      RelationManagers\AddressRelationManager::class,
      RelationManagers\AdditionalFieldRelationManager::class,
    ];
  }
  
  public static function getPages(): array
  {
    return [
      'index' => Pages\ListClients::route('/'),
      'create' => Pages\CreateClient::route('/create'),
      'edit' => Pages\EditClient::route('/{record}/edit'),
    ];
  }    
}
