<?php

namespace Voice\RedisCacheExtension\App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Voice\RedisCacheExtension\PatternDelete;

class FlushRedis extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "asseco-voice:flush-redis {pattern?}";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = <<<DESC
This command will flush Laravel Redis cache by provided pattern. If no pattern is provided, '*' will be used.
DESC;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (!(Cache::store()->getStore() instanceof PatternDelete)) {
            $this->error("Cache class doesn't implement PatternDelete interface. Are you using Redis as your cache driver?");
            return;
        }

        if (env('APP_ENV') === 'production') {
            if ($this->confirm('App is in production. Do you wish to continue?')) {
                $this->flush();
            }

            return;
        }

        $this->flush();
    }

    protected function flush(): void
    {
        $pattern = $this->argument('pattern') ?: '*';

        $keys = Cache::keys($pattern);

        if (empty($keys)) {
            $this->info("No keys match the following pattern.");
            return;
        }

        $this->info("The following pattern will delete these keys:");
        $this->info(print_r($keys, true));

        if ($this->confirm('Continue?')) {
            Cache::forgetByPattern($pattern);
            $this->info("Deleted.");
        } else {
            $this->info("Aborted.");
        }
    }
}
