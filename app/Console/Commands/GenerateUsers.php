<?php

namespace App\Console\Commands;

use App\Enums\UserType;
use App\Models\Asesor;
use App\Models\Scopes\AktifScope;
use App\Models\User;
use Illuminate\Console\Command;

class GenerateUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $usernames = User::query()->pluck('email');

            $this->info('Generate Akun Asesor');

            $inactive = Asesor::query()
                ->withoutGlobalScope(AktifScope::class)
                ->where('aktif', false)
                ->pluck('email');

            User::query()
                ->whereIn('email', $inactive)
                ->delete();

            $asesor = Asesor::query()
                ->select('id','nama', 'email')
                ->whereNotIn('email', $usernames)
                ->get();

            $bar = $this->output->createProgressBar(count($asesor));

            $bar->start();

            foreach ($asesor as $item) {
                User::updateOrCreate(
                    [
                        'asesor_id' => $item->id,
                    ],
                    [
                        'email' => $item->email,
                        'name' => $item->nama,
                        'password' => bcrypt('password'),
                        'type' => UserType::ASESOR,
                    ]
                );

                $bar->advance();
            }

            $bar->finish();

            $this->newLine();

            $this->info('Generate Akun Selesai!');

            $this->newLine();

            return true;

        } catch (\Throwable $th) {
            return false;
            report($th->getMessage());
            $this->error('Something went wrong!');
        }
    }
}
