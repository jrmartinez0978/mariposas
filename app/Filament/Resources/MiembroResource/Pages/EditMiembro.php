<?php

namespace App\Filament\Resources\MiembroResource\Pages;

use App\Filament\Resources\MiembroResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMiembro extends EditRecord
{
    protected static string $resource = MiembroResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
