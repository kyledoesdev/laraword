<?php

namespace App\Filament\Fields;

use Filament\Forms\Components\FileUpload;

class AvatarField extends FileUpload
{
    public function setUp(): void
    {
        parent::setUp();

        $this
            ->disk('public')
            ->directory('avatars')
            ->circleCropper()
            ->image();
    }

    public static function getDefaultName(): ?string
    {
        return 'Avatar';
    }
}