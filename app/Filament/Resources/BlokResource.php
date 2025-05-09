<?php

namespace App\Filament\Resources;

use App\Filament\Pages\TahunTanam;
use App\Filament\Resources\BlokResource\Pages;
use App\Filament\Resources\BlokResource\RelationManagers;
use App\Models\Blok;
use App\Models\TahunTanam as ModelsTahunTanam;
use Carbon\Carbon;
// use Filament\Actions\ViewAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
// use Filament\Forms\Components\Grid;
// use Filament\Forms\Components\Section;
// use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
// use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Notifications\Actions\Action;

class BlokResource extends Resource
{
    protected static ?string $model = Blok::class;

    protected static ?string $modelLabel = 'Semua Blok';

    public static function getNavigationLabel(): string
    {
        return __('Blok');
    }

    protected static ?string $navigationGroup = 'Data Aktual';

    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'Jumlah Data Blok';
    }

    // protected static ?string $navigationIcon = 'images/area-svgrepo-com.svg';

    public static function form(Form $form): Form
    {
        $tahunTanamId = request()->get('tahun_tanam_id');

        $schema = [
            TextInput::make('nama_blok')
                ->required(),
            TextInput::make('luas_lahan')
                ->required(),
            TextInput::make('jumlah_pokok')
                ->required()
        ];

        // Tambahkan field tahun_tanam_id hanya jika tidak ada di parameter
        if (empty($tahunTanamId)) {
            $schema[] = Select::make('tahun_tanam_id')
                ->relationship('tahunTanam', 'tahun_tanam')
                ->required();
        } else {
            // Jika ada parameter, tambahkan sebagai hidden field
            $schema[] = Forms\Components\Hidden::make('tahun_tanam_id')
                ->default($tahunTanamId);
        }

        return $form->schema($schema);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_blok')
                    ->searchable(),
                TextColumn::make('tahunTanam.tahun_tanam')
                    ->label('Tahun Tanam')
                    ->searchable(),
                TextColumn::make('luas_lahan'),
                TextColumn::make('jumlah_pokok'),
            ])
            ->filters([
                SelectFilter::make('tahun_tanam_id')
                    ->label('Tahun Tanam')
                    ->options(ModelsTahunTanam::all()->pluck('tahun_tanam', 'id'))
                    ->searchable()
                    ->multiple()
                    ->preload(),
            ])
            ->actions([
                EditAction::make()
                    ->iconButton(),
                DeleteAction::make()
                    ->iconButton()
                    ->modalHeading('Hapus Blok')
                    ->modalDescription('Apakah Anda yakin ingin menghapus blok ini?')
                    ->modalSubmitActionLabel('Ya, Hapus')
                    ->modalCancelActionLabel('Batalkan')
                    ->successNotification(function (Blok $record) {
                        return Notification::make()
                            ->success()
                            ->title('Blok Dihapus')
                            ->body("Blok {$record->nama_blok} dipindahkan ke trash.")
                            ->persistent()
                            ->actions([
                                Action::make('undo')
                                    ->color('gray')
                                    ->label('Batalkan')
                                    ->dispatch('undoDeleteBlok', ['recordId' => $record->id]),
                            ])
                            ->send();
                    })
            ])
            ->bulkActions([
                // ... bulk actions tetap sama ...
            ]);
    }

    public static function getPages(): array
    {
        // dd(request()->all());
        return [
            'index' => Pages\ListBloks::route('/'),
            'create' => Pages\CreateBlok::route('/create'),
            'edit' => Pages\EditBlok::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->when(request()->has('tahun_tanam_id'), function (Builder $query) {
                $query->where('tahun_tanam_id', [request('tahun_tanam_id')]);
            });
    }
}
