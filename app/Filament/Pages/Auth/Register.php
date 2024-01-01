<?php

namespace App\Filament\Pages\Auth;

use App\Models\Asesi;
use App\Models\KompetensiKeahlian;
use App\Models\Sekolah;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Facades\Filament;
use Filament\Pages\Auth\Register as BaseRegister;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Select;
use Filament\Forms\Get;
use Filament\Http\Responses\Auth\Contracts\RegistrationResponse;
use Filament\Notifications\Notification;
use Illuminate\Support\Collection;

class Register extends BaseRegister
{
    public function register(): ?RegistrationResponse
    {
        try {
            $this->rateLimit(2);
        } catch (TooManyRequestsException $exception) {
            Notification::make()
                ->title(__('filament-panels::pages/auth/register.notifications.throttled.title', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]))
                ->body(array_key_exists('body', __('filament-panels::pages/auth/register.notifications.throttled') ?: []) ? __('filament-panels::pages/auth/register.notifications.throttled.body', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]) : null)
                ->danger()
                ->send();

            return null;
        }

        $data = $this->form->getState();

        $asesi = Asesi::create([
            'nama' => $data['name'],
            'email' => $data['email'],
            'sekolah_id' => $data['sekolah_id'],
            'kompetensi_keahlian_id' => $data['kompetensi_keahlian_id'],
        ]);

        unset($data['sekolah_id']);
        unset($data['kompetensi_keahlian_id']);

        $data['asesi_id'] = $asesi->id;

        $user = $this->getUserModel()::create($data);

        $this->sendEmailVerificationNotification($user);

        Filament::auth()->login($user);

        session()->regenerate();

        return app(RegistrationResponse::class);
    }

    /**
     * @return array<int | string, string | Form>
     */
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getSekolahFormComponent(),
                        $this->getKompetensiKeahlianFormComponent(),
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    protected function getSekolahFormComponent(): Component
    {
        return Select::make('sekolah_id')
            ->label('Asal Sekolah')
            ->options(Sekolah::where('aktif', true)->pluck('nama', 'id'))
            ->required()
            ->searchable()
            ->preload()
            ->reactive();
    }

    protected function getKompetensiKeahlianFormComponent(): Component
    {
        return Select::make('kompetensi_keahlian_id')
            ->label('Kompetensi Keahlian')
            ->options(fn (Get $get): Collection => KompetensiKeahlian::whereHas('sekolah', function ($query) use ($get) {
                $query->where('sekolah_id', $get('sekolah_id'));
            })->pluck('nama', 'id'))
            ->required()
            ->searchable()
            ->preload();
    }
}
