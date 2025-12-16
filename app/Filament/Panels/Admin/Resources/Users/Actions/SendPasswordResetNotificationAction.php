<?php

namespace App\Filament\Panels\Admin\Resources\Users\Actions;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Auth\Notifications\ResetPassword;
use Filament\Facades\Filament;
use Filament\Support\Icons\Heroicon;
use Illuminate\Auth\Events\PasswordResetLinkSent;
use Illuminate\Support\Facades\Password;

class SendPasswordResetNotificationAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->requiresConfirmation()
            ->label('Reset Password')
            ->modalHeading('Send Password Reset Email?')
            ->modalDescription(fn (User $record) => "Send the password reset email to: {$record->name}?")
            ->successNotificationTitle(fn (User $record) => "The email has been sent to: {$record->email}!")
            ->action(function (Action $action, User $record) {
                $status = Password::broker(Filament::getAuthPasswordBroker())
                    ->sendResetLink(['email' => $record->email], function (User $user, string $token): void {
                        $notification = app(ResetPassword::class, ['token' => $token]);
                        /* send the notification across filament panels. - must set it to 'app' because we are on 'admin' */
                        $notification->url = Filament::getPanel('app')->getResetPasswordUrl($token, $user);
                        
                        $user->notify($notification);

                        if (class_exists(PasswordResetLinkSent::class)) {
                            event(new PasswordResetLinkSent($user));
                        }
                    });

                if ($status !== Password::RESET_LINK_SENT) {
                    return $action->failed();
                }

                $action->success();
            });
    }

    public static function getDefaultName(): ?string
    {
        return 'reset_password';
    }
}
