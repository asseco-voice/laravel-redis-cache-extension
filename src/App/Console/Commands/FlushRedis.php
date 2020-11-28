<?php

namespace Asseco\RedisCacheExtension\App\Console\Commands;

use Asseco\RedisCacheExtension\PatternDelete;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class FlushRedis extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'voice:flush-redis {pattern?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = <<<'DESC'
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

        if (Config::get('app.env') === 'production') {
            if ($this->confirm('App is in production. Do you wish to continue?')) {
                $this->flush();
            }

            return;
        }

        $this->flush();
    }

    protected function flush(): void
    {
        // Adding wildcard at front to ignore redis prefix
        $pattern = $this->argument('pattern') ? ('*' . $this->argument('pattern')) : '*';
        $prefix = Config::get('database.redis.options.prefix') . Cache::getStore()->getPrefix();
        $keys = Cache::keys($pattern);

        if (empty($keys)) {
            $this->info('No keys match the following pattern.');

            return;
        }

        $this->info('The following pattern will delete these keys:');

        $formattedKeys = array_map(function ($key) use ($prefix) {
            return str_replace($prefix, '', $key);
        }, $keys);

        sort($formattedKeys);

        $this->info(print_r($formattedKeys, true));

        if ($this->confirm('Continue?')) {
            Cache::forgetByPattern($pattern);
            $this->info('Deleted.');
        } else {
            $this->info('Aborted.');
        }
    }
}
