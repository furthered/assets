<?php

namespace Assets\Console;

use Illuminate\Console\Command;

class AssetsToJsonCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'json:assets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert the assets to json for gulp';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        \Log::info('CDN_URL: ' . env('CDN_URL'));
        $data = json_encode([
            'assets'  => \Config::get('assets'),
            'cdn_url' => rtrim(env('CDN_URL'), '/'),
        ]);

        $dest = __DIR__ . '/../../config/generated.json';

        file_put_contents($dest, $data);
    }
}
