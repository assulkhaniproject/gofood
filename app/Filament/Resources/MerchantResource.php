<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MerchantResource\Pages;
use App\Filament\Resources\MerchantResource\RelationManagers;
use App\Filament\Resources\MerchantResource\RelationManagers\MenusRelationManager;
use App\Models\Merchant;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\LinkAction;
use Filament\Tables\Columns\ImageColumn;
use PhpParser\Node\Stmt\Label;

class MerchantResource extends Resource
{
    protected static ?string $model = Merchant::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'user';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Forms\Components\TextInput::make('name')->label('Nama')->required(),
                    Forms\Components\TextInput::make('phone')->label('No. Telp')->tel()->required(),
                    Forms\Components\Textarea::make('address')->label('Alamat')->required(),
                ])->columnSpan(2),
                Card::make()->schema([
                    FileUpload::make('photo')->label('Foto')->disk('public')->directory('/merchant/photo')
                ])->columnSpan(1)
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nama')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('address')->label('Alamat')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('phone')->label('No. Telp')->searchable()->sortable(),
                ImageColumn::make('photo')->label('Foto')->rounded()->width(50)->height(50)
            ])->prependActions([
                LinkAction::make('delete')
                ->action(fn(Merchant $record) => $record->delete())
                ->requiresConfirmation()
                ->color('danger')
            ])
            ->filters([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            MenusRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMerchants::route('/'),
            'create' => Pages\CreateMerchant::route('/create'),
            'edit' => Pages\EditMerchant::route('/{record}/edit'),
        ];
    }
}
