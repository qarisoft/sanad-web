<?php

namespace App\Models;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email'
    ];
    public function company(): BelongsToMany
    {
        return $this->belongsToMany(Company::class);
    }

    public function tasks():HasMany
    {
        return $this->hasMany(Task::class);
    }
    public static function getForm():array
    {
        return [
            Section::make('info')
                ->columns(2)
                ->schema([
                TextInput::make('name')
                    ->autofocus()
                    ->maxLength(255),
                TextInput::make('email')
                    ->email()
                    ->maxLength(255),
            ])


        ];
    }
}
